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
    foreach(range('A','Z') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }   
    $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
    header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$FileName.'"');
    $writer->save("php://output");
	exit();
}
$show_hidden     = isset($_POST['show_hidden']) ? $_POST['show_hidden'] : 0;
$show_settlement = isset($_POST['show_settlement']) ? $_POST['show_settlement'] : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Detailed Agency Collection</title>
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
                <h1>Detailed Agency Collection</h1>
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
                    <?php $colspan=23;
                            if($show_hidden) $colspan=$colspan+10;
                            if($show_settlement) $colspan=$colspan+1;
                            //35 cells in total
                    ?>
<table width="100%" class="table table-results" border="1">
  <thead>
    <tr>
      <td style="background-color: #e7f2f4; font-weight: bold; color:#000000;" colspan="<?php echo $colspan;?>"> DETAILED AGENCY COLLECTION - 01-JUL-2019 TO 31-JUL-2019 | Product Group: DAILY | SHORT: 3 MONTHS | UNIT: THIRUVANANTHAPURAM | Type: Groupwise | Group: FIELD PROMOTER | Report Mode : <?php echo Enum::getConstant('ReportMode',$show_hidden); ?></td>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <!--<td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" colspan="<?php echo $show_hidden ? "3" : "2"; ?>" align="center">Billing Apr 19</td>-->
      
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Billing Apr 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <?php } ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Journals - Apr 19</td>

      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <?php } ?>
        
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd!important;">Collection</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;border-right-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd!important;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <?php } ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="center">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"></td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Sl No</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Code</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Agent Name</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr-19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Jan-19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Feb-19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Mar - 19</td>
      <?php if($show_hidden) { ?>
      <td  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Mar - 19</td>
      <?php } ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>

      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <?php } ?>

      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">%</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Balance</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Balance</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Apr-19</td>
      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Sec.</td>
      <?php } ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Mar - 19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">31-03-19</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Bonus</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Chq Bouce</td>
      <?php if($show_settlement) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Settlement</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Agent</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">ACM</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Promoter</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Shakha</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Edition</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Dropping Point</td>
      <?php } ?>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Location</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">OP Bal</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Short</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Short</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Short</td>
      <?php if($show_hidden) { ?>
      <td  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Bill</td>
      <?php } ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Collectable</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Dis Chq</td>

      <?php if($show_hidden) { ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Debit</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Credit</td>
      <?php } ?>

      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Journal Total</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Cash</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Chq</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Pd Chq.</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Coll.Net</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Collectable</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Cl Bal</td>
      <?php if($show_hidden) { ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Short</td>
      <?php } ?>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Security</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Copy</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Count</td>
      <?php if($show_settlement) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Date</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Criteria</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td></td>
      <td style="color:#ff0000;font-weight:bold;">01. THAMPANOOR (THAMPURU R P - ACM) PH : 9946103223</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>1</td>
      <td>T0019</td>
      <td>SANTHOSH KUMAR S, CHENTHITTA</td>
      <td align="right">21,797</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <?php if($show_hidden) { ?>
      <td align="right">22,517</td>
      <?php } ?>
      <td align="right">21,797</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">0</td>

      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <td align="right">0</td>
      <?php } ?>

      <td align="right">0</td>
      <td align="right">21,797</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">100</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">1,08,699</td>
      <td align="right">124</td>
      <td align="right">1%</td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>14-05-2019</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td>ACM NAME</td>
      <td>RAHUL S R</td>
      <td>VARKALA</td>
      <td>TRIVANDRUM-CHIRAYANKEEZH</td>
      <td>VARKALA MYTHANAM</td>
      <?php } ?>
    </tr>
    
    <!--repeated-->
    <tr>
      <td>2</td>
      <td>T0019</td>
      <td>SANTHOSH KUMAR S, CHENTHITTA</td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right">0</td>
      <?php if($show_hidden) { ?>
      <td align="right">22,517</td>
      <?php } ?>
      <td align="right">21,797</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">21,797</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">100</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">1,08,699</td>
      <td align="right">124</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>14-05-2019</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>3</td>
      <td>T0019</td>
      <td>SANTHOSH KUMAR S, CHENTHITTA</td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right">0</td>
      <?php if($show_hidden) { ?>
      <td align="right">22,517</td>
      <?php } ?>
      <td align="right">21,797</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">21,797</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">100</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">1,08,699</td>
      <td align="right">124</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>14-05-2019</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>4</td>
      <td>T0019</td>
      <td>SANTHOSH KUMAR S, CHENTHITTA</td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right">0</td>
      <?php if($show_hidden) { ?>
      <td align="right">22,517</td>
      <?php } ?>
      <td align="right">21,797</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">21,797</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">100</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">1,08,699</td>
      <td align="right">124</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>14-05-2019</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>5</td>
      <td>T0019</td>
      <td>SANTHOSH KUMAR S, CHENTHITTA</td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right">0</td>
      <?php if($show_hidden) { ?>
      <td align="right">22,517</td>
      <?php } ?>
      <td align="right">21,797</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">21,797</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">21,797</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">21,797</td>
      <td align="right">100</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">1,08,699</td>
      <td align="right">124</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>14-05-2019</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <!--repeated-->
    
    <tr>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">Sub Total</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">10,95,965</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">12,720</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">4,55,019</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">4,31,453</td>
      <td align="right" style="color:#ff0000;font-weight:bold;background-color:#D9E1F2;border:1px solid #ecf0f5;">4,44,173</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">0</td>

      <?php if($show_hidden) { ?>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <?php } ?>

      <td style="color:#ff0000;font-weight:bold;" align="right"></td>
      <td style="color:#ff0000;font-weight:bold;" align="right">1,37,608</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">2,47,015</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">3,84,623</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">87</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">46,955</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">59,675</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">4,269</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">12,29,696</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">2,578</td>
      <td style="color:#ff0000;font-weight:bold;" align="right"></td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="color:#ff0000;font-weight:bold;">02. PETTAH UNNI R    PH: 9744567731</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php } ?>

      <td align="right">&nbsp;</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <?php } ?>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>6</td>
      <td>T0059</td>
      <td>SASIDHARAN N, PETTAH</td>
      <td align="right">-753</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,396</td>
      <?php } ?>
      <td align="right">0</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right">10,000</td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,000</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">28,698</td>
      <td align="right">61</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    
    <!--repeated-->
    <tr>
      <td>7</td>
      <td>T0059</td>
      <td>SASIDHARAN N, PETTAH</td>
      <td align="right">-753</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,396</td>
      <?php } ?>
      <td align="right">0</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right">10,000</td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,000</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">28,698</td>
      <td align="right">61</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>8</td>
      <td>T0059</td>
      <td>SASIDHARAN N, PETTAH</td>
      <td align="right">-753</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,396</td>
      <?php } ?>
      <td align="right">0</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right">10,000</td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,000</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">28,698</td>
      <td align="right">61</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>9</td>
      <td>T0059</td>
      <td>SASIDHARAN N, PETTAH</td>
      <td align="right">-753</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,396</td>
      <?php } ?>
      <td align="right">0</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right">10,000</td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,000</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">28,698</td>
      <td align="right">61</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <tr>
      <td>10</td>
      <td>T0059</td>
      <td>SASIDHARAN N, PETTAH</td>
      <td align="right">-753</td>
      <td align="right"></td>
      <td align="right"></td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,396</td>
      <?php } ?>
      <td align="right">0</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right"></td>
      <td align="right">10,000</td>
      <td align="right"></td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,000</td>
      <td align="right">0</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">0</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">0</td>
      <?php } ?>
      <td align="right">28,698</td>
      <td align="right">61</td>
      <td align="right"></td>
      <td></td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php } ?>
    </tr>
    <!--repeated-->
    
    <tr>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">Sub Total</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">10,57,784</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">8,281</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">5,45,045</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">4,51,450</td>
      <td align="right" style="color:#ff0000;font-weight:bold;background-color:#D9E1F2;border:1px solid #ecf0f5;">4,59,731</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">0</td>

      <?php if($show_hidden) { ?>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <?php } ?>

      <td style="color:#ff0000;font-weight:bold;" align="right"></td>
      <td style="color:#ff0000;font-weight:bold;" align="right">2,55,100</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">1,87,022</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">4,42,122</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">96</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">20,907</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">28,931</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">16,914</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">15,20,172</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">3,070</td>
      <td style="color:#ff0000;font-weight:bold;" align="right"></td>
      <?php if($show_settlement) { ?>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;">&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <?php } ?>
    </tr>
    <tr align="right">
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="left">TOTAL</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">28,25,605</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">2,87,952</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">8239180</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">72,63,502</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">75,51,074</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">2,06,764</td>

      <?php if($show_hidden) { ?>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <td align="right" style="color:#ff0000;font-weight:bold;"></td>
      <?php } ?>

      <td style="color:#ff0000;font-weight:bold;" align="right"></td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">72,63,502</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">96</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;color:#ff0000;font-weight:bold;">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php } ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color:#ff0000;font-weight:bold;" align="right">&nbsp;</td>
      <?php } ?>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td style="color: #FF0004;font-weight:bold;">SUMMARY</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>01. THAMPANOOR  (THAMPURU R P - ACM) PH : 9946103223</td>
      <td align="right">10,95,965</td>
      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">12,720</td>
      <?php if($show_hidden) { ?>
      <td align="right">10,00,000</td>
      <?php } ?>
      <td align="right">10,00,000</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right">10,00,000</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">10,00,000</td>
      <td align="right">10,00,000</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right">82</td>
      <td align="right">10,00,000</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,00,000</td>
      <?php } ?>
      <td align="right">10,00,000</td>
      <td align="right">3,000</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>02. PETTAH   UNNI R  PH: 9744567731</td>
      <td align="right">10,95,965</td>
      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">12,720</td>
      <?php if($show_hidden) { ?>
      <td align="right">10,00,000</td>
      <?php } ?>
      <td align="right">10,00,000</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right">10,00,000</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">10,00,000</td>
      <td align="right">10,00,000</td>
      <td align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right">82</td>
      <td align="right">10,00,000</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">10,00,000</td>
      <td align="right"></td>
      <?php if($show_hidden) { ?>
      <td align="right">10,00,000</td>
      <?php } ?>
      <td align="right">10,00,000</td>
      <td align="right">3,000</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td style="color: #FF0004;font-weight:bold;">TOTAL</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,95,965</td>
      <td style="color: #FF0004;font-weight:bold;" align="right"></td>
      <td style="color: #FF0004;font-weight:bold;" align="right">&nbsp;</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">12,720</td>
      <?php if($show_hidden) { ?>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <?php } ?>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <td align="right" style="background-color:#D9E1F2;border:1px solid #ecf0f5;color: #FF0004;font-weight:bold;">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>

      <?php if($show_hidden) { ?>
      <td align="right" style="color: #FF0004;font-weight:bold;"></td>
      <td align="right" style="color: #FF0004;font-weight:bold;"></td>
      <?php } ?>

      <td style="color: #FF0004;font-weight:bold;" align="right"></td>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">0</td>
      <td align="right" style="background-color:#C6E0B4;border:1px solid #ecf0f5;color: #FF0004;font-weight:bold;">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">82</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <td align="right" style="background-color:#F5B88F;border:1px solid #ecf0f5;color: #FF0004;font-weight:bold;">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right"></td>
      <?php if($show_hidden) { ?>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <?php } ?>
      <td style="color: #FF0004;font-weight:bold;" align="right">10,00,000</td>
      <td style="color: #FF0004;font-weight:bold;" align="right">3,000</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>

      <?php if($show_hidden) { ?>
      <td align="right"></td>
      <td align="right"></td>
      <?php } ?>

      <td align="right"></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <?php if($show_hidden) { ?>
      <td align="right">&nbsp;</td>
      <?php } ?>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <?php if($show_settlement) { ?>
      <td>&nbsp;</td>
      <?php } ?>
      <?php if($show_hidden) { ?>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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