<?php
$default_image=base_url('uploads/users/default.jpeg');
$prof_image=glob('uploads/users/'.$this->user->user_id.'/*{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE);
if($prof_image){ $image=base_url($prof_image[0]); } else { $image=$default_image; }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Newstrack | Profile</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php $this->load->view('inc/styles.php');
          $this->load->view('inc/alerts');?>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
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
                <h1>&nbsp;</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard'); ?>">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">Profile</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-prof-circle" src="<?php echo $image."?".filemtime($prof_image?$prof_image[0]:""); ?>" alt="User profile picture" onerror="<?php echo $default_image; ?>" style="border-radius:0;">
                                <h3 class="profile-username text-center"><?php echo strtoupper($records->user_name); ?></h3>
                                <p class="text-muted text-center"><?php echo strtoupper($records->unit_name); ?></p>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Unit</b>
                                        <a class="pull-right"><?php echo strtoupper($records->unit_name); ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Product</b> <a class="pull-right"><?php echo strtoupper($records->product_name); ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Group</b> <a class="pull-right"><?php echo strtoupper($records->group_name); ?></a>
                                    </li>                                    
                                </ul>
                                <a></a>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#user_activity" data-toggle="tab">Content</a>
                                    <span></span>
                                </li>
                                <li>
                                    <a href="#photo_user" data-toggle="tab">Photo</a>
                                    <span></span>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="user_activity">
                                    <form action="<?php echo base_url('Profiles/UpdateProfileDetails'); ?>" class="form-horizontal" name="user_details_form" id="user_details_form" onsubmit="return CIRCULATION.utils.formValidation(this);" method="post">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php  echo $records->user_name; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Place</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="place" name="place" placeholder="Place" value="<?php  echo $records->user_place; ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Login Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="login_name" name="login_name" placeholder="Login Name" value="<?php  echo $records->user_login_name; ?>"  readonly /> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Password</label>

                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php  echo $records->user_login_password; ?>" required />  
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="inputExperience" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php  echo $records->user_email; ?>" required /> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSkills" class="col-sm-2 control-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php  echo $records->user_mobile; ?>" required /> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputSkills" class="col-sm-2 control-label">Byline</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control ToMal" id="user_byline" maxlength="100" name="user_byline" placeholder="Byline" value="<?php  echo $records->user_byline; ?>" />  
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-2">&nbsp;</div>
                                                <div class="col-sm-5 col-xs-12">
                                                    <input type="button" class="pull-left btn btn-default btn-md E_M aruna-font" style="margin-right:2px;" value="മലയാളം" title="Press Ctrl+Alt to Change Language" />
                                                    <input type="button" class="pull-left btn btn-default btn-md I_V aruna-font" style="margin-right:2px;" value="<?php echo $this->user->user_kb_type == KeyboardPreference::Verifone ? 'വെരിഫോൺ' : 'ഇൻസ്ക്രിപ്‌റ്റ്';  ?>" />
                                                </div>
                                            <div class="col-xs-12 visible-xs">&nbsp;</div>
                                            <div class="col-sm-5 col-xs-12">
                                                <button type="submit" class="btn btn-primary" name="submit" id="upload_contents"><i class="fa fa-plus-circle" aria-hidden="true"></i> Update</button>
                                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                                                </div>
                                            </div>
                             </form>
                                </div>
                                <div class="tab-pane" id="photo_user">
                                  <div class="row">
                                         <form action="" method="post" name="photo_form" id="photo_form" enctype="multipart/form-data">
                                            
                                                    <div class="form-group">
                                                        <label for="inputName" class="col-sm-2 control-label">Photo</label>
                                                        <div class="col-sm-5">
                                                            <input type="file" class="form-control" id="profile_photo" name="profile_photo" placeholder="Photo" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">&nbsp;</div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="button" class="btn btn-primary" name="submit" id="upload_photo" style="width: 20%;"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                                                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" style="width: 20%;" class="btn btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                                                        </div>
                                                    </div>
                                            </form>
                                     </div>
                                    <div id="message" style="text-align: center;"></div>
                                 </div>
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
           </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php $this->load->view('inc/footer');?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'myprofile';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug') { ?>
    <script src="<?php echo base_url('assets/js/profiles.js?v='.$this->config->item('version')); ?>"></script>
    <?php } ?>
    <!--<script type="text/javascript">
        CIRCULATION.utils.enableMalayalamTyping();
    </script>-->
</body>
</html>
