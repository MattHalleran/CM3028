<?php
if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->create('Elective',array('url' => array('controller' => 'Electives', 'action'=> 'offer'))); ?>
<fieldset>
        <legend><?php echo __('Edit module'); ?></legend>
<?php echo $this->Form->input('selectModule', array('type' => 'hidden'));?>
	<?php echo $this->Form->input('code', array(
		'options' => $modules,
        'label' => 'Choose module',
        'empty' => 'Choose module',
        'default' => array(''),
        'disabled' => array('')
	));
	echo $this->Form->input('edit',array('type' => 'hidden'));
echo'</fieldset>';

echo $this->Form->end(__('Edit'));
endif;
//debug($this->request);
echo $this->Form->create("Elective", array('type' => 'post'));
if ($this->data):
echo $this->Form->input('edit', array('type' => 'hidden'));
	echo $this->Form->input('code', array('type' => 'hidden'));
endif;
echo $this->Form->input('code', array(
	'type' => 'text',
	'disabled' => ((empty($this->data))? false : true)
	));
echo $this->Form->input('title');
echo $this->Form->input('synopsis');
echo $this->Form->input('lecturer', array(
	'hidden' => true,
	'value' => AuthComponent::user('staffID')
));
echo $this->Form->input('courses', array(
            'type' => 'select',
            'options' => $courses,
            'selected' => $selected,
            'multiple' => true
        ));
?>
<?php if( !$this->request->is('ajax') ) echo $this->Form->end(__('Save')); ?>

<?php
if ( isset($this->data['Elective']) && !$this->request->is('ajax')) {
	echo $this->Html->link('Delete this module', array('controller' => 'Electives', 'action' => 'delete', $this->data['Elective']['code']));
}
?>