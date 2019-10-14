<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Plan For Copies</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php 
        $this->load->view('inc/styles.php');
        $this->load->view('inc/alerts'); 
        $today = Enum::getTZDateTime(null, "d-m-Y");
    ?>
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
                <h1>Plan For Copies</h1>
               <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li>MIS Reports</li>
                    <li class="active">Plan For Copies</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" name="plancopies_report" id="plancopies_report" target="_blank" action=<?php echo base_url("MISReports/PlanForCopies");  ?> onsubmit="return CIRCULATION.utils.formValidation(this);">
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
                                <label>Unit</label>
                                <select class="form-control" name="unit" id="unit">
                                    <?php foreach($unit_lists as $unit){?> 
                                    <option <?php if($this->user->user_unit_code == $unit->unit_code) echo 'selected';?> value="<?php echo $unit->unit_code;?>"><?php echo $unit->unit_name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>ACM</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="acm" name="acm" data-request='{"id":"2","search":"ACM"}' data-callback="clrInputs" data-select="{}" data-multiselect="true"  data-criteria='[{"column":"acm_unit","input":"#unit","select":"","encode":"false","multiselect":"false","msg":"Please Select Unit!"}]' placeholder="Select ACM" />
                                    <div class="input-group-addon btn" id="acm_search" data-search="acm"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Work Type</label>
                                <select class="form-control select2" name="work_type[]" id="work_type" multiple>
                                    <?php foreach(Enum::getAllConstants('WorkType') as $key=>$value) { ?>
                                    <option selected value="<?php echo $key; ?>"><?php  echo str_replace("_"," ",$value); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Team Member</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="team_member" name="team_member" data-request='{"id":"4","search":"Name"}' data-select="{}" data-multiselect="true"
                                            data-criteria='[{"column":"work_type","input":"#work_type","select":"","encode":"false","multiselect":"true","msg":"Please Select Work Type!"},
                                           {"column":"unit","input":"#unit","select":"","encode":"false","multiselect":"false","required":"false","msg":"Please Select Unit!"},
                                           {"column":"acm","input":"#acm_rec_sel","select":"","encode":"false","multiselect":"true","required":"false"}]' placeholder="Select Team Member" />
                                    <div class="input-group-addon btn" id="acm_search" data-search="acm"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>GD News</label>
                                <select class="form-control select2" name="gd_news[]" id="gd_news" multiple>
                                    <?php foreach(Enum::getAllConstants('GDNews') as $key=>$value) { ?>
                                    <option selected value="<?php echo $key; ?>"><?php  echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Report Type</label>
                                <select class="form-control" name="opt_type" id="opt_type">
                                    <option value="ACM Wise">ACM Wise</option>
                                    <option value="Worktype Wise">Worktype Wise</option>
                                    <option value="Teammember Wise">Teammember Wise</option>
                                    <option value="Bureau Wise">Bureau Wise</option>
                                </select>
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
        var page = 'PLAN-COPIES';
         function clrInputs() {
            $("#team_member").val('');
            $("#team_member").closest('.search-module').find('.multiselect-text').remove();
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?> 
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug') { ?> 
     <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }  ?>
</body>
</html>