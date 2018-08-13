<?php
include("includes/includedFiles.php");

 ?>

 <div class="entityInfo">
   
<!-- User Information Section -->
   <div class="centerSection">
     <div class="userInfo">
       <img src="<?php echo $userLoggedIn->getProfilePicture(); ?>" alt="Display Image" class="profilePic ">
       <h1><?php echo $userLoggedIn->getName(); ?></h1>
     </div>
   </div>
<!-- End Of User Information Section -->

<!--User Options Section -->
   <div class="buttonItems">
     <button class="button black" onclick="openPage('userDetails.php')">USER DETAILS</button>
     <button class="button black" onclick="logOut()">LOGOUT</button>
   </div>
<!-- End Of User Options Section -->
 </div>
