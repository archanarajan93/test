<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Sponsor</title>
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
                <h1>Sponsor</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Sponsor</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertSponsor'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">

                            <input type="hidden" name="is_update" value="0" />                      
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" name="spons_code" id="spons_code" value="<?php echo @$code; ?>" />
                            </div>                            

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input tabindex="1" value="" maxlength="15" autocomplete="off" required type="text" class="form-control" id="spons_reg_no" name="spons_reg_no" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="2" required autocomplete="off" value="" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Sale"},
                                                           {"column":"avoid_entekaumudi","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid"}]' />
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="copy_code" value="CP0004" />

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <!--Client-->
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Client</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="3" required data-target='[{"selector":"#sponsor_client_details","indexes":"1,2"}]' autocomplete="off" value="" type="text" class="form-control" id="sponsor_client" name="sponsor_client" data-request='{"id":"37","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Unit"}]' />                                    
                                    <div class="input-group-addon btn" id="sponsor_client_search" data-search="sponsor_client"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="unit_code" value="<?php echo $this->user->user_unit_code; ?>" />

                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12">
                                <label>Client Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control sponsor_client_clr" id="sponsor_client_details" name="sponsor_client_details" value="" />
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <!--Agent-->
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="4" required data-selectindex="0" data-target='[{"selector":"#agent_details","indexes":"1,2"}]' autocomplete="off" value="" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />                                    
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control agent_clr" id="agent_details" name="agent_details" value="" />
                            </div>
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <!--Canvassed By-->                  
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select tabindex="5" class="form-control" id="canvassed_by_type" name="canvassed_by_type">
                                <?php $status = Enum::getAllConstants('CanvassedBy'); 
                                      foreach($status as $key => $value) {
                                          if($key == 1) continue; ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true" id="canvassed_by_users">
                                    <input tabindex="6" autocomplete="off" value="" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#can_agent_details","indexes":"1,2"}]' />                                    
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                                <!--manual input for #canvassed_by_type value others-->
                                <input type="text" value="" class="form-control hide" id="canvassed_by_others" name="canvassed_by_others" />
                            </div>

                            <div class="col-lg-7 col-md-3 col-sm-6 col-xs-12 can-agent-details">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control canvassed_by_clr" id="can_agent_details" name="" value="" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>


                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Amount</label>
                                <input tabindex="7" autocomplete="off" type="number" isDecimal="true" class="form-control isNumberKey" name="spons_inc_amt" id="spons_inc_amt" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Paid</label>
                                <input tabindex="8" autocomplete="off" type="number" isDecimal="true" class="form-control isNumberKey" name="spons_inc_paid" id="spons_inc_paid" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Deal Amount</label>
                                <input tabindex="9" autocomplete="off" required type="number" isDecimal="true" class="form-control calculate-copies isNumberKey" name="spons_deal_amt" id="spons_deal_amt" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Rate</label>
                                <input tabindex="10" autocomplete="off" required type="number" isDecimal="true" class="form-control calculate-copies isNumberKey" name="spons_rate_per_copy" id="spons_rate_per_copy" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>No of Copies</label>
                                <input autocomplete="off" type="number" readonly class="form-control" name="spons_copies" id="spons_copies" value="" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <!--Add Copies By Date-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date</label>
                                <div class="input-group">
                                    <input tabindex="11" type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="spons_list_date" name="spons_list_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input tabindex="12" autocomplete="off" type="number" class="form-control isNumberKey" name="spons_list_copy" id="spons_list_copy" value="" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label style="width:100%">&nbsp;</label>
                                <button class="btn btn-block btn-warning" id="add_copies_to_list" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-results no-data-tbl" border="0" id="spons-copy-table" width="100%">
                                    <thead>
                                        <tr>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold">Date</td>
                                            <td style="background: #cfcdcd;color: #000; font-weight: bold" align="right">Copies</td>
                                            <td style="background: #cfcdcd;color: #000;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="no-records">
                                            <td colspan="3">No Records Found!</td>                                  
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                           

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary upsert-sponsor" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/Sponsor');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'SPONSOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>