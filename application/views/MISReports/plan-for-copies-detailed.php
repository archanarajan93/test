<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Plan-For-Copies-Details-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Plan For Copies Details</title>
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
                <h1>Plan For Copies Details</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Plan For Copies Details</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table width="100%" class="table table-results" border="1">
                            <thead>
                                <tr>
                                    <td colspan="19" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
                                        Plan For Copies Details from 01-July-2019 to 05-July-2019 | 
                                        Unit: Thiruvananthapuram&nbsp;|&nbsp;
                                        Work Type: Promoter, Bureau, Internal Work&nbsp;|&nbsp;
                                        GD News: Yes&nbsp;|&nbsp;
                                        Report Type: ACM Wise
                                    </td>
                                </tr>
                                <tr>
                                    <td width="1%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Sl No.</td>
                                    <td width="4%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Date</td>
                                    <td width="6%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Team Members</td>
                                    <td width="3%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Region</td>
                                    <td width="3%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Work Type</td>
                                    <td width="3%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">ACM</td>
                                    <td width="3%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bureau</td>
                                    <td width="4%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Res Assoc / Shakha </td>
                                    <td width="5%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Wellwisher</td>
                                    <td width="17%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Planned Agents</td>
                                    <td width="3%" align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Target</td>
                                    <td width="3%" align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Result</td>
                                    <td width="4%" align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Rejected</td>
                                    <td width="3%" align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Approved</td>
                                    <td width="3%" align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Billed</td>
                                    <td width="2%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">GD News</td>
                                    <td width="5%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Comment</td>
                                    <td width="22%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Actual Agents</td>
                                    <td width="6%" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Missed Agents</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>01-July-2019</td>
                                    <td>VISHNU,VIPIN</td>
                                    <td>CHZ-1</td>
                                    <td>PMD</td>
                                    <td>SAJITH</td>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">SAJITH S, POOVANPARA -1 , ANILKUMAR A P, MUTTAPALAM -1 , <a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1 </a>, RAJEESH R, THEVARNADA -1 , BABU M, PALLIMUKKU -2.</td>
                                    <td align="right">10</td>
                                    <td align="right" style="color:#4094e6" onclick="getDailyCanvassedReport()">6</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>YES</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">SAJITH S, POOVANPARA -1 , ANILKUMAR A P, MUTTAPALAM -1 , <a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a> , RAJEESH R, THEVARNADA -1 , BABU M, PALLIMUKKU -2.</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">SAJITH S POOVANPARA -1 , ANILKUMAR A P MUTTAPALAM -1,<a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>02-July-2019</td>
                                    <td>VISHNU,VIPIN</td>
                                    <td>CHZ-1</td>
                                    <td>PMD</td>
                                    <td>SAJITH</td>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">VIJAYAN,CHAKKUVILAKAM</td>
                                    <td align="right">6</td>
                                    <td align="right" style="color:#4094e6" onclick="getDailyCanvassedReport()">5</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>YES</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">VIJAYAN,CHAKKUVILAKAM</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>03-July-2019</td>
                                    <td>VISHNU</td>
                                    <td>CHZ-1</td>
                                    <td>PMD</td>
                                    <td>SAJITH</td>
                                    <td></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">BINU KUMAR R, VELLALOOR - 1 , SUDARSANAN  S, NEERMANKADVU,MITHRUMALA -1 ,<a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a></td>
                                    <td align="right">10</td>
                                    <td align="right" style="color:#4094e6" onclick="getDailyCanvassedReport()">3</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>YES</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">BINU KUMAR R, VELLALOOR - 1 , SUDARSANAN  S, NEERMANKADVU,MITHRUMALA -1 , <a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a></td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()"><a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>04-July-2019</td>
                                    <td>VISHNU</td>
                                    <td>CHZ-1</td>
                                    <td>BUREAU</td>
                                    <td>SAJITH</td>
                                    <td>KILIMANOOR</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">AKHIL.A.S, THATTATHUMALA - 1 .</td>
                                    <td align="right"></td>
                                    <td align="right" style="color:#4094e6" onclick="getDailyCanvassedReport()">1</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>YES</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">BINU KUMAR R, VELLALOOR - 1 , SUDARSANAN  S, NEERMANKADVU,MITHRUMALA -1 , <a style="background:#fce875;color:#fd0202;">GIRIJA KUMARI, GANDHISMARAKAM CHIRAYINKI -1</a></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>05-July-2019</td>
                                    <td>VIPIN</td>
                                    <td>CHZ-1</td>
                                    <td>BUREAU</td>
                                    <td>SAJITH</td>
                                    <td>CHIRAYINKEEZHU</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">ANILKUMAR A P, MUTTAPALAM - 5 , SUNIL KUMAR. N, MANCHADIMOODU - SARKKARA -3</td>
                                    <td align="right">6</td>
                                    <td align="right" style="color:#4094e6" onclick="getDailyCanvassedReport()">8</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>YES</td>
                                    <td>&nbsp;</td>
                                    <td style="color:#4094e6" onclick="getCollTargetReport()">ANILKUMAR A P, MUTTAPALAM - 5 , SUNIL KUMAR. N, MANCHADIMOODU - SARKKARA -3</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Total</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">32</td>
                                    <td align="right" style="background:#cfcdcd; color:#4094e6; font-weight:bold; border:1px solid #ecf0f5;" onclick="getDailyCanvassedReport()">23</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
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
                <form method="post" action="<?php echo base_url('MISReports/CollectionTargetDetailed');?>" target="_blank" id="colltrgt_form">
                    <input type="hidden"/>
                </form>
                <form method="post" action="<?php echo base_url('MISReports/DailyCanvassedCopiesDetails');?>" target="_blank" id="dailycanv_form">
                    <input type="hidden" />
                </form>
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
        function getCollTargetReport() {
            $("#colltrgt_form").submit();
        }
        function getDailyCanvassedReport() {
            $("#dailycanv_form").submit();
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>