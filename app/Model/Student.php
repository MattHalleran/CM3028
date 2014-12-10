<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
	class Student extends AppModel {
		
		var $name = 'Student';
		var $scaffold;
		var $primaryKey = 'matric';
		var $hasOne = array(
			'Choice' => array(
				'className' => 'Choice',
				'foreignKey' => 'StudentID',
				'dependent' => true
			)
		);
		var $belongsTo = array(
			'Course' => array(
				'className' => 'Course',
				'foreignKey' => 'course'
			)
		);
		
		public $validate = array(
			'matric' => array(
	            'required' => array(
	                'rule' => array('notEmpty'),
	                'message' => 'Matric is required'
	            )
	        ),
	        'password' => array(
	            'required' => array(
	                'rule' => array('notEmpty'),
	                'message' => 'A password is required'
	            )
	        ),
	        'firstname' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'You must provide first name'
				)
			),
			'course' => array(
				'required' => array(
					'rule' => array('notEmpty'),
					'message' => 'Choose a course'
				)
			)
		);
		
		var $matric;
		
		public function getStudent($id = null) {
			//debug($this->matric);
			if ( !$id ) {
				$id = $this->matric;
			}
			return $this->findByMatric($id);
		}
		public function getStudents() {
			$students = $this->find('all', array(
				'fields' => array(
					'Student.matric', 'Student.firstname', 'Student.surname'
				)
			));
			$new;
			// Format for option input
			foreach ($students as $key => $value) {
				$new[$students[$key]['Student']['matric']] = $students[$key]['Student']['firstname'] . ' ' . $students[$key]['Student']['surname'];
			}
			return $new;
		}
		
		public function generateSalt() {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUV0123456789~`!@#$%^&*()_+=-[]{}:;/.,<>?";
		    $salt = str_shuffle($chars);
		    $salt = substr($salt, 0, 12);
			return $salt;
		}
		
		
		public function beforeSave($options = array()) {
		    if ( !$this->matric ) {
				$passwordHasher = new BlowfishPasswordHasher();
				$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
			}
		}
}
?>