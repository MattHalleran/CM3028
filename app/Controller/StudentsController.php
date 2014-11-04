<?php
App::uses('AppController', 'Controller');
App::uses('CustomPasswordHasher','CustomAuthentication', 'Controller/Component/Auth');

class StudentsController extends AppController {
	var $uses = array('Student','Security');
	var $components = array();
	
    public function index() {
        /* hash password for testing purposes */
        /*
        $salt = $this->Student->generateSalt();
        $this->set('pwd', md5("lollol".$salt));
        $this->set('salt', $salt);
		*/
		/* --- */
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
		
	    if ( $this->Auth->user('matric') !== null ) {
	    	$this->Auth->allow('index', 'logout');
	    } else {
	    	$this->Auth->allow('login');
			if ( $this->Auth->user('staffID') ) {
				$this->redirect(array('controller' => 'Staff' , 'action' => 'index'));
			}
			
	    }
	}
}
?>