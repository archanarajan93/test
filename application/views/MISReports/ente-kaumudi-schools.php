<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Ente-Kaumudy-Schools-".date("F-j-Y").".xls";
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
    <title>Circulation | EnteKaumudy Schools</title>
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
                <h1>EnteKaumudi Schools</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Ente Kaumudi Schools</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results" border="1" width="100%">
                          <thead>
                            <tr>
                              <td bgcolor="#00a7c7" style="color: #FFFFFF" colspan="3">GEETHA MADHU, MADHU GEETHAM ,VAZHAMUTTAM</td>
                            </tr>
                            <tr>
                              <td><strong>School name</strong></td>
                              <td align="right"><strong>Copy</strong></td>
                              <td><strong>Distribution Agents  Code &  Name</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
                            </tr>
                            <tr>
                              <td>ST JOSEPH, GH JUNCTION, TRIVANDRUM</td>
                              <td align="right">25</td>
                              <td>AGENT NAME, LOCATION</td>
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