<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Agent-Print-Order-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Agent Printorder</title>
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
                <h1>Agent Printorder</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Agent Printorder</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="agent-printorder-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/AgentPrintOrder?g_fe=xEdtsg0'); ?>"  onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Agent</label>
                               <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-selectIndex="0" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                               </div>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input readonly type="text" value="" class="form-control agent_clr" id="agent_name" name="agent_name" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Location</label>
                                <input readonly type="text" value="" class="form-control agent_clr" id="agent_loc" name="agent_loc" />
                            </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date From</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="from_date" name="from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date To</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="to_date" name="to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Copy Type</label>
                               <select name="copy_type[]" id="copy_type[]" class="form-control select2" multiple>
                                    <?php foreach($copy_lists as $copy){?>
                                        <option selected value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                    <?php }?>
                                </select>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Amendment Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="" type="text" class="form-control" id="amendment_type" name="amendment_type" data-request='{"id":"25","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="amendment_type_search" data-search="amendment_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div> 
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Report Mode</label>
                                <select name="show_hidden" id="report_mode" class="form-control">
                                    <?php
                                         $rt = Enum::getAllConstants('ReportMode');
                                         foreach($rt as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary" id="show-report" type="button"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>
                <?php } elseif(isset($_GET['g_fe'])) { ?>
                <div class="box">
                  <div class="box-body table-responsive">
                    <?php if($_GET['g_fe']=='xEdtsg0') { ?>
                        <table border="1" class="table table-results" style="width:60%;">
                          <tr>
                              <td style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="2"><strong> Agent Printorder of T0128 - <?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?></strong></td>
                          </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">ACM</td>
                                <td style="border:1px solid #ecf0f5;">ACM NAME</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Promoter</td>
                                <td style="border:1px solid #ecf0f5;">RAHUL S R</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Bureau</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Edition</td>
                                <td style="border:1px solid #ecf0f5;">TRIVANDRUM-CHIRAYANKEEZH</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Route</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Dropping Point</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA MYTHANAM</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Address</td>
                                <td style="border:1px solid #ecf0f5;"><?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Phone No.</td>
                                <td style="border:1px solid #ecf0f5;">+91 8891823491, 0471 2356553</td>
                            </tr>
                        </table>
                        <table border="1" class="table table-results" style="width:60%;">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="4">
                                        <strong>AMENDMENT REPORT FROM 01-JAN-2019 - 28-JUN-2019 | Copy Group: SALES,SCHEME,SPONSOR,FREE | Amendment Types: DIRECT SALE,ENTEKAUMUDI,SCHEME AUTO</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">DATE</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">PLUS</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">MINUS</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">TOTAL</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="color:#ff0e3e;border:1px solid #ecf0f5;">Copy As on 01-Jan-2019 = 168</td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">1</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">167</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Feb-2019</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">1</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">168</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Mar-2019</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Apr-2019</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">168</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">May-2019</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;">Total</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">9</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">5</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <table class="table table-results" style="margin-top:10px; width:35%;">
                            <thead>
                                <tr>
                                    <td colspan="2" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">Copy As on 28-June-2019 </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Sales - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right" width="85">120</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Scheme - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">40</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Free - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">12</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                            </tfoot>
                        </table>
                      <?php } else if($_GET['g_fe']=='xEdtsg1'){?>
                        <table border="1" class="table table-results" style="width:60%;">
                          <tr>
                              <td style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="2"><strong> Agent Printorder of T0128 - <?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?></strong></td>
                          </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">ACM</td>
                                <td style="border:1px solid #ecf0f5;">ACM NAME</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Promoter</td>
                                <td style="border:1px solid #ecf0f5;">RAHUL S R</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Bureau</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Edition</td>
                                <td style="border:1px solid #ecf0f5;">TRIVANDRUM-CHIRAYANKEEZH</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Route</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Dropping Point</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA MYTHANAM</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Address</td>
                                <td style="border:1px solid #ecf0f5;"><?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Phone No.</td>
                                <td style="border:1px solid #ecf0f5;">+91 8891823491, 0471 2356553</td>
                            </tr>
                        </table>
                        <table border="1" class="table table-results" style="width:60%;">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" align="left" colspan="7">
                                        AMENDMENT REPORT FROM 01-JAN-2019 - 28-JUN-2019 | Copy Group: SALES,SCHEME,SPONSOR,FREE | Amendment Types: DIRECT SALE,ENTEKAUMUDI,SCHEME AUTO
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">DATE</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">SUBSCRIBER</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">COPY TYPE</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">AMENDMENT TYPE</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">PLUS</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">MINUS</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">TOTAL</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="color:#ff0e3e;border:1px solid #ecf0f5;">Copy As on 01-Jan-2019 =    168</td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">01-Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;">SISUPALAN</td>
                                    <td style="border:1px solid #ecf0f5;">Unity 2018 1 Year - 2000</td>
                                    <td style="border:1px solid #ecf0f5;">DIRECT SALE</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">1</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">167</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">03-Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;">SISUPALAN</td>
                                    <td style="border:1px solid #ecf0f5;">SDS 2016 1 YEAR - 2250</td>
                                    <td style="border:1px solid #ecf0f5;">DIRECT SALE</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">1</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">168</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">06-Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;">DEFAULT</td>
                                    <td style="border:1px solid #ecf0f5;">SALES</td>
                                    <td style="border:1px solid #ecf0f5;">SCHEME AUTO</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">07-Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;">DEFAULT</td>
                                    <td style="border:1px solid #ecf0f5;">SALES</td>
                                    <td style="border:1px solid #ecf0f5;">SCHEME AUTO</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">168</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">13-Jan-2019</td>
                                    <td style="border:1px solid #ecf0f5;">DEFAULT</td>
                                    <td style="border:1px solid #ecf0f5;">SALES</td>
                                    <td style="border:1px solid #ecf0f5;">SCHEME AUTO</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">4</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">0</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                    <td style="border:1px solid #ecf0f5;"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;">Total</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">9</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">5</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <table class="table table-results" style="margin-top:10px; width:35%;">
                            <thead>
                                <tr>
                                    <td colspan="2" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">Copy As on 28-June-2019 </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Sales - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right" width="85">120</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Scheme - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">40</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;">Free - Total</td>
                                    <td style="border:1px solid #ecf0f5;" align="right">12</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;"></td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold;border:1px solid #ecf0f5;" align="right">172</td>
                                </tr>
                            </tfoot>
                        </table>
                      <?php }?>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
        var page = 'AGENT-PRINT-ORDER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>