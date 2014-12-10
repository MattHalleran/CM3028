<?php

class Choice extends AppModel {
	var $name = "Choice";
	var $primaryKey = "id";
	
	var $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'studentID',
			'dependent' => true
		)
	);
	
	public function getChoice($matric) {
		$this->recursive = -1;
		return $this->findByStudentid($matric);
	}
	
	
	
	public function beforeSave($options = null) {
		$rankings = $this->data['ranking'];
		$rankingsStr = "";
		if ( $rankings != '' ) {
			foreach( $rankings as $key => $value ) {
				$rankingsStr .= "" . $key . ",";
			}
			$rankingsStr = substr($rankingsStr,0,-1);
			//debug($coursesStr);
			$this->data[$this->alias]['choices'] = $rankingsStr;
		}
	} 
}

?>