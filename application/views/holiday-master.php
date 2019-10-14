<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Holiday</title>
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
                <h1>Holiday Master</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">Masters</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Masters/CreateHoliday'); ?>" name="unit_master" id="unit_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Holiday Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="region_code" value="<?php echo $hld_code; ?>" name="region_code" readonly />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label> Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control" id="holiday_date" name="holiday_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label>Description</label>
                                <!--<textarea  required class="form-control" id="region_name" name="region_name" rows="4" cols="50"> </textarea>-->
                                <input class="form-control" id="holiday_desc" name="holiday_desc" required />
                                </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Applicable to Office Only</label>
                                <select name="holiday_Office" id="holiday_Office" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                                <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                                </span>
                                <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                    <label>&nbsp;</label>
                                    <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button">
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        Close
                                    </button>
                                </span>
</form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results" id="holiday-table" style="width:50%">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Date</td>
                                        <td>Description</td>
                                        <td>Applicable to Office Only</td>
                                        <td>Status</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($holiday_list)) {
                                         $i=1;
                                         foreach($holiday_list as $list) {?>

                                    <tr data-save="false" data-drpid="<?php //echo $dr->drop_code; ?>">
                                       
                                        <td><?php echo $i++; ?></td>
                                        <td class="hld-date"><?php echo date('d-m-Y',strtotime($list->holiday_date)); ?> </td>
                                        <td class="hld-desc"><?php echo $list->holiday_desc; ?> </td>
                                        <td class="hld-desc"><?php  if($list->holiday_office == 0){echo "No";}else{echo "Yes";} ?> </td>
                                        <td class="hld-status"><?php if( $list->cancel_flag == Status::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                         <td align="center">
                                        <button data-id="<?php echo $list->holiday_code; ?>"class="btn btn-primary holiday-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>

                                            <?php //if($grp->cancel_flag == 0){?>
                                            <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php }
                                    else {
                                        echo "<tr><td colspan='7' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                    }?>
                                    </tbody>
                            </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('inc/footer');
              $this->load->view('inc/help'); ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'HOLIDAY-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
