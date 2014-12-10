<?php
App::uses('AppController', 'Controller');
App::uses('CustomPasswordHasher','CustomAuthentication', 'Controller/Component/Auth');
class StaffsController extends AppController {
	var $uses = array('Staff','Security','PasswordHasher', 'Course','Student', 'Elective', 'SysVar','Course');
	var $components = array('Session','Validations');
	var $name = 'Staffs';
	var $layout = 'admin';
	
    public function index() {
    	// fetch vote start/end dates
    	$start_date = $this->SysVar->getParam('START_DATE');
		$end_date = $this->SysVar->getParam('END_DATE');
		$voting = $this->Validations->inVoting($start_date['SysVar']['meta_value'],$end_date['SysVar']['meta_value']);
			// set a view variable
		$this->set('inVoting', $voting);
		$this->set('vote_details', array($start_date,$end_date));
		//
		// fetch role
    	$role = $this->Auth->user('courses');
		$courses = explode(',',$role);
		
		// if loged in as aministrator
		if ( in_array('ADM', $courses) ) {
			$this->set('role', 'ADM');
			// fetch all electives modules
			$electives = $this->Elective->find('all', array(
				'order' => array(
					'Elective.code ASC'
				)
			));
			// fetch all staff members
			$this->Staff->recursive = -1;
			$this->set('staffMembers', $this->Staff->find('all'));
			// fetch all students
			$sortedStudents = $this->Student->find('all', array(
				'order' => array(
					'Student.firstname'
				),
				'fields' => array(
					'Student.matric',
					'Student.firstname',
					'Student.surname',
					'Choice.choices',
					'Course.name'
				)
			));
			// modify student array
			foreach( $sortedStudents as &$student ) {
				$student['Choice']['choices'] = ($student['Choice']['choices'] != "")? count(explode(',',$student['Choice']['choices'])): 0;
			}
			// sort student array by rank. lowest first
			$sortedStudents = Hash::sort($sortedStudents, '{n}.Choice.choices', 'asc');
			$this->set('students', $sortedStudents);
			
			// fetch course list
			$courseList = $this->Course->find('all', array(
				'order' => array('name')
			));
			// modify course array
			$courses = array();
			foreach ( $courseList as &$course ){
				$courses[$course['Course']['code']] = $course['Course']['name'];
			}
			
			$this->set('courseList', $courses);
			
		} else { // Viewing as a lecturer
			// fetch modules
			$electives = $this->Elective->findAllByLecturer($this->Auth->user('staffID'));
			// set role
			$this->set('role', 'LEC');
		}
		// set modules variable
		$this->set('modules', $electives);
		
		if ( $voting ) { // Voting has already started
		
			// Generate elective module list along with student list who chose particular module
			$student_list = array();
			foreach( $electives as &$module) { // loop through all modules lecturer created
				// fetch all students who chose current module
				$student_choices = $this->Student->find('all', array(
					'fields' => array(
						'Student.matric',
						'Student.firstname',
						'Student.surname',
						'Choice.choices',
						'Course.name'
					),
					'conditions' => array(
						'Choice.id !=' => null,
						'Choice.choices LIKE' => '%' . $module['Elective']['code'] . '%' 
					)
				));
				foreach ( $student_choices as &$student ) { // loop through all students
					$choices = explode(',',$student['Choice']['choices']); // convert chosen modules into array
					$student_list[$module['Elective']['code']][] = array(
						'name' => $student['Student']['firstname'] . ' ' . $student['Student']['surname'],
						'matric' => $student['Student']['matric'],
						'course' => $student['Course']['name'],
						'rank' => count($choices) - array_search($module['Elective']['code'], $choices) // Generates module rank
 					);
				}
				if( isset($student_list[$module['Elective']['code']]) ) { // check there are any students who chose this module
					// Sort student list by rank. high to low
					$student_list[$module['Elective']['code']] = Hash::sort($student_list[$module['Elective']['code']], '{n}.rank', 'desc');
				}
			}
			// set module-student list variable
			$this->set('student_list',$student_list);
		}
		// define page layout
    	$this->layout = 'admin';
    }
	
