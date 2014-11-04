<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AuthComponent', 'Controller/Component');
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	// Load models
	var $uses = array('Student','Staff');
	// Load components
	public $components = array('Security','Cookie','Session','Auth','RequestHandler');
    // Load helpers
    public $helpers = array('Cache','Html','Session','Form');
	
	
	public function isAuthorized($user) {
	   return true;
	}

    function beforeFilter() {
    	// Authorisation setup
		if ( strtolower($this->request->controller) == 'staff' ) {
			$this->Auth->loginAction = array('controller' => 'Staff', 'action' => 'login');
			$this->Auth->loginRedirect = array('controller' => 'Staff', 'action' => 'index');
			$this->Auth->logoutRedirect = '/';
			$this->Auth->authError = "Not allowed! Staff";
			$this->Auth->authenticate = array (
	        	'Custom' => array(
	        		'passwordHasher' => array(
						'className' => 'Custom'
					),
	        		'userModel' => 'Staff',
	        		'fields' => array(
						'username' => 'staffID',
						'password' => 'password'
					),
				)
			);
			$this->Auth->allow('login');
		} else {
			$this->Auth->autoRedirect = false;
			$this->Auth->loginAction = array('controller' => 'Students', 'action' => 'login');
			$this->Auth->loginRedirect = array('controller' => 'Students', 'action' => 'index');
			$this->Auth->logoutRedirect = '/';
			$this->Auth->authError = "Not allowed! User";
			$this->Auth->authenticate = array (
	        	'Custom' => array(
	        		'passwordHasher' => array(
						'className' => 'Custom'
					),
	        		'userModel' => 'Student',
	        		'fields' => array(
						'username' => 'matric',
						'password' => 'password'
					),
				)
			);
			$this->Auth->allow('login');
		}
		// ------
		
		//Test 
		//$this->Student->matric = $this->Auth->user('matric');
    	//$this->Staff->staffID = $this->Auth->user('staffID');	
    	//$this->Staff->getStaff();
		//debug($this->Student->getStudent());
		if ($matric = $this->Auth->user()) {
			//debug($matric);
		}
		// ----
    }
	
}
