<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | DCR</title>
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
                <h1>DCR</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard'); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">DCR</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">  
                                              
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Date</label>
                            <input type="text" class="form-control" readonly value="<?php echo date('d-M-Y'); ?>" />                                
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Type of work</label>
                            <select class="form-control" id="type-of-work">
                                <?php $wt = SeedData::$DcrWorkType; 
                                foreach($wt as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-xs">&nbsp;</div>

                        <!--AgencyWork-->
                        <div id="div-0" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding cont-div">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Phone</label>
                                <input type="number" class="form-control" required value="" min="0" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Place</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Starting Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control avoid-clr" id="" name="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <!--OtherIncome-->
                        <div id="div-1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding hide cont-div">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Client Name</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Address</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Head</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Billing Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control avoid-clr" id="" name="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input type="number" class="form-control" required value="" min="0" />
                            </div>                                
                        </div>

                        <!--Copy+-->
                        <div id="div-2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding hide cont-div">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input type="text" class="form-control" required value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy</label>
                                <input type="number" class="form-control" required value="" min="1" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Billing Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control avoid-clr" id="" name="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Address</label>
                                <input type="text" class="form-control" required value="" />
                            </div>
                        </div>

                        <!--<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-primary add-btn" type="button" name="SearchJudges" id="SearchJudges"><i class="fa fa-search" aria-hidden="true"></i> Show</button>
                        </div>-->                

                        <!--<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                        </div>-->                            
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('inc/footer'); $this->load->view('inc/help'); ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'DCR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/dcr.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>