<h1>This is main page</h1>
<p>Here you can login as a student and choose modules</p>

<?php
echo $this->Html->link('Logout', array('controller' => 'Students' , 'action' => 'logout'));
/*
 * Display hashed password - for test user creation.
echo "pwd: " . $pwd;
echo "<br/>salt: " . $salt;
*/
?>
<br/>
<?php
echo $this->Html->link('Set elective modules', array('controller' => 'Choices', 'action' => 'choose'));
?>