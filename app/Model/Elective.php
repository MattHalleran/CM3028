<?php

class Elective extends AppModel {
	var $name = "Elective";
	var $primaryKey = "code";
	var $hasOne = array(
		'Staff' => array(
			'className' => 'Staff'
		)
	);
}

?>