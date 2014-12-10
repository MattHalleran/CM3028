<?php
App::uses('AppController', 'Controller');

class StudentsController extends AppController {
	var $uses = array('Student','Course','SysVar','Elective','Choice');
	var $components = array('Security', 'Session','Validations');
	
    public function index() {
    	$start_date = $this->SysVar->getParam('START_DATE');
		$end_date = $this->SysVar->getParam('END_DATE');
		$voting = $this->Validations->inVoting($start_date['SysVar']['meta_value'],$end_date['SysVar']['meta_value']);
		$this->set('vote_details', array($start_date,$end_date));
		$this->set('inVoting', $voting);
		$this->set('electives', $this->Elective->find('all', array(
			'conditions' => array('Elective.courses LIKE' => '%' . substr($this->Auth->user('course'), 0,-1) . '%')
		)));
		if ( $choice = $this->Choice->getChoice($this->Auth->user('matric'))) {
			$this->set('choice', $choice);
			$this->data = $this->Choice->findByStudentid($this->Auth->user('matric'));
		}
		$this->set('choice', $choice);
    }
	
	// Delete student account
	public function delete ( $id ) {
		if ( $this->Student->delete($id) ) {
			$this->Session->setFlash(__('Student account has been deleted'),'flash_good');
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('Unable to delete student account'), 'flash_bad');
			$this->redirect($this->referer());
		}
	}
	// Edit student account
	public function edit($id = null) {
		
		if ( $this->Auth->user('matric') ) {
			$id = $this->Auth->user('matric');
		} else {
			$this->layout = 'admin';
		}
		if ( $this->request->is('ajax') ) {
			$this->layout = "ajax";
		}
		if ($this->request->is('post') || $id) {
			if ( isset($this->request->data['Student']['edit']) ) {
				$this->Student->matric = $this->request->data['Student']['matric'];
				if ( $this->Student->save($this->request->data) ) {
					if ( $this->Auth->user('matric') ) {
						$this->Session->write('Auth.User', $this->request->data['Student']);
					}
					$this->Session->setFlash(__('Student has been updated'),'flash_good');
					$this->redirect($this->referer());
				}
			} else {
				if ( !$id ) {
					$this->Student->recursive = -1;
					$id = $this->request->data['Student']['matric'];
				}
				$student = $this->Student->getStudent($id);
				$courses = $this->Course->fetchCourses();
				$this->set('courses', $courses);
				$this->data = $student;
			}
		}
	}
	// Create new student account
	public function create() {
		if ( $this->request->is('ajax') ) {
			$this->layout = "ajax";
		} else {
			$this->layout = "admin";
		}
		if ( $this->request->is('post') ) {
			$this->Student->create();
			$data = $this->request->data['Student'];
			if ( !empty($data['firstname']) && !empty($data['surname']) ) {
				if ( !$this->Student->getStudent($this->request->data['Student']['matric']) ) {
					if ($this->Student->save($this->request->data)) {
						$this->Session->setFlash(__('Student has been created'),'flash_good');
						$this->redirect($this->referer());
					} else {
						$this->Session->setFlash(__('Something went wrong'),'flash_bad');
					}
				} else {
					$this->Session->setFlash(__('Student already exists'),'flash_bad');
				}
			} else {
				$this->Session->setFlash(__('Dont forget first name and surname'),'flash_bad');
			}
		}
		$this->set('students', $this->Student->getStudents());
		$courses = $this->Course->fetchCourses();
		$this->set('courses', $courses);
	}
	
	// Check for privileges
	public function isAuthorized( $user ) {
		$courses = explode(',',@$user['courses']);
		// Admin can perform all actions
		if ( in_array('ADM', $courses) ) {
			return true;
		}
		// Prevent other users than admin edit, create or delete student account
		if ( in_array($this->action, array('create','edit', 'delete')) ) {
			if ( isset($user['matric']) && $this->action == 'edit' ) { // Allow student to change his information
				return true;
			} else {
				$this->Session->setFlash(__('Youre not allowed to see this'),'flash_bad');
				return false;
			}
		}
		return parent::isAuthorized($user);
	}
	
	public function beforeFilter() {
	    parent::beforeFilter();
		// unblock few actions
		$this->Security->unlockedActions = array('create', 'edit', 'delete');
	}
}
?>