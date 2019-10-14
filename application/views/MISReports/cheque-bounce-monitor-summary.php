<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Cheque-Bounce-Monitor-Summary-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Cheque Bounce Monitor Summary</title>
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
                <h1>Cheque Bounce Monitor Summary</h1>
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
                        <table width="100%" class="table table-results" border="1">
                            <thead>
                                <tr>
                                    <td bgcolor="#00a7c7" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="20"><strong>Cheque Bounce Monitor Summary | Billing Period: 01-Jun-19 to 30-Jun-19 | Product Group: DAILY | Report Type: Unitwise | Months: 5 | Report Mode: Compact</strong></td>
                                </tr>
                                <tr>
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
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Current</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Target</strong></td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;" scope="col">June-19</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-right:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-left:none !important;" scope="col">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Collectable</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Cash</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Cheque</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>PDC</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Total Collection</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Short</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Short</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>THIRUVANANTHAPURAM</td>
                                    <td align="right" style="background:#ffffff;font-weight:200;text-align:right;">45,220</td>
                                    <td align="right">10</td>
                                    <td align="right">54,264</td>
                                    <td align="right">12</td>
                                    <td align="right">14,250</td>
                                    <td align="right">5</td>
                                    <td align="right">14,050</td>
                                    <td align="right">3</td>
                                    <td align="right">99,000</td>
                                    <td align="right">32</td>
                                    <td align="right">1,53,000</td>
                                    <td align="right">1,00,000</td>
                                    <td align="right">53,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">1,53,000</td>
                                    <td align="right">10</td>
                                    <td align="right">15</td>
                                    <td align="right">1,50,000</td>
                                    <td align="right">10</td>
                                </tr>
                                <tr>
                                    <td>KOLLAM</td>
                                    <td align="right" style="background:#ffffff;font-weight:200;text-align:right;">49,742</td>
                                    <td align="right">11</td>
                                    <td align="right">45,562</td>
                                    <td align="right">5</td>
                                    <td align="right">74,000</td>
                                    <td align="right">4</td>
                                    <td align="right">15,000</td>
                                    <td align="right">17</td>
                                    <td align="right">85,500</td>
                                    <td align="right">7</td>
                                    <td align="right">2,50,000</td>
                                    <td align="right">2,50,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,50,000</td>
                                    <td align="right">5</td>
                                    <td align="right">25</td>
                                    <td align="right">2,50,000</td>
                                    <td align="right">5</td>
                                </tr>
                                <tr>
                                    <td>ALAPUZHA</td>
                                    <td align="right">36,176</td>
                                    <td align="right">8</td>
                                    <td align="right">32,256</td>
                                    <td align="right">7</td>
                                    <td align="right">54,000</td>
                                    <td align="right">10</td>
                                    <td align="right">15,600</td>
                                    <td align="right">4</td>
                                    <td align="right">74,000</td>
                                    <td align="right">18</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">5</td>
                                    <td align="right">10</td>
                                    <td align="right">4,00,000</td>
                                    <td align="right">20</td>
                                </tr>
                                <tr>
                                    <td>PATHANAMTHITTA</td>
                                    <td align="right">18,088</td>
                                    <td align="right">4</td>
                                    <td align="right">11,256</td>
                                    <td align="right">8</td>
                                    <td align="right">22,000</td>
                                    <td align="right">7</td>
                                    <td align="right">18,088</td>
                                    <td align="right">4</td>
                                    <td align="right">14,000</td>
                                    <td align="right">15</td>
                                    <td align="right">4,00,000</td>
                                    <td align="right">4,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,00,000</td>
                                    <td align="right">15</td>
                                    <td align="right">20</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">15</td>
                                </tr>
                                <tr>
                                    <td>ERANAKULAM</td>
                                    <td align="right">99,484</td>
                                    <td align="right">22</td>
                                    <td align="right">41,000</td>
                                    <td align="right">4</td>
                                    <td align="right">11,000</td>
                                    <td align="right">5</td>
                                    <td align="right">56,000</td>
                                    <td align="right">3</td>
                                    <td align="right">25,000</td>
                                    <td align="right">5</td>
                                    <td align="right">5,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">5,00,000</td>
                                    <td align="right">5,00,000</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">2,50,000</td>
                                    <td align="right">30</td>
                                </tr>
                                <tr>
                                    <td>THRISSUR</td>
                                    <td align="right">54,264</td>
                                    <td align="right">12</td>
                                    <td align="right">82,000</td>
                                    <td align="right">11</td>
                                    <td align="right">74,050</td>
                                    <td align="right">15</td>
                                    <td align="right">84,000</td>
                                    <td align="right">11</td>
                                    <td align="right">35,000</td>
                                    <td align="right">7</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">20</td>
                                    <td align="right">25</td>
                                    <td align="right">1,50,000</td>
                                    <td align="right">15</td>
                                </tr>
                                <tr>
                                    <td>MALAPPURAM</td>
                                    <td align="right">13,566</td>
                                    <td align="right">3</td>
                                    <td align="right">72,356</td>
                                    <td align="right">13</td>
                                    <td align="right">88,900</td>
                                    <td align="right">2</td>
                                    <td align="right">54,264</td>
                                    <td align="right">12</td>
                                    <td align="right">20,000</td>
                                    <td align="right">25</td>
                                    <td align="right">1,00,000</td>
                                    <td align="right">1,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">1,00,000</td>
                                    <td align="right">15</td>
                                    <td align="right">30</td>
                                    <td align="right">3,50,000</td>
                                    <td align="right">10</td>
                                </tr>
                                <tr>
                                    <td>KOZHIKODE</td>
                                    <td align="right">54,264</td>
                                    <td align="right">12</td>
                                    <td align="right">15,000</td>
                                    <td align="right">5</td>
                                    <td align="right">49,742</td>
                                    <td align="right">11</td>
                                    <td align="right">54,000</td>
                                    <td align="right">2</td>
                                    <td align="right">84,000</td>
                                    <td align="right">8</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,00,000</td>
                                    <td align="right">30</td>
                                    <td align="right">30</td>
                                    <td align="right">4,00,000</td>
                                    <td align="right">5</td>
                                </tr>
                                <tr>
                                    <td>KANNUR</td>
                                    <td align="right">49,742</td>
                                    <td align="right">11</td>
                                    <td align="right">80,000</td>
                                    <td align="right">4</td>
                                    <td align="right">18,088</td>
                                    <td align="right">10</td>
                                    <td align="right">14,000</td>
                                    <td align="right">5</td>
                                    <td align="right">94,000</td>
                                    <td align="right">13</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">3,00,000</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">5,00,000</td>
                                    <td align="right">25</td>
                                </tr>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Total</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">6,89,856</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">98</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">12,56,250</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">69</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">5,54,992</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">69</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">3,25,202</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">61</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">7,45,500</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">111</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">23,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">16,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">2,53,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">5,00,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">23,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">120</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">195</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">29,50,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">135</td>
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
        var page = 'CHEQUE-BOUNCE-MONITOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>