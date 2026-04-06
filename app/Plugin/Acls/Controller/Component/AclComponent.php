<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller.Component
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Component', 'Controller');
App::uses('AclInterface', 'Controller/Component/Acl');

/**
 * Access Control List factory class.
 *
 * Uses a strategy pattern to allow custom ACL implementations to be used with the same component interface.
 * You can define by changing `Configure::write('Acl.classname', 'DbAcl');` in your core.php. The adapter
 * you specify must implement `AclInterface`
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/access-control-lists.html
 */
class AclComponent extends Component {

/**
 * Instance of an ACL class
 *
 * @var AclInterface
 */
	protected $_Instance = null;

/**
 * Aro object.
 *
 * @var string
 */
	public $Aro;

/**
 * Aco object
 *
 * @var string
 */
	public $Aco;

/**
 * Constructor. Will return an instance of the correct ACL class as defined in `Configure::read('Acl.classname')`
 *
 * @param ComponentCollection $collection Collection instance.
 * @param array $settings Settings list.
 * @throws CakeException when Acl.classname could not be loaded.
 */
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
		$name = Configure::read('Acl.classname');
		if (!class_exists($name)) {
			list($plugin, $name) = pluginSplit($name, true);
			App::uses($name, $plugin . 'Controller/Component/Acl');
			if (!class_exists($name)) {
				throw new CakeException(__d('cake_dev', 'Could not find %s.', $name));
			}
		}
		$this->adapter($name);
	}

/**
 * Sets or gets the Adapter object currently in the AclComponent.
 *
 * `$this->Acl->adapter();` will get the current adapter class while
 * `$this->Acl->adapter($obj);` will set the adapter class
 *
 * Will call the initialize method on the adapter if setting a new one.
 *
 * @param AclInterface|string $adapter Instance of AclInterface or a string name of the class to use. (optional)
 * @return AclInterface|void either null, or the adapter implementation.
 * @throws CakeException when the given class is not an instance of AclInterface
 */
	public function adapter($adapter = null) {
		if ($adapter) {
			if (is_string($adapter)) {
				$adapter = new $adapter();
			}
			if (!$adapter instanceof AclInterface) {
				throw new CakeException(__d('cake_dev', 'AclComponent adapters must implement AclInterface'));
			}
			$this->_Instance = $adapter;
			$this->_Instance->initialize($this);
			return;
		}
		return $this->_Instance;
	}

