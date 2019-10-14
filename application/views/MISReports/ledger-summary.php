<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Ledger-Summary-".date("F-j-Y").".xlsx";
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    foreach(range('A','AZ') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
    header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$FileName.'"');
    $writer->save("php://output");
	exit();
}
$today = Enum::getTZDateTime(null, "d-m-Y");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Ledger Summary</title>
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
                <h1>Ledger Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Ledger Summary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="ledger-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/LedgerSummary?g_fe=xEdtsg0'); ?>"  onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Product</label>
                               <div class="input-group search-module" data-selected="true">
                                    <input required="required" autocomplete="off" value="" type="text" class="form-control" id="product" name="product" data-request='{"id":"18","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                               </div>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Billing Period From</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required="required" autocomplete="off" value="" type="text" class="form-control" id="billing_period" name="billing_period" data-request='{"id":"19","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="billing_period_search" data-search="billing_period"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Billing Period To</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required="required" autocomplete="off" value="" type="text" class="form-control" id="billing_period_to" name="billing_period_to" data-request='{"id":"20","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="billing_period_to_search" data-search="billing_period_to"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required="required" autocomplete="off" value="" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div> 
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input readonly type="text" value="" class="form-control agent_clr" id="agent_name" name="agent_name"/>
                            </div>                      
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Location</label>
                                <input readonly type="text" value="" class="form-control agent_clr" id="agent_loc" name="agent_loc" />
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
                        <table cellspacing="0" cellpadding="0"  border="1" class="table table-results" width="100%">
                          <thead>  
                            <tr>
                                <td colspan="10"  style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
                                    <b>Ledger Summary - Billing Period: [01-Jan-2019 TO 31-Jul-2019] - [01-Jul-2019 TO 31-Sep-2019] | Product: DAILY,WEEKLY,MAGIC SLATE | Agent: T0128-JAYAPRAKASH K, VARKALA | Report Mode: Compact</b>
                                </td>
                            </tr>                                                        
                            <tr>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Month</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Opening</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Current</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Receipt</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Debit</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="width-200" align="right">Credit</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Return</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Average</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Settlement</td>
                            </tr>
                            <tr>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Balance</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Collectable</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Journals</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Journals</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">O/s</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Copy</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Copy</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Date</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">January-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,982 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,930 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">31,600 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,400 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">45 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">February-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,447 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">45 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">March-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">104</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">April-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">17,070 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,200 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">360 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,827 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">15-04-2018</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">May-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,827 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,200 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">33,950 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">17,118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">405 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,790 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3</td>
                              <td style="border:1px solid #ecf0f5;" align="right">104</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">June-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,790 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,724 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,800 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,555 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,277 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">102</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">July-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,277 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,024 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,300 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,819 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,274 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">20,546 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;"></td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">August-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">20,546 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,910 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,500 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,200 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">September-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">20,523 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,500 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">October-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,780 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,250 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">8</td>
                              <td style="border:1px solid #ecf0f5;" align="right">108</td>
                              <td style="border:1px solid #ecf0f5;"></td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">November-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">24,866 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,795 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,072 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">December-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,072 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,831 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">23,075 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,495 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">January-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,143 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,464 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">21,680 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">February-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,680 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,490 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,250 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,995 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,925 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">March-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,925 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,237 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">34,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,995 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">25,167 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">110</td>
                              <td style="border:1px solid #ecf0f5;">03-03-2019</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">April-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,167 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,930 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">26,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">7,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">6,090 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,007 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3</td>
                              <td style="border:1px solid #ecf0f5;" align="right">106</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">May-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,007 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">22,371 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">14,082 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5,130 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">22,166 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">June-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">22,166 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">24,400 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">20,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,112 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">25,454 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">8</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;">Total</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">8,53,032 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">8,15,669 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">98,348 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">1,35,686 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">185</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                            </tr>
                              <tr>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">Current Security Balance</td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;">80,000 </td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold;"></td>
                                  <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                              </tr>
                          </tfoot>
                        </table>
                        <?php } else if($_GET['g_fe'] == 'xEdtsg1') {?>
                        <table cellspacing="0" cellpadding="0" border="1" class="table table-results" width="100%" >
                          <thead>
                            <tr>
                                <td colspan="15" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
                                    <b>Ledger Summary - Billing Period: [01-Jan-2019 TO 31-Jul-2019] - [01-Jul-2019 TO 31-Sep-2019] | Product: DAILY,WEEKLY,MAGIC SLATE | Agent: T0128-JAYAPRAKASH K, VARKALA | Report Mode: Detailed</b>                                    
                                </td>
                            </tr>
                            <tr>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Month</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Opening</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Current</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Receipt</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Chq Bounce</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Other Debit</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Unsold Cr</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Sec. Transfer</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="width-200">Other Credit</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Security</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Total</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Return</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Average</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Settlement</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus%</td>
                            </tr>
                            <tr>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Balance</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Collectable</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Journals</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Journals</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Contr</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">O/s</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Date</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">January-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,982 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,930 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">31,600 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,400 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">45 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">February-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,447 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">16,667 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">45 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">March-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">16,520 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">250</td>
                              <td style="border:1px solid #ecf0f5;" align="right">500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">104</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1.5</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">April-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,199 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">17,070 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,200 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">360 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,450</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">16,827 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">15-04-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">May-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">16,827 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,200 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">33,950 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">17,118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">405 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,300</td>
                              <td style="border:1px solid #ecf0f5;" align="right">700</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,790 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3</td>
                              <td style="border:1px solid #ecf0f5;" align="right">104</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">June-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,790 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,724 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,800 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">118 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,555 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">800</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">18,277 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">102</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1.5</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">July-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,277 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,024 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,300 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,819 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,274 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">150</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">20,546 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;"></td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">August-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">20,546 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,910 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,500 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5,500 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,200 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,220</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">September-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">20,523 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,756 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,500 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,400</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">October-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,780 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,022 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,250 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,300</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">8</td>
                              <td style="border:1px solid #ecf0f5;" align="right">108</td>
                              <td style="border:1px solid #ecf0f5;"></td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">November-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">24,866 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">19,530 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,795 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5,214</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,400</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,072 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">101</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">December-2018</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,072 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,831 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">23,075 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,495 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,514</td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,600</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">January-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,143 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">23,333 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,464 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,000</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">21,680 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">4</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1.5</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">February-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">21,680 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,490 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">18,250 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,995 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,000</td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">23,925 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">March-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,925 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">23,237 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">34,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">15,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,995 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5,245</td>
                              <td style="border:1px solid #ecf0f5;" align="right">4,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">25,167 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">110</td>
                              <td style="border:1px solid #ecf0f5;">03-03-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">April-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">25,167 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">18,930 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">26,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">7,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">6,090 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,520</td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,500</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">19,007 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3</td>
                              <td style="border:1px solid #ecf0f5;" align="right">106</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">May-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">19,007 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">22,371 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">14,082 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5,130 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">2,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">22,166 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">5</td>
                              <td style="border:1px solid #ecf0f5;" align="right">100</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;">June-2019</td>
                              <td style="border:1px solid #ecf0f5;" align="right">22,166 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">24,400 </td>
                              <td style="border:1px solid #ecf0f5; background:#a4cffd;" align="right">20,000 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">1,112 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">3,300</td>
                              <td style="border:1px solid #ecf0f5;" align="right">4,200</td>
                              <td style="border:1px solid #ecf0f5;" align="right">0 </td>
                              <td style="border:1px solid #ecf0f5; background:#fdc7ac;" align="right">25,454 </td>
                              <td style="border:1px solid #ecf0f5;" align="right">8</td>
                              <td style="border:1px solid #ecf0f5;" align="right">105</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="border:1px solid #ecf0f5;"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right"></td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">Total</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">&nbsp;</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">8,53,032 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">8,15,669 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">5,500 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">98,348 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">1,35,686 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">2,33,000</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">1,50,000</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">0 </td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">185</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                              <td style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">&nbsp;</td>
                              <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                            </tr>
                              <tr>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">Current Security Balance</td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">80,000</td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
                                  <td style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;">&nbsp;</td>
                                  <td align="right" style="background:#cfcdcd; color:#000000; border:1px solid #ecf0f5; font-weight:bold;"></td>
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
        var page = 'LEDGER-SUMMARY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>