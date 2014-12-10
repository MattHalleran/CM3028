<!--<?php if (AuthComponent::user()) :?>
	<div style="position:fixed;top:46px; right: 20px; background: #fff; padding: 5px; color: #000;border:1px solid;">
	Hi, <?php
		echo AuthComponent::user('firstname') . ' ' . AuthComponent::user('surname');
	?> <br/>
	Your course is:
	<?php
		echo AuthComponent::user('course');
	?><br/>
	<?php echo $this->Html->link('Logout', array('controller' => 'Users' , 'action' => 'logout'));?>
	</div>
	
<?php endif;?>

<?php if (AuthComponent::user('staffID')) :?>
	<div style="position:fixed;top:46px; right: 20px; background: #fff; padding: 5px; color: #000;border:1px solid;">
	Hi, <?php
		echo AuthComponent::user('firstname') . ' ' . AuthComponent::user('lastname');
	?> <br/>
	Your courses are:
	<?php
		echo AuthComponent::user('courses');
	?><br/>
	<?php echo $this->Html->link('Logout', array('controller' => 'Users' , 'action' => 'logout'));?>
	</div>
<?php endif;?>
-->
<?php if (AuthComponent::user()) :?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="<?php echo $this->Html->url('/')?>">RGU Elective Portal</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
          	<?php echo $this->Html->link('Sign Out', array('controller' => 'Users' , 'action' => 'logout'));?>
          </li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
</div>
<?php endif;?>