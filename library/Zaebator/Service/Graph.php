<?php

class Zaebator_Service_Graph {

	public static function getGraphImageById(Zaebator $zaebator, $graphid, $period = 3600, $width = 1200) {
		
		$filename_cookie =  "zabbix_cookie_" . $graphid . ".txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $zaebator->getOption('urlIndex'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$post_data = array(
			'name' => $zaebator->getOption('user'),
			'password' => $zaebator->getOption('password'),
			'enter' => 'Enter'
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $filename_cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $filename_cookie);

		// Login
		curl_exec($ch);

		// Fetch image
		// &period= the time, in seconds, of the graph (so: value of 7200 = a 2 hour graph to be shown)
		// &stime= the time, in PHP's time() format, from when the graph should begin
		// &width= the width of the graph, small enough to fit on mobile devices

		curl_setopt($ch, CURLOPT_URL, $zaebator->getOption('urlGraph') . "?graphid=" . $graphid . "&width=".$width."&period=" . $period);
		$output = curl_exec($ch);

		// Close session
		curl_close($ch);


		// Return the image
		return $output;
	}

}