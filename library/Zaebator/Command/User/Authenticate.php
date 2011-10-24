<?php
class Zaebator_Command_User_Authenticate extends Zaebator_Command_Abstract
{
	/**
	 *
	 * @var array 
	 */
	protected $_paramsMap = array('user', 'password');
	
	/**
	 * array of response callback - will be proccesed after geting response
	 * @var array 
	 */
	protected $_responseCallbacks = array('_setAuthHashCallback');
	
	protected function _setAuthHashCallback() {
		$this->_zaebator->setAuthHash($this->_result);
	}
}
