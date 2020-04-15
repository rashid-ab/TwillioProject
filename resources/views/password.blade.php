@extends('layouts.app')
@section('content')
<style>
    .bnt{
        background-color: white;
        color: #0e7c7b;
        font-weight: 700;
        font-size: 18px;
        border: 1px solid white;
        line-height: 26px;
        position: relative;
        top: -8px;
        cursor: pointer;
    }
    .bg-color{
        background-color: white;
        border-top-left-radius: 50px;
        border-top-right-radius: 50px;
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
        margin-top: 20px;
        padding: 12px;
    }
    .icns{
        padding: 18px 17px;
        border-radius: 50%;
        float: left;
        margin-left: -8px;
        margin-top: -11px;
        font-size: 30px;
    }
    .icns-1{
        padding: 18px 21px;
        border-radius: 50%;
        float: left;
        margin-left: -8px;
        margin-top: -11px;
        font-size: 30px;
    }
      input:focus{
        border-color:transparent;
        box-shadow: 0 0 0 0.01rem transparent;
        outline: none;
        border-bottom: 1px solid black;
    }
    .inpt{
        border:0px;
        width: 6%;
        margin-right: 7px;
        background-color: transparent;
        border-bottom: 1px solid black;
    }
    .digits-outer{
         background-color: white;
        border-radius: 30px;
        border: 1px solid lightgray;
        padding: 4px 20px;
    }
    .w-39{
        width:39% !important;
    }
    .inpt-outer{
        border-right: 1px solid lightgray;
    }
    @media only screen and (max-width: 1002px) {
    .digits-outer{
        width:75% !important;
    }
    
    }
    @media only screen and (max-width: 576px) {
        .cd-img{width:75% !important;}
    }
</style>
<div class="container">
        <div class="row mt-md-5 mt-0 pt-md-5 pt-0">
            <div  class="col-md-7 m-auto pt-3 pb-4 rounded text-center" style="background-color:#f7f7f7;">
                <img src="{{url('/public/password')}}/Avatar.png" alt="" >
                <h5 style="color: black;font-weight: 500;font-family: inherit;">Ready?</h5>
                <p class="mt-4 mb-3" style="color: black;font-weight: 500;font-family: inherit;">Enter Your 6 Digit Password</p>
               <form method="POST"  class="container">
               	@csrf
                   <div class="digits-outer w-39 m-auto">
                       <div style="background: #f7f7f7;padding-bottom: 5px;padding-top: 5px;" class="abc">
                            <input type="text" name="password1" class="inpt" maxlength="1" style="text-align: center;"><span style="border: 1px solid lightgray;"></span>
                            <input type="text" name="password2" class="inpt" maxlength="1" style="text-align: center;"><span style="border: 1px solid lightgray;"></span>
                            <input type="text" name="password3" class="inpt" maxlength="1" style="text-align: center;"><span style="border: 1px solid lightgray;"></span>
                            <input type="text" name="password4" class="inpt" maxlength="1" style="text-align: center;"><span style="border: 1px solid lightgray;"></span>
                            <input type="text" name="password5" class="inpt" maxlength="1" style="text-align: center;"><span style="border: 1px solid lightgray;"></span>
                            <input type="text" name="password6" class="inpt" maxlength="1" style="text-align: center;">
                        </div>
                    </div>
                      <div class="bg-color">
                    <i class="fa fa-address-card icns" style="background-color: #0e7c7b;color: white;"></i>
                    <button type="submit" class="bnt mt-3">Start my Consultation</button>
                </div>
                </form>
              
                
                <p class="mt-2" style="color: black;font-weight: 500;font-family: inherit; font-size:12px;"> By clicking, I agree to the <a href="http://newdev.clickdietitian.com/termsofuse.php">Terms and Conditions and Privacy Policy </a></p>
                <div class="row mt-5 mb-5">
                    <div class="col-md-4 col-sm-4 col-xs-4 m-auto p-3 cd-img" style="background:white;">
                        <img src="{{url('/public/password')}}/cd.png" class="w-100" style="" alt="">
                    </div>
                </div>
                <div class="bg-color">
                        <i class="fa fa-calendar icns-1" style="background-color: #0e7c7b;color: white;"></i>
                        <button type="submit" class="bnt mt-3">Book a Consultation</button>
                    </div>
            </div>
        </div>
    </div>


<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script>
    var container = document.getElementsByClassName("abc")[0];
container.onkeyup = function(e) {
     var target = e.srcElement;
     var maxLength = parseInt(target.attributes["maxlength"].value, 10);
     var myLength = target.value.length;
     if (myLength >= maxLength) {
         var next = target;
         while (next = next.nextElementSibling) {
             if (next == null)
                 break;
             if (next.tagName.toLowerCase() == "input") {
                 next.focus();
                 break;
             }
         }
    }
}
</script>
@endsection