<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Shakha-Master-".date("F-j-Y").".xlsx";
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
    <title>Circulation |Shakha Master</title>
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
                <h1>Shakha Master </h1>
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
                        <form method="post" action="<?php echo base_url('Masters/CreateShakhaMaster'); ?>" name="unit_master" id="unit_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="shakha_code" value="<?php echo $sh_code; ?>" name="shakha_code" readonly />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Shakha No.</label>
                                <input autocomplete="off" required type="text" class="form-control" id="shakha_no" name="shakha_no" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Shakha Name</label>
                                <input autocomplete="off" required type="text" class="form-control isAlpha" id="shakha_name" name="shakha_name" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Address 1</label>
                                <input autocomplete="off" required type="text" class="form-control" id="shakha_address1" name="shakha_address1" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Address 2</label>
                                <input autocomplete="off" required type="text" class="form-control" id="shakha_address2" name="shakha_address2" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Town</label>
                                <input autocomplete="off" required type="text" class="form-control" id="sakha_town" name="sakha_town" />
                            </span>
                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Pincode</label>
                                <input autocomplete="off" required type="number" class="form-control" id="shakha_pin" name="shakha_pin" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Union</label>
                                <div class="input-group search-module" data-selected="true">

                                    <input autocomplete="off" value="" type="text" class="form-control" id="shakha_union" name="shakha_union" data-request='{"id":"8","search":""}' data-select="{}" data-multiselect="false" placeholder=""  data-criteria='[{"column":"union_unit","input":"#union_f","select":"","encode":"false","multiselect":"false","msg":"Unit Required ","required":"true"}]'/>
                                    <div class="input-group-addon btn" id="shakha_union_search" data-search="shakha_union"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>President</label>
                                <input autocomplete="off" required type="text" class="form-control isAlpha" id="shakha_president" name="shakha_president" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>President Mobile</label>
                                <input autocomplete="off" required type="number" class="form-control isNumberKey" id="shakha_pres_mobile" name="shakha_pres_mobile" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Secretary</label>
                                <input autocomplete="off" required type="text" class="form-control isAlpha" id="shakha_secretary" name="shakha_secretary" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Secretary Mobile</label>
                                <input autocomplete="off" required type="number" class="form-control isNumberKey" id="shakha_sec_mobile" name="shakha_sec_mobile" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Status</label>
                                <select name="shakha_status" id="shakha_status" class="form-control">
                                    <option value="0">Active</option>
                                    <option value="1">Disabled</option>
                                </select>
                            </div>
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </span>
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i> Close</button>
                            </span>
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <input class="hidden" type="text" name="union_f" id="union_f" value="<?php echo $this->user->user_unit_code;?>" />
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results" id="shakha-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Shakha No. </td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Shakha Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Address 1</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Address 2</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Town</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Pincode</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Union</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> President</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> President Mobile</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Secretary</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Secretary Mobile</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">status</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($shakha_list)) {
                                        foreach($shakha_list as $sh) {?>
                                                    
                                    <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">
                                       
                                        <td class="sh-number"><?php echo $sh->shakha_no; ?></td>
                                        <td class="sh-name"><?php echo $sh->shakha_name; ?></td>
                                        <td class="sh-add1"><?php echo $sh->shakha_address1; ?></td>
                                        <td class="sh-add2"><?php echo $sh->shakha_address2; ?></td>
                                        <td class="sh-town"><?php echo $sh->shakha_town; ?></td>
                                        <td class="sh-pin"><?php echo $sh->shakha_pincode; ?></td>
                                        <td class="sh-union"><?php echo $sh->union_name; ?> </td>
                                        <td class="sh-pres"><?php echo $sh->shakha_president; ?> </td>
                                        <td class="sh-pres-phn"><?php echo $sh->shakha_president_phone; ?> </td>
                                        <td class="sh-sec"><?php echo $sh->shakha_secretary; ?> </td>
                                        <td class="sh-sec-phn"><?php echo $sh->shakha_secretary_phone; ?> </td>
                                        <td class="sh-status"><?php if( $sh->cancel_flag == ResidenceStatus::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                        <td>
                                            <button data-id="<?php echo $sh->shakha_code; ?>"class="btn btn-primary shakha-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <?php //if($grp->cancel_flag == 0){?>
                                            <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                            <?php //} ?>
                                        </td>
                                    </tr>
                                    <?php }
                                    }
                                    else {
                                        echo "<tr><td colspan='13' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";  
                                    }?>
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
        var page = 'SHAKHA-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
