<!-- app/View/Users/add.ctp -->
<div class="users form">
<?php
echo (!AuthComponent::user('matric')) ? '<span class="label label-warning">'.$this->Html->link('Delete this user', array('controller' => 'Students', 'action' => 'delete', $this->data['Student']['matric'])) . '</span>' : '';
echo $this->Form->create('Student', array('action' => 'edit')); ?>
    <fieldset><?php if ( !$this->request->is('ajax') ): ?>
        <legend><?php echo __('Edit Student'); ?></legend>
        <?php endif;?>
        <?php echo $this->Form->input('matric', array('type' => 'hidden'));
        echo $this->Form->input('firstname');
		echo $this->Form->input('surname');
        echo $this->Form->input('course', array(
            'options' => $courses,
            'default' => array(''),
            'empty' => 'Choose course',
            'disabled' => array('')
        ));
		echo $this->Form->input('edit',array(
			'type' => 'hidden',
			'value' => '1'
		));
    ?>
    </fieldset>
<?php if ( !$this->request->is('ajax') ): ?>
<?php echo $this->Form->end(__('Save')); ?>
<?php endif;?>
</div>