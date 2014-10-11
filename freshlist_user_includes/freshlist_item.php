<?php
	require_once 'db_connect.php';
	$db = new Db_connect();
	$db -> connect_toDb();
	
	$response = array();

// check for required fields
if (isset($_POST['item_name']) && isset($_POST['item_note']) && isset($_POST['item_list'])) {
    
    $item_name = $_POST['item_name'];
    $item_note = $_POST['item_note'];
    $item_list = $_POST['item_list'];

    // inserting a new item
    $result = mysql_query("INSERT INTO item(`item_name`, `item_note`, `item_list`) VALUES('$item_name', '$item_note', '$item_list')");

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Item successfully sent";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "error iserting item";
        
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