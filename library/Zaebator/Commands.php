<?php

class Zaebator_Commands {

	/**
	 * Zaebator commands
	 *
	 * @var array
	 */
	protected static $_commands = array(
		'user.authenticate' => 'Zaebator_Command_User_Authenticate'
	);

	/**
	 * Add command
	 *
	 * @param string $name      Command name
	 * @param string $className Name of class
	 */
	public static function add($name, $className) {
		if (!class_exists($className)) {
			throw new Zaebator_Exception("Class '$className' not found. You must include before or setup autoload");
		}

		$classReflection = new ReflectionClass($className);
		if (!in_array('Zaebator_Command_Interface', $classReflection->getInterfaceNames())) {
			throw new Zaebator_Exception("Class '$className' must implement Zaebator_Command_Interface interface");
		}

		$lowerName = strtolower($name);
		self::$_commands[$lowerName] = $className;

		return true;
	}

	/**
	 * Remove command
	 *
	 * @param string $name Command name
	 */
	public static function remove($name) {
		$lowerName = self::_getCommandLowerNameAndThrowIfNotPresent($name);

		unset(self::$_commands[$lowerName]);

		return true;
	}

	/**
	 * Get command instance
	 *
	 * @param Zaebator $zaebator   Zaebator instance
	 * @param string  $name      Command name
	 * @param array   $arguments Command arguments
	 * @return Zaebator_Command_Abstract
	 */
	public static function get(Zaebator $zaebator, $name, $arguments) {
		$lowerName = self::_getCommandLowerNameAndThrowIfNotPresent($name);

		return new self::$_commands[$lowerName]($zaebator, $name, $arguments);
	}

	/**
	 * Get command list
	 *
	 * @return array
	 */
	public static function getList() {
		return self::$_commands;
	}

	/**
	 * Get command lower name and throw exception if command not present
	 *
	 * @param <type> $name
	 * @return <type>
	 */
	protected static function _getCommandLowerNameAndThrowIfNotPresent($name) {
		$lowerName = strtolower($name);

		if (!isset(self::$_commands[$lowerName])) {
			throw new Zaebator_Exception("Command '$name' not found");
		}

		return $lowerName;
	}

}