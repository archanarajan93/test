<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="CRM-View-".date("F-j-Y").".xlsx";
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
    <title>Circulation | CRM View</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php $this->load->view('inc/styles.php');
          $this->load->view('inc/alerts.php');?>
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
                <h1>CRM View</h1>
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
                         <input type="text" id="unit_code" class="form-control" disabled value="<?php echo $crm->unit_code; ?>" readonly/>
                     </span>
                     <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                         <label>Product</label>
                         <input type="text" class="form-control" disabled value="<?php echo $crm->crm_pdt_code; ?>" readonly />
                     </span>
                     <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                         <label>Department</label>
                         <input type="text" class="form-control" id="dept" value="<?php echo $department[$crm->crm_dept_code]; ?>" disabled readonly />
                     </span>
                     <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                         <label>Customer</label>
                         <input type="text" class="form-control" value="<?php echo $customer[$crm->crm_cust_type]; ?>" disabled readonly />
                         <input type="hidden" id="cus_type" value="<?php echo $crm->crm_cust_type; ?>"/>
                     </span>
                     <span class="col-xs-12">&nbsp;</span>
                     <?php
                     if($crm->crm_cust_type == '0')
                     {
                     ?>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus" id="subscriber_box">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>SUBSCRIBER</strong></div>
                     <div class="row">
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Subscriber Code</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_cust_id; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Name</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_name; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Address</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_address; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Contact No.</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_phone; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Scheme</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_scheme_name; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Scheme Code</label>
                             <input value="<?php echo $crm->crm_scheme_slno; ?>" type="text" class="form-control cus_inp subscriber_clr" id="" name="" disabled readonly />
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
                             <span class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding"><input type="text" class="form-control" disabled readonly id="cus_ag_code" name="cus_ag_code" value="<?php echo $crm->crm_ag_code; ?>" /></span>
                             <span class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding"><input type="text" class="form-control" disabled readonly id="cus_ag_name" name="cus_ag_name" value="<?php echo $crm->crm_ag_name; ?>" /></span>
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Agency Phone</label>
                             <input type="text" class="form-control" disabled readonly id="cus_ag_phone" name="cus_ag_phone" value="<?php echo $crm->crm_ag_phone; ?>" />
                         </span>
                         <span class="col-xs-12">&nbsp;</span>
                         <span class="col-xs-12">&nbsp;</span>
                     </div>
                 </div>
                     <?php } else if($crm->crm_cust_type == '1'){?>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus" id="agent_box">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>AGENT</strong></div>
                     <div class="row">
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Agent Code</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_cust_id; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Name</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_name; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Address</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_address; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Contact No.</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_phone; ?>" disabled readonly />
                         </span>
                         <span class="col-xs-12">&nbsp;</span>
                     </div>
                 </div>
                     <?php } else {?>
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus" id="general_box">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>GENERAL</strong></div>
                     <div class="row">
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Name</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_name; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Address</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_address; ?>" disabled readonly />
                         </span>
                         <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <label>Contact No.</label>
                             <input type="text" class="form-control" value="<?php echo $crm->crm_phone; ?>" disabled readonly />
                         </span>
                         <span class="col-xs-12">&nbsp;</span>
                     </div>
                 </div>
                     <?php }?>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="cus_gen">
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>STATUS</strong></div>
                         <div class="row">
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
                                     <input data-request='{"id":"30","search":"Code"}' data-select="{}" type="text" class="form-control" name="status" value="<?php echo @$_POST['status'];?>" placeholder="Press 'F2' here..." id="status" data-criteria='[{"column":"status_type","input":"#entry_type","select":"", "encode":"false", "msg":"Please select Entry Type"},{"column":"status_dept_code","input":"#dept","select":"", "encode":"false", "msg":"Please select Department"}]' />
                                     <span id="status_search" data-search="status" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span id="response_head_wrapper" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                 <label>Response Header<span class="text-red">[F2]</span></label>
                                 <span class="input-group">
                                     <input data-request='{"id":"29","search":"Code"}' data-select="{}" type="text" class="form-control" name="response" value="<?php echo @$_POST['response'];?>" placeholder="Press 'F2' here..." id="response" data-criteria='[{"column":"res_ag_flag","input":"#cus_type","select":"", "encode":"false", "msg":"Please select customer type!"},{"column":"res_dept_flag","input":"#dept","select":"", "encode":"false", "msg":"Please select customer type!"}]' />
                                     <span id="response_search" data-search="response" class="input-group-addon"><i class="fa fa-search"></i></span>
                                 </span>
                             </span>
                             <span class="col-xs-12 visible-lg visible-sm visible-xs"></span>
                             <span class="col-lg-7 col-md-8 col-sm-7 col-xs-12">
                                 <label>Remarks</label>
                                 <textarea id="remarks" name="remarks" class="textarea" style="width: 100%; height:74px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                             </span>
                             <span class="col-lg-3 col-md-4 col-sm-5 col-xs-12">
                                 <label class="col-xs-12 hidden-xs" style="margin-top:38px;">&nbsp;</label>
                                 <input type="hidden" name="status_record" id="status_record" />
                                 <button type="button" class="btn btn-report" name="add_status" id="add_status"><i class="fa fa-plus-square" aria-hidden="true"></i> ADD</button>&nbsp;
                                 <button type="button" onClick="closeView()" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> CLOSE</button>
                             </span>
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
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Entry Type</b></td>
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Response Header</b></td>
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Remarks</b></td>
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Entry Status</b></td>
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>User</b></td>
                                         <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>DateTime</b></td>
                                     </tr>
                                 </thead>
                                 <tbody id="resTbody">
                                     <?php if(0 > $res_len){?>
                                     <tr id="no-record"><td colspan="6" align="center" class="text-info" style="padding: 25px !important;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp; No status added yet!</td></tr>
                                     <?php } else{
                                               $entry_type = array(
                                                   0 => "Incoming",
                                                   1 => "Outgoing",
                                                   2 => "Action");
                                               for($index=0;$index<=$res_len; $index++)
                                               {
                                     ?>
                                        <tr data-level="<?php echo $responses[$index]->trans_level;?>">
                                         <td><?php echo $entry_type[$responses[$index]->trans_entry_type];?></td>
                                         <td><?php echo $responses[$index]->res_desc;?></td>
                                         <td><?php echo $responses[$index]->trans_response;?></td>
                                         <td><?php echo $responses[$index]->status_name;?></td>
                                         <td><?php echo $responses[$index]->user_emp_name;?></td>
                                         <td><?php echo $responses[$index]->created_at;?></td>
                                     </tr>
                                     <?php 
                                               }
                                           }?>
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
        var page = 'CRM-VIEW';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/crm.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
