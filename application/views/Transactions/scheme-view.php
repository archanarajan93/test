<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme Details</title>
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
                <h1>Scheme Details</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Scheme Details</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/UpsertScheme'); ?>" name="scheme-create-form" id="scheme-create-form">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Serial No.</label>
                                <input autocomplete="off" readonly type="text" class="form-control input-bold-text" name="sch_view_code" id="sch_view_code" value="<?php echo $sch_details->sch_slno; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input readonly value="<?php echo $sch_details->sch_reg_no; ?>" maxlength="15" autocomplete="off" required type="text" class="form-control" id="sch_reg_no" name="sch_reg_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Type</label>
                                <input readonly value="<?php echo $sch_details->group_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme</label>
                                <input readonly value="<?php echo $sch_details->copytype_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <input readonly value="<?php echo $sch_details->sub_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="agent_det" id="agent_det" value="<?php echo $sch_details->agent_code." ".$sch_details->agent_name." ".$sch_details->agent_location; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Shakha</label>
                                <input readonly value="<?php echo $sch_details->shakha_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Event</label>
                                <input readonly value="<?php echo $sch_details->event_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                    <?php
                                      $status = Enum::getAllConstants('CanvassedBy');
                                      foreach($status as $key => $value) {
                                          if($sch_details->sch_can_flag != $key) { continue;}
                                    ?>
                                    <input readonly value="<?php echo $value; ?>" type="text" class="form-control" />
                                    <?php } ?>
                            </div>
                            <?php if($sch_details->sch_can_flag!='0'){
                                      $canvassed_rec=null;
                                      $canvassed_name="";
                                      if($sch_details->sch_can_flag== CanvassedBy::Agent){
                                        $canvassed_rec = rawurlencode(json_encode(array("Code"=>$sch_details->sch_can_code,"Name"=>$sch_details->sch_can_name)));
                                      }else{
                                        $canvassed_rec = rawurlencode(json_encode(array("Code"=>$sch_details->sch_can_code,"Name"=>$sch_details->sch_can_name,"Department"=>$sch_details->sch_can_dept)));
                                      }
                                ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 canvassed_by_users">
                                <label id="can_text"><?php if($sch_details->sch_can_flag== CanvassedBy::Agent){?>Agent<?php } else {?>Staff<?php }?></label>
                                <input readonly value="<?php echo ($sch_details->sch_can_flag== CanvassedBy::Agent)? $sch_details->sch_can_code : $sch_details->sch_can_name; ?>" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 canvassed_by_users">
                                <label id="can_det_text"><?php if($sch_details->sch_can_flag== CanvassedBy::Agent){?>Agent<?php } else {?>Staff<?php }?> Details</label>
                                <input type="text" class="form-control canvassed_by_clr" name="canvassed_name" id="canvassed_name" value="<?php if($sch_details->sch_can_flag== CanvassedBy::Agent){ echo $sch_details->canvassed_agent;} else { echo $sch_details->sch_can_dept; }?>" readonly />
                            </div>
                            <?php } else{?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="canvassed_by_others">
                                <label>Others</label>
                                <input readonly type="text" value="<?php echo $sch_details->sch_can_name; ?>" class="form-control" id="canvassed_others" name="canvassed_others" />
                            </div>
                            <?php }?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed Date</label>
                                <div class="input-group">
                                    <input readonly type="text" value="<?php echo date('d-m-Y', strtotime($sch_details->sch_can_date)); ?>" class="form-control" id="canvassed_date" name="canvassed_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" style="pointer-events:none;"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input readonly type="text" value="<?php echo date('d-m-Y', strtotime($sch_details->sch_from_date)); ?>" class="form-control" id="sch_start_date" name="sch_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" style="pointer-events:none;"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input readonly readonly type="text" value="<?php echo date('d-m-Y', strtotime($sch_details->sch_to_date)); ?>" class="form-control copy_type_clr" id="sch_end_date" name="sch_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" style="pointer-events:none;"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Amount</label>
                                <input readonly type="text" value="<?php echo $sch_details->sch_inc_amount; ?>" class="form-control text-right isNumberKey" isDecimal="true" id="inc_amt" name="inc_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Paid</label>
                                <input readonly type="text" value="<?php echo $sch_details->sch_inc_paid_amount; ?>" class="form-control text-right isNumberKey" isDecimal="true" id="inc_paid" name="inc_paid" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea readonly  class="form-control" id="remarks" name="remarks" rows="1" style="height:34px"><?php echo $sch_details->sch_remarks; ?></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

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
