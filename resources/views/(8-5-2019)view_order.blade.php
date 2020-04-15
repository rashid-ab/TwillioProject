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
.view_setp p{font-weight: bold;}
.view_setp h3{padding: 20px 0px;}
.view_setp h2{padding: 20px 0px !important;font-weight: bold;    text-transform: uppercase;}
</style>
<section class="view_setp">
    <div class="container">
        <div class="row set-inner-text">
            <div class="col-lg-12">
                 <h2 style="padding:10px;text-align: center;background-color: #f1f2f7;">Complete Order Detail</h2>
                    <div class="row ">
                        <div class="col-lg-6"><p style="font-size:17px;">Order Number:{{$order->id}}</p></div>
                        <div class="col-lg-6"><p style="font-size:17px;">Order Date:{{$order->date}}</p></div>
                    </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Booking Details:</h3>
                <div class="row ">
                    <div class="col-lg-6"><p style="font-size:17px; ">Client :{{$order->first_name}} {{$order->last_name}}</p></div>
                    <div class="col-lg-6"><p style="font-size: 17px;">Assigned Employee : {{$booking_details->first_name}} {{$booking_details->last_name}}</p></div>
                    <div class="col-lg-6"><p style="font-size:17px; ">Address :{{$order->street}} {{$order->city}} {{$order->area}}</p></div>
                    </div>
                    <div class="row">
                    <div class="col-lg-6"><p style="font-size: 17px;">start Time:{{$order->time}}</p></div>
                    <div class="col-lg-6"><p style="font-size: 17px;">End Time:{{$order->end_time}}</p></div>
                  </div>
                
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Service Details:</h3>
                <div class="row ">
                <div class="col-lg-12"><p style="font-size:17px;">Service Type :{{$service_name->name}}</p></div>
                <div class="col-lg-12">
                  <div class="row">
                <div class="col-lg-6">
                     @if(count($order_rooms)>0)
                       <p style="font-size:17px;">Rooms:</p>
                       @foreach($order_rooms as $ord_rooms)
                       <span style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                          font-weight: bold;">{{$ord_rooms->room_name}}</span>
                          @endforeach
                     @endif
                </div>
                <div class="col-lg-6">
                    @if(count($order_windows)>0)
                      <p style="font-size:17px;">Windows:</p>
                      @foreach($order_windows as $ord)
                      <span style="font-size:20px; padding:10px;">{{$ord->window_name}}</span>
                      <span style="font-size:20px; padding:10px;">{{$ord->window_side}}</span>
                      <span style="font-size:20px; padding:10px;">{{$ord->no_of_windows}}</span>
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
                       <span style="font-size:20px; padding:10px 0px;float:left;width:100%;font-size: 17px;
                           font-weight: bold;">{{$ordd->add_service}}</span>
                           <span style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                                font-weight: bold;">{{$ordd->quantity}}</span>
                            @endforeach
                    @endif
        </div>   
      </div>
        <div class="row ">
            <div class="col-lg-12">
                <h3 style="color: #79797994">Other Details:</h3>
                <div class="row ">
                <div class="col-lg-6">
                    <p style="font-size:17px;">{{$order->order_have}}</p>
                    <p style="font-size:17px;">{{$order->order_key}}</p>
                    <p style="font-size:17px;">{{$order->order_paslock}}</p>
                </div>
                <div class="col-lg-6"></div>
              </div>
            </div>
        </div>  
        <div class="row ">
            <div class="col-lg-12">
              
                @if(count($images)>0)
                      <h3 style="color: #79797994">Attachment:</h3>
                      <div class="row">
                      @foreach($images as $img)
                      <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 ">
                        <img src="{{$img->image_url}}" style="width:100%" />
                        <span style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
                          font-weight: bold;text-align:center;">{{$img->description}}</span>
                        </div>
                      @endforeach
                      </div>
                @endif
            
        </div>  
      </div>
        <div class="row ">
            <div class="col-lg-12">
                @if(count($feed_back)>0)
<h3 style="color: #79797994">Feed Back:</h3>
@foreach($feed_back as $feed)
<div class="row" style="margin-bottom: 20px;">
<div class="col-lg-4 col-xs-12 col-md-3 "><img src="{{$feed->image}}" style="width:100%" /></div>
<div class="col-lg-4 col-xs-12 col-md-3 "><span style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
    font-weight: bold;text-align:center;"><p style="font-size: 17px;">Stars</br>{{$feed->stars}}</p></span></div>
    <div class="col-lg-4 col-xs-12 col-md-3 "><span style="font-size:20px; padding:10px;float:left;width:100%;font-size: 17px;
    font-weight: bold;text-align:center;"><p style="font-size: 17px;">Note</br>{{$feed->note}}</p></span></div>
  </div>
@endforeach
@endif
            </div>
        </div>   
    </div>
</section>

</div>
@endsection