<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Journal-Entry-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Journal Entry</title>
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
                <h1>Journal Entry</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Journal Entry</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/CreateJournalEntry'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label>Journal Code</label>
                                <input type="text" class="form-control" readonly id="jour_code" name="jour_code" value="<?php echo $je_code; ?>"/>
                                
                             </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="" tabindex="1" data-required="agent_clr"  type="text" class="form-control tg" id="agent" name="agent" data-request='{"id":"17","search":""}' data-target='[{"selector":"#agent_det","indexes":"1,2"}]' data-select="{}" data-multiselect="false" placeholder="" data-selectIndex="0" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent Details</label>
                                <input type="text" readonly class="form-control" value="" id="agent_det" name="agent_det" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Journal Date</label>
                                <div class="input-group">
                                    <input type="text" readonly value="<?php echo date('d-m-Y',strtotime($je_date."+1 days"));?>" class="form-control" tabindex="2" id="jour_date" name="jour_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 agent_sel">
                                <label>Journal Head</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="" type="text" data-required="accounthead_clr" tabindex="3" class="form-control tg" id="accounthead" name="accounthead" data-request='{"id":"36","search":""}'  data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="accounthead_search" data-search="accounthead">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            <span class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                                <label>Narration</label>
                                <input autocomplete="off" type="text" class="form-control" tabindex="4" id="jour_narrate" name="jour_narrate" />
                            </span>
                            <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label>Amount</label>
                                <input required type="number" autocomplete="off" class="form-control isNumberKey tg" tabindex="5" id="jour_amount" name="jour_amount" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="6" type="submit"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Transactions/JournalEntry');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--<div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-results"  id="journal-entry-table" width="100%">
                            <thead>
                                <tr>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Agent Code</td>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Agent Name</td>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Location</td>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Journal Head</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Debit</td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Credit</td>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Narration</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($je_rec)) {
                                    $sum_debit=$sum_credit=0;
                                    foreach($je_rec as $je) {
                                        $sum_debit=$sum_debit+$je->je_debit_amount;
                                        $sum_credit = $sum_credit+$je->je_credit_amount;
                                ?>
                                <tr data-id="<?php echo $je->je_code ; ?>">
                                    <td class="je-age-code"><?php echo $je->agent_code; ?></td>
                                    <td class="je-age-name"><?php echo $je->agent_name; ?></td>
                                    <td class="je-age-loc"><?php echo $je->agent_location; ?></td>
                                    
                                    <td class="je-age-phn"><?php echo $je->ac_name ; ?></td>
                                    <td class="je-debit" align="right">
                                        <?php echo moneyFormat($je->je_debit_amount); ?></td>
                                    <td class="je-credit" align="right">
                                        <?php echo moneyFormat($je->je_credit_amount); ?></td>
                                    <td class="je-narration"><?php echo $je->je_narration ; ?></td>
                                  
                                    <td>
                                        <button data-id="<?php echo $je->je_code ; ?>" class="btn btn-primary pack-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                                        <button data-id="<?php echo $je->je_code ; ?>" class="btn btn-warning je-delete-btn btn-xs"><i class="fa fa-trash-o"></i></button>
                                    </td>
                                    
                                </tr>
                                <?php
                                    }
                                }else {
                                    echo "<tr><td colspan='8' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                }
                                ?>
                                <tr>
                                    <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Total</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>                                    
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"><?php echo  moneyFormat($sum_debit);?></td>
                                    <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;"><?php echo  moneyFormat($sum_credit); ?></td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    <td align="center" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                </tr>
                            </tbody>
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
            </div>-->
</section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
        ?>
        <!--<form method="post" class="hide" target="_blank" id="open-enroll-form" action=""></form>-->
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'JOURNAL-ENTRY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
