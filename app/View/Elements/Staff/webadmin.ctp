<?php //debug($staffMembers);?>
<?php $vars = $this->Html->url(array('controller' => 'SysVars', 'action' => 'edit'));?>
<script>
	var sysvars = '<?php echo $vars;?>';
</script>
<div class=" ptq">
	<div class="panel panel-success ">
  		<div class="panel-heading">
			<h3 class="panel-title">Welcome <?php echo AuthComponent::user('firstname');?></h3>
  		</div>
  		<div class="panel-body">
			<div class="vote-time">Vote dates: starts at <h4><span data-toggle="tooltip" data-placement="top" title="Double click to enable editing" class="label label-<?php echo (($inVoting)?"success":"primary");?> start"><?php echo $vote_details[0]['SysVar']['meta_value'];?></span></h4>, ends at <h4><span data-toggle="tooltip" data-placement="top" title="Double click to enable editing" class="end label label-<?php echo (($inVoting)?"success":"primary");?>"><?php echo $vote_details[1]['SysVar']['meta_value'];?></span></h4></div>
			<div style="margin-top:10px;">
				<div class="btn-group">
					<button type="button" data-title="Create new lecturer account" data-toggle='modal' data-ajax="<?php echo $this->Html->url(array('controller' => 'Staffs', 'action' => 'create'));?>" data-target="#ajaxModal" class="btn btn-primary">Create new lecturer account</button>
					<div class="btn-group" role="group">
    					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
      						Edit account
      						<span class="caret"></span>
    					</button>
    					<ul class="dropdown-menu" role="menu">
    						<?php foreach($staffMembers as &$staff):?>
     						<li data-toggle='modal' data-title="Edit lecturer account" data-ajax="<?php echo $this->Html->url(array('controller' => 'Staffs', 'action' => 'edit', $staff['Staff']['staffID']));?>" data-target="#ajaxModal"><a href="#"><?php echo $staff['Staff']['firstname'] . ' ' . $staff['Staff']['lastname'];?></a></li>
     						<?php endforeach;?>
    					</ul>
  					</div>
				</div>
			</div>
			<div style="margin-top:10px;">
				<div class="btn-group">
					<button type="button" data-title="Create new student account" data-toggle='modal' data-ajax="<?php echo $this->Html->url(array('controller' => 'Students', 'action' => 'create'));?>" data-target="#ajaxModal" class="btn btn-primary">Create new student account</button>
					<div class="btn-group" role="group">
    					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
      						Edit account
      						<span class="caret"></span>
    					</button>
    					<ul class="dropdown-menu" role="menu">
    						<?php foreach($students as &$student):?>
     						<li data-toggle='modal' data-title="Edit student account" data-ajax="<?php echo $this->Html->url(array('controller' => 'Students', 'action' => 'edit', $student['Student']['matric']));?>" data-target="#ajaxModal"><a href="#"><?php echo $student['Student']['firstname'] . ' ' . $student['Student']['surname'];?></a></li>
     						<?php endforeach;?>
    					</ul>
  					</div>
				</div>
			</div>
  		</div>
 	</div>
</div>
<div class="panel panel-info">
	<div class="panel-heading">Elective module list</div>
	<table id="electives" class="table electives">
      <th>Module Code</th><th>Module Name</th><th>Decription</th><th>Lecturer</th><th></th>
      <?php 
      $i = 1;
      foreach( $modules as &$module ): ?>
      <tr>
        <td><?php echo $module['Elective']['code'];?></td>
        <td><?php echo $module['Elective']['title'];?></td>
        <td><?php echo $module['Elective']['synopsis'];?></td>
        <td><?php echo $module['Staff']['firstname'] . ' ' . $module['Staff']['lastname'];?></td>
        <td>
        	<div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <button data-toggle="collapse" data-target="#restrictionsExpand-<?php echo $i;?>" aria-expanded="<?php echo (($i == 1) ? "true":"false");?>" aria-controls="restrictionsExpand-<?php echo $i;?>" type="button" class="btn btn-primary btn-sm"><small>Restrictions</small></button>
                <button <?php echo( isset($student_list[$module['Elective']['code']]) )? "style='cursor:pointer;'" : "disabled='disabled'" ?> data-parent="#electives" class="trigger collapsed btn btn-primary btn-sm" data-toggle="collapse" data-target="#expand-<?php echo $i;?>" aria-expanded="<?php echo (($i == 1) ? "true":"false");?>" aria-controls="expand-<?php echo $i;?>" type="button"><small>Students</small></button>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr id="restrictionsExpand-<?php echo $i;?>" class="collapse out">
      	<td colspan="5">
      		<div class="well well-sm">
      			<?php $courseArray = explode(',',$module['Elective']['courses']);?>
      			<?php foreach($courseArray as &$course):?>
      			<span class="label label-primary"><?php echo $courseList[$course];?></span>
      			<?php endforeach;?>
      		</div>
      	</td>
      </tr>
	  <?php if( isset($student_list[$module['Elective']['code']]) ) :?>
	  <tr id="expand-<?php echo $i;?>" class="expand collapse out">
      	<td colspan="5">
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
</div>
<div class="panel panel-info">
	<div class="panel-heading">Student list</div>
	<table id="electives" class="table electives">
      <th>Student name</th><th>Course</th><th>No. of electives</th>
      <?php foreach($students as &$student):?>
      	<tr>
      		<td><?php echo $student['Student']['firstname'] . ' ' . $student['Student']['surname'];?></td>
      		<td><?php echo $student['Course']['name'];?></td>
      		<td><?php echo $student['Choice']['choices'];?></td>
      	</tr>
      <?php endforeach;?>
    </table>
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