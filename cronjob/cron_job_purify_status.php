<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "purify";
$servername = "localhost";
$username = "purifyappcrates_purifyappcrates";
$password = "~Y-Q]3;ngZ2D";
$dbname = "purifyappcrates_purifydev2";
date_default_timezone_set("Europe/Stockholm");  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$time_now = date('H:i');


$late_orders = "SELECT id,end_time,user_id from orders WHERE DATE_FORMAT(`date`, '%Y-%m-%d') = CURDATE() AND `payment_status` != 'paid' ";
// echo $late_orders;die;
$late_order_results = $conn->query($late_orders);

if ($late_order_results->num_rows > 0) {
    // output data of each row
    while($late_order = $late_order_results->fetch_assoc()) {
        
        echo $late_lunch_id = $late_order["id"];
        // echo $late_order["id"];
        if(date('H:i', strtotime($time_now)) >= date('H:i', strtotime($late_order["end_time"]))){
            
           $late_order_id = $late_order["id"];
            
            $update_late_order_status = "UPDATE orders SET `order_status` = 2  WHERE `id` = $late_order_id ";
            $update_booked_order_status = "UPDATE order_employ_book SET `status` = 0  WHERE `order_id` = $late_order_id ";
            // return $update_booked_order_status;
            if ($conn->query($update_late_order_status) === TRUE && $conn->query($update_booked_order_status) === TRUE) {
                echo "Record updated successfully now";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            
        }
        
    }
} else {
    echo "0 results";
}

$conn->close();

?>