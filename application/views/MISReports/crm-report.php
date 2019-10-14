<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | CRM Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php $this->load->view('inc/styles.php');
        $this->load->view('inc/alerts');
        $month = Enum::getTZDateTime(null, "M Y");?>
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
                <h1>CRM Report</h1>
               <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Reports</li>
                    <li class="active">CRM Report</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" name="crm_report_form" id="crm_report_form" target="_blank" action=<?php echo base_url("MISReports/CRMReportsDetails");  ?> onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>&nbsp;</label>
                                <select name="date_type" class="form-control">
                                    <option value="created_date">Created Date</option>
                                    <option value="updated_date">Modified Date</option>
                                </select>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>From</label>
                                <span class="input-group" data-selected="true">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input required type="text" class="form-control" name="from_date" id="from_date" value="<?php echo date('d-m-Y'); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                </span>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>To</label>
                                <span class="input-group" data-selected="true">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input required type="text" class="form-control" name="to_date" id="to_date" value="<?php echo date('d-m-Y'); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                </span>
                            </span>

                            <span class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Users</label>
                                <select name="users_id[]" class="form-control select2 " multiple="multiple">
                                    <?php foreach($user_records as $urec) { ?>
                                    <option value="<?php echo $urec->user_id; ?>"><?php echo $urec->user_login_name; ?></option>
                                    <?php } ?>
                                </select>
                            </span>

                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-lg">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Entry Level</label>
                                <select name="entry_level" class="form-control">
                                    <option value="All">All</option>
                                    <option value="0">First Entry</option>
                                    <option value="1">Last Entry</option>
                                </select>
                            </span>

                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Unit<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-multiselect="true" data-request='{"id":"13","search":"Unit"}' data-select="{}" type="text" class="form-control" name="unit" value="" placeholder="Press 'F2' here..." id="unit" />
                                    <span id="unit_search" data-search="unit" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Product<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-multiselect="true" data-request='{"id":"18","search":"Product"}' data-select="{}" type="text" class="form-control" name="product" id="product" value="" placeholder="Press 'F2' here..." />
                                    <span class="multiselect-text"><span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span><input type="hidden" class="multi-search-selected multi_sel_product" name="multi_sel_product" value="%5B%7B%22Code%22%3A%22DLY%22%2C%22Name%22%3A%22DAILY%22%7D%5D"></span>
                                    <span id="product_search" data-search="product" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Department<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-multiselect="true" data-request='{"id":"31","search":"Product"}' data-select="{}" type="text" class="form-control" name="department" id="department" value="" placeholder="Press 'F2' here..." />
                                    <span class="multiselect-text"><span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span><input type="hidden" class="multi-search-selected multi_sel_department" name="multi_sel_department" value="%5B%7B%22Code%22%3A%220%22%2C%22Name%22%3A%22PMD%22%7D%5D"></span>
                                    <span id="department_search" data-search="department" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Customer</label>
                                <select name="customer" class="form-control" id="customer">
                                    <option value="all">All</option>
                                    <option value="0">Subscriber</option>
                                    <option value="1">Agent</option>
                                    <option value="2">General</option>
                                </select>
                            </span>

                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-lg">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Entry Type<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-callback="retEntryType" data-multiselect="true" data-request='{"id":"32","search":"Product"}' data-select="{}" type="text" class="form-control" name="entrytype" value="" placeholder="Press 'F2' here..." id="entrytype" />
                                    <span id="entrytype_search" data-search="entrytype" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-8 col-md-3 col-sm-4 col-xs-12">
                                <label>Entry Type Level</label>
                                <select disabled id="entrytype_level" name="entrytype_level[]" class="form-control select2" multiple="multiple">
                                    <option value="first">First Level</option>
                                    <option value="final">Final Level</option>
                                    <option value="others">Any Level Except First & Final</option>
                                </select>
                            </span>

                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-lg">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Response Header<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-callback="retResponseHeader" data-multiselect="true" data-request='{"id":"29","search":"Code"}' data-select="{}" type="text" class="form-control" name="response" value="" placeholder="Press 'F2' here..." id="response" />
                                    <span id="response_search" data-search="response" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-8 col-md-3 col-sm-4 col-xs-12">
                                <label>Response Header Level</label>
                                <select id="response_level" disabled name="response_level[]" class="form-control select2" multiple="multiple">
                                    <option value="first">First Level</option>
                                    <option value="final">Final Level</option>
                                    <option value="others">Any Level Except First & Final</option>
                                </select>
                            </span>

                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-lg">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>Entry Status<span class="text-red">[F2]</span></label>
                                <span class="input-group search-module" data-selected="true">
                                    <input data-callback="retEntryStatus" data-multiselect="true" data-request='{"id":"30","search":"Code"}' data-select="{}" type="text" class="form-control" name="status" value="" placeholder="Press 'F2' here..." id="status" />
                                    <span id="status_search" data-search="status" class="input-group-addon"><i class="fa fa-search"></i></span>
                                </span>
                            </span>

                            <span class="col-lg-8 col-md-3 col-sm-4 col-xs-12">
                                <label>Entry Status Level</label>
                                <select disabled id="status_level" name="status_level[]" class="form-control select2" multiple="multiple">
                                    <option value="first">First Level</option>
                                    <option value="final">Final Level</option>
                                    <option value="others">Any Level Except First & Final</option>
                                </select>
                            </span>

                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12 visible-lg">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-primary" name="show-report" id="show-report"><i class="fa fa-search" aria-hidden="true"></i> Show</button>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>&nbsp;</label>
                                <button type="button" class="btn btn-block btn-primary" name="show-summary" id="show-summary"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Summary</button>
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                <label>&nbsp;</label>
                                <button type="button" onClick="window.location='<?php echo base_url(); ?>index.php/dashboard'" class="btn btn-block btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                            </span>
                        </form>
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
        var page = 'CRM-REPORT';
    </script>
    <?php $this->load->view('inc/scripts'); ?> 
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug') { ?> 
     <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }  ?>
</body>
</html>