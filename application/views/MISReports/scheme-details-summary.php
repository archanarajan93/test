<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Scheme-Details-Summary-".date("F-j-Y").".xls";
	header('Content-Type: application/force-download');
	header('Content-disposition: attachment; filename='.$FileName.'');
	header("Pragma: ");
	header("Cache-Control: ");
	echo $_REQUEST['tableData'];
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Scheme Details</title>
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
                <h1>Scheme Details Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Scheme Details Summary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">            
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table width="100%"  class="table table-results">
                            <thead>                                
                                <tr>
                                    <td colspan="18" style="color:#fff; background:#00a7c7; font-weight:bold;">
                                        Scheme Details Summary From 01-Jun-2019 to 28-Jun-2019 | Date Type: Canvassed Date | Report Type: Unitwise | Scheme/Sponsor: UNITY, SDS, BBS, GDSS
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Sl No.</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Unit</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">New</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Renewed</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Total</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">UNITY</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">SDS</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">BBS</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">GDSS</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Total</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Bill Amount</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Cash</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Cheque</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">PDC</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Dis Chq.</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Balance</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Institution Count</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>THIRUVANATHAPURAM</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">20</td>
                                    <td align="right">10</td>
                                    <td align="right">20</td>
                                    <td align="right">30</td>
                                    <td align="right">40</td>
                                    <td align="right">100</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>KOLLAM</td>
                                    <td align="right">20</td>
                                    <td align="right">10</td>
                                    <td align="right">30</td>
                                    <td align="right">30</td>
                                    <td align="right">20</td>
                                    <td align="right">30</td>
                                    <td align="right">40</td>
                                    <td align="right">120</td>
                                    <td align="right">4,500</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>ALAPPUZHA</td>
                                    <td align="right">20</td>
                                    <td align="right">30</td>
                                    <td align="right">50</td>
                                    <td align="right">20</td>
                                    <td align="right">50</td>
                                    <td align="right">20</td>
                                    <td align="right">30</td>
                                    <td align="right">120</td>
                                    <td align="right">4,500</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>PATHANAMTHITTA</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">20</td>
                                    <td align="right">10</td>
                                    <td align="right">30</td>
                                    <td align="right">30</td>
                                    <td align="right">70</td>
                                    <td align="right">140</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,250</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>KOTTAYAM</td>
                                    <td align="right">20</td>
                                    <td align="right">20</td>
                                    <td align="right">40</td>
                                    <td align="right">50</td>
                                    <td align="right">40</td>
                                    <td align="right">30</td>
                                    <td align="right">20</td>
                                    <td align="right">140</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>ERNAKULAM</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">20</td>
                                    <td align="right">10</td>
                                    <td align="right">10</td>
                                    <td align="right">30</td>
                                    <td align="right">30</td>
                                    <td align="right">80</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>THRISSUR</td>
                                    <td align="right">30</td>
                                    <td align="right">10</td>
                                    <td align="right">40</td>
                                    <td align="right">40</td>
                                    <td align="right">50</td>
                                    <td align="right">30</td>
                                    <td align="right">60</td>
                                    <td align="right">180</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="background:#cfcdcd; color:#000; font-weight:bold;">Grand Total</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">120</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">100</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">220</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">170</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">220</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">200</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">290</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;" align="right">880</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">1,62,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">9,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">2,250</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">22,500</td>
                                    <td style="background-color: #00a7c7; font-weight: bold; color:#FFF; width:1px;padding:0px !important;" class="no-sort">&nbsp;</td><!--Separator-->
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
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