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

                    <section class="panel">

                        <header class="panel-heading">


                            @if(Session::has('message'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('message') }}</h2>

                                </div>

                            @endif

                           
                          

                            <div class="btn-holder" style="float: right;">

                           

                            </div>

                        </header>

                        <div class="panel-body">

                        <!--         <form role="form"> -->
                        <form role="form"  method="post" 
                              class="add_squar_meter squar_meter_table">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                
                                 <div class="form-group">
                                     
                                      <select class="form-control" name='setting_services_name'>
                                          @foreach($services as $serv)
                                          <option>{{$serv->setting_services_name}}</option>
                                          @endforeach
                                      </select>
                                 </div>
                                  
                                 <div class="form-group">
                                      <label>Quantity</label>
                                      <input type="text" class="form-control" 
                                      name="quantity" required >
                                  </div>

                                  <div class="form-group">
                                      <label>Price</label>
                                      <input type="text" class="form-control" 
                                      name="price" required >
                                  </div>

                                 <button type="submit" class="btn btn-success ">Save</button>
                                  
                            </form>

                        

                        </div>

                    </section>

                </div>

            </div>



            <!-- page end-->

        </section>

    </section>

    <!--dynamic table initialization -->    
<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script >
    $(document).ready(function(){
    
    $('.squar_meter_table').submit(function(e){
      
    e.preventDefault();
     $.ajax({
        type:'post',
        url:'{{ url('/create_squar_meter') }}',
          dataType:'json',
          data:$(this).serialize(),
          success:function(data){
             
          toastr.success('Added Successfully!');
                  $('.form-control').val('');
                  return false;
            
          },
      });
    });
    
    
   
    });
</script>

@endsection





