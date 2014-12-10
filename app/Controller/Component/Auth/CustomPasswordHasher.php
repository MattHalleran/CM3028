<?php
App::uses('AbstractPasswordHasher', 'Controller/Component/Auth');
App::uses('Security', 'Utility');

class CustomPasswordHasher extends AbstractPasswordHasher {
	
    public function hash($password) {
    	if ( is_array($password) ) {
    		return Security::hash($password['pwd'],'md5', $password['salt']);
    	} else {
    		return Security::hash($password,'md5', false);
    	}
        
    }

    public function check($password, $hashedPassword) {
        return $hashedPassword == $this->hash($password);
    }
}
?>