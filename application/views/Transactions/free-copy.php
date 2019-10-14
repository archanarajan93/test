<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Free-Copy-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Free Copy</title>
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
                <h1>Free Copy</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Free Copy</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/FreeCopy'); ?>" name="free-copy-form" id="free-copy-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                           
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>From Date</label>
                                <div class="input-group">
                                    <input  data-compare="#free_to_date" type="text" value="<?php echo @$_POST['free_from_date']?>" tabindex="1" class="form-control" id="free_from_date" name="free_from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>To Date</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo @$_POST['free_to_date']?>" tabindex="2" class="form-control" id="free_to_date" name="free_to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo @$_POST['agent']?>" tabindex="3" data-required="agent_clr" type="text" class="form-control tg" id="agent" name="agent" data-request='{"id":"17","search":""}' data-target='[{"selector":"#agent_det","indexes":"1,2"}]' data-select="{}" data-multiselect="false" placeholder="" data-selectindex="0" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="col-lg-6 col-md-4 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent Details</label>
                                <input type="text" readonly class="form-control" value="" id="agent_det" name="agent_det" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="10" type="submit" name="search" id="search" value=""><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <a href="<?php echo base_url('Transactions/CreateFreeCopy'); ?>">
                                    <button class="btn btn-block btn-success" tabindex="5" type="button">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        &nbsp;New
                                    </button>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                    <label>&nbsp;</label>
                                    <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                                   
                              </div>
                   </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php //echo $count ? "" : "no-data-tbl"; ?>" id="free-copy-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">SlNo</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy Type</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Name</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Address</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Phone</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Code</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Name</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Location</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;text-align:right;">Copies</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Start Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">End Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Remarks</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created By</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($free_list)) {
                                    $slno = 1;
                                    foreach($free_list as $list) { 
                                        $fc_code = Enum::encrypt_decrypt(Encode::Encrypt,$list->free_slno,$en_key); 
                                ?>
                                        <tr>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $slno++; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->copytype_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->sub_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->sub_address; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->sub_phone; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->agent_code; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->agent_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->agent_location; ?></td>
                                            <td style="border:1px solid #ecf0f5;text-align:right;"><?php echo $list->free_copies; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y',strtotime($list->free_start_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->free_end_date ? date('d-m-Y',strtotime($list->free_end_date)):null; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->free_remarks ? $list->free_remarks : " "; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $list->user_emp_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y h:i:s A',strtotime($list->created_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;" class="remove_on_excel">
                                               
                                                <button onclick="window.location='<?php echo base_url('Transactions/FreeCopyEdit/'.$fc_code);?>'" class="btn btn-primary edit-scheme" title="Edit">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit
                                                </button>

                                                <button data-id="<?php echo $fc_code; ?>" class="btn btn-warning pause-free-copy <?php echo ($list->free_status == CopyStatus::Paused || $list->free_status == CopyStatus::Stopped) ? "hide" : ""; ?>">
                                                <i class="fa fa-pause" aria-hidden="true" title="Pause"></i>&nbsp;Pause
                                                </button>

                                                <button data-id="<?php echo $fc_code; ?>" class="btn btn-success restart-free-copy <?php echo $list->free_status == CopyStatus:: Started || $list->free_status == CopyStatus::Stopped ? "hide" : ""; ?>">
                                                <i class="fa fa-retweet" aria-hidden="true" title="Restart"></i>&nbsp;Restart
                                                </button>

                                                <button data-id="<?php echo $fc_code; ?>" class="btn btn-primary stop-free-copy <?php echo $list->free_status == CopyStatus:: Stopped ? "hide" : ""; ?>" title="stop">
                                                <i class="fa fa-stop-circle" aria-hidden="true"></i>&nbsp;Stop
                                                </button>

                                                <button data-id="<?php echo $fc_code; ?>" class="btn btn-danger del-free-copy">
                                                <i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i>&nbsp;Delete
                                                </button>
                                             
                                             </td>
                                         </tr>
                                <?php }
                                }
                                else {
                                    echo "<tr><td colspan='19' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
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
        <form method="post" class="hide" target="_blank" id="open-enroll-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'FREE-COPY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
