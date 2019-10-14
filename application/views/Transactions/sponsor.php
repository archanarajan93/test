<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Sponsors-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Sponsor</title>
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
                <h1>Sponsor</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Sponsor</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Transactions/Sponsor?g_fe=results'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Created Date From</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo isset($_POST['date_from']) ? date('d-m-Y',strtotime($_POST['date_from'])) : date('d-m-Y'); ?>" class="form-control" id="date_from" name="date_from" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Created Date To</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo isset($_POST['date_to']) ? date('d-m-Y',strtotime($_POST['date_to'])) : date('d-m-Y'); ?>" class="form-control" id="date_to" name="date_to" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Code</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input data-selectindex="0" data-target='[{"selector":"#agent_details","indexes":"1,2"}]' autocomplete="off" value="<?php echo @$_POST['agent']; ?>" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="agent_rec_sel" class="agent_clr" id="agent_rec_sel" value="<?php echo @$_POST['agent_rec_sel']; ?>">
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control agent_clr" id="agent_details" name="agent_details" value="<?php echo @$_POST['agent_details']; ?>" />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Client</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input data-target='[{"selector":"#sponsor_client_details","indexes":"1,2"}]' autocomplete="off" value="<?php echo @$_POST['sponsor_client']; ?>" type="text" class="form-control" id="sponsor_client" name="sponsor_client" data-request='{"id":"37","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                        data-criteria='[{"column":"unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Unit"}]' />
                                    <input type="hidden" name="sponsor_client_rec_sel" class="sponsor_client_clr" id="sponsor_client_rec_sel" value="<?php echo @$_POST['sponsor_client_rec_sel']; ?>" />
                                    <div class="input-group-addon btn" id="sponsor_client_search" data-search="sponsor_client"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <input type="hidden" id="unit_code" value="<?php echo $this->user->user_unit_code; ?>" />

                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Client Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control sponsor_client_clr" id="sponsor_client_details" name="sponsor_client_details" value="<?php echo @$_POST['sponsor_client_details']; ?>" />
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <a href="<?php echo base_url('Transactions/CreateSponsor'); ?>">
                                    <button class="btn btn-block btn-primary" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;New</button>
                                </a>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>

                <?php if(isset($_GET['g_fe'])) { ?>
                <!--Records-->
                <?php $count = count($records); ?>               
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php echo $count ? "" : "no-data-tbl"; ?>" border="1" id="records-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">SlNo</td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">Code</td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">Client Name & Address</td>
                                    <td align="right" style="background: #cfcdcd; color: #000000; font-weight:bold;">Deal Amount</td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">Copies</td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">Canvassed By</td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;">Agent Code</td>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                if($count) {
                                    $slno = 1;
                                    foreach($records as $r) {
                                        $sum += $r->spons_deal_amt; ?>
                                <tr data-id="<?php echo base64_encode($r->spons_code); ?>">                                    
                                    <td><?php echo $slno++; ?></td>
                                    <td><?php echo $r->spons_code; ?></td>
                                    <td><?php echo $r->client_name.", ".$r->client_address.", ".$r->client_phone; ?></td>
                                    <td align="right"><?php echo moneyFormat($r->spons_deal_amt); ?></td>
                                    <td align="right"><?php echo $r->spons_copies; ?></td>
                                    <td><?php echo $r->spons_can_name; ?></td>                                  
                                    <td><?php echo $r->spons_agent_code; ?></td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='7' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                }?>
                            </tbody>
                            <?php if($count) { ?>
                            <tfoot>
                                <tr>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;" align="right"><?php echo moneyFormat($sum); ?></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                    <td style="background: #cfcdcd;color: #000000; font-weight:bold;"></td>
                                </tr>
                            </tfoot>
                            <?php } ?>
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
                <?php } ?>
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
        var page = 'SPONSOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
