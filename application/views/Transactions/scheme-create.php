<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme Create</title>
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
                <h1>Scheme Create</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Scheme Create</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertScheme'); ?>" name="scheme-create-form" id="scheme-create-form">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serial No.</label>
                                <input autocomplete="off" readonly type="text" class="form-control input-bold-text" name="sch_view_code" id="sch_view_code" value="<?php echo @$scheme_code; ?>" />
                                <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                                <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input value="" maxlength="15" autocomplete="off" tabindex="1" required type="text" class="form-control" id="sch_reg_no" name="sch_reg_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Type</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_group_clr" autocomplete="off" tabindex="2" value="" type="text" class="form-control" id="copy_group" name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]' />
                                    <div class="input-group-addon btn" id="copy_group_search" data-search="copy_group"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_type_clr" autocomplete="off" tabindex="3" value="" type="text" class="form-control copy_group_clr" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_code","input":"#copy_group_rec_sel","select":"Code","encode":"true","multiselect":"false","required":"false"},
                                                            {"column":"RC.rate_pdt_code","input":"#pdt_code","select":"","encode":"false","multiselect":"false","required":"false"}]'  data-callback="showEndDate"/>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="subscriber_clr" autocomplete="off" tabindex="4" value="" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}'
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}"  data-target='[{"selector":"#agent_det","indexes":"7,2,3"}]' data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="agent_det" id="agent_det" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Shakha</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" tabindex="5" class="form-control" id="shakha" name="shakha" data-request='{"id":"9","search":""}' 
                                           data-criteria='[{"column":"shakha_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="shakha_search" data-search="shakha"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Event</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" tabindex="6" class="form-control" id="event" name="event" data-request='{"id":"28","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="event_search" data-search="event"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select class="form-control" id="canvassed_by_type" tabindex="7" name="canvassed_by_type">
                                    <?php
                                      $status = Enum::getAllConstants('CanvassedBy');
                                      foreach($status as $key => $value) {
                                          if($value=='Promoter' || $value=='ACM') { continue;}
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 canvassed_by_users">
                                <label id="can_text">Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" tabindex="8" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-selectIndex="0" data-target='[{"selector":"#canvassed_name","indexes":"1,2"}]'
                                           data-criteria='[{"column":"agent_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 canvassed_by_users">
                                <label id="can_det_text">Agent Details</label>
                                <input type="text" class="form-control canvassed_by_clr" name="canvassed_name" id="canvassed_name" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="canvassed_by_others">
                                <label>Others</label>
                                <input autocomplete="off" type="text" value="" tabindex="9" class="form-control" id="canvassed_others" name="canvassed_others" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed Date</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo date('d-m-Y'); ?>" tabindex="10" class="form-control" id="canvassed_date" name="canvassed_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo date('d-m-Y'); ?>" tabindex="11" class="form-control" id="sch_start_date" name="sch_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input required readonly type="text" value="" class="form-control copy_type_clr" tabindex="12" id="sch_end_date" name="sch_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" style="pointer-events:none;"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Amount</label>
                                <input autocomplete="off" type="text" value="0.00" class="form-control text-right isNumberKey" tabindex="13" isDecimal="true" id="inc_amt" name="inc_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Paid</label>
                                <input autocomplete="off" type="text" value="0.00" class="form-control text-right isNumberKey" tabindex="14" isDecimal="true" id="inc_paid" name="inc_paid" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea  class="form-control" id="remarks" name="remarks" rows="1" tabindex="15" style="height:34px"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="button" id="scheme-save" tabindex="16"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/Scheme');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'SCHEME-CREATE';
        function showEndDate() {
            var schRecord = $("#copy_type_rec_sel").val(),
                schDet = schRecord ? JSON.parse(decodeURIComponent(schRecord)) : '',
                startDate = $("#sch_start_date").val(),
                endDate='',
                momentStart=null,
                momentEnd = null;
            if (schDet) {
                var momentStart = moment(startDate, "DD-MM-YYYY"),
                    years = parseInt(schDet["Years"]),
                    months = parseInt(schDet["Months"]),
                    days = parseInt(schDet["Days"]);
                if (years > 0) {
                    momentEnd = momentStart.add(years, 'years');
                }
                if (months > 0) {
                    momentEnd = momentEnd.add(months, 'months');
                }
                if (days > 0) {
                    momentEnd = momentEnd.add(days, 'days');
                }
                $("#sch_end_date").val(momentEnd.format("DD-MM-YYYY"));
            }
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
