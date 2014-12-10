<?php
App::uses('AppController', 'Controller');
class ChoicesController extends AppController {
	var $uses = array('Staff', 'Elective');
	var $components = array('Validations');
	
    public function index() {
    	
    }
	public function resetChoice($id) {
		if ($this->Choice->delete($id)) {
			$this->Session->setFlash(__('Your choices has been reseted'));
		} else {
			$this->Session->setFlash(__('Unable to reset your choice'));
		}
		return $this->redirect($this->referer());
	}
	
	public function choose() {
		//debug($this->request->data);
		$this->set('electives', $this->Elective->find('all', array(
			'conditions' => array('Elective.courses LIKE' => '%' . substr($this->Auth->user('course'), 0,-1) . '%')
		)));
		if ( $choice =  $this->Choice->getChoice($this->Student->matric)) {
			$this->set('choice', $choice);
			$this->data = $this->Choice->findByStudentid($this->Student->matric);
		}
		$this->set('choice', $choice);
		if ( $this->request->is('post') ) {
			if ( !$choice ) {
				$data = $this->request->data;
				$rankings = $data['ranking'];
				if ( $this->Validations->duplicateExists($rankings) ) {
					$this->Session->setFlash(__('Duplicate ranking values found.'));
					return $this->redirect($this->referer());
				}
				arsort($rankings);
				$i = count($rankings);
				foreach ( $rankings as $key => $value ) {
					$rankings[$key] = $i--;
				}
				$this->request->data['ranking'] = $rankings; 
				$this->Choice->create();
				if ( $this->Choice->save($this->request->data) ) {
					//debug($this->data);
					$this->Session->setFlash(__('Your choice has been recorded'));
					return $this->redirect($this->referer());
				}
			} else {
				$this->Session->setFlash(__('You\'ve already voted. You can either edit your choice or reset it.'));
				return $this->redirect($this->referer());
			}
		}
	}

	public function isAuthorized( $user ) {
		$start_date = $this->SysVar->getParam('START_DATE');
		$end_date = $this->SysVar->getParam('END_DATE');
		if ( !$this->Validations->inVoting($start_date['SysVar']['meta_value'],$end_date['SysVar']['meta_value']) ) {
			$this->Session->setFlash(__('Voting hasn\'t started yet.'), 'flash_bad');
			return false;
		}
		return parent::isAuthorized($user);
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
		
		$matric = $this->Auth->user();
		if ( isset($matric['courses']) ) {
			$this->Auth->allow(array('logout', 'index', 'register'));
		} else {
			$this->Auth->deny('logout','index');
			$this->Auth->allow('login');
			$allowedActions = array('choose','resetChoice');
			if ( !in_array($this->request->action, $allowedActions) ) {
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			}
		}
	}
}
?>