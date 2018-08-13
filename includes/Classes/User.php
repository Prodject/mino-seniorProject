<?php
	class User {

	/**
	* User Class
	* Returns user information from database
	*/

		private $con;
    private $username;
		//private $profilePicture;

		public function __construct($con, $username){
			$this->con = $con;
      $this->username = $username;
		//	$this->profilePicture = $profilePicture;
		}

    public function getUsername() {
      return $this->username;
    }

		public function getEmail() {
			$query = mysqli_query($this->con, "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

		public function getName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}

		public function getProfilePicture() {
			$query = mysqli_query($this->con, "SELECT profilePic FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['profilePic'];
		}
	}

 ?>
