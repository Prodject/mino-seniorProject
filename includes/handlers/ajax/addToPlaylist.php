<?php
include("../../config.php");

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
  $playlistId = $_POST['playlistId'];
  $songId = $_POST['songId'];

  $orderIDQuery = mysqli_query($con, "SELECT MAX(playlistOrder) as playlistOrder FROM playlistSongs WHERE playlistId='playlistId'");
  $row = mysqli_fetch_array($orderIDQuery);
  $order = $row['playlistOrder'];

  $query = mysqli_query($con, "INSERT INTO playlistSongs VALUES('', '$songId', '$playlistId', '$order')");

}
else {
  echo "PlaylistId or songId was not passed into deletePlaylist.php";
}

?>
