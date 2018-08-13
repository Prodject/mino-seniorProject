<?php
include("includes/includedFiles.php");

//encode URL with search term
if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = "";
}

 ?>
<!-- Search Input Area -->
 <div class="searchContainer">
	 <div class="contentSpacing">
		<h4 class="searchBox-label">Search for an artist, song or album</h4>
 	 	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..." onfocus="var val=this.value; this.value=''; this.value= val;" spellcheck="false">
	 </div>
 </div>
 <!-- End Of Search Input Area -->

<script>
 	$(".searchInput").focus();
 	var timer;

 	$(".searchInput").keyup(function() {
 		clearTimeout(timer);
 		timer = setTimeout(function() {
 			var val = $(".searchInput").val();
 			openPage("search.php?term=" + val);
 		}, 1000);
 	});

 	$(".searchInput").focus();
</script>

 <?php if ($term == "") {
 	exit();
 } ?>

<!-- Song Search Result Container -->
 <div class="tracklistContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="trackList">

		<?php
		$songQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($songQuery) == 0) {
			echo "<span class='noResults'>No songs found matching " . $term . "</span>";
		}

		$songIdArray = array();

		$i = 1;
		while ($row = mysqli_fetch_array($songQuery)) {

			if($i > 15) {
				break;
			}

			array_push($songIdArray, $row['id']);

			$albumSong = new Song($con, $row['id']);
			$albumArtist = $albumSong->getArtist();

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getID() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistkName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getID() . 	"'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>

					</div>

				</li>";

			$i++;

		}

		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>

	</ul>
</div>
<!-- End Song Search Result Container -->

<!-- Artist Search Result Container -->
<div class="artistContainer borderBottom">

	<h2>ARTISTS</h2>

	<?php

	$artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10 ");

	if(mysqli_num_rows($artistQuery) == 0) {
		echo "<span class='noResults'>No artist found matching " . $term . "</span>";
	}

	while($row = mysqli_fetch_array($artistQuery)) {
		$artistFound = new Artist($con, $row['id']);

		echo "<div class='searchResultRow'>
				<div class='artistName'>

					<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getID() ."\")'>

					"
					. $artistFound->getName() .
					"
					</span>

				</div>

			</div>";
	}


	 ?>

</div>
<!-- End of Artist Search Result Container -->

<!-- Album Search Result Container -->
<div class="gridViewContainer">

	<h2>ALBUMS</h2>

	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($albumQuery) == 0) {
		echo "<span class='noResults'>No albums found matching " . $term . "</span>";
	}

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
<!-- End Album Search Result Container -->

<!-- Hidden check for user logged in to get user playlists -->
<nav class="optionsMenu">
	<input  type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
