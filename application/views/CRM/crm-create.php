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
    <title>Circulation | CRM Create</title>
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
                <h1>CRM Create</h1>
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
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('CRM/CreateCRM'); ?>" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.crm.validateCRM();">
                             <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Token No.</label>
                                    <input type="text" class="form-control highlite" value="<?php echo @$token_no; ?>" readonly id="token_no" name="token_no" />
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>User</label>
                                    <input type="text" class="form-control highlite" value="<?php echo @$user_name; ?>" readonly id="user_name" name="user_name" />
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Date-Time</label>
                                    <input type="text" class="form-control highlite" value="<?php echo date("d-m-Y h:i A"); ?>" readonly id="now" name="now" />
                                </span>
                                <span class="col-xs-12" style="margin-bottom:15px;"></span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Unit<span class="text-red">[F2]</span></label>
                                    <span class="input-group">
                                        <input data-request='{"id":"13","search":"Unit"}' data-select="{}" type="text" class="form-control" name="unit" value="<?php if(@$_POST['unit']) echo @$_POST['unit']; else echo @$user_unit["UNIT"];?>" placeholder="Press 'F2' here..." id="unit" />
                                        <span id="unit_search" data-search="unit" class="input-group-addon"><i class="fa fa-search"></i></span>
                                        <input type="hidden" name="unit_rec_sel" class="unit_clr" id="unit_rec_sel" value="<?php echo rawurlencode(json_encode($user_unit));?>">
                                    </span>
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Product<span class="text-red">[F2]</span></label>
                                    <span class="input-group">
                                        <input data-request='{"id":"18","search":"Product"}' data-select="{}" type="text" class="form-control" name="product" value="<?php if(isset($_POST['product'])) echo @$_POST['product']; else echo "DLY";?>" placeholder="Press 'F2' here..." id="product" />
                                        <input type="hidden" name="product_rec_sel" class="product_clr" id="product_rec_sel" value="<?php if(isset($_POST['product_rec_sel'])) echo @$_POST['product_rec_sel']; else echo rawurlencode(json_encode(array("Code"=>"DLY","Name"=>"DAILY")));?>">
                                        <span id="product_search" data-search="product" class="input-group-addon"><i class="fa fa-search"></i></span>
                                    </span>
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Department</label>
                                    <select name="dept" class="form-control" id="dept">
                                        <option value="PMD">PMD</option>
                                        <option value="SMD">SMD</option>
                                        <option value="EDT">EDT</option>
                                    </select>
                                </span>
                                <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Customer</label>
                                    <select name="customer" class="form-control" id="customer">
                                        <option value="Subscriber">Subscriber</option>
                                        <option value="Agent">Agent</option>
                                        <option value="General">General</option>
                                    </select>
                                    <input type="hidden" id="cus_type" value="0" />
                                </span>
                                <span class="col-xs-12">&nbsp;</span>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus" id="subscriber_box">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>SUBSCRIBER</strong></div>
                                    <div class="row">
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Subscriber Code<span class="text-red">[F2]&nbsp;[Min 3 chars]</span></label>
                                            <span class="input-group">
                                                <input data-request='{"id":"23","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp" name="subscriber" data-minchars="3" value="<?php echo @$_POST['subscriber'];?>" placeholder="Press 'F2' here..." id="subscriber"
                                                       data-criteria='[{"column":"sub_unit_code","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"}]'  data-target='[{"selector":"#sub_name","indexes":"0"},{"selector":"#sub_addr","indexes":"1"},{"selector":"#sub_contact","indexes":"6"},
                                                       {"selector":"#sub_executive_code","indexes":"11"},{"selector":"#sub_executive","indexes":"5"},{"selector":"#cus_ag_code","indexes":"9"},{"selector":"#cus_ag_name","indexes":"2"},{"selector":"#cus_ag_phone","indexes":"7"}]'/>
                                                <span id="subscriber_search" data-search="subscriber" class="input-group-addon"><i class="fa fa-search"></i></span>
                                            </span>
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control cus_inp subscriber_clr" disabled readonly id="sub_name" name="sub_name" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Address</label>
                                            <input type="text" class="form-control cus_inp subscriber_clr" disabled readonly id="sub_addr" name="sub_addr" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control cus_inp subscriber_clr" id="sub_contact" name="sub_contact" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Scheme<span class="text-red">[F2]</span></label>
                                            <span class="input-group">
                                                <input data-request='{"id":"41","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp subscriber_clr" name="scheme" value="" placeholder="Press 'F2' here..." id="scheme"
                                                       data-criteria='[{"column":"unit_code","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"},
                                                          {"column":"scheme","input":"#subscriber_rec_sel","select":"Code", "msg":"Please select subscriber!"}]' data-target='[{"selector":"#scheme_code","indexes":"5"}]'/>
                                                <span id="scheme_search" data-search="scheme" class="input-group-addon"><i class="fa fa-search"></i></span>
                                            </span>
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Scheme Code</label>
                                            <input type="text" class="form-control cus_inp subscriber_clr scheme_clr" readonly id="scheme_code" name="scheme_code" />
                                        </span>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Field Staff</label><br />
                                            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding">
                                                <input readonly class="form-control subscriber_clr " type="text" name="sub_executive_code" id="sub_executive_code" />
                                            </div>
                                            <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding">
                                                <input readonly class="form-control cus_inp subscriber_clr" type="text" id="sub_executive" name="sub_executive" />
                                            </div>
                                        </div>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Agency</label><br />
                                            <span class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding"><input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_code" name="cus_ag_code" /></span>
                                            <span class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding"><input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_name" name="cus_ag_name" /></span>
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Agency Phone</label>
                                            <input type="text" class="form-control cus_inp subscriber_clr" readonly id="cus_ag_phone" name="cus_ag_phone" />
                                        </span>
                                        <span class="col-xs-12">&nbsp;</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus hidden" id="agent_box">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>AGENT</strong></div>
                                    <div class="row">
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Agent Code<span class="text-red">[F2]&nbsp;[Min 3 chars]</span></label>
                                            <span class="input-group">
                                                <input data-request='{"id":"17","search":"Code"}' data-select="{}" type="text" class="form-control cus_inp" name="agent" data-minchars="3" value="<?php //echo @$_POST['agent'];?>" placeholder="Press 'F2' here..." id="agent"
                                                    data-criteria='[{"column":"agent_unit","input":"#unit_rec_sel","select":"UNIT", "msg":"Please select unit!"}]'    
                                                       data-target='[{"selector":"#agent_name","indexes":"1"},{"selector":"#agent_addr","indexes":"4"},{"selector":"#agent_contact","indexes":"3"},{"selector":"#agent_executive_code","indexes":"7"},{"selector":"#agent_executive","indexes":"5"}]'/>
                                                <span id="agent_search" data-search="agent" class="input-group-addon"><i class="fa fa-search"></i></span>
                                            </span>
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control agent_clr cus_inp" readonly disabled id="agent_name" name="agent_name" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Address</label>
                                            <input type="text" class="form-control agent_clr cus_inp" readonly disabled id="agent_addr" name="agent_addr" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control agent_clr cus_inp" id="agent_contact" name="agent_contact" />
                                        </span>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Field Staff</label><br />
                                            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 no-padding">
                                                <input readonly type="text" class="form-control cus_inp agent_clr" id="agent_executive_code" name="agent_executive_code" />
                                            </div>
                                            <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6 no-padding">
                                                <input readonly type="text" class="form-control cus_inp agent_clr" id="agent_executive" name="agent_executive" />
                                            </div>
                                        </div>
                                        <span class="col-xs-12">&nbsp;</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cus hidden" id="general_box">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-form"><strong>GENERAL</strong></div>
                                    <div class="row">
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Name</label>
                                            <input type="text" class="form-control cus_inp" id="gen_name" name="gen_name" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Address</label>
                                            <input type="text" class="form-control cus_inp" id="gen_addr" name="gen_addr" />
                                        </span>
                                        <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control cus_inp" id="gen_contact" name="gen_contact" />
                                        </span>
                                        <span class="col-xs-12">&nbsp;</span>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                            <input type="hidden" name="status_record" id="status_record" />
                                            <label class="col-xs-12 hidden-xs" style="margin-top:38px;">&nbsp;</label>
                                            <?php if($is_admin == 1) { ?>
                                            <button type="submit" class="btn btn-report btn-primary" name="show_crm"><i class="fa fa-floppy-o" aria-hidden="true"></i> SAVE</button>&nbsp;
                                            <?php } ?>
                                            <button type="button" onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> CLOSE</button>
                                        </span>
                                    </div>
                                </div>
                                <span class="col-xs-12">&nbsp;</span>
                            </form>
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
    <?php }?>
</body>
</html>
