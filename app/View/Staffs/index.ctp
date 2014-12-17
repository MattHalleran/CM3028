
<?php
/*
* Author: Haroldas Latonas
* Matric: 1205950
* Date:   17 Dec 2014
* Description: This view file decides which panel to display
*/
	if ( $role === 'ADM' ) {
		// Display web administrators panel
		// It's located in:
		// View/Element/Staff/webadmin
		echo $this->element('Staff/webadmin', array(
			'var' => 'val'
		));
	} else {
		// Display lecturers panel
		// It's located in:
		// View/Element/Staff/lecturer
		echo $this->element('Staff/lecturer', array(
			// Passing few variables to lecturer panel
			'modules' => $modules,
			'inVoting' => $inVoting
		));
	}
?>
