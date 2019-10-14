<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Response-Master-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Response Master</title>
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
                <h1>Response Master</h1>
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
                        <?php echo form_open_multipart('Masters/CreateResponse','name="Response_form" id="Response_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>
                        <div class="row form-group form-btns" data-update="false">
                            <span class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                                <label>Agent/Subscriber</label>
                                <select class="form-control" name="unit" id="unit"  tabindex="1" required>
                                    <option value="0">Subscriber</option>
                                    <option value="1">Agent</option>
                                    <option value="2">General</option>
                                </select>
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label>Response Head</label>
                                <input type="text" name="response_head" id="response_head" value="" tabindex="2" class="form-control" autocomplete="off">
                            </span>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label class="col-xs-12">&nbsp</label>
                                <button class="btn btn-block btn-primary" tabindex="3" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </span>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label class="col-xs-12">&nbsp</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </span>
                        </div>           
                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                </div>

                <!--Response Records-->
                <div class="box">
                    <div class="box-body table-responsive">
                       <table class="export-table table-bordered no-wrap" style="width:40%;" id="response_table">
            <thead class="report-head">
            <tr>
                  <th style="background-color: #7da4e8; color:#fff; font-weight:bold;">#</th>
                  <th style="background-color: #7da4e8; color:#fff; font-weight:bold;">Response Header</th>
                  <th style="width:15%;background-color: #7da4e8; color:#fff; font-weight:bold;">&nbsp;</th>
                  <th style="width:15%;background-color: #7da4e8; color:#fff; font-weight:bold;">&nbsp;</th>
            </tr>

                </thead>
                <tbody>
                <?php 
                $dynamic_head=null; 
                foreach($list_respose as $response_list)
                {
                    if($dynamic_head!=$response_list->res_ag_flag)
                    {
                        if($response_list->res_ag_flag=='0'){ $head_name="Subscriber";} else if($response_list->res_ag_flag=='1'){ $head_name="Agent"; } else { $head_name="General"; }
                ?>

                            <tr class="report-head"><td colspan="4" style="background-color: #7da4e8; color:#fff; font-weight:bold;"><?php echo $head_name; ?></td></tr>
                        <?php
                        $dynamic_head=$response_list->res_ag_flag;
                    }
                        ?>
                    <tr class="form-btns" data-update="false">
                        <td><?php echo $response_list->res_code; ?></td>
                        <td><span class="form-control res-text" spell-check="false" contenteditable="false" disabled ><?php echo $response_list->res_desc; ?></span></td>
                        <td class="remove_on_excel">
                            <span  class="text-blue link pull-right  btn edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;EDIT</span>
                            <span class="text-success link pull-right btn save-btn" style="color:#349436;">&nbsp;&nbsp;&nbsp;<i class="fa fa-floppy-o fa-1x"></i>&nbsp;SAVE</span>
                        </td>
                        <td class="remove_on_excel"><span class="text-red link btn pull-right cancel-btn">&nbsp;&nbsp;<i class="fa fa-times-circle"></i>&nbsp;CANCEL</span>
                        </td>
                    </tr>

                   <?php
                    }
                   ?> 
                  
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
        var page = 'RESPONSE-MASTER', $currentRow = '', current_head = ''; //global
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
