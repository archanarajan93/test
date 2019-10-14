<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme Details</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php $this->load->view('inc/styles.php');
        $this->load->view('inc/alerts');
        $today = Enum::getTZDateTime(null, "d-m-Y");?>
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
                <h1>Scheme Details</h1>
               <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>Reports</li>
                    <li class="active">Scheme Details</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" name="schdetails_report" id="schdetails_report" target="_blank" action=<?php echo base_url("MISReports/SchemeDetails");  ?> onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date Type</label>
                                <select class="form-control" name="date_type" id="date_type">
                                    <option>Canvassed Date</option>
                                    <option>Copy Start Date</option>
                                    <option>Receipt Date</option>
                                    <option>Dishonoured</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date From</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo $today; ?>" class="form-control" id="date_from" name="date_from" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask data-compare="#date_to" autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date To</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo $today; ?>" class="form-control" id="date_to" name="date_to" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme/Sponsor</label>
                                <select id="copy_master" name="copy_master" class="hidden" multiple>
                                    <?php foreach($copy_lists as $copy){?>
                                    <option <?php if($copy->copy_name=='SPONSOR' || $copy->copy_name == 'SCHEME') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                    <?php }?>
                                </select>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"15","search":"Name"}' data-select="{}" data-multiselect="true" data-criteria='[{"column":"group_copy_code","input":"#copy_master","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' placeholder="Select Scheme/Sponsor" />
                                    <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Type</label>
                                <select class="form-control" id="type">
                                    <option value="1">Unitwise</option>
                                    <option value="2">Groupwise</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Unit</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" data-callback="clrInputs" />
                                    <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 toggle-grps hide">
                                <label>Groups</label>
                                <select class="form-control" id="groups" name="groups">
                                    <?php foreach(SeedData::$Groups as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 toggle-grps hide" id="groupwise-wrap">
                                <label id="member-title">Field Promoter</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="groupwise" name="groupwise" data-request='{"id":"5","search":""}' data-select="{}" data-multiselect="true" placeholder=""
                                           data-criteria='[{"column":"promoter_unit","input":"#unit_rec_sel","select":"","encode":"true","multiselect":"false","required":"true","msg":"Please select unit"},
                                                           {"column":"promoter_unit","input":".multi_sel_unit","select":"","encode":"true","multiselect":"true","required":"false","msg":""}]' />                                    
                                    <div class="input-group-addon btn" id="groupwise_search" data-search="groupwise"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                           
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                <label style="width:100%">&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="button" name="show_summ" id="show_summ"><i class="fa fa-search" aria-hidden="true"></i> Show Summary</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6">
                                <label style="width:100%">&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="button" name="show_detailed" id="show_detailed"><i class="fa fa-search" aria-hidden="true"></i> Show Detailed</button>
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
        var page = 'SCHEME-DETAILS';
        function clrInputs() {
            $("#groupwise-wrap .multiselect-text").remove();
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?> 
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug') { ?> 
     <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }  ?>
</body>
</html>