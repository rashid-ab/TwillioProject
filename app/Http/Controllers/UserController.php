<?php

namespace App\Http\Controllers;

use App\User;
use App\Ad;
use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
use Twilio\Twiml;
use App\Category;
use App\Product;
use App\Setting;
use App\Order;
use App\Orderdetail;
use App\Web_common;
use App\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function curl(Request $request){
        $cur = curl_init();
curl_setopt_array($cur, array(
    // CURLOPT_URL => $response->domainurl."/webservice/free_consult_client_otp_login_mobile.php",
    CURLOPT_URL => "https://newdev.clickdietitian.com/webservice/free_consult_client_otp_login_mobile.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'',
    
));
$headers = [
    'clickAuthorizeWebKeyMeetingRoom:5xpY2tkaWV0aXRpYW46sz60oiuU2NmhnZJlJCMj0mq'
];
curl_setopt($cur, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($cur);
 $response=json_decode($response);
// echo $response->result;die;
 $email=$response;
 curl_close($cur);
 return $email;
    } 
    public function index()
    {
        //
    }
    function send_push($title, $body, $tokens) 
    {
    
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//Custom data to be sent with the push

		$data = array
			(
			'message' => 'here is a message. message',
			'title' => $title,
			'body' => $body,
			'smallIcon' => 'small_icon',
			'some data' => 'Some Data',
			'Another Data' => 'Another Data',
			'click_action' => 'OPEN_ACTIVITY',
			'sound' => 'default',

		);

		//This array contains, the token and the notification. The 'to' attribute stores the token.
		$arrayToSend = array(
			'registration_ids' => $tokens,
			'notification' => $data,
			'priority' => 'high',
		);

		//Generating JSON encoded string form the above array.
		$json = json_encode($arrayToSend);
		//Setup headers:
		$headers = array();
		$headers[] = 'Content-Type: application/json';

		$headers[] = 'Authorization: key= AIzaSyDwEFqD5f_8NIBRWeWQ1LJirJ4grISAZnE';

		//Setup curl, add headers and post parameters.

		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		//Send the request
		$response = curl_exec($ch);
        // return $response;
		//Close request
		curl_close($ch);
// 		return $response;

		// echo $response;

	}
// public function zip(Request $request){
//     return 'asd';
//     }
     public function zip_index(){
        return view('zip');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_array=array();
     
     $email=User::where('email',$request->email)->first();
     $number=User::where('phone_number',$request->phone_number)->first();
    if(!is_null($email)){
        return response()->json(['status'=>"400",
       'description'=> "error",
       'message'=>"Duplication Email",'data'=>'']);
    }
    if(!is_null($number)){
        return response()->json(['status'=>"400",
       'description'=> "error",
       'message'=>"Duplication Phone Number",'data'=>'']);
    }
   if($request->appartment==0){
    $appartment=0;
    $vila=$request->vila;
   }
   if($request->vila==0){
    $vila=0;
    $appartment=$request->appartment;
   }

// $list_no_rooms=serialize($request->no_rooms);
if($request->hasfile('avatar')){
    $file=$request->file('avatar');
    $file_name=time().'.'.$file->getClientOriginalName();
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$file_name);

    $charset = "0987654321";
      $base = strlen($charset);
      $result = '';
      $now = explode(' ', microtime())[1];
      while ($now >= $base)
      {
          $i = $now % $base;
          $result = $charset[$i] . $result;
          $now /= $base;
       }

      $v_code = substr($result, -4);

      $account_sid = 'AC18a0b9148d3dc815f33f4fbd9ab3354d';
      $auth_token  = 'f6cd618c64f0b9eae82b6fd5f071c0d0';
    //   $phone_check=User::where('phone_number',$phone)->first();

      $client = new Client($account_sid, $auth_token);
      $client->messages->create(
          $request->phone_number,
          array(
              'from' => '+12024103135',
              'body' => 'Your Weave app verification code is: ' . "\r\n" . ' ' . $v_code
          )
      );
        $user=User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'avatar'=>url('/').'/public/avatar/'.$file_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'device_token'=>$request->device_token,
            'app_token'=>$request->app_token,
            'verify_code'=>$v_code,
            'delete_status'=>1,
            'status'=>1,
            'roles'=>'user',
        ]);
        $address=Address::create([
            'user_id'=>$user->id,
            'region'=>$request->region,
            'appartment'=>$appartment,
            'address'=>$request->address,
            'city'=>$request->city,
            'vila'=>$vila,
            'building_no'=>$request->building_no,
            'flat_no'=>$request->flat_no,
            'house_no'=>$request->house_no,
            
        ]);

        
        $user_array=array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'avatar'=>$user->avatar,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'verify_code'=>$user->verify_code,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,     
     );
        $user_detail=User::where('id',$user->id)->first();
        return response()->json(['status'=>"200",
       'description'=> "signup",
       'message'=>"success",'data'=>$user_array]);
}
else{

$charset = "0987654321";
      $base = strlen($charset);
      $result = '';
      $now = explode(' ', microtime())[1];
      while ($now >= $base)
      {
          $i = $now % $base;
          $result = $charset[$i] . $result;
          $now /= $base;
       }

      $v_code = substr($result, -4);

      $account_sid = 'AC18a0b9148d3dc815f33f4fbd9ab3354d';
      $auth_token  = 'f6cd618c64f0b9eae82b6fd5f071c0d0';
    //   $phone_check=User::where('phone_number',$request->phone_number)->first();

      $client = new Client($account_sid, $auth_token);
      $client->messages->create(
          $request->phone_number,
          array(
              'from' => '+12024103135',
              'body' => 'Your Weave app verification code is: ' . "\r\n" . ' ' . $v_code
          )
      );
     $user=User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'avatar'=>'',
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'device_token'=>$request->device_token,
            'app_token'=>$request->app_token,
            'verify_code'=>$v_code,
            'delete_status'=>1,
            'status'=>1,
            'roles'=>'user',
        ]);
     $address=Address::create([
            'user_id'=>$user->id,
            'region'=>$request->region,
            'appartment'=>$appartment,
            'city'=>$request->city,
            'vila'=>$vila,
            'building_no'=>$request->building_no,
            'flat_no'=>$request->flat_no,
            'house_no'=>$request->house_no,
            
        ]);
     $user_array=array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'avatar'=>$user->avatar,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'verify_code'=>$user->verify_code,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,
     );
    $user_detail=User::where('id',$user->id)->first();
        return response()->json(['status'=>"200",
       'description'=> "signup",
       'message'=>"success",'data'=>$user_array]);
}
}
    public function resend_code(Request $request){
        $check=User::where('phone_number',$request->phone_number)->first();
        if(is_null($check)){
        return response()->json(['status'=>"400",
       'description'=> "check",
       'message'=>"failure",'data'=>'No User Exist']);
        }
        $charset = "0987654321";
      $base = strlen($charset);
      $result = '';
      $now = explode(' ', microtime())[1];
      while ($now >= $base)
      {
          $i = $now % $base;
          $result = $charset[$i] . $result;
          $now /= $base;
       }

      $v_code = substr($result, -4);

      $account_sid = 'AC18a0b9148d3dc815f33f4fbd9ab3354d';
      $auth_token  = 'f6cd618c64f0b9eae82b6fd5f071c0d0';
    //   $phone_check=User::where('phone_number',$request->phone_number)->first();

      $client = new Client($account_sid, $auth_token);
      $client->messages->create(
          $request->phone_number,
          array(
              'from' => '+12024103135',
              'body' => 'Your Weave app verification code is: ' . "\r\n" . ' ' . $v_code
          )
      );
      $update=User::where('phone_number',$request->phone_number)->update([
            'verify_code' => $v_code,
          ]);
        return response()->json(['status'=>"200",
       'description'=> "Resend Code",
       'message'=>"success",'data'=>$v_code]);
    }

    public function login(Request $request){
        $check=1;
        $login=auth::attempt(array('phone_number' => $request->phone_number, 'password' => $request->password ,'status' => $check ,'delete_status' => $check));
        if($login==false){
        $fail=DB::table('users')->where('phone_number',$request->phone_number)->first();
        if(!is_null($fail)){
        if($fail->status==0 || $fail->delete_status==0){
                return response()->json(['status'=>"401",
                'description'=> "error",
                'message'=>"Your account is blocked. Please contact with admin",'data'=>'N/A']);
        }
        }
        else{
        return response()->json(['status'=>"400",
       'description'=> "error",
       'message'=>"no user exist",'data'=>'N/A']);
            }
        return response()->json(['status'=>"400",
       'description'=> "error",
       'message'=>"no user exist",'data'=>'N/A']);
        }
        if($login==true){
            $login_user=DB::table('users')->where('phone_number',$request->phone_number)->first();
            if($login_user->verify_status=='0'){
            return response()->json(['status'=>"400",
           'description'=> "error",
           'message'=>"Verification Error",'data'=>'Not Verified']);
            }
            $token = openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
            User::where('phone_number',$request->phone_number)->update([
               'app_token'=>$token,
                'device_token'=>$request->device_token,
                ]);
            $user       = User::where('phone_number',$request->phone_number)->first();
            $address    = Address::where('user_id',$user->id)->first();
            $user_array = array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'avatar'=>$user->avatar,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,
     );       
             return response()->json(['status'=>"200",
            'description'=> "signin",
            'message'=>"success",'data'=>$user_array]);
        }

    }
    public function verification(Request $request){
        $user=DB::table('users')
        ->join('addresses','addresses.user_id','=','users.id')
        ->where('users.phone_number',$request->phone_number)
        ->select('users.*','addresses.region','addresses.appartment','addresses.city','addresses.vila','addresses.building_no','addresses.flat_no','addresses.house_no')
        ->first();
            if(is_null($user)){
            return response()->json(['status'=>"400",
           'description'=> "error",
           'message'=>"No User",'data'=>'No User Exist']);
            }
            else{
                if($request->verify_code==$user->verify_code){
        $login_user=DB::table('users')->where('phone_number',$request->phone_number)->update(['verify_status' => '1']);
        $user_array=array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'avatar'=>$user->avatar,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'verify_code'=>$user->verify_code,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$user->region,
            'appartment'=>$user->appartment,
            'city'=>$user->city,
            'vila'=>$user->vila,
            'building_no'=>$user->building_no,
            'flat_no'=>$user->flat_no,
            'house_no'=>$user->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,     
     );
        return response()->json(['status'=>"200",
           'description'=> "success",
           'message'=>"Verified",'data'=>$user_array]);
                }
                else{
                    return response()->json(['status'=>"400",
                   'description'=> "failure",
                   'message'=>"Verification",'data'=>'Code Not Match']);
                }
            }
    }

    public function logout(Request $request){
        $user=User::where('id',$request->user_id)->update([
            'app_token'=>'0',
            // 'device_token'=>'0'
            ]);
        return response()->json(['status'=>"200",
       'description'=> "logout",
       'message'=>"success",'data'=>'']);
    }
    public function forgetpassword(Request $request){
        $email=$request->email;
        $user=User::where('email',$email)->first();
        if(!is_null($user)){
        $hashed_random_password = str_random(8);
        $uss=User::where('email',$email)->update([
        'password'=>Hash::make($hashed_random_password),
        ]);

        $to      = $request->email;
        $subject = "Password Reset";

        $message = "
        <html>
        <title>HTML email</title>
        </head>
        <body>
        <h2>Your New Password!</h2>
        <h1 style=color:#f50000>$hashed_random_password</h1>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: rashid.butt@appcrates.com' . "\r\n";
        $headers .= 'Cc: lal.bhinder@appcrates.com' . "\r\n";

        mail($to, $subject, $message, $headers);
        return response()->json(['status'=>"200",
       'description'=> "forget password",
       'message'=>"success",'data'=>'email send successfully']);
        }
        else{
            return response()->json(['status'=>"400",
       'description'=> "forget password",
       'message'=>"error",'data'=>'no such user exist']);
        }
}

