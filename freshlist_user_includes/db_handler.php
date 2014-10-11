<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
class Db_handler {
	private $db;
	function __construct() {
		require_once 'db_connect.php';
		$this -> db = new Db_connect();
		$this -> db -> connect_toDb();
	}

	public function signup($username, $email, $password) {

		// now put user details in usertable into db
		$user_type = "customer";
		$freshsignup_query = "INSERT INTO user_auth (`username`,`email`,`password`) VALUES ('$username','$email','$password')";
		$freshsignup_result = mysql_query($freshsignup_query) or die("no data entered caused by " . mysql_error());

		if ($freshsignup_result) {

			$freshsignup_query = "SELECT * FROM user_auth WHERE username = '$username'";
			$freshsignup_result = mysql_query($freshsignup_query);
			//now send user details to main freshlist
			return mysql_fetch_array($freshsignup_result);

		} else {
			return false;
		}

	}// end of signup function

	//now let log user in
	public function login($email) {
		$freshlogin_result = mysql_query("SELECT * FROM user_auth WHERE email = '$email'") or die(mysql_error());
		// check for result
		$number_of_rows = mysql_num_rows($freshlogin_result);
		$tag = "login";

		if ($number_of_rows > 0) {

			$a = mysql_fetch_array($freshlogin_result);
			$user = array();
			$responce["user"] = array();
			$user["email"] = $a["email"];
			$user["username"] = $a["username"];
			$user["password"] = $a["password"];
			$user["date_joined"] = $a["date_joined"];
			$user["success"] = 1;
			$user["tag"] = "login";
			$user["error"] = 0;

			array_push($responce["user"], $user);

			//right user authenticated

			return json_encode($responce);

		} else {

			$user = array();
			$responce["user"] = array();
			$user["email"] = "";
			$user["join_date"] = "";
			$user["success"] = 0;
			$user["tag"] = "login";
			$user["error"] = 1;
			$user["error_message"] = "\t incorrect email \n user with this email is not found";

			array_push($responce["user"], $user);

			//right user authenticated

			return json_encode($responce);
		}
		//return $responce["user"];
	}//e nd of login function

	//now let check if this new user has already signed in before using this email
	public function userAlreadyExist($username) {
		$fresh_user_exist_result = mysql_query("SELECT username FROM user_auth WHERE username = '$username'") or die(mysql_error());
		$number_of_rows = mysql_num_rows($fresh_user_exist_result);
		//	echo $number_of_rows;
		//echo json_encode(array_push($result, $number_of_rows));
		if ($number_of_rows > 0) {
			// user signed in using this email before
			return 1;
		} else {
			// user not signed so is new user he can signup
			return 0;
		}
	}public function emailAlreadyExist($email) {
		$fresh_user_exist_result = mysql_query("SELECT email FROM user_auth WHERE email = '$email'") or die(mysql_error());
		$number_of_rows = mysql_num_rows($fresh_user_exist_result);
		//	echo $number_of_rows;
		//echo json_encode(array_push($result, $number_of_rows));
		if ($number_of_rows > 0) {
			// user signed in using this email before
			return 1;
		} else {
			// user not signed so is new user he can signup
			return 0;
		}
	}

}
?>