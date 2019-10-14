<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Copy-Type-Master-".date("F-j-Y").".xlsx";
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
    <title>Circulation |Copy Type Master</title>
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
                <h1>Copy Type Master</h1>
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
                        <form method="post" action="<?php echo base_url('Masters/CreateCopyTypeMaster'); ?>" name="type_master" id="type_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="ct_code" value="<?php echo $cpt_code; ?>" name="ct_code" readonly />
                            </span>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="ct_name" name="ct_name" />
                            </span>
                            
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Code</label>
                                <select name="copy_code" id="copy_code" class="form-control" required >
                                    <?php foreach($copy_code as $code){?>
                                        <option value="<?php echo $code->copy_code;?>"><?php echo $code->copy_name;?></option>
                                    <?php } ?>
                                </select>
                            </span>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Copy Group</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="ct_group" name="ct_group" data-request='{"id":"15","search":""}' data-callback="showYear" data-select="{}" data-multiselect="false" placeholder=""  data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]'/>
                                    <div class="input-group-addon btn" id="ct_group_search" data-search="ct_group"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12 hide" id="scheme_unity">
                                <label>Year</label>
                                <input autocomplete="off"  type="text" class="form-control yearpicker" id="ct_year" name="ct_year" />
                            </span>
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </span>
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-body table-responsive">
                            <table class="table table-results" id="ct-group-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <td  style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Copy Type Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Copy Code</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Copy Group</td>
                                        <th style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">status</th>
                                        <th style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($ct_rec)) {
                                        foreach($ct_rec as $ct) {?>
                                                    
                                    <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">
                                       
                                        <td class="ct-name"><?php echo $ct->copytype_name; ?></td>
                                        <td class="copy-name"><?php echo $ct->copy_name; ?> </td>
                                        <td class="ct-grp-name"><?php echo $ct->group_name; ?> </td>
                                        <td class="ct-status"><?php if( $ct->cancel_flag == Status::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                        <td>
                                            <button data-id="<?php echo $ct->copytype_code; ?>"class="btn btn-primary ct-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <?php //if($grp->cancel_flag == 0){?>
                                            <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                            <?php //} ?>
                                        </td>
                                    </tr>
                                    <?php
                                          }
                                    } else {
                                        echo "<tr><td colspan='5' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                    }
                                    ?>
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
        var page = 'COPY-TYPE-MASTER';
        function showYear() {
            var copyGroup = $("#ct_group").val();
            var copyCode = $("#copy_code").val();
            if (copyGroup == 'UNITY' && copyCode == 'CP0003'){ 
                $("#scheme_unity").removeClass('hide');
            } else {
                $("#scheme_unity").addClass('hide');
            }
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
