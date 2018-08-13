<?php
include("includes/includedFiles.php");
?>

<div class="userDetails">
<!-- Email Update Section -->
  <div class="container borderBottom">
    <h2>EMAIL</h2>
    <input type="text" name="email" class="email" placeholder="Email address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
    <span class="message"></span>
    <button class="button black" onclick="updateEmail('email')">SAVE</button>
  </div>
<!-- End Of Email Update Section -->

<!-- Password Update Section -->
  <div class="container">
    <h2>PASSWORD</h2>
    <input type="password" name="oldPassword" class="oldPassword" placeholder="Current password">
    <input type="password" name="newPassword1" class="newPassword1" placeholder="New password">
    <input type="password" name="newPassword2" class="newPassword2" placeholder="Confirm password">
    <span class="message"></span>
    <button class="button black" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button>
  </div>
<!-- End Of Password Update Section -->
</div>
