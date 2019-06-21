<?php

function getApiUsers($authToken) {

	$apiUsersUrl = 'http://0.0.0.0:8888/users';
	$ch = curl_init();

	print 'Auth Token: '. $authToken ."\r\n";
	$checksum = hash('sha256', ($authToken . "/users"));

	$headers = [ 
		'X-Request-Checksum: '. $checksum
	];

	curl_setopt($ch, CURLOPT_URL,$apiUsersUrl);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);
	return $result;
}

function getApiAuth() {
	$ch = curl_init();
	$apiAuthUrl = 'http://0.0.0.0:8888/auth';
	$result = get_headers($apiAuthUrl, 1);
	$theToken = $result['Badsec-Authentication-Token'];
	return $theToken;
}

$authToken = getApiAuth();
$users = null;
while ($users == null) {
	echo "doing it \r\n";
	$users = getApiUsers($authToken);
}
$users = json_decode(json_encode($users));
echo $users;
// EOF
