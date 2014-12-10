<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class CustomAuthenticate extends BaseAuthenticate {
	
	protected $_passwordHasher;
	protected $usrModel;
	
    public function authenticate(CakeRequest $request, CakeResponse $response) {
    	$models = array('Staff', 'Student');
		$fields = array('staffID', 'matric');
		for ( $i = 0 ; $i < 2 ; $i++ ) {
			$this->settings['fields']['username'] = $fields[$i];
			$this->usrModel = $models[$i];
			if ( $usr = $this->_findUser($request->data['User']['username'], $request->data['User']['password']) ) {
				return $usr;
			}
		}
    }
	
	protected function _findUser($username, $password = null) {
		$userModel = $this->usrModel;//$this->settings['userModel'];
		list(, $model) = pluginSplit($userModel);
		$fields = $this->settings['fields'];

		if (is_array($username)) {
			$conditions = $username;
		} else {
			$conditions = array(
				$model . '.' . $fields['username'] => $username
			);
		}

		if (!empty($this->settings['scope'])) {
			$conditions = array_merge($conditions, $this->settings['scope']);
		}

		$result = ClassRegistry::init($userModel)->find('first', array(
			'conditions' => $conditions,
			'recursive' => $this->settings['recursive'],
			'contain' => $this->settings['contain'],
		));
		if (empty($result[$model])) {
			$this->passwordHasher()->hash($password);
			return false;
		}

		$user = $result[$model];
		if ($password !== null) {
			if (!$this->passwordHasher()->check($password, $user[$fields['password']])) {
				return false;
				
			}
			unset($user[$fields['password']]);
		}

		unset($result[$model]);
		return array_merge($user, $result);
	}

	public function passwordHasher() {
		if ($this->_passwordHasher) {
			return $this->_passwordHasher;
		}

		$config = array();
		if (is_string($this->settings['passwordHasher'])) {
			$class = $this->settings['passwordHasher'];
		} else {
			$class = $this->settings['passwordHasher']['className'];
			$config = $this->settings['passwordHasher'];
			unset($config['className']);
		}
		list($plugin, $class) = pluginSplit($class, true);
		$className = $class . 'PasswordHasher';
		App::uses($className, $plugin . 'Controller/Component/Auth');
		if (!class_exists($className)) {
			throw new CakeException(__d('cake_dev', 'Password hasher class "%s" was not found.', $class));
		}
		if (!is_subclass_of($className, 'AbstractPasswordHasher')) {
			throw new CakeException(__d('cake_dev', 'Password hasher must extend AbstractPasswordHasher class.'));
		}
		$this->_passwordHasher = new $className($config);
		return $this->_passwordHasher;
	}
}
?>