public function logins(Request $request) {

        $email = $request->input('email');
        $password = $request->input('password');
        $messages = array(
            'email.required' => 'Please enter email',
             'password.required' => 'Please enter password',
        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $data=array ( 'email' => $email,'password' => $password ,'roles' => 'admin','roles' => 'super');
        if (Auth::attempt($data)) {

            return redirect('/manage_user');

        } else {

            Session::flash ( 'message', "Invalid Credentials , Please try again." );
            return redirect()->back();
        }

    }

public function update_profile_pic(Request $request)
    {
        if($request->hasfile('avatar')){

    $file=$request->file('avatar');
    $file_name=$file->getClientOriginalName();
    $f_imge = time().$file_name;
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$f_imge);
     $user=User::where('id',$request->id)->update([
          'avatar'=>url('/').'/public/avatar/'.$f_imge,]);
    $users=User::where('id',$request->id)->first();
    return response()->json(['status'=>"200",
    'description'=> "update profile pic",
    'message'=>"success",'data'=>$users]);
        }


    }

public function update(Request $request)
    {
    if($request->appartment==0){
    $appartment=0;
    $vila=$request->vila;
   }
   if($request->vila==0){
    $vila=0;
    $appartment=$request->appartment;
   }
    $users=User::where('id',$request->user_id)->first();
    $addresses=Address::where('user_id',$request->user_id)->first();
    // return $addresses->id;
    if(is_null($users)){
        return response()->json(['status'=>"200",
       'description'=> "error",
       'message'=>"no user exist",'data'=>'']);
    }
    if($request->hasfile('avatar')){

    $file=$request->file('avatar');
    $file_name=$file->getClientOriginalName();
    $f_imge = time().$file_name;
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$f_imge);
    // echo url('/').'/public/images/'.$f_imge;
    // die;

        User::where('id',$request->user_id)->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'avatar'=>url('/').'/public/avatar/'.$f_imge,
            'phone_number'=>$request->phone_number,
            
        ]);
         Address::where('id',$addresses->id)->update([
            'region'=>$request->region,
            'appartment'=>$appartment,
            'city'=>$request->city,
            'vila'=>$vila,
            'building_no'=>$request->building_no,
            'flat_no'=>$request->flat_no,
            'house_no'=>$request->house_no,
            
        ]);
        $user=User::where('id',$request->user_id)->first();
        $address=Address::where('user_id',$request->user_id)->first();
        $user_array=array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'email'=>$user->email,
            'avatar'=>$user->avatar,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,
     );
        return response()->json(['status'=>"200",
       'description'=> "update profile",
       'message'=>"success",'data'=>$user_array]);
    }
    else{
     $user=User::where('id',$request->user_id)->first();
        User::where('id',$request->user_id)->update([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'avatar'=>'',
            'phone_number'=>$request->phone_number,
        ]);
        
         Address::where('id',$addresses->id)->update([
            'region'=>$request->region,
            'appartment'=>$appartment,
            'city'=>$request->city,
            'vila'=>$vila,
            'building_no'=>$request->building_no,
            'flat_no'=>$request->flat_no,
            'house_no'=>$request->house_no,
            
        ]);
        $user=User::where('id',$request->user_id)->first();
        $address=Address::where('user_id',$request->user_id)->first();
     $user_array=array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'email'=>$user->email,
            'avatar'=>$user->avatar,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,
     );
        
        
       return response()->json(['status'=>"200",
       'description'=> "update profile",
       'message'=>"success",'data'=>$user_array]);
    }

    }


	public function get_profile(Request $request)
    {
        $user_id    = $request->user_id;
        $user       = User::where('id',$user_id)->first();
        $address    = Address::where('user_id',$user_id)->first();
        
        if(is_null($user)){

            return response()->json(['status_code'=>100,'status'=>'failure','data'=>'No User Exist']);
        }
        else{

         $user_array = array(
            'user_id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'avatar'=>$user->avatar,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'device_token'=>$user->device_token,
            'email_verified_at'=>$user->email_verified_at,
            'social_token'=>$user->social_token,
            'app_token'=>$user->app_token,
            'social_name'=>$user->social_name,
            'roles'=>$user->roles,
            'region'=>$address->region,
            'appartment'=>$address->appartment,
            'city'=>$address->city,
            'vila'=>$address->vila,
            'building_no'=>$address->building_no,
            'flat_no'=>$address->flat_no,
            'house_no'=>$address->house_no,
            'delete_status'=>$user->delete_status,
            'status'=>$user->status,
     );       
            return response()->json(['status_code'=>200,'status'=>'success','data'=>$user_array]);
        }
    }

    public function get_logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }

    public function manage_user()
    {
    	$user=User::where('roles','user')->where('delete_status',1)->get();
    	return view('users',['users' => $user]);

    }

    public function delete_user($id)
    {
      User::where('id',$id)->delete();
       return  redirect()->intended('/manage_user')->with('delete','Deleted Successfully!');
    }
    public function deleteuser(Request $request)
    {
      User::where('phone_number',$request->phone_number)->delete();
       return response()->json(['status'=>"200",
       'description'=> "delete",
       'message'=>"success",'data'=>'Delete']);
    }

     public function change_password(Request $request){

     $user=User::where('id',$request->user_id)->first();
     if(is_null($user)){
         return response()->json(['status'=>"100",
       'description'=> "Change Password",
       'message'=>"success",'data'=>'No User Exist.']);
     }
    if(Hash::check($request->old_password,$user->password)){
     $users=User::where('id',$request->user_id)->update([
         'password'=>Hash::make($request->new_password),
         ]);
    return response()->json(['status'=>"200",
       'description'=> "Change Password",
       'message'=>"success",'data'=>'password change successfully.']);
    }
      else{
         return response()->json(['status'=>"100",
       'description'=> "Change Password",
       'message'=>$request->old_password.' is a wrong password!.','data'=>'']);
      }

     }


    public function get_users($id)
    {
$rec=DB::table('users')->where('users.id',$id)->first();
$address=DB::table('addresses')->where('user_id',$id)->get();
    if($rec->roles=='user'){
    	$html="";
    	if($rec->avatar!=''){
        $html.='<div class="media-left">

            <div style="height:160px;" class="media-body">
                <img src="'.$rec->avatar.'" style="width:150px;height:150px;" class="img-circle" >
                <div class="col-sm-6 col-xs-12">

                    <br /><span><b>Name:</b> '.$rec->first_name.' '.$rec->last_name.'</span>
                    <br /><span><b>Email:</b> '.$rec->email.'</span>
                    <br /><span><b>Phone:</b> '.$rec->phone_number.'</span><br />
                    ';
        }
        else{
        $html.='<div class="media-left">

            <div style="height:160px;" class="media-body">
                <img src="public/avatar/avatar.jpg" style="width:150px;height:150px;" class="img-circle" >
                <div class="col-sm-6 col-xs-12">

                    <br /><span><b>Name:</b> '.$rec->first_name.' '.$rec->last_name.'</span>
                    <br /><span><b>Email:</b> '.$rec->email.'</span>
                    <br /><span><b>Phone:</b> '.$rec->phone_number.'</span><br />
                    ';
        }
            foreach($address as $key=> $value){
                $key=$key+1;
                if($value->appartment==1){
                $html.='<br /><span><b>'.$key.' Default Address:</b>'.$value->region.' '.$value->state.' '.$value->city.'
                    <br /><b>Building No:</b>'.$value->building_no.' </span><br />
                    <b>Flat No:</b>'.$value->flat_no.' </span><br />';
                    }
                    if($value->vila==1){
                $html.='<br /><span><b>'.$key.' Default Address:</b>'.$value->region.' '.$value->state.' '.$value->city.'
                    <br /><b>House No:</b>'.$value->house_no.' </span><br />';
                    }
            }
            $html.='</div>


                </div>
            </div>';
    	return response()->json($html);
 }

    }

    public function block_user($id)
    {
    	$data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"users");
       return  redirect()->intended('/manage_user');
    }

    public function un_block_user($id)
    {
    	$data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"users");
       return  redirect()->intended('/manage_user');
    }

   
    public function email_send(Request $request){
        $email_send=User::where('email',$request->email)->first();
        if(is_null($email_send)){
            return response()->json('null');
        }
        else{
            $hashed_random_password = str_random(8);
        $email_submit=User::where('id',$email_send->id)->update([
        'password'=>Hash::make($hashed_random_password),
        ]);

        $to      = $request->email;
         $subject = "Password Reset";

        $message = "
        <html>
        <head>
        <title>HTML email</title>
        </head>
        <body>
        <h2>Your New Password!</h2>
        <h1 style=color:#f50000>$hashed_random_password</h1>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: rashid.butt@appcrates.com' . "\r\n";
        $headers .= 'Cc: lal.bhinder@appcrates.com' . "\r\n";

        mail($to, $subject, $message, $headers);
        return response()->json('send');
        }
    }
   
    public function send_mail($text,$email)
    {
        $data = array('text'=>$text, "name" => "hahahaha");
           $to=$email;
        Mail::to($to)->send(new ReplyMail($data));
        echo "Your Msg have been send to user via email";
    }


