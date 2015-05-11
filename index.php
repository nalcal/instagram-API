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
