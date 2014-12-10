Main page<br/>
<?php
if ( !AuthComponent::user() ) {
echo $this->Html->link('Login', array('controller' => 'Users' , 'action' => 'login')) . '<br/>';
} else {
if ( AuthComponent::user('matric') ) {
	echo $this->Html->link('Go to my page', array('controller' => 'Students' , 'action' => 'index'));
}

?>
<br/>
<?php
if ( AuthComponent::user('staffID') ) {
	echo $this->Html->link('Go to Staff page', array('controller' => 'Staffs' , 'action' => 'index'));
}
}
?>