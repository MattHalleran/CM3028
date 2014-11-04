Main page<br/>
<?php
if ( !AuthComponent::user('matric') ) {
	echo $this->Html->link('Login as a Student', array('controller' => 'Students' , 'action' => 'login'));
} else {
	echo $this->Html->link('Go to my page', array('controller' => 'Students' , 'action' => 'index'));
}

?>
<br/>
<?php
if ( !AuthComponent::user('staffID') ) {
	echo $this->Html->link('Login as a Staff member', array('controller' => 'Staff' , 'action' => 'login'));
} else {
	echo $this->Html->link('Go to Staff page', array('controller' => 'Staff' , 'action' => 'index'));
}

?>