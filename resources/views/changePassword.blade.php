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

    <section id="main-content">

        <section class="wrapper">

            <!-- page start-->

            <div class="row">
<div class="col-sm-4" >
    </div>
                <div class="col-sm-4" >

                    <section class="panel">

                        <header class="panel-heading">


                            @if(Session::has('message'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('message') }}</h2>

                                </div>

                            @endif

                           
                            Change Password

                            <div class="btn-holder" style="float: right;">

                           <!--  <a href="{{ url('newcustomer') }}"><button type="button" class="btn btn-danger">Add New</button></a> -->

                            </div>

                        </header>

                        <div class="panel-body">

                        <!--         <form role="form"> -->
                        <form role="form" method="post" 
                              action="{{ url('send_pass_var') }}" >

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                 <div class="form-group">
                                      <label>Old Password</label>
                                      <input type="Password" class="form-control" 
                                      name="oldPassowrd" required >
                                  </div>

                                  <div class="form-group">
                                      <label>New Password</label>
                                      <input type="Password" class="form-control" 
                                      name="newPassowrd" required >
                                  </div>

                                  <div class="form-group">
                                      <label>Confirm Password</label>
                                      <input type="Password" class="form-control" 
                                      name="confermPassowrd" required >
                                  </div>


                 

                                  <button type="submit" class="btn btn-success">Save</button>
                                  <button type="button" class="btn btn-danger">Cancel</button>
                            </form>

                        </div>

                    </section>

                </div>

            </div>



            <!-- page end-->

        </section>

    </section>

    <!--dynamic table initialization -->    


@endsection





