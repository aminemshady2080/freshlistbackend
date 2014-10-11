<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
if (isset($_POST['tag']) && $_POST['tag'] != '') {
	$tag = $_POST['tag'];
	require_once 'freshlist_includes/db_handler.php';

	$dbhandler = new Db_handler();
	$responseArray = array("tag" => $tag, "success" => 0, "error" => 0);

	///check if user sent a tag to sign up and return a json responce
	if ($tag == 'signup') {
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$mail_message = "Hi $email nnThank You so much for signup for freshlist delivery services nnFrom Arkham.com/freshlist";
		$mail_subject = "Successfull signup on Freshlist";
		$from = "staff@Arkham.com";
		$mail_head = "From :" . $from;
		if ($dbhandler -> userAlreadyExist($email) == 1) {
			$responseArray["error"] = 2;
			$responseArray["error_message"] = "User Already Existed";
			echo json_encode($responseArray);
		} else {
			//then here user can be entered in db
			$user = $dbhandler -> signup($email, $phone);
			if ($user) {
				$responseArray["success"] = 1;
				$responseArray["email"] = $user["email"];
				$responseArray["phone"] = $user["phone"];
				//mail($email, $mail_subject, $mail_message, $mail_head);
				echo json_encode($responseArray);

			} else {
				$responseArray["error"] = 1;
				$responseArray["error_message"] = "Error in signing user in db";
				echo json_encode($responseArray);
			}
		}

	}////end of signup besiness
	if ($tag == 'signupAuth') {
		$email = $_POST['email'];
		$username = $_POST['username'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$mail_message = "Hi $email nnThank You so much for signup for freshlist delivery services nnFrom Arkham.com/freshlist";
		$mail_subject = "Successfull signup on Freshlist";
		$from = "staff@Arkham.com";
		$mail_head = "From :" . $from;
		if ($dbhandler -> userAlreadyExist($email) == 1) {
			$responseArray["error"] = 2;
			$responseArray["error_message"] = "User Already Existed";
			echo json_encode($responseArray);
		} else {
			//then here user can be entered in db
			$user = $dbhandler -> signup($email, $phone);
			if ($user) {
				$responseArray["success"] = 1;
				$responseArray["email"] = $user["email"];
				$responseArray["username"] = $user["username"];
				//mail($email, $mail_subject, $mail_message, $mail_head);
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