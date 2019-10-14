<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Setbonus-Date".date("F-j-Y").".xlsx";
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
    <title>Circulation |Set Bonus Date</title>
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
                <h1>Set Bonus Date</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active"></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Tools/SaveBonusDate'); ?>" name="bonus_form" id="bonus_form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Select Month</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control monthpicker" id="bonus_month" name="bonus_month" autocomplete="off" />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>2% Bonus Date</label>
                                <div class="input-group">
                                    <input required data-greater="true" data-compare="#bonus5_date" type="text" value="" class="form-control" id="bonus2_date" name="bonus2_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>1.5% Bonus Date</label>
                                <div class="input-group">
                                    <input required data-greater="true" data-compare="#bonus1_date" type="text" value="" class="form-control" id="bonus5_date" name="bonus5_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  autocomplete="off"/>
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>1% Bonus Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control" id="bonus1_date" name="bonus1_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="save_btn" id="save_btn">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    Add
                                </button>
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
                        <table class="table table-results" id="set-bonus-date-table" style="width:100%">
                            <thead>
                                <tr>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Bonus Month</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">2% Bonus Date</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1.5% Bonus Date</td>
                                    <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">1% Bonus Date</td>
                                    <th style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($bonus_list)) {
                                    foreach($bonus_list as $list) {?>

                                <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">

                                    <td class="bonus-month">
                                        <?php echo date('F-Y',strtotime('01-'.$list->bonus_month.'-'.$list->bonus_year)); ?></td>
                                     <td class="bonus-first-per"><?php echo date('d-m-Y',strtotime($list->bonus_first_date)); ?></td>
                                    <td class="bonus-sec-per"><?php echo date('d-m-Y',strtotime($list->bonus_second_date)); ?></td>
                                    <td class="bonus-third-per"><?php echo date('d-m-Y',strtotime($list->bonus_third_date)); ?></td>
                                    <td>
                                        <button data-id="<?php echo $list->bonus_code; ?>" class="btn btn-primary bonus-edit-btn btn-xs">
                                            <i class="fa fa-edit fa-1x"></i>
                                        </button>
                                        <button class="btn btn-warning cancel-btn btn-xs">
                                            <i class="fa fa-times-circle fa-1x"></i>
                                        </button>
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
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                &nbsp;Excel
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                &nbsp;Close
                            </button>
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
        var page = 'SET-BONUS-DATE';
        /*function validateBonusForm() {
            var error = 0;
            var isValid = CIRCULATION.utils.formValidation($("#bonus_form"));

            if (isValid) {

            }
        }*/
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/tools.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