	// Edit staff member action
	public function edit($id = null) {
		// set layout according to request we've got
		if ( $this->request->is('ajax') ) {
			$this->layout = "ajax";
		} else {
			$this->layout = "admin";
		}
		// redirect user to create staff member action in case there is no ID defined
		if ( empty($this->request->data) && !$id ) {
			$this->Session->setFlash(__('You must select a user to update'),'flash_bad');
			$this->redirect(array('controller' => 'Staffs' , 'action' => 'create'));
		}
		// if post data found or ID for editing is set
		if ($this->request->is('post') || $id) { // 
			if ( isset($this->request->data['Staff']['edit']) ) { // if we're editing user
				$this->Staff->staffID = $this->request->data['Staff']['staffID']; // set current user id to the model
				if ( $this->Staff->save($this->request->data) ) { // save data
					if ( $this->Staff->staffID == $this->Auth->user('staffID') ) { // If I've updated my own account
						// then we update session data
						$this->request->data['Staff']['courses'] = implode(',',$this->request->data['Staff']['courses']);
						$this->Session->write('Auth.User', $this->request->data['Staff']);
					}
					$this->Session->setFlash(__('Staff member has been updated'),'flash_good');
					$this->redirect($this->referer());
				}
			} else { // Otherwise we haven't clicked submit yet
			// fetch data for form inputs
				if ( !$id ) { // if ID is not found via GET
					$this->Staff->recursive = -1;
					// then lets use the one we've got from POST
					$id = $this->request->data['Staff']['staffID'];
				}
				// fetch data from database
				$staff = $this->Staff->getStaff($id);
				$courses = $this->Course->fetchCourses();
				$cours = explode(',', @$staff['Staff']['courses']);
				$selected;
				// generate array of courses lecturer has already created
				foreach( $courses as $key => $val ) {
					for ( $i = 0 ; $i < count($cours) ; $i++ ) {
						if ( $key == $cours[$i] ) {
							$selected[] = $key;
						}
					}
				}
				$this->set('selected', @$selected);
				$this->set('courses', $courses);
				// set all data to be sent to view
				$this->data = $staff;
			}
		}
	}
	// Delete single staff member
	public function delete ( $id ) {
		if ( $this->Staff->delete($id) ) {
			$this->Session->setFlash(__('Staff member has been deleted'),'flash_good');
		} else {
			$this->Session->setFlash(__('Unable to delete staff member'),'flash_bad');
		}
		$this->redirect($this->referer());
	}
	// Action to create a new staff member/lecturer
	public function create() {
		// Check request type
		if ( $this->request->is('ajax') ) {
			$this->layout = "ajax";
		} else {
			$this->layout = "admin";
		}
		// Check how data arrived
		if ( $this->request->is('post') ) {
			// create new Staff model object
			$this->Staff->create();
			$data = $this->request->data['Staff'];
			if ( !empty($data['firstname']) && !empty($data['lastname']) ) { // validate name
				if ( !$this->Staff->staffExists($this->request->data['Staff']['staffID']) ) { // check for ID duplicates 
					if ($this->Staff->save($this->request->data)) {// save data
						$this->Session->setFlash(__('Lecturer has been created'),'flash_good');
						$this->redirect($this->referer());
					} else {
						$this->Session->setFlash(__('Something went wrong'),'flash_bad');
					}
				} else {
					$this->Session->setFlash(__('Lecturer already exists'),'flash_bad');
				}
			} else {
				$this->Session->setFlash(__('Don\'t forget first name and surname'),'flash_bad');
			}
		}
		$this->set('staff', $this->Staff->getStaffMembers());
		$courses = $this->Course->fetchCourses();
		$this->set('courses', $courses);
	}
	// Logout action
	public function logout () {
		return $this->redirect($this->Auth->logout());
	}
	// Check for privileges
	public function isAuthorized( $user ) {
		$courses = explode(',',@$user['courses']);
		if ( in_array('ADM', @$courses) ) { // if current user is Admin
		// then we allow all actions
			return true;
		}
		// otherwise disable access
		if ( in_array($this->action, array('create', 'delete', 'edit')) ) {
			$this->Session->setFlash(__('Youre not allowed to see this'),'flash_bad');
			return false;
		}
		return parent::isAuthorized($user);
	}

	public function beforeFilter() {
	    parent::beforeFilter();
		// unlock some actions to prevent request black-holing
		$this->Security->unlockedActions = array('create', 'edit');
		// get currently loged user's credentials
		$matric = $this->Auth->user();
		if ( isset($matric['courses']) ) {
			$courses = explode(',',$matric['courses']);
			if ( in_array('ADM', $courses) ) { // if it's admin
				$this->Auth->allow(); // allow all actions
			} else { // otherwise deny all actions
				$this->Auth->deny(array('create', 'edit','delete'));
			}
		} else { // unauthorized user
			$this->Auth->deny(); // deny all actions
			if ( $matric ) { // Student detected
			// redirect to students page
				$this->redirect(array('controller' => 'Students' , 'action' => 'index'));
			}
		}
	}
}
?>