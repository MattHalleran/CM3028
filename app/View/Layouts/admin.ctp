<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<meta charset="utf-8">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php echo $this->Html->charset(); ?>
	<title>
		RGU Elective Portal
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('vendor/bootstrap.min');
		echo $this->Html->css('flat-ui-pro');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<style>
		.alert {
			position:relative;
			top:60px;
		}
		table.electives tr.trigger:hover {
			background: #eee;
		}
		table.electives tr.expand:hover {
			background: #efefef;
		}
		
		
		table.electives tr.expand{
			cursor:default;
		    background-color: #efefef;
		}
		.vote-time input:not(.btn){
			background:none;
			outline:none;
			border:none;
		}
		.vote-time input[type='submit'] {
			margin-left: 10px;
		}
		.vote-time h4 {
			display:inline-block;
		}
	</style>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="js/vendor/html5shiv.js"></script>
  <script src="js/vendor/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	<?php echo $this->element('userInfo'); ?>
	<div class="container">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
	</div>
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
