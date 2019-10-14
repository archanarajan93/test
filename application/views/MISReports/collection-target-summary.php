<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Detailed-Agency-Collection-Summary-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    //$spreadsheet->getActiveSheet()->setTitle("123");
    foreach(range('A','Z') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    //$spreadsheet->getActiveSheet()->unmergeCells('A1:M1');
    //$spreadsheet->getActiveSheet()->getColumnDimension('A1')->setWidth(30);
    //$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
    //$spreadsheet->getActiveSheet()->getStyle('B5')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
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
    <title>Circulation | Detailed Agency Collection Summary</title>
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
                <h1>Detailed Agency Collection Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Detailed Agency Collection</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <?php 
                        $colspan=23;
                        if($show_hidden) $colspan=$colspan+1;
                        ?>
<table width="100%" class="table table-results" border="1">
  <thead>
    <tr>
      <td style="background-color: #e7f2f4; font-weight: bold; color:#000000;" colspan="<?php echo $colspan; ?>"><strong>DETAILED AGENCY COLLECTION SUMMARY - 01-JUL-2019 TO 31-JUL-2019 | Product Group: DAILY | SHORT: 2 MONTHS | Report Type: Unitwise | Report Mode : <?php echo Enum::getConstant('ReportMode',$show_hidden); ?></strong></td>
    </tr>
    <tr>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">APR-19</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">FEB-19</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">MAR-19</td>
      <!--<td align="center" colspan="<?php echo $show_hidden ? "3" : "2"; ?>" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Billing APR-19</td>-->
      
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Billing APR-19</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <?php } ?>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Journals - APR-19</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Collection</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Balance</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Balance</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">APR-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Total</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">31-03-19</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Bonus</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">UNIT</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Opening Balance</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Short</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Short</td>
      <?php if($show_hidden) { ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Bill - Mar-19</td>
      <?php } ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Collectable</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Dis. Cheque</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Debit</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Credit</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Total</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Cash</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Cheque</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">PDC</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Coll.Net</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Coll%</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Collectable</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Cl Bal</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Security</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Copy</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">B 2%</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">B 1.5%</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">B 1%</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td height="25">TVM</td>
      <td align="right">9,61,259</td>
      <td align="right">56,444</td>
      <td align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right">12,895</td>
      <?php } ?>
      <td align="right">11,745</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">98,895</td>
      <td align="right">50,456</td>
      <td align="right">1,935</td>
      <td align="right">6,895</td>
      <td align="right">7,456</td>
      <td align="right">98,456</td>
      <td align="right">12,445</td>
      <td align="right">10,562</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">2,562</td>
      <td align="right">1,562</td>
      <td align="right">3,562</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">6,456</td>
      <td align="right">6,456</td>
      <td align="right">1,456</td>
      <td align="right">50,895</td>
      <td align="right">6</td>
      <td align="right">8</td>
      <td align="right">1</td>
    </tr>
    <tr>
      <td>QLN</td>
      <td align="right">7,56,456</td>
      <td align="right">95,656</td>
      <td align="right">89,461</td>
      <?php if($show_hidden) { ?>
      <td align="right">96,456</td>
      <?php } ?>
      <td align="right">44,656</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">14,696</td>
      <td align="right">45,412</td>
      <td align="right">14,693</td>
      <td align="right">9,800</td>
      <td align="right">8,456</td>
      <td align="right">96,410</td>
      <td align="right">14,652</td>
      <td align="right">98,120</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">9,120</td>
      <td align="right">1,000</td>
      <td align="right">9,100</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">14,500</td>
      <td align="right">8,620</td>
      <td align="right">9,120</td>
      <td align="right">32,400</td>
      <td align="right">7</td>
      <td align="right">4</td>
      <td align="right">1</td>
    </tr>
    <tr>
      <td>ALP</td>
      <td align="right">9,61,259</td>
      <td align="right">56,444</td>
      <td align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right">12,895</td>
      <?php } ?>
      <td align="right">11,745</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">98,895</td>
      <td align="right">50,456</td>
      <td align="right">1,935</td>
      <td align="right">6,895</td>
      <td align="right">7,456</td>
      <td align="right">98,456</td>
      <td align="right">12,445</td>
      <td align="right">12,445</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">2,562</td>
      <td align="right">3,562</td>
      <td align="right">3,562</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">3,562</td>
      <td align="right">6,456</td>
      <td align="right">12,445</td>
      <td align="right">20,262</td>
      <td align="right">5</td>
      <td align="right">9</td>
      <td align="right">2</td>
    </tr>
    <tr>
      <td>PTA</td>
      <td align="right">7,56,456</td>
      <td align="right">95,656</td>
      <td align="right">89,461</td>
      <?php if($show_hidden) { ?>
      <td align="right">96,456</td>
      <?php } ?>
      <td align="right">44,656</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">14,696</td>
      <td align="right">45,412</td>
      <td align="right">14,693</td>
      <td align="right">9,800</td>
      <td align="right">8,456</td>
      <td align="right">96,410</td>
      <td align="right">14,652</td>
      <td align="right">98,120</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">9,120</td>
      <td align="right">1,162</td>
      <td align="right">9,100</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">14,500</td>
      <td align="right">8,620</td>
      <td align="right">9,120</td>
      <td align="right">23,142</td>
      <td align="right">9</td>
      <td align="right">1</td>
      <td align="right">3</td>
    </tr>
    <tr>
      <td>KTM</td>
      <td align="right">9,61,259</td>
      <td align="right">56,444</td>
      <td align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right">12,895</td>
      <?php } ?>
      <td align="right">11,745</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">98,895</td>
      <td align="right">50,456</td>
      <td align="right">1,935</td>
      <td align="right">6,895</td>
      <td align="right">7,456</td>
      <td align="right">98,456</td>
      <td align="right">12,445</td>
      <td align="right">10,562</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">2,562</td>
      <td align="right">2,502</td>
      <td align="right">3,562</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">6,456</td>
      <td align="right">6,456</td>
      <td align="right">3,562</td>
      <td align="right">22,500</td>
      <td align="right">6</td>
      <td align="right">6</td>
      <td align="right">5</td>
    </tr>
    <tr>
      <td>EKM</td>
      <td align="right">7,56,456</td>
      <td align="right">95,656</td>
      <td align="right">89,461</td>
      <?php if($show_hidden) { ?>
      <td align="right">96,456</td>
      <?php } ?>
      <td align="right">44,656</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">14,696</td>
      <td align="right">45,412</td>
      <td align="right">14,693</td>
      <td align="right">9,800</td>
      <td align="right">8,456</td>
      <td align="right">96,410</td>
      <td align="right">14,652</td>
      <td align="right">98,120</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">9,120</td>
      <td align="right">1,562</td>
      <td align="right">9,100</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">14,500</td>
      <td align="right">8,620</td>
      <td align="right">98,120</td>
      <td align="right">29,455</td>
      <td align="right">6</td>
      <td align="right">5</td>
      <td align="right">1</td>
    </tr>
    <tr>
      <td>TSR</td>
      <td align="right">9,61,259</td>
      <td align="right">56,444</td>
      <td align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right">12,895</td>
      <?php } ?>
      <td align="right">11,745</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">98,895</td>
      <td align="right">50,456</td>
      <td align="right">1,935</td>
      <td align="right">6,895</td>
      <td align="right">7,456</td>
      <td align="right">98,456</td>
      <td align="right">12,445</td>
      <td align="right">10,562</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">2,562</td>
      <td align="right">7,562</td>
      <td align="right">3,562</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">6,456</td>
      <td align="right">6,456</td>
      <td align="right">2,562</td>
      <td align="right">20,451</td>
      <td align="right">4</td>
      <td align="right">4</td>
      <td align="right">2</td>
    </tr>
    <tr>
      <td>MLP</td>
      <td align="right">7,56,456</td>
      <td align="right">95,656</td>
      <td align="right">89,461</td>
      <?php if($show_hidden) { ?>
      <td align="right">96,456</td>
      <?php } ?>
      <td align="right">44,656</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">14,696</td>
      <td align="right">45,412</td>
      <td align="right">14,693</td>
      <td align="right">9,800</td>
      <td align="right">8,456</td>
      <td align="right">96,410</td>
      <td align="right">14,652</td>
      <td align="right">98,120</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">9,120</td>
      <td align="right">6,562</td>
      <td align="right">9,100</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">14,500</td>
      <td align="right">8,620</td>
      <td align="right">98,120</td>
      <td align="right">22,525</td>
      <td align="right">7</td>
      <td align="right">3</td>
      <td align="right">1</td>
    </tr>
    <tr>
      <td>KOZ</td>
      <td align="right">9,61,259</td>
      <td align="right">56,444</td>
      <td align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right">12,895</td>
      <?php } ?>
      <td align="right">11,745</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">98,895</td>
      <td align="right">50,456</td>
      <td align="right">1,935</td>
      <td align="right">6,895</td>
      <td align="right">7,456</td>
      <td align="right">98,456</td>
      <td align="right">12,445</td>
      <td align="right">10,562</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">2,562</td>
      <td align="right">1,562</td>
      <td align="right">3,562</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">6,456</td>
      <td align="right">6,456</td>
      <td align="right">6,895</td>
      <td align="right">19,452</td>
      <td align="right">6</td>
      <td align="right">2</td>
      <td align="right">4</td>
    </tr>
    <tr>
      <td>KNR</td>
      <td align="right">7,56,456</td>
      <td align="right">95,656</td>
      <td align="right">89,461</td>
      <?php if($show_hidden) { ?>
      <td align="right">96,456</td>
      <?php } ?>
      <td align="right">44,656</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">14,696</td>
      <td align="right">45,412</td>
      <td align="right">14,693</td>
      <td align="right">9,800</td>
      <td align="right">8,456</td>
      <td align="right">96,410</td>
      <td align="right">14,652</td>
      <td align="right">98,120</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">9,120</td>
      <td align="right">1,562</td>
      <td align="right">9,100</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">14,500</td>
      <td align="right">8,620</td>
      <td align="right">9,800</td>
      <td align="right">26,141</td>
      <td align="right">1</td>
      <td align="right">2</td>
      <td align="right">5</td>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" >TOTAL</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"  align="right">9,61,259</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">56,444</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">41,789</td>
      <?php if($show_hidden) { ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">12,895</td>
      <?php } ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">11,745</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,895</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">50,456</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">1,935</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">6,895</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">7,456</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,456</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,445</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">10,562</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">2,562</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">9,599</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">3,562</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">6,456</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">6,456</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">11,745</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">9,23,253</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">9</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">3</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">2</td>
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