/****************** Bilal ******************************************/


    
/****************** Zaid ******************************************/

     public function delete_event($id){

        $data=array("status"=>'2');
        $record = Web_common::delete_event($id,$data,"events");
        return  redirect()->back()->with('alert', 'Events deleted!');
    }



    public function changepassword()
     {
         return view('changePassword');
     }



      public function sendPasswordVar()
     {

        $data=Input::all();
        $oldpassword = $data['oldPassowrd'];
        $newpassword = $data['newPassowrd'];
        $confermpassword = $data['confermPassowrd'];


         $user = Auth::User();
        if($newpassword == $confermpassword){
            $current_password = $user->password;
              if (Hash::check($oldpassword, $current_password)){
                print_r("yes match value");
                echo "<br>";
                 $newpassword = Hash::make($newpassword);
                  print_r($newpassword);
                  echo "<br>";
                 $user_id = $user->id;
                 $data=array("password"=> $newpassword);
                 $newpassword = Web_common::newpassword($user_id,$data,"users");
                 print_r("yes change");
                echo "<br>";
                return  redirect('/');
              }
              else
              {

                return  redirect()->back()->with('message', 'Old Password is Incorect..!');
              }


        }else
        {

          return  redirect()->back()->with('message', 'Your Password In Not Match..!');
        }


     }

   

  public function manage_category(){
    $categories=Category::orderBy('priority','ASC')->get();
    return view('category',compact('categories'));
  }

  public function new_category(){
    return view('new_category');
  }

  public function add_category(Request $request){
    $duplicate=Category::where('title_in_english',$request->title_in_english)->first();
    if(!is_null($duplicate)){
      return redirect('/new_category')->with('duplicate','Category is Already Exist');
    }
    if($request->hasfile('image')){
            $file=$request->file('image');
            $file_name=time().$file->getClientOriginalName();
            $destination=app()->basePath('public/images');
            $file->move($destination,$file_name);
    }
    Category::create([
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'image'=>url('/').'/public/images/'.$file_name,
            'status'=>1,
    ]);
    return redirect('/new_category')->with('success','Category Added');
  }

  public function edit_category($id){
    $category=Category::where('id',$id)->first();
    return view('edit_category',compact('category'));
  }

  public function update_category(Request $request){
    if($request->title_in_english!=$request->title_in_englishs){
    $duplicate=Category::where('title_in_english',$request->title_in_english)->first();
    if(!is_null($duplicate)){
      return redirect('/new_category')->with('duplicate','Category is Already Exist');
    }
  }
    if($request->hasfile('image')){
            $file=$request->file('image');
            $file_name=time().$file->getClientOriginalName();
            $destination=app()->basePath('public/images');
            $file->move($destination,$file_name);
            Category::where('id',$request->id)->update([
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'image'=>url('/').'/public/images/'.$file_name,
            'status'=>1,
    ]);
    }
            Category::where('id',$request->id)->update([
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'status'=>1,
    ]);
    
    return redirect('/manage_category')->with('update','Updated Successfully!');
  }
 public function change_order_category(Request $request)
    {

    $orders = explode('&', $request->orders);

    $array = array();

    foreach($orders as $item) {
        $item = explode('=', $item);
        $item = explode('_', $item[1]);
        $array[] = $item[1];
    }

    // return $array;
    // die;


    for($i=0; $i<count($array); $i++){
        // print_r($i);
        // print_r($array[$i]);
        Category::where([['id', $array[$i]],['status', 1]])->update(['priority' => $i]);

    }

    echo "Successfully Category Order Changed";
    // try {

    //     $objDb = new PDO('mysql:host=localhost;dbname=abc_medwin', 'root', '');
    //     $objDb->exec("SET CHARACTER SET utf8");

    //     foreach($array as $key => $value) {
    //         $key = $key + 1;
            
    //         //echo $key;

    //         //echo $value;

    //         $sql = "UPDATE `categories`
    //                SET `order` = ?
    //                WHERE `id` = ?";
    //                // echo $aql;
    //          $objDb->prepare($sql)->execute(array($key, $value));



    //     }
    //         echo "Successfully Order Change";

    //     } catch(Exception $e) {

    //         echo json_encode(array('error' => false));

    //     }


    }
    
    public function block_category($id)
    {
      $data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"categories");
       return  redirect()->intended('/manage_category');
    }

    public function un_block_category($id)
    {
      $data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"categories");
       return  redirect()->intended('/manage_category');
    }

    public function delete_category($id)
    {
      Category::where('id',$id)->delete();
       return  redirect()->intended('/manage_category')->with('delete','Deleted Successfully!');
    }


    public function get_category($id)
    {
      $rec=DB::table('categories')->
      where('id',$id)->first();
     
    
      $html="";
      $html.='<div class="media-left">

            <div style="height:160px;" class="media-body">
              <img src="'.$rec->image.'" style="width:150px" class="img-circle" >
              <div class="col-sm-6 col-xs-12">

          <br /><span><b>Title:</b> '.$rec->title_in_english.' '.$rec->title_in_arabic.'</span><br />
          



          </div>


              </div>
            </div>';

      return response()->json($html);
 

    }


 public function manage_product(){
    $products=Product::
    join('categories','products.category_id','=','categories.id')
    ->where('categories.status',1)
    ->select('products.id','products.product_code','products.title_in_english','products.title_in_arabic','products.description_in_english','products.description_in_arabic','products.status','products.price','products.discounted_price','products.image','categories.title_in_english as category_name')
    ->orderBy('products.priority','ASC')
    ->get();
    return view('product',compact('products'));
  }
 public function change_order_product(Request $request)
    {

    $orders = explode('&', $request->orders);

    $array = array();

    foreach($orders as $item) {
        $item = explode('=', $item);
        $item = explode('_', $item[1]);
        $array[] = $item[1];
    }

    // return $array;
    // die;


    for($i=0; $i<count($array); $i++){
        // print_r($i);
        // print_r($array[$i]);
        Product::where([['id', $array[$i]],['status', 1]])->update(['priority' => $i]);

    }

    echo "Successfully Products Order Changed";
    // try {

    //     $objDb = new PDO('mysql:host=localhost;dbname=abc_medwin', 'root', '');
    //     $objDb->exec("SET CHARACTER SET utf8");

    //     foreach($array as $key => $value) {
    //         $key = $key + 1;
            
    //         //echo $key;

    //         //echo $value;

    //         $sql = "UPDATE `categories`
    //                SET `order` = ?
    //                WHERE `id` = ?";
    //                // echo $aql;
    //          $objDb->prepare($sql)->execute(array($key, $value));



    //     }
    //         echo "Successfully Order Change";

    //     } catch(Exception $e) {

    //         echo json_encode(array('error' => false));

    //     }


    }
    
    public function product_search(Request $request){
        if(is_null($request->category_name)){
            $data=$products=Product::
    join('categories','products.category_id','=','categories.id')
    ->where('categories.status',1)
    ->select('products.id','products.product_code','products.title_in_english','products.title_in_arabic','products.description_in_english','products.description_in_arabic','products.status','products.price','products.discounted_price','products.image','categories.title_in_english as category_name')
    ->orderBy('products.priority','ASC')
    ->get();
    
        return response()->json($data);
        }
        $data=$products=Product::
    join('categories','products.category_id','=','categories.id')
    ->where('categories.status',1)
    ->where('categories.title_in_english',$request->category_name)
    ->select('products.id','products.product_code','products.title_in_english','products.title_in_arabic','products.description_in_english','products.description_in_arabic','products.status','products.price','products.discounted_price','products.image','categories.title_in_english as category_name')
    ->orderBy('products.priority','ASC')
    ->get();
    
        return response()->json($data);
    }
    
  public function new_product(){
    $categories=Category::where('status',1)->get();
    return view('new_product',compact('categories'));
  }

  public function add_product(Request $request){
    $duplicate=Product::where('title_in_english',$request->title_in_english)->first();
    if(!is_null($duplicate)){
      return redirect('/new_product')->with('duplicate','Product is Already Exist');
    }
    $duplicate=Product::where('category_id',$request->category_id)->where('product_code',$request->product_code)->first();
    if(!is_null($duplicate)){
      return redirect('/new_product')->with('duplicate','Product Code is Already Exist');
    }

    if($request->hasfile('image')){
            $file=$request->file('image');
            $file_name=time().$file->getClientOriginalName();
            $destination=app()->basePath('public/images');
            $file->move($destination,$file_name);
    }
    Product::create([
            'product_code'=>$request->product_code,
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'description_in_english'=>$request->description_in_english,
            'description_in_arabic'=>$request->description_in_arabic,
            'category_id'=>$request->category_id,
            'image'=>url('/').'/public/images/'.$file_name,
            'price'=>$request->price,
            'discounted_price'=>$request->discounted_price,
            'status'=>1,
    ]);
    return redirect('/new_product')->with('success','Product Added');
  }

  public function edit_product($id){
    $product=Product::
    join('categories','products.category_id','=','categories.id')
    ->where('products.id',$id)
    ->select('products.id as product_id','products.product_code','products.title_in_english','products.title_in_arabic','products.description_in_english','products.description_in_arabic','products.status','products.price','products.discounted_price','products.image','categories.title_in_english as category_name_in_english','categories.id as category_id','categories.title_in_english as category_name_in_english','categories.title_in_arabic as category_name_in_arabic')
    ->first();
    $categories=Category::all();
    return view('edit_product',compact('product','categories'));
  }

  public function update_product(Request $request){

    if($request->title_in_english!=$request->title_in_englishs){
    $duplicate=DB::table('products')->where('title_in_english',$request->title_in_english)->first();
    if(!is_null($duplicate)){
      return redirect('/edit_product/'.$request->id)->with('duplicate','Product is Already Exist');
    }
  }
    if($request->product_code!=$request->product_codes){
    $duplicate=DB::table('products')->where('product_code',$request->product_code)->first();
    if(!is_null($duplicate)){
      return redirect('/edit_product/'.$request->id)->with('duplicate','Product Code is Already Exist');
    }
  }
  if($request->hasfile('image')){
    // return 'asd1';
            $file=$request->file('image');
            $file_name=time().$file->getClientOriginalName();
            $destination=app()->basePath('public/images');
            $file->move($destination,$file_name);
            $product=DB::table('products')->where('id',$request->id)->update([
            'product_code'=>$request->product_code,
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'description_in_english'=>$request->description_in_english,
            'description_in_arabic'=>$request->description_in_arabic,
            'category_id'=>$request->category_id,
            'image'=>url('/').'/public/images/'.$file_name,
            'price'=>$request->price,
            'discounted_price'=>$request->discounted_price,
            'status'=>1,
    ]);
            
    }
    else{
            $product=DB::table('products')->where('id',$request->id)->update([
            'product_code'=>$request->product_code,
            'title_in_english'=>$request->title_in_english,
            'title_in_arabic'=>$request->title_in_arabic,
            'description_in_english'=>$request->description_in_english,
            'description_in_arabic'=>$request->description_in_arabic,
            'category_id'=>$request->category_id,
            'price'=>$request->price,
            'discounted_price'=>$request->discounted_price,
            'status'=>1,
    ]);
             
    }
    return redirect('/manage_product')->with('update','Updated Successfully!');
  }

    public function block_product($id)
    {
      $data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"products");
       return  redirect()->intended('/manage_product');
    }

    public function un_block_product($id)
    {
      $data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"products");
       return  redirect()->intended('/manage_product');
    }

    public function delete_product($id)
    {
      Product::where('id',$id)->delete();
       return  redirect()->intended('/manage_product')->with('delete','Deleted Successfully!');
    }


    public function get_product($id)
    {
      $rec=DB::table('products')->
      where('id',$id)->first();
     
    
      $html="";
      $html.='<div class="media-left">

            <div style="height:160px;" class="media-body">
              <img src="'.$rec->image.'" style="width:150px" class="img-circle" >
              <div class="col-sm-6 col-xs-12">

          <br /><span><b>Title:</b> '.$rec->title_in_english.' '.$rec->title_in_arabic.'</span><br />
          <br /><span><b>Price:</b> '.$rec->price.'</span><br />
          



          </div>


              </div>
            </div>';

      return response()->json($html);
 

    }

    public function manage_order(){
        $orders=Order::
        join('users','orders.user_id','=','users.id')->
        select('orders.id','orders.total_price','orders.payment_method','orders.payment_status','order_status','orders.date','users.first_name','users.last_name')->
        orderBy('id','DESC')->get();
        return view('order',compact('orders'));
    }

    public function block_order($id)
    {
        $data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"orders");
        return  redirect()->intended('/manage_order');
    }

    public function un_block_order($id)
    {
        $data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"orders");
        return  redirect()->intended('/manage_order');
    }

    public function paid_payment_status($id)
    {
        $data=array("payment_status"=>'0');
        $record = Web_common::update_data($id,$data,"orders");
        return  redirect()->intended('/manage_order');
    }

    public function pending_payment_status($id)
    {
        $data=array("payment_status"=>'1');
        $record = Web_common::update_data($id,$data,"orders");
        return  redirect()->intended('/manage_order');
    }
    public function order_status(Request $request,$id)
    {   $check='';
        if($request->complete){
        $check=$request->complete;
        $data=array("order_status"=>'2');
    }
        if($request->cancel){
        $check=$request->cancel;
        $data=array("order_status"=>'0');
        
    }
        if($request->active){
        $check=$request->active;
        $data=array("order_status"=>'1');
    }
        $order=Order::where('id',$id)->first();
        $admin=User::where('roles','admin')->first();
        $user=User::where('id',$order->user_id)->first();
        $record = Web_common::update_data($id,$data,"orders");
        if($record==1){
        $email=User::where('roles','admin')->first();
        $to       = $user->email;
        $subject  = 'Order Status';
        $messages = "
        <html>
        <head>
        <title>HTML email</title>
        </head>
        <body>
        <h2>Order</h2>
        <p><b>Order No:</b>$order->id</p>
        <p><b>Name:</b>$user->first_name $user->last_name</p>
        <p><b>Phone No:</b>$user->phone_number</p>
        <p>
        <b>
        Message:
        </b>
        </p>
        Your Order $check Now!
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From:'.$admin->email. "\r\n";
        $headers .= 'Cc: lal.bhinder@appcrates.com' . "\r\n";

        mail($to, $subject, $messages, $headers);
        }
            $title='Order Status';
            $body="Your Order is $check";
            $tokens=array();
            $tokens[]= $user->app_token;
          echo $notifi = $this->send_push($title, $body, $tokens);
        return  redirect()->intended('/manage_order');
    }
    
    public function orderdetail($id)
    {  
        // $orders= Order::
        // join('orderdetails','orderdetails.order_id','=','orders.id')->
        // join('users','orders.user_id','=','users.id')->
        // join('products','orderdetails.product_id','=','products.id')->
        // select('orders.id','orders.date','orders.time','orders.total_price','orders.order_status','orders.payment_method','orders.payment_status',
        // 'products.title_in_english','products.title_in_arabic','products.image'
        // ,'products.price','orderdetails.quantity','orderdetails.price','users.first_name','users.last_name')->
        // where('orders.id',$id)->
        // get();
        
        $order=array();
         $orders=
         Order::
         join('addresses','orders.address_id','=','addresses.id')->
         join('users','orders.user_id','=','users.id')->
         select('orders.id','orders.date','orders.order_status','orders.payment_method','orders.payment_status','orders.total_price'
         ,'users.first_name','users.last_name','users.phone_number','addresses.region','addresses.state','addresses.city','addresses.appartment','addresses.vila'
         ,'addresses.building_no','addresses.flat_no','addresses.house_no')->where('orders.id',$id)->first();
         //  return $orders; 
         $orderss=
         Orderdetail::
         join('products','orderdetails.product_id','=','products.id')->
         join('categories','products.category_id','=','categories.id')->
         select( 'orderdetails.price','categories.title_in_english as category_title_in_english','categories.title_in_arabic as category_title_in_arabic'
                ,'products.title_in_english as product_title_in_english','products.image','products.title_in_arabic as product_title_in_arabic','orderdetails.quantity'
                
                )->where('orderdetails.order_id',$orders->id)->get();
                // return $order;
        // $total_price_of_a_order=Orderdetail::where('order_id',$orders->id)->sum('total_price');
        if(!is_null($order)){
        if($orders->appartment!=1){
        $order=array(
                       "order_id"       => $orders->id,
                       "total_price"    => $orders->total_price,
                       "date"           => $orders->date,
                       "time"           => $orders->time,
                       "payment_method" => $orders->payment_method,
                       "payment_status" => $orders->payment_status,
                       "total_price"    => $orders->total_price,
                       "phone_number"   => $orders->phone_number,
                       "name"           => $orders->first_name.' '.$orders->last_name,
                       "address"        => $orders->region.','.$orders->city.','.$orders->state.','.$orders->house_no,
                       'status'         => $orders->order_status,
                       "order_detail"   => $orderss,
                       
            );
        }
        if($orders->vila!=1){
        $order=array(
                       "order_id"       => $orders->id,
                       "total_price"    => $orders->total_price,
                       "date"           => $orders->date,
                       "time"           => $orders->time,
                       "payment_method" => $orders->payment_method,
                       "payment_status" => $orders->payment_status,
                       "total_price"    => $orders->total_price,
                       "phone_number"   => $orders->phone_number,
                       "name"           => $orders->first_name.' '.$orders->last_name,
                       "address"        => $orders->region.','.$orders->city.','.$orders->state.','.$orders->building_no.','.$orders->flat_no,
                       "order_detail"   => $orderss,
                       
            );
        }
         }
        // return $order;
        return view('orderdetail',compact('order'));
    }
