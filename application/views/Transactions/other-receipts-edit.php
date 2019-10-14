<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Other Receipts</title>
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
                <h1>Other Receipts Edit</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li>Accounts</li>
                    <li class="active">Other Receipts</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertOtherReceipts'); ?>" name="scheme-rcpt-form" id="scheme-rcpt-form">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt No.</label>
                                <input autocomplete="off" readonly type="text" class="form-control input-bold-text" name="sch_rcpt_view_no" id="sch_rcpt_view_no" value="<?php echo $sch_rcpt_details->srec_no; ?>" />
                                <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                                <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                                <input type="hidden" name="sch_rcpt_no" value="<?php echo $sch_rcpt_code;?>" />
                                <input type="hidden" name="is_update" id="is_update" value="1"/>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt Date</label>
                                <input value="<?php echo date("d-m-Y",strtotime($sch_rcpt_details->srec_date)); ?>" autocomplete="off" readonly type="text" class="form-control" id="sch_rec_dte" name="sch_rec_dte" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Heads</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly data-required="copy_type_clr" autocomplete="off" value="<?php echo $sch_rcpt_details->copytype_name; ?>"  tabindex="1" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"false"},
                                                            {"column":"RC.rate_pdt_code","input":"#pdt_code","select":"","encode":"false","multiselect":"false","required":"false"}]' />
                                    <input type="hidden" name="copy_type_rec_sel" class="copy_type_clr" id="copy_type_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_rcpt_details->copytype_name,"Code"=>$sch_rcpt_details->copytype_code)));?>"/>
                                    <div class="input-group-addon btn" style="pointer-events:none" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <?php $subscriber = explode('#&', $sch_rcpt_details->subscriber);?>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="subscriber_clr" autocomplete="off" data-selectable="false"  tabindex="2" value="<?php echo $subscriber[1]; ?>" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"38","search":""}'
                                           data-criteria='[{"column":"copy_type","input":"#copy_type_rec_sel","select":"","encode":"false","condition":"true","required":"false"}]' data-select="{}" data-target='[{"selector":"#sub_det","indexes":"3"},{"selector":"#sub_scheme","indexes":"0"}]' data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="<?php echo rawurlencode(json_encode(array("Scheme No"=>$sch_rcpt_details->srec_scheme_code,"Scheme"=>$sch_rcpt_details->copytype_name,"Name"=>$subscriber[1],"Address"=>$subscriber[2],"Amount"=>"","Pending Amount"=>"")));?>" />
                                    <div class="input-group-addon btn" style="pointer-events:none;" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Address</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="sub_det" id="sub_det" value="<?php echo $subscriber[2]; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serial No.</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" name="sub_scheme" id="sub_scheme" value="<?php echo $sch_rcpt_details->srec_scheme_code; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Against Cheque Bounce</label>
                                <select class="form-control"  tabindex="3" id="against_chqbounce" name="against_chqbounce">
                                    <option <?php if($sch_rcpt_details->srec_against_dis=='0') echo 'selected';?> value="0">No</option>
                                    <option <?php if($sch_rcpt_details->srec_against_dis=='1') echo 'selected';?> value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_rcpt hide">
                                <label>Receipt No.</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo $sch_rcpt_details->srec_against_dis_code;?>" type="text"  tabindex="4" class="form-control" id="receipt_no" name="receipt_no" data-request='{"id":"9","search":""}' 
                                           data-criteria='[{"column":"rec_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="receipt_no_rec_sel" class="receipt_no_clr" id="receipt_no_rec_sel" value="<?php echo rawurlencode(json_encode(array("Receipt No"=>$sch_rcpt_details->srec_against_dis_code,"Amount"=>"")));?>" />
                                    <div class="input-group-addon btn" id="receipt_no_search" data-search="receipt_no"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Pay Type</label>
                                <select class="form-control" id="pay_type"  tabindex="5" name="pay_type">
                                    <?php
                                      $status = Enum::getAllConstants('PayType');
                                      foreach($status as $key => $value) {
                                    ?>
                                    <option  <?php if($sch_rcpt_details->srec_pay_type==$key) echo 'selected';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Cheque) echo 'hide';?>">
                                <label>Cheque No.</label>
                                <input value="<?php echo $sch_rcpt_details->srec_chq_no; ?>" autocomplete="off"  tabindex="6" type="number" isRequired="true" class="form-control isNumberKey" id="sch_chq_no" name="sch_chq_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Cheque) echo 'hide';?>">
                                <label>Cheque Date</label>
                                <input value="<?php echo date("d-m-Y", strtotime($sch_rcpt_details->srec_chq_date)); ?>" autocomplete="off"  tabindex="7" type="text" isRequired="true" class="form-control" id="sch_chq_dte" name="sch_chq_dte"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 card_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Card) echo 'hide';?>">
                                <label>Card No.</label>
                                <input value="<?php echo $sch_rcpt_details->srec_card_no; ?>" autocomplete="off" tabindex="8" isRequired="true" type="number" class="form-control isNumberKey" id="sch_card_no" name="sch_card_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 card_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Card) echo 'hide';?>">
                                <label>Card Name</label>
                                <input value="<?php echo $sch_rcpt_details->srec_card_name; ?>" autocomplete="off"  tabindex="9"type="text"  isRequired="true" class="form-control isAlpha" id="sch_card_name" name="sch_card_name" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 card_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Card) echo 'hide';?>">
                                <label>Card Expiry</label>
                                <input value="<?php echo $sch_rcpt_details->srec_card_exp_date; ?>" autocomplete="off" tabindex="10" type="text"  class="form-control" id="sch_card_exp" name="sch_card_exp" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 bank_det <?php if($sch_rcpt_details->srec_pay_type!=PayType::Card && $sch_rcpt_details->srec_pay_type!=PayType::Cheque) echo 'hide';?>">
                                <label>Bank</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="11" value="<?php echo $sch_rcpt_details->bank_name; ?>" type="text" class="form-control" id="bank" name="bank" data-request='{"id":"39","search":""}' data-selectIndex="1" data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="bank_rec_sel" class="bank_clr" id="bank_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_rcpt_details->bank_name,"Address"=>"","Code"=>$sch_rcpt_details->bank_code)));?>">
                                    <div class="input-group-addon btn" id="bank_search" data-search="bank"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input <?php if($this->user->user_id!=1){?> readonly <?php }?> value="<?php echo $sch_rcpt_details->srec_amount; ?>"  tabindex="12" style="text-align:right" autocomplete="off" type="text" class="form-control isNumberKey" id="sch_amt" name="sch_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Payment Mode</label>
                                <select class="form-control" tabindex="13" id="payment_mode" name="payment_mode">
                                    <?php
                                      $status = Enum::getAllConstants('PaymentMode');
                                      foreach($status as $key => $value) {
                                    ?>
                                    <option  <?php if($sch_rcpt_details->srec_paid_by==$key) echo 'selected';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_text">Promoter</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="14" value="<?php echo $sch_rcpt_details->promoter_name; ?>" type="text" class="form-control" id="promoter" name="promoter" data-request='{"id":"5","search":""}' data-selectIndex="0" data-target='[{"selector":"#promoter_det","indexes":"1"}]'
                                           data-criteria='[{"column":"promoter_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="promoter_rec_sel" class="promoter_clr" id="promoter_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_rcpt_details->promoter_name,"Area"=>$sch_rcpt_details->promoter_area,"Code"=>$sch_rcpt_details->promoter_code)));?>">
                                    <div class="input-group-addon btn" id="promoter_search" data-search="promoter"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_det_text">Promoter Area</label>
                                <input type="text" class="form-control promoter_clr" name="promoter_det" id="promoter_det" value="<?php echo $sch_rcpt_details->promoter_area; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label>Temp Receipt</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" tabindex="15" value="<?php echo $sch_rcpt_details->srec_temp_rec; ?>" type="text" class="form-control" id="tmp_rcpt" name="tmp_rcpt" data-request='{"id":"9","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="promoter_rec_sel" class="promoter_clr" id="promoter_rec_sel" value="<?php echo rawurlencode(json_encode(array("Receipt No"=>$sch_rcpt_details->srec_temp_rec)));?>">
                                    <div class="input-group-addon btn" id="tmp_rcpt_search" data-search="tmp_rcpt"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea  class="form-control"  tabindex="16" id="remarks" name="remarks" rows="1" style="height:34px"><?php echo $sch_rcpt_details->srec_remarks; ?></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary"  tabindex="17" type="button" id="scheme-rcpt-save"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/OtherReceipts');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
