<!DOCTYPE html>
<html>
<head>
<title>Admin - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="bs3/css/bootstrap.min.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<link href="css/atom-style.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="container login-bg">

<form action="http://198.154.230.250/marketplace/atom/index.html" class="login-form-signin">
<!--   <div class="login-logo"><img src="images/logo.png"></div>
 -->    <h2 class="login-form-signin-heading">Reset Password</h2>
        <div class="login-wrap">
          <div class="notification-bar" id="msg" style="display: none;"></div>
            <input type="text" autofocus placeholder="Enter Email" class="form-control" id="email">
<!--             <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a href="#myModal" data-toggle="modal"> Forgot Password?</a>

                </span>
            </label> -->
            <img src="images/spinner.gif" style="position:absolute; left:59%; display:none;" id="spinner">
            <button type="button" class="btn btn-lg btn-primary btn-block" onclick="forgotPassword();">Submit</button>
          
            
<!--             <div class="registration">
                Don't have an account yet?
                <a href="index.html">Create an account</a>
            </div>
 -->
        </div>



      </form>

    </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.10.2.js"></script> 
<script src="js/script.js"></script> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="bs3/js/bootstrap.min.js"></script>
<script>
$( document ).ready(function() {
  $("#email").keypress(function(e) {
      if(e.which == 13) {
        forgotPassword();
      }
  });
});
</script>
</body>
</html>