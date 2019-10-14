<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Other Receipts PDC</title>
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
                <h1>Other Receipts PDC View</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li>Accounts</li>
                    <li class="active">Other Receipts PDC</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertOtherReceiptsPDC'); ?>" name="scheme-rcpt-form" id="scheme-rcpt-form">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt No.</label>
                                <input autocomplete="off" readonly type="text" class="form-control input-bold-text" name="sch_rcpt_view_no" id="sch_rcpt_view_no" value="<?php echo $sch_rcpt_details->pdc_no; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt Date</label>
                                <input value="<?php echo date("d-m-Y",strtotime($sch_rcpt_details->pdc_date)); ?>" autocomplete="off" readonly type="text" class="form-control" id="sch_rec_dte" name="sch_rec_dte" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Heads</label>
                                <input type="text" class="form-control" readonly value="<?php echo $sch_rcpt_details->copytype_name; ?>" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <?php $subscriber = explode('#&', $sch_rcpt_details->subscriber);?>
                                <input type="text" class="form-control" readonly value="<?php echo $subscriber[1]; ?>" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Address</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="sub_det" id="sub_det" value="<?php echo $subscriber[2]; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme No.</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" name="sub_scheme" id="sub_scheme" value="<?php echo $sch_rcpt_details->pdc_scheme_code; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Against Cheque Bounce</label>
                                <input type="text" class="form-control" readonly value="<?php if($sch_rcpt_details->pdc_against_dis=='0') echo 'No'; else echo 'Yes';;?>" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_rcpt hide">
                                <label>Receipt No.</label>
                                <input type="text" class="form-control" readonly value="<?php echo $sch_rcpt_details->pdc_against_dis_code; ?>" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det">
                                <label>Cheque No.</label>
                                <input readonly value="<?php echo $sch_rcpt_details->pdc_chq_no; ?>" autocomplete="off"  tabindex="6" type="number" isRequired="true" class="form-control isNumberKey" id="sch_chq_no" name="sch_chq_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det">
                                <label>Cheque Date</label>
                                <input readonly value="<?php echo date("d-m-Y", strtotime($sch_rcpt_details->pdc_chq_date)); ?>" autocomplete="off"  tabindex="7" type="text" isRequired="true" class="form-control" id="sch_chq_dte" name="sch_chq_dte"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 bank_det">
                                <label>Bank</label>
                                <input readonly value="<?php echo $sch_rcpt_details->bank_name; ?>" autocomplete="off" tabindex="10" type="text" class="form-control" id="bank" name="bank" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input readonly value="<?php echo $sch_rcpt_details->pdc_amount; ?>"  tabindex="12" style="text-align:right" autocomplete="off" type="text" class="form-control isNumberKey" id="sch_amt" name="sch_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Payment Mode</label>
                                <select class="form-control" tabindex="13" id="payment_mode" name="payment_mode" readonly>
                                    <?php
                                      $status = Enum::getAllConstants('PaymentMode');
                                      foreach($status as $key => $value) {
                                    ?>
                                    <option  <?php if($sch_rcpt_details->pdc_paid_by==$key) echo 'selected';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_text">Promoter</label>
                                <input readonly value="<?php echo $sch_rcpt_details->promoter_name; ?>" tabindex="12" autocomplete="off" type="text" class="form-control" id="promoter" name="promoter" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_det_text">Promoter Area</label>
                                <input readonly type="text" class="form-control promoter_clr" name="promoter_det" id="promoter_det" value="<?php echo $sch_rcpt_details->promoter_area; ?>" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label>Temp Receipt</label>
                                <input readonly type="text" class="form-control" name="tmp_rcpt" id="tmp_rcpt" value="<?php echo $sch_rcpt_details->pdc_temp_rec; ?>" />
                           </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea  class="form-control"  tabindex="16" id="remarks" name="remarks" rows="1" style="height:34px" readonly><?php echo $sch_rcpt_details->pdc_remarks; ?></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/OtherReceiptsPDC');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'OTHER-RECEIPTS-CREATE';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
