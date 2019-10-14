<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Circulation | Dashboard</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?php $this->load->view('inc/styles');?>
</head>
<body class="hold-transition <?php echo $this->default_theme;?> sidebar-mini dashboard">

<div class="wrapper">
  <?php $this->load->view('inc/header');
        if(isset($_SESSION['NTACCESS'])){
      ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                sweetAlert("Access Denied!", "<?php echo $_SESSION['NTACCESS']; ?>", "warning");
            }, false);
        </script>
      <?php 
        }?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <?php $this->load->view('inc/left-side-menu'); ?>
    <!-- /.sidebar --> 
  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Dashboard<small></small> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content"> 
      <!-- Small boxes (Stat box) -->
      <div class="row"> 
        <?php 
            $fav_len = count($favorites);
            if($fav_len > 0){
              for($index=0; $index<$fav_len; $index++)
              {
                  if($index !=0 && $index%4 == 0)
                  {
                      echo '<div class="col-md-12 col-lg-12 visible-lg visible-md"></div>';
                  }
                  ?>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                  <a href="<?php echo base_url($favorites[$index]->menu_link);?>">
                    <div class="info-box" style="white-space:normal;">
                        <span class="info-box-icon bg-aqua-gradient"><i class="fa <?php echo $favorites[$index]->menu_icon;?>"></i></span>
                        <div class="info-box-content"><span class="info-box-text"><small><?php echo $favorites[$index]->menu_link;?></small></span><span class="info-box-number"><?php echo $favorites[$index]->menu_name;?></span></div>
                    </div>
                  </a>
                </div>
           <?php  
               }
             } else {
        ?>
          <div class="col-md-4 col-sm-12 col-xs-12">
          <a href="<?php echo base_url('Dashboard/Setup');?>"><b style="color:#00c0ef; font-size:19px;"> CUSTOMIZE YOUR DASHBOARD!</b></a></div>
        <?php }
            ?>
      </div>
      <!-- /.row -->       
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper --> 
  <?php $this->load->view('inc/footer');?>
  <div class="control-sidebar-bg"></div>
</div> 
<script>
    var page = 'dashboard',
        user_phone = '<?php echo $this->user->user_mobile; ?>',
        user_email = '<?php echo $this->user->user_email; ?>',
        user_photo = '<?php echo $this->user->user_photo; ?>',
        idle_users = '<?php echo isset($_SESSION['NTIDLEUSERS']) ? $_SESSION['NTIDLEUSERS'] : NULL; ?>';
</script>
<?php $this->load->view('inc/scripts'); unset($_SESSION['NTIDLEUSERS']); ?>
<?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
<script src="<?php echo base_url('assets/js/dashboard.js?v='.$this->config->item('version')); ?>"></script>
<?php }?>
</body>
</html>