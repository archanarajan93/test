<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Plan-For-Copies-Summary-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    //$spreadsheet->getActiveSheet()->setTitle("123");
    foreach(range('A','Z') as $columnID) {
        $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    //$spreadsheet->getActiveSheet()->unmergeCells('A1:M1');
    //$spreadsheet->getActiveSheet()->getColumnDimension('A1')->setWidth(30);
    //$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
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
    <title>Circulation | Plan For Copies Summary</title>
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
                <h1>Plan For Copies Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Plan For Copies</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">            
                <div class="box">                    
                    <div class="box-body table-responsive">
                    <table width="100%" class="table table-results" border="1">
  <thead>
    <tr>
      <td colspan="13" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
        Plan For Copies Summary from 01-July-2019 to 05-July-2019
        | Unit: Thiruvananthapuram&nbsp;|&nbsp;
        Work Type: Promoter, Bureau, Internal Work&nbsp;|&nbsp;Team Member: Pradeep,Manoj Kumar A S, Anju&nbsp;|&nbsp;
        GD News: Yes&nbsp;|&nbsp;
        Report Type: ACM Wise
      </td>
      <!--<td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>
        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #cfcdcd;">&nbsp;</td>-->
    </tr>
    <tr>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" scope="col">&nbsp;</td>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">01-July-2019</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">02-July-2019</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">03-July-2019</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">04-July-2019</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
      <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">05-July-2019</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">Total</td>
        <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col"></td>
    </tr>
    <tr>
      <td style="color:#000000;background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
      <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
        <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
        <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>ANILKUMAR</td>
      <td align="right">5</td>
      <td align="right">5</td>
      <td align="right">2</td>
      <td align="right">6</td>
      <td align="right">4</td>
      <td align="right">9</td>
      <td align="right">5</td>
      <td align="right">3</td>
      <td align="right">9</td>
      <td align="right">10</td>
        <td align="right">25</td>
        <td align="right">33</td>
    </tr>
    <tr>
      <td>PRADEEP</td>
      <td align="right">2</td>
      <td align="right">5</td>
      <td align="right">3</td>
      <td align="right">6</td>
      <td align="right">1</td>
      <td align="right">4</td>
      <td align="right">2</td>
      <td align="right">2</td>
      <td align="right">1</td>
      <td align="right">1</td>
        <td align="right">9</td>
        <td align="right">19</td>
    </tr>
    <tr>
      <td>RAHUL</td>
      <td align="right">8</td>
      <td align="right">9</td>
      <td align="right">2</td>
      <td align="right">4</td>
      <td align="right">3</td>
      <td align="right">6</td>
      <td align="right">1</td>
      <td align="right">5</td>
      <td align="right">2</td>
      <td align="right">5</td>
        <td align="right">16</td>
        <td align="right">29</td>
    </tr>
    <tr>
      <td>SAJITH</td>
      <td align="right">7</td>
      <td align="right">9</td>
      <td align="right">9</td>
      <td align="right">9</td>
      <td align="right">1</td>
      <td align="right">2</td>
      <td align="right">7</td>
      <td align="right">6</td>
      <td align="right">6</td>
      <td align="right">4</td>
        <td align="right">30</td>
        <td align="right">30</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">TOTAL</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">22</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">28</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">16</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">25</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">9</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">21</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">15</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">16</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">18</td>
      <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">20</td>
        <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">80</td>
        <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">111</td>
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
        var page = 'PLAN-COPIES';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>