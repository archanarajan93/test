<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CIRCULATION | Setup My Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('inc/styles');?>
</head>
<body class="hold-transition <?php echo $this->default_theme;?> sidebar-mini sidebar-collapse">
<div class="wrapper">
 <?php $this->load->view('inc/header'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
<?php $this->load->view('inc/left-side-menu'); ?>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Setup</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('/Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Resources</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php $this->load->view('inc/alerts'); ?>
      <div class="row">
          <form method="post" action="<?php echo base_url('Dashboard/CreateDashboardSetup')?>"><?php echo $setup_menu;?>
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6"><button class="btn btn-block btn-primary" type="submit" ><i class="fa fa-save fa-1x"></i>&nbsp;Save</button></div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6"><a href="<?php echo base_url('/Dashboard');?>"><button type="button"  class="form-control btn btn-danger close-button" id="close" name="close"><i class="fa fa-times"></i>&nbsp;&nbsp;CLOSE</button></a></div>       
         </div></form>   
      </div>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php $this->load->view('inc/footer');?>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script>
var page = 'dashboardSetup';
</script>
<?php $this->load->view('inc/scripts'); ?>
<?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
<script src="<?php echo base_url('assets/js/dashboard.js?v='.$this->config->item('version')); ?>"></script>
<?php }?>
</body>
</html>
