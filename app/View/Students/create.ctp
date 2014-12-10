<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->create('Student', array('action' => 'edit')); ?>
<fieldset>
        <legend><?php echo __('Edit Student'); ?></legend>
	<?php echo $this->Form->input('matric', array(
		'options' => $students,
        'label' => 'Choose Student',
        'empty' => 'Choose Student',
        'default' => array(''),
        'disabled' => array('')
	));
echo'</fieldset>';
echo $this->Form->end(__('Edit')); ?>
<?php endif; ?>
<?php echo $this->Form->create('Student', array('action' => 'create')); ?>
    <fieldset>
    	<?php if ( !$this->request->is('ajax') ): ?>
        <legend><?php echo __('Add Student'); ?></legend>
        <?php endif;?>
        <?php echo $this->Form->input('matric', array('type' => 'text'));
        echo $this->Form->input('firstname');
		echo $this->Form->input('surname');
        echo $this->Form->input('password');
        echo $this->Form->input('course', array(
            'options' => $courses,
            'default' => array(''),
            'empty' => 'Choose course',
            'disabled' => array('')
        ));
    ?>
    </fieldset>
<?php if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->end(__('Submit')); ?>
<?php endif;?>
</div>