/**
 * Pass-thru function for ACL check instance. Check methods
 * are used to check whether or not an ARO can access an ACO
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 */
	public function check($aro, $aco, $action = "*") {
		// return $this->_Instance->check($aro, $aco, $action);

                if ($aro == null || $aco == null) {
			return false;
		}

		if(
			(strcasecmp($aco, 'controllers/Dashboard/index') == 0) ||
			((
			(strcasecmp($aco, 'controllers/Users/index') == 0) ||
			((strcasecmp($aco, 'controllers/Users/department_create_user_account') == 0) &&
			 //(Configure::read('User.role_id') == ROLE_DEPARTMENT)) ||
			 ($aro['User']['role_id'] == ROLE_DEPARTMENT)) ||
			((strcasecmp($aco, 'controllers/Users/add') == 0) &&
			 //(Configure::read('User.role_id') != ROLE_DEPARTMENT)) ||
			 ($aro['User']['role_id'] != ROLE_DEPARTMENT)) ||
			((strcasecmp($aco, 'controllers/Users/assign') == 0) &&
			 //(Configure::read('User.role_id') == ROLE_REGISTRAR)) ||
			 ($aro['User']['role_id'] == ROLE_REGISTRAR)) ||
			(strcasecmp($aco, 'controllers/Securitysettings/permission_management') == 0) ||
			(strcasecmp($aco, 'controllers/Securitysettings/index') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Permissions/add') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Permissions/delete') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Permissions/index') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Permissions/edit') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Acos/index') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Acls/index') == 0) ||
			(strcasecmp($aco, 'controllers/Users/build_user_menu') == 0) ||
			(strcasecmp($aco, 'controllers/Acls/Acos/add') == 0 && Configure::read("Developer")) ||
			(strcasecmp($aco, 'controllers/Acls/Acos/edit') == 0 && Configure::read("Developer")) ||
			(strcasecmp($aco, 'controllers/Acls/Acos/delete') == 0 && Configure::read("Developer")) ||
			(strcasecmp($aco, 'controllers/Acls/Acos/rebuild') == 0 && Configure::read("Developer"))
			)
			//&& (Configure::read('User.role_id') == ROLE_SYSADMIN || Configure::read('User.is_admin') == 1) && Configure::read('User.active') == 1)) {
			&& ($aro['User']['role_id'] == ROLE_SYSADMIN || $aro['User']['is_admin'] == 1) && $aro['User']['active'] == 1)) {
			return true;
		}
		else {
		//debug($aco);
		//exit();
		}
		//The following code is included to automatically give privilege for the specified actions on smis.php if any of the specified controller/action is granted to the user. It is mainly useful to give privilege for false controllers if any of the sub menu privilege is enabled
		$equivalentACL = Configure::read('ACL.equivalentACL');
		//debug($equivalentACL);
		//debug($aco);
		if(isset($equivalentACL) && !empty($equivalentACL) && is_array($equivalentACL)) {
			foreach($equivalentACL as $parent => $child_acls) {
				if(strcasecmp('controllers'.DS.$parent, $aco) == 0) {
					foreach($child_acls as $child_acl) {
						//Check if all action is to be considered
						$checking = explode(DS, $child_acl);
						if($checking[1] == '*') {
							$controller_id = $this->Aco->field('id', 
								array(
									'Aco.alias' => $checking[0]
								)
							);
							$actions = $this->Aco->find('list', 
								array(
									'conditions' =>
									array(
										'Aco.parent_id' => $controller_id
									),
									'fields' =>
									array(
										'Aco.id',
										'Aco.alias',
									)
								)
							);
							foreach($actions as $action_value) {
								if(strcasecmp('controllers'.DS.$parent, 'controllers'.DS.$checking[0].DS.$action_value) != 0 &&
									$this->check($aro, 'controllers'.DS.$checking[0].DS.$action_value) == true) {
									return true;
								}
							}
						}
						else {
							if($this->check($aro, 'controllers'.DS.$child_acl) == true) {
								return true;
							}
						}
					}
				}
			}
		}
		//END: Equivalent ACL checking
		
		$permKeys = $this->_getAcoKeys($this->Aro->Permission->schema());
		$aroPath = $this->Aro->node($aro);
		$acoPath = $this->Aco->node($aco);
		if (empty($aroPath) || empty($acoPath)) {
			trigger_error(__("DbAcl::check() - Failed ARO/ACO node lookup in permissions check.  Node references:\nAro: ") . print_r($aro) . "\nAco: " . print_r($aco, true), E_USER_WARNING);
			return false;
		}

		if ($acoPath == null || $acoPath == array()) {
			trigger_error(__("DbAcl::check() - Failed ACO node lookup in permissions check.  Node references:\nAro: ") . print_r($aro) . "\nAco: " . print_r($aco, true), E_USER_WARNING);
			return false;
		}
		
		//Remove default Department and College privilege unless the user is admin.
		//Non admins need to get explicit user level privilege for access
		//if(Configure::read('User.is_admin') != 1) {
		if($aro['User']['is_admin'] != 1) {
			$admin_detail = ClassRegistry::init('User')->find('first',
				array(
					'conditions' =>
					array(
						'User.id' => $aro['User']['id']//Configure::read('User.user')
					),
					'contain' => 
					array(
						'Staff'
					)
				)
			);
			if($admin_detail['User']['role_id'] == ROLE_DEPARTMENT || $admin_detail['User']['role_id'] == ROLE_COLLEGE || $admin_detail['User']['role_id'] == ROLE_ACCOMODATION || $admin_detail['User']['role_id'] == ROLE_MEAL || $admin_detail['User']['role_id'] == ROLE_HEALTH || $admin_detail['User']['role_id'] == ROLE_REGISTRAR) {
				foreach($aroPath as $ap_key => $ap_value) {
					if(strcasecmp($ap_value['Aro']['model'], 'Role') == 0) {
						unset($aroPath[$ap_key]);
					}
				}
			}
		}
		//End of removal Role
		////////////////////////////////// Auto privilege to index /////////////////////////
		if(strcasecmp($acoPath[0]['Aco']['alias'], 'index') == 0) {
			$children_aco = $this->Aco->find('list',
				array(
					'conditions' =>
					array(
						'Aco.parent_id' => $acoPath[0]['Aco']['parent_id']
					),
					'fields' => array('Aco.id')
				)
			);
			//debug($children_aco);
			$aro_keys = array();
			$aco_keys = array();
			foreach($children_aco as $aco_id_c) {
				$aco_keys[] = $aco_id_c;
			}
			foreach($aroPath as $arp) {
				$aro_keys[] = $arp['Aro']['id'];
			}
			$permAlias = $this->Aro->Permission->alias;
			$perms = $this->Aro->Permission->find('all', array(
				'conditions' => array(
					"{$permAlias}.aro_id" => $aro_keys,
					"{$permAlias}.aco_id" => $aco_keys,
					"{$permAlias}._create" => 1,
					"{$permAlias}._read" => 1,
					"{$permAlias}._update" => 1,
					"{$permAlias}._delete" => 1,
				),
				'order' => array($this->Aco->alias . '.lft' => 'desc'),
				'recursive' => 0
			));
			if(!empty($perms)) {
				return true;
			}
		}
		////////////////////////////////// END: Auto privilege to index ////////////////////
		
		//unset($aroPath[1]);
		//debug($aroPath);//exit();
		$aroNode = $aroPath[0];
		$acoNode = $acoPath[0];
		
		if ($action != '*' && !in_array('_' . $action, $permKeys)) {
			trigger_error(sprintf(__("ACO permissions key %s does not exist in DbAcl::check()"), $action), E_USER_NOTICE);
			return false;
		}

		$inherited = array();
		$acoIDs = Set::extract($acoPath, '{n}.' . $this->Aco->alias . '.id');

		$count = count($aroPath);
		for ($i = 0 ; $i < $count; $i++) {
			$permAlias = $this->Aro->Permission->alias;

			$perms = $this->Aro->Permission->find('all', array(
				'conditions' => array(
					"{$permAlias}.aro_id" => $aroPath[$i][$this->Aro->alias]['id'],
					"{$permAlias}.aco_id" => $acoIDs
				),
				'order' => array($this->Aco->alias . '.lft' => 'desc'),
				'recursive' => 0
			));
			if (empty($perms)) {
				continue;
			} else {
				$perms = Set::extract($perms, '{n}.' . $this->Aro->Permission->alias);
				foreach ($perms as $perm) {
					if ($action == '*') {

						foreach ($permKeys as $key) {
							if (!empty($perm)) {
								if ($perm[$key] == -1) {
									return false;
								} elseif ($perm[$key] == 1) {
									$inherited[$key] = 1;
								}
							}
						}

						if (count($inherited) === count($permKeys)) {
							return true;
						}
					} else {
						switch ($perm['_' . $action]) {
							case -1:
								return false;
							case 0:
								continue;
							break;
							case 1:
								return true;
							break;
						}
					}
				}
			}
		}
		return false;
	}

