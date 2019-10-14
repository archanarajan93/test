<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Receipts-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    //$spreadsheet->getActiveSheet()->setTitle("123");
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
    <title>Circulation | Receipts</title>
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
                <h1>Receipts</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Receipts</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/Receipts?g_fe=results'); ?>" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Created Date</label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" value="<?php echo date('d-m-Y'); ?>" tabindex="4" required class="form-control" id="start_date" name="start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="10" type="submit" name="search" value=""><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/CreateReceipts');?>'" class="btn btn-block btn-primary" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;New
                                </button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close
                                </button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                <div class="box">
                    <?php $count = count($records); ?>                   
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php echo $count ? "" : "no-data-tbl"; ?>" id="free-copy-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">SlNo</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Rec No</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agency</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Type</td>                                                                                                  
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;text-align:right;">Amount</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Mode</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Remarks</td>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($count) {
                                    $slno = 1;
                                    foreach($records as $rec) {                                         
                                ?>
                                        <tr data-id="<?php echo base64_encode($rec->wa_code); ?>">
                                            <td style="border:1px solid #ecf0f5;"><?php echo $slno++; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sub_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->wa_agent_code." - ".$rec->agent_name.", ".$rec->agent_location.", ".$rec->agent_phone; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sub_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;text-align:right;"><?php echo $rec->wa_copies; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->wa_start_date; ?></td>                                            
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->wa_remarks ? $rec->wa_remarks : " "; ?></td>                                    
                                        </tr>
                                <?php }
                                }
                                else {
                                    echo "<tr><td colspan='7' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                } ?>
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
        <form method="post" class="hide" target="_blank" id="open-trans-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'RECEIPTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
