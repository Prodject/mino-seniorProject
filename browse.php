<?php

include("includes/includedFiles.php");

?>

<div class="browse">

<!-- Music You Might Like Section -->
	<h1 class="pageHeadingBig">Music You Might Like</h1>
	<div class="gridViewContainer">

		<?php
			$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

			while ($row = mysqli_fetch_array($albumQuery)) {


				echo "<div class='gridViewItem'>

						<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>

							<img src='" .$row['artworkPath'] . "'>

							<div class='gridViewInfo'>"
								. $row['title'] .
							"</div>

						</span>

					</div>";
			}

		 ?>
</div>
<!-- End Of Music You Might Like Section -->

<!-- Trending Artist Section -->
	<h1 class="pageHeadingBig">Trending Artists</h1>

	<div class="gridViewContainer">

		<?php
			$artistQuery = mysqli_query($con, "SELECT * FROM artists ORDER BY RAND() LIMIT 6");

			while ($row = mysqli_fetch_array($artistQuery)) {


				echo "<div class='gridViewItem2'>

						<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $row['id'] . "\")'>

							<img src='" .$row['artWork'] . "'>

							<div class='gridViewInfo'>"
								. $row['name'] .
							"</div>

						</span>

					</div>";
			}

		 ?>

	</div>
<!-- End Of Trending Artist Section -->
</div>
