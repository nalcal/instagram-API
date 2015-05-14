<?php

//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);

session_start();

//Make Constant using define.
define('clientID', '31197fed7f9e44b9a89555d336819848');
define('clientSecret', '13131ef5975543f89af94cde7a805535');
define('redirectURI', 'http://localhost/apinalitha/index.php');
define('ImageDirectory', 'pics/');

//function that is going to connect to instagram
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
		));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
//function to get userID cause userName doesnt allow to get pictures
function getUserID($username){
	$url = 'http://api.instagram.com/v1/users/search?q='.$userName.'&client_id='.clientID;
	$instagramINFO = connectToInstagram($url);
	$results = json_decode($instagramINFO, true);

	return $results['data']['0']['id'];
}
//function to print out images onto screen
function printImages($userID){
	$url = 'http://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=5';
	$instagramINFO = connectToInstagram($url);
	$results = json_decode($instagramINFO, true);
	//parse through the information one by one
	foreach($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url'];
		echo '<img src=" '.$image_url.' "/><br/>';
	}
}

if (isset($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
									'client_secret' => clientSecret,
									'grant_type' => 'authorization_code',
									'redirect_uri' => redirectURI,
									'code' => $code
									);
	// a curl is what we use in php, it is a library calls to other api
	$curl = curl_init($url);//setting a curl session and we put in URL
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($username);

printImages($userID);
}
else{
?>

<!DOCTYPE html>
<html>
	<head>
	<title> </title>
</head>
	<body>
		<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">Login</a>
		
	</body>
</html>
<?php  
}
?>
