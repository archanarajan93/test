<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Bureau Master</title>
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
                <h1>Bureau Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Masters</li>
                    <li class="active">Bureau Master</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Masters/CreateBureau'); ?>" name="bureau_master" id="bureau_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Bureau Name</label>
                                <input required type="text" class="form-control isAlpha" id="bureau_name" name="bureau_name" autocomplete="off" />
                            </span> 
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Contact Person</label>
                                <input required type="text" class="form-control isAlpha" id="bureau_contact" name="bureau_contact" autocomplete="off" />
                            </span> 
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Mobile No.</label>
                                <input required type="text" class="form-control isMob isNumberKey" id="bureau_mobile" name="bureau_mobile" autocomplete="off" />
                            </span>                         
                            <span class="col-lg-1 col-md-3 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <input class="btn btn-block btn-primary add-btn" id="add" value="Add" name="Add" type="submit" />
                            </span>
                            <span class="col-lg-1 col-md-3 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button">Close</button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results" id="bureau-table" style="width:90%;">
                            <thead>
                                <tr>
                                    <td width="7%">Code</td>
                                    <!--<td width="12%">Bureau Unit</td>-->
                                    <td width="24%">Bureau Name</td>
                                    <td width="23%">Contact Person</td>
                                    <td width="20%">Mobile No.</td>
                                    <td width="13%" style="text-align:center;">Priority</td>
                                    <td width="8%">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="display:none;">
                                    <td colspan="7"></td>
                                </tr>
                               <?php
                               if(isset($bureau_lists) && count($bureau_lists)>0)
                               {
                                   $i=1;
                                   foreach($bureau_lists as $bureau)
                                   {
                               ?>
                                <tr data-save="false" data-burcode="<?php echo $bureau->bureau_code; ?>">  
                                    <td class="dicCode"><?php echo $bureau->bureau_code; ?>
                                        <input type="hidden" class="form-control burcode" disabled value="<?php echo $bureau->bureau_code; ?>" />
                                    </td>
                                    <!--<td>
                                        
                                        <input type="text" class="form-control" disabled value="<?php echo $bureau->bureau_unit; ?>" />
                                    </td>-->
                                    <td>
                                        <input type="text" class="form-control burname" disabled value="<?php echo $bureau->bureau_name; ?>" /></td>
                                    <td>
                                        <input type="text" class="form-control burcontact" disabled value="<?php echo $bureau->bureau_contact_person; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control burmobile" disabled value="<?php echo $bureau->bureau_mobile; ?>" />
                                    </td>
                                    <td align="center" class="handle"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></td>
                                    <td>
                                        <button  class="btn btn-primary edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                                        <button  class="btn btn-info save-btn btn-xs"><i class="fa fa-save fa-1x"></i></button>
                                        <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                        <button class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                               <?php
                                   }
                               }
                               else {
                                    echo '<tr><td class="no-records" colspan="7"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Records Found</td></tr>';
                               }
                               ?>
                       </table>
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
        var page = 'BUREAU-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>    
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
