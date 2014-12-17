<?php
/*
* Author: Haroldas Latonas
* Matric: 1205950
* Date:   17 Dec 2014
* Description: This view file displays staff account editting form
*/
?>
<div class="users form">
	
<?php
echo '<span class="label label-warning">'.$this->Html->link('Delete this user', array('controller' => 'Staffs', 'action' => 'delete', $this->data['Staff']['staffID'])) . '</span><br/>';
 echo $this->Form->create('Staff', array('action' => 'edit')); ?>
    <fieldset>
    	<?php if ( !$this->request->is('ajax') ): ?>
        <legend><?php echo __('Edit Staff member'); ?></legend>
        <?php endif;?>
        <?php echo $this->Form->input('staffID', array('type' => 'hidden'));
        echo $this->Form->input('firstname');
		echo $this->Form->input('lastname');
        echo $this->Form->input('courses', array(
            'type' => 'select',
            'options' => $courses,
            'selected' => $selected,
            'multiple' => true
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
