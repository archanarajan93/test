<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | User Master</title>
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
                <h1>User Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">Admin Tools</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                    <?php echo form_open_multipart('AdminTools/CreateUser','name="user_form" id="user_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Login User Name</label>
                                <div class="input-group">
                                    <input autocomplete="off" required type="text" class="form-control" id="user_login_name" name="user_login_name" />
                                    <div class="input-group-addon btn" id="check-availability" data-search="group"><i class="fa fa-check"></i>Check</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Login Password</label>
                                <input autocomplete="off" required type="text" class="form-control" id="user_login_password" name="user_login_password" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Unit</label> 
                                <select name="user_unit_code" id="user_unit_code" class="form-control" required>                                    
                                    <?php foreach($unit_list as $list_unit) { ?>
                                        <option value="<?php echo $list_unit->unit_code; ?>"><?php echo $list_unit->unit_name; ?></option> 
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Employee Name</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" id="employee_name" name="employee_name" data-request='{"id":"1","search":"Employee"}' data-select="{}" data-multiselect="false" placeholder="Select Employee ID" />
                                    <div class="input-group-addon btn" id="employee_name_search" data-search="employee_name"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Employee ID</label>
                                <input readonly autocomplete="off" value="" required type="text" class="form-control" id="employee_id" name="employee_id"  />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Employee Department</label>
                                <input readonly autocomplete="off" value="" required type="text" class="form-control" id="employee_department" name="employee_department" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Employee Designation</label>
                                <input readonly autocomplete="off" value="" required type="text" class="form-control" id="employee_designation" name="employee_designation" />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <label>Menu Permission</label>
                                <select class="form-control select2" multiple="multiple" name="menu_permission[]" id="menu_permission">
                                    <?php foreach($listmenu_records as $list_menu) { ?>
                                    <option value="<?php echo $list_menu->menu_id; ?>"><?php echo $list_menu->menu_name; ?></option> 
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <label>Block SubMenu</label>
                                <select class="form-control select2" multiple="multiple" name="sub_menu_permission[]" id="sub_menu_permission"> 
                                    <?php foreach($submenu_records as $list_menu) { ?>
                                        <option value="<?php echo $list_menu->menu_id."#".$list_menu->menu_parent_id; ?>"><?php echo $list_menu->menu_parent_name.' > '.$list_menu->menu_name; ?></option>                                   
                                    <?php } ?>                    
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <table class="table table-results" id="unit-access-tbl">
                                    <thead>
                                        <tr>
                                            <td width="1%"><input checked type="checkbox" id="select-all-unit" /></td>
                                            <td>Unit Access</td>
                                        </tr>
                                    </thead>
                                    <?php foreach($unit_list as $list_unit) { ?>
                                    <tr>
                                        <td><input checked type="checkbox" name="unit_access[]" value="<?php echo $list_unit->unit_code; ?>" /></td>
                                        <td><?php echo $list_unit->unit_name; ?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">                              
                                <table class="table table-results" id="product-access-tbl">
                                    <thead>
                                        <tr>
                                            <td width="1%"><input checked type="checkbox" id="select-all-product" /></td>
                                            <td>Product Access</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($product_list as $p) { ?>
                                        <tr>
                                            <td><input checked type="checkbox" name="product_access[]" value="<?php echo $p->product_code; ?>" /></td>
                                            <td><?php echo $p->product_name; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">                                
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                                <button onclick="window.location = baseUrlPMD + 'AdminTools/SearchUser'" class="btn btn-block btn-warning" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </span>

                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                        </div>
                </div>
                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
        ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'USER-CREATE';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/admin-tools.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
