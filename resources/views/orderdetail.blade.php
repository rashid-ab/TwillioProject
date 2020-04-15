@extends('layouts.app')
@section('content')
<style type="text/css">
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

</style>
<span>Order ID: {{$order['order_id']}}</span>
<span>Customer Name: {{$order['name']}}</span>
<span>Phone Number: {{$order['phone_number']}}</span>
<span>Date: {{$order['date']}}</span>
<span>Time: {{$order['time']}}</span>
<span>Address: {{$order['address']}}</span>
<span>Total Price: {{$order['total_price']}}</span>
<span>Payment Method: {{$order['payment_method']}}</span>
<span>Payment Status: {{$order['payment_status']}}</span>
@foreach($order['order_detail'] as $ord)
<span>Product Name: {{$ord->product_title_in_english}} {{$ord->product_title_in_arabic}}</span>
<span><img src="{{$ord->image}}" style="width:200px;height:200px" /> </span>
<span>Quantity: {{$ord->quantity}}</span>
<span>Price Per Product: {{$ord->price}}</span>
@endforeach

@endsection
