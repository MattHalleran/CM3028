<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class Staff extends AppModel {
	var $name = "Staff";
	var $primaryKey = "staffID";
	var $useTable = "staff";
	
	var $hasMany = array(
		'Elective' => array(
			'className' => 'Elective',
			'foreignKey' => 'lecturer'
		)
	);
	
	
	public function getStaff($id = null) {
		if ( !$id ) {
			$id = $this->staffID;
		}
		return $this->find('first', array(
			'conditions' => array(
				'staffID' => $id
			)
		));
	}
	
	public function getStaffMembers() {
		$staffs = $this->find('all', array(
			'fields' => array(
				'Staff.staffID', 'Staff.firstname', 'Staff.lastname'
			)
		));
		$new;
		// Format for option input
		foreach ($staffs as $key => $value) {
			$new[$staffs[$key]['Staff']['staffID']] = $staffs[$key]['Staff']['firstname'] . ' ' . $staffs[$key]['Staff']['lastname'];
		}
		return $new;
	}
	
	// for creating test user
	public function hashPwd( $pwd ) {
		$passwordHasher = new BlowfishPasswordHasher();
		return $passwordHasher->hash($pwd);
	}
	
	public function staffExists( $id ) {
		return $this->find('first', array(
			'conditions' => array(
				'Staff.staffID' => $id
			)
		));
	}
	
	public function beforeSave($options = array()) {
		if ( !$this->staffID ) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		$courses = $this->data[$this->alias]['courses'];
		$coursesStr = "";
		if ( $courses != '' ) {
			foreach( $courses as &$course ) {
				$coursesStr .= "" . $course . ",";
			}
			$coursesStr = substr($coursesStr,0,-1);
			//debug($coursesStr);
			$this->data[$this->alias]['courses'] = $coursesStr;
		}
	}
}

?>