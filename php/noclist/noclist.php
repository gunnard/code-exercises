<?php

function getApiUsers() {

	//Set users endpoint and initialize curl
	$baseUrl = 'http://0.0.0.0:8888';
	$endPoint = '/users';
	$apiUsersUrl = $baseUrl . $endPoint;
	$ch = curl_init();

	//Set authToken to null and attempt to 0;
	$authToken = '';
	$attempt = 0;

	//get the auth token
	//try 3 times
	while ($authToken == '' && $attempt <3 ){
		$authToken = getApiAuth();
		$attempt++;
	}
	unset($attempt);

	//If authToken exists, call users endpoint
	$result = null;
	$attempt = 0;
	if ($authToken) {
		$checksum = hash('sha256', ($authToken . "/users"));

		$headers = [ 
			'X-Request-Checksum: '. $checksum
		];

		curl_setopt($ch, CURLOPT_URL,$apiUsersUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		while ($result == null && $attempt <3) {
			$result = curl_exec($ch);
			$attempt++;
		}
		curl_close ($ch);
	} else {
		exit(1);
	}
	unset($authToken);
	unset($attempt);
	if ($result) {
		return $result;
	} else {
		exit(1);
	}
}

function getApiAuth() {
	//Set base url and endpoint
	$baseUrl = 'http://0.0.0.0:8888';
	$endPoint = '/auth';
	$apiAuthUrl = $baseUrl . $endPoint;

	//Get header information from url
	$result = get_headers($apiAuthUrl, 1);

	//if anything but '200 OK' then die
	if (preg_match("/200 OK/", $result[0])) {
		$theToken = $result['Badsec-Authentication-Token'];
		unset($result);
		return $theToken;
	} else {
		exit(1);
	}
}

//main call to getApiUsers
$users = getApiUsers();

//if conenction worked and users exist, explode on line break and json encode
if ($users) {
	$users = json_encode(explode("\n", $users));
	echo($users);
	exit(0);
} else {
	exit(1);
}
