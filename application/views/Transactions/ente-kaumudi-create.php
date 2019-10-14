<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Ente Kaumudi</title>
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
                <h1>Ente Kaumudi</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Ente Kaumudi</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <form method="post" action="<?php echo base_url('Transactions/UpsertEnteKaumudi'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <input type="hidden" name="is_update" value="0" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" name="ek_slno" id="ek_slno" value="<?php echo @$code; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input tabindex="1" value="" maxlength="15" autocomplete="off" required type="text" class="form-control" id="ek_reg_no" name="ek_reg_no" />
                            </div>

                            <!--Client-->
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Client</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="2" required data-target='[{"selector":"#sponsor_client_details","indexes":"1,2"}]' autocomplete="off" value="" type="text" class="form-control" id="sponsor_client" name="sponsor_client" data-request='{"id":"37","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Unit"}]' />
                                    <div class="input-group-addon btn" id="sponsor_client_search" data-search="sponsor_client"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="unit_code" value="<?php echo $this->user->user_unit_code; ?>" />

                            <div class="col-lg-5 col-md-3 col-sm-6 col-xs-12">
                                <label>Client Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control sponsor_client_clr" id="sponsor_client_details" name="sponsor_client_details" value="" />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <!--Canvassed By-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select tabindex="3" class="form-control" id="canvassed_by_type" name="canvassed_by_type">
                                    <?php $status = Enum::getAllConstants('CanvassedBy');
                                          foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true" id="canvassed_by_users">
                                    <input tabindex="4" autocomplete="off" value="" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#can_agent_details","indexes":"1,2"}]' />
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                                <!--manual input for #canvassed_by_type value others-->
                                <input tabindex="5" type="text" value="" class="form-control hide" id="canvassed_by_others" name="canvassed_by_others" />
                            </div>

                            <div class="col-lg-7 col-md-3 col-sm-6 col-xs-12 can-agent-details">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control canvassed_by_clr" id="can_agent_details" name="" value="" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Deal Amount</label>
                                <input tabindex="6" autocomplete="off" required type="number" isDecimal="true" class="form-control calculate-copies isNumberKey" name="ek_deal_amount" id="ek_deal_amount" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Rate</label>
                                <input readonly autocomplete="off" required type="number" isDecimal="true" class="form-control isNumberKey" name="ek_rate" id="ek_rate" value="<?php echo $rate_amount; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>No of Copies</label>
                                <input autocomplete="off" type="number" readonly class="form-control" name="ek_copies" id="ek_copies" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Amount</label>
                                <input tabindex="7" autocomplete="off" type="number" isDecimal="true" class="form-control isNumberKey" name="ek_inc_amt" id="ek_inc_amt" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Paid</label>
                                <input tabindex="8" autocomplete="off" type="number" isDecimal="true" class="form-control isNumberKey" name="ek_inc_paid" id="ek_inc_paid" value="" />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive">
                            <!--add to list-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="9" data-target='[{"selector":"#sub_agent_name","indexes":"7,2,3"}]' autocomplete="off" value="" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Unit"}]' />
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control subscriber_clr" id="sub_agent_name" name="" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input tabindex="10" autocomplete="off" type="number" class="form-control isNumberKey" name="copies" id="copies" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input tabindex="11" required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="start_date" name="start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-warning" id="add_to_list" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
                                <table class="table table-results no-data-tbl" border="0" id="ek-copy-table" width="100%">
                                    <thead>
                                        <tr>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Subscriber</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Agent</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Start Date</td>
                                            <td align="right" style="background: #cfcdcd;color: #000; font-weight: bold">Copies</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Status</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Status Date</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">&nbsp;</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="no-records">
                                            <td colspan="7">No Records Found!</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary upsert-ente-kaumudi" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/EnteKaumudi');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
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
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'ENTE-KAUMUDI-TRANS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
