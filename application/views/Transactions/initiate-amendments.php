<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Initiate Amendments</title>
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
                <h1>Initiate Amendments</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Initiate Amendments</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/TriggerInitiateAmendments'); ?>" name="trans-form" id="trans-form">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date</label>
                                <div class="input-group">
                                    <input readonly type="text" value="<?php echo date('d-m-Y', strtotime($finalize_date . ' +1 day')); ?>" class="form-control" id="next_finalize_date" name="next_finalize_date" />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Include EnteKaumudi</label>
                                <select class="form-control" name="include_ek" id="include_ek">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" id="initiate_amendments" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Initiate</button>
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
        <form method="post" class="hide" target="_blank" id="open-trans-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'INITIATE-AMENDMENTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
