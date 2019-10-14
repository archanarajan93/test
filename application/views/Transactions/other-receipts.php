<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Other-Receipts-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Other Receipts</title>
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
                <h1>Other Receipts</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li>Accounts</li>
                    <li class="active">Other Receipts</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Type</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["copy_group"])?$_POST["copy_group"]:'';?>" type="text" class="form-control" id="copy_group" name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="true" placeholder="" 
                                           data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]'/>
                                    <?php if(isset($_POST["copy_group_rec_sel"])){?>
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="<?php echo $_POST["copy_group_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>                                
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["copy_type"])?$_POST["copy_type"]:'';?>" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_code","input":".multi_sel_copy_group","select":"","encode":"true","multiselect":"false","required":"false"},
                                                            {"column":"RC.rate_pdt_code","input":"#pdt_code","select":"","encode":"false","multiselect":"false","required":"false"}]' />
                                    <?php if(isset($_POST["copy_type_rec_sel"])){?>
                                    <input type="hidden" name="copy_type_rec_sel" class="copy_type_clr" id="copy_type_rec_sel" value="<?php echo $_POST["copy_type_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>From</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo isset($_POST["from_dte"])?$_POST["from_dte"]:date("d-m-Y");?>" class="form-control" id="from_dte" name="from_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <label>To</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo isset($_POST["to_dte"])?$_POST["to_dte"]:date("d-m-Y");?>" class="form-control" id="to_dte" name="to_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="submit" name="search" value="1"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <a href="<?php echo base_url('Transactions/CreateOtherReceipts'); ?>">
                                    <button class="btn btn-block btn-primary" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;New</button>
                                </a>
                            </div>

                            <div class="col-lg-1 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                <?php $count = count($sch_rcpt_records); ?>               
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php echo $count ? "" : "no-data-tbl"; ?>" id="scheme-rcpt-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Receipt No.</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Receipt Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Scheme</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Name</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Address</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Phone</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Amount</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Pay Type</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created By</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($count) {
                                    $slno = 1;
                                    $rec_amount = 0; 
                                    foreach($sch_rcpt_records as $rec) { 
                                        $scheme_rcpt_code = Enum::encrypt_decrypt(Encode::Encrypt,$rec->srec_no,$en_key); 
                                        $rec_amount += $rec->srec_amount;
                                        $subscriber = explode('#&', $rec->subscriber);
                                        ?>
                                <tr>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $rec->srec_no; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo date("d-m-Y", strtotime($rec->srec_date)); ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $rec->copytype_name; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $subscriber[1]; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $subscriber[2]; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $subscriber[3]; ?></td>
                                    <td align="right" style="border:1px solid #ecf0f5;"><?php echo moneyFormat($rec->srec_amount); ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php if($rec->srec_pay_type==PayType::Cash) echo "Cash"; else if($rec->srec_pay_type==PayType::Card) echo "Card"; else echo "Cheque"; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo $rec->created_name; ?></td>
                                    <td style="border:1px solid #ecf0f5;"><?php echo date("d-m-Y h:i:s A",strtotime($rec->created_date)); ?></td>
                                    <td style="border:1px solid #ecf0f5;" class="remove_on_excel">
                                        <button onclick="window.location='<?php echo base_url('Transactions/ViewOtherReceipts/'.$scheme_rcpt_code);?>'" class="btn btn-success view-rcpt-scheme" title="View"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>
                                        <button onclick="window.location='<?php echo base_url('Transactions/UpdateOtherReceipts/'.$scheme_rcpt_code);?>'" class="btn btn-primary edit-rcpt-scheme" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>
                                        <button data-id="<?php echo $scheme_rcpt_code; ?>" class="btn btn-danger del-rcpt-scheme"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i>&nbsp;Delete</button>
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='11' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                }?>
                            </tbody>
                            <?php if($count) {?>
                            <tfoot>
                                <tr>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Total</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>                                    
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"></td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"></td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"><?php echo  moneyFormat($rec_amount); ?></td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                </tr>
                            </tfoot>
                            <?php }?>
                        </table>
                    </div>
                    <div class="box-footer">
                        <?php if($count) {?>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <?php }?>
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
        var page = 'OTHER-RECEIPTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
