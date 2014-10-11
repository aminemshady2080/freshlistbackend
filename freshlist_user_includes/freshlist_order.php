<?php
	require_once 'db_connect.php';
	$db = new Db_connect();
	$db -> connect_toDb();
	
	$response = array();

// check for required fields
if (isset($_POST['order_contact']) && isset($_POST['order_timestamp'])  && isset($_POST['order_schedule']) && isset($_POST['order_status'])&& isset($_POST['order_listname'])) {
    
    $order_contact = $_POST['order_contact'];
    $order_timestamp = $_POST['order_timestamp'];
    $order_status = $_POST['order_status'];
	$order_listname = $_POST['order_listname'];
	$order_schedule = $_POST['order_schedule'];

    // inserting a new order
    $result = mysql_query("INSERT INTO order_table (`order_listname`, `order_contact`, `order_timestamp`,`order_schedule`, `order_status`)
	VALUES
	('$order_listname','$order_contact', '$order_timestamp', '$order_schedule', '$order_status')") 
	or die("no data in order table entered caused by " . mysql_error());

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Order successfully Sent and Received";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "error inserting order";
        
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