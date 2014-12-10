<?php
App::uses('SysVars', 'Model');
App::uses('CakeTime', 'Utility');
class Elective extends AppModel {
	var $name = "Elective";
	var $primaryKey = "code";
	var $belongsTo = array(
		'Staff' => array(
			'className' => 'Staff',
			'foreignKey' => 'lecturer'
		)
	);
	
	public function getLecturerModules($lecturerID) {
		$electives = $this->findAllByLecturer($lecturerID);
		$new = "";
		// Format for option input
		foreach ($electives as $key => $value) {
			$new[$electives[$key]['Elective']['code']] = $electives[$key]['Elective']['code'] . ' - ' . $electives[$key]['Elective']['title'];
		}
		return $new;
	}
	
	
	public function beforeSave($options = array()) {
			$courses = $this->data[$this->alias]['courses'];
			//debug($this->data);
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