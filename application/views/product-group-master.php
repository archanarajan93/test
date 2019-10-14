<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Group Master</title>
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
                <h1>Group Master</h1>
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
                        <form method="post" action="<?php echo base_url('Masters/CreateProductGroups'); ?>" name="unit_master" id="unit_master" onsubmit="return NEWSTRACK.utils.formValidation(this);">
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Group Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="group_name" name="group_name" />
                            </span>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Group Product</label>
                                <select name="group_pdt[]" id="group_pdt[]" class="form-control select2" required multiple>
                                    <?php foreach($prdts as $pdt){?>
                                        <option value="<?php echo $pdt->product_code;?>"><?php echo $pdt->product_name;?></option>
                                    <?php }?>
                                </select>
                            </span>
                            <span class="col-lg-1 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </span>
                            <span class="col-lg-1 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                <?php if(isset($prdt_groups) && $prdt_groups){?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                            <table class="table table-results" id="group-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="hidden" style="width:10%">Group Code</th>
                                        <th style="width:50%">Group Name</th>
                                        <th style="width:30%">Group Product</th>
                                        <th style="width:8%">Priority</th>
                                        <th style="width:12%">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                               if(isset($prdt_groups))
                               {
                                   foreach($prdt_groups as $pdt_grp)
                                   {
                                       $grp_pdt = explode(",",$pdt_grp->group_prdts);
                                    ?>
                                    <tr data-save="false" data-grpid="<?php echo $pdt_grp->group_code; ?>">
                                        <td class="hidden"><?php echo $pdt_grp->group_code; ?></td>
                                        <td><input type="text" name="group_name" id="group_name" class="form-control group_name" disabled value="<?php echo strtoupper($pdt_grp->group_name); ?>" style="padding: 6px 0px;" /></td>
                                        <td>
                                            <span class="demo-text"><?php echo strtoupper($pdt_grp->group_prdts); ?></span>
                                            <select name="group_pdt[]" id="group_pdt[]" class="form-control select2 actv-content group_pdt" multiple>
                                                <?php foreach($prdts as $pdt){?>
                                                <option <?php if(in_array($pdt->product_code,$grp_pdt)) { echo 'selected';}?> value="<?php echo $pdt->product_code;?>"><?php echo $pdt->product_name;?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                        <td class="handle"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></td>
                                        <td>
                                            <button class="btn btn-primary edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                                            <button class="btn btn-info save-btn btn-xs"><i class="fa fa-save fa-1x"></i></button>
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <button class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                <?php }?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('inc/footer');?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'PRODUCT-GROUP';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
