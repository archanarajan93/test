<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Other-Receipt-Summary-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    foreach(range('A','Z') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
    header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$FileName.'"');
    $writer->save("php://output");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Other Receipts </title>
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
                <h1>Other Receipts </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Other Receipts </li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="oim-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/OtherReceiptSummary?g_fe=xEdtsg'); ?>" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Copy</label>
                                <select id="copy" name="copy" class="hidden" multiple>
                                    <?php foreach($copy_lists as $copy){?>
                                    <option <?php if($copy->copy_name == 'SCHEME' || $copy->copy_name == 'SPONSOR') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                    
                                    <?php }?>
                                </select>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" required value="" type="text" class="form-control copy_master" id="copymaster" name="copymaster" data-request='{"id":"42","search":""}' data-select="{}" 
                                      data-criteria='[{"column":"copy_code","input":"#copy","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' data-multiselect="true" placeholder=""  />
                                    <div class="input-group-addon btn" id="copymaster_search" data-search="copymaster"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Copy Group</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" id="copy_group" data-criteria='[{"column":"group_copy_code","input":".multi_sel_copymaster","select":"","encode":"true","multiselect":"true","msg":"Please Select Copy!","required":"true"}]' name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="copy_group_search" data-search="copy_group"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Copy Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-criteria='[{"column":"group_code","input":".multi_sel_copy_group","select":"","encode":"true","multiselect":"true","msg":"Please Select Copy Group!","required":"true"}]' data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date From</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo date('d-m-Y'); ?>" tabindex="2" data-compare="#to_date" class="form-control" id="from_date" name="from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date To</label>
                                <div class="input-group">
                                    <input required type="text" tabindex="3" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="to_date" name="to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select class="form-control" id="canvassed_by_type" required tabindex="7" name="canvassed_by_type">
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
                                    <input autocomplete="off" value="" required type="text" tabindex="8" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-selectIndex="0" data-target='[{"selector":"#canvassed_name","indexes":"1,2"}]'
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
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                                <label>Report Type</label>
                                <select id="report_type" name="report_type" required class="form-control" tabindex="1">
                                    <option value="0"> Detailed</option>
                                    <option value="1"> Summary</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Units</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="multi_sel_unit" autocomplete="off" value="<?php echo $this->user->user_unit_code;?>" tabindex="4" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                                    <span class="multiselect-text">
                                        <span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span>
                                        <input type="hidden" class="multi-search-selected multi_sel_unit" name="multi_sel_unit" value="<?php echo rawurlencode(json_encode(array(array("Code"=>$this->user->user_unit_code,"Name"=>$this->user->user_unit_name))));?>">
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                                <label>Pay Mode</label>
                                <select id="select_date" name="select_date" class="form-control" tabindex="1">
                                    <option value="">Select</option>
                                    <?php $pay_type = Enum::getAllConstants('PayType');
                                        foreach($pay_type as $key => $value){?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" tabindex="6" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                           
                       </form>
                       <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>
                <?php } elseif(isset($_GET['g_fe'])) { 
                          if($_POST['report_type']=='0'){
                ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table width="100%" class="table table-results">
                            <thead>
                                <tr>
                                    <td colspan="18" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
                                        <strong>Other Receipts Report</strong> FROM <?php echo $_POST['from_date']; ?> to <?php echo $_POST['to_date'];?>&nbsp;<?php
                              $multi_scheme=isset($_POST['multi_sel_scheme'])?$_POST['multi_sel_scheme']:'';
                              if($multi_scheme) {
                                  $scheme_record = json_decode(rawurldecode($multi_scheme),true);  echo "| Scheme: "; foreach($scheme_record as $sch){
                                      echo " ".$sch["Name"];
                                  }
                              }
                                                                                                                                                                   ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Receipt No</strong></td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Date</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Party Name</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Scheme Name </strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Pay Type</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Bank</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Chq/DD No</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Chq.Date</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Narration</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Promoter</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Department</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Scheme No.</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Scheme Status</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Canvassed By</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Entry Date</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Canvassed Date</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>RefNo</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              $today = date('d-m-Y');
                              //$sch_amount = $sch_cash = $sch_cheque = $sch_pdc = $sch_balance = $total_balance = 0;
                              $grand_total = 0;
                              $payment = $copy_type = array();
                              if(count($scheme_rec)) {
                                  //$i=1;
                                  foreach($scheme_rec as $sh) {
                                      $grand_total += $sh->srec_amount;
                                      if(!isset($payment[$sh->srec_pay_type])){$payment[$sh->srec_pay_type] = 0;}
                                      if(!isset($copy_type[$sh->copytype_name]["no"])){$copy_type[$sh->copytype_name]["no"] = 0;}
                                      if(!isset($copy_type[$sh->copytype_name]["amt"])){$copy_type[$sh->copytype_name]["amt"] = 0;}
                                      $payment[$sh->srec_pay_type] += $sh->srec_amount;
                                      $copy_type[$sh->copytype_name]["no"] += 1;
                                      $copy_type[$sh->copytype_name]["amt"] += $sh->srec_amount;
                                      //$sch_cash += $sh->cash;
                                      //$sch_cheque += $sh->cheque;
                                      //$sch_pdc += $sh->pdc;
                                      //$sch_balance = $sh->sch_amount-$sh->cash-$sh->cheque-$sh->pdc;
                                      //$total_balance += $sch_balance;
                                ?>

                                <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">

                                    <td class="sh-number"><?php echo $sh->srec_no; ?></td>
                                    <td class="sh-name"><?php echo $sh->srec_date; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->srec_sub_name; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->copytype_name; ?></td>
                                    <td align="right" class="sh-add1">
                                        <?php if($sh->srec_pay_type == PayType::Card){ echo "Card"; }
                                              else if($sh->srec_pay_type == PayType::Cash){ echo "Cash";}
                                              else if($sh->srec_pay_type == PayType::Cheque){ echo "Cheque";}
                                              else if($sh->srec_pay_type == PayType::DD){ echo "DD";}
                                        ?>
                                    </td>
                                    <td align="right" class="sh-add1"><?php echo moneyFormat($sh->srec_amount); ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->bank_name; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->srec_chq_no; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->srec_chq_date; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->srec_remarks; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->promoter_area.",".$sh->promoter_name." PH:".$sh->promoter_phone; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->sch_can_dept; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->srec_scheme_code; ?></td>
                                    <td align="right" class="sh-add1">
                                    <?php if(strtotime($sh->sch_from_date) <= strtotime($today) && strtotime($sh->sch_to_date)>= strtotime($today)){
                                              echo 'Live';
                                          }else if(strtotime($today)>=strtotime($sh->sch_to_date) && $sh->sch_renew_code){
                                              echo 'Renewed';
                                          }else if(strtotime($today)>=strtotime($sh->sch_to_date)){
                                              echo 'Expired';
                                          }else{
                                              echo 'Live';
                                          } ?>
                                    </td>
                                    <td align="right" class="sh-add1"><?php echo $sh->sch_can_name; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->created_date; ?></td>
                                    <td align="right" class="sh-add1"><?php echo $sh->sch_can_date; ?></td>
                                    <td align="right" class="sh-add1"><?php //echo moneyFormat($sch_balance); ?></td>

                                </tr>
                                <?php
                                  }
                              }
                              else {
                                  echo "<tr><td colspan='18 ' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                              }
                              if(count($scheme_rec)) {
                                ?>
                                <tr>
                                    <td bgcolor="#CCCCCC"><strong>Grand Total</strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo count($sh->sch_count);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong></strong><?php //echo moneyFormat($sch_amount);?></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong></strong><?php //echo moneyFormat($sch_cash);?></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong></strong><?php echo moneyFormat($grand_total);?></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($sch_pdc);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php //echo moneyFormat($total_balance);?></strong></td>
                                </tr>
                                <?php }?>
                                
                        </table>
                    </div>
                    <div class="box-body">
                        <table style="margin-top:10px; width:40%" class="table table-results">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Pay Type</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              $pay_type = Enum::getAllConstants('PayType');
                              foreach($pay_type as $key => $value){
                                ?>
                                <tr>
                                    <td style="font-weight:bold;"><?php echo $value; ?></td>
                                    <td style="text-align:right;"><?php echo moneyFormat(isset($payment[$key])?$payment[$key]:0); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table style="margin-top:10px; width:40%" class="table table-results">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Scheme Type</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Nos</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              $sch_no_total = $sch_amt_total=0;
                              foreach($copy_type as $key => $ctype){
                                  $sch_no_total += isset($ctype["no"])?$ctype["no"]:0;
                                  $sch_amt_total += isset($ctype["amt"])?$ctype["amt"]:0;
                                ?>
                                <tr>
                                    <td style="font-weight:bold;"><?php echo $key; ?></td>
                                    <td style="text-align:right;"><?php echo moneyFormat(isset($ctype["no"])?$ctype["no"]:0); ?></td>
                                    <td style="text-align:right;"><?php echo moneyFormat(isset($ctype["amt"])?$ctype["amt"]:0); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="font-weight:bold;"></td>
                                    <td style="text-align:right;"><?php echo moneyFormat(isset($sch_no_total)?$sch_no_total:0); ?></td>
                                    <td style="text-align:right;"><?php echo moneyFormat(isset($sch_amt_total)?$sch_amt_total:0); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
                <?php 
                          }elseif($_POST['report_type']=='1'){
                              if($scheme_rec){
                                  $sch_summ = $cgrp_total=$pay_type_total = array();
                                  foreach($scheme_rec as $sch){
                                      $sch_summ[$sch->group_name][$sch->srec_pay_type] = $sch->amount;
                                      if(!isset($cgrp_total[$sch->group_name])) $cgrp_total[$sch->group_name]=0;
                                      if(!isset($pay_type_total[$sch->srec_pay_type])) $pay_type_total[$sch->srec_pay_type]=0;
                                      $pay_type_total[$sch->srec_pay_type] += $sch->amount;
                                      $cgrp_total[$sch->group_name] += $sch->amount;

                                  }

                ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table width="100%" class="table table-results">
                            <thead>
                                <tr>
                                    <td colspan="8" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
                                        <strong>Other Receipts Summary</strong> FROM <?php echo $_POST['from_date']; ?> to <?php echo $_POST['to_date'];?>&nbsp;<?php
                                  $multi_scheme=isset($_POST['multi_sel_scheme'])?$_POST['multi_sel_scheme']:'';
                                  if($multi_scheme) {
                                      $scheme_record = json_decode(rawurldecode($multi_scheme),true);  echo "| Scheme: "; foreach($scheme_record as $sch){
                                          echo " ".$sch["Name"];
                                      }
                                  }
                                                                                                                                                                   ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Scheme Type</strong></td>
                                    <?php $pay_type = Enum::getAllConstants('PayType');
                                          foreach($pay_type as $key => $value){?>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong><?php echo $value; ?></strong></td>
                                    <?php } ?>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Total </strong></td>
                                </tr>
                                <tr>

                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                  $copy_group = json_decode(rawurldecode($_POST["multi_sel_copy_group"]),true);
                                  if(count($copy_group)) {
                                      foreach($copy_group as $cpygrp) {
                                ?>

                                <tr>
                                    <td><?php echo $cpygrp["Name"]; ?></td>
                                    <?php foreach($pay_type as $key => $value){?>
                                    <td align="right"><strong><?php echo isset($sch_summ[$cpygrp["Name"]][$key])?$sch_summ[$cpygrp["Name"]][$key]:0; ?></strong></td>
                                    <?php } ?>
                                    <td align="right"><?php echo moneyFormat(isset($cgrp_total[$cpygrp["Name"]])?$cgrp_total[$cpygrp["Name"]]:0); ?></td>
                                </tr>
                                <?php
                                      }
                                  }
                                  else {
                                      echo "<tr><td colspan='8' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                  }
                                  //if(count($scheme_rec)) {
                                ?>
                                <tr>
                                    <td bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
                                    <?php $sum_total = 0;?>
                                    <?php foreach($pay_type as $key => $value){
                                              $sum_total += isset($pay_type_total[$key])?$pay_type_total[$key]:0;
                                        ?>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php echo isset($pay_type_total[$key])?$pay_type_total[$key]:0; ?></strong></td>
                                    <?php } ?>
                                    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $sum_total; ?></strong></td>
                                </tr>
                                <?php //}?> 
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
                <?php
                              }
                          }
                 }
                ?>
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
        var page = 'OTHER-RECEIPT-SUMMARY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>