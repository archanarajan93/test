<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Wellwisher-Master-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Wellwisher</title>
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
                <h1>Wellwisher</h1>
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
                        <?php echo form_open_multipart('Masters/CreateWellWisher','name="Wellwisher_form" id="Wellwisher_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                            <input autocomplete="off" type="text" class="form-control" value="<?php echo $well_code; ?>" readonly/>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label> Name</label>
                            <input autocomplete="off" required type="text" class="form-control isAlpha" id="well_name" name="well_name" />
                            </div>
                        
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Phone Number</label>
                            <input autocomplete="off" required type="number" class="form-control isMob isNumberKey" id="well_phn" name="well_phn" />
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Location</label>
                            <input autocomplete="off" required type="text" class="form-control" id="well_location" name="well_location" />
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Remarks</label>
                            <input autocomplete="off" required type="text" class="form-control" id="well_remark" name="well_remark" />
                        </div>

                            <!--<div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Status</label> 
                                <select name="res_status" id="res_status" class="form-control" >  
                                        <option value="0">Active</option>
                                        <option  value="1">Disabled</option>
                                </select>
                            </div>-->       

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">     
                                <label>&nbsp;</label>                           
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>    
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                        </div>                       
                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>

                <!--Issue Records-->
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results"  id="well_table" style="width:100%;">
                            <thead>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Name</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Phone Number</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Location</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Status</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($well_list)) {
                                    foreach($well_list as $list) { ?>
                                <tr>
                                    <td class="wel-name"><?php echo $list->well_name; ?></td>
                                    <td class="wel-phon"><?php echo $list->well_phone; ?></td>
                                    <td class="wel-loc"><?php echo $list->well_location; ?></td>
                                    <td><?php if($list->cancel_flag == Status::Active){echo "Active"; } else{echo "Disable";}?> </td>
                                                                           
                                    <td class="remove_on_excel" align="center">
                                        <button data-id="<?php echo $list->well_code; ?>" class="btn btn-primary well-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>                                   
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
        var page = 'WELLWISHER-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
