@extends('layouts.app')
@section('content')

<style type="text/css">

button.fc-basicWeek-button.fc-button.fc-state-default {
    display: none;
}

button.fc-basicDay-button.fc-button.fc-state-default.fc-corner-right {
    display: none;
}

a.fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end{
    height:173px;
    margin: -22px auto;
    border:0px !important;
    border-radius:0px !important;
}
 .fc-end{
    height: 177px !important;
}
/*.fc-day-grid-event {*/
/*    margin: 0px 0px !important;*/
/*    padding: 0 !important;*/
/*}*/

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

    <link href="{{asset('public/dist')}}/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{asset('public/dist')}}/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" media="screen"/>


    <section id="main-content">
        <section class="wrapper">
            <div class="alert notification" style="display: none;">
                <button class="close" data-close="alert"></button>
                <p></p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <section class="panel">

                        <header class="panel-heading">

                            Manage Settings

                            <div class="btn-holder" style="float: right;">
                                <a href="javascript:void (0)" class="btn btn-success add_calendar"> ADD NEW SETTING
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>



                        </header>
                        <div class="panel-body">

                            @if(Session::has('message'))
                                <div class="alert-box success">
                                    <h2>{{ Session::get('message') }}</h2>
                                </div>

                            @endif




                        <div id="calendarIO">

                         </div>
                         <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <form class="form-horizontal" method="POST" action="POST" id="form_create">
                                                <input type="hidden" name="calendar_id" value="0">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Setting Detail</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                         <div class="alert alert-danger validation_error_calendar" style="display: none;"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Type  <span class="required"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <select name="type" id="type" class="form-control">
                                                                <option value="">--- SELECT ---</option>
                                                                <option value="Block">--- Block ---</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group" id="limit" style="display: none">
                                                        <label class="control-label col-sm-2">Limit  <span class="required"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <select name="limit" class="form-control">
                                                                @for($i=1; $i<101; $i++)
                                                                <option value="{{$i}}">--- {{$i}} ---</option>
                                                               @endfor

                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Title  <span class="required"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="title" class="form-control" placeholder="Title">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Description <span class="required"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <textarea name="description" rows="3" class="form-control"  placeholder="Enter description"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="color" class="col-sm-2 control-label">Color</label>
                                                        <div class="col-sm-10">
                                                            <select name="color" class="form-control">
                                                                <option value="">Choose</option>

                                                                <option style="color:#FF0000 !important;;" value="rgba(255, 0, 0, 0.2)">&#9724; Red</option>

                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label class="control-label col-sm-2">Date <span class="required"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <div class='input-group date' id='datetimepicker232'>
                                                                <input type="text" name="start_date"  value="" id="start_date"  readonly="readonly"   class="form-control" placeholder="Date">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar">
                                                              </span>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:void (0)" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                                    <a class="btn btn-danger delete_calendar" style="display: none;">Delete</a>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </section>
                </div>
            </div>

        </section>
    </section>




