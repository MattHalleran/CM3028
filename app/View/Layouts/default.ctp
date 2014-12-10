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
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="js/vendor/html5shiv.js"></script>
  <script src="js/vendor/respond.min.js"></script>
  <![endif]-->
</head>
<body>
	
	<div class="container">
		<div class=" ptq">
			
		<?php echo $this->element('userInfo'); ?>
		<div style="z-index: 1000; position:absolute;top: 60px;"><?php echo $this->Session->flash(); ?></div>
		<?php echo $this->fetch('content'); ?>
	</div>
	<!--<?php echo $this->element('sql_dump'); ?>-->
</body>
</html>
