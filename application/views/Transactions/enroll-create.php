<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Enroll Sale</title>
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
                <h1>Enroll Sale</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Enroll Sale</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertEnroll'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            
                            <input type="hidden" name="is_update" value="<?php echo isset($_GET['g_fe']) ? 1 : 0; ?>" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" name="sales_code" id="sales_code" value="<?php echo @$code; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input tabindex="1" value="" maxlength="15" autocomplete="off" required type="text" class="form-control" id="sales_reg_no" name="sales_reg_no" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Sale Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="2" required autocomplete="off" value="" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Sale"}]' />                                    
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="copy_code" value="CP0001" />

                            <!--Subscriber-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="3" required data-target='[{"selector":"#sub_agent_name","indexes":"7,2,3"},{"selector":"#sub_agent_loc","indexes":"4,5"}]' autocomplete="off" value="" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}' data-select="{}" data-multiselect="false" placeholder="" />                                                                   
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div> 
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control subscriber_clr" id="sub_agent_name" name="" value=""/>
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Edition & Promoter</label> 
                                <input readonly autocomplete="off" type="text" class="form-control subscriber_clr" id="sub_agent_loc" name="" value=""/> 
                            </div>

                            <!--Canvassed By-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select tabindex="4" class="form-control" id="canvassed_by_type" name="canvassed_by_type">
                                <?php $status = Enum::getAllConstants('CanvassedBy'); 
                                foreach($status as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true" id="canvassed_by_users">
                                    <input tabindex="5" autocomplete="off" value="" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#can_agent_details","indexes":"1,2"}]' />                                    
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                                <!--manual input for #canvassed_by_type value others-->
                                <input type="text" value="" class="form-control hide" id="canvassed_by_others" name="canvassed_by_others" />
                            </div>

                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 can-agent-details">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control canvassed_by_clr" id="can_agent_details" name="" value="" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed Date</label>
                                <div class="input-group">
                                    <input tabindex="6" required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="sales_can_date" name="sales_can_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <!--Serviced By-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serviced By</label>
                                <select tabindex="7" class="form-control" id="serviced_by_type" name="serviced_by_type">
                                    <?php $status = Enum::getAllConstants('ServicedBy');
                                    foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="8" autocomplete="off" value="" type="text" class="form-control" id="serviced_by" name="serviced_by" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#ser_agent_details","indexes":"1,2"}]' />                                    
                                    <div class="input-group-addon btn" id="serviced_by_search" data-search="serviced_by"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12 serv-agent-details">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control serviced_by_clr" id="ser_agent_details" name="" value="" />
                            </div>

                            <!--Wellwisher-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Wellwisher</label>
                                <select tabindex="9" class="form-control" id="wellwisher_type" name="wellwisher_type">
                                    <?php $status = Enum::getAllConstants('Wellwisher');
                                    foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input tabindex="10" autocomplete="off" value="<?php echo @$records->sales_wel_name; ?>" type="text" class="form-control" id="wellwisher" name="wellwisher" data-request='{"id":"9","search":""}' data-select="{}" data-multiselect="false" placeholder="" />                                                                  
                                    <div class="input-group-addon btn" id="wellwisher_search" data-search="wellwisher"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Contact Person</label>
                                <input autocomplete="off" value="" readonly type="text" class="form-control wellwisher_clr" id="contact_person" name="" />
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Location</label>
                                <input autocomplete="off" value="" readonly type="text" class="form-control wellwisher_clr" id="sales_location" name="" />
                            </div>


                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input tabindex="11" required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="sales_start_date" name="sales_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask data-greater="true" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <br />
                                <label><input tabindex="12" type="checkbox" name="sales_end_flag" id="sales_end_flag" value="1" /> Specify End Date</label>                                
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input tabindex="13" readonly type="text" value="<?php echo isset($_GET['g_fe']) && $records->sales_end_flag ? date('d-m-Y',strtotime($records->sales_end_date)) : ""; ?>" class="form-control" id="sales_end_date" name="sales_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input tabindex="14" value="" autocomplete="off" required type="text" class="form-control" id="sales_copies" name="sales_copies" />
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Type</label>
                                <select tabindex="15" class="form-control" name="sales_type">
                                    <?php $status = Enum::getAllConstants('EnrollType');
                                    foreach($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>                                
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Remarks</label>
                                <input tabindex="16" value="" autocomplete="off" required type="text" class="form-control" id="sales_remarks" name="sales_remarks" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="button" id="upsert-records"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/Enroll');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'ENROLL';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
