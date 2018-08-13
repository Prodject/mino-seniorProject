/**
* Acts on register.php page only
* Displays login form while hiding registration form and vise versa when link clicked
*/

$(document).ready(function() {

	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#registerForm").show();
	});

	$("#hideRegister").click(function() {
		$("#loginForm").show();
		$("#registerForm").hide();
	});
});
