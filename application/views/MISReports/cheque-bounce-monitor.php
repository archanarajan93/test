<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Cheque Bounce Monitor</title>
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
                <h1>Cheque Bounce Monitor</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">MIS Reports</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">                       
                       <form id="cbm-pilot" method="post" target="_blank" action="" onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Billing Period</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input required autocomplete="off" value="" type="text" class="form-control" id="billing_period" name="billing_period" data-request='{"id":"19","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                   <div class="input-group-addon btn" id="billing_period_search" data-search="billing_period"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Product Group</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" required type="text" class="form-control" id="product_group" name="product_group" data-request='{"id":"3","search":"Product Group"}' data-select="{}" data-multiselect="false" placeholder="Select Product Group" />
                                   <div class="input-group-addon btn" id="product_group_search" data-search="product_group"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Report Type</label>
                               <select class="form-control" id="type">
                                   <option value="1">Unitwise</option>
                                   <option value="2">Groupwise</option>
                               </select>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Unit</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                   <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>No of Months</label>
                               <select class="form-control" id="toggle_unit_multiselect">                                   
                                   <?php for($i=1;$i<=12;$i++) { ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?>
                               </select>
                           </div>

                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide toggle-grps">
                               <label>Groups</label>                                                             
                               <select class="form-control" id="groups" name="groups">
                                   <?php foreach(SeedData::$Groups as $key => $value) { ?>
                                   <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                           
                           <?php
                           //autofill-promoters-initially
                           $pro = array();
                           foreach($promoters as $p) {
                               $pro[] =   array ('Code' => $p->promoter_code,
                                                 'Name' => $p->promoter_name,
                                                 'Area' => $p->promoter_area,
                                                 'Phone' => $p->promoter_phone);
                           }
                           ?>
                           <!--data-criteria='[{"column":"groups","input":"#groups","select":"","encode":"false","multiselect":"false","msg":"Invalid Group Selected"}]'-->
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide toggle-grps" id="groupwise-wrap">
                               <label id="member-title">Field Promoter</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="groupwise" name="groupwise" data-request='{"id":"5","search":""}' data-select="{}" data-multiselect="true" placeholder="" /> 
                                    <span class="multiselect-text">
                                        <span class="selected-res"><?php echo count($pro); ?> Selected</span>
                                        <span class="clear-btn"><i class="fa fa-close"></i></span>
                                        <input type="hidden" class="multi-search-selected multi_sel_groupwise" name="multi_sel_groupwise" value="<?php echo rawurlencode(json_encode($pro)); ?>">
                                    </span>
                                   <div class="input-group-addon btn" id="groupwise_search" data-search="groupwise"><i class="fa fa-search"></i></div>
                               </div>
                           </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Report Mode</label>
                               <select name="show_hidden" class="form-control">
                                   <?php
                                         $rt = Enum::getAllConstants('ReportMode');
                                         foreach($rt as $key => $value) {
                                   ?>
                                   <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                   <?php } ?>
                               </select>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button data-type="summary" class="btn btn-block btn-primary show-report" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Summary</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="detbtn-blck" style="display:none;">
                               <label>&nbsp;</label>
                               <button data-type="detailed" id="detailed-btn" disabled class="btn btn-block btn-warning show-report" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Detailed</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
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
        var page = 'CHEQUE-BOUNCE-MONITOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>