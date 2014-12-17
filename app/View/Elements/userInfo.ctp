<?php
/*
* Author: Haroldas Latonas
* Matric: 1205950
* Date:   17 Dec 2014
* Description: Top menu bar. Displays website title and logout button
*/
?>
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
