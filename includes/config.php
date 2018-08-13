<?php
/*
|-----------------------------------------------------------------------------------------
| Mino config code
|-----------------------------------------------------------------------------------------
|
| disconnects and starts session
| sets timezone
| sets databse connection credentials
|
| @author Fru Emmnauel hello@fruemmanuel.com
|
*/
	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Africa/Douala");

	$con = mysqli_connect("localhost", "root", "", "minodb");

	if(mysqli_connect_errno()) {
		echo "Failed to connect:" . mysqli_connect_errno();
	}


 ?>
