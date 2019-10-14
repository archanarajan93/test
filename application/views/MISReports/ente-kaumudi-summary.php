<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Ente-Kaumudi-Summary-".date("F-j-Y").".xls";
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
    <title>Circulation | EnteKaumudi Summary</title>
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
                <h1>EnteKaumudi Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Ente Kaumudi Summary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                    <table width="100%" class="table table-results" border="1">
                      <thead>
                        <tr>
                          <td colspan="9">Ente Kaumudi Summary from 01-Jun-2019 to 28-Jun-2019</td>
                        </tr>
                        <tr>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF">Sl No</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF">Unit Name</td>
                          <td align="right" bgcolor="#00a7c7" style="color: #FFFFFF">Count</td>
                          <td align="right" bgcolor="#00a7c7" style="color: #FFFFFF">Copies</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF" align="right">Deal Amount</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF" align="right">Cash</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF" align="right">Cheque</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF" align="right">Cheque Bounce</td>
                          <td bgcolor="#00a7c7" style="color: #FFFFFF" align="right">Balance</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>THIRUVANANTHAPURAM</td>
                          <td align="right">33</td>
                          <td align="right">288</td>
                          <td align="right">2,91,375</td>
                          <td align="right">20,125</td>
                          <td align="right">52,500</td>
                          <td align="right">0</td>
                          <td align="right">2,18,750</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>KOLLAM</td>
                          <td align="right">12</td>
                          <td align="right">185</td>
                          <td align="right">76,750</td>
                          <td align="right">21,875</td>
                          <td align="right">11,125</td>
                          <td align="right">0</td>
                          <td align="right">43,750</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>ALAPUZHA</td>
                          <td align="right">22</td>
                          <td align="right">151</td>
                          <td align="right">1,27,825</td>
                          <td align="right">26,368</td>
                          <td align="right">7,075</td>
                          <td align="right">0</td>
                          <td align="right">94,382</td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>PATHANAMTHITTA</td>
                          <td align="right">14</td>
                          <td align="right">89</td>
                          <td align="right">77,875</td>
                          <td align="right">8,750</td>
                          <td align="right">64,750</td>
                          <td align="right">0</td>
                          <td align="right">4375</td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>KOTTAYAM</td>
                          <td align="right">8</td>
                          <td align="right">75</td>
                          <td align="right">1,06,750</td>
                          <td align="right">0</td>
                          <td align="right">8,750</td>
                          <td align="right">0</td>
                          <td align="right">98,000</td>
                        </tr>
                        <tr>
                          <td>6</td>
                          <td>ERANAKULAM</td>
                          <td align="right">21</td>
                          <td align="right">129</td>
                          <td align="right">1,39,125</td>
                          <td align="right">40,250</td>
                          <td align="right">15,750</td>
                          <td align="right">0</td>
                          <td align="right">83,125</td>
                        </tr>
                        <tr>
                          <td>7</td>
                          <td>TRISSUR</td>
                          <td align="right">17</td>
                          <td align="right">132</td>
                          <td align="right">1,27,375</td>
                          <td align="right">39,400</td>
                          <td align="right">17,500</td>
                          <td align="right">0</td>
                          <td align="right">70,475</td>
                        </tr>
                        <tr>
                          <td>8</td>
                          <td>MALAPPURAM</td>
                          <td align="right">26</td>
                          <td align="right">210</td>
                          <td align="right">1,83,750</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">1,83,750</td>
                        </tr>
                        <tr>
                          <td>9</td>
                          <td>KOZHIKODE</td>
                          <td align="right">4</td>
                          <td align="right">20</td>
                          <td align="right">17,500</td>
                          <td align="right">4,375</td>
                          <td align="right">0</td>
                          <td align="right">0</td>
                          <td align="right">13,125</td>
                        </tr>
                        <tr>
                          <td>10</td>
                          <td>KANNUR</td>
                          <td align="right">23</td>
                          <td align="right">136</td>
                          <td align="right">1,19,000</td>
                          <td align="right">39,375</td>
                          <td align="right">39,375</td>
                          <td align="right">0</td>
                          <td align="right">40,250</td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCC"><strong>Grand Total</strong></td>
                          <td bgcolor="#CCC">&nbsp;</td>
                          <td align="right" bgcolor="#CCC"><strong>180</strong></td>
                          <td align="right" bgcolor="#CCC"><strong>1415</strong></td>
                          <td align="right" bgcolor="#CCC"><strong>12,67,325</strong></td>
                          <td align="right" bgcolor="#CCC"><strong>2,00,518</strong></td>
                          <td align="right" bgcolor="#CCC"><strong>2,16,825</strong></td>
                          <td align="right" bgcolor="#CCC">0</td>
                          <td align="right" bgcolor="#CCC"><strong>8,49,982</strong></td>
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
        var page = 'ENTE-KAUMUDI';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>