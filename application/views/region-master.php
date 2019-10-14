<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Regions-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Region</title>
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
                <h1>Region Master</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">Masters</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Masters/CreateRegion'); ?>" name="unit_master" id="unit_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Region Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="region_code" value="<?php echo $reg_code; ?>" name="region_code" readonly />
                            </span>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Region Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="region_name" name="region_name" />
                            </span>
                            <span class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </span>
                            <span class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button">
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    Close
                                </button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results" id="region-table" style="width:50%">
                                <thead>
                                    <tr>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">#</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Region Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">status</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"  class="remove_on_excel"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($region_list)) {
                                         $i=1;
                                         foreach($region_list as $reg) {?>

                                    <tr data-save="false" data-drpid="<?php //echo $dr->drop_code; ?>">
                                       
                                        <td><?php echo $i++; ?></td>
                                        <td class="reg-name"><?php echo $reg->region_name; ?> </td>
                                        <td class="reg-status"><?php if( $reg->cancel_flag == Status::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                         <td align="center"  class="remove_on_excel">
                                        <button data-id="<?php echo $reg->region_code; ?>"class="btn btn-primary region-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>

                                            <?php //if($grp->cancel_flag == 0){?>
                                            <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php }
                                    else {
                                        echo "<tr><td colspan='7' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                    }?>
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
                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('inc/footer');
              $this->load->view('inc/help'); ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'REGION-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
