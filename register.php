<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset ($_POST[$name])) {
			echo $_POST[$name];
		}
	}

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Mino Web Player</title>
	<meta name="Mino Web Player" content="The True Sound of Music">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="icon" type="image/png" href="assets/images/icons/favicon.png" sizes="32x32">

	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php
// Script to hide or show either form when called
	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>

	<div id="background">
<!-- Login Container Section -->
		<div id="loginContainer">
			<div id="inputContainer">
				<div class="loginLogo">
					<img src="assets/images/loginLogo.png" alt="Mino Web Player">
				</div>

<!-- Login Form -->
				<form id="loginForm" action="register.php" method="POST">
						<h2>Login to Your Account</h2>
						<p>
							<?php echo $account->getError(Constants::$loginFailed); ?>
							<label for="loginUsername">User Name</label>
							<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g fruStoic" value="<?php getInputValue('loginUsername'); ?>" required="">
						</p>
						<p>
							<label for="loingPassword">Password</label>
							<input id="loginPassword" name="loginPassword" type="password" required="" placeholder="your password">
						</p>

						<button type="submit" name="loginButton">LOGIN</button>

						<div class="hasAccountText">
							<span id="hideLogin">Don't have account ? Sign-up here.</span>
						</div>
				</form>
<!-- End Of Login Form -->
<!-- Registration Form -->
				<form id="registerForm" action="register.php" method="POST">
						<h2>Sign-Up for an Account</h2>
						<p>
							<?php echo $account->getError(Constants::$userNameCharacters); ?>
							<?php echo $account->getError(Constants::$userNameTaken); ?>
							<label for="username">User Name</label>
							<input id="username" name="username" type="text" placeholder="e.g fruStoic" value="<?php getInputValue('username'); ?>" required="">
						</p>

						<p>
							<?php echo $account->getError(Constants::$firstNameCharacters); ?>
							<label for="firstName">First Name</label>
							<input id="firstName" name="firstName" type="text" placeholder="e.g Julius" value="<?php getInputValue('firstName'); ?>" required="">
						</p>

						<p>
							<?php echo $account->getError(Constants::$lastNameCharacters); ?>
							<label for="lastName">Last Name</label>
							<input id="lastName" name="lastName" type="text" placeholder="e.g Novachrono" value="<?php getInputValue('lastName'); ?>" required="">
						</p>

						<p>
							<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
							<?php echo $account->getError(Constants::$emailInvalid); ?>
							<?php echo $account->getError(Constants::$emailTaken); ?>
							<label for="email">Email</label>
							<input id="email" name="email" type="email" placeholder="e.g novachrono@holyknight.com" value="<?php getInputValue('email'); ?>" required="">
						</p>

						<p>
							<label for="confirmEmail">Confirm Email</label>
							<input id="confirmEmail" name="confirmEmail" type="email" placeholder="e.g novachrono@holyknight.com" value="<?php getInputValue('confirmEmail'); ?>" required="">
						</p>

						<p>
							<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
							<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
							<?php echo $account->getError(Constants::$passwordCharacters); ?>
							<label for="password">Password</label>
							<input id="password" name="password" required="" type="password" placeholder="your password">
						</p>

						<p>
							<label for="confirmPassword">Confirm Password</label>
							<input id="confirmPassword" name="confirmPassword" required="" type="password" placeholder="your password">
						</p>

						<button type="submit" name="registerButton">SIGN-UP</button>

						<div class="hasAccountText">
							<span id="hideRegister">Already have account ? Log-in here.</span>

						</div>
				</form>
<!-- End Of Registration Form -->
			</div>
<!-- End Of Login Container Section -->

<!-- Login Text Sectoin -->
				<div id="loginText">
					<h1>The true sound of music</h1>
					<h2>Listen to and have full control over millions of songs for free.</h2>
					<ul>
						<li>Search and discover music you'll love</li>
						<li>Create playlists of your favorite music</li>
					</ul>
				</div>
<!-- End Of Login Text Sectoin -->

		</div>
	</div>

</body>
</html>
