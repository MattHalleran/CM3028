<?php
App::uses('AppController', 'Controller');
App::uses('CustomPasswordHasher','CustomAuthentication', 'Controller/Component/Auth');
class StaffController extends AppController {
	var $uses = array('Staff','Security','PasswordHasher');
	var $components = array();
	
    public function index() {
    	$role = $this->Auth->user('courses');
    	$this->layout = 'admin';
		$this->set('role', $role);
    }
	
	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
	        	$this->Session->setFlash(__('Log in successful'));
	            return $this->redirect($this->Auth->redirectUrl());
	        }
			$this->Session->setFlash(__('Invalid username or password, try again'));
	    }
	}
	
	public function logout () {
		return $this->redirect($this->Auth->logout());
	}

	public function beforeFilter() {
	    parent::beforeFilter();
		
		$matric = $this->Auth->user();
		if ( isset($matric['courses']) ) {
			$this->Auth->allow(array('logout', 'index', 'register'));
		} else {
			$this->Auth->deny('logout','index');
			$this->Auth->allow('login');
			if ( $matric ) {
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			}
		}
	}
}
?>