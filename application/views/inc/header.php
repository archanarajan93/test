<?php include('functions.php');?>
<script>var page = '';</script>
<header class="main-header">
    <?php //globals
    if(!isset($this->user->user_product_code)) header("Location: ".base_url('Settings/Product'));
    $color_codes  = array("#FFD600","#0266C8","#F90101","#F2B50F","#00933B","#F44336","#E91E63","#9C27B0","#D50000","#AA00FF","#C51162","#3F51B5","#8BC34A","#FF9800","#01579B","#FFC400","#795548","#33691E","#0091EA","#004D40","#827717","#EF6C00","#546E7A","#CDDC39","#7E57C2");
    $color_length = sizeof($color_codes);
    $no_img_index = $this->user->user_id < $color_length ? $this->user->user_id : ($this->user->user_id % $color_length);
    $first_letter = strtoupper(substr($this->user->user_name,0,1));
    $smallPhotoHtml = '<span class="img-sm img-circle img-bordered" style="position:relative;line-height:1.42857143;background-color:'.$color_codes[$no_img_index].'; margin-right:5px;margin-top: -2px;"><b class="round-text-md-top">'.$first_letter.'</b></span>';
    $photoHtml = '<span style="margin: 15px 0;" class="col-md-12"><b class="img-circle img-bordered round-text-xl-top" style="background-color:'.$color_codes[$no_img_index].'">'.$first_letter.'</b></span>';
    ?> 
    <a href="<?php echo base_url('Dashboard'); ?>" class="logo hidden-xs">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url('assets/imgs/logo_icon.png'); ?>" alt="logo" style="max-width: 25px;"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url('assets/imgs/logo.png'); ?>" alt="logo" class="img-responsive" ><!--<b>CIRCULATION</b>--></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <div class="miniheader visible-xs">CIRCULATION</div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">                                                                       
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="user-image" alt="User Image">-->
                <?php echo $smallPhotoHtml;?>
              <span class="hidden-xs" style="margin-top: 2px;float: right;"><?php echo $this->user->user_name." - ".$this->user->user_unit_code." - ".$this->user->user_product_code; ?> &nbsp;<i class="fa fa-cogs" aria-hidden="true"></i></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php echo $photoHtml; ?>                
                <p><?php echo $this->user->user_name." - ".$this->user->user_unit_code." - ".$this->user->user_product_code; ?></p>
              </li>              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a onclick="window.location='<?php echo base_url('Profiles'); ?>'" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a onclick="CIRCULATION.utils.userLogout()" class="btn btn-default btn-flat link">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>&nbsp;</li>
        </ul>
      </div>
    </nav>
  </header>