<?php
$servername = "localhost";
$username = "v71appcrates_ilunchdev2user";
$password = "@dqMi%adnq23";
$dbname = "v71appcrates_ilunch_dev2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

echo $time_now = date('H:i');


$late_lunches = "SELECT id,end_time,user_id from lunch_orders WHERE DATE_FORMAT(`date`, '%Y-%m-%d') = CURDATE() AND `payment_status` != 0 AND `lunch_status_color` != '#0000ff'";
$late_lunch_results = $conn->query($late_lunches);

if ($late_lunch_results->num_rows > 0) {
    // output data of each row
    while($late_lunch = $late_lunch_results->fetch_assoc()) {
        
        // echo $late_lunch_id = $late_lunch["id"];
        
        if(date('H:i', strtotime($time_now)) > date('H:i', strtotime($late_lunch["end_time"]))){
            
            echo $late_lunch_id = $late_lunch["id"];
            
            $update_late_lunch_status = "UPDATE lunch_orders SET `lunch_status_color` = '#808080' WHERE `id` = $late_lunch_id ";

            if ($conn->query($update_late_lunch_status) === TRUE) {
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