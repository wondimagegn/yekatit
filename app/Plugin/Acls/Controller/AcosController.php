<?php
/**
 * ACL Management Plugin
 *
 * @copyright     Copyright 2010, Joseph B Crawford II
 * @link          http://www.jbcrawford.net
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class AcosController extends AppController {
    var $name = 'Acos';
    var $components = array('Acls.AcoBuilder');
    var $uses = array('Permission','Aco');
    var $root_id;
   
    function beforeFilter() {
        parent::beforeFilter();
	//debug($this->Auth->actionPath);
       // $this->root_id = $this->Aco->field('id', array('alias' => substr($this->Auth->actionPath, 0, -1)));
       $this->root_id = $this->Aco->field('id', array('alias' => substr('controllers/', 0, -1)));
        $this->Aco->virtualFields['depth'] = 'SELECT COUNT(*) FROM acos WHERE acos.lft < Aco.lft AND acos.rght > Aco.rght';
        $this->Aco->validate = array(
            'alias' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Alias is required',
'on' => 'create'
            )
        );
		
		// $this->Auth->allow('*');
    }
    
    function validateAco($data) {
        if (empty($data['Model']['alias'])) {
            $errors['Acl']['alias'] = 'Alias is required';
        }
        if (empty($errors)) {
            return true;
        } else {
            $this->set(compact('errors'));
            return false;
        }
    }
    
   function index($parent_id = null) {
		$admin_detail = ClassRegistry::init('User')->find('first',
			array(
				'conditions' =>
				array(
					'User.id' => Configure::read('User.user')
				),
				'contain' => 
				array(
					'Staff'
				)
			)
		);
        if (empty($parent_id)) {
            $parent_id = $this->root_id;
        } else {
            $this->Aco->actsAs[] = 'Tree';
            $path = $this->_getAcoPathList($parent_id);
          
        }
	// $parent_id = 1827;
	// echo ($this->Auth->actionPath);
        $actionpath = substr($this->Auth->actionPath, 0, -1);
        $this->Aco->virtualFields['num_permissions'] = 'SELECT COUNT(*) FROM aros_acos x WHERE x.aco_id = Aco.id';
        //$this->Aco->virtualFields['num_permitted_actions_controlloer'] = 0;
        $this->Aco->virtualFields['num_children'] = 'CAST((Aco.rght - Aco.lft -1) / 2 AS UNSIGNED)';
        /*$this->Aco->find('all', 
        	array(
        		'conditions' =>
        		array(
        			'Aco.parent_id' => 90
        		)
        	)
        );*/

			$options = 
				array(
					//'order' => 'lft',
					'order' => 'order ASC',  
					'conditions' => 
					array(
						'parent_id' => $parent_id
					),
					'recursive' => -1
				);
			
			//The following 3 lins of code replaced by the multi role administration checking, below
			/*if($parent_id > 1) {
				$options['conditions']['admin'] = Configure::read('User.role_id');
			}*/
			$acos = $this->Aco->find('all', $options);
			if($parent_id > 1) {
				//debug($acos);
				foreach($acos as $k => $v) {
					$admin_ids = explode(',', $v['Aco']['admin']);
					if(!in_array(Configure::read('User.role_id'), $admin_ids)) {
						unset($acos[$k]);
					}
				}
			}
       if($parent_id == 1) {
				foreach($acos as $aco_k => $aco_v) {
					$child_acos = $this->Aco->find('all', 
						array(
							'conditions' => 
							array(
								'parent_id' => $aco_v['Aco']['id'],
								//'admin' => Configure::read('User.role_id')
							),
							'order' => 'order ASC',
							'recursive' => -1
						)
					);
					
					$child_aco_count = 0;
					foreach($child_acos as $child_aco_key => $child_aco) {
						$admin_ids = explode(',', $child_aco['Aco']['admin']);
						if(in_array(Configure::read('User.role_id'), $admin_ids)) {
							$child_aco_count++;
						}
					}
					
					if($child_aco_count <= 0) {
						unset($acos[$aco_k]);
					}
					else {
						$acos[$aco_k]['Aco']['num_children'] = $child_aco_count;
						$actions_c = $this->Aco->find('list',
							array(
								'conditions' =>
								array(
									'Aco.parent_id' => $aco_v['Aco']['id']
								),
								'fields' => 
								array(
									'Aco.admin'
								)
							)
						);
						$actions_admins = array_count_values($actions_c);
						$actions_admin = array_keys($actions_admins);
						$actions_admin = $actions_admin[0];
						if(count($actions_admins) > 1 || $actions_admin != $admin_detail['User']['role_id']) {
							$acos[$aco_k]['Aco']['remove_permission'] = true;
						}
						else {
							$acos[$aco_k]['Aco']['remove_permission'] = false;
						}
					}
				}
			}
       //allow main account holder to manage their own users,by allowing to access only their
       // acls allowed initialy.
       /*if(!Configure::read("Developer")){
            foreach ($acos as $k=> &$av) {
                    foreach ($av['Aro'] as $avk=>$avv) {
                        if ($this->role_id != $avv['Permission']['aro_id']) {
                            unset($acos[$k]);
                        }
                    }
             }
        }*/
            foreach($acos as &$v){
                  if(!isset($v['Aco']['num_children'])) {
                  	$v['Aco']['num_children'] = 0;
                  }
                  $anotheracos=$this->Aco->find('all', array('order' => 'lft', 'conditions' => array('parent_id' => $v['Aco']['id'])));
                  $counter=count($anotheracos);
                  $j=0;
                  $conditions=null;
                  foreach($anotheracos as $k){
                        if($j!=$counter-1){
                            $conditions.='aco_id='.$k['Aco']['id'].' OR ';
                        } else {
                          $conditions.='aco_id='.$k['Aco']['id'];
                        }
                        $j++;
                 }
                // debug($conditions);
                 if($conditions!=null){
                     if($this->Session->read('role_id')){
                        $role_id=$this->Session->read('role_id');
                        //debug($role_id);
                     } else {
                        $role_id=1;
                     }
                     //debug($conditions);
                     $user_aro_id = $this->Aco->Aro->field('id',array('foreign_key'=>$this->Session->read('user_id')));
                     $numberpermissioncontroller=$this->Aco->query('
                     SELECT COUNT(*) as cont FROM aros_acos  WHERE (aro_id='.$role_id.' OR aro_id='.$user_aro_id.') and ( '.$conditions.' ) AND (_create>0 OR _read>0 OR _update>0 OR _delete>0)
                     ');
                     $v['Aco']['num_permitted_actions_controlloer']=$numberpermissioncontroller[0][0]['cont'];
                 }
                 else {
										$permissions = $this->Permission->find('all', array('conditions' => array('aco_id' => $v['Aco']['id'])));
										foreach($permissions as $key => $i) {
												$path2 = $this->_getAcoPathList($i['Permission']['aco_id']);
												$permissions[$key]['Permission']['path'] = implode('/', $path2);
										}
										if($admin_detail['User']['role_id'] == ROLE_COLLEGE || $admin_detail['User']['role_id'] == ROLE_DEPARTMENT) {
											foreach($permissions as $p_key => $permission) {
												if(strcasecmp($permission['Aro']['model'], 'Role') != 0) {
										 		$staff = ClassRegistry::init('Staff')->find('first',
										 			array(
										 				'conditions' =>
										 				array(
										 					'Staff.user_id' => $permission['Aro']['foreign_key']
										 				),
										 				'recursive' => -1
										 			)
										 		);
										 		if(($admin_detail['User']['role_id'] == ROLE_DEPARTMENT && $staff['Staff']['department_id'] != $admin_detail['Staff'][0]['department_id']) ||
										 			($admin_detail['User']['role_id'] == ROLE_COLLEGE && $staff['Staff']['college_id'] != $admin_detail['Staff'][0]['college_id'])
										 		) {
										 			unset($permissions[$p_key]);
										 		}
												}
											}
										}
									$v['Aco']['num_permitted_actions_controlloer']=count($permissions);
                  }
            }
          
          //Excluding controllers and actions from ACL management
          $excludedACLs = Configure::read('ACL.excludedACL');
          foreach($excludedACLs as $excludedACL) {
          	$c_a = explode(DS, $excludedACL);
          	foreach($acos as $aco_key => $aco) {
          		if(count($c_a) > 1 && $c_a[0] == '*' && strcasecmp($c_a[1], $aco['Aco']['alias']) == 0) {
          			unset($acos[$aco_key]);
          		}
          		else if($aco['Aco']['parent_id'] == 1 && count($c_a) == 1 && 
          			strcasecmp($excludedACL, $aco['Aco']['alias']) == 0) {
          			unset($acos[$aco_key]);
          		}
          		else if($aco['Aco']['parent_id'] != 1 && count($c_a) > 1) {
          			$parent_aco = $this->Aco->find('first', 
          				array(
          					'conditions' =>
          					array(
          						'Aco.id' => $aco['Aco']['parent_id']
          					),
          					'recursive' => -1
          				)
          			);
          			if(!empty($parent_aco) && 
          				strcasecmp($parent_aco['Aco']['alias'].DS.$aco['Aco']['alias'], $excludedACL) == 0) {
          				unset($acos[$aco_key]);
          			}
          		}
          	}
          }
          //END of excluding

        $aco = $this->Aco->find('first', 
		     	array(
		     		'conditions' => 
		     		array(
		     			'Aco.id' => $parent_id
		     		),
		     		'recursive' => -1
		     	)
        	);
        $this->set(compact('acos', 'aco', 'path', 'actionpath', 'parent_id'));
    }
    /*
    function add($parent_id = null) {
        if (!empty($this->request->data)) {
            if (empty($this->request->data['Aco']['parent_id'])) {
                $this->request->data['Aco']['parent_id'] = $this->root_id;
            }
            if ($this->Aco->save($this->request->data)) {
                $this->Session->setFlash('ACO Created');
                $this->redirect(array('action' => 'index', $this->request->data['Aco']['parent_id']));
            }
        } else {
            $this->request->data['Aco']['parent_id'] = $parent_id;
        }
        $parents = $this->_getParenstsList();
        $this->set(compact('parents'));
    }
*/
    
   

  function edit($id = null) {
        if (!empty($this->request->data)) {
            if (empty($this->request->data['Aco']['parent_id'])) {
                $this->request->data['Aco']['parent_id'] = $this->root_id;
            }
	// debug($this->request->data['Aco']);
	    if (!empty($this->request->data['Aco']['admin'])) {
            $this->request->data['Aco']['admin'] = implode(',', 
$this->request->data['Aco']['admin']);
	    } 
            if ($this->Aco->save($this->request->data)) {
                $this->Session->setFlash('<span></span>'.__('ACO Updated'),'default',array('class'=>'success-box success-message'));
                $this->redirect(array('action' => 'index', $this->request->data['Aco']['parent_id']));
            }
            else {
            	//debug($this->Aco->invalidFields());
            	$this->Session->setFlash('<span></span>'.__('Unable to update ACO. Please try again.'), 'default',array('class'=>'error-message error-box'));
            }
            $aco = $this->Aco->findById($this->request->data['Aco']['id']);
            $parent_aco = $this->Aco->find('first',
            	array(
            		'conditions' =>
            		array(
            			'Aco.id' => $aco['Aco']['parent_id']
            		),
            		'recursive' => -1
            	)
            );
            $aco['parent_aco'] = $parent_aco['Aco'];
        } else {
            $aco = $this->Aco->findById($id);
            $parent_aco = $this->Aco->find('first',
            	array(
            		'conditions' =>
            		array(
            			'Aco.id' => $aco['Aco']['parent_id']
            		),
            		'recursive' => -1
            	)
            );
            $aco['parent_aco'] = $parent_aco['Aco'];
            if (empty($aco)) {
               // $this->Session->setFlash('Invalid ACO ID');
                $this->Session->setFlash('<span></span>'.__('Invalid ACO ID'),
				            'default',array('class'=>'error-box error-message'));
                $this->redirect('add');
            } else {
                $this->request->data = $aco;
                $this->request->data['Aco']['admin'] = explode(',', $this->request->data['Aco']['admin']);
            }
        }
        $parents = $this->_getParenstsList();
        $roles = ClassRegistry::init('Role')->find('list');
        //$roles = array('0' => '--- None ---') + $roles;
        $this->set(compact('parents', 'aco', 'roles'));
    }
    
    
    function delete() {
        $delete_count = 0;
        if (!empty($this->request->data['Aco']['delete'])) {
            foreach($this->request->data['Aco']['delete'] as $id => $delete) {
                if ($delete == 1) {
                    if ($this->Aco->delete($id)) {
                        $delete_count++;
                    }
                }
            }
        }
        $this->Session->setFlash('<span></span>'.__($delete_count . ' ACO' . (($delete_count == 1) ? ' was' : 's were') . ' deleted'),
'default', array('class' => 'success-message success-box'));
        $this->redirect(array('action' => 'index', $this->request->data['Aco']['parent_id']));



    }
    
    function rebuild() {
        if (!empty($this->request->data)) {
            $this->Session->setFlash(__('ACOs were rebuilt'),'default', array('class' => 'success-message success-box'));
            $this->AcoBuilder->build_acl();
            $this->redirect('index');
        }
    }
    
    function _getParenstsList() {
        $acos = $this->Aco->find('all', array('order' => 'lft', 'conditions' => array('lft >' => 1)));
        foreach($acos as $key => $i) {
            $parents[$i['Aco']['id']] = str_repeat('-- ', $i['Aco']['depth']) . $i['Aco']['alias'];
        }
        return $parents;
    }
    
    function _getAcoPathList($aco_id) {
        $_path = $this->Aco->getPath($aco_id);
        foreach($_path as $i) {
            $path[$i['Aco']['id']] = $i['Aco']['alias'];
        }
        return $path;
    }
}
?>
