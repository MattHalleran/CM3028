
	<!-- Image Section -->
<div class="row">
	<div class="col-md-6 col-md-offset-3 pth">
  		<?php echo $this->Html->image('rgu.svg', array(
			'alt' => 'RGU Logo',
			'width' => 400,
			'height' => 73.33,
			'class' => 'img-responsive pth center-block'
		))?>
	</div><!-- /.col-md-7 -->
</div>
	<!-- Login Form Section -->
<div class="row">
	<div class="col-md-6 col-md-offset-3 mtl">
		<div class="alert alert-info">
  			
  				<?php echo $this->Form->create('User', array(
  					'inputDefaults' => array(
						'label' => false,
						'div' => false
					)));?>
				<legend>Login</legend>
				<div class="form-group">
  					<label for="inputId">Username</label>
  					<?php echo $this->Form->input('username', array(
						'type' => 'text',
						'class' => 'form-control',
						'id' => 'inputId',
						'placeholder' => 'RGU Matriculation No.'
					));?>
				</div>
				<div class="form-group">
			  		<label for="inputPassword">Password</label>
			  		<?php echo $this->Form->input('password', array(
						'class' => 'form-control',
						'id' => 'inputPassword',
						'placeholder' => 'Password'
					));?>
				</div>
				<?php echo $this->Form->end(array(
					'div' => false,
					'label' => 'Login',
					'class' => 'btn btn-primary'
				)); ?>
		</div>
	</div><!-- /.col-md-7 -->
</div>

<?php echo $this->Html->script('vendor/jquery.min');?>
<?php echo $this->Html->script('flat-ui-pro');?>
