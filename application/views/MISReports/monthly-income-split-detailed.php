<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Monthly-Income-PL-Split-".date("F-j-Y").".xls";
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
    <title>Circulation | Monthly P & L Income Split</title>
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
                <h1>Monthly P & L Income Split</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Monthly P & L Income Split</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                    <table width="100%" border="1"  class="table table-results">
                      <thead>
                        <tr>
                            <td style="color:#FFFFFF; background:#00a7c7;" colspan="4"><strong>Monthly P & L Income Split  FROM MAY 2019 TO JUN2019 | Report Type: Monthwise | Unit: THIRUVANANTHAPURAM</strong></td>
                        </tr>
                        <tr>
                            <td style="color:#FFFFFF; background:#00a7c7;"><strong>Description</strong></td>
                            <td style="color:#FFFFFF; background:#00a7c7;" align="right"><strong>May 2019</strong></td>
                            <td style="color:#FFFFFF; background:#00a7c7;" align="right"><strong>Jun 2019</strong></td>
                            <td style="color:#FFFFFF; background:#00a7c7;" align="right"><strong>Total</strong></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="color:#F33">SALES DAILY</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>DAILY RECEIPTS</td>
                          <td align="right">1,23,467</td>
                          <td align="right">5,96,566</td>
                          <td align="right">6,89,555</td>
                        </tr>
                        <tr>
                          <td>LESS SPONS RECEIPT</td>
                          <td align="right">9,565</td>
                          <td align="right">98,456</td>
                          <td align="right">1,56,000</td>
                        </tr>
                        <tr>
                          <td>LESS EK RECEIPT</td>
                          <td align="right">-72,625</td>
                          <td align="right">-52,366</td>
                          <td align="right">-1,24,991</td>
                        </tr>
                        <tr>
                          <td>LESS CHQ BOUNCE</td>
                          <td align="right">-2,81,917</td>
                          <td align="right">62,565</td>
                          <td align="right">9,45,100</td>
                        </tr>
                        <tr>
                          <td>ADD SPONS CHQ BOUNCE</td>
                          <td align="right">0 </td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                        </tr>
                        <tr>
                          <td>ADD EK CHQ VOUNCE</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                        </tr>
                        <tr>
                          <td style="color:#900">Total</td>
                          <td align="right" style="color:#900">23,86,260</td>
                          <td align="right" style="color:#900">31,88,439</td>
                          <td align="right" style="color:#900">55,74,699</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="color:#F33">BOOKS PERIODICALS & SPONSOR</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>RECEIPTS</td>
                          <td align="right">81,698</td>
                          <td align="right">91,666</td>
                          <td align="right">1,73,364</td>
                        </tr>
                        <tr>
                          <td>LESS CHQ BOUNCE</td>
                          <td align="right">-1,238</td>
                          <td align="right">-1,300</td>
                          <td align="right">-2,538</td>
                        </tr>
                        <tr>
                          <td>LESS SPONS CHQ BOUNCE</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                        </tr>
                        <tr>
                          <td style="color:#900">Total</td>
                          <td align="right" style="color:#900">80,460</td>
                          <td align="right" style="color:#900">90,366</td>
                          <td align="right" style="color:#900">1,70,826</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="color:#F33">SCHEMES</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>SCHEME RECEIPTS - DAILY</td>
                          <td align="right">72,000</td>
                          <td align="right">72,000</td>
                          <td align="right">1,44,000</td>
                        </tr>
                        <tr>
                          <td>SCHEME RECEIPTS - PERIODICALS</td>
                          <td align="right">6,320</td>
                          <td align="right">6,320</td>
                          <td align="right">12,640</td>
                        </tr>
                        <tr>
                          <td>SCHEME CHQ BOUNCE</td>
                          <td align="right">-44,250</td>
                          <td align="right">-44,250</td>
                          <td align="right">-88,500</td>
                        </tr>
                        <tr>
                          <td>ADD EK RECEIPT</td>
                          <td align="right">72,625</td>
                          <td align="right">72,625</td>
                          <td align="right">1,45,250</td>
                        </tr>
                        <tr>
                          <td>LESS EK CHQ BOUNCE</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                        </tr>
                        <tr>
                          <td style="color:#900">Total</td>
                          <td align="right" style="color:#900">1,06,695</td>
                          <td align="right" style="color:#900">1,06,695</td>
                          <td align="right" style="color:#900">2,13,390</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td style="color:#F33">ANNUAL BOOKS</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                          <td align="right">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>RECEIPTS</td>
                          <td align="right">72,000</td>
                          <td align="right">6,320</td>
                          <td align="right">1,44,000</td>
                        </tr>
                        <tr>
                          <td style="color:#900">Total</td>
                          <td align="right" style="color:#900">1,06,695</td>
                          <td align="right" style="color:#900">1,06,695</td>
                          <td align="right" style="color:#900">2,13,390</td>
                        </tr>
                        <tr>
                          <td style="color:#900">&nbsp;</td>
                          <td align="right" style="color:#900">&nbsp;</td>
                          <td align="right" style="color:#900">&nbsp;</td>
                          <td align="right" style="color:#900">&nbsp;</td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCC" style="color:#900"><strong>Grand Total</strong></td>
                          <td align="right" bgcolor="#CCC" style="color:#900"><strong>9,85,456</strong></td>
                          <td align="right" bgcolor="#CCC" style="color:#900"><strong>8,26,456</strong></td>
                          <td align="right" bgcolor="#CCC" style="color:#900"><strong>9,89,900</strong></td>
                        </tr>
                      </tbody>
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
        var page = 'MONTH-INCOME-SPLIT';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>