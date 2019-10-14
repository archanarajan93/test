<?php $user_session = $this->session->userdata("CIRSTAYLOGIN"); if($user_session && isset($user_session["user_name"])){ redirect('/Dashboard', 'refresh'); }?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Circulation | User Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="theme-color" content="#00a7c7">
    <meta name="msapplication-navbutton-color" content="#00a7c7">
    <meta name="apple-mobile-web-app-status-bar-style" content="#00a7c7">
    <?php $this->load->view('inc/styles');?>
  </head>
  <body class="hold-transition login-page">   
      <!--<div class="container-fluid login-cont hidden-xs">
          <div class="container">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login-header">CIRCULATION</div>
          </div>
      </div>-->
      <div id="login-box-wrap" class="login-box box-primary animated hide">
          <div class="login-box-body">
              <div class="login-logo">
                  <!--<a href="#"><img src="<?php //echo base_url('assets/imgs/logo.png'); ?>" width="240"></a>-->
                  CIRCULATION
              </div>

            <!-- /.login-logo -->
              <p class="login-box-msg">Sign in to start your session</p>
            <?php if($this->session->flashdata('loginstatus') == 'error') { ?>
              <div data-height="40" class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                  Invalid Username/Password.
              </div>
              <?php } ?>

              <?php if($this->session->flashdata('loginstatus')=='logout_success') { ?>
              <div data-height="40" class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-check"></i> Alert!</h4>
                  You are successfully logged out.
              </div>
              <?php } ?>

              <?php if($this->session->flashdata('loginstatus')=='login_to_proceed') { ?>
              <div data-height="40" class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                  Please login to proceed.
              </div>
              <?php } ?>
              <form action="<?php echo base_url('/AuthController/DoLogin');?>" onsubmit="return validateLogin()" method="post" accept-charset="utf-8">
                  <input type="hidden" name="CSTOKEN" value="2981814aefccfb5ac65932bedcd0469c" style="display:none;">
                  <div class="form-group has-feedback">
                      <input type="hidden" name="redirect_nws" id="redirect_nws" value="<?php echo isset($_GET['n'])?$_GET['n']:'';?>"/>
                      <input required="" autocomplete="off" name="user_login_name" id="user_login_name" type="text" class="form-control rem_error movenext" placeholder="Username">
                      <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input required="" autocomplete="off" name="user_password" id="user_password" type="password" class="form-control rem_error movenext" placeholder="Password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                      <div class="col-xs-12 pull-right">
                          <button type="submit" name="login_submit" class="btn btn-report btn-block btn-flat movenext login-btn">Sign In</button>
                      </div><!-- /.col -->
                  </div>
              </form>
          </div><!-- /.login-box-body -->
      </div><!-- /.login-box --> 
    <script> var page = 'login';</script>
	<?php $this->load->view('inc/scripts');
          function getRealIpAddr()
          {
              if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
              {
                  $ip=$_SERVER['HTTP_CLIENT_IP'];
              }
              elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
              {
                  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
              }
              else
              {
                  $ip=$_SERVER['REMOTE_ADDR'];
              }
              return $ip;
          }
          $ipaddr = getRealIpAddr();
        ?>             
    <script>
    $(document).ready(function (e) {
        $("#user_login_name").focus();
        var dismisable = parseInt($(".alert-dismissable").attr("data-height") || 0);
        $("#login-box-wrap").css("margin-top", (parseInt(($(document).height() / 2) - 150 - dismisable)) + "px");
        $("#login-box-wrap").removeClass('hide');
        $("#login-box-wrap").addClass('zoomIn');
    });
    function validateLogin()
    {
       if ($("#user_login_name").val().trim() == '') {
           bootbox.alert("Please Enter Username.");
           return false;
       }
       if ($("#user_password").val().trim() == '') {
           bootbox.alert("Please Enter Password.");
           return false;
       }
    }
    CIRCULATION.utils.setCookie("USERTZ", jstz.determine().name(), 5);
    </script>
  </body>
</html>
