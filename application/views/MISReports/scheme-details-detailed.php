<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Scheme-Details-Detailed-".date("F-j-Y").".xls";
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
    <title>Circulation | Scheme Details Detailed</title>
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
                <h1>Scheme Details Detailed</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Scheme Details</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table width="100%"  class="table table-results">
                            <thead>                                
                                <tr>
                                    <td colspan="28" style="color:#fff; background:#00a7c7; font-weight:bold;">
                                        Scheme Details Detailed From 01-Jun-2019 to 28-Jun-2019 | Date Type: Canvassed Date | Report Type: Unitwise | Unit: Thiruvananthapuram | Scheme/Sponsor: UNITY, SDS, BBS | Group: Promoter | Promoters: Anilkumar, Pradeep, Sajith                                                                       
                                    </td>
                                    <td colspan="5" style="color:#fff; background:#00a7c7; font-weight:bold;">Gouping Criteria</td>
                                </tr>
                                <tr>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Sl No.</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Sch SlNo.</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Status</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Created By</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Canvassed Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Entry Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Start Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Scheme Type</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Scheme</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Subscriber / Sponsor Name</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Amount</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Cash</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Cheque</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">PDC</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">PDC Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Dis Chq.</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Dis Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Balance</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Canvassed by</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Department</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Remark Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Remark By</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Remarks</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Code</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Agent Name</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Location</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Released / Inauguration Date</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Institution Name</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">ACM</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Promoter</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Shakha</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Edition</td>
                                    <td scope="col" style="color:#fff; background:#00a7c7; font-weight:bold;">Dropping Point</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>SDTVM00030857</td>
                                    <td>New</td>
                                    <td>RAJI</td>
                                    <td>03-Jun-2019</td>
                                    <td>03-Jun-2019</td>
                                    <td>23-Jun-2019</td>
                                    <td>BBS</td>
                                    <td>BBS (5x2) - Rs. 4500</td>
                                    <td>HOLY CROSS ENGLISH SCHOOL, CBSE,VETTINAD,VATTAPPARA, Ph : 9447471428  0472- 2586991</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td>UDAYAKUMAR K</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T0810</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>08-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>SDTVM00011025</td>
                                    <td>Renewed</td>
                                    <td>RAJI</td>
                                    <td>10-Jun-2019</td>
                                    <td>10-Jun-2019</td>
                                    <td>01-Ju1-2019</td>
                                    <td>BBS</td>
                                    <td>BBS (5x2) - Rs. 4500</td>
                                    <td>THE MANAGER, UNION COLLEGE,BALARAMAPURAM,, Ph : 2400456</td>
                                    <td align="right">4,500</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T2510</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>01-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>SDTVM00071564</td>
                                    <td>&nbsp;</td>
                                    <td>RAJI</td>
                                    <td>22-Jun-2019</td>
                                    <td>22-Jun-2019</td>
                                    <td>01-Ju1-2019</td>
                                    <td>BBS</td>
                                    <td>BBS (5x2) - Rs. 4500</td>
                                    <td>THE MANAGER, UNION COLLEGE,BALARAMAPURAM,, Ph : 2400456</td>
                                    <td align="right">4,500</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T0109</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>26-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>SDTVM00012543</td>
                                    <td>&nbsp;</td>
                                    <td>RAJI</td>
                                    <td>20-Jun-2019</td>
                                    <td>20-Jun-2019</td>
                                    <td>23-Jun-2019</td>
                                    <td>SBS</td>
                                    <td>SBS - 1 Year</td>
                                    <td>THE MANAGER, SREE VIVEKANDA MEMMORIAL PUBLIC SCHOOL,ARALUMOODU,NEYYATTINKARA, Ph : 9847060876   2227999</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">2,250</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T0109</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>04-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>SDTVM00022222</td>
                                    <td>Renewed -  3</td>
                                    <td>RAJI</td>
                                    <td>13-Jun-2019</td>
                                    <td>13-Jun-2019</td>
                                    <td>13-Jun-2019</td>
                                    <td>SBS</td>
                                    <td>SBS - 2 Year</td>
                                    <td>G V PRINTERS, BALARAMAPURAM,BALARAMAPURAM,, Ph : 2400516 9495825786</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T1248</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>03-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>SDTVM00040857</td>
                                    <td>&nbsp;</td>
                                    <td>RAJI</td>
                                    <td>03-Jun-2019</td>
                                    <td>03-Jun-2019</td>
                                    <td>05-Ju1-2019</td>
                                    <td>Unity</td>
                                    <td>Unity 2019 1 year. 2250</td>
                                    <td>SECRETARY, BHARATHUYA VIDYA PEEDOM CENTRAL SCHOOL,PARASSALA,TVM, Ph : 2203746,,9400703746</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T1821</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>24-Jun-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>SDTVM00041857</td>
                                    <td>&nbsp;</td>
                                    <td>RAJI</td>
                                    <td>20-Jun-2019</td>
                                    <td>20-Jun-2019</td>
                                    <td>03-Aug-2019</td>
                                    <td>BBS</td>
                                    <td>BBS (5x2) - Rs. 4500</td>
                                    <td>KARTHIKA GRANITE &amp; SANITARY WARE, TOLL JUNCTION,GRAMAM,NEYYATTINKARA, Ph : 9446575159  2227229</td>
                                    <td align="right">4,500</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td align="right">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="right">4,500</td>
                                    <td>KALA S D</td>
                                    <td>PMD</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>T2231</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>14-Ju1-2019</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="background:#cfcdcd; color:#000; font-weight:bold;">Grand Total</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">31,500</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">9,000</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">2,250</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td align="right" style="background:#cfcdcd; color:#000; font-weight:bold;">22,500</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
                                    <td style="background:#cfcdcd; color:#000; font-weight:bold;">&nbsp;</td>
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