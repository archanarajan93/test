<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Token Details - CRM</title>
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
                <h1>Token Details - CRM</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Token Details - CRM</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <style>
                    .form-control[disabled][readonly] {
                        background-color: #eee !important;
                        border: 1px solid #ccc !important;
                    }
                    </style>
                    <div class="box-body pad table-responsive">
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Token No.</label>
                            <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="TVM076757" readonly="" disabled="" id="token_no" name="token_no">
                        </span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>User</label>
                            <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="GOPIKRISHNA" readonly="" disabled="" id="user_name" name="user_name">
                            <input type="hidden" class="form-control" value="ADMINISTRATOR" readonly="" disabled="" id="current_user" name="current_user">
                        </span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Date-Time</label>
                            <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="17-Jul-2019 04:01 PM" readonly="" disabled="" id="now" name="now">
                        </span>
                        <span class="col-xs-12" style="margin-bottom:15px;"></span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Unit<span class="text-red">[F2]</span></label>
                            <input type="text" id="unit_code" class="form-control" disabled="" value="TVM" readonly="">
                        </span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Product</label>
                            <input type="text" class="form-control" disabled="" value="DLY" readonly="">
                        </span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Department</label>
                            <input type="text" class="form-control" id="dept" value="PMD" disabled="" readonly="">
                        </span>
                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label>Customer</label>
                            <input type="text" class="form-control" value="Subscriber" disabled="" readonly="">
                            <input type="hidden" id="cus_type" value="0">
                        </span>
                        <span class="col-xs-12">&nbsp;</span>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus" id="subscriber_box">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>SUBSCRIBER</strong></div>
                            <div class="row">
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Subscriber Code</label>
                                    <input type="text" class="form-control" value="STVM000083284" disabled="" readonly="">
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="ANILKUMAR P" disabled="" readonly="">
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="SASTHAMVILA VEEDU,TC 7/1195(4),KOORA-175 MARUTHAMKUZHY  695013  VATTIYOORKAVU P O" disabled="" readonly="">
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Contact No.</label>
                                    <input type="text" class="form-control" value="9400500995" disabled="" readonly="">
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Scheme</label>
                                    <input type="text" class="form-control" value="Unity 2018 1 Year - 2250" disabled="" readonly="">
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Scheme Code</label>
                                    <input value="SDTVM00028820" type="text" class="form-control cus_inp subscriber_clr" id="" name="" disabled="" readonly="">
                                </span>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Field Staff</label><br>
                                    <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding">
                                        <input readonly="" class="form-control subscriber_clr" type="text" name="sub_executive_code" id="sub_executive_code" value="">
                                    </div>
                                    <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding">
                                        <input readonly="" class="form-control cus_inp subscriber_clr" type="text" id="sub_executive" name="sub_executive" value="ANU V S NAIR">
                                    </div>
                                </div>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Agency</label><br>
                                    <span class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding"><input type="text" class="form-control" disabled="" readonly="" id="cus_ag_code" name="cus_ag_code" value="T0790"></span>
                                    <span class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding"><input type="text" class="form-control" disabled="" readonly="" id="cus_ag_name" name="cus_ag_name" value="SURESH KUMAR S."></span>
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Agency Phone</label>
                                    <input type="text" class="form-control" disabled="" readonly="" id="cus_ag_phone" name="cus_ag_phone" value="2364971,9446705453">
                                </span>
                                <span class="col-xs-12">&nbsp;</span>
                                <span class="col-xs-12">&nbsp;</span>
                            </div>
                        </div>                        
                        <span class="col-xs-12">&nbsp;</span>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive table-wrap no-padding">
                                <table width="100%" border="1" class="table table-results">
                                    <thead>
                                        <tr align="center">
                                            <td class="report-head"><b>Entry Type</b></td>
                                            <td class="report-head"><b>Response Header</b></td>
                                            <td class="report-head"><b>Remarks</b></td>
                                            <td class="report-head"><b>Entry Status</b></td>
                                            <td class="report-head"><b>User</b></td>
                                            <td class="report-head"><b>DateTime</b></td>
                                        </tr>
                                    </thead>
                                    <tbody id="resTbody">
                                        <tr data-level="1">
                                            <td>Outgoing</td>
                                            <td>OTHER RESPONSE</td>
                                            <td>പത്രം കിട്ടുന്നുണ്ട്,ഇനി വേണ്ട,പത്രം വേണമെങ്കിൽ ഇങ്ങോട്ടു വിളിച്ചു അറിയിക്കാമെന്ന് പറഞ്ഞു [വൈഫ്] [03/07/19]</td>
                                            <td>PMD - RENEWAL</td>
                                            <td>GOPIKRISHNA</td>
                                            <td>17-Jul-2019 04:01 PM</td>
                                        </tr>
                                        <tr data-level="2">
                                            <td>Action</td>
                                            <td></td>
                                            <td>RENEWED</td>
                                            <td>RENEWED</td>
                                            <td>RAJI</td>
                                            <td>08-Aug-2019 03:37 PM</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        var page = 'CRM-TOKEN-DETAILS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>