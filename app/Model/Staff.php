<?php
/*
* Author: Haroldas Latonas
* Matric: 1205950
* Date:   17 Dec 2014
*/
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
	
	/*
	* fetches single staff member by staff member ID
	*/
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
	
	/*
	* Fetches all staff members into array
	* This method is for populating <select> tag.
	*/
	public function getStaffMembers() {
		$staffs = $this->find('all', array(
			'fields' => array(
				'Staff.staffID', 'Staff.firstname', 'Staff.lastname'
			)
		));
		$new;
		foreach ($staffs as $key => $value) {
			$new[$staffs[$key]['Staff']['staffID']] = $staffs[$key]['Staff']['firstname'] . ' ' . $staffs[$key]['Staff']['lastname'];
		}
		return $new;
	}
	
	/*
	* Check whether staff member exists
	*/
	public function staffExists( $id ) {
		return $this->find('first', array(
			'conditions' => array(
				'Staff.staffID' => $id
			)
		));
	}
	
	/*
	* Method bellow will be executed before every Model->save(); function call
	*/
	public function beforeSave($options = array()) {
		if ( !$this->staffID ) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		// Code block bellow converts array of courses into string.
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
