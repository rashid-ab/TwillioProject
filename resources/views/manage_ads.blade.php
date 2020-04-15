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
            
             <header class="panel-heading">

                            All Ad's

                            @if(Session::has('message'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('message') }}</h2>

                                </div>

                            @endif

                           

                            <div class="btn-holder" style="float: right;">

                             <a href="{{ url('add_ads') }}"><button type="button" class="btn btn-danger">Add New</button></a> 

                            </div>

                        </header>
                    
              <div class="panel-body">
              <div class="adv-table">
              <table  class="display table table-bordered table-striped" id="dynamic-table">
              <thead>
              <tr style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Ad Type</th>
                <th style="text-align:center">Title In Englis</th>
                <th style="text-align:center">Title In Arabic</th>
                <th style="text-align:center">Text In English</th>
                <th style="text-align:center">Text In Arabic</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Current Status</th> 
                <th style="text-align:center">Actions</th>
              </tr>
              </thead>
              <tbody>
                  @foreach ($ads as $ad)
                
                    <tr style="text-align:center">
                        <td>{{ $ad->id }}</td> 
                        
                        <td>{{ $ad->ad_type }}</td>
                        <td>{{ $ad->title_in_english }}</td>
                        <td>{{ $ad->title_in_english }}</td>
                        <td>{{ $ad->text_in_english }}</td>
                        <td>{{ $ad->text_in_arabic }}</td>
                        <td>{{ $ad->image }}</td>
                         <td> 
                          <?php if($ad->status =='1')
                         {
                             echo "Active Ad";
                         }
                                elseif($ad->status == 0)
                         {
                             echo "Blocked Ad";
                         }
                         ?> 
                         <td>
                            <div class="icon_wraper">
                                <a href="{{url('/edit_ad/'.$ad->id)}}" data-toggle="tooltip" title="Edit Ad"><button><i class="fas fa-pencil-alt"></i></button></a>
                                 <?php if($ad->status==1) { ?>
                                <a href="{{url('/block_ad/'.$ad->id)}}" data-toggle="tooltip" title="Block Ad"><button><i class="fas fa-user-slash"></i></button></a>
                                <?php } else{ ?>
                                <button><i class=""></i></button>
                                <a href="{{url('/un_block_ad/'.$ad->id)}}" data-toggle="tooltip" title="UnBlock Ad"><button><i class="fas fa-user-alt"></i></button></a>
                                <?php } ?>
                                <a id="{{$ad->id}}" class="user_details" data-toggle="tooltip" title="Ad Detail">
                                  <button data-toggle="modal" data-target="#myModalview">
                                    <i class="fas fa-eye"></i>
                                </button></a>
                                
                                <a href="{{url('/delete_ad/'.$ad->id)}}" class="delete_user" data-toggle="tooltip" title="Delete User"><button><i class="fas fa-trash"></i></button></a>
                
                                
                            </div>
                            
                         </td>
                    </tr>

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
          <h4 class="modal-title">Ad Information</h4>
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


<script type="text/javascript">
    $(function(){
        $('body').on('click','.user_details',function(){
           
            $.ajax({
                type: "GET",
                url: "{{url('ad_details')}}/"+$(this).attr("id"),                          
                success: function(data) {  
                    // alert(data);
                    // return false;
                    $(".media").html(data);
                  },error: function(data){
                  
                  }
            });
          
        });
    });

</script>
@endsection





