<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Faq;
use App\Ad;
use App\aboutus;
use App\Product;
use App\Notification;
use App\Contactus;
use App\Cart;
use App\Orderdetail;
use App\Order;
use App\Address;
use App\Region;
use App\City;
use App\User;
// use Hash;
class ApiController extends Controller
{ 
    
    /*******************Push Notification****************/
    
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
    public function noify()
    {
      echo  $this->send_push('$title', '$body', $device_tok);
    }
    /*******************get_categories****************/

    public function get_categories(Request $request)
    {
      
    	$categories=Category::where('status',1)->get();
    	$cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
        $cart_count=Cart::where('user_id',$request->user_id)->get();
        $sum=array();
        $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
        );
    	return response()->json(['status_code'=>200,'status'=>'success','data'=>$categories,'sum'=>$sum]);
    }

    public function get_category(Request $request)
    {
      
    	$categories=Category::where('status',1)->get();
    	
    	return response()->json(['status_code'=>200,'status'=>'success','data'=>$categories]);
    }


    /*******************get_product_by_category_id****************/

    public function get_product_by_category_id(Request $request)
    {
        
        $n_category=Category::where('id','>',$request->category_id)->orderBy('id', 'ASC')->first();
        $p_category=Category::where('id','<',$request->category_id)->orderBy('id','DESC')->first();
        
        
        
    	$products=Product::where('status',1)->where('category_id',$request->category_id)->get();
    	if(count($products)>0){
    	$cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
        $cart_count=Cart::where('user_id',$request->user_id)->get();
        $sum=array();
        $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
        $product_array=array();
        
        
        foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id" => $product->id,
            "product_code"=> $product->product_code,
            "title_in_english"=> $product->title_in_english,
            "title_in_arabic"=> $product->title_in_arabic,
            "description_in_english"=> $product->description_in_english,
            "description_in_arabic" => $product->description_in_arabic,
            "category_id"=> $product->category_id,
            "image"=> $product->image,
            "price"=> $product->price,
            "discounted_price"=>$product->discounted_price,
            "status"=> $product->status,
            'product_count' => count($cart_total_sum),
                );
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
        }
        
        $result=array("next_at"=>$n_category,
                "prev_cat"=>$p_category,
                "producnts"=>$product_array
        );
        
    	return response()->json(['status_code'=>200,'status'=>'success','data'=>$result,'sum'=>$sum]);
    	}
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
    }
    
    public function get_product_by_category_ids(Request $request)
    {
        
        $n_category=Category::where('id','>',$request->category_id)->orderBy('id', 'ASC')->first();
        $p_category=Category::where('id','<',$request->category_id)->orderBy('id','DESC')->first();
        
        
        
    	$products=Product::where('status',1)->where('category_id',$request->category_id)->get();
    	if(count($products)>0){
    	$cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
        
        $product_array=array();
        
        
        foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id" => $product->id,
            "product_code"=> $product->product_code,
            "title_in_english"=> $product->title_in_english,
            "title_in_arabic"=> $product->title_in_arabic,
            "description_in_english"=> $product->description_in_english,
            "description_in_arabic" => $product->description_in_arabic,
            "category_id"=> $product->category_id,
            "image"=> $product->image,
            "price"=> $product->price,
            "discounted_price"=>$product->discounted_price,
            "status"=> $product->status,
               );
            
        }
        
        $result=array("next_at"=>$n_category,
                "prev_cat"=>$p_category,
                "producnts"=>$product_array
        );
        
    	return response()->json(['status_code'=>200,'status'=>'success','data'=>$result]);
    	}
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
    }

    /*******************get_product_by_product_name****************/

    public function get_product_by_product_name(Request $request)
    {
    	if($request->title_in_english){
    	$products=Product::where('status',1)->where('title_in_english','LIKE','%'.$request->title_in_english. '%')->get();
    	if(count($products)>0){
    	$cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
        $cart_count=Cart::where('user_id',$request->user_id)->get();
        $sum=array();
        $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
        $product_array=array();
        foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id" => $product->id,
            "product_code"=> $product->product_code,
            "title_in_english"=> $product->title_in_english,
            "title_in_arabic"=> $product->title_in_arabic,
            "description_in_english"=> $product->description_in_english,
            "description_in_arabic" => $product->description_in_arabic,
            "category_id"=> $product->category_id,
            "image"=> $product->image,
            "price"=> $product->price,
            "discounted_price"=>$product->discounted_price,
            "status"=> $product->status,
            'product_count' => count($cart_total_sum),
                );
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
        }
    	return response()->json(['status_code'=>200,'status'=>'success','data'=>$product_array,'sum'=>$sum]);
    	}
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
    }
    
    if($request->title_in_arabic){
    	$products=Product::where('status',1)->where('title_in_arabic','LIKE','%'.$request->title_in_arabic. '%')->get();
    	if(count($products)>0){
    	$cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
        $cart_count=Cart::where('user_id',$request->user_id)->get();
        $sum=array();
        $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
        $product_array=array();
        foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id" => $product->id,
            "product_code"=> $product->product_code,
            "title_in_english"=> $product->title_in_english,
            "title_in_arabic"=> $product->title_in_arabic,
            "description_in_english"=> $product->description_in_english,
            "description_in_arabic" => $product->description_in_arabic,
            "category_id"=> $product->category_id,
            "image"=> $product->image,
            "price"=> $product->price,
            "discounted_price"=>$product->discounted_price,
            "status"=> $product->status,
            'product_count' => count($cart_total_sum),
                );
        }
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
        }
    
   
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
}

   }

