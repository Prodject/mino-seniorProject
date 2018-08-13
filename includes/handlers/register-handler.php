<?php
/**
* carries out data normalisation on registration form
* if data is in norm, user is registered and redirect to index.php page
*/
function sanitizeFormUsername($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormPassword($inputText){
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormString($inputText){
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = ucfirst(strtolower($inputText));
	return $inputText;
}



if (isset($_POST['registerButton'])) {
	//Register button pressed

	$username = sanitizeFormUsername($_POST['username']);
	$firstName = sanitizeFormString($_POST['firstName']);
	$lastName = sanitizeFormString($_POST['lastName']);
	$email = sanitizeFormString($_POST['email']);
	$confirmEmail = sanitizeFormString($_POST['confirmEmail']);
	$password = sanitizeFormPassword($_POST['password']);
	$confirmPassword = sanitizeFormPassword($_POST['confirmPassword']);

	$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $confirmEmail, $password, $confirmPassword);

	if($wasSuccessful == true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}


}

 ?>
