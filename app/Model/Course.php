<?php

class Course extends AppModel {
	var $name = "Course";
	var $primaryKey = "code";
	
	public function fetchCourses() {
		$courses = $this->find('all');
		$new;
		// Format for option input
		foreach ($courses as $key => $value) {
			$new[$courses[$key]['Course']['code']] = $courses[$key]['Course']['name'];
		}
		return $new;
	}
}

?>