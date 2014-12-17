/*
* Author: Haroldas Latonas
* Matric: 1205950
* Date:   17 Dec 2014
* Description: Create new staff member view
*/
<div class="users form">
<?php if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->create('Staff', array('action' => 'edit')); ?>
<fieldset>
        <legend><?php echo __('Edit Staff Member'); ?></legend>
	<?php echo $this->Form->input('staffID', array(
		'options' => $staff,
        'label' => 'Choose Staff member',
        'empty' => 'Choose Staff member',
        'default' => array(''),
        'disabled' => array('')
	));
echo'</fieldset>';
echo $this->Form->end(__('Edit'));
endif;
echo $this->Form->create('Staff', array('action' => 'create')); ?>
    <fieldset>
        <?php echo $this->Form->input('staffID', array('type' => 'text'));
        echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
        echo $this->Form->input('password');
        echo $this->Form->input('courses', array(
        	'type' => 'select',
        	'multiple' => true,
            'options' => $courses,
            'empty' => 'Please choose course',
            'default' => array(''),
            'disabled' => array('')
        ));
    ?>
    </fieldset>
<?php if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->end(__('Submit')); ?>
<?php endif;?>
</div>
