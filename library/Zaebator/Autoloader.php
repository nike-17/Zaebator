<?php

class Zaebator_Autoloader {

	/**
	 * Is registered Zaebator autoload
	 *
	 * @var boolean
	 */
	protected static $_isRegistered;

	/**
	 * Zaebator path
	 *
	 * @var string
	 */
	protected static $_zaebatorPath;

	/**
	 * Autoload callback
	 *
	 * @var array
	 */
	protected static $_callback = array('Zaebator_Autoloader', 'load');

	/**
	 * Register Zaebator autoload
	 *
	 * @param boolean $prepend Prepend the autoloader in the chain, the default is
	 *                         'false'. This parameter is available since PHP 5.3.0
	 *                         and will be silently disregarded otherwise.
	 * @return boolean
	 */
	public static function register($prepend = false) {
		if (self::isRegistered()) {
			return false;
		}
		if (!is_bool($prepend)) {
			$prepend = (bool) $prepend;
		}

		if (version_compare(PHP_VERSION, '5.3.0', '<')) {
			self::$_isRegistered = spl_autoload_register(self::$_callback);
		} else {
			self::$_isRegistered = spl_autoload_register(
					self::$_callback, true, $prepend
			);
		}
		return self::$_isRegistered;
	}

	/**
	 * Unregister Zaebator autoload
	 *
	 * @return boolean
	 */
	public static function unregister() {
		if (!self::isRegistered()) {
			return false;
		}

		self::$_isRegistered = !spl_autoload_unregister(self::$_callback);

		return self::$_isRegistered;
	}

	/**
	 * Is Zaebator autoload registered
	 *
	 * @return boolean
	 */
	public static function isRegistered() {
		return self::$_isRegistered;
	}

	/**
	 * Load class
	 *
	 * @param string $className
	 *
	 * @return boolean
	 */
	public static function load($className) {
		if (0 !== strpos($className, 'Zaebator')) {
			return false;
		}

		$path = self::getZaebatorPath() . '/' . str_replace('_', '/', $className) . '.php';

		return include $path;
	}

	/**
	 * Get Zaebator path
	 *
	 * @return string
	 */
	public static function getZaebatorPath() {
		if (!self::$_zaebatorPath) {
			self::$_zaebatorPath = realpath(dirname(__FILE__) . '/..');
		}

		return self::$_zaebatorPath;
	}

}
