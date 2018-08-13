<?php include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header ("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());
?>

<div class="your-music">
<!-- Playlist Information Section -->
	<div class="entityInfo">
		<div class="leftSection">
	    <div class="playlistImage">
	      <img src="assets/images/icons/playlist.png">
	    </div>
		</div>

		<div class="rightSection">
			<h2><?php echo $playlist->getName(); ?></h2>
			<p>By <?php echo $playlist->getOwner(); ?></p>
			<p><?php echo $playlist->getSongCount(); ?> songs</p>
	    <button class="button green" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
		</div>
	</div>
<!-- End of Playlist Information Section -->

<!-- Tracklist Container Section -->
	<div class="tracklistContainer">
		<ul class="trackList">

			<?php

			$songIdArray = $playlist->getSongIDs();

			$i = 1;
			foreach ($songIdArray as $songId) {

				$playlistSong = new Song($con, $songId);
				$songArtist = $playlistSong->getArtist();

				echo "<li class='tracklistRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getID() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$i</span>
						</div>

						<div class='trackInfo'>
							<span class='trackName'>" . $playlistSong->getTitle() . "</span>
							<span class='artistkName'>" . $songArtist->getName() . "</span>
						</div>

						<div class='trackOptions'>
							<input type='hidden' class='songId' value='" . $playlistSong->getID() . 	"'>
							<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
						</div>

						<div class='trackDuration'>
							<span class='duration'>" . $playlistSong->getDuration() . "</span>

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

<!-- Hidden check for user logged in to get user playlists -->
	<nav class="optionsMenu">
		<input  type="hidden" class="songId">
		<?php echo Playlist::getPlaylistDropdown($con, $userLoggedIn->getUsername()); ?>
		<div class="item" onclick="deleteFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
	</nav>

</div>
