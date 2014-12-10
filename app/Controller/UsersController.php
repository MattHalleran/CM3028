<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class UsersController extends AppController {
	var $uses = array('Student','Staff','Security');
	var $components = array();
	
    public function index() {
        
    }
	
	public function login() {
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	$this->Session->setFlash(__('Log in successful'),'flash_good');
				if ( $this->Auth->user('staffID') ) {
					return $this->redirect(array('controller' => 'Staffs' , 'action'=> 'index'));
				} else {
					return $this->redirect(array('controller' => 'Students' , 'action'=> 'index'));
				}
	            return $this->redirect(array('controller' => 'Users' , 'action'=> 'login'));
	        }
	        $this->Session->setFlash(__('Invalid username or password, try again'),'flash_bad');
	    }
	}
	
	
	
	public function logout () {
		return $this->redirect($this->Auth->logout());
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
		if ($this->request->action == 'login' && $this->Auth->user()) {
			if ( $this->Auth->user('matric') ) {
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			} elseif ( $this->Auth->user('staffID') ) {
				$this->redirect(array('controller' => 'Staffs' , 'action' => 'index'));
			}
		}
	    if ( $this->Auth->user('matric') != null ) {
	    	$this->Auth->allow('index', 'logout');
	    } elseif ( $this->Auth->user('staffID') ) {
			$this->Auth->allow('logout');
	    }
		//debug($this->Auth->user());
	}
}
?>