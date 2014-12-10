<?php
App::uses('Controller', 'Component');
class PasswordComponent extends Component {
	public function __construct( $request = null, $response = null ) {
		parent::__construct($request, $response);
	}
	
	public function generateSalt() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUV0123456789~`!@#$%^&*()_+=-[]{}:;/.,<>?";
	    $salt = str_shuffle($chars);
	    $salt = substr($salt, 0, 12);
		return $salt;
	}
}
?>