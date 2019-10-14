<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Copy-Amendment-Chart-Summary-".date("F-j-Y").".xlsx";
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
$plus_minus = (int)$_POST['plus_minus'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Copy Amendment Chart Summary</title>
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
                <h1>Copy Amendment Chart Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Copy Amendment Chart Summary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
<table width="100%" class="table table-results" border="1">
  <thead>
    <tr>
        <td colspan="12" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">Copy Amendment Chart Summary From  01-Jul-2019 to 30-Jul-2019 | Report Type: Unitwise | Amendment Types: SUBSCRIBER SALE, DIRECT SALE, STALL SALES | Sale Type: Gurudeepam, Bureau, Internal Work, Scheme to Sale </td>
    </tr>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Sl.No</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Unit</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">01-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">02-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">03-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">04-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">05-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">06-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">07-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">08-07-19</td>
      <td align="right" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Dropped</td>
    </tr>
  </thead>
  <tbody>
    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>1</td>
      <td>THIRUVANANTHAPURAM</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">933</td>
      <td align="right" class="drill-down">3</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">65</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">5</td>
      <td align="right" class="drill-down">7</td>
      <td align="right" class="drill-down">863</td>
      <td align="right" class="drill-down">1,876</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "1" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "THIRUVANANTHAPURAM" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">5</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">3</td>
      <td align="right" class="drill-down">13</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>2</td>
      <td>KOLLAM</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">502</td>
      <td align="right" class="drill-down">4</td>
      <td align="right" class="drill-down">7</td>
      <td align="right" class="drill-down">3</td>
      <td align="right" class="drill-down">18</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">533</td>
      <td align="right" class="drill-down">1,069</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "2" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "KOLLAM" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">4</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">12</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>3</td>
      <td>ALAPUZHA</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">309</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">12</td>
      <td align="right" class="drill-down">5</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">8</td>
      <td align="right" class="drill-down">301</td>
      <td align="right" class="drill-down">638</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "3" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "ALAPUZHA" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">4</td>
      <td align="right" class="drill-down">10</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>4</td>
      <td>PATHANAMTHITTA</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">46</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">21</td>
      <td align="right" class="drill-down">46</td>
      <td align="right" class="drill-down">113</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "4" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "PATHANAMTHITTA" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">3</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>5</td>
      <td>KOTTAYAM</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">258</td>
      <td align="right" class="drill-down">4</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">6</td>
      <td align="right" class="drill-down">196</td>
      <td align="right" class="drill-down">464</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "5" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "KOTTAYAM" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">6</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>6</td>
      <td>ERANAKULAM</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">95</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">12</td>
      <td align="right" class="drill-down">95</td>
      <td align="right" class="drill-down">202</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "6" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "ERANAKULAM" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">5</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">7</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>7</td>
      <td>TRISSUR</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">27</td>
      <td align="right" class="drill-down">14</td>
      <td align="right" class="drill-down">8</td>
      <td align="right" class="drill-down">21</td>
      <td align="right" class="drill-down">6</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">31</td>
      <td align="right" class="drill-down">108</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "7" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "TRISSUR" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">7</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>8</td>
      <td>MALAPPURAM</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">22</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">8</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">22</td>
      <td align="right" class="drill-down">52</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "8" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "MALAPPURAM" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">2</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>9</td>
      <td>KOZHIKODE</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">105</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">21</td>
      <td align="right" class="drill-down">2</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">128</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "9" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "KOZHIKODE" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">3</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 2) { ?>
    <tr>
      <td>10</td>
      <td>KANNUR</td>
      <td class="drill-down">PLUS</td>
      <td align="right" class="drill-down">4</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">5</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">17</td>
      <td align="right" class="drill-down">16</td>
      <td align="right" class="drill-down">43</td>
    </tr>
    <?php } ?>

    <?php if($plus_minus == 1 || $plus_minus == 3) { ?>
    <tr>
      <td><?php echo $plus_minus == 3 ? "10" : ""; ?></td>
      <td><?php echo $plus_minus == 3 ? "KANNUR" : ""; ?></td>
      <td class="drill-down">MINUS</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">0</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">&nbsp;</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">1</td>
      <td align="right" class="drill-down">4</td>
    </tr> 
    <?php } ?> 
         
  </tbody>
  <tfoot>
    <tr>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Total</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">2,301</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">26</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">56</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">97</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">29</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">10</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">71</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">2,103</td>
      <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">4,693</td>
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

        <form class="hide" id="copy-drop-detailed-form" method="post" target="_blank" action="<?php echo base_url('MISReports/CopyDropChartDetailed'); ?>">
            <input type="text" value="<?php echo $plus_minus; ?>" name="plus_minus" />
        </form>

        <!-- /.content-wrapper -->
       <?php 
       $this->load->view('inc/footer');
       $this->load->view('inc/help');     
       ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'COPY-DROP-CHART';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>