// **********************Ad Module*******************
    public function manage_ads(){
    $ads=Ad::where('status',1)->get();
    return view('manage_ads',compact('ads'));
  }
    public function add_ads(){
        return view('ads');
    }
    public function save_ad(Request $request){
       if($request->hasfile('image')){
    $file=$request->file('image');
    $file_name=time().'.'.$file->getClientOriginalName();
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$file_name);
    $file_names=url('/').'/public/avatar/'.$file_name;
       }
        else{
            $file_names='No-Image';
    }
            $ad=Ad::create([
                'ad_type'               => $request->ad_type,
                'title_in_english'      => $request->title_in_english,
                'title_in_arabic'       => $request->title_in_arabic,
                'text_in_english'       => $request->text_in_english,
                'text_in_arabic'        => $request->text_in_arabic,
                'image'                 => $file_names,
                'status'                => 1,
            ]);
    return redirect('manage_ads')->with('Success','Ad added Successfully!');
    }
     public function block_ad($id)
    {
        $data=array("status"=>'2');
        $record = Web_common::update_data($id,$data,"ads");
        return  redirect()->intended('/manage_ads');
    }

    public function un_block_ad($id)
    {
        $data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"ads");
        return  redirect()->intended('/manage_ads');
    }
    public function delete_ad($id)
    {
        $data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"ads");
        return  redirect()->intended('/manage_ads');
    }
    public function edit_ad($id){
        $ad=Ad::find($id);
        return view('edit_ad',compact('ad'));
    }
    public function update_ad(Request $request,$id){
        if($request->ad_type=='By Text' || $request->ad_type=='By Text And Image'){
            $title_in_english = $request->title_in_english;
            $title_in_arabic = $request->title_in_arabic;
            $text_in_english = $request->text_in_english;
            $text_in_arabic = $request->text_in_arabic;
        }
        if($request->ad_type=='By Image'){
            $title_in_english = '';
            $title_in_arabic = '';
            $text_in_english = '';
            $text_in_arabic = '';
        }
       if($request->hasfile('image')){
    $file=$request->file('image');
    $file_name=time().'.'.$file->getClientOriginalName();
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$file_name);
    $file_names=url('/').'/public/avatar/'.$file_name;
       }
        else{
            $add=Ad::find($id);
            $file_names=$add->image;
    }
            $ad=Ad::find($id)->update([
                'ad_type'               => $request->ad_type,
                'title_in_english'      => $title_in_english,
                'title_in_arabic'       => $title_in_arabic,
                'text_in_english'       => $text_in_english,
                'text_in_arabic'        => $text_in_arabic,
                'image'                 => $file_names,
                'status'                => 1,
            ]);
    return redirect('manage_ads')->with('update','Updated Successfully!');
    }
    
    public function ad_details($id)
    {
$rec=Ad::find($id);
$html="";
if($rec->ad_type=='By Text' || $rec->ad_type=='By Text And Image'){
    	
    	$html.='<div class="align-self-end mr-3">';
    	if($rec->image!='No-Image'){
        $html.='<img src="'.$rec->image.'" style="width:150px;height:150px;display: block;
        margin-left: auto;
        margin-right: auto;" class="img-circle center" >
                    
        ';
        }
    	
        $html.='
        <div style="margin:0 auto">
                    <br /><span><b>Title In English:</b> '.$rec->title_in_english.'</span>
                    <br /><span><b>Title In Arabic:</b> '.$rec->title_in_arabic.'</span>
                    <br /><span><b>Text In English:</b> '.$rec->text_in_english.'</span>
                    <br /><span><b>Text In Arabic:</b> '.$rec->text_in_arabic.'</span>
        </div>
                    ';
        
}
        else{
        $html.='<div class="media-center">

            <img src="'.$rec->image.'" style="width:250px;height:250px;display: block;
            margin-left: auto;
            margin-right: auto;
            "class="img-circle center" >
                
                ';
        }
            
            $html.='</div>';
            return response()->json($html);
 

    }
    public function manage_admins(){
        $admins= User::where('roles','admin')->get();
        return view('/manage_admins',compact('admins'));
    }
    public function new_admin(){
        return view('new_admin');
    }
    public function add_admin(Request $request){
        $password=str_random(8);
        $check=User::where('email',$request->email)->orWhere('phone_number',$request->phone_number)->first();
        if($check){
            return redirect()->back()->with('duplicate','Admin Already Exist');
        }
        if($request->hasfile('avatar')){
    $file=$request->file('avatar');
    $file_name=time().'.'.$file->getClientOriginalName();
    $destinationPaths1 = app()->basePath('public/avatar');
    $file->move( $destinationPaths1,$file_name);
    $file_names=url('/').'/public/avatar/'.$file_name;
       }
        else{
            $file_names='No-Image';
    }
            $admin=User::create([
                'first_name'                => $request->first_name,
                'last_name'                 => $request->last_name,
                'email'                     => $request->email,
                'phone_number'              => $request->phone_number,
                'password'                  => Hash::make($password),
                'avatar'                    => $file_names,
                'roles'                     => 'admin',
                'status'                    => 1,
            ]);
    return redirect('manage_admins')->with('Success','Admin added Successfully!');
    }
    public function block_admin($id)
    {
    	$data=array("status"=>'0');
        $record = Web_common::update_data($id,$data,"users");
       return  redirect()->intended('/manage_admins');
    }

    public function un_block_admin($id)
    {
    	$data=array("status"=>'1');
        $record = Web_common::update_data($id,$data,"users");
       return  redirect()->intended('/manage_admins');
    }
    
    
}
