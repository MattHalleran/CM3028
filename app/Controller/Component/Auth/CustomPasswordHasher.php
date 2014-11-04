<?php
App::uses('AbstractPasswordHasher', 'Controller/Component/Auth');
App::uses('Security', 'Utility');

class CustomPasswordHasher extends AbstractPasswordHasher {
	
    public function hash($password) {
    	//debug($password);
        return Security::hash($password,'md5', false);
    }

    public function check($password, $hashedPassword) {
        	//debug($password);
        return $hashedPassword == $this->hash($password);
    }
}
?>