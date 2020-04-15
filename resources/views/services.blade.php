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
                        Services
                           
                       
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
              <tr style="text-align:center">
                <th style="text-align:center">ID</th>
                <th style="text-align:center">Services</th>
                <th style="text-align:center">Avatar</th>
                <th style="text-align:center">Starting Price</th>
                <th style="text-align:center">Text Info</th>
                <th style="text-align:center">Hint Text</th>
                <th style="text-align:center">Action</th>
                
              </tr>
              </thead>
              <tbody>
                  @foreach ($services as $serv)
               
                    <tr style="text-align:center">
                 
                      
                                                         
                
                        <td>{{ $serv->id }}</td>
                        
                        <td>{{ $serv->name }}</td>
                        
                        <td><img src="{{ $serv->image }}" class="img-circle" style="width:50px "/></td>
                
                         <td>{{ $serv->price }}</td>
                         
                         <td>{{ $serv->text_info }}</td>
                         
                         <td>{{ $serv->hint_text }}</td>
                         
                         
                         
                         
                         <td>
                            <div class="icon_wraper">
                               
                                <a id="{{$serv->id}}" class="service_details" data-toggle="tooltip" title="Service Detail">
                                  <button data-toggle="modal" data-target="#myModalview">
                                    <i class="fas fa-eye"></i>
                                </button></a>
                                <a class="edit_window" href="{{url('/edit_service/'.$serv->id)}}"  title="Edit Service"><i class="fa fa-pencil" style="font-size: 18px;"  aria-hidden="true"></i></a>
                                
                                
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
          <h4 class="modal-title">Service Information</h4>
        </div>
        <div class="modal-body">
        <!-- Left-aligned -->
        <div class="media">
         <table class="table table-responsive">
          <tr>
              
              <th>Service Name</th>
              <th>Image</th>
              <th>Starting Price</th>
              
          </tr>
          <tbody class="app_settings">
              
          </tbody>
         </table>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
     $(document).ready(function(){
        $('body').on('click','.service_details',function(){
            // alert($(this).attr("id"));
            //       return false;
            $.ajax({
                type: "GET",
                url: "{{url('view_service')}}/"+$(this).attr("id"),                          
                success: function(data) {
                    $('.app_settings').html('');
               $(".app_settings").append(
                   
                   '<tr>'+
                        '<td>'+data.services.name+'</td>'+
                        '<td><img class="img-circle" style="width:50px" src="'+data.services.image+'" /></td>'+
                        '<td>'+data.services.price+'</td>'+
                        '</tr>'
                        );
                        if(data.services.id=='1'){
                            $(".app_settings").append(
                                '<tr>'+
              '<th>Service Name</th>'+
              '<th>(sqm) Area Cleanable Per Hour </th>'+
              '<th>Price Per Hour</th>'+
              '</tr>'+
                   '<tr>'+
                        '<td>'+data.app_setting.setting_services_name+'</td>'+
                        '<td>'+data.app_setting.quantity+'</td>'+
                        '<td>'+data.app_setting.price+'</td>'+
                        '</tr>'
                        );
                        return false;
                        }
                        if(data.services.id=='2'){
                            $(".app_settings").append(
                                '<tr>'+
              '<th>Service Name</th>'+
              '<th>(sqm) Area Cleanable Per Hour </th>'+
              '<th>Price Per Hour</th>'+
              '</tr>'+
                   '<tr>'+
                        '<td>'+data.app_setting.setting_services_name+'</td>'+
                        '<td>'+data.app_setting.quantity+'</td>'+
                        '<td>'+data.app_setting.price+'</td>'+
                        '</tr>'
                        );
                        return false;
                        }
                        if(data.services.id=='4'){
                            $(".app_settings").append(
                                '<tr>'+
              '<th>Service Name</th>'+
              '<th>(sqm) Area Cleanable Per Hour </th>'+
              '<th>Price Per Hour</th>'+
              '</tr>'+
                   '<tr>'+
                        '<td>'+data.app_setting.setting_services_name+'</td>'+
                        '<td>'+data.app_setting.quantity+'</td>'+
                        '<td>'+data.app_setting.price+'</td>'+
                        '</tr>'
                        );
                        return false;
                        }
                   else{
                       
                        $(".app_settings").append(
                                '<tr>'+
              '<th>Service Name</th>'+
              '<th>Cleaning Time (Minutes)</th>'+
              '<th>Unit Price</th>'+
              '</tr>'
              );
                    $.each(data.app_setting,function(f,v){
                        if(v.setting_services_name=='Window Deposit Amount')
                        { $(".app_settings").append(
                        '<tr>'+
                        '<td>'+v.setting_services_name+'</td>'+
                        '<td></td>'+
                        '<td>'+v.price+'</td>'+
                        '</tr>'
                        );   
                            
                        }
                        else{
                    $(".app_settings").append(
                        '<tr>'+
                        '<td>'+v.setting_services_name+'</td>'+
                        '<td>'+v.quantity+'</td>'+
                        '<td>'+v.price+'</td>'+
                        '</tr>'
                        ); 
                        }
                    });
                    }
                  },error: function(data){
                  
                  }
            });
          
        });
        $('.squar').click(function(){
            $('.squar_meter_table').css('display','block');
            $('.window_table').css('display','none');
             $('.window_tables').DataTable().destroy();
             $('#dynamic-table1').DataTable({
       "columnDefs": [
          { "targets": [0,1,2,3,4,5], "orderable": false }
      ]
});
        });
        $('.windows').click(function(){
            $('.window_table').css('display','block');
             $('.squar_meter_table').css('display','none');
              $('#dynamic-table1').DataTable().destroy();
              $('.window_tables').DataTable({
       "columnDefs": [
          { "targets": [0,1,2,3,4,5], "orderable": false }
      ]
});
        });
        
        $('#dynamic-table1').DataTable({
       "columnDefs": [
          { "targets": [0,1,2,3,4,5], "orderable": false }
      ]
});
       
    });

</script>

@endsection