public function get_product_by_product_names(Request $request)
    {
    	if($request->title_in_english){
    	$products=Product::where('status',1)->where('title_in_english','LIKE','%'.$request->title_in_english. '%')->get();
    	if(count($products)>0){
            return response()->json(['status_code'=>100,'status'=>'success','data'=>$products]);
    
    	}
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
    	}
    
    if($request->title_in_arabic){
    	$products=Product::where('status',1)->where('title_in_arabic','LIKE','%'.$request->title_in_arabic. '%')->get();
    	if(count($products)>0){
            return response()->json(['status_code'=>100,'status'=>'success','data'=>$products]);
    
    	}
    
    	else{
    		return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Product Exist']);
    	}
}

   }

   /*******************About Us****************/

   public function aboutus()
   {
   	$about=aboutus::first();
   	if(is_null($about)){
   	return response()->json(['status_code'=>100,'status'=>'success','data'=>'No aboutus Exist']);
   	}
   	return response()->json(['status_code'=>200,'status'=>'success','data'=>$about]);
   }

   public function faq(){
   	$faq=Faq::get();
   	if(count($faq)>0){
   	return response()->json(['status_code'=>200,'status'=>'success','data'=>$faq]);
   	}
   	else{
   	return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Faqs Exist']);
   	}
   }

   /*******************Contact Us****************/

   public function contactus(Request $request)
   {
   		 $email=User::where('roles','admin')->first();
            $contactus=Contactus::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'company' => $request->company,
                'message' => $request->message,
                ]);
        
        $to       = $email->email;
        $subject  = 'Query';
        $message  = $request->message;
        $messages = "
        <html>
        <title>HTML email</title>
        </head>
        <body>
        <h2>User Concern</h2>
        <p><b>Name:</b>$contactus->name</p>
        <p><b>Phone No:</b>$contactus->phone</p>
        <p><b>Company:</b>$contactus->company</p>
        
        <p>
        <b>
        Message:
        </b>
        </p>
        $message
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From:'.$request->email. "\r\n";
        $headers .= 'Cc: lal.bhinder@appcrates.com' . "\r\n";

        mail($to, $subject, $messages, $headers);
        return response()->json(['status_code'=>200,'status'=>'success','data'=>'Email Send Successfully']);
        }
   
   /*******************Cart****************/

   public function add_cart(Request $request)
   {
    $user_id     = $request->user_id;
    $product_id  = $request->product_id;
    $quantity    = $request->quantity;
    $price       = $request->price;
    $total_price = $quantity*$price;
    $check_cart=Cart::where('product_id',$product_id)->where('user_id',$user_id)->first();
    if(!is_null($check_cart)){
    
            $update_cart=Cart::where('product_id',$product_id)->where('user_id',$user_id)->update([
            'quantity'      => $check_cart->quantity+$quantity,
            'price'         => $price,
            'total_price'   => $check_cart->total_price+$total_price,
            ]);
        
        return response()->json(['status_code'=>200,'status'=>'success','data'=>'Update Product']);
    }
    $cart        = Cart::create([
                   'user_id'      => $user_id,
                   'product_id'   => $product_id,
                   'quantity'     => $quantity,
                   'price'        => $price,
                   'total_price'  => $total_price,
    ]);
    return response()->json(['status_code'=>200,'status'=>'success','data'=>$cart]);
   }

    public function cancel_cart_item(Request $request)
    {
    $cart_id=$request->cart_id;
    
    Cart::where('id',$cart_id)->delete();
    return response()->json(['status_code'=>200,'status'=>'success','data'=>'delete']);
   }

   public function update_cart(Request $request)
   {
        $user_id     = $request->user_id;
        $cart_id     = $request->cart_id;
        $product_id  = $request->product_id;
        $quantity    = $request->quantity;
        $price       = $request->price;
        $total_price = $quantity*$price;
        $cart_check  = Cart::where('id',$cart_id)->first();
        if(is_null($cart_check)){
        return response()->json(['status_code'=>100,'status'=>'failure','data'=>'No Order Exist']);
        }
        $cart        = Cart::where('id',$cart_id)->update([
                       'user_id'      => $user_id,
                       'quantity'     => $quantity,
                       'price'        => $price,
                       'total_price'  => $total_price,
        ]);
   return response()->json(['status_code'=>200,'status'=>'success','data'=>"Updated Successfully"]);
       }

   /*******************Order****************/

   public function add_order(Request $request)
   {
     
    $user_id         = $request->user_id;
    $address_id      = $request->address_id;
    $payment_method  = $request->payment_method;
    $payment_status  = $request->payment_status;
    $date            = $request->date;
    $cart            = cart::where('user_id',$user_id)->get();
    $total_price     = cart::where('user_id',$user_id)->sum('total_price');
    $order           = Order::create([
                       'user_id'        => $user_id,
                       'address_id'     => $address_id,
                       'date'           => date('Y-m-d'),
                       'time'           => date('H:i:s'),
                       'payment_method' => $payment_method,
                       'total_price'    => $total_price,
                       'payment_status' => $payment_status,
    ]);
    $order_category = array();
    $order_detail   = array();
    foreach($cart as $crt){
     $Orderdetail    = Orderdetail::create([
                       'user_id'      => $crt->user_id,
                       'order_id'        => $order->id,
                       'product_id'   => $crt->product_id,
                       'quantity'     => $crt->quantity,
                       'price'        => $crt->price,
                       'total_price'  => $crt->total_price,
    ]);
    
    }
    $orders=Order::
        join('orderdetails','orderdetails.order_id','=','orders.id')->
        join('products','orderdetails.product_id','=','products.id')->
        join('categories','products.category_id','=','categories.id')->
        select('categories.title_in_english as category_title_in_english','categories.title_in_arabic as category_title_in_arabic'
              )->where('orders.id',$order->id)->get();
        foreach($orders as $ord){
            $order_category[]=array(
            'category_title_in_english' => $ord->category_title_in_english,
            'category_title_in_arabic'  => $ord->category_title_in_arabic,
                );
        }
        
    Cart::where('user_id',$user_id)->delete();
    $order_detail=array(
            'category_type'     => $order_category,
            'Transaction_Time'  => $order->date,
            'Order_Number'      => $order->id,
            'Total'             => $order->total_price,
            'payment_method'    => $order->payment_method,
            );
    $token=User::where('id',$user_id)->first();
    $user=User::where('roles','admin')->first();
            $title='Order';
            $body="Your Order is Recieved";
            $tokens=array();
            $tokens[]= $token->app_token;
            echo $notifi = $this->send_push($title, $body, $tokens);
         
          Notification::create([
            'title' => $title,  
            'message' => $body,  
            'time' => date('H:i:s'),  
            'user_id' => $user_id,  
              ]);
        $email=User::where('roles','admin')->first();
        $to       = $token->email;
        $subject  = 'New Order';
        $messages = "
        <html>
        <head>
        <title>HTML email</title>
        </head>
        <body>
        <h2>Order</h2>
        <p><b>Order No:</b>$order->id</p>
        <p><b>Name:</b>$token->first_name $token->last_name</p>
        <p><b>Phone No:</b>$token->phone_number</p>
        <p>
        <b>
        Message:
        </b>
        </p>
        Your Order Recieved
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From:'.$user->email. "\r\n";
        $headers .= 'Cc: lal.bhinder@appcrates.com' . "\r\n";

        mail($to, $subject, $messages, $headers);
    return response()->json(['status_code'=>200,'status'=>'success','data'=>$order_detail]);
   }

   public function cancel_order(Request $request)
   {
    $order_id=$request->order_id;
    $order=Order::where('id',$order_id)->first();
    if(!is_null($order)){

    Order::where('id',$order_id)->update([
              'order_status' => '0',
    ]);

    return response()->json(['status_code'=>200,'status'=>'success','data'=>'Order Cancel Successfully']);
    }
    else{

    return response()->json(['status_code'=>100,'status'=>'success','data'=>'No Such Order Exist']); 

    }
   }
    
    public function get_cart(Request $request)
    {
        $cart=Cart::join('products','carts.product_id','=','products.id')
        ->select('carts.id as cart_id','carts.quantity','carts.price','carts.total_price','carts.product_id','products.title_in_english','products.title_in_arabic','products.image')
        ->where('carts.user_id',$request->user_id)->get();
        $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
        $cart_count=Cart::where('user_id',$request->user_id)->get();
        $sum=array();
        $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$cart,'sum'=>$sum]);
    }
    
     public function delete_cart(Request $request)
     {
        $cart=Cart::where('user_id',$request->user_id)->where('id',$request->cart_id)->delete();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>'Delete Successfully!']);
    }

    public function add_address(Request $request)
    {
        if($request->appartment==0){
            $appartment=0;
            $vila=$request->vila;
          }
        if($request->vila==0){
            $vila=0;
            $appartment=$request->appartment;
          }

        $address=Address::create([
            'user_id'     =>$request->user_id,
            'region'      =>$request->region,
            'appartment'  =>$appartment,
            'city'        =>$request->city,
            'vila'        =>$vila,
            'building_no' =>$request->building_no,
            'flat_no'     =>$request->flat_no,
            'house_no'    =>$request->house_no,
            
        ]);
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$address]);
    }

    public function get_address(Request $request)
    {
        $address=Address::where('user_id',$request->user_id)->get();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$address]);
    }

    public function get_region(){
        $region=Region::all();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$region]);
    }

    public function get_cities(Request $request)
    {
        $city=City::where('region_id',$request->region_id)->get();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$city]);
    }

     public function get_orders(Request $request)
     {
         $order_array=array();
         $orders=Order::join('addresses','orders.address_id','=','addresses.id')->select('orders.id','orders.date','orders.order_status'
         ,'addresses.region','addresses.state','addresses.city','addresses.appartment','addresses.vila'
         ,'addresses.building_no','addresses.flat_no','addresses.house_no')->where('orders.user_id',$request->user_id)->get();
        //  return $orders; 
         foreach($orders as $ord){
            
        $order=Orderdetail::
        join('users','orderdetails.user_id','=','users.id')->
        join('products','orderdetails.product_id','=','products.id')->
        join('categories','products.category_id','=','categories.id')->
        
        select( 'categories.title_in_english as category_title_in_english','categories.title_in_arabic as category_title_in_arabic'
                ,'products.title_in_english as product_title_in_english','products.title_in_arabic as product_title_in_arabic','orderdetails.quantity'
                
                )->where('orderdetails.order_id',$ord->id)->get();
                // return $order;
        $total_price_of_a_order=Orderdetail::where('order_id',$ord->id)->sum('total_price');
        if(!is_null($order)){
        if($ord->appartment!=1){
        $order_array[]=array(
                       "order_id"       => $ord->id,
                       "total_price"    => $total_price_of_a_order,
                       "date"           => $ord->date,
                       "address"        => $ord->region.','.$ord->city.','.$ord->state.','.$ord->house_no,
                       'status'         => $ord->order_status,
                       "order_detail"   => $order,
                       
            );
        }
        if($ord->vila!=1){
        $order_array[]=array(
                       "order_id"       => $ord->id,
                       "total_price"    => $total_price_of_a_order,
                       "date"           => $ord->date,
                       "address"        => $ord->region.','.$ord->city.','.$ord->state.','.$ord->building_no.','.$ord->flat_no,
                       "order_detail"   => $order,
                       
            );
        }
         }
         }
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$order_array]);
    }

    public function update_address(Request $request)
    {
        if($request->appartment==0){
            $appartment=0;
            $vila=$request->vila;
          }
        if($request->vila==0){
            $vila=0;
            $appartment=$request->appartment;
          }

        $address=Address::where('id',$request->address_id)->update([
            'region'=>$request->region,
            'appartment'=>$appartment,
            'city'=>$request->city,
            'vila'=>$vila,
            'building_no'=>$request->building_no,
            'flat_no'=>$request->flat_no,
            'house_no'=>$request->house_no,
            
        ]);
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$address]);
    }
    public function next_previous_caegory(Request $request)
    {
        if($request->next){
        $category=Category::where('id','>',$request->category_id)->first();
        $product_array=array();
        if(!is_null($category)){
            $products=Product::where('category_id',$category->id)->get();
            foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id"                        =>$product->id,
                "product_code"              =>$product->product_code,
                "title_in_english"          =>$product->title_in_english,
                "title_in_arabic"           =>$product->title_in_arabic,
                "description_in_english"    =>$product->description_in_english,
                "description_in_arabic"     =>$product->description_in_arabic,
                "image"                     =>$product->image,
                "price"                     =>$product->price,
                "discounted_price"          =>$product->discounted_price,
                "status"                    =>$product->status,
                'product_count'             =>count($cart_total_sum),
                
                );
            }
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
            $cart_count=Cart::where('user_id',$request->user_id)->get();
            $sum=array();
            $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
            $data=array(
                'category_id'                       => $category->id,
                'category_title_in_english'         => $category->title_in_english,
                'category_title_in_arabic'          => $category->title_in_arabic,
                'product_detail'                    => $product_array,
                );
            return response()->json(['status_code'=>200,'status'=>'success','data'=>$data,'sum'=>$sum]);
        }
        else{
            $first_category=Category::first();
            $products=Product::where('category_id',$first_category->id)->get();
             foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id"                        =>$product->id,
                "product_code"              =>$product->product_code,
                "title_in_english"          =>$product->title_in_english,
                "title_in_arabic"           =>$product->title_in_arabic,
                "description_in_english"    =>$product->description_in_english,
                "description_in_arabic"     =>$product->description_in_arabic,
                "image"                     =>$product->image,
                "price"                     =>$product->price,
                "discounted_price"          =>$product->discounted_price,
                "status"                    =>$product->status,
                'product_count'             =>count($cart_total_sum),
                
                );
            }
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
            $cart_count=Cart::where('user_id',$request->user_id)->get();
            $sum=array();
            $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
            $data=array(
                'category_id'                       => $first_category->id,
                'category_title_in_english'         => $first_category->title_in_english,
                'category_title_in_arabic'          => $first_category->title_in_arabic,
                'product_detail'                    => $product_array,
                );
            return response()->json(['status_code'=>200,'status'=>'success','data'=>$data,'sum'=>$sum]);
            
        }
        }
        if($request->previous){
            
        $category=Category::where('id','<',$request->category_id)->orderBy('id','DESC')->first();
        if(!is_null($category)){
            $products=Product::where('category_id',$category->id)->get();
            foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id"                        =>$product->id,
                "product_code"              =>$product->product_code,
                "title_in_english"          =>$product->title_in_english,
                "title_in_arabic"           =>$product->title_in_arabic,
                "description_in_english"    =>$product->description_in_english,
                "description_in_arabic"     =>$product->description_in_arabic,
                "image"                     =>$product->image,
                "price"                     =>$product->price,
                "discounted_price"          =>$product->discounted_price,
                "status"                    =>$product->status,
                'product_count'             =>count($cart_total_sum),
                
                );
            }
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
            $cart_count=Cart::where('user_id',$request->user_id)->get();
            $sum=array();
            $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
            $data=array(
                'category_id'                       => $category->id,
                'category_title_in_english'         => $category->title_in_english,
                'category_title_in_arabic'          => $category->title_in_arabic,
                'product_detail'                    => $product_array,
                );
            return response()->json(['status_code'=>200,'status'=>'success','data'=>$data,'sum'=>$sum]);
        }
        else{
            $first_category=Category::orderBy('id','DESC')->first();
            $products=Product::where('category_id',$first_category->id)->get();
            foreach($products as $product){
            $cart_total_sum=Cart::where('user_id',$request->user_id)->where('product_id',$product->id)->get();
            $product_array[]=array(
                "id"                        =>$product->id,
                "product_code"              =>$product->product_code,
                "title_in_english"          =>$product->title_in_english,
                "title_in_arabic"           =>$product->title_in_arabic,
                "description_in_english"    =>$product->description_in_english,
                "description_in_arabic"     =>$product->description_in_arabic,
                "image"                     =>$product->image,
                "price"                     =>$product->price,
                "discounted_price"          =>$product->discounted_price,
                "status"                    =>$product->status,
                'product_count'             =>count($cart_total_sum),
                
                );
            }
            $cart_total_sum=Cart::where('user_id',$request->user_id)->sum('total_price');
    	
            $cart_count=Cart::where('user_id',$request->user_id)->get();
            $sum=array();
            $sum=array(
                    'count'       => count($cart_count),
                    'total_price' => $cart_total_sum
            );
            $data=array(
                'category_id'                       => $first_category->id,
                'category_title_in_english'         => $first_category->title_in_english,
                'category_title_in_arabic'          => $first_category->title_in_arabic,
                'product_detail'                    => $product_array,
                );
            return response()->json(['status_code'=>200,'status'=>'success','data'=>$data,'sum'=>$sum]);
            
        }
        }
        
        
    }
    public function products_information(Request $request){
        $offset=$request->offset;
        $limit=$request->limit;
        $product=Product::offset($offset)->limit($limit)->get();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$product]);
    }
    public function get_notification(Request $request){
        $offset=$request->offset;
        $limit=$request->limit;
        $notification=Notification::where('user_id',$request->user_id)->orderBy('id','DESC')->offset($offset)->limit($limit)->get();
        $notification_array=array();
        foreach($notification as $notify){
            $notify_time=strtotime($notify->time);
            $current_time=strtotime(date('H:i:s'));
            $seconds=abs($notify_time-$current_time);
            $notification_array[]=array(
                'user_id'               => $notify->user_id,
                'title'                 => $notify->title,
                'message'               => $notify->message,
                'time'                  => $seconds,
                );
        }
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$notification_array]);
    }
    
    public function ads(){
        $ads=Ad::where('status','1')->get();
        return response()->json(['status_code'=>200,'status'=>'success','data'=>$ads]);
    }
}
