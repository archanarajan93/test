<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Cheque-Bounce-Monitor-Detailed-".date("F-j-Y").".xlsx";
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
$show_hidden = isset($_POST['show_hidden']) ? $_POST['show_hidden'] : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Cheque Bounce Monitor Detailed</title>
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
                <h1>Cheque Bounce Monitor Detailed</h1>
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
                <div class="box">                    
                    <div class="box-body table-responsive">        
                        <?php $tot_colspan = 24;
                              if($show_hidden) $tot_colspan=$tot_colspan+6;?>             
                    <table width="100%" class="table table-results" border="1">
                      <thead>
                        <tr>
                            <td colspan="<?php echo $tot_colspan;?>" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
                                <b>Cheque Bounce Monitor Detailed | Billing Period: 01-Jun-19 to 30-Jun-19 | Product Group: DAILY | Report Type: Groupwise | UNIT: THIRUVANANTHAPURAM | Group: FIELD PROMOTER | Months: 5 | Report Mode: Detailed</b>
                            </td>
                        </tr>
                        <tr>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Jan-19</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Feb-19</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Mar-19</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Apr-19</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">May-19</td>
                          <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Jun-19</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;border-right:none !important;" scope="col">&nbsp;</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;border-right:none !important;" scope="col">&nbsp;</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;border-right:none !important;" scope="col">&nbsp;</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"">Current</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Jun-19</td>
                            <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <!--<td style="background-color: #00a7c7; font-weight: bold; color:#FFF;">Settlement</td>-->
                          <?php if($show_hidden) { ?>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                          <?php } ?>
                        </tr>
                        <tr>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">SlNo</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Code</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Name</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Location</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Collectable</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Cash</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Cheque</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">PDC</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Total Collection</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Short</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Short</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Count</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Avg. Copy</td>
                          <!--<td style="background-color: #00a7c7; font-weight: bold; color:#FFF;">Date</td>-->
                          <?php if($show_hidden) { ?>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Criteria</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Grouping Criteria 1</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Grouping Criteria 2</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Grouping Criteria 3</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Grouping Criteria 4</td>
                          <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Grouping Criteria 5</td>
                          <?php } ?>
                        </tr>
                      </thead>
                        <tbody>
                            <?php
                            for($i=1;$i<=30;$i++) {
                            if($i==1){
                            ?>
                            <tr>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="color: #D10000; font-weight:bold; border:1px solid #ecf0f5;">PRADEEP</td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <?php } ?>
                            </tr>
                            <?php
                                }
                            ?>

                            <tr>
                                <td style="border:1px solid #ecf0f5;"><?php echo $i; ?></td>
                                <td style="border:1px solid #ecf0f5;">T0128</td>
                                <td style="border:1px solid #ecf0f5;">JAYAPRAKASH K</td>
                                <td style="border:1px solid #ecf0f5;">VARKALA</td>
                                <td style="border:1px solid #ecf0f5;" align="right">1,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">20</td>
                                <td style="border:1px solid #ecf0f5;" align="right">2,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">25</td>
                                <td style="border:1px solid #ecf0f5;" align="right">3,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">30</td>
                                <td style="border:1px solid #ecf0f5;" align="right">4,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">40</td>
                                <td style="border:1px solid #ecf0f5;" align="right">5,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">50</td>
                                <td style="border:1px solid #ecf0f5;" align="right">2,50,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">50,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">50,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">1,50,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">2,50,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">10,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">10,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">4,00,000</td>
                                <td style="border:1px solid #ecf0f5;" align="right">30</td>
                                <td style="border:1px solid #ecf0f5;" align="right">300</td>
                                <!--<td><?php if($i%2==0) echo date("d-m-Y",strtotime($i."-07-2019"));?></td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <?php } ?>
                            </tr>
                            <?php if($i==10){?>
                            <tr>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">Total</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">10,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">200</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">20,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">250</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">30,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">300</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">40,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">400</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">50,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">500</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">25,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">5,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">5,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">15,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">25,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">1,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">1,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">40,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">300</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">3,000</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <?php } ?>
                                </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="color: #D10000; font-weight:bold;border:1px solid #ecf0f5;">SAJITH</td>
                                <td style="border:1px solid #ecf0f5;"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;" align="right"></td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <?php } ?>
                            </tr>
                            <?php }?>

                            <?php } ?>
                            <tr>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">Total</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;"></td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">20,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">400</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">40,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">500</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">60,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">600</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">80,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">800</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">1,00,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">1,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">50,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">10,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">10,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">30,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">50,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">2,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">2,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">80,00,000</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">600</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;" align="right">6,000</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;font-weight:bold;">&nbsp;</td>
                                <?php } ?>
                                </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td align="right"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <!--<td>&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <?php } ?>
                                </tr>
                                <tr>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">Total</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">30,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">600</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">60,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">750</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">90,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">900</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,20,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,200</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,50,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,500</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">75,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">15,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">15,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">45,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">75,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">3,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">3,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,20,00,000</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">900</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">9,000</td>
                                <!--<td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>-->
                                <?php if($show_hidden) { ?>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                                <?php } ?>
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
        var page = 'COLLECTION-TARGET';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>