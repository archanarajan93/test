<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Bonus-Analysis-Summary-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Bonus Analysis Summary</title>
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
                <h1>Bonus Analysis Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Bonus Analysis</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table width="100%" class="table table-results" border="1">
                            <thead>
                                <tr>
                                    <td bgcolor="#00a7c7" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="20"><strong>Bonus Analysis Summary | Billing Period: 01-Jun-19 to 30-Jun-19 | Report Type: Unitwise | Months: 5 | Report Mode: Compact</strong></td>
                                </tr>
                                <tr>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" scope="col">&nbsp;</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" scope="col">&nbsp;</td>
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
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"></td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" scope="col">&nbsp;</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bonus Agents</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Net Collection</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Cheque Bounce</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Avg. Copy</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Unique Agents</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">THIRUVANANTHAPURAM</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">KOLLAM</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">75,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">35</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">82</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,64,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">38,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">110</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">35</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,20,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">35</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">75</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">95,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">110</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">125</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,10,400</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">125</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">110</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,44,100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">180</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,88,500</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">180</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">4,33,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">170</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">6,80,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">50,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">220</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">58</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">ALAPPUZHA</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,30,40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,400</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">33</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">68,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">80</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">98,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">35</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">75,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">33,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">88,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,44,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,88,500</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">170</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,40,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">180</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">200</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">6,88,550</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">40,550</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">200</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">170</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">PATHANAMTHITTA</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">ERNAKULAM</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">98,220</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,02,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">84</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,65,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">82</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">48,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">110</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">80,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">35</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">42</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">75</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">90</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,26,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">86</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,86,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">110</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">155</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,88,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,33,500</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">200</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">200</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">4,55,500</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">180</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">6,90,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">70,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">255</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">58</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">THRISSUR</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">MALAPPURAM</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">KOZHIKODE</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">KANNUR</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,45,300</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">40</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,200</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">77,500</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">62</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,44,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">50</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">2,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">20,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">105</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1.5%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">85,550</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">94,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">70</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,85,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1%</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">45</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">65,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">44,100</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">15</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">25,250</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">58</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">60,050</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">32</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">99,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">55</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">1,53,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">30,000</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">120</td>
                                    <td style="color:#000000; border:1px solid #ecf0f5;" align="right">10</td>
                                </tr>
                                <tr>
                                    <td style="color:#a94c4c; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">Total</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">102</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,55,650</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">115</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">2,23,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">100</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,57,850</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">146</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">1,98,150</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">164</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">3,42,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">165</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">5,91,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">60,000</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">325</td>
                                    <td style="color:#a94c4c; background: #f1f1f1; font-weight:bold; border:1px solid #ecf0f5;" align="right">65</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Total</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"></td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,250</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">4,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,400</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">3,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,550</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">3,60,800</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,800</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">3,90,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,650</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">5,60,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1,900</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">6,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">5,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">2,100</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">450</td>
                                </tr>
                            </tfoot>
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
        var page = 'CHEQUE-BOUNCE-MONITOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>