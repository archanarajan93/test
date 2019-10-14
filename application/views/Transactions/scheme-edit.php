<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme <?php if($is_renewal=='1'){?>Renew<?php } else{?>Edit<?php }?></title>
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
                <h1>Scheme Edit</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Scheme <?php if($is_renewal=='1'){?>Renew<?php } else{?>Edit<?php }?></li>                    
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
                                <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                                <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                                <input type="hidden" name="sch_code" value="<?php echo $sch_code;?>"/>
                                <input type="hidden" name="is_renewal" value="<?php echo $is_renewal;?>" />
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <div  style="float:left; width:100%; height:34px; padding:6px; font-weight:bold; background: #fbfbfb !important;border: 1px solid #ccc !important;text-align: center;font-size: 16px !important;">
                                    <?php if($sch_details->sch_renew_code){?>
                                    <b class="blink" style="color:#18b77d">Renewed</b>
                                    <?php } else if(strtotime($sch_details->sch_to_date)<strtotime(date("Y-m-d"))){?>
                                    <b class="blink" style="color:#e50f0f">Expired</b>
                                    <?php }else {?>
                                    <b class="blink" style="color:#18b77d">Active</b>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Reg.No</label>
                                <input value="<?php echo $sch_details->sch_reg_no; ?>" tabindex="1" maxlength="15" autocomplete="off" required type="text" class="form-control" id="sch_reg_no" name="sch_reg_no" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Type</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_group_clr" tabindex="2" autocomplete="off" value="<?php echo $sch_details->group_name; ?>" type="text" class="form-control" id="copy_group" name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]' />
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_details->group_name,"Type"=>'SCHEME',"Code"=>$sch_details->group_code)));?>">
                                    <div class="input-group-addon btn" id="copy_group_search" data-search="copy_group"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="copy_type_clr" tabindex="3" autocomplete="off" value="<?php  if($is_renewal!='1') echo $sch_details->copytype_name; ?>" type="text" class="form-control copy_group_clr" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_code","input":"#copy_group_rec_sel","select":"Code","encode":"true","multiselect":"false","required":"false"},{"column":"RC.rate_pdt_code","input":"#pdt_code","select":"","encode":"false","multiselect":"false","required":"false"}]'  data-callback="showEndDate"/>
                                    <?php if($is_renewal!='1'){?>
                                    <input type="hidden" name="copy_type_rec_sel" class="copy_type_clr copy_group_clr" id="copy_type_rec_sel" 
                                           value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_details->copytype_name,"Code"=>$sch_details->copytype_code,"Copy Group"=>$sch_details->group_code,
                                                      "Years"=>$sch_details->rate_sch_years,"Months"=>$sch_details->rate_sch_months,"Days"=>$sch_details->rate_sch_days,"Amount"=>$sch_details->rate_amount)));?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input <?php  if($is_renewal=='1') echo 'readonly'; else echo 'required'; ?>  tabindex="4"  data-required="subscriber_clr" autocomplete="off" value="<?php echo $sch_details->sub_name; ?>" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}' data-select="{}"  
                                     data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]'  data-target='[{"selector":"#agent_det","indexes":"7,2,3"}]'  data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_details->sub_name,"Address"=>$sch_details->sub_address,"Agent Name"=>$sch_details->agent_name,
                                                      "Agent Location"=>$sch_details->agent_location,"Code"=>$sch_details->sub_code,"AgentCode"=>$sch_details->agent_code,"AgentSlNo"=>$sch_details->agent_slno)));?>">
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber" <?php  if($is_renewal=='1') {?> style="pointer-events:none;background:#f1f0f0;" <?php }?>><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <input type="text" class="form-control text-brown agent_clr subscriber_clr" style="display:inline-block" name="agent_det" id="agent_det" value="<?php echo $sch_details->agent_code." ".$sch_details->agent_name." ".$sch_details->agent_location; ?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Shakha</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo $sch_details->shakha_name; ?>"  tabindex="5" type="text" class="form-control" id="shakha" name="shakha" data-request='{"id":"9","search":""}' 
                                           data-criteria='[{"column":"shakha_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="shakha_rec_sel" class="shakha_clr" id="shakha_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_details->shakha_name,"Contact Person"=>"","Phone"=>"",
                                                      "Location"=>"","Code"=>$sch_details->shakha_code)));?>">
                                    <div class="input-group-addon btn" id="shakha_search" data-search="shakha"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Event</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo $sch_details->event_name; ?>"  tabindex="6" type="text" class="form-control" id="event" name="event" data-request='{"id":"28","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="event_rec_sel" class="event_clr" id="event_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sch_details->event_name,"Start Date"=>"","End Date"=>"","Code"=>$sch_details->event_code)));?>">
                                    <div class="input-group-addon btn" id="event_search" data-search="event"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select class="form-control"  tabindex="7" id="canvassed_by_type" name="canvassed_by_type">
                                    <?php
                                      $status = Enum::getAllConstants('CanvassedBy');
                                      foreach($status as $key => $value) {
                                          if($value=='Promoter' || $value=='ACM') { continue;}
                                    ?>
                                    <option <?php if($sch_details->sch_can_flag == $key) echo 'selected';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
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
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="8" value="<?php echo ($sch_details->sch_can_flag== CanvassedBy::Agent)? $sch_details->sch_can_code : $sch_details->sch_can_name; ?>" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"<?php echo ($sch_details->sch_can_flag == CanvassedBy::Agent) ? CanvassedBy::Agent : CanvassedBy::Staff; ?>","search":""}' data-selectIndex="0"
                                          <?php if($sch_details->sch_can_flag== CanvassedBy::Agent){?> data-criteria='[{"column":"agent_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' <?php }?> data-target='[{"selector":"#canvassed_name","indexes":"<?php echo ($sch_details->sch_can_flag == CanvassedBy::Agent) ? "1,2" : "3"; ?>"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="canvassed_by_rec_sel" class="canvassed_by_clr" id="canvassed_by_rec_sel" value="<?php echo $canvassed_rec;?>">
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 canvassed_by_users">
                                <label id="can_det_text"><?php if($sch_details->sch_can_flag== CanvassedBy::Agent){?>Agent<?php } else {?>Staff<?php }?> Details</label>
                                <input type="text" class="form-control canvassed_by_clr" name="canvassed_name" id="canvassed_name" value="<?php if($sch_details->sch_can_flag== CanvassedBy::Agent){ echo $sch_details->canvassed_agent;} else { echo $sch_details->sch_can_dept; }?>" readonly />
                            </div>
                            <?php } else{?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="canvassed_by_others">
                                <label>Others</label>
                                <input autocomplete="off" type="text"  tabindex="9" value="<?php echo $sch_details->sch_can_name; ?>" class="form-control" id="canvassed_others" name="canvassed_others" />
                            </div>
                            <?php }?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed Date</label>
                                <div class="input-group">
                                    <input required type="text"  tabindex="10" value="<?php echo date('d-m-Y', strtotime($sch_details->sch_can_date)); ?>" class="form-control" id="canvassed_date" name="canvassed_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <?php 
                                          $today = date('d-m-Y');
                                          $end_strtime = strtotime($sch_details->sch_to_date);
                                          $start_date = date('d-m-Y', strtotime($sch_details->sch_from_date));
                                          $end_date = date('d-m-Y', $end_strtime);
                                          if($is_renewal=='1'){
                                              if(strtotime($today)>$end_strtime){
                                                $start_date = $today;
                                              }else{
                                                  $start_date = date('d-m-Y', strtotime($sch_details->sch_to_date . " +1 day"));
                                              }
                                              $end_date="";    
                                          }
                                          ?>
                                    <input type="hidden" name="sch_prev_from_dte" id="sch_prev_from_dte" value="<?php echo $sch_details->sch_from_date; ?>" />
                                    <input type="hidden" name="sch_prev_to_dte" id="sch_prev_to_dte" value="<?php echo $sch_details->sch_to_date; ?>" />
                                    <input  tabindex="11"  <?php if($is_renewal!='1' && in_array('M.1',$this->permissions)){?> required <?php } else {?> readonly <?php }?> type="text" value="<?php echo $start_date; ?>" class="form-control" id="sch_start_date" name="sch_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" <?php if($is_renewal!='1' && !in_array('M.1',$this->permissions)){?> style="pointer-events:none;"<?php }?>><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input <?php if($is_renewal!='1' && in_array('M.2',$this->permissions)){?> required <?php } else{?> readonly <?php }?> type="text" value="<?php echo $end_date; ?>"  tabindex="12" class="form-control copy_type_clr" id="sch_end_date" name="sch_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn" <?php if($is_renewal!='1' && !in_array('M.2',$this->permissions)){?> style="pointer-events:none;" <?php }?>><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Amount</label>
                                <input autocomplete="off"  tabindex="13" type="text" value="<?php if($is_renewal!='1') echo $sch_details->sch_inc_amount; else echo '0.00'; ?>" class="form-control text-right isNumberKey" isDecimal="true" id="inc_amt" name="inc_amt" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Incentive Paid</label>
                                <input autocomplete="off"  tabindex="14" type="text" value="<?php if($is_renewal!='1')  echo $sch_details->sch_inc_paid_amount;  else echo '0.00' ?>" class="form-control text-right isNumberKey" isDecimal="true" id="inc_paid" name="inc_paid" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" >
                                <label>Remarks</label>
                                <textarea  class="form-control"  tabindex="15" id="remarks" name="remarks" rows="1" style="height:34px"><?php if($is_renewal!='1') echo $sch_details->sch_remarks; ?></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="16" type="button" id="scheme-save"><i class="fa fa-share-square-o" aria-hidden="true"></i>&nbsp;Update</button>
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
