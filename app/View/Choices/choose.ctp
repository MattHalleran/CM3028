<?php
echo $this->Form->create('Choice');
echo $this->Form->input('studentID', array(
	'type' => 'hidden',
	'value' => AuthComponent::user('matric')
));
if ( $choice ) {
	echo $this->Form->input('id', array(
		'type' => 'hidden'
	));
	$choices = explode(",",$choice['Choice']['choices']);
}
//debug($choices);
$i = 0;
foreach( $electives as &$elective ) {
	echo $this->Form->input('ranking.' . $elective['Elective']['code'], array(
		'size' => 1,
		'maxlength' => 1,
		'disabled' => (($choice) ? true: false),
		'style' => 'width:16px;', 
		'label' => $elective['Elective']['code'] . ' ' . $elective['Elective']['title'],
		'value' => (($choice) ? array_search($elective['Elective']['code'], $choices)+1 : "")
	));
	$i++;
	//debug(array_search($elective['Elective']['code'], $choices)+1);
}
echo $this->Form->end(__("Save"));

?>
