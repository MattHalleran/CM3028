<?php
App::uses('AppController', 'Controller');
class ElectivesController extends AppController {
	var $uses = array('Staff', 'Course', 'Elective','SysVar');
	var $components = array('Validations');
	
    public function index() {
    	$role = $this->Auth->user('courses');
    	$this->layout = 'admin';
		$this->set('role', $role);
    }
	
	public function delete( $code ) {
		if ($this->Elective->delete($code)) {
			$this->Session->setFlash(__('Module successfully removed'), 'flash_good');
		} else {
			$this->Session->setFlash(__('Module cannot be removed'), 'flash_bad');
		}
		return $this->redirect($this->referer());
	}
	
	public function setSelectedCourses ($code) {
		if ($module = $this->Elective->findByCode($code)) {
			$courses = $this->Course->fetchCourses();
			$cours = explode(',', $module['Elective']['courses']);
			$selected = array();
			if ( count($cours) > 0 ) {
				foreach( $courses as $key => $val ) {
					for ( $i = 0 ; $i < count($cours) ; $i++ ) {
						if ( $key == $cours[$i] ) {
							$selected[] = $key;
						}
					}
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
		return $selected;
	}
	
	public function offer($param = null) {
		//debug($this->request);
		if ( $this->request->is('ajax') ) {
			//$this->render('offer');
			$this->layout = "ajax";
		} else {
			$this->layout = "admin";
			/*if ( $param == "edit" && !empty($this->request->data['Elective']['code']) ) {
				return $this->redirect(array('controller'=> 'Electives', 'action' => 'offer', $code));
			}*/
		}
		
		if ( $this->request->is('post') || isset($this->request->data['Elective']['edit']) ) {
			$data = $this->request->data;
			if ( !isset($this->request->data['Elective']['edit']) ) {
				$this->Elective->create();
			}
			//debug(count($data['Elective']['courses']));
			if ( !empty($data['Elective']['code']) ) {
				if ( !empty($data['Elective']['title']) ) {
					if ( !empty($data['Elective']['synopsis']) ) {
						if ( !empty($data['Elective']['courses']) ) {
							if ($this->Elective->save($this->request->data)) {
								$this->Session->setFlash(__('Module saved'), 'flash_good');
							} else {
								$this->Session->setFlash(__('Unable to save module'),'flash_bad');
							}
						} else {
							$this->Session->setFlash(__('Choose at least one course where modules belongs'), 'flash_bad');
						}
					} else {
						$this->Session->setFlash(__('Please enter title of the module'), 'flash_bad');
					}
				} else {
					$this->Session->setFlash(__('Please enter synopsis'), 'flash_bad');
				}
			} else {
				$this->Session->setFlash(__('Please enter module code'), 'flash_bad');
			}
			return $this->redirect($this->referer());
		}
	if ( isset($this->request->data['Elective']['selectModule']) ) {
			$code = $this->request->data['Elective']['code'];
		} elseif ( $param ) {
			$code = $param;
		}
		//debug($code);
		$courses = $this->Course->fetchCourses();
		unset($courses['ADM']);
		$this->set('modules', $this->Elective->getLecturerModules($this->Auth->user('staffID')));
		$this->set('courses', $courses);
		//debug($code);
		
		//debug($this->setSelectedCourses($code));
		$this->set('selected');
		if ( isset($code) ) {
			$this->request->data = $this->Elective->findByCode($code);
			$this->set('selected', $this->setSelectedCourses($code));
		}

	}

	public function isAuthorized( $user ) {
		
		$start_date = $this->SysVar->getParam('START_DATE');
		$end_date = $this->SysVar->getParam('END_DATE');
		if ( $this->Validations->inVoting($start_date['SysVar']['meta_value'],$end_date['SysVar']['meta_value']) ) {
			$this->Session->setFlash(__('Voting has already started. You can\'t make any changes'), 'flash_bad');
			return false;
		}
		return parent::isAuthorized($user);
	}

	public function beforeFilter() {
	    parent::beforeFilter();
		//$this->Auth->allow('login');
		$matric = $this->Auth->user();
		if ( isset($matric['courses']) ) {
			$this->Auth->allow(array('logout', 'index', 'register', 'offer', 'delete'));
		} else {
			if ( $matric ) {
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			}
		}
	}
}
?>