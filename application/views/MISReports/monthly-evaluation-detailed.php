<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Monthly-Evaluation-Detailed-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Monthly Evaluation Detailed</title>
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
                <h1>Monthly Evaluation Detailed</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Monthly Evaluation Detailed</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <table width="100%" class="table table-results" border="1">
                          <thead>
                            <tr>
                              <td colspan="27" style="background-color: #e7f2f4; font-weight: bold; color:#000000;"> Monthly Evaluation Detailed |
                                Billing Period: 01-JUL-2019 TO 31-JUL-2019 | 
                                Report Type: Monthwise |
                                Unit: THIRUVANANTHAPURAM</td>
                            </tr>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">Other Income</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">Avg Diff Sales</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">Avg Diff Sch</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">Agency Coll Jun 1-31</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">BBS</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">SlNo</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Name &amp; Area of Executive</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">June 19</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">July 19</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Diff</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">June 19</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">July 19</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Diff</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Tot Avg Diff</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Achive</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">No of BBS Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Achive</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Dues Coll Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Dues Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Dues Coll%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Current Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">SDS</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Periodicals Scheme</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Dis Chq.</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Sponsored Copy</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">EnteKaumudi</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Net Total</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">%</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>01. THAMPANOOR  (SAJI )</td>
                              <td>Thamburu</td>
                              <td align="right">45,779</td>
                              <td align="right">46,061</td>
                              <td align="right">282</td>
                              <td align="right">2,619</td>
                              <td align="right">2,642</td>
                              <td align="right">22</td>
                              <td align="right">305</td>
                              <td align="right">72,87,723</td>
                              <td align="right">69,63,364</td>
                              <td align="right">96</td>
                              <td align="right">79</td>
                              <td align="right">22</td>
                              <td align="right">7,30,460</td>
                              <td align="right">2,37,189</td>
                              <td align="right">29</td>
                              <td align="right">4500</td>
                              <td align="right">1,10,250</td>
                              <td align="right">480</td>
                              <td align="right">26,722</td>
                              <td align="right">350</td>
                              <td align="right">2,96,125</td>
                              <td align="right">6,22,172</td>
                              <td align="right">6,00,000</td>
                              <td align="right">104</td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>03. SREEKARIYAM (SHAJI MON B L - CRE) </td>
                              <td>Rajeev</td>
                              <td align="right">20,919</td>
                              <td align="right">21,124</td>
                              <td align="right">205</td>
                              <td align="right">2,309</td>
                              <td align="right">2,479</td>
                              <td align="right">170</td>
                              <td align="right">375</td>
                              <td align="right">32,55,721</td>
                              <td align="right">30,11,721</td>
                              <td align="right">93</td>
                              <td align="right">56</td>
                              <td align="right">55</td>
                              <td align="right">6,01,476</td>
                              <td align="right">2,04,487</td>
                              <td align="right">33</td>
                              <td align="right">16,000</td>
                              <td align="right">74,368</td>
                              <td align="right">1,920</td>
                              <td align="right">8,237</td>
                              <td align="right">0</td>
                              <td align="right">1,97,750</td>
                              <td align="right">4,86,288</td>
                              <td align="right">4,00,000</td>
                              <td align="right">122</td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>04. POTHENCODE SIVA PRASAD</td>
                              <td>Thamburu</td>
                              <td align="right">9,422</td>
                              <td align="right">9,462</td>
                              <td align="right">40</td>
                              <td align="right">1,156</td>
                              <td align="right">1,125</td>
                              <td align="right">-30</td>
                              <td align="right">9</td>
                              <td align="right">15,66,993</td>
                              <td align="right">14,14,471</td>
                              <td align="right">90</td>
                              <td align="right">62</td>
                              <td align="right">29</td>
                              <td align="right">4,72,104</td>
                              <td align="right">2,04,549</td>
                              <td align="right">38</td>
                              <td align="right">28,250</td>
                              <td align="right">6,7500</td>
                              <td align="right">1,940</td>
                              <td align="right">24,956</td>
                              <td align="right">0</td>
                              <td align="right">1,03,625</td>
                              <td align="right">3,80,908</td>
                              <td align="right">3,00,000</td>
                              <td align="right">127</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>SAJI</strong></td>
                              <td>&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>02. PETTAH  SREEJITH VM</td>
                              <td>Thamburu</td>
                              <td align="right">5,644</td>
                              <td align="right">5,611</td>
                              <td align="right">-33</td>
                              <td align="right">654</td>
                              <td align="right">676</td>
                              <td align="right">22</td>
                              <td align="right">-11</td>
                              <td align="right">9,47,248</td>
                              <td align="right">7,63,011</td>
                              <td align="right">81</td>
                              <td align="right">50</td>
                              <td align="right">15</td>
                              <td align="right">4,79,410</td>
                              <td align="right">1,06,852</td>
                              <td align="right">20</td>
                              <td align="right">4000</td>
                              <td align="right">4,500</td>
                              <td align="right">0</td>
                              <td align="right">13,236</td>
                              <td align="right">0</td>
                              <td align="right">1,99,000</td>
                              <td align="right">3,01,116</td>
                              <td align="right">3,00,000</td>
                              <td align="right">100</td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>05. KOVALAM (SUFIYAN A - CRE) </td>
                              <td>Thamburu</td>
                              <td align="right">8,151</td>
                              <td align="right">8,123</td>
                              <td align="right">-28</td>
                              <td align="right">1,935</td>
                              <td align="right">1,939</td>
                              <td align="right">4</td>
                              <td align="right">-23</td>
                              <td align="right">12,32,703</td>
                              <td align="right">11,43,726</td>
                              <td align="right">93</td>
                              <td align="right">110</td>
                              <td align="right">54</td>
                              <td align="right">5,15,160</td>
                              <td align="right">1,75,425</td>
                              <td align="right">32</td>
                              <td align="right">32,000</td>
                              <td align="right">1,59,750</td>
                              <td align="right">3,020</td>
                              <td align="right">8,240</td>
                              <td align="right">0</td>
                              <td align="right">76,875</td>
                              <td align="right">4,38,830</td>
                              <td align="right">4,00,000</td>
                              <td align="right">110</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td><strong>ARUN KUMAR</strong></td>
                              <td>&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                              <td align="right">&nbsp;</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>06. PALAYAM (ARUN P )</td>
                              <td>&nbsp;</td>
                              <td align="right">5,367</td>
                              <td align="right">5,404</td>
                              <td align="right">37</td>
                              <td align="right">716</td>
                              <td align="right">696</td>
                              <td align="right">-20</td>
                              <td align="right">17</td>
                              <td align="right">8,43,500</td>
                              <td align="right">7,62,654</td>
                              <td align="right">90</td>
                              <td align="right">30</td>
                              <td align="right">27</td>
                              <td align="right">78,415</td>
                              <td align="right">87,146</td>
                              <td align="right">55</td>
                              <td align="right">78,055</td>
                              <td align="right">33,750</td>
                              <td align="right">0</td>
                              <td align="right">44,012</td>
                              <td align="right">0</td>
                              <td align="right">96,375</td>
                              <td align="right">2,51,314</td>
                              <td align="right">2,50,000</td>
                              <td align="right">101</td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>07. KESAVADASAPURAM ( MANU M K )</td>
                              <td>Rajeev </td>
                              <td align="right">3,787</td>
                              <td align="right">3,736</td>
                              <td align="right">-51</td>
                              <td align="right">1,136</td>
                              <td align="right">1,135</td>
                              <td align="right">-1</td>
                              <td align="right">-53</td>
                              <td align="right">5,68,895</td>
                              <td align="right">5,41,820</td>
                              <td align="right">95</td>
                              <td align="right">40</td>
                              <td align="right">10</td>
                              <td align="right">73,418</td>
                              <td align="right">41,950</td>
                              <td align="right">52</td>
                              <td align="right">4000</td>
                              <td align="right">90,000</td>
                              <td align="right">0</td>
                              <td align="right">4,118</td>
                              <td align="right">800</td>
                              <td align="right">1,92,700</td>
                              <td align="right">3,25,332</td>
                              <td align="right">3,25,000</td>
                              <td align="right">100</td>
                            </tr>
                            <tr>
                              <td>8</td>
                              <td>08. VATTIYOORKAVU (*******)</td>
                              <td>Rajeev </td>
                              <td align="right">1,443</td>
                              <td align="right">1,434</td>
                              <td align="right">-9</td>
                              <td align="right">347</td>
                              <td align="right">345</td>
                              <td align="right">-2</td>
                              <td align="right">-11</td>
                              <td align="right">2,32,588</td>
                              <td align="right">1,94,243</td>
                              <td align="right">84</td>
                              <td align="right">50</td>
                              <td align="right">6</td>
                              <td align="right">1,12,938</td>
                              <td align="right">31,500</td>
                              <td align="right">28</td>
                              <td align="right">0</td>
                              <td align="right">9,000</td>
                              <td align="right">0</td>
                              <td align="right">0</td>
                              <td align="right">0</td>
                              <td align="right">1,13,980</td>
                              <td align="right">1,54,480</td>
                              <td align="right">1,50,000</td>
                              <td align="right">103</td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>09. BALARAMAPURAM (RAJAJ LAL S R</td>
                              <td>Rajeev </td>
                              <td align="right">1,796</td>
                              <td align="right">1,780</td>
                              <td align="right">-16</td>
                              <td align="right">817</td>
                              <td align="right">812</td>
                              <td align="right">-5</td>
                              <td align="right">-21</td>
                              <td align="right">2,41,405</td>
                              <td align="right">2,16,225</td>
                              <td align="right">90</td>
                              <td align="right">45</td>
                              <td align="right">23</td>
                              <td align="right">1,10,100</td>
                              <td align="right">70,101</td>
                              <td align="right">60</td>
                              <td align="right">38,000</td>
                              <td align="right">0</td>
                              <td align="right">550</td>
                              <td align="right">4,001</td>
                              <td align="right">3,300</td>
                              <td align="right">4,375</td>
                              <td align="right">1,12,325</td>
                              <td align="right">2,00,000</td>
                              <td align="right">56</td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Total</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1,04,465</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1,04,893</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">428</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,327</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,487</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">159</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">588</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1,65,15,843</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">15276889</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">92</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">547</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">250</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">32,19,549</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1172767</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">32</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">2,24,805</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">5,53,618</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">9,490</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1,37,640</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">5,150</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">14,45,305</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">32,73,495</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">31,00,000</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">106</td>
                            </tr>
                          </tfoot>
                        </table>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close
                            </button>
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
        var page = 'MONTHLY-EVALUATION';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>