{{-- <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script> --}}
    <script src="{{asset('public/dist')}}/moment-develop/moment.js"></script>
    <script src="{{asset('public/dist')}}/bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('public/dist')}}/fullcalendar/fullcalendar.js"></script>
    <script type="text/javascript">
        var get_data        = '<?php echo $get_data; ?>';
        var backend_url     = 'settings';

        $(document).ready(function() {
            //$('.date-picker').datepicker();
            //$('#datetimepicker32').datetimepicker();
            // $('#datetimepicker33').datetimepicker();
            $('#calendarIO').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: moment().format('YYYY-MM-DD'),
//                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    $('#form_create')[0].reset();
                    $('#create_modal input[name=calendar_id]').val(0);
                    $('button.btn-primary').text('Submit');
                    $('.delete_calendar').css('display','none');
                    $('.validation_error_calendar').css('display','none');
                    $('#create_modal input[name=start_date]').val(moment(start).format('YYYY-MM-DD'));
                    $('#create_modal').modal('show');
                    $('#datetimepicker232').data("DateTimePicker").date(moment(start).format('YYYY-MM-DD'));
                    $('#datetimepicker232').data("DateTimePicker").maxDate(moment(start).format('YYYY-MM-DD'));
                    $('#calendarIO').fullCalendar('unselect');


                },
                eventClick: function(event, element)
                {
                    deteil(event);
                    editData(event);
                    deleteData(event);
                },
                events: JSON.parse(get_data)
            });
        });

        $(document).on('click', '.add_calendar', function(){
            $('.validation_error_calendar').css('display','none');
            $('#form_create')[0].reset();
            $('.delete_calendar').css('display','none');
            $('#create_modal input[name=calendar_id]').val(0);
            $('button.btn-primary').text('Submit');
            $('#create_modal').modal('show');
            $('#limit').css('display','none');
        })

        $(document).on('submit', '#form_create', function(){
            var element = $(this);
            var eventData;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url     : backend_url+'/save',
                type    : element.attr('method'),
                data    : element.serialize(),
                dataType: 'JSON',
                beforeSend: function()
                {
                    element.find('button[type=submit]').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
                },
                success: function(data)
                {

                    if(data.status)
                    {
                        location.reload();
                        eventData = {
                            id          : data.id,
                            title       : $('#create_modal input[name=title]').val(),
                            description : $('#create_modal textarea[name=description]').val(),
                            start       : moment($('#create_modal input[name=start_date]').val()).format('YYYY-MM-DD HH:mm:ss'),
                            color       : $('#create_modal select[name=color]').val(),
                        };
                        $('#calendarIO').fullCalendar('renderEvent', eventData, true); // stick? = true
                        $('#create_modal').modal('hide');
                        element[0].reset();
                        $('.notification').removeClass('alert-danger').addClass('alert-primary').find('p').html(data.notif);
                    }
                    else
                    {
                        alert(data.notif);

                        element.find('.alert').css('display', 'block');
                        //  element.find('.alert').html(data.notif);
                        $.each(data.notif, function(key, value){
                            $('.alert').append('<p>'+value+'</p>');
                        });

                    }
                    element.find('button[type=submit]').html('Submit');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    element.find('button[type=submit]').html('Submit');
                    element.find('.alert').css('display', 'block');
                    element.find('.alert').html('Wrong server, please save again');
                }
            });
            return false;
        })



        function save()
        {
            $('#form_create').submit(function(){
                var element = $(this);
                var eventData;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url     : backend_url+'/save',
                    type    : element.attr('method'),
                    data    : element.serialize(),
                    dataType: 'JSON',
                    beforeSend: function()
                    {
                        element.find('button[type=submit]').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
                    },
                    success: function(data)
                    {
                        if(data.status)
                        {

                            location.reload();
                            eventData = {
                                id           : data.id,
                                title        : $('#create_modal input[name=title]').val(),
                                description  : $('#create_modal textarea[name=description]').val(),
                                start        : moment($('#create_modal input[name=start_date]').val()).format('YYYY-MM-DD HH:mm:ss'),
                                color       : $('#create_modal select[name=color]').val(),
                            };
                            $('#calendarIO').fullCalendar('renderEvent', eventData, true); // stick? = true
                            $('#create_modal').modal('hide');
                            element[0].reset();
                            $('.notification').removeClass('alert-danger').addClass('alert-primary').find('p').html(data.notif);
                        }
                        else
                        {
                            alert(data.notif);
                            element.find('.alert').css('display', 'block');
                            // element.find('.alert').html(data.notif);
                            $.each(data.notif, function(key, value){
                                $('.alert').append('<p>'+value+'</p>');
                            });
                        }
                        element.find('button[type=submit]').html('Submit');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        element.find('button[type=submit]').html('Submit');
                        element.find('.alert').css('display', 'block');
                        element.find('.alert').html('Wrong server, please save again');
                    }
                });
                return false;
            })
        }

        function deteil(event)
        {

            if(event.type=='Order Limit'){
                $('#limit').css('display','block');
            }else{
                $('#limit').css('display','none');
            }

            // fun();
            $('#create_modal input[name=calendar_id]').val(event.id);
            $('#create_modal select[name=type]').val(event.type);
            $('#create_modal select[name=limit]').val(event.limit);
            $('#create_modal input[name=start_date]').val(moment(event.start).format('YYYY-MM-DD'));
            $('#create_modal input[name=title]').val(event.title);
            $('#create_modal textarea[name=description]').val(event.description);
            $('#create_modal select[name=color]').val(event.color);
            $('#create_modal .delete_calendar').show();
            $('#create_modal').modal('show');
            $('button.btn-primary').text('Update');
        }

        function editData(event)
        {

            $('#form_create').submit(function(){
                var element = $(this);
                var eventData;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url     : backend_url+'/save',
                    type    : element.attr('method'),
                    data    : element.serialize(),
                    dataType: 'JSON',
                    beforeSend: function()
                    {
                        element.find('button[type=submit]').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
                    },
                    success: function(data)
                    {

                        if(data.status)
                        {
                            location.reload();
                            event.type      = $('#create_modal select[name=type]').val();
                            event.limit      = $('#create_modal select[name=limit]').val();
                            event.title         = $('#create_modal input[name=title]').val();
                            event.description   = $('#create_modal textarea[name=description]').val();
                            event.start         = moment($('#create_modal input[name=start_date]').val()).format('YYYY-MM-DD');
                            // event.end           = moment($('#create_modal input[name=end_date]').val()).format('YYYY-MM-DD HH:mm:ss');
                            event.color         = $('#create_modal select[name=color]').val();
                            $('#calendarIO').fullCalendar('updateEvent', event);

                            $('#create_modal').modal('hide');
                            element[0].reset();
                            $('#create_modal input[name=calendar_id]').val(0)
                            $('.notification').removeClass('alert-danger').addClass('alert-primary').find('p').html(data.notif);
                        }
                        else
                        {
                            alert(data.notif);
                            element.find('.alert').css('display', 'block');
                            // element.find('.alert').html(data.notif);
                            $.each(data.notif, function(key, value){
                                $('.alert').append('<p>'+value+'</p>');
                            });
                        }
                        element.find('button[type=submit]').html('Submit');
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        element.find('button[type=submit]').html('Submit');
                        element.find('.alert').css('display', 'block');
                        element.find('.alert').html('Wrong server, please save again');
                    }
                });
                return false;
            })
        }

        function deleteData(event)
        {

            $('#create_modal .delete_calendar').click(function(){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url     : backend_url+'/delete',
                    type    : 'POST',
                    data    : 'id='+event.id,
                    dataType: 'JSON',
                    beforeSend: function()
                    {
                        $('.delete_calendar').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');


                    },
                    success: function(data)
                    {
                        location.reload();
                        if(data.status)
                        {
                            $('#calendarIO').fullCalendar('removeEvents',event._id);
                            $('#create_modal').modal('hide');
                            $('#form_create')[0].reset();
                            $('#create_modal input[name=calendar_id]').val(0)
                            $('.notification').removeClass('alert-danger').addClass('alert-primary').find('p').html(data.notif);
                        }
                        else
                        {
                            alert(data.notif);
                            $('#form_create').find('.alert').css('display', 'block');
                            // $('#form_create').find('.alert').html(data.notif);
                            $.each(data.notif, function(key, value){
                                $('.alert').append('<p>'+value+'</p>');
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        $('#form_create').find('.alert').css('display', 'block');
                        $('#form_create').find('.alert').html('Wrong server, please save again');
                    }
                });
            })
        }

        $('#type').on('change',function (e) {
            var type= $('#type').val();
            if(type=='Order Limit'){
                $('#limit').css('display','block');
            }else{
                $('#limit').css('display','none');
            }
        })

    </script>





@endsection




