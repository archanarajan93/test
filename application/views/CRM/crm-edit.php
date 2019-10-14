<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="CRM-".date("F-j-Y").".xlsx";
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
    <title>Circulation | CRM Edit</title>
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
                <h1>CRM Edit</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">CRM</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body pad table-responsive">
                 <?php $crm = $crm_results["crm"];
                       $department=array(0=>"PMD",1=>"SMD",2=>"EDT");
                       $customer = array(0=>"Subscriber",1=>"Agent",2=>"General");
                 ?>
                <form method="post" onsubmit="return validateCRM();" action="<?php echo site_url("CRM/edit/".base64_encode($crm->token_no)); ?>">
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>Token No.</label>
                        <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="<?php echo $crm->token_no; ?>" readonly disabled id="token_no" name="token_no" />
                    </span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>User</label>
                        <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="<?php echo $crm->user_emp_name; ?>" readonly disabled id="user_name" name="user_name" />
                        <input type="hidden" class="form-control" value="<?php echo @$current_user; ?>" readonly disabled id="current_user" name="current_user" />
                    </span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>Date-Time</label>
                        <input type="text" class="form-control" style="background:#d5e8ec !important;font-size:14px;font-family:sans-serif !important;" value="<?php echo $crm->token_date; ?>" readonly disabled id="now" name="now" />
                    </span>
                    <span class="col-xs-12" style="margin-bottom:15px;"></span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                         <label>Unit<span class="text-red">[F2]</span></label>
                        <span class="input-group">
                            <input data-request='{"id":"1","search":"Unit"}' data-select="{}" type="text" id="unit"  name="unit" class="form-control" value="<?php echo $crm->unit_code; ?>" />
                            <span id="unit_search" data-search="unit" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="hidden" name="unit_rec_sel" class="unit_clr" id="unit_rec_sel" value="<?php echo rawurlencode(json_encode(array("UNIT"=>$crm->unit_code)));?>">
                        </span>
                    </span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>Product<span class="text-red">[F2]</span></label>
                        <span class="input-group">
                            <input data-request='{"id":"2","search":"Product"}' data-select="{}" type="text" class="form-control"  name="product" id="product" value="<?php echo $crm->crm_pdt_code; ?>" />
                            <span id="product_search" data-search="product" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="hidden" name="product_rec_sel" class="product_clr" id="product_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$crm->crm_pdt_code)));?>">
                        </span>
                        </span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>Department</label>
                        <select name="dept" class="form-control" id="dept">
                            <option <?php if($department[$crm->crm_dept_code] == 'PMD') echo 'selected';?> value="PMD">PMD</option>
                            <option <?php if($department[$crm->crm_dept_code] == 'SMD') echo 'selected';?> value="SMD">SMD</option>
                            <option <?php if($department[$crm->crm_dept_code] == 'EDT') echo 'selected';?> value="EDT">EDT</option>
                        </select>
                    </span>
                    <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <label>Customer</label>
                        <select name="customer" class="form-control" id="customer">
                            <option <?php if($customer[$crm->crm_cust_type] == 'Subscriber') echo 'selected';?> value="Subscriber">Subscriber</option>
                            <option <?php if($customer[$crm->crm_cust_type] == 'Agent') echo 'selected';?> value="Agent">Agent</option>
                            <option <?php if($customer[$crm->crm_cust_type] == 'General') echo 'selected';?> value="General">General</option>
                        </select>
                        <input type="hidden" id="cus_type" value="<?php echo $crm->crm_cust_type; ?>" />
                    </span>
                    <span class="col-xs-12">&nbsp;</span>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus <?php if($crm->crm_cust_type != '0') echo 'hidden';?>" id="subscriber_box">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>SUBSCRIBER</strong></div>
                         <div class="row">
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Subscriber Code<span class="text-red">[F2]&nbsp;[Min 3 chars]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"23","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp" name="subscriber" data-minchars="3" value="<?php echo $crm->crm_cust_id; ?>" placeholder="Press 'F2' here..." id="subscriber"
                                            data-criteria='[{"column":"sub_unit_code","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"}]' data-target='[{"selector":"#sub_name","indexes":"0"},{"selector":"#sub_addr","indexes":"1"},{"selector":"#sub_contact","indexes":"6"},
                                                       {"selector":"#sub_executive_code","indexes":"11"},{"selector":"#sub_executive","indexes":"5"},{"selector":"#cus_ag_code","indexes":"9"},{"selector":"#cus_ag_name","indexes":"2"},{"selector":"#cus_ag_phone","indexes":"7"}]' />
                                     <input type="hidden" name="subscriber_rec_sel" class="cus_inp subscriber_clr" id="subscriber_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$crm->crm_cust_id,"Name"=>$crm->crm_name,"Address"=>$crm->crm_address,"Contact No"=>$crm->crm_phone, "AgentCode"=> $crm->crm_ag_code, "Agent Name"=>  $crm->crm_ag_name, "Agent Phone"=> $crm->crm_ag_phone)));?>">
                                      <span id="subscriber_search" data-search="subscriber" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Name</label>
                                 <input type="text" class="form-control cus_inp subscriber_clr" value="<?php echo $crm->crm_name; ?>" disabled readonly name="sub_name" id="sub_name" />
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Address</label>
                                 <input type="text" class="form-control cus_inp subscriber_clr" value="<?php echo $crm->crm_address; ?>" disabled readonly name="sub_addr" id="sub_addr"/>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Contact No.</label>
                                 <input type="text" class="form-control cus_inp subscriber_clr" value="<?php echo $crm->crm_phone; ?>" name="sub_contact" id="sub_contact" />
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Scheme<span class="text-red">[F2]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"41","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp subscriber_clr" name="scheme" value="<?php echo $crm->crm_scheme_name; ?>" placeholder="Press 'F2' here..." id="scheme"
                                            data-criteria='[{"column":"unit_code","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"},
                                                          {"column":"scheme","input":"#subscriber_rec_sel","select":"Code", "msg":"Please select subscriber!"}]' data-target='[{"selector":"#scheme_code","indexes":"5"}]' />
                                     <input type="hidden" name="scheme_rec_sel" class="scheme_clr cus_inp subscriber_clr" id="scheme_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$crm->crm_scheme_code,"Name"=>$crm->crm_scheme_name,"sch_type"=>$crm->crm_scheme_type,"SchemeSlNo"=>$crm->crm_scheme_slno,"SchemeEndDate"=>$crm->sch_scheme_enddate)));?>">
                                     <span id="scheme_search" data-search="scheme" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Scheme Code</label>
                                 <input value="<?php echo $crm->crm_scheme_slno; ?>" type="text" class="form-control cus_inp subscriber_clr" readonly id="scheme_slno" name="scheme_slno" />
                             </span>
                             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Field Staff</label><br />
                                 <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding">
                                     <input readonly class="form-control subscriber_clr" type="text" name="sub_executive_code" id="sub_executive_code" value="<?php echo $crm->crm_fs_code; ?>" />
                                 </div>
                                 <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding">
                                     <input readonly class="form-control cus_inp subscriber_clr" type="text" id="sub_executive" name="sub_executive" value="<?php echo $crm->crm_fs_name; ?>" />
                                 </div>
                             </div>

                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Agency</label><br />
                                 <span class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding"><input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_code" name="cus_ag_code" value="<?php echo $crm->crm_ag_code; ?>" /></span>
                                 <span class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding"><input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_name" name="cus_ag_name" value="<?php echo $crm->crm_ag_name; ?>" /></span>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Agency Phone</label>
                                 <input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_phone" name="cus_ag_phone" value="<?php echo $crm->crm_ag_phone; ?>" />
                             </span>
                             <span class="col-xs-12">&nbsp;</span>
                         </div>
                     </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus <?php if($crm->crm_cust_type != '1') echo 'hidden';?>" id="agent_box">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>AGENT</strong></div>
                         <div class="row">
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Agent Code<span class="text-red">[F2]&nbsp;[Min 3 chars]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"17","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp" name="agent" data-minchars="3" value="<?php echo $crm->crm_cust_id; ?>" placeholder="Press 'F2' here..." id="agent"
                                            data-criteria='[{"column":"agent_unit","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"}]'
                                            data-target='[{"selector":"#agent_name","indexes":"1"},{"selector":"#agent_addr","indexes":"4"},{"selector":"#agent_contact","indexes":"3"},{"selector":"#agent_executive_code","indexes":"7"},{"selector":"#agent_executive","indexes":"5"}]' />
                                     <input type="hidden" name="agent_rec_sel" class="cus_inp agent_clr" id="agent_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$crm->crm_cust_id,"Name"=>$crm->crm_name,"Address"=>$crm->crm_address,"Contact No"=>$crm->crm_phone)));?>">
                                     <span id="agent_search" data-search="agent" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Name</label>
                                 <input type="text" class="form-control cus_inp agent_clr" value="<?php echo $crm->crm_name; ?>" disabled readonly id="agent_name" name="agent_name"/>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Address</label>
                                 <input type="text" class="form-control cus_inp agent_clr" value="<?php echo $crm->crm_address; ?>" disabled readonly id="agent_addr" name="agent_addr" />
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Contact No.</label>
                                 <input type="text" class="form-control cus_inp agent_clr" value="<?php echo $crm->crm_phone; ?>" id="agent_contact" name="agent_contact"/>
                             </span>                             
                             <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Field Staff</label><br />
                                 <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding">
                                     <input readonly type="text" class="form-control cus_inp agent_clr" id="agent_executive_code" name="agent_executive_code" value="<?php echo $crm->crm_fs_code; ?>" />
                                 </div>
                                 <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding">
                                     <input readonly type="text" class="form-control cus_inp agent_clr" id="agent_executive" name="agent_executive" value="<?php echo $crm->crm_fs_name; ?>" />
                                 </div>
                             </div>
                             <span class="col-xs-12">&nbsp;</span>
                         </div>
                     </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus <?php if($crm->crm_cust_type != '2') echo 'hidden';?>" id="general_box">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>GENERAL</strong></div>
                         <div class="row">
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Name</label>
                                 <input type="text" class="form-control cus_inp" value="<?php echo $crm->crm_name; ?>" id="gen_name" name="gen_name"  />
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Address</label>
                                 <input type="text" class="form-control cus_inp" value="<?php echo $crm->crm_address; ?>" id="gen_addr" name="gen_addr" />
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Contact No.</label>
                                 <input type="text" class="form-control cus_inp" value="<?php echo $crm->crm_phone; ?>" id="gen_contact" name="gen_contact"/>
                             </span>
                             <span class="col-xs-12">&nbsp;</span>
                         </div>
                     </div>
                    <span class="col-lg-5 col-md-4 col-sm-5 col-xs-12">
                        <?php if($is_admin == 1) { ?>
                        <button type="submit" class="btn btn-report" name="update_crm"><i class="fa fa-floppy-o" aria-hidden="true"></i> UPDATE</button>&nbsp;
                        <?php } else { ?>
                        <button type="button" class="btn btn-primary" disabled name=""><i class="fa fa-floppy-o" aria-hidden="true"></i> UPDATE</button>&nbsp;
                        <?php } ?>
                        <button type="button" onClick="window.location='<?php echo site_url("dashboard");?>'" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> CLOSE</button>
                    </span>
                    <span class="col-xs-12">&nbsp;</span>
                </form>                     
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="cus_gen">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>STATUS</strong></div>
                     <div class="row hidden" id="stats-box">
                         <form method="post" name="crm_status" id="crm_status" action="<?php echo base_url("CRM/updatestatus");?>">
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Entry Type</label>
                                 <select name="entry_type" class="form-control" id="entry_type">
                                     <?php if($is_admin == 1) { ?>
                                     <option value="Incoming">Incoming</option>
                                     <option value="Outgoing">Outgoing</option>
                                     <?php } ?>
                                     <option value="Action">Action</option>
                                 </select>
                             </span>                                 
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                 <label>Entry Status<span class="text-red">[F2]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"7","search":"Code"}' data-select="{}" type="text" class="form-control" name="status" placeholder="Press 'F2' here..." id="status" data-criteria='[{"column":"status_type","input":"#entry_type","select":"", "encode":"false", "msg":"Please select Entry Type"},{"column":"status_dept_code","input":"#dept","select":"", "encode":"false", "msg":"Please select Department"}]' />
                                     <input type="hidden" id="status_rec_sel" class="status_clr" />
                                     <span id="status_search" data-search="status" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span  id="response_head_wrapper" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                 <label>Response Header<span class="text-red">[F2]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"6","search":"Code"}' data-select="{}" type="text" class="form-control" name="response" placeholder="Press 'F2' here..." id="response" data-criteria='[{"column":"res_ag_flag","input":"#cus_type","select":"", "encode":"false", "msg":"Please select customer type!"},{"column":"res_dept_flag","input":"#dept","select":"", "encode":"false", "msg":"Please select customer type!"}]' />
                                     <input type="hidden" id="response_rec_sel" class="response_clr" />
                                     <span id="response_search" data-search="response" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
                                 <label>Remarks</label>
                                 <textarea id="remarks" name="remarks" class="textarea" style="width: 100%; height:74px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                 <input type="hidden" name="finalflag" id="finalflag" value="">
                                 <input type="hidden" name="levelCode" id="levelCode" value="">
                                 <input type="hidden" name="transcode" id="transcode" value="">                                     
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                                 <label class="col-xs-12 hidden-xs" style="margin-top:38px;">&nbsp;</label>
                                 <input type="hidden" name="status_record" id="status_record" />                                     
                                 <button type="button" class="btn btn-report" name="update_status" id="update_status"><i class="fa fa-plus-square" aria-hidden="true"></i> UPDATE</button>&nbsp;
                                 <button type="button" id="stats-cancel" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> CANCEL</button>
                             </span>
                         </form>
                     </div>
                 </div>
                <span class="col-xs-12">&nbsp;</span>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive table-wrap">
                             <?php
                             $responses = $crm_results["status"];
                             $res_len = count($responses)-1;
                             ?>
                             <table class="table-bordered hover tblExport" id="response_table" style="white-space:nowrap; width:100%;" border="1">
                                 <thead>
                                     <tr align="center">
                                         <td class="report-head"><b>Entry Type</b></td>
                                         <td class="report-head"><b>Response Header</b></td>
                                         <td class="report-head"><b>Remarks</b></td>
                                         <td class="report-head"><b>Entry Status</b></td>
                                         <td class="report-head"><b>User</b></td>
                                         <td class="report-head"><b>DateTime</b></td>
                                         <td class="report-head">&nbsp;</td>
                                     </tr>
                                 </thead>
                                 <tbody id="resTbody">
                                     <?php if(0 > $res_len){?>
                                     <tr id="no-record"><td colspan="6" align="center" class="text-info" style="padding: 25px !important;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp; No status added yet!</td></tr>
                                     <?php
                                           } else{
                                               $entry_type = array(
                                                   0 => "Incoming",
                                                   1 => "Outgoing",
                                                   2 => "Action");
                                               for($index=0;$index<=$res_len; $index++)
                                               {
                                     ?>
                                     <tr data-level="<?php echo $responses[$index]->trans_level;?>" data-final="<?php echo $responses[$index]->trans_final_flag; ?>" data-transcode="<?php echo $responses[$index]->trans_no; ?>">
                                         <td class="type"><?php echo $entry_type[$responses[$index]->trans_entry_type];?></td>
                                         <td  class="res-head" data-rescode="<?php echo $responses[$index]->trans_res_code;?>"><?php echo $responses[$index]->res_desc;?></td>
                                         <td style="white-space:normal!important;" class="remark"><?php echo $responses[$index]->trans_response;?></td>
                                         <td class="stats" data-stats="<?php echo $responses[$index]->trans_entry_status;?>"><?php echo $responses[$index]->status_name;?></td>
                                         <td><?php echo $responses[$index]->user_emp_name;?></td>
                                         <td><?php echo $responses[$index]->created_at;?></td>
                                         <td align="center">
                                         <?php if( (($responses[$index]->created_by == $user_id || $is_admin == 1) && $index == $res_len) || $user_id == 323) {  ?>                                             
                                            <a class="text-primary stats-edit" target="_blank" href="javascript:void(0)"><i class="fa fa-edit" aria-hidden="true">&nbsp;</i></a>
                                         <?php } ?>    
                                         </td>
                                     </tr>
                                     <?php
                                               }
                                           }
                                     ?>
                                 </tbody>
                             </table>
                         </div>
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
        var page = 'CRM-CREATE';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/crm.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/Help.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
