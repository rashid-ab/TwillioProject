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

                           
                       
                            @if(Session::has('Success'))

                                <div class="alert alert-success">

                                    {{ Session::get('Success') }}

                                </div>

                            @endif

                           

                            <div class="btn-holder" style="float: right;">

                            <a href="{{ url('new_admin') }}"><button type="button" class="btn btn-danger">Add Admin</button></a>

                            </div>

                        </header>
                    
              <div class="panel-body squar_meter_table" >
              <div class="adv-table">
              <table  class="display table table-bordered table-striped " id="dynamic-table1">
              <thead>
              <tr style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Email</th>
                <th style="text-align:center">Number</th>
                <th style="text-align:center">Image</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Action</th>
              </tr>
              </thead>
              <tbody>
                 
                        @foreach ($admins as $admin)
                
                    <tr style="text-align:center">
                        <td>{{ $admin->id }}</td> 
                        
                        <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                        <td>{{ $admin->email }}</td>                                       
                        <td>{{ $admin->phone_number }}</td>
                        <td><img src="{{ $admin->avatar }}" class="img-rounded" style="width: 80px;height: 80px;" /></td>
                         
                       <td>
                         <?php if($admin->status =='1')
                         {
                             echo "Active";
                         }
                         elseif($admin->status == 0)
                         {
                             echo "Cancel";
                         }
                         
                         ?>
                       </td>
                         <td>
                                
                                <?php if($admin->status==1) {?>
                                <a href="{{url('/block_admin/'.$admin->id)}}" data-toggle="tooltip" title="Block Admin"> <i class="fas fa-user-slash"></i></a>
                                <?php } else{ ?>
                                <a href="{{url('/un_block_admin/'.$admin->id)}}" data-toggle="tooltip" title="UnBlock Admin"><i class="fas fa-user-alt"></i></a>
                                <?php } ?>
                                <a id="{{$admin->id}}" class="user_details" data-toggle="tooltip" title="Admin Detail">
                                  
                                    <i class="fas fa-eye" data-toggle="modal" data-target="#myModalview"></i>
                                  
                                    
                               </a>
                                
                              

                               </div>
                               
                
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
          <h4 class="modal-title">User Information</h4>
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
<!--<script-->
<!--  src="https://code.jquery.com/jquery-3.4.0.js"-->
<!--  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="-->
<!--  crossorigin="anonymous"></script>-->

<script type="text/javascript">
     $(document).ready(function(){
         $('#dynamic-table1').DataTable({
       
           "order": [[ 0, "desc" ]]
     
});
       
    });

</script>

@endsection





