<?php

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
	
	public function getStaff() {
		debug($this->find('first', array(
			'conditions' => array(
				'staffID' => $this->staffID
			)
		)));
	}
}

?>