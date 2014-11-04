<?php
App::uses('AppController', 'Controller');
class ChoicesController extends AppController {
	var $uses = array('Staff');
	var $components = array();
	
    public function index() {
    	
    }
	
	public function choose() {
		
	}

	public function beforeFilter() {
	    parent::beforeFilter();
		
		$matric = $this->Auth->user();
		if ( isset($matric['courses']) ) {
			$this->Auth->allow(array('logout', 'index', 'register'));
		} else {
			$this->Auth->deny('logout','index');
			$this->Auth->allow('login');
			$allowedActions = array('choose');
			if ( !in_array($this->request->action, $allowedActions) ) {
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			}
		}
	}
}
?>