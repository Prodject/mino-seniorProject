<?php

/*
|-----------------------------------------------------------------------------------------
| Included files for all pages
|-----------------------------------------------------------------------------------------
|
| includes config files and class files
| checks for user logged in and redirects to register.php if not
| if user logged in, binds header and footer to load full page
| adds cross section content with openPage
|
| @author Fru Emmnauel hello@fruemmanuel.com
|
*/

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("includes/config.php");
	include("includes/classes/User.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");
	include("includes/classes/Playlist.php");

	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	}
	else {
		echo "username variable not passed into page. Check openPage JS";
	}
}
else {
	include("includes/header.php");
	include("includes/footer.php");

	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('$url')</script>";
	exit();
}

?>
