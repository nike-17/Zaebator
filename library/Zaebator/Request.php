<?php

class Zaebator_Request {

	/**
	 *
	 * @var Zaebator_Request
	 */
	protected static $_instance;

	/**
	 *
	 * @var Zaebator 
	 */
	protected $_zaebator;

	private function __construct(Zaebator $zaebator) {
		$this->_zaebator = $zaebator;
	}

	/**
	 *
	 * @param Zaebator $zaebator
	 * @return Zaebator_Request 
	 */
	public static function instance(Zaebator $zaebator) {
		if (self::$_instance == null || self::$_instance->getZaebator() != self::$_instance) {
			self::$_instance = new self($zaebator);
		}
		return self::$_instance;
	}

	/**
	 *
	 * @param string $data
	 * @param array $headers
	 * @return array 
	 */
	public function exec($data = '', $headers = array()) {
		$c = curl_init($this->_zaebator->getOption('url'));
		
		$headers[] = 'Content-Type: application/json-rpc';
		// Well, ok this one isn't, but it's good to conform (sometimes)
		$headers[] = 'User-Agent: Zaebator v' . Zaebator::PHPAPI_VERSION;

		$opts = array(
			CURLOPT_RETURNTRANSFER => true, // Allows for the return of a curl handle
			//CURLOPT_VERBOSE => true,          // outputs verbose curl information (like --verbose with curl on the cli)
			//CURLOPT_HEADER => true,           // In a verbose output, outputs headers
			CURLOPT_TIMEOUT => 30, // Maximum number of seconds to allow curl to process the entire request
			CURLOPT_CONNECTTIMEOUT => 5, // Maximm number of seconds to establish a connection, shouldn't take 5 seconds
			CURLOPT_SSL_VERIFYHOST => false, // Incase we have a fake SSL Cert...
			CURLOPT_SSL_VERIFYPEER => false, //    Ditto
			CURLOPT_FOLLOWLOCATION => true, // Incase there's a redirect in place (moved zabbix url), follow it automatically
			CURLOPT_FRESH_CONNECT => true	// Ensures we don't use a cached connection or response
		);

		// If we have headers set, put headers into our curl options
		if (is_array($headers) && count($headers)) {
			$opts[CURLOPT_HTTPHEADER] = $headers;
		}

		// This is a POST, not GET request
		$opts[CURLOPT_CUSTOMREQUEST] = "POST";
		$opts[CURLOPT_POSTFIELDS] = ( is_array($data) ? http_build_query($data) : $data );

		// This is useful, incase we're remotely attempting to consume Zabbix's API to compress our data, save some bandwidth
		$opts[CURLOPT_ENCODING] = 'gzip';


		// Go go gadget!  Do your magic!
		curl_setopt_array($c, $opts);
		$result = curl_exec($c);
		
		
		if(curl_error($c) != '') {
			throw new Zaebator_Exception('Connection error: ' . curl_error($c));
		}

		curl_close($c);
		return $result;
	}

	protected function getZaebator() {
		return $this->_zaebator;
	}

}