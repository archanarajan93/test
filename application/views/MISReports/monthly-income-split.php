<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Monthly P & L Income Split</title>
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
                <h1>Monthly P & L Income Split</h1>
               <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Reports</li>
                    <li class="active">Monthly P & L Income Split</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" name="schdetails_report" id="schdetails_report" target="_blank" action=<?php echo base_url("MISReports/MonthlyIncomeSplitDetailed");  ?> onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Report Type</label>
                                <select class="form-control" name="report_type" id="report_type">
                                    <option>Monthwise</option>
                                    <option>Unitwise</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 unit-sel">
                                <label>Unit</label>
                                <select class="form-control" id="sel_unit" name="sel_unit">
                                    <?php foreach($unit_lists as $unit){?>
                                    <option <?php if($unit->unit_code == $this->user->user_unit_code) echo 'selected';?> value="<?php echo $unit->unit_code;?>"><?php echo $unit->unit_name;?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 multi-unit-sel"  style="display:none;">
                                <label>Unit</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":"Name"}' data-select="{}" data-multiselect="true" placeholder="Select Unit" />
                                    <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                                    <span class="multiselect-text"><span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span><input type="hidden" class="multi-search-selected multi_sel_unit" name="multi_sel_unit" value="<?php echo rawurlencode(json_encode(array(array("Code"=>$this->user->user_unit_code,"Name"=>$this->user->user_unit_name))));?>"></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 month-sel" style="display:none;">
                                <label>Month</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $month; ?>" class="form-control" id="month" name="month" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 multi-month-sel">
                                <label>Month From</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $month; ?>" class="form-control" id="month_from" name="month_from" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 multi-month-sel">
                                <label>Month To</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo $month; ?>" class="form-control" id="month_to" name="month_to" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                           
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                <label style="width:100%">&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="show_summ" id="show_summ"><i class="fa fa-search" aria-hidden="true"></i> Show</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                <label style="width:100%">&nbsp;</label>
                                <button class="btn btn-block btn-danger" onclick="window.location='<?php echo base_url('Dashboard');?>'" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                            </div>
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
        var page = 'MONTH-INCOME-SPLIT';
    </script>
    <?php $this->load->view('inc/scripts'); ?> 
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug') { ?> 
     <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }  ?>
</body>
</html>