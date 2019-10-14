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
                        <form method="post" action="<?php echo base_url('Transactions/UpsertFreeCopy'); ?>" name="free-copy-form" id="free-copy-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Free SlNo.</label>
                                <input  type="text" name="free_slno" id="free_slno" class="form-control" value="<?php echo $free_code;?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Free Register No.</label>
                                <input type="text" required name="free_reg" id="free_reg" tabindex="1" class="form-control" value="" autocomplete="off"/>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required data-required="subscriber_clr" tabindex="2" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}'
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" data-target='[{"selector":"#sub_det","indexes":"7,2,3"}]'/>
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="">
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input type="text" class="form-control agent_clr" name="sub_det" id="sub_det" value="" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copy Type</label>
                                <input type="hidden" id="copy_code" value="CP0002" />
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" data-required="copy_group_clr" tabindex="3" id="copy_group" name="copy_group" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"CT.copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]' />
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="">
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Start Date</label>
                                <div class="input-group">
                                    <input  autocomplete="off" type="text" value="" tabindex="4" data-compare="#end_dte" required class="form-control" id="start_dte" name="start_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 "> 
                                <label>End Flag</label>
                                <select class="form-control end-flag" id="endflag" name="endflag" tabindex="5">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 hide" id="last_date">
                                <label>End Date</label>
                                <div class="input-group">
                                    <input type="text" value="" class="form-control "  tabindex="6" id="end_dte" name="end_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label> Commission Applicable</label>
                                <select class="form-control comm-app" id="comm_app"  tabindex="7" name="comm_app">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>

                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input type="number" value="" class="form-control isNumberKey" id="free_copy" tabindex="8"  name="free_copy" autocomplete="off"/>
                            </div>
                            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-12">
                                <label>Remark</label>
                                <input type="text" value="" tabindex="9" class="form-control" id="remark" name="remark"  autocomplete="off"/>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="10" type="button" name="search" id="save-btn" value=""><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                    <label>&nbsp;</label>
                                    <button onclick="window.location='<?php echo base_url('Transactions/FreeCopy');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                              </div>
                   </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                <!--<div class="box">                    
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
                </div>-->
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
        var page = 'FREE-COPY-CREATE';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
