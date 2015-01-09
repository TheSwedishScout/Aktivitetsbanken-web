<?php
	//include "javaScript/jwt_helper.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Aktivitetsbank TEST</title>
<link rel="stylesheet" href="styles/style.css">
</head>

<body>
<?php
 //visa alla activiteter i en kategori.
	$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$url="http://devscout.mikaelsvensson.info:10081/api/v1/favourites ";
	$contents = file_get_contents($url); 
	$results = json_decode($contents); 
	
	
	
	$key = "07f2e0edb17cd1bba91be67ca2b7343428c973a7";
	$token = array(
		"iss" => "http://devscout.mikaelsvensson.info:10081/api/v1/favourites",
		"aud" => "http://devscout.mikaelsvensson.info:10081/api/v1/favourites",
		"iat" => 1356999524,
		"nbf" => 1357000000
	);
	
	$jwt = JWT::encode($token, $key);
	$decoded = JWT::decode($jwt, $key);
	
	print_r($decoded);
	
	/*
	 NOTE: This will now be an object instead of an associative array. To get
	 an associative array, you will need to cast it as such:
	*/
	
	$decoded_array = (array) $decoded;
	print_r ($results);
		
?>
</body>
</html>