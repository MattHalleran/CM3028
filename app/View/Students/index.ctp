<div class="panel panel-success ">
  		<div class="panel-heading">
			<h3 class="panel-title">Welcome <?php echo AuthComponent::user('firstname');?></h3>
  		</div>
  		<div class="panel-body">
			<div>Voting starts at <small><?php echo $vote_details[0]['SysVar']['meta_value'];?></small>, ends at <small><?php echo $vote_details[1]['SysVar']['meta_value'];?></small></div>
			<button type="button" data-title="Edit my account" data-toggle='modal' data-ajax="<?php echo $this->Html->url(array('controller' => 'Students', 'action' => 'edit'));?>" data-target="#ajaxModal" class="btn btn-primary">Edit my details</button>
 	</div>
</div>
<div class="col-lg-12 ptm">
  <div class="table-responsive">
  	<?php echo ($inVoting)?$this->Form->create('Choice',array(
  		'url' => array('controller' => 'Choices', 'action' => (($choice) ? "resetChoice" : "choose"), (($choice)? $this->data['Choice']['id'] : "")),
		'inputDefaults' => array(
			'label' => false,
			'div' => false
		)
	)):"";?>
	<?php
	if ( $choice && $inVoting ) {
		echo $this->Form->input('id', array(
			'type' => 'hidden'
		));
		$choices = explode(",",$choice['Choice']['choices']);
	}
	?>
	<?php echo ($inVoting)?$this->Form->input('studentID', array('type' => 'hidden', 'value' => AuthComponent::user('matric'))):"";?>
    <table class="table">
      <thead>
      <tr>
        <th>Module Code</th>
        <th>Module Title</th>
        <th>Details</th>
        <th>Selected</th>
        <th>Preference Rank</th>
      </tr>
      </thead>
      <tbody>
<?php $i = 1;?>
<?php foreach($electives as &$elective):?>
      <tr>
        <td><?php echo $elective['Elective']['code'];?></td>
        <td><?php echo $elective['Elective']['title'];?></td>
        <td><?php echo $elective['Elective']['synopsis'];?></td>
        <td><input type="checkbox" <?php echo ($inVoting)?(($choice && in_array($elective['Elective']['code'], $choices))? "checked='checked' disabled='disabled'" : ""):"disabled='disabled'";?> class="checkbox" id="cb<?php echo $i;?>"></td>
        <td>
        	<?php echo ($inVoting)?$this->Form->input('ranking.' . $elective['Elective']['code'], array(
				'type' => (($choice) ? "text" : "select"),
				'size' => 1,
				'class' => 'selectbox',
				'id' => 's' . $i,
				'disabled' => true,
				'value' => (($choice) ? array_search($elective['Elective']['code'], $choices)+1 : "")
			)):"";?>
        </td>
      </tr>
<?php $i++;?>
<?php endforeach;?>
      </tbody>
    </table>
    <?php echo ($inVoting)?$this->Form->end(array(
		'label' => (($choice && $inVoting) ? "Reset" : "Submit")
	)):"";?>
  </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="ajaxModalLabel">Update module</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<?php echo $this->Html->script('vendor/jquery.min');?>
<?php echo $this->Html->script('flat-ui-pro');?>
<?php echo $this->Html->script('elective-rating');?>
<?php echo $this->Html->script('ui-script');?>