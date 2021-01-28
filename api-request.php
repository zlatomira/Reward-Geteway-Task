<?php

// send the get request to the API
function get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_ENCODING, "");
	curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_TIMEOUT, 0);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json ','Content-Type: application/json','Authorization: Basic aGFyZDpoYXJk'));
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

?>
