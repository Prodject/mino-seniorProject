
<?php
/*
|-----------------------------------------------------------------------------------------
| Mino Music Player Bar code
|-----------------------------------------------------------------------------------------
|
| contains AJAX calls and fuctions for the musci player
| random playlist of songs is loaded from here
| encodes php database $resultArray as $jsonArray to be used in javascript
| incline comments for fucntionalities which are not clear at a glance
|
| @author Fru Emmnauel hello@fruemmanuel.com
|
*/

// loads 10 random songs from database and encodes the result using JSON
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}

 $jsonArray = json_encode($resultArray);

 ?>

 <script>
 // $jsonArray is parsed in javascript and new random playlist created
 $(document).ready(function() {
 	var newPlaylist = <?php echo $jsonArray; ?>;
 	audioElement = new Audio();
 	setTrack(newPlaylist[0], newPlaylist, false);
 	updateVolumeProgressBar(audioElement.audio);
//---------------------------------------------------------------------------------------------------

// using mousedown, mousemove and mouseup to slide through time on currrently playing song and volume
 	$("nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function() {
 		e.preventDefault();
 	});

 	$(".playbackBar .progressBar").mousedown(function() {
 		mouseDown = true;
 	});

 	$(".playbackBar .progressBar").mousemove(function(e) {
 		if(mouseDown) {

 			timeFromOffset(e, this);
 		}
 	});

 	$(".playbackBar .progressBar").mouseup(function(e) {
 		timeFromOffset(e, this);
 	});

 	$(".volumeBar .progressBar").mousedown(function() {
 		mouseDown = true;
 	});

 	$(".volumeBar .progressBar").mousemove(function(e) {
 		if(mouseDown) {
 			var percentage = e.offsetX / $(this).width();
 			audioElement.audio.volume = percentage; // if(percentage >= 0 && percentage <= 1) {} //Encapsulate in if in case of error
 		}
 	});

 	$(".volumeBar .progressBar").mouseup(function(e) {
 		var percentage = e.offsetX / $(this).width();
 		audioElement.audio.volume = percentage;
 	});

 	$(document).mouseup(function() {
 		mouseDown = false;
 	});
 });
//------------------------------------------------------------------------------------------------------------------

// sets new time on currently playing song depending on where mouse action was
 function timeFromOffset(mouse, progressBar) {
 	var percentage = mouse.offsetX / $(progressBar).width() * 100;
 	var seconds = audioElement.audio.duration * (percentage / 100);
 	audioElement.setTime(seconds);
 }

// goes to previous song on the current playing
 function prevSong() {
 	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
 		audioElement.setTime(0);
 	}
 	else {
 		currentIndex = currentIndex - 1;
 		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
 	}
 }

// goes to the next song on current playlist
 function nextSong() {

 	if(repeat == true) {
 		audioElement.setTime(0);
 		playSong();
 		return;
 	}

 	if(currentIndex == currentPlaylist.length - 1) {
 		currentIndex = 0;
 	}
 	else {
 		currentIndex++;
 	}

 	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
 	setTrack(trackToPlay, currentPlaylist, true);
 }

// continously loop through the same song
 function setRepeat() {
 	repeat = !repeat;
 	var imageName = repeat ? "repeat-active.png" : "repeat.png";
 	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
 }

// set mute option by clicking volume icon
  function setMute() {
 	audioElement.audio.muted = !audioElement.audio.muted;
 	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
 	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
 }

// set shuffle option on current playlist
   function setShuffle() {
 	shuffle = !shuffle;
 	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
 	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

 	if(shuffle) {
 		//make playlist random
 		shuffleArray(shufflePlaylist);
 		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

 	}
 	else {
 		//go back to ordered playlist
 		urrentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
 	}
 }

// randomise a playlist so as to create shuffle effect
 function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
}

// create new playlist which can be shuffled, set track and pause
function setTrack(trackId, newPlaylist, play) {

	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}
	if(shuffle){
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}

	pauseSong();

// ajax call to get song title
	$.post("includes/handlers/ajax/getSongJSON.php", { songId: trackId}, function(data) {
		var track = JSON.parse(data);
		$(".trackName span").text(track.title);

// ajax call to get artistname and set onclick event to artist page
	$.post("includes/handlers/ajax/getArtistJSON.php", { artistId: track.artist}, function(data) {
		var artist = JSON.parse(data);
		$(".trackInfo .artistName span").text(artist.name);
		$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
	});

// ajax call to get album artwork and track name and set onlick event to album page
	$.post("includes/handlers/ajax/getAlbumJSON.php", { albumId: track.album}, function(data) {
		var album = JSON.parse(data);
		$(".content .albumLink img").attr("src", album.artworkPath);
		$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
		$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
	});


		audioElement.setTrack(track);

		if(play) {
		playSong();
	}

	});

}
// play current song and change pause icon to play icon
function playSong() {
	if (audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
	}

	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

// pause currently playing song and change play icon to pause icon
function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}

 </script>



<div id="nowPlayingContainer">

		<div id="nowPlayingBar">

			<div id="nowPlayingLeft">

				<div class="content">
					<span class="albumLink">
						<img role="link" tabindex="0" src="" class="albumArtwork">
					</span>

					<div class="trackInfo">
						<span class="trackName">
							<span role="link" tabindex="0"></span>
						</span>

						<span class="artistName">
							<span role="link" tabindex="0"></span>
						</span>
					</div>
				</div>

			</div>

			<div id="nowPlayingCenter">

				<div class="content playerControls">

					<div class="buttons">

						<button class="controlButton shuffle" title="Shuffle Button">
							<img src="assets/images/icons/shuffle.png" alt="Shuffle" onclick="setShuffle()">
						</button>

						<button class="controlButton previous" title="Previous Button" onclick="prevSong()">
							<img src="assets/images/icons/previous.png" alt="Previous">
						</button>

						<button class="controlButton play" title="Play Button" onclick="playSong()">
							<img src="assets/images/icons/play.png" alt="Play">
						</button>

						<button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
							<img src="assets/images/icons/pause.png" alt="Pause">
						</button>

						<button class="controlButton next" title="Next Button" onclick="nextSong()">
							<img src="assets/images/icons/next.png" alt="Next">
						</button>

						<button class="controlButton repeat" title="Repeat Button" onclick="setRepeat()">
							<img src="assets/images/icons/repeat.png" alt="Repeat">
						</button>

					</div>

					<div class="playbackBar">

						<span class="progressTime current">0.00</span>

						<div class="progressBar">
							<div class="progressBarBG">
								<div class="progress"></div>
							</div>
						</div>

						<span class="progressTime remaining">0.00</span>

					</div>

				</div>

			</div>

			<div id="nowPlayingRight">

				<div class="volumeBar">

					<button class="controlButton volume" title="Volume Button" onclick="setMute()">
						<img src="assets/images/icons/volume.png" alt="Volume">
					</button>

					<div class="progressBar">
							<div class="progressBarBG">
								<div class="progress"></div>
							</div>
					</div>

				</div>

			</div>

		</div>

	</div>
