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

                <div class="col-sm-4">

                    <section class="panel">

                        <header class="panel-heading">

                            Send Custom Push Notification

                            @if(Session::has('message'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('message') }}</h2>

                                </div>

                            @endif

                           

                            <div class="btn-holder" style="float: right;">

                           <!--  <a href="{{ url('newcustomer') }}"><button type="button" class="btn btn-danger">Add New</button></a> -->

                            </div>

                        </header>

                        <div class="panel-body">

                        <!--         <form role="form"> -->
                        <form role="form" method="post" action="{{ url('send_push_notification') }}" >

<input type="hidden" name="_token" value="{{ csrf_token() }}">

                                  <div class="form-group">
                                      <label>Title</label>
                                      <input type="text" class="form-control" name="title" required >
                                  </div>
                                  <div class="form-group">
                                      <label >Message</label>
                                      <textarea name="body" class="form-control" required></textarea>
                                  </div>
                                  <!-- <div class="checkbox">
                                      <label>
                                          <input type="checkbox"> Check me out
                                      </label>
                                  </div> -->
                                  <button type="submit" class="btn btn-info">Send</button>
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





