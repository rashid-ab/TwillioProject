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
                <section class="panel" style="width:674px;margin-left: -77px;">
                    <header class="panel-heading">

                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        @endif

                        @if(Session::has('Duplicate_email'))
                        <div class="alert alert-danger">
                            {{ Session::get('Duplicate_email') }}
                        </div>
                        @endif
                        @if(Session::has('Duplicate_phone'))
                        <div class="alert alert-danger">
                            {{ Session::get('Duplicate_phone') }}
                        </div>
                        @endif



                        Edit Ad
                        <div class="btn-holder" style="float: right;">
                            <!--  <a href="{{ url('newcustomer') }}"><button type="button" class="btn btn-danger">Add New</button></a> -->
                        </div>
                    </header>
                    <div class="panel-body">
                        <!--         <form role="form"> -->
                        <form role="form" method="post"
                            class="add_word" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group"  style="width: 180px;">
                                        <select class="form-control va" name="ad_type" >
                                        @if($ad->ad_type=='By Text')
                                        <option>By Text</option>
                                        <option>By Image</option>
                                        <option>By Text And Image</option>
                                        @elseif($ad->ad_type=='By Image')
                                        <option>By Image</option>
                                        <option>By Text</option>
                                        <option>By Text And Image</option>
                                        @elseif($ad->ad_type=='By Text And Image')
                                        <option>By Text And Image</option>
                                        <option>By Text</option>
                                        <option>By Text And Image</option>
                                        @endif
                                            
                                        </select>
                                    </div>
                                    <div class="form-group title" >
                                        <label>Title in English</label>
                                        <input type="text" class="form-control titles"
                                        name="title_in_english" value="{{ $ad->title_in_english }}" required placeholder="Title in English">
                                    </div>
                                    <div class="form-group title" >
                                        <label>Title in Arabic</label>
                                        <input type="text" class="form-control titles"
                                        name="title_in_arabic" value="{{ $ad->title_in_arabic }}" required placeholder="Title in Arabic">
                                    </div>
                                    <div class="form-group body">
                                        <label>Text in English</label>
                                        <textarea class="form-control text"
                                        name="text_in_english" placeholder="Text" value="" required autocomplete="off" >{{ $ad->text_in_english }}</textarea>
                                    </div>
                                    <div class="form-group body">
                                        <label>Text in Arabic</label>
                                        <textarea class="form-control text"
                                        name="text_in_arabic" placeholder="Text" value="" required autocomplete="off" >{{ $ad->text_in_arabic }}</textarea>
                                    </div>
                                    <div class="form-group image" style="display:none">
                                        @if($ad->image!='No-Image')
                                        <img src="{{$ad->image}}" width="200px" height="200px" />
                                        @else
                                        <label>Image</label>
                                        @endif
                                        <input type="file" class="form-control images"
                                        name="image" placeholder="Image"  >
                                    </div>
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-success " style="float: right;margin-right: 14px;">Save</button>
                                </div>
                            </div>
                           </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>

<script type="text/javascript">
    $(function(){
        $value=$(".va").val();
        if($value=='By Text'){
            $('.image').hide();
            $('.body,.title').show();
            $('.text').attr('required', true);
            $('.titles').attr('required', true);
            $('.images').attr('required', false);
        }
        if($value=='By Image'){
            $('.image').show();
            $('.images').attr('required', true);
            $('.body,.title').hide();
            $('.text').attr('required', false);
            $('.titles').attr('required', false);
        }
        if($value=='By Text And Image'){
            // $('.images').attr('required', true);
            $('.body,.title,.image').show();
            $('.text').attr('required', true);
            $('.titles').attr('required', true);
        }
        $(".va").on('change',function(){
         if($(this).val()=='By Text'){
            $('.image').hide();
            $('.body,.title').show();
            $('.text').attr('required', true);
            $('.titles').attr('required', true);
            $('.images').attr('required', false);
         }
         if($(this).val()=='By Image'){
            $('.image').show();
            $('.images').attr('required', true);
            $('.body,.title').hide();
            $('.text').attr('required', false);
            $('.titles').attr('required', false);
         }
         if($(this).val()=='By Text And Image'){
            $('.images').attr('required', true);
            $('.body,.title,.image').show();
            $('.text').attr('required', true);
            $('.titles').attr('required', true);
         }

        });
    });

</script>
@endsection