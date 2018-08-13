/*
|-----------------------------------------------------------------------------------------
| Mino Main JavaScript Code
|-----------------------------------------------------------------------------------------
|
| This .js file contains all the main javascript used in the web music player app
| All music player functionalities are coded here
| Page dynamism and load behavior is equally all coded here
| Functions which are no clear at a glance are further explained in detail side comments
| examples include openPage(), audio(), showOptionsMenu(), createPlaylist()...
| All jQuery methods to handle the applications event are coded in this file
|
| @author Fru Emmnauel hello@fruemmanuel.com
|
*/

// Setting variables

var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;



/**
  *Javascript function for seamless page transition by swapping mainContent
  * For this to work all anchor tag links are changed to onlick links
  * The pages never really reload, just the mainContent is swapped
  * The scroll postion is set to 0 -- top of page
*/
function openPage(url) {
	if(timer != null) {
		clearTimeout(timer);
	}
	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);             // encodes userLoggedIn in URL
	//console.log(encodedUrl);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);

	//openPagePushState(url);
	history.pushState(null, null, url);
}

// jQueury method to change menu navItemLink class to active
$(document).ready(function() {
  $('ul li a').click(function() {
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});

//Javascript method to move between back and forward browser histony buttons while maintaining userLoggedIn
window.addEventListener("popstate", function() {
  var url = location.href;
  openPagePushState(url);
})
function openPagePushState(url) {
  if(timer !== null) {
    clearTimeout(timer);
  }
  if(url.indexOf("?") === -1) {
    url = url + "?";
  }
  var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
  $("#mainContent").load(encodedUrl);
  $("body").scrollTop(0);
}
// END-OF PAGE SEAMLESS TRANSTION FUCNTIONS |-----------------------------------------------------


/*
|--------------------------------------------------------------------------------------------------
* Playlist jQuery methods and  AJAX call functions
* createPlaylist() -- creates a new playlist by displaying popup to prompt for playlist name
@requires createPlaylist.php
* deletePlaylist() -- deletes a certain playlist with popup to confirm
@requires deletePlaylist.php
*deleteFromPlaylist() -- deletes a certain song from a certain playlist
@requires deleteFromPlaylist.php
|---------------------------------------------------------------------------------------------------
*/

function createPlaylist() {
	var popup = prompt("Please enter the name of your playlist");
	if(popup != null) {

		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {

			if(error != "") {
					alert(error);
					return;
			}
				openPage("your-music.php");
		});
	}
}

function deletePlaylist(playlistId) {
		var prompt = confirm('Are you sure you want to delete this playlist?');

		if(prompt) {
			$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
			.done(function(error) {

				if(error != "") {
						alert(error);
						return;
				}
					openPage("your-music.php");
			});
		}
}

function deleteFromPlaylist(button, playlistId) {
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/deleteFromPlaylist.php", { playlistId: playlistId, songId: songId })
	.done(function(error) {

		if(error != "") {
				alert(error);
				return;
		}
			openPage("playlist.php?id=" + playlistId);
	});
}

// jQuery method to add select song to specific playlist
$(document).on("change", "select.playlist", function() {
		var select = $(this);
		var playlistId = select.val();
		var songId = select.prev(".songId").val();

		//console.log("playlistId: " + playlistId);
		//console.log("songId: " + songId);

		$.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
		.done(function(error) {

			if(error != "") {
					alert(error);
					return;
			}

			 hideOptionsMenu();
			 select.val("");
		});
});

// END OF PLAYLIST AJAX CALLS and jQuery METHODS |-----------------------------------------------------


/**
|-------------------------------------------------------------------------------------------------------
* js functions to display and hide optionsMenu
* showOptionsMenu - dispays optionsMenu at a specific location besides menu button when clicked
* hideOptionsMenu - hides options menu
|-------------------------------------------------------------------------------------------------------
*/

function showOptionsMenu(button) {
	var songId = $(button).prev(songId).val();
	var menu = $(".optionsMenu");
	var menuWidth = menu.width();
	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop();                                         // distance from window top to document top
	var elementOffset = $(button).offset().top;                                    // distance from document
	var top = elementOffset - scrollTop;
	var left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline"});

}

function hideOptionsMenu() {
	var menu = $(".optionsMenu");

	if(menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

// jQuery method to hide the optionsMenu upon mouse click away from menu
$(document).click(function(click) {
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
		hideOptionsMenu();
	}
});

// jQuery method to hide the optionsMenu upon mouse action on scrol bar
$(document).scroll(function() {
	hideOptionsMenu();
});
// END OF optionsMenu FUNCTIONS |------------------------------------------------------------------

/**
|--------------------------------------------------------------------------------------------------
*Web music player functions
*handles all the music player functionalities
*in-line comments next to each functionality
*new fucntionalities added in version 2.0
|--------------------------------------------------------------------------------------------------
*/

// converts the default display of song's time in seconds to the standard format of 'minutes:second'(00:oo)
function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - minutes * 60;

	var extraZero;

	if(seconds < 10) {
		extraZero = "0";
	}
	else {
		extraZero = "";
	}

	//var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

// allow user to skip to any point in time during song by clicking at any postion on progressBar
function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

// allow user to change volume by clicking on any postion of volumeBar
function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

// plays the first song in the temporal random playlist
function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

// creates the audio() function on which all other music player functions can act
function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);

	});

	this.audio.addEventListener("timeupdate", function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
}
// END-OF MUSIC PLAYER FUCNTIONS |----------------------------------------------------------------

/**
|-------------------------------------------------------------------------------------------------
*User details update AJAX CALLS
*updateEmail @require updateEmail.php
*updatePassword @require updatePassword.php
*All self descriptive
|-------------------------------------------------------------------------------------------------
*/

function updateEmail(emailClass) {
	var emailValue = $("." + emailClass).val();

	$.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
	.done(function(response) {
		$("." + emailClass).nextAll(".message").text(response);
	});

}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
	var oldPassword = $("." + oldPasswordClass).val();
	var newPassword1 = $("." + newPasswordClass1).val();
	var newPassword2 = $("." + newPasswordClass2).val();

	$.post("includes/handlers/ajax/updatePassword.php",
	{ oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username: userLoggedIn }).done(function(response) {
		$("." + oldPasswordClass).nextAll(".message").text(response);
	})

}
// END-OF USER DETAILS UPDATE FUCNTIONS |-----------------------------------------------------------------

//logOut ajax call fucntion @require logOut.php
function logOut() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	});
}
// END-OF SCRIPT }-------------------------------------------------------------------------------------------
