<?php
/*
|-----------------------------------------------------------------------------------------
| Mino Main Page Header Code
|-----------------------------------------------------------------------------------------
|
| this php code houses the header information used in the web music player app
| checks for user logged in and redirects to register.php if not
| all classes are required
| could not use includedFiles.php as header.php itself is included there
|
| @author Fru Emmnauel hello@fruemmanuel.com
|
*/

include("includes/config.php");
include("includes/classes/User.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Playlist.php");

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
	$username = $userLoggedIn->getUsername();
	echo "<script>userLoggedIn = '$username';</script>";
}
else {
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Mino - The True Sound of Music !</title>
	<meta name="Mino Web Player" content="The True Sound of Music">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="icon" type="image/png" href="assets/images/icons/favicon.png" sizes="32x32">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">
