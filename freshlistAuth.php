<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
if (isset($_POST['tag']) && $_POST['tag'] != '') {
	$tag = $_POST['tag'];
	require_once 'freshlist_user_includes/db_handler.php';

	$dbhandler = new Db_handler();
	$responseArray = array("tag" => $tag, "success" => 0, "error" => 0);

	///check if user sent a tag to sign up and return a json responce

	if ($tag == 'signup') {
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$mail_message = "Hi $username nnThank You so much for signup for freshlist delivery services nnFrom Arkham.com/freshlist";
		$mail_subject = "Successfull signup on Freshlist";
		$from = "staff@Arkham.com";
		$mail_head = "From :" . $from;
		if ($dbhandler -> userAlreadyExist($username) == 1) {
			$responseArray["error"] = 2;
			$responseArray["error_message"] = "Username Already Taken";
			echo json_encode($responseArray);
		} elseif ($dbhandler -> emailAlreadyExist($email) == 1) {
			$responseArray["error"] = 3;
			$responseArray["error_message"] = "Email Already Existed";
			echo json_encode($responseArray);
		} else {
			//then here user can be entered in db
			$user = $dbhandler -> signup($username, $email, $password);
			if ($user) {
				$responseArray["success"] = 1;
				$responseArray["email"] = $user["email"];
				$responseArray["username"] = $user["username"];
				$responseArray["password"] = $user["password"];
				$responseArray["error"] = 0;
				mail($email, $mail_subject, $mail_message, $mail_head);
				echo json_encode($responseArray);

			} else {
				$responseArray["error"] = 1;
				$responseArray["error_message"] = "Error in signing user in db";
				echo json_encode($responseArray);
			}
		}

	}////end of signup besiness

	//check if user wants to login and return a json responce
	if ($tag == 'login') {

		$email = $_POST['email'];
		$user = $dbhandler -> login($email);
		echo $user;

	}///end of login business

} else {
	$responseArray = array("error" => 0, "success" => 0);
	$responseArray["error"] = 3;
	$responseArray["success"] = 0;
	$responseArray["error_message"] = "Incorrect tag";

	echo json_encode($responseArray);
}
/*
 * if ($user != false) {
 $responseArray["success"] = 1;
 $responseArray["user"]["email"] = $user["email"];
 $responseArray["user"]["phone"] = $user["phone"];
 $responseArray["user"]["join_date"] = $user["join_date"];
 echo json_encode($responseArray);
 } else {
 $responseArray["error"] = 1;
 $responseArray["error_message"] = "Incorrect email";
 echo json_encode($responseArray);
 }
 *
 * */
?>