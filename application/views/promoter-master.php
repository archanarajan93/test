<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Promoters-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Promoter Master</title>
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
                <h1>Promoter Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">Masters</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <?php echo form_open_multipart('Masters/CreatePromoter','name="promoter_form" id="promoter_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Promoter Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" value="<?php echo $promoter_code; ?>" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Promoter Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="promoter_name" name="promoter_name" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Area</label>
                                <input autocomplete="off" required type="text" class="form-control" id="promoter_area" name="promoter_area" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Phone</label>
                                <input autocomplete="off" required type="number" class="form-control" id="promoter_phone" name="promoter_phone" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>ACM</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" id="promoter_acm_code" name="promoter_acm_code" data-request='{"id":"2","search":"ACM"}' data-select="{}" data-multiselect="false" placeholder="Select ACM" />
                                    <div class="input-group-addon btn" id="promoter_acm_code_search" data-search="promoter_acm_code"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                                                        
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">     
                                <label>&nbsp;</label>                           
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>                           
                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>

                <!--Prmoter Records-->
                <?php  ?>
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results" id="records-table" style="width:100%">
                            <thead>
                                <tr>
                                    <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Name</td>
                                    <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Area</td>
                                    <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Phone</td>
                                    <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">ACM</td>                                    
                                    <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($promoter_list)) {
                                    foreach($promoter_list as $i) { ?>
                                <tr>
                                    <td class="pro-name"><?php echo $i->promoter_name; ?></td>
                                    <td class="pro-area"><?php echo $i->promoter_area; ?></td>
                                    <td class="pro-phone"><?php echo $i->promoter_phone; ?></td>
                                    <td class="pro-acm"><?php echo $i->acm_name; ?></td>
                                    <td class="remove_on_excel" align="center">
                                        <button data-id="<?php echo $i->promoter_code; ?>" class="btn btn-primary promoter-edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button data-id="<?php echo $i->promoter_code; ?>" class="btn btn-danger promoter-delete-btn"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='5' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
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
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
       ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'PROMOTER-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
