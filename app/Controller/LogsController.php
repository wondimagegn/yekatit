<?php
class LogsController extends AppController
{
	var $name = 'Logs';

	var $menuOptions = array(
		//'parent' => 'dashboard',
		'parent' => 'security',
		'alias' => array(
			'index' => 'View logs',
		)
	);

	public $paginate = array();

	function __init_search()
	{
		if (!empty($this->request->data['Log'])) {
			$this->Session->write('log_search_data', $this->request->data['Log']);
		} else if ($this->Session->check('log_search_data')) {
			$this->request->data['Log'] = $this->Session->read('log_search_data');
		}
	}

	function __init_clear_session_filters()
	{
		if ($this->Session->check('log_search_data')) {
			$this->Session->delete('log_search_data');
		}
	}

	function index()
	{
		$this->__init_search();
		$logs = array();
		$options = array();
		$limit = 50;
		$page = 1;
		$direction = 'desc';
		$sort = 'Log.created';

		if (!empty($this->passedArgs)) {

			if (isset($this->passedArgs['page'])) {
				$page = $this->request->data['Log']['page'] = $this->passedArgs['page'];
			}

			if (isset($this->passedArgs['sort'])) {
				$sort = $this->request->data['Log']['sort'] = $this->passedArgs['sort'];
			}

			if (isset($this->passedArgs['direction'])) {
				$direction = $this->request->data['Log']['direction'] = $this->passedArgs['direction'];
			}
		}

		if (isset($this->request->data['searchLogs'])) {
			unset($this->passedArgs);
			$this->__init_clear_session_filters();
			$this->__init_search();
		}

		if (!empty ($this->request->data)) {

			//debug($this->request->data);

			if (!empty($page) && !isset($this->request->data['searchLogs'])) {
				$this->request->data['Log']['page'] = $page;
			}

			if (!empty($this->request->data['Log']['role_id']) && !empty($this->request->data['Log']['role_id']) && empty($this->request->data['Log']['username'])) {
				$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE role_id = \'' . $this->request->data['Log']['role_id'] . '\')');
			}

			if (!empty($this->request->data['Log']['change'])) {
				$options['conditions'][] = array('Log.change LIKE ' => '%' . $this->request->data['Log']['change'] . '%');
			}

			if (!empty($this->request->data['Log']['key'])) {
				$options['conditions'][] = array('Log.foreign_key LIKE ' => '%' . $this->request->data['Log']['key'] . '%');
			}

			if (!empty($this->request->data['Log']['description'])) {
				$options['conditions'][] = array('Log.description LIKE ' => '%' . $this->request->data['Log']['description'] . '%');
			}

			if ($this->request->data['Log']['deactive'] == 0 && $this->request->data['Log']['active'] == 1) {
				$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE active = 1)');
			}

