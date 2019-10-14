<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Weekday Amendments</title>
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
                <h1>Weekday Amendments</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Weekday Amendments</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertWeekdayAmendments'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <input type="hidden" name="is_update" id="is_update" value="0" />                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input  type="text" name="wa_code" id="wa_code" class="form-control" value="<?php echo $code; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input type="text" required name="wa_reg_no" id="wa_reg_no" tabindex="1" class="form-control" value="" autocomplete="off"/>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required data-required="subscriber_clr" tabindex="2" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}'
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#sub_det","indexes":"7,2,3"}]'/>
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="">
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input type="text" class="form-control agent_clr" name="sub_det" id="sub_det" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type</label>
                                <input type="hidden" id="copy_code" value="CP0001" />
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" data-required="copy_group_clr" tabindex="3" id="copy_group" name="copy_group" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]' />
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="">                           
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input  autocomplete="off" type="text" value="" tabindex="4" required class="form-control" id="wa_start_date" name="wa_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask data-greater="true" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 "> 
                                <label>End Flag</label>
                                <select class="form-control end-flag" id="wa_end_flag" name="wa_end_flag" tabindex="5">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="last_date">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" value="" class="form-control "  tabindex="6" id="wa_end_date" name="wa_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input type="number" value="" class="form-control isNumberKey" id="wa_copies" tabindex="7"  name="wa_copies" autocomplete="off"/>
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">                              
                                <table width="100%" border="1" style="margin-top: 13px;">
                                    <tr>
                                        <td align="center">SUN</td>
                                        <td align="center">MON</td>
                                        <td align="center">TUE</td>
                                        <td align="center">WED</td>
                                        <td align="center">THU</td>
                                        <td align="center">FRI</td>
                                        <td align="center">SAT</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><input name="wa_sun" value="1" tabindex="8" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_mon" value="1" tabindex="9" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_tue" value="1" tabindex="10" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_wed" value="1" tabindex="11" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_thu" value="1" tabindex="12" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_fri" value="1" tabindex="13" type="checkbox" checked /></td>
                                        <td align="center"><input name="wa_sat" value="1" tabindex="14" type="checkbox" checked /></td>
                                    </tr>
                                </table>                                
                            </div>

                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12">
                                <label>Remark</label>
                                <input type="text" value="" tabindex="15" class="form-control" id="wa_remarks" name="wa_remarks" autocomplete="off"/>
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="16" type="button" id="upsert-records" name="search" value=""><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/WeekdayAmendments');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'WEEKDAY-AMENDMENTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>