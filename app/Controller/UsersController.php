<?php
/*
* Author: Matthew Halleran
* Matric: 1202919
* Date:   18 Dec 2014
*/

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
//Initialising the 3 types of users that could log into the system.
class UsersController extends AppController {
	var $uses = array('Student','Staff','Security');
	var $components = array();
	
    public function index() {
        
    }
	//Creating the login function
	public function login() {
		//Authenticating the details the user has given the app.
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	//Displaying appropriate log in message.
	        	$this->Session->setFlash(__('Log in successful'),'flash_good');
				//Checking the ID of the user to determine whether they are staff or a student.
				if ( $this->Auth->user('staffID') ) {
					return $this->redirect(array('controller' => 'Staffs' , 'action'=> 'index'));
				} else {
					return $this->redirect(array('controller' => 'Students' , 'action'=> 'index'));
				}
	            return $this->redirect(array('controller' => 'Users' , 'action'=> 'login'));
	        }
	        //In the case that the user's details are no authorized the user will receive an appropriate message.
	        $this->Session->setFlash(__('Invalid username or password, try again'),'flash_bad');
	    }
	}
	
	
	//Logout function
	public function logout () {
		return $this->redirect($this->Auth->logout());
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
		//Sending the users to the appropriate page of the app depending on the type of user they are.
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
