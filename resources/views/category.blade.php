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
                <div class="col-sm-12">
              <section class="panel">
            
             <header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

                            All Users

                            @if(Session::has('update'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('update') }}</h2>

                                </div>

                            @endif

                           

                            <div class="btn-holder" style="float: right;">

                            <a href="{{ url('new_category') }}"><button type="button" class="btn btn-danger">Add Category</button></a>

                            </div>

                        </header>
                    
              <div class="panel-body">
              <div class="adv-table">
              <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
              <tr style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Title in English</th>
                <th style="text-align:center">Title in Arabic</th>
                <th style="text-align:center">Image</th>
                 <th style="text-align:center">Current Status</th> 
                <th style="text-align:center">Actions</th>
              </tr>
              </thead>
              <tbody>
                  @php
                    
                    $count = 1;
                    
                    @endphp
                  @foreach ($categories as $category)
                
                    <tr style="text-align:center" id="order_{{ $category->id }}" data-id="{{ $category->id }}" data-parent="">
                        <td>{{ $count }}</td>
                        
                        <td>{{ $category->title_in_english }}</td>
                       
                        <td>{{ $category->title_in_arabic }}</td>                                       
                
                        <td><img src="{{ $category->image }}" class="img-rounded" style="width: 80px;height: 80px;"></td>
                
                          <td>
                         <?php if($category->status =='1')
                         {
                             echo "Active User";
                         }
                         elseif($category->status == '0')
                         {
                             echo "Blocked User";
                         }
                         ?> 
                         <td>
                            <div class="icon_wraper">
                                 <?php if($category->status==1) {?>
                                <a href="{{url('/block_category/'.$category->id)}}" data-toggle="tooltip" title="Block Category"><button><i class="fas fa-user-slash"></i></button></a>
                                <?php } else{ ?>
                               <button><i class=""></i></button>
                                <a href="{{url('/un_block_category/'.$category->id)}}" data-toggle="tooltip" title="UnBlock Category"><button><i class="fas fa-user-alt"></i></button></a>
                                <?php } ?>  
                                <a href="{{url('/edit_category/'.$category->id)}}" class="edit_category" data-toggle="tooltip" title="Edit Category"><button><i class="fas fa-pencil-alt"></i></button></a>
                                <a id="{{$category->id}}" class="user_details" data-toggle="tooltip" title="Category Detail">
                                  <button data-toggle="modal" data-target="#myModalview">
                                    <i class="fas fa-eye"></i>
                                </button></a>
                                
                                <a href="{{url('/delete_category/'.$category->id)}}" class="delete_category" data-toggle="tooltip" title="Delete Category"><button><i class="fas fa-trash"></i></button></a>
                
                                
                            </div>
                            
                         </td>
                    </tr>
                     @php
                    
                    $count++;
                    
                    @endphp

                                    @endforeach 
              
              </tbody>
              </table>
              </div>
              </div>
              </section>
              </div>
              </div>
              
              <!-- page end-->
          </section>
      </section>

                    
    <!--dynamic table initialization -->    



    <div class="overlay"><img src="{{url('assets/img')}}/spiner.gif"></div>

<div class="modal fade" id="myModalview" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Category Information</h4>
        </div>
        <div class="modal-body">
        <!-- Left-aligned -->
        <div class="media">
            
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script src="https://v71.appcrates.co/retroPixel/public/dist/advanced-datatable/jquery.tablednd_0_5.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $('#dynamic-table').DataTable({
       
        //   "order": [[ 0, "desc" ]]
     
});
        $('body').on('click','.user_details',function(){
           
            $.ajax({
                type: "GET",
                url: "{{url('get_category')}}/"+$(this).attr("id"),                          
                success: function(data) {  
                    // alert(data);
                    // return false;
                    $(".media").html(data);
                  },error: function(data){
                  
                  }
            });
          
        });
        $("#dynamic-table tbody").tableDnD({
        onDrop: function(table, row) {
            var orders = $.tableDnD.serialize();
            // alert(orders);
            $.post('{{ url("/change_order_category") }}', 
                { orders : orders , _token: '{{csrf_token()}}'}, function(data) {
      // alert(data);
      location.reload(true);

      
    });


        }
    });
    });

</script>
@endsection





