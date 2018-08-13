<!-- Start of Navigation Bar Container -->
<div id="navBarContainer">
	<nav class="navBar">

		<div class="navBar-expand">
			<span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
				<img src="assets/images/icons/logo.png">
			</span>

			<div>
				<ul class="navItems">
					<div class="navItem">
						<li><a class="navItemLink" onclick="openPage('search.php')">Search
							<img src="assets/images/icons/search.png" class="icon" alt="Search">
						</a></li>
					</div>
					<div class="navItem">
						<li><a class="navItemLink" onclick="openPage('browse.php')">Browse
							<img src="assets/images/icons/home.png" class="icon" alt="Search">
						</a></li>
					</div>
					<div class="navItem">
						<li><a class="navItemLink" onclick="openPage('your-music.php')">Your Library
							<img src="assets/images/icons/library.png" class="icon" alt="Search">
						</a></li>
					</div>
						<div class="sessionInfo">
							<div class="navItem">
							<li><a class="navItemLink" onclick="openPage('settings.php')"><?php echo $userLoggedIn->getUsername(); ?>
								<img src="<?php echo $userLoggedIn->getProfilePicture(); ?>" alt="user-image" class="icon">
							</a></li>
						</div>
						</div>
				</ul>
			</div>
		</div>

	</nav>

</div>
<!-- End of Navigation Bar Container -->
