<?php echo $this->Form->create('SysVar');?>
<?php foreach( $vars as &$var ):?>
<?php echo $this->Form->input($var['SysVar']['meta_key'], array(
	'value' => $var['SysVar']['meta_value']
));?>	
<?php endforeach;?>
<?php echo $this->Form->end(__('Save'))?>