<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Product Master</title>
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
                <h1>Product Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Masters</li>
                    <li class="active">Product Master</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Masters/CreateProducts'); ?>" name="product_master" id="product_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Product Code</label>
                                <input required type="text" class="form-control" id="product_code" name="product_code" />
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Product Name</label>
                                <input required type="text" class="form-control isAlpha" id="product_name" name="product_name" />
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
                        <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                            <table class="table table-results" id="product-table" align="center" style="width:100%;">
                                <thead>
                                    <tr>
                                        <td width="2%;" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">#</td>
                                        <td width="10%;" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Code</td>
                                        <td width="58%;" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Product Name</td>
                                        <td width="10%" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Priority</td>
                                        <td width="20%" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               if(isset($prdt_lists))
                               {
                                   $i=1;
                                   foreach($prdt_lists as $prdt)
                                   {
                                    ?>
                                    <tr data-save="false" data-prdid="<?php echo $prdt->product_code; ?>">
                                        <td class="dicCode padtop16"><?php echo $i++; ?></td>
                                        <td style="padding-top: 15px;"><?php echo $prdt->product_code; ?></td>
                                        <td><input type="text" name="product_name" id="product_name" class="form-control isAlpha product_name" style="color:#000000;" disabled data-val="<?php echo strtoupper($prdt->product_name); ?>" value="<?php echo strtoupper($prdt->product_name); ?>" style="padding: 6px 0px;" /></td>
                                        <td class="handle" style="text-align:center;"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></td>
                                        <td class="btn-box">
                                            <button class="btn btn-primary edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                                            <button class="btn btn-info save-btn btn-xs"><i class="fa fa-save fa-1x"></i></button>
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <button class="btn btn-danger status-btn btn-xs" data-disabled="1"><i class="fa fa-ban" aria-hidden="true"></i></button>
                                        </td>

                                    </tr>
                                    <?php
                                    }
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
        var page = 'PRODUCT-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