			if ($this->request->data['Log']['active'] == 0 && $this->request->data['Log']['deactive'] == 1) {
				$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE active = 0)');
			}

			if (!empty($this->request->data['Log']['username'])) {

				$users = explode(',', $this->request->data['Log']['username']);
				$include_users = array();
				$exclude_users = array();

				if (!empty($users)) {
					foreach ($users as $user) {
						if (substr(trim($user), 0, 1) == '-') {
							$exclude_users[] = addslashes(substr(trim($user), 1));
						} else {
							$include_users[] = addslashes(trim($user));
						}
					}
				}

				if (!empty($include_users)) {
					if (count($include_users) == 1) {
						$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username = \'' . $include_users[0] . '\')');
					} else {
						$include_users_s = implode("', '", $include_users);
						$include_users_s = "('" . $include_users_s . "')";
						$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username IN ' . $include_users_s . ')');
					}
				}

				if (!empty($exclude_users)) {
					if (count($exclude_users) == 1) {
						$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username <> \'' . $exclude_users[0] . '\')');
					} else {
						$exclude_users_s = implode("', '", $exclude_users);
						$exclude_users_s = "('" . $exclude_users_s . "')";
						debug($exclude_users_s);
						$options['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username NOT IN ' . $exclude_users_s . ')');
					}
				}
			}

			if (!empty($this->request->data['Log']['ip'])) {

				$ips = explode(',', $this->request->data['Log']['ip']);
				$include_ips = array();
				$exclude_ips = array();

				if (!empty($ips)) {
					foreach ($ips as $ip) {
						if (substr(trim($ip), 0, 1) == '-') {
							$exclude_ips[] = substr(trim($ip), 1);
						} else {
							$include_ips[] = trim($ip);
						}
					}
				}

				if (!empty($include_ips)) {
					if (count($include_ips) == 1) {
						$options['conditions'][] = array('Log.ip' => $include_ips[0]);
					} else {
						$options['conditions'][] = array('Log.ip' => $include_ips);
					}
				}

				if (!empty($exclude_ips)) {
					if (count($exclude_ips) == 1) {
						$options['conditions'][] = array('Log.ip <> ' => $exclude_ips[0]);
					} else {
						$options['conditions'][] = array('Log.ip NOT ' => $exclude_ips);
					}
				}
			}

			if (!empty($this->request->data['Log']['action'])) {

				$actions = explode(',', $this->request->data['Log']['action']);
				$include_actions = array();
				$exclude_actions = array();

				if (!empty($actions)) {
					foreach ($actions as $action) {
						if (substr(trim($action), 0, 1) == '-') {
							$exclude_actions[] = substr(trim($action), 1);
						} else {
							$include_actions[] = trim($action);
						}
					}
				}

				if (!empty($include_actions)) {
					if (count($include_actions) == 1) {
						$options['conditions'][] = array('Log.action' => $include_actions[0]);
					} else {
						$options['conditions'][] = array('Log.action' => $include_actions);
					}
				}

				if (!empty($exclude_actions)) {
					if (count($exclude_actions) == 1) {
						$options['conditions'][] = array('Log.action <> ' => $exclude_actions[0]);
					} else {
						$options['conditions'][] = array('Log.action NOT ' => $exclude_actions);
					}
				}
			}

			if (!empty($this->request->data['Log']['model'])) {

				$models = explode(',', $this->request->data['Log']['model']);
				$include_models = array();
				$exclude_models = array();

				if (!empty($models)) {
					foreach ($models as $model) {
						if (substr(trim($model), 0, 1) == '-') {
							$exclude_models[] = substr(trim($model), 1);
						} else {
							$include_models[] = trim($model);
						}
					}
				}

				if (!empty($include_models)) {
					if (count($include_models) == 1) {
						$options['conditions'][] = array('Log.model' => $include_models[0]);
					} else {
						$options['conditions'][] = array('Log.model' => $include_models);
					}
				}

				if (!empty($exclude_models)) {
					if (count($exclude_models) == 1) {
						$options['conditions'][] = array('Log.model <> ' => $exclude_models[0]);
					} else {
						$options['conditions'][] = array('Log.model NOT ' => $exclude_models);
					}
				}
			}

			$change_date_from = $this->request->data['Log']['change_date_from'];
			$change_date_to = $this->request->data['Log']['change_date_to'];
			
			$options['conditions'][] = array('date(Log.created) >= ' => $change_date_from['year'] . '-' . $change_date_from['month'] . '-' . $change_date_from['day']);
			$options['conditions'][] = array('date(Log.created) <= ' =>  $change_date_to['year'] . '-' . $change_date_to['month'] . '-' . $change_date_to['day']);
			
			if (isset($this->request->data['Log']['limit']) && $this->request->data['Log']['limit'] > 0) {
				$limit = $this->request->data['Log']['limit'];
			}
		}

		//debug($options);

		if (!empty($options['conditions'])) {
			$this->Paginator->settings = array(
				'conditions' => $options['conditions'],
				'contain' => array(
					'User' => array(
						'fields' => array ('id', 'username', 'first_name', 'middle_name', 'last_name', 'role_id'),
						'Role' => array('id', 'name')
					)
				),
				'order' => array($sort => $direction),
				'limit' => (!empty($limit) ? $limit : 50),
				'maxLimit' => 1000,
				'page' => $page,
			);


			try {
				$logs = $this->Paginator->paginate($this->modelClass);
			} catch (NotFoundException $e) {
				if (!empty($this->request->data['Log'])) {
					unset($this->request->data['Log']['page']);
					unset($this->request->data['Log']['sort']);
					unset($this->request->data['Log']['direction']);
				}
				unset($this->passedArgs);
				return $this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				if (!empty($this->request->data['Log'])) {
					unset($this->request->data['Log']['page']);
					unset($this->request->data['Log']['sort']);
					unset($this->request->data['Log']['direction']);
				}
				unset($this->passedArgs);
			}
		}

		if (empty($logs) && !empty($options['conditions'])) {
			$this->Flash->info('No log is found with the given criteria.');
			$turn_off_search = false;
		} else {
			if (empty($logs)) {
				$turn_off_search = false;
			} else {
				$turn_off_search = true;
			}
		}

		$roles = $this->Log->User->Role->find('list', array('conditions' => array('Role.id <> ' => ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)));
		$roles = array('0' => '[ All Roles ]') + $roles;
		$this->set(compact('logs',  'roles', 'limit', 'turn_off_search'));

	}

	public function view_logs()
	{
		if (!empty($this->request->data)) {

			// $this->Model->findUserActions(301, array('fields' => array('id','model'),'model' => 'BookTest');

			$params = array();
			$params['fields'] = array('id', 'model', 'user_id', 'ip', 'foreign_key', 'description', 'action', 'change', 'created');

			if (isset($this->request->data['Log']['username']) && !empty($this->request->data['Log']['username'])) {
				$username = $this->request->data['Dashboard']['username'];
				$params['conditions'][] = "user_id IN (SELECT id FROM users WHERE username like '%$username%' )";
			}

			if (!empty($this->request->data['Log']['action'])) {
				$params['conditions']['action'] = $this->request->data['Log']['action'];
			}

			if (!empty($this->request->data['Log']['model'])) {
				$params['conditions']['model'] = $this->request->data['Log']['model'];
			}

			if (!empty($this->request->data['Log']['change_date_from'])) {
				$change_date_from = $this->request->data['Log']['change_date_from'];
				$params['conditions']['created >='] = $change_date_from['year'] . '-' . $change_date_from['month'] . '-' . $change_date_from['day'];
			}

			if (!empty($this->request->data['Log']['change_date_to'])) {
				$change_date_to = $this->request->data['Log']['change_date_to'];
				$params['conditions']['created <='] = $change_date_to['year'] . '-' . $change_date_to['month'] . '-' . $change_date_to['day'] . ' ';
			}

			//debug($params);
			//debug($this->request->data);

			if (!empty($this->request->data['Log']['limit'])) {
				$params['limit'] = $this->request->data['Log']['limit'];
			} else {
				$params['limit'] = 5;
			}

			$logs = $this->Log->User->getUserLogDetail($this->Auth->user('id'), $params);
		}

		$this->set(compact('roles', 'logs'));
	}

}
