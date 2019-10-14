<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Copy Master</title>
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
                <h1>Copy Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Admin Tools</li>
                    <li class="active">Copy Master</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('AdminTools/CreateCopyMaster'); ?>" name="copy_master" id="copy_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Name</label>
                                <input required type="text" class="form-control" id="copy_name" name="copy_name" />
                            </div>
                            <span class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                <label style="width:100%">&nbsp;</label>
                                <input class="btn btn-primary add-btn" id="add" value="Add" name="Add" type="submit" />
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-danger" type="button">Close</button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="col-lg-4 col-md-8 col-sm-12 col-xs-12">
                            <table class="table table-results" id="copy-table" align="center" style="width:100%;float:left;">
                                <thead>
                                    <tr>
                                        <th width="2%;">#</th>
                                        <th width="15%;">Code</th>
                                        <th width="63%;">Copy Name</th>
                                        <th width="20%">&nbsp;</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                    <?php
                               if(isset($copy_lists) && count($copy_lists)>0)
                               {
                                   $i=1;
                                   foreach($copy_lists as $copy)
                                   {
                                    ?>
                                    <tr data-save="false" data-cpyid="<?php echo $copy->copy_code; ?>">
                                        <td class="dicCode padtop16"><?php echo $i++; ?></td>
                                        <td style="padding-top: 15px;"><?php echo $copy->copy_code; ?></td>
                                        <td><input type="text" name="product_name" id="product_name" class="form-control copy_name" disabled data-val="<?php echo strtoupper($copy->copy_name); ?>" value="<?php echo strtoupper($copy->copy_name); ?>" style="padding: 6px 0px;" /></td>
                                        <td class="btn-box">
                                            <button class="btn btn-primary edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                                            <button class="btn btn-info save-btn btn-xs"><i class="fa fa-save fa-1x"></i></button>
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <button class="btn btn-danger del-btn btn-xs" data-disabled="1"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>

                                    </tr>
                                    <?php
                                    }
                               } else {
                                    echo '<tr><td class="no-records" colspan="4"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Records Found</td></tr>';
                               }
                                    ?>
                            </table>
                        </div>
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
        var page = 'COPY-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/admin-tools.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }?>
</body>
</html>
