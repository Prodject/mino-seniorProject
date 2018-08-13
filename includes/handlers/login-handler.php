<?php
/**
* checks login information upon clicking login button
* if information is true, logs user in and redirects to index.php
*/
if (isset($_POST['loginButton'])) {
	// Login button check
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}

	//login function
}
?>
