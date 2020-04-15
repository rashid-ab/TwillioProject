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

#dynamic-table_filter{
    display:none;
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

                            <a href="{{ url('new_product') }}"><button type="button" class="btn btn-danger">Add Product</button></a>

                            </div>

                        </header>
                    
              <div class="panel-body">
              <div class="adv-table">
            <form role='form' method='post' class="searches" >
            @csrf
            <input type='text' Placeholder='Category Name' style='margin-right:11px;float: left;width: 148px;' class='form-control cat' name='category_name' />
            <!--<input type='text' Placeholder='Status'  style='float: left;width:148px;' class='form-control' name='status' />-->
            <form/>
              <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
              <tr style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Product Code</th>
                <th style="text-align:center">Title in English</th>
                <th style="text-align:center">Title in Arabic</th>
                <th style="text-align:center">Description in English</th>
                <th style="text-align:center">Description in Arabic</th>
                <th style="text-align:center">Category Name</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Price</th>
                <th style="text-align:center">Discounted Price</th>
                 <th style="text-align:center">Current Status</th> 
                <th style="text-align:center">Actions</th>
              </tr>
              </thead>
              <tbody>
                    @php
                    
                    $count = 1;
                    
                    @endphp
                  @foreach ($products as $product)
                
                    <tr style="text-align:center" id="order_{{ $product->id }}" data-id="{{ $product->id }}" data-parent="">
                        <td>{{ $count }}</td> 
                        <td>{{ $product->product_code}}</td>
                        <td>{{ $product->title_in_english }}</td>
                        <td>{{ $product->title_in_arabic }}</td>
                        <td>{{ $product->description_in_english }}</td>
                        <td>{{ $product->description_in_arabic }}</td>
                        <td>{{ $product->category_name }}</td>                                       
                
                        <td><img src="{{ $product->image }}" class="img-rounded" style="width: 80px;height: 80px;"></td>
                    <td>{{ $product->price }} OMR</td>
                    <td>{{ $product->discounted_price }} OMR</td>
                    
                          <td> 
                          <?php if($product->status =='1')
                         {
                             echo "Active User";
                         }
                         elseif($product->status == 0)
                         {
                             echo "Blocked User";
                         }
                         ?>
                         <td>
                            <div class="icon_wraper">
                                <?php if($product->status==1) {?>
                                <a href="{{url('/block_product/'.$product->id)}}" data-toggle="tooltip" title="Block Product"><i class="fas fa-user-slash"></i></a>
                                <?php } else{ ?>
                                <button><i class=""></i></button>
                                 <a href="{{url('/un_block_product/'.$product->id)}}" data-toggle="tooltip" title="UnBlock Product"><i class="fas fa-user-alt"></i></a>
                                <?php } ?>  
                                <a href="{{url('/edit_product/'.$product->id)}}" class="edit_product" data-toggle="tooltip" title="Edit Product"><i class="fas fa-pencil-alt"></i></a>
                                <a id="{{$product->id}}" class="user_details" data-toggle="tooltip" title="Product Detail">
                                  
                                    <i class="fas fa-eye" data-toggle="modal" data-target="#myModalview"></i>
                                </a>
                                
                                <a href="{{url('/delete_product/'.$product->id)}}" class="delete_product" data-toggle="tooltip" title="Delete Product"><i class="fas fa-trash"></i></a>
                
                                
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
              
                    @endphp
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
          <h4 class="modal-title">Product Information</h4>
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
        
        $('#dynamic-table').DataTable();
       
        $('body').on('click','.user_details',function(){
           
            $.ajax({
                type: "GET",
                url: "{{url('get_product')}}/"+$(this).attr("id"),                          
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
            // return alert(orders);
            $.post('{{ url("/change_order_product") }}', 
                { orders : orders , _token: '{{csrf_token()}}'}, function(data) {
            location.reload(true);

      
    });


        }
    });
    $('.searches').keyup(function(e){
        var status = '';
        var count= 1;
        var clas;
        var url='';
        var title='';
        var base_url="{{url('/')}}";
        $.ajax({
            type: 'post',
            url: "{{ url('product_search') }}",
            data: $(this).serialize(),
            success: function(data) {
                if(data.length!=0){
                    $('#dynamic-table').DataTable().destroy();
                    $('tbody').html('');
                $.each(data,function(key,val){
                    if(val.status==1){
                        status='Active Product';
                        clas="fa-user-slash";
                        url='block_product';
                        title='Block Product';
                    }
                    else{
                        status='De-Active Product';
                        clas="fa-user-alt";
                        url='un_block_product';
                        title='UnBlock Product';
                    }
                    $('tbody').append(
                        '<tr style="text-align:center" id="order_'+val.id+'" data-id="'+val.id+'" data-parent="">'+
                        '<td>'+count+'</td>'+ 
                        '<td>'+val.product_code+'</td>'+
                        '<td>'+val.title_in_english+'</td>'+
                        '<td>'+val.title_in_arabic+'</td>'+
                        '<td>'+val.description_in_english+'</td>'+
                        '<td>'+val.description_in_arabic+'</td>'+
                        '<td>'+val.category_name+'</td>'+
                        '<td><img src='+val.image+' class="img-rounded" style="width: 80px;height: 80px;"></td>'+
                        '<td>'+val.price+'OMR</td>'+
                        '<td>'+val.discounted_price+'OMR</td>'+
                        '<td>'+status+'</td>'+
                        '<td><a href="'+base_url+'/'+url+'/'+val.id+'" data-toggle="tooltip" title='+title+'><i class="fas '+clas+'"></i></a>'+
                             '<a href='+base_url+'/edit_product/'+val.id+' class="edit_product" data-toggle="tooltip" title="Edit Product"><i class="fas fa-pencil-alt"></i></a>'+
                             '<a id='+val.id+' class="user_details" data-toggle="tooltip" title="Product Detail">'+
                             '<i class="fas fa-eye" data-toggle="modal" data-target="#myModalview"></i>'+
                             '</button></a>'+
                             '<a href=/delete_product/'+val.id+' class="delete_product" data-toggle="tooltip" title="Delete Product"><i class="fas fa-trash"></i></a>'+
                        '</td>'+
                        '</tr>'
                        
                        );
                        
                count++;
                
                });
               
            }
             $('#dynamic-table').DataTable();
                 $("#dynamic-table tbody").tableDnD({
                    onDrop: function(table, row) {
                    var orders = $.tableDnD.serialize();
                    // return alert(orders);
                    $.post("{{ url('/change_order_product') }}", 
                    { orders : orders , _token: '{{csrf_token()}}'}, function(data) {
                    location.reload(true);

      
    });


        }
    });
            }
        
    });
    });
    });

</script>
@endsection