/**
 * Pass-thru function for ACL allow instance. Allow methods
 * are used to grant an ARO access to an ACO.
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 */
	public function allow($aro, $aco, $action = "*") {
		return $this->_Instance->allow($aro, $aco, $action);
	}

/**
 * Pass-thru function for ACL deny instance. Deny methods
 * are used to remove permission from an ARO to access an ACO.
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 */
	public function deny($aro, $aco, $action = "*") {
		return $this->_Instance->deny($aro, $aco, $action);
	}

/**
 * Pass-thru function for ACL inherit instance. Inherit methods
 * modify the permission for an ARO to be that of its parent object.
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 */
	public function inherit($aro, $aco, $action = "*") {
		return $this->_Instance->inherit($aro, $aco, $action);
	}

/**
 * Pass-thru function for ACL grant instance. An alias for AclComponent::allow()
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 * @deprecated 3.0.0 Will be removed in 3.0.
 */
	public function grant($aro, $aco, $action = "*") {
		trigger_error(__d('cake_dev', '%s is deprecated, use %s instead', 'AclComponent::grant()', 'allow()'), E_USER_WARNING);
		return $this->_Instance->allow($aro, $aco, $action);
	}

/**
 * Pass-thru function for ACL grant instance. An alias for AclComponent::deny()
 *
 * @param array|string|Model $aro ARO The requesting object identifier. See `AclNode::node()` for possible formats
 * @param array|string|Model $aco ACO The controlled object identifier. See `AclNode::node()` for possible formats
 * @param string $action Action (defaults to *)
 * @return bool Success
 * @deprecated 3.0.0 Will be removed in 3.0.
 */
	public function revoke($aro, $aco, $action = "*") {
		trigger_error(__d('cake_dev', '%s is deprecated, use %s instead', 'AclComponent::revoke()', 'deny()'), E_USER_WARNING);
		return $this->_Instance->deny($aro, $aco, $action);
	}

}
