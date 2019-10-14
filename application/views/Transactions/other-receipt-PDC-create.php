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
                <h1>Other Receipts PDC Create</h1>
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
                                <input autocomplete="off" readonly type="text" class="form-control input-bold-text" name="sch_rcpt_view_no" id="sch_rcpt_view_no" value="<?php echo @$pdc_rcpt_code; ?>" />
                                <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                                <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt Date</label>
                                <input value="<?php echo $pdc_rcpt_dte;?>" autocomplete="off" readonly type="text" class="form-control" id="sch_rec_dte" name="sch_rec_dte" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Group</label>
                                <input type="hidden" id="copy_code" value="<?php echo rawurlencode(json_encode(array("CP0003","CP0004")));?>" />
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_group_clr" autocomplete="off" value=""  tabindex="1" type="text" class="form-control" id="copy_group" name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                        data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"true","multiselect":"true","required":"true","msg":"Invalid Copy Code"}]'/>
                                    <div class="input-group-addon btn" id="copy_group_search" data-search="copy_group"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_type_clr" autocomplete="off" value="" tabindex="2" type="text" class="form-control copy_group_clr" id="copy_type" name="copy_type" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.group_code","input":"#copy_group_rec_sel","select":"Code","encode":"true","multiselect":"false","required":"false"}]' />
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="subscriber_clr" autocomplete="off"  tabindex="3" value="" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"38","search":""}' 
                                           data-criteria='[{"column":"copy_type","input":"#copy_type_rec_sel","select":"","encode":"false","condition":"true","required":"false"}]' data-select="{}"  data-target='[{"selector":"#sub_det","indexes":"3"},{"selector":"#sub_scheme","indexes":"0"}]' data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Address</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="sub_det" id="sub_det" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serial No.</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" name="sub_scheme" id="sub_scheme" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Against Cheque Bounce</label>
                                <select class="form-control"  tabindex="4" id="against_chqbounce" name="against_chqbounce">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_rcpt hide">
                                <label>Receipt No.</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text"  tabindex="5" class="form-control" id="receipt_no" name="receipt_no" data-request='{"id":"9","search":""}' 
                                           data-criteria='[{"column":"shakha_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="receipt_no_search" data-search="receipt_no"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                           
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det ">
                                <label>Cheque No.</label>
                                <input value="" autocomplete="off"  tabindex="7" type="number" isRequired="true" class="form-control isNumberKey" id="sch_chq_no" name="sch_chq_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 chq_det ">
                                <label>Cheque Date</label>
                                <input value="" autocomplete="off"  tabindex="8" type="text" isRequired="true" class="form-control" id="sch_chq_dte" name="sch_chq_dte"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 bank_det ">
                                <label>Bank</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="12" value="" type="text" class="form-control" id="bank" name="bank" data-request='{"id":"39","search":""}' data-selectIndex="1" data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="bank_search" data-search="bank"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input required value="0.00"  tabindex="13" style="text-align:right" autocomplete="off" type="text" class="form-control isNumberKey" id="sch_amt" name="sch_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Payment Mode</label>
                                <select class="form-control" tabindex="14" id="payment_mode" name="payment_mode">
                                    <?php
                                      $status = Enum::getAllConstants('PaymentMode');
                                      foreach($status as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_text">Promoter</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="15" value="" type="text" class="form-control" id="promoter" name="promoter" data-request='{"id":"5","search":""}' data-selectIndex="0" data-target='[{"selector":"#promoter_det","indexes":"1"}]'
                                           data-criteria='[{"column":"promoter_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="promoter_search" data-search="promoter"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 prom_det hide">
                                <label id="can_det_text">Promoter Area</label>
                                <input type="text" class="form-control promoter_clr" name="promoter_det" id="promoter_det" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 prom_det hide">
                                <label>Temp Receipt</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" tabindex="16" value="" type="text" class="form-control" id="tmp_rcpt" name="tmp_rcpt" data-request='{"id":"9","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="tmp_rcpt_search" data-search="tmp_rcpt"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea  class="form-control"  tabindex="17" id="remarks" name="remarks" rows="1" style="height:34px"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary"  tabindex="18" type="submit" id="scheme-rcpt-save"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>

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
        var page = 'OTHER-RECEIPTS-PDC-CREATE';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
