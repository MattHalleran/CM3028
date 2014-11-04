<?php if (AuthComponent::user('matric')) :?>
	<div style="position:fixed;top:10px; right: 20px; background: #fff; padding: 5px; color: #000;border:1px solid;">
	Hi, <?php
		echo AuthComponent::user('firstname') . ' ' . AuthComponent::user('surname');
	?> <br/>
	Your course is:
	<?php
		echo AuthComponent::user('course');
	?><br/>
	<?php echo $this->Html->link('Logout', array('controller' => 'Students' , 'action' => 'logout'));?>
	</div>
	
<?php endif;?>

<?php if (AuthComponent::user('staffID')) :?>
	<div style="position:fixed;top:10px; right: 20px; background: #fff; padding: 5px; color: #000;border:1px solid;">
	Hi, <?php
		echo AuthComponent::user('firstname') . ' ' . AuthComponent::user('lastname');
	?> <br/>
	Your courses are:
	<?php
		echo AuthComponent::user('courses');
	?><br/>
	<?php echo $this->Html->link('Logout', array('controller' => 'Staff' , 'action' => 'logout'));?>
	</div>
<?php endif;?>