<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Cumulative-Receipt-Summary-Unitwise-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Cumulative Receipt Summary Unitwise</title>
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
                <h1>Cumulative Receipt Summary Unitwise</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Cumulative Receipt Summary Unitwise</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <table width="100%" class="table table-results" border="1">
                        <thead>
                            <tr>
                              <td colspan="25" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
                                Cumulative Receipt Summary - Receipt Date 01-May-2019 to 30-May-2019 |
                                Report Type: Unitwise |
                                Units: THIRUVANANTHAPURAM, KOLLAM, ALAPUZHA
                              </td>
                            </tr>
                            <tr>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">THIRUVANANTHAPURAM</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">KOLLAM</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">ALAPUZHA</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-right-color:#cfcdcd;">TOTAL</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;border-right-color:#cfcdcd;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;border-left-color:#cfcdcd;">&nbsp;</td>
                            </tr>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Date</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Chq. Bounce</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cash</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cheque</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Net Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cumulative</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Agent Count</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Chq. Bounce</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cash</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cheque</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Net Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cumulartive</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Agent Count</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Chq. Bounce</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cash</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cheque</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Net Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cumulative</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Agent Count</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Chq. Bounce</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cash</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cheque</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Net Coll</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Cumulative</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Agent Count</td>
                            </tr>
                        </thead>
                        <tbody>      
                          <?php for($i = 1; $i<=30; $i++) { ?>                                                  
                          <tr>
                             <td class="drill-down" align="right"><?php echo $i; ?></td>
                             <td class="drill-down" align="right">55,125</td>
                             <td class="drill-down" align="right">36,789</td>
                             <td class="drill-down" align="right">54,101</td>
                             <td class="drill-down" align="right">89,400</td>
                             <td class="drill-down" align="right">58,120</td>
                             <td class="drill-down" align="right">5</td>
                             <td class="drill-down" align="right">98,412</td>
                             <td class="drill-down" align="right">99,000</td>
                             <td class="drill-down" align="right">41,102</td>
                             <td class="drill-down" align="right">32,410</td>
                             <td class="drill-down" align="right">11,212</td>
                             <td class="drill-down" align="right">10</td>
                             <td class="drill-down" align="right">89,410</td>
                             <td class="drill-down" align="right">85,100</td>
                             <td class="drill-down" align="right">12,011</td>
                             <td class="drill-down" align="right">63,100</td>
                             <td class="drill-down" align="right">12,566</td>
                             <td class="drill-down" align="right">6</td>
                             <td class="drill-down" align="right">99,100</td>
                             <td class="drill-down" align="right">89,123</td>
                             <td class="drill-down" align="right">45,100</td>
                             <td class="drill-down" align="right">98,856</td>
                             <td class="drill-down" align="right">49,100</td>
                             <td class="drill-down" align="right">21</td>
                           </tr> 
                           <?php } ?>                           
                        </tbody>
                          <tfoot>
                            <tr>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Total</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">11,12,569</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">99,100</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,123</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">25</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,123</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">11</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,123</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">10</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">89,500</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98,123</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">12,56,456</td>
                              <td class="drill-down" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">30</td>
                            </tr>
                            <tr>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Coll%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">95%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Coll%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">95%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Coll%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">95%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Coll%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">95%</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">&nbsp;</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Target</td>
                              <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">98</td>
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

            <form class="hide" id="crs-unitwise-drilldown-form" method="post" target="_blank" action="<?php echo base_url('MISReports/CollectionTargetDetailed'); ?>">
                <input type="text" value="0" name="plus_minus" />
            </form>

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
        var page = 'CUMULATIVE-RECEIPT-SUMMARY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>