<div class="table-responsive ptq">
    <h4>My Modules</h4>
    <table id="electives" class="table electives">
      <th>Module Code</th><th>Module Name</th><th>Decription</th><th></th>
      <?php 
      $i = 1;
	  //debug($modules);
      foreach( $modules as &$module ): ?>
      <tr <?php echo( isset($student_list[$module['Elective']['code']]) )? "style='cursor:pointer;'" : "" ?> data-parent="#electives" class="trigger collapsed" data-toggle="collapse" data-target="#expand-<?php echo $i;?>" aria-expanded="<?php echo (($i == 1) ? "true":"false");?>" aria-controls="expand-<?php echo $i;?>">
        <td><?php echo $module['Elective']['code'];?></td>
        <td><?php echo $module['Elective']['title'];?></td>
        <td><?php echo $module['Elective']['synopsis'];?></td>
        <td>
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <button data-toggle="modal" data-title="Edit elective module" data-ajax="<?php echo $this->Html->url(array('controller' => 'Electives', 'action' => 'offer', $module['Elective']['code']));?>" data-target="#ajaxModal" type="button"<?php echo (($inVoting)? "disabled='disabled'": "");?> class="btn btn-primary btn-sm">Edit</button>
                <button type="button"<?php echo (($inVoting)? "disabled='disabled'": "");?> class="btn btn-primary btn-sm"><a style="color:white;" href="<?php echo $this->Html->url(array('controller' => 'Electives', 'action'=>'delete', $module['Elective']['code']));?>">Delete</a></button>
              </div>
            </div>
          </div>
        </td>
      </tr>		
	  <?php if( isset($student_list[$module['Elective']['code']]) ) :?>
	  <tr id="expand-<?php echo $i;?>" class="expand collapse out">
      	<td colspan="4">
	    	<table class="table students">
	      		<th>Matric</th><th>Student name</th><th>Host course</th><th>Ranking value</th>
	      	<?php foreach($student_list[$module['Elective']['code']] as &$student):?>
		      		<tr>
		      			<td><?php echo $student['matric'];?></td>
		      			<td><?php echo $student['name'];?></td>
		      			<td><?php echo $student['course'];?></td>
		      			<td><?php echo $student['rank'];?></td>
		      		</tr>
		   <?php endforeach;?>
	      	</table>
      	</td>
      </tr>
      <?php endif;?>
      <?php 
      $i++;
      endforeach;?>
    </table>
<?php 
if ( !$inVoting ) {
	echo "<button data-title='Create new elective module' data-toggle='modal' data-ajax='" . $this->Html->url(array('controller' => 'Electives', 'action' => 'offer')). "' data-target='#ajaxModal' type='button' class='btn btn-primary btn-sm'>Add module</button>";
}
?>
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
<?php echo $this->Html->script('ui-script');?>

