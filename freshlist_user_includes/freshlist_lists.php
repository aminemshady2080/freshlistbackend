<?php
	require_once 'db_connect.php';
	$db = new Db_connect();
	$db -> connect_toDb();
	
	$response = array();

// check for required fields
if (isset($_POST['list_name']) && isset($_POST['list_timestamp']) && isset($_POST['list_service'])&& isset($_POST['list_schedule'])) {
    
    $list_name = $_POST['list_name'];
    $list_timestamp = $_POST['list_timestamp'];
    $list_service = $_POST['list_service'];
	$list_schedule = $_POST['list_schedule'];

    // inserting a new list
    $result = mysql_query("INSERT INTO lists(`list_name`, `list_timestamp`, `list_service`,`list_schedule`)
	VALUES
	('$list_name', '$list_timestamp', '$list_service','$list_schedule')")
	or die("no data in lists table entered caused by " . mysql_error());

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "list successfully created";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "error inserting list";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
	}
	
?>