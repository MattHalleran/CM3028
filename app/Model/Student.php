<?php
App::uses('AppModel', 'Model');
App::uses('CustomPasswordHasher', 'Controller/Component/Auth');
	class Student extends AppModel {
		
		var $name = 'Student';
		var $scaffold;
		var $primaryKey = 'matric';#
		var $hasOne = array(
			'Choice' => array(
				'className' => 'Choice',
				'foreignKey' => 'StudentID'
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
	        )
		);
		
		public function getStudent() {
			debug($this->matric);
			return $this->findByMatric($this->matric);
		}
		
		public function generateSalt() {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUV0123456789~`!@#$%^&*()_+=-[]{}:;/.,<>?";
		    $salt = str_shuffle($chars);
		    $salt = substr($salt, 0, 12);
			return $salt;
		}
		
		
		public function beforeSave($options = array()) {
		    if (isset($this->data[$this->alias]['password'])) {
		    	$salt = $this->generateSalt();
				$passwordHasher = new CustomPasswordHasher();
		        $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password'].$salt);
				$this->data[$this->alias]['salt'] = $salt;

		    }
		    return true;
		}
}
?>