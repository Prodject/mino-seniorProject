<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistId = $_GET['id'];
}
else {
	header ("Location: index.php");
}
// creates new isntance of Artist class
$artist = new Artist($con, $artistId);

?>

<!-- Artist Header Section -->
<header class="artistHeader" style="background-image: url('assets/images/artist-header.jpg');">
	<div class="entityInfo">
	<div class="centerSection">
		<div class="artistInfo">
			<h1 class="artistName"> <?php echo $artist->getName(); ?> </h1>
			<div class="headerButtons">
				<button class="button green" onclick="playFirstSong()">PLAY</button>
			</div>
		</div>
	</div>
</div>
</header>
<!-- End Of Artist Header Section -->

<!-- Tracklist Container Section-->
<div class="tracklistContainer borderBottom">
	<h2>songs</h2>
		<ul class="trackList">

		<?php

		$songIdArray = $artist->getSongIDs();

		$i = 1;
		foreach ($songIdArray as $songId) {

			if($i > 5) {
				break;
			}

			$albumSong = new Song($con, $songId);
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
<!-- End Of Tracklist Container Section -->

<!-- Grid View Container Section -->
<div class="gridViewContainer">

	<h2>albums</h2>

	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

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
<!-- End Of Grid View Container Section -->

<!-- Hidden check for user logged in to get user playlists -->
<nav class="optionsMenu">
	<input  type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
