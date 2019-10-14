<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Receipts</title>
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
                <h1>Receipts</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Receipts</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <form method="post" action="<?php echo base_url('Transactions/UpsertReceipts'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <input type="hidden" name="is_update" id="is_update" value="0" />

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Receipt No</label>
                                <input type="text" name="wa_code" id="wa_code" class="form-control" value="<?php echo $code; ?>" readonly />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date</label>
                                <div class="input-group">
                                    <input readonly autocomplete="off" type="text" value="<?php echo date("d-m-Y",strtotime($finalize_date . ' +1 day')) ?>" required class="form-control" id="" name="" />
                                    <div class="input-group-addon btn disable-input"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required tabindex="1" autocomplete="off" value="" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#agent_details","indexes":"1,2"}]' 
                                           data-criteria='[{"column":"agent_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Please Select Promoter!"}]' />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 can-agent-details">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control agent_clr" id="agent_details" name="" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Pay Type</label>
                                <select tabindex="2" class="form-control" id="pay_type" name="pay_type">
                                    <?php $status = Enum::getAllConstants('PayType');
                                      foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Cheque No</label>
                                <input tabindex="3" type="text" name="cheque_number" id="cheque_number" class="form-control" value="" readonly />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Cheque Date</label>
                                <div class="input-group">
                                    <input readonly autocomplete="off" type="text" value="" tabindex="4" required class="form-control" id="cheque_date" name="cheque_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask data-greater="true" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 bank_det ">
                                <label>Bank</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly autocomplete="off" tabindex="5" value="" type="text" class="form-control disable-input" id="bank" name="bank" data-request='{"id":"39","search":""}' data-selectIndex="1" data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn disable-input" id="bank_search" data-search="bank"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Cheque Type</label>
                                <select tabindex="6" readonly class="form-control disable-input" id="cheque_type" name="cheque_type">
                                    <option value="0">Select</option>
                                    <?php $status = Enum::getAllConstants('ChequeType');
                                      foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Paid By</label>
                                <select tabindex="7" class="form-control" id="paid_by" name="paid_by">
                                    <?php $status = Enum::getAllConstants('PaymentMode');
                                      foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 bank_det ">
                                <label>Promoter</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input data-callback="ClearTmpRec" readonly autocomplete="off" tabindex="8" value="" type="text" class="form-control disable-input" id="promoter" name="promoter" data-request='{"id":"5","search":""}' data-selectIndex="1" data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="promoter_rec_sel" class="promoter_clr" id="promoter_rec_sel" value="">
                                    <div class="input-group-addon btn disable-input" id="promoter_search" data-search="promoter"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 bank_det ">
                                <label>Temporary Receipt No</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly autocomplete="off" tabindex="9" value="" type="text" class="form-control promoter_clr disable-input" id="temporary_receipt" name="temporary_receipt" data-request='{"id":"40","search":""}' data-selectIndex="1" data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.copy_code","input":"#promoter_rec_sel","select":"","encode":"false","multiselect":"false","required":"true","msg":"Please Select Promoter!"}]' />
                                    <div class="input-group-addon btn disable-input" id="temporary_receipt_search" data-search="temporary_receipt"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input tabindex="10" required type="number" name="amount" id="amount" class="form-control isNumberKey" isDecimal="true" value="" />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Remarks</label>
                                <input type="text" value="" tabindex="11" class="form-control" id="remarks" name="remarks" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <style>
                        .bills-results tbody td {
                            padding:5px!important;
                            border:solid 1px #cfcdcd!important;
                            vertical-align:middle!important;
                            display:table-cell!important;
                        }
                        .bills-results tr td:nth-child(1),
                        .bills-results tr td:nth-child(2),
                        .bills-results tr td:nth-child(3),
                        .bills-results tr td:nth-child(4),
                        .bills-results tr td:nth-child(5) {
                            border-right:none!important;
                            border-top:none!important;
                        }
                        .bills-results tr td:nth-child(6) {
                            border-top:none!important;
                        }
                        .bills-results .isNumberKey {
                            height:auto!important;
                            padding: 4px 4px 4px 4px!important;
                        }
                    </style>
                    <div class="box">
                        <div class="box-body">
                            <table width="100%" class="table bills-results" id="outstanding_tbl">
                                <thead>
                                    <tr>
                                        <td width="5%"  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Slno</td>
                                        <td width="15%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Product</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Outstanding</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Target</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Payments</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Balance</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-product="FSH">
                                        <td>1</td>
                                        <td>FLASH</td>
                                        <td align="right" class="outstanding">10000.00</td>
                                        <td align="right" class="target">5000.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="12" isDecimal="true" /></td>
                                        <td align="right" class="balance">10000.00</td>
                                    </tr>
                                    <tr data-product="MS">
                                        <td>2</td>
                                        <td>MAGIC SLATE</td>
                                        <td align="right" class="outstanding">25000.00</td>
                                        <td align="right" class="target">1200.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="13" isDecimal="true" /></td>
                                        <td align="right" class="balance">25000.00</td>
                                    </tr>
                                    <tr data-product="DLY">
                                        <td>3</td>
                                        <td>DAILY</td>
                                        <td align="right" class="outstanding">20000.00</td>
                                        <td align="right" class="target">3000.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="14" isDecimal="true" /></td>
                                        <td align="right" class="balance">20000.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <div class="box-body">
                            <table width="100%" class="table bills-results" id="security_tbl">
                                <thead>
                                    <tr>
                                        <td width="5%"  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Slno</td>
                                        <td width="15%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Date</td>    
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Description</td>         
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Security Amount</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Payments</td>
                                        <td width="20%" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;text-align:right;">Balance</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>01-05-2019</td>
                                        <td>SECURITY DEPOSITS</td>
                                        <td align="right" class="outstanding">10000.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="12" isDecimal="true" /></td>
                                        <td align="right" class="balance">10000.00</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>01-05-2019</td>
                                        <td>SECURITY DEPOSITS</td>
                                        <td align="right" class="outstanding">25000.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="13" isDecimal="true" /></td>
                                        <td align="right" class="balance">25000.00</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>01-05-2019</td>
                                        <td>SECURITY DEPOSITS</td>
                                        <td align="right" class="outstanding">20000.00</td>
                                        <td align="right"><input type="number" class="form-control isNumberKey payments" tabindex="14" isDecimal="true" /></td>
                                        <td align="right" class="balance">20000.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        <textarea id="trans_records"></textarea>
                        <div class="box-footer">
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <button class="btn btn-block btn-primary" tabindex="16" type="button" id="upsert-records" name="search" value=""><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <button onclick="window.location='<?php echo base_url('Transactions/WeekdayAmendments');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </div>
                    </div>
                </form>
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
        var page = 'RECEIPTS';
        function ClearTmpRec() {
            $("#temporary_receipt, .temporary_receipt_clr").val('');
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
