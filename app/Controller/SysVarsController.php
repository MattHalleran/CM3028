<?php
App::uses('AppController', 'Controller');
class SysVarsController extends AppController {
	var $uses = array('SysVar');
	var $components = array();
	
    public function index() {
    	
    }
	
	public function edit () {
		$this->set('vars', $this->SysVar->find('all'));
		if ( $this->request->is('post') ) {
			$start = $this->request->data['start'];
			$end = $this->request->data['end'];
			if ( strtotime($start) && strtotime($end) ) {
				if (
					$this->SysVar->updateAll(array(
						'SysVar.meta_value' => '"' . $this->request->data['start'] . '"'
					),array(
						'SysVar.meta_key' => 'START_DATE'
					)) 
					&& 
					$this->SysVar->updateAll(array(
						'SysVar.meta_value' => '"' . $this->request->data['end'] . '"'
					),array(
						'SysVar.meta_key' => 'END_DATE'
					))
				){
					$this->Session->setFlash(__('Data has been saved'), 'flash_good');
				} else {
					$this->Session->setFlash(__('Unable to save data'), 'flash_bad');
				}
			} else {
				$this->Session->setFlash(__('Incorrect time format'), 'flash_bad');
			}
			return $this->redirect($this->referer());
		}
	}
	
	public function isAuthorized( $user ) {
		$courses = explode(',',@$user['courses']);
		if ( in_array('ADM', @$courses) ) {
			return true;
		}
		if ( in_array($this->action, array('create', 'delete', 'edit')) ) {
			$this->Session->setFlash(__('Youre not allowed to see this'),'flash_bad');
			return false;
		}
		return parent::isAuthorized($user);
	}

	public function beforeFilter() {
	    parent::beforeFilter();
		$matric = $this->Auth->user();
		if ( in_array('ADM',explode(',',$matric['courses']) ) ) {
			$this->Auth->allow(array('index','edit'));
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