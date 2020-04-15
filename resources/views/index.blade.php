<!DOCTYPE html>
<htmllang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Zahib Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('dist/css')}}/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('dist/css') }}/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('dist/css') }}/style.css" rel="stylesheet">
    <link href="{{ asset('dist/css') }}/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    
</head>

<body class="login-body">

<div class="container">
     @if(Session::has('message'))

                                <div class="alert-box success">

                                    <h2>{{ Session::get('message') }}</h2>

                                </div>

                            @endif

    <form class="form-signin" role="form" method="POST" action="{{ url('submit_login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2 class="form-signin-heading">Sign In Now</h2>
        <div class="login-wrap">
            <input type="text" class="form-control" name="email" placeholder="Email" autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
            @endif
            <input type="password" class="form-control" name="password" placeholder="Password">
            @if ($errors->has('password'))
                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
            @endif
            
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign In</button>
            <span class="btn btn-lg btn-login btn-block forget_password" >Forget Password</span>



        </div>
</form>
        

    
<div class="modal fade" id="neg-modal" role="dialog">

    <div class="modal-dialog" style="margin-top: 250px;">
<div class="modal-content" style="    width: 400px; margin-left: 100px;">

        <div class="modal-header" style="background-color:#41cac0; color:white;">

            <h4 class="modal-title" id="">Container Information</h4>

          <button type="button" style="color:black; margin-top: -16px;" class="close" data-dismiss="modal">&times;</button>



        </div>

        <div class="container">

        <div class="modal-body"  >
            <form class="email_send"  method="post" role="form" accept-charset="utf-8">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="text" class="form-control password_email" style="width: 338px;"  name="email" placeholder="Email" >
                <span class="email_verification" style="color: red; display: none">No such User Exist</span>
                <button class="btn btn-lg btn-login btn-block" style="width: 338px; margin-top: 15px; background: #f67a6e; color: white" type="submit">Send Link</button>
            </form>
         
        </div>
</div>
</div>

       

      </div>



    </div>

  </div>

</div>



<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('dist/js') }}/jquery.js"></script>
<script src="{{ asset('dist/js') }}/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script >
    $(document).ready(function(){
    $('.forget_password').click(function(){
        $('#neg-modal').modal('show');

    });
    $('.email_send').submit(function(e){
    e.preventDefault();
     $.ajax({
        type:'post',
        url:'email_send',
          dataType:'json',
          data:$(this).serialize(),
          success:function(data){
              if(data=='null'){
          $('.email_verification').css('display','inline');
              }
              else{
          $('#neg-modal').modal('hide');
          $('.password_email').val('');
          toastr.success('Email Send!');
              }
          },
      });
    });
    });
</script>

</body>
</html>