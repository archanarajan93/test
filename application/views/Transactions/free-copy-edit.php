
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Free Copy</title>
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
                <h1>Free Copy</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Free Copy</li>                    
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertFreeCopy'); ?>" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <input type="hidden" name="fc_code" value="<?php echo $fc_code;?>" />
                            <!--<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Free SlNo.</label>
                                <input  type="text" name="free_slno" id="free_slno" class="form-control" value="<?php echo $fc_code;?>" readonly />
                            </div>-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Free Register No.</label>
                                <input type="text" required name="free_reg" id="free_reg" tabindex="1" class="form-control" value="<?php echo $free_rec->free_reg_no; ?>" autocomplete="off"/>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo $free_rec->sub_name; ?>" required data-required="subscriber_clr" tabindex="2" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}'
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#sub_det","indexes":"7,2,3"}]'/>
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$free_rec->free_sub_code,"Name"=>$free_rec->sub_name,"Address"=>$free_rec->sub_address,"AgentCode"=>$free_rec->free_agent_code,"AgentSlNo"=>$free_rec->free_agent_slno))); ?>">
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input type="text" class="form-control agent_clr" name="sub_det" id="sub_det" value="<?php echo $free_rec->free_agent_code." ".$free_rec->sub_name." ".$free_rec->sub_address; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type</label>
                                <input type="hidden" id="copy_code" value="CP0002" />
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo $free_rec->copytype_name; ?>" required type="text" class="form-control" data-required="copy_group_clr" tabindex="4" id="copy_group" name="copy_group" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]' />
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$free_rec->free_copy_type,"Name"=>$free_rec->copytype_name,"Copy Code"=>$free_rec->copy_code,"Copy Group"=>$free_rec->group_code))); ?>">
                                   <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input  autocomplete="off" type="text" value="<?php echo date('d-m-Y',strtotime($free_rec->free_start_date)); ?>" tabindex="5" required class="form-control" id="start_dte" name="start_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <input type="hidden" name="prev_start_date" value="<?php echo date('Y-m-d',strtotime($free_rec->free_start_date)); ?>"/>
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 "> 
                                <label>End Flag</label>
                                <select class="form-control end-flag" id="endflag" name="endflag" tabindex="6">
                                    <option <?php if($free_rec->free_end_flag == 0){echo "selected";}?> value="0">No</option>
                                    <option <?php if($free_rec->free_end_flag == 1){echo "selected";}?> value="1">Yes</option>
                                </select>
                            </div>
                            <?php //if($free_rec->free_end_flag == 1){?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 <?php if($free_rec->free_end_flag == 0){echo "hide";} ?>" id="last_date">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" value="<?php if($free_rec->free_end_flag == 1){ echo date('d-m-Y',strtotime($free_rec->free_end_date));}else{ echo "";} ?>" class="form-control "  tabindex="7" id="end_dte" name="end_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <input type="hidden" name="prev_end_date" value="<?php echo date('Y-m-d',strtotime($free_rec->free_end_date)); ?>" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <?php //} ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label> Commission Applicable</label>
                                <select class="form-control comm-app" id="comm_app"  tabindex="8" name="comm_app">
                                    <option <?php if($free_rec->free_comm == 0){echo "selected";}?> value="0">No</option>
                                    <option <?php if($free_rec->free_comm == 1){echo "selected";}?> value="1">Yes</option>
                                </select>

                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input type="text" value="<?php echo $free_rec->free_copies; ?>" class="form-control" id="free_copy" tabindex="9"  name="free_copy" autocomplete="off"/>
                            </div>
                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12">
                                <label>Remark</label>
                                <input type="text" value="<?php echo $free_rec->free_remarks; ?>" tabindex="10" class="form-control" id="remark" name="remark"  autocomplete="off"/>
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="11" type="submit" name="search" value=""><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;update</button>
                            </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                    <label>&nbsp;</label>
                                    <button onclick="window.location='<?php echo base_url('Transactions/FreeCopy');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                                    </div>
                   </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
        ?>
        <form method="post" class="hide" target="_blank" id="open-enroll-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'FREE-COPY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
