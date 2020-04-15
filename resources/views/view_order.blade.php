@extends('layouts.app')



@section('content')

<style type="text/css">

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

td:nth-child(even) {
  background-color: #dddddd;
}

	.overlay{

    opacity:0.8;

    background-color:#ccc;

    position:fixed;

    width:100%;

    height:100%;

    top:0px;

    left:0px;

    z-index:1000;

    display: none;



}

.overlay img {

    position: relative;

    z-index: 99999;

    left: 48%;

    right: -40%;

    top: 40%;

    width: 5%;

}
.set-inner-text .col-lg-6{text-align:center;}
.view_setp span{font-weight: bold;color: #1172c9;}
.view_setp h3{padding: 20px 0px;}
.view_setp h2{padding: 20px 0px !important;font-weight: bold;    text-transform: uppercase;}
</style>
<section class="view_setp">
    <div class="container">
        <div class="row set-inner-text">
            <div class="col-lg-12">
                 <h2 style="padding:10px;text-align: center;background-color: #f1f2f7;">Complete Order Detail</h2>
                    <div class="row ">
                        <div class="col-lg-6"><p style="font-size:17px;"><span>Order Number&nbsp;:</span>&nbsp;&nbsp;{{$order->id}}</p></div>
                        <div class="col-lg-6"><p style="font-size:17px;"><span>Order Date&nbsp;:</span>&nbsp;&nbsp;{{$order->date}}</p></div>
                    </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Booking Details:</h3>
                <div class="row ">
                    <div class="col-lg-12"><p style="font-size:17px; "><span>Client :  </span>&emsp;{{$order->first_name}} {{$order->last_name}}</p></div>
                    <div class="col-lg-12"><p style="font-size: 17px;"><span>Assigned Employee :  </span>&emsp; {{$booking_details->first_name}} {{$booking_details->last_name}}</p></div>
                    <div class="col-lg-12"><p style="font-size:17px; "><span>Address :  </span>&emsp;{{$order->street}} {{$order->city}} {{$order->area}}</p></div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12"><p style="font-size: 17px;"><span>Start Time  :  </span>&emsp;{{$order->time}}</p></div>
                    <div class="col-lg-12"><p style="font-size: 17px;"><span>End Time  :  </span>&emsp;{{$order->end_time}}</p></div>
                  </div>
                
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Service Details:</h3>
                <div class="row ">
                <div class="col-lg-12"><p style="font-size:17px;"><span>Service Type  :  </span>&emsp;{{$service_name->name}}</p></div>
                <div class="col-lg-12">
                  <div class="row">
                <div class="col-lg-12">
                     @if(count($order_rooms)>0)
                       <p style="font-size:17px;"><span>Rooms  :  </span></p>
                       @foreach($order_rooms as $ord_rooms)
                       <span style="padding:10px;float:left;width:100%;font-size: 17px;
                          color: #797979;font-weight: inherit;">{{$ord_rooms->room_name}}</span>
                          @endforeach
                     @endif
                      @if(count($order_windows)>0)
                      <p style="font-size:17px;">Windows:</p>
                      @foreach($order_windows as $ord)
                      <span style="font-size:17px; padding:10px;color: #797979;">{{$ord->no_of_windows}} x</span>
                      <span style="font-size:17px; padding:10px;color: #797979;">{{$ord->window_name}}</span>
                      <span style="font-size:17px; padding:10px;color: #797979;">{{$ord->window_side}} Sides</span>
                      </br>
                      @endforeach
                    @endif
                </div>
              </div>
               </div> 
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                    @if(count($additional_service)>0)
                       <h3 style="color: #79797994">Additional Services:</h3>
                       @foreach($additional_service as $ordd)
                       <div style="width: 100%;float: left;">
                       <span style="font-size:20px; padding:10px;float:left;font-size: 17px;
                                font-weight: bold;">{{$ordd->quantity}}x</span>
                       <span style="font-size:20px; padding:10px 0px;float:left;font-size: 17px;
                           font-weight: bold;">{{$ordd->add_service}}</span>
                           </div>
                         </br>
                         </br>
                            @endforeach
                    @endif
        </div>   
      </div>
        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Other Details:</h3>
                <div class="row ">
                <div class="col-lg-6">
                    <p style="font-size:17px;"><span>Key  :  </span>&emsp;{{$order->order_key}}</p>
                    <p style="font-size:17px;"><span>I have  :  </span>&emsp;{{$order->order_have}}</p>
                    <p style="font-size:17px;"><span>Paslock  :  </span>&emsp;{{$order->order_paslock}}</p>
                </div>
                
              </div>
            </div>
        </div>  
        <div class="row ">
            <div class="col-lg-12">
              
                @if(count($images)>0)
                      <h3 style="color: #79797994">Attachment:</h3>
                      <div class="row">
                        <div class="col-lg-12">
                      @foreach($images as $img)
                      
                        <div class="row " style="margin-bottom: 20px;">
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                        <img src="{{$img->image_url}}" style="width:100%" />
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <p style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                        ">{{$img->description}}</p>
                        </div>
                      </div>
                      @endforeach
                    </div>
                      </div>
                @endif
            
        </div>  
      </div>
        <div class="row ">
            <div class="col-lg-12">
                @if(count($feed_back)>0)
                   <h3 style="color: #79797994"><span>Feed Back  :  </span></h3>
                @foreach($feed_back as $feed)
                   <div class="row" style="margin-bottom: 20px;">
                      <div class="col-lg-3 "><img src="{{$feed->image}}" style="width:100%" /></div>
                      <div class="col-lg-12 "><p style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                      font-weight: bold;"><p style="font-size: 17px;"><span>Stars  :  </span>&emsp; {{$feed->stars}}</p></p>
                      </div>
                     <div class="col-lg-12"><p style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                       font-weight: bold;"><p style="font-size: 17px;"><span>Note  :  </span>&emsp;{{$feed->note}}</p></p></div>
                     </div>
                        @endforeach
                         @endif
            </div>
        </div>   
    </div>
</section>

</div>
@endsection