<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Monthly Evaluation</title>
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
                <h1>Monthly Evaluation</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Monthly Evaluation</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <form id="monthly-eval" method="post" target="_blank" action="" onsubmit="return CIRCULATION.utils.formValidation(this);">                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Billing Period</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="<?php echo @$bill_period->entry_period;?>" type="text" class="form-control" id="billing_period" name="billing_period" data-request='{"id":"19","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="billing_period_search" data-search="billing_period"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Type</label>
                                <select class="form-control" id="type">
                                    <option value="1">Unitwise</option>
                                    <option value="2">Monthwise</option>
                                </select>
                            </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Units</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input required autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />                                     
                                   <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button data-type="summary" class="btn btn-block btn-primary show-report" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Summary</button>
                           </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="detailed-wrap">
                                <label>&nbsp;</label>
                                <button data-type="detailed" class="btn btn-block btn-primary show-report" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show Detailed</button>
                            </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
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
        var page = 'MONTHLY-EVALUATION';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>