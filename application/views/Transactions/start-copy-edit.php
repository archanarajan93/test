<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Start Copy</title>
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
                <h1>Start Copy</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Start Copy</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <!--<form method="post" action="<?php echo base_url('Transactions/UpsertEnroll'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">-->
                            
                            <input type="hidden" name="is_update" value="<?php echo isset($_GET['g_fe']) ? 1 : 0; ?>" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" name="sales_code" id="sales_code" value="<?php echo @$code; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input readonly value="<?php echo @$records->sales_reg_no; ?>" maxlength="15" autocomplete="off" required type="text" class="form-control" id="sales_reg_no" name="sales_reg_no" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Sale Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly required autocomplete="off" value="<?php echo @$records->copytype_name; ?>" type="text" class="form-control" id=""/>                                    
                                    <div class="input-group-addon btn" id="" data-search=""><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="copy_code" value="CP0001" />

                            <!--Subscriber-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly autocomplete="off" value="<?php echo @$records->sub_name; ?>" type="text" class="form-control" />                                                                       
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div> 
                                </div>
                            </div>
                        
                            <input type="hidden" id="sales_copy_type" value="<?php echo @$records->sales_copy_type; ?>" />
                            <input type="hidden" id="sales_copy_group" value="<?php echo @$records->sales_copy_group; ?>" />
                            <input type="hidden" id="sales_copy_code" value="<?php echo @$records->sales_copy_code; ?>" />
                            <input type="hidden" id="sales_sub_code" value="<?php echo @$records->sales_sub_code; ?>" />
                            <input type="hidden" id="sales_agent_code" value="<?php echo @$records->sales_agent_code; ?>" />
                            <input type="hidden" id="sales_agent_slno" value="<?php echo @$records->sales_agent_slno; ?>" />                            
                        
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" required type="text" class="form-control subscriber_clr" id="sub_agent_name" name="" value="<?php echo @$records->sales_agent_code.', '.@$records->agent_name.', '.$records->agent_location; ?>"/>
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Edition & Promoter</label> 
                                <input readonly autocomplete="off" required type="text" class="form-control subscriber_clr" id="sub_agent_loc" name="" value="<?php echo @$records->edition_name.', '.@$records->promoter_name; ?>"/> 
                            </div>

                            <!--Canvassed By-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select class="form-control disable-input" id="canvassed_by_type" name="canvassed_by_type">
                                <?php $status = Enum::getAllConstants('CanvassedBy'); 
                                foreach($status as $key => $value) { ?>
                                <option <?php echo (isset($_GET['g_fe']) && @$records->sales_can_by == $key) ? "selected" : ""; ?>  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <?php
                            $route = 17; //agent f2 default
                            if(isset($_GET['g_fe']) && $records->sales_can_by) {
                                $route = $records->sales_can_by;
                            }
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module <?php if(isset($_GET['g_fe']) && $records->sales_can_by == 0) { echo "hide"; } ?>" data-selected="true" id="canvassed_by_users">
                                    <input readonly autocomplete="off" value="<?php echo $route == 17 ? @$records->sales_can_code :  @$records->sales_can_name; ?>" type="text" class="form-control"  />                                    
                                    <div class="input-group-addon btn" id="" data-search=""><i class="fa fa-search"></i></div>
                                </div>
                                <!--manual input for #canvassed_by_type value others-->
                                <input readonly type="text" value="<?php echo @$records->sales_can_name; ?>" class="form-control <?php if(isset($_GET['g_fe']) && $records->sales_can_by == 0) { echo ""; } else { echo "hide"; } ?>" id="canvassed_by_others" name="canvassed_by_others" />
                            </div>

                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 can-agent-details <?php echo ($records->sales_can_by && $route == 17) ? "" : "hide"; ?>">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control canvassed_by_clr" id="can_agent_details" name="" value="<?php echo @$records->sales_can_name; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed Date</label>
                                <div class="input-group">
                                    <input readonly required type="text" value="<?php echo isset($_GET['g_fe']) ? date('d-m-Y',strtotime($records->sales_can_date)) : date('d-m-Y'); ?>" class="form-control" id="sales_can_date" name="sales_can_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <!--Serviced By-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serviced By</label>
                                <select class="form-control disable-input" id="serviced_by_type" name="serviced_by_type">
                                    <?php $status = Enum::getAllConstants('ServicedBy');
                                    foreach($status as $key => $value) { ?>
                                    <option <?php echo @$records->sales_service_by == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php
                            $route = 17; //agent f2 default
                            if(isset($_GET['g_fe']) && $records->sales_service_by) { $route = $records->sales_service_by; }
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly autocomplete="off" value="<?php echo $route == 17 ? @$records->sales_service_code : @$records->sales_service_name; ?>" type="text" class="form-control" />                                    
                                    <div class="input-group-addon btn" id="serviced_by_search" data-search="serviced_by"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12 serv-agent-details <?php echo $route == 17 ? "" : "hide"; ?>">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control serviced_by_clr" id="ser_agent_details" name="" value="<?php echo @$records->sales_service_name; ?>" />
                            </div>

                            <!--Wellwisher-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Wellwisher</label>
                                <select class="form-control disable-input" id="wellwisher_type" name="wellwisher_type">
                                    <?php $status = Enum::getAllConstants('Wellwisher');
                                    foreach($status as $key => $value) { ?>
                                    <option <?php echo @$records->sales_wel_by == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php
                            $route = 9; //agent f2 default
                            if(isset($_GET['g_fe']) && $records->sales_wel_by) { $route = $records->sales_wel_by; }
                            ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input readonly autocomplete="off" value="<?php echo @$records->sales_wel_name; ?>" type="text" class="form-control"  />                                                                      
                                    <div class="input-group-addon btn" id="" data-search=""><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Contact Person</label>
                                <input autocomplete="off" value="<?php echo @$records->sales_wel_contact; ?>" readonly type="text" class="form-control wellwisher_clr" id="contact_person" name="" />
                            </div>

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Location</label>
                                <input autocomplete="off" value="<?php echo @$records->sales_wel_loc; ?>" readonly type="text" class="form-control wellwisher_clr" id="sales_location" name="" />
                            </div>


                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input readonly required type="text" value="<?php echo isset($_GET['g_fe']) ? date('d-m-Y',strtotime($records->sales_start_date)) : date('d-m-Y'); ?>" class="form-control" id="sales_start_date" name="sales_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <br />
                                <label class="disable-input"><input <?php echo @$records->sales_end_flag ? "checked" : ""; ?> type="checkbox" name="sales_end_flag" id="sales_end_flag" value="1" /> Specify End Date</label>                                
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input readonly <?php echo @$records->sales_end_flag == 0 ? "readonly" : ""; ?> type="text" value="<?php echo isset($_GET['g_fe']) && $records->sales_end_flag ? date('d-m-Y',strtotime($records->sales_end_date)) : ""; ?>" class="form-control" id="sales_end_date" name="sales_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input readonly value="<?php echo @$records->sales_copies; ?>" autocomplete="off" required type="text" class="form-control" id="sales_copies" name="sales_copies" />
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Type</label>
                                <select class="form-control disable-input" name="sales_type">
                                    <?php $status = Enum::getAllConstants('EnrollType');
                                    foreach($status as $key => $value) { ?>
                                    <option <?php echo @$records->sales_type == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>                                
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Remarks</label>
                                <input readonly value="<?php echo @$records->sales_remarks; ?>" autocomplete="off" required type="text" class="form-control" id="sales_remarks" name="sales_remarks" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button <?php echo @$records->sales_status == EnrollStatus::Started ? "disabled" : ""; ?> class="btn btn-block btn-primary" id="start-copy" type="button"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Start Copy</button>                                
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.close();" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>

                        <!--</form>-->
                        
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
        var page = 'START-COPY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
