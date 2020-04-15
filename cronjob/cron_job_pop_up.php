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
// echo $conn;die;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// $order_id=1;
// $token='cu79QKylUTE:APA91bHx7rwvC2aDI2Oaxl8CniHNfMtTMMYjfzY77PgZGOD4w0j1QeCM-xfVHV1J1gxfPlUDkP3wepIe9h3NH4sOzuHkdRKkwg49eF09WJkckwdIRZ4IbHYaPUrDQLcP7z8vYevoJRVx';
// $title = " No Order Completed";
//          $body =  "Your cleaning was completed 1 hour ago please rate this cleaning. To give your feedback tap on this notification.";
//          echo   send_push($title, $body,$token,$order_id); die;
$current_day=date('Y-m-d');
$current_time=date('H:i');
// echo $current_time
$orders = "SELECT * from orders where  `order_status`=2 AND `date` = '$current_day'";
$order_results = $conn->query($orders);
// echo $order_results;
$users_token=array();
// $order_id=array();
if ($order_results->num_rows > 0) {
 while($selected_orders = $order_results->fetch_assoc()) {
         $order_id=$selected_orders["id"];
         $order_end_time = $selected_orders["end_time"];
         $user_id = $selected_orders["user_id"];
        $date=date('H:i',strtotime($order_end_time.'+ 1 hour'));
        // echo $date; die;
        $user_query="SELECT * from users where `roles`='mobile_user' AND `id` = '$user_id'";
        $user_device_token = $conn->query($user_query);
        unset($users_token);
        while($user_data=$user_device_token->fetch_assoc()){
            $users_token[]= $user_data['device_token'];

        }
         
        if($current_time==$date){
            
         $title ="Cleaning Completed";
         $body =  "Your cleaning was completed 1 hour ago please rate this cleaning. To give your feedback tap on this notification.";
         echo   send_push($title, $body, $users_token,$order_id);
         }
         
    }

}
else{echo 'no';}


 function send_push($title , $body ,$tokens,$order_id)
    {
        // return $tokens;

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );        
        //Custom data to be sent with the push
        $data2=array(
            'order_id'=>$order_id,
            'notification_type'=>'rating'
        );
        $data = array
            (
                'message'      => 'here is a message. message',
                'title'        => $title,
                'body'         => $body,
                'smallIcon'    => 'small_icon',
                'some data'    => 'Some Data',
                'Another Data' => 'Another Data',
                'click_action' => 'OPEN_ACTIVITY',
                'sound'=>'default'
               
            );

        //This array contains, the token and the notification. The 'to' attribute stores the token.
        $arrayToSend = array(
                             'registration_ids' => $tokens,
                             'notification' => $data,
                             'data' => $data2,
                             'priority'=>'high'
                              );

        //Generating JSON encoded string form the above array.
        $json = json_encode($arrayToSend);
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        
        $headers[] = 'Authorization: key= AIzaSyDAAKZz29uPRcnsenJUbLLtL0m2Gko2vxw';


        //Setup curl, add headers and post parameters.
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

        //Send the request
        $response = curl_exec($ch);

        //Close request
        curl_close($ch);
        return $response;

        // echo $response;

    }

?>