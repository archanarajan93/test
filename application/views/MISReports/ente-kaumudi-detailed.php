<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Ente-Kaumudi-Detailed-".date("F-j-Y").".xlsx";
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | EnteKaumudi Detailed</title>
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
                <h1>EnteKaumudi Details</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Ente Kaumudi Details</li>
                </ol>
            </section>            
            <!-- Main content -->
            <section class="content">            
                <div class="box">                    
                    <div class="box-body table-responsive">                       
                        <table width="100%" class="table table-results" border="1">
                          <thead>
                            <tr>
                                <td  style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;" colspan="9">Ente Kaumudi Details From 01-Jun-2019 to 28-Jun-2019 | Unit: THIRUVANANTHAPURAM</td>
                            </tr>
                            <tr>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Sl No</td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Client Name</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Schools</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copies</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Deal Amount</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Cash</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Cheque</td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Balance</td>
                              <td  style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Canvassed By</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>GEETHA MADHU, MADHU GEETHAM ,VAZHAMUTTAM</td>
                              <td align="right"> 1 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/EnteKaumudySchools'); ?>"> <i class="fa fa-external-link" aria-hidden="true"></i> </a></td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>SISUPALAN, SAGARA BEACH RESORT</td>
                              <td align="right"> 1 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/EnteKaumudySchools'); ?>"> <i class="fa fa-external-link" aria-hidden="true"></i> </a></td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>3</td>
                              <td>PRASAD, SAIGROUP , POONKULAM</td>
                              <td align="right"> 1 <a class="remove_on_excel" target="_blank" href="<?php echo base_url('MISReports/EnteKaumudySchools'); ?>"> <i class="fa fa-external-link" aria-hidden="true"></i> </a></td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>4</td>
                              <td>KAIRALI JEWELLERS, MAITHANAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>RAHUL R S</td>
                            </tr>
                            <tr>
                              <td>5</td>
                              <td>DR CHANRAKUMAR, BHARATH HOSPITAL, MUDAPURAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>BEENA SAJITHAN</td>
                            </tr>
                            <tr>
                              <td>6</td>
                              <td>UDAYARAJ, LAGOONA BEACH RESORT PACHALOOR</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>7</td>
                              <td>KOVALAM T N SURESH, KOVALAM S N D P UNION PRESIDENT</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>8</td>
                              <td>SUDHEESH KUMAR G, HOTEL SEAFACE, KOVALAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>9</td>
                              <td>KOTTUKAL KRISHNAKUMAR, N S S THALUK UNION PRESIDENT</td>
                              <td align="right">3</td>
                              <td align="right">40</td>
                              <td align="right">35000</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">35000</td>
                              <td>JINAN A P</td>
                            </tr>
                            <tr>
                              <td>10</td>
                              <td>SHINE J, GANGA, PARAKONAM , THEMPAMUTTOM BALARAMAPURAM</td>
                              <td align="right">2</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>PRADEEP V</td>
                            </tr>
                            <tr>
                              <td>11</td>
                              <td>SREEJITH, MELAMCODE</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>12</td>
                              <td>ANILKUMAR, JAYARAM BAKERS, MEDICAL COLLEGE</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>13</td>
                              <td>SANTHOSH, CHAIN COMPUTERS ATTINGAL</td>
                              <td align="right">1</td>
                              <td align="right">5</td>
                              <td align="right">4375</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">4375</td>
                              <td>VIJAYAN PALAZHI</td>
                            </tr>
                            <tr>
                              <td>14</td>
                              <td>DR BABU, BAVA HOSPITAL, AVANAVANCHEERY , ATTINGAL</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>VIJAYAN PALAZHI</td>
                            </tr>
                            <tr>
                              <td>15</td>
                              <td>KOTTAKKAL KRISHNAKUMAR, NSS TALUK UNION PRESIDENT</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SAJEEV GOPALAN</td>
                            </tr>
                            <tr>
                              <td>16</td>
                              <td>SHINE J, GANGA PARAKONAM, THEMPAMUTTOM, BALARAMAPURAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>CHANDRAN T S</td>
                            </tr>
                            <tr>
                              <td>17</td>
                              <td>POONTHOPPIL PURUSHOTHAMAN, KARIKKAKAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>18</td>
                              <td>BABY MATHEW, SOMATHEERAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>19</td>
                              <td>BABY MATHEW, SOMATHEERAM</td>
                              <td align="right">4</td>
                              <td align="right">20</td>
                              <td align="right">17500</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td align="right">17500</td>
                              <td>SHAJIMON C</td>
                            </tr>
                            <tr>
                              <td>20</td>
                              <td>ADV SALIM KHAN, SREEKARIYAM</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>SURESH BABU P</td>
                            </tr>
                            <tr>
                              <td>21</td>
                              <td>KRITHIDAS, CS TRADERS AND ELECTRICALS NALUMUKKU PERUMKUZHI</td>
                              <td align="right">4</td>
                              <td align="right">30</td>
                              <td align="right">26250</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">17500</td>
                              <td>JIJU S</td>
                            </tr>
                            <tr>
                              <td>22</td>
                              <td>BABURAJ K, PERAYAM</td>
                              <td align="right">1</td>
                              <td align="right">3</td>
                              <td align="right">2625</td>
                              <td align="right">2625</td>
                              <td align="right"></td>
                              <td align="right"></td>
                              <td>BHUVANENDRAN S</td>
                            </tr>
                            <tr>
                              <td>23</td>
                              <td>SOMAKUMAR N, S VIHAR, MANAPPURAM, MALAYINKEEZHU</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>CHANDRAN T S</td>
                            </tr>
                            <tr>
                              <td>24</td>
                              <td>TRAVANCORE METALS, MYLOM CHERIYAKONNI</td>
                              <td align="right">1</td>
                              <td align="right">10</td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td align="right">8,750</td>
                              <td align="right"></td>
                              <td>PRADEEP V</td>
                            </tr>
                            <tr>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;">Grand Total</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">33</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">288</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">2,52,000</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">20,125</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">52,500</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;" align="right">1,79,375</td>
                              <td style="background:#cfcdcd; color:#000000; font-weight:bold;">&nbsp;</td>
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
        var page = 'ENTE-KAUMUDI';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>