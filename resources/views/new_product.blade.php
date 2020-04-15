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

    <section id="main-content" >

        <section class="wrapper">

            <!-- page start-->

            <div class="row">
<div class="col-sm-4" >
</div>
                <div class="col-sm-4" >

                    <section class="panel">

                        <header class="panel-heading">


                          @if(Session::has('success'))
           <div class="alert alert-success">
             {{ Session::get('success') }}
           </div>
        @endif
        
                          @if(Session::has('duplicate'))
           <div class="alert alert-danger">
             {{ Session::get('duplicate') }}
           </div>
        @endif
            
          
                           
                            Add Product

                            <div class="btn-holder" style="float: right;">

                           <!--  <a href="{{ url('newcustomer') }}"><button type="button" class="btn btn-danger">Add New</button></a> -->

                            </div>

                        </header>

                        <div class="panel-body">

                        <!--         <form role="form"> -->
                        <form role="form" method="post" 
                              class="add_employee" enctype="multipart/form-data">

        						 <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                 <div class="form-group">
                                      <label>Product Code</label>
                                      <input type="text" class="form-control" 
                                      name="product_code" required >
                                 </div>

                                 <div class="form-group">
                                      <label>Title in English</label>
                                      <input type="text" class="form-control" 
                                      name="title_in_english" required >


                                 </div>

                                 <div class="form-group">
                                      <label>Title in Arabic</label>
                                      <input type="text" class="form-control" 
                                      name="title_in_arabic" required >
                                 </div>

                                 <div class="form-group">
                                      <label>Description in English</label>
                                      <input type="text" class="form-control" 
                                      name="description_in_english" required >


                                 </div>

                                 <div class="form-group">
                                      <label>Description in Arabic</label>
                                      <input type="text" class="form-control" 
                                      name="description_in_arabic" required >
                                 </div>

                                 <div class="form-group">
                                      <label>Category</label>
                                 <select class="form-control" name="category_id">
                                 	<option>Select</option>
                                 	@foreach($categories as $category)
                                 	<option value="{{$category->id}}">{{$category->title_in_english}}  {{$category->title_in_arabic}}</option>
                                 	@endforeach
                                 </select>
                                 </div>

                                 <div class="form-group">
                                      <label>Image</label>
                                      <input type="file" class="form-control avatar" 
                                      name="image" required >
                                 </div>

                                 <div class="form-group">
                                      <label>Price</label>
                                      <input type="text" class="form-control" 
                                      name="price"  required>
                                 </div>
                                 <div class="form-group">
                                      <label>Discounted Price</label>
                                      <input type="text" class="form-control" 
                                      name="discounted_price"  >
                                 </div>
								
								 <button type="submit" class="btn btn-success save">Save</button>
                                  
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
    $('.save').click(function(e){
    	
    	var values=$('select').val();
    	if(values=='Select'){
    		e.preventDefault();
    		alert('Select A Category');
    		return false;
    	}
    	else{
    		window.location.href="{{url('/new_product')}}";
    	}
    });
    
    });
</script> 

@endsection





