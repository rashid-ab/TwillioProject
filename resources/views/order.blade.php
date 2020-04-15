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

                          

                            </div>

                        </header>
                    
              <div class="panel-body squar_meter_table" >
              <div class="adv-table">
              <table  class="display table table-bordered table-striped " id="dynamic-table1">
              <thead>
              <tr   style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">User Name</th>
                <th style="text-align:center">Price</th>
                <th style="text-align:center">Date</th>
                <th style="text-align:center">Payment Method</th>
                <!--<th style="text-align:center">Payment Status</th>-->
                <th style="text-align:center">Order Status</th>
                <th style="text-align:center">Action</th>
              </tr>
              </thead>
              <tbody>
                 
                        @foreach ($orders as $order)
                
                    <tr style="text-align:center">
                        <td>{{ $order->id }}</td> 
                        
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td>{{ $order->total_price }}</td>                                       
                        <td>{{ $order->date }}</td>
                         <td>
                         <?php if($order->payment_method =='1')
                         {
                             echo "Cash Payment";
                         }
                         elseif($order->payment_method == 0)
                         {
                             echo "Card Payment";
                         }
                         ?>
                       </td>
                       <!--<td>-->
                       <!--  <php if($order->payment_status =='1')-->
                       <!--  {-->
                       <!--      echo "Pending";-->
                       <!--  }-->
                       <!--  elseif($order->payment_status == 0)-->
                       <!--  {-->
                       <!--      echo "Paid";-->
                       <!--  }-->
                       <!--  ?>-->
                       <!--</td>-->
                       <td>
                         <?php if($order->order_status =='1')
                         {
                             echo "Active";
                         }
                         elseif($order->order_status == 0)
                         {
                             echo "Cancel";
                         }
                         elseif($order->order_status == 2)
                         {
                             echo "Complete";
                         }
                         ?>
                       </td>
                         <td>
                                <div class="dropdown">
                                <i class="fas fa-info dropdown-toggle" data-toggle="dropdown" style="font-size: 15px;margin-right: 4px;color: #337ab7;" title="Order Status"></i>
                                <ul class="dropdown-menu pai" style="padding:34px">
                                <form method="post" action="{{url('order_status/'.$order->id)}}" role="form">
                                    @csrf    
                                <li><button style="width:90px; background:#6dbb4a;padding: 1px;font-size: 15px;margin-bottom: 6px;" class="btn btn-success" type="submit" value="complete" name='complete'>Complete</button></li>
                                <li><button style="width:90px; background:#53bee6;padding: 1px;font-size: 15px;margin-bottom: 6px;" class="btn btn-info" type="submit" value="active" name='active'>Active</button></li>
                                <li><button style="width:90px; background:#ec6459;padding: 1px;font-size: 15px;margin-bottom: 6px;" class="btn btn-danger" type="submit" value="cancel" name='cancel'>Cancel</button></li>
                                </form>
                                </ul>
                                <?php if($order->payment_status==0) {?>
                                <a href="{{url('/pending_payment_status/'.$order->id)}}" data-toggle="tooltip" title="Payment Pending"> <i class="far fa-money-bill-alt"></i></a>
                                <?php } else{ ?>
                                <a href="{{url('/paid_payment_status/'.$order->id)}}" data-toggle="tooltip" title="Payment Paid"><i class="fas fa-money-bill-wave"></i></a>
                                <?php } ?>
                                <a href="{{url('/orderdetail/'.$order->id)}}" style="font-size:17px;" class="user_details"  title="Order Detail">
                                  
                                    <i class="fas fa-eye"></i>
                               </a>
                                </div>
                                
                              

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





