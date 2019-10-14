<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Daily-Canvassed-Copies-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    //$spreadsheet->getActiveSheet()->setTitle("123");
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
    <title>Circulation | Daily Canvassed Copies</title>
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
                <h1>Daily Canvassed Copies</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">MIS Reports</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">                       
                       <form id="dcc-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/DailyCanvassedCopies?g_fe=xEdtsg'); ?>">

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date Type</label>
                               <select class="form-control">
                                   <option value="1">Canvassed</option>
                                   <option value="2">Created</option>
                               </select>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date From</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date To</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Report Type</label>
                               <select class="form-control" id="type">
                                   <option value="1">Unitwise</option>
                                   <option value="2">Saletypewise</option>
                                   <option value="3">Regionwise</option>
                                   <option value="4">Promoterwise</option>
                                   <option value="5">ACMwise</option>
                               </select>
                           </div>
                           
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Units</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />                                     
                                   <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                               <label>Copy Types</label>
                               <select id="copy_master" name="copy_master" class="hidden">
                                   <?php foreach($copy_lists as $copy){?>
                                   <option <?php if($copy->copy_name=='SALES') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                   <?php }?>
                               </select>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}'  data-criteria='[{"column":"copy_code","input":"#copy_master","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' data-select="{}" data-multiselect="true" placeholder="" />
                                   <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
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
                        <table width="100%" class="table table-results" border="1">
                            <thead>
                                <tr>
                                    <td colspan="23" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">Daily Canvassed Copies From 01-Jul-2019 To 08-Jul-2019 | Date Type: CANVASSED | Report Type: Unitwise | Copy Types: GURUDEEPAM, BBS 1 YEAR 2000</td>
                                </tr>
                                <tr>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Unit</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">01-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">02-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">03-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">04-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">05-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">06-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">07-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">08-07-19</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Canvassed</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Days</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">CP/Day</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target CP/Day</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Not Contacted</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Pending</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Approved</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Rejected</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Rejected%</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Paused</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Billed</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Canvassed</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Fresh</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Retained</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>THIRUVANANTHAPURAM</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" class="drill-down">1</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">23</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">11</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">38</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">10</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">35</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">3</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;">38</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">3</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>KOLLAM</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down"></td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">8</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>ALAPUZHA</td>
                                    <td align="right" class="drill-down">1</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down"></td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>PATHANAMTHITTA</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;"></td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="drill-down">KOTTAYAM</td>
                                    <td align="right" class="drill-down">2</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down"></td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">100%</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>ERANAKULAM</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">3</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>TRISSUR</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;"></td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>MALAPPURAM</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">3</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down"></td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">3</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;" class="drill-down">1</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>KOZHIKODE</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">4</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">19</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">23</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">2</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">3</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">18</td>
                                    <td align="right" style="border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">22%</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;" class="drill-down">23</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>KANNUR</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6e06a;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#f6f7bc;border:1px solid #ecf0f5;" class="drill-down">5</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#8fd9fd;border:1px solid #ecf0f5;"></td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#bff9f9;border:1px solid #ecf0f5;">&nbsp;</td>
                                </tr>                                  
                                <tr>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;">TOTAL</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">9</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">0</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">20</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">1</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">2</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">25</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">14</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">3</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">74</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">42</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">0</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">19</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">7</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down"></td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">0</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">6</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">74</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">6</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">0</td>
                                </tr>
                                <tr>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">57%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">26%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">9%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right"></td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">8%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">100%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right" class="drill-down">8%</td>
                                    <td style="background:#cfcdcd;font-weight:bold;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                                </tr>                                                             
                            </tbody>                            
                        </table>
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

    <form class="hide" id="daily-canvass-copies-detailed-form" method="post" target="_blank" action="<?php echo base_url('MISReports/DailyCanvassedCopiesDetails'); ?>">
        <input type="text" value="0" />
    </form>

    <!-- ./wrapper -->
    <script>
        var page = 'DAILY-CANVAS-COPY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>