<?php include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header ("Location: index.php");
}

$album = new Album($con, $albumId);
$artist = $album->getArtist();
$artistId = $artist->getID();
?>

<!-- Album information Section -->
<div class="entityInfo">
	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
</div>

<div class="rightSection">
	<h2><?php echo $album->getTitle(); ?></h2>
		<p role="link" tabindex="0" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getSongCount(); ?></p>
</div>
<!-- End of Album information Section -->

<!-- Track List Container Section -->
<div class="tracklistContainer">
	<ul class="trackList">

		<?php

		$songIdArray = $album->getSongIDs();

		$i = 1;
		foreach ($songIdArray as $songId) {

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
<!-- End of Track List Container Section -->

<!-- Hidden check for user logged in to get user playlists -->
<nav class="optionsMenu">
	<input  type="hidden" class="songId">
	<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
