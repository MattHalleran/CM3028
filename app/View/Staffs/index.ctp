
<?php

	if ( $role === 'ADM' ) {
		// View/Element/Staff/webadmin
		echo $this->element('Staff/webadmin', array(
			'var' => 'val'
		));
	} else {
		// View/Element/Staff/lecturer
		echo $this->element('Staff/lecturer', array(
			'modules' => $modules,
			'inVoting' => $inVoting
		));
	}
?>