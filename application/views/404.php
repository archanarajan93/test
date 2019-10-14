<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>CIRCULATION | 404</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php $this->load->view('inc/styles');?>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  <?php $this->load->view('inc/alerts');?>
  <?php //$this->load->view('inc/header');?>     

  <!-- Content Wrapper. Contains page content -->
  <div style="background: #eae9e8;" class="content-wrapper text-center">   
      <a href="<?php echo base_url('Dashboard'); ?>">
          <img src="<?php echo base_url('assets/imgs/404.gif'); ?>" />
      </a>  
  </div>
  <!-- /.content-wrapper -->
  
  <?php $this->load->view('inc/footer');?>
  <!-- /.control-sidebar --> 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper --> 

<!-- jQuery 2.2.0 --> 
<?php $this->load->view('inc/scripts');?>
</body>
</html>
