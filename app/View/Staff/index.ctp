<h1>Staff view</h1>
<?php
echo $this->Html->link('Logout' , array('controller' => 'Staff', 'action' => 'logout'));
?><br/>
Viewing as <?php
	if ( $role === 'ADM' ) {
		?><b>Web administrator</b><br/><?php
		// View/Element/Staff/webadmin
		echo $this->element('Staff/webadmin', array(
			'var' => 'val'
		));
	} else {
		?><b>Lecturer</b><br/><?php
		// View/Element/Staff/lecturer
		echo $this->element('Staff/lecturer', array(
			'var' => 'val'
		));
	}
?>