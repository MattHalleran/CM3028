<?php
App::uses('AppController', 'Controller');
class ElectivesController extends AppController {
	var $uses = array('Staff');
	var $components = array();
	
    public function index() {
    	$role = $this->Auth->user('courses');
    	$this->layout = 'admin';
		$this->set('role', $role);
    }

	public function beforeFilter() {
	    parent::beforeFilter();
		//$this->Auth->allow('login');
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