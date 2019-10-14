<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="CRM-Enroll-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Approval</title>
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
                <h1>Approval</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Approval</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('CRM/Approve?g_fe=results'); ?>" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Sale Type</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo @$_POST['copy_type']; ?>" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"35","search":""}' data-select="{}" data-multiselect="false" placeholder="" 
                                           data-criteria='[{"column":"CT.copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Sale"}]'/>
                                    <input type="hidden" name="copy_type_rec_sel" class="copy_type_clr" id="copy_type_rec_sel" value="<?php echo @$_POST['copy_type_rec_sel']; ?>">
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>                                
                            </div>
                            <input type="hidden" id="copy_code" value="CP0001" />

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo @$_POST['subscriber']; ?>" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="<?php echo @$_POST['subscriber_rec_sel']; ?>">
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Code</label><!--data-minchars="3"-->
                                <div class="input-group search-module" data-selected="true">
                                    <input data-target='[{"selector":"#agent_details","indexes":"1,2"}]' autocomplete="off" value="<?php echo @$_POST['agent']; ?>" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="agent_rec_sel" class="agent_clr" id="agent_rec_sel" value="<?php echo @$_POST['agent_rec_sel']; ?>">
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input readonly autocomplete="off" type="text" class="form-control agent_clr" id="agent_details" name="agent_details" value="<?php echo @$_POST['agent_details']; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Date Type</label>
                                <select class="form-control" name="date_type">
                                    <option value="0">-- Select --</option>
                                    <option <?php echo @$_POST['date_type'] == 'sales_can_date' ? "selected" : ""; ?> value="sales_can_date">Canvassed Date</option>
                                    <option <?php echo @$_POST['date_type'] == 'created_date' ? "selected" : ""; ?> value="created_date">Created Date</option>
                                    <option <?php echo @$_POST['date_type'] == 'sales_start_date' ? "selected" : ""; ?> value="sales_start_date">Starting From</option>
                                    <option <?php echo @$_POST['date_type'] == 'sales_end_date' ? "selected" : ""; ?> value="sales_end_date">Ending From</option>
                                </select>
                            </div>
                                
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>From</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo isset($_POST['date_from']) ? date('d-m-Y',strtotime($_POST['date_from'])) : date('d-m-Y'); ?>" class="form-control" id="date_from" name="date_from" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>To</label>
                                <div class="input-group">
                                    <input required type="text" value="<?php echo isset($_POST['date_to']) ? date('d-m-Y',strtotime($_POST['date_to'])) : date('d-m-Y'); ?>" class="form-control" id="date_to" name="date_to" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Status</label>
                                <select class="form-control" name="sale_status">
                                    <option value="-1">All</option>
                                    <?php $status = Enum::getAllConstants('EnrollStatus');
                                          foreach($status as $key => $value) {
                                              if($key == EnrollStatus::Started) continue; ?>
                                    <option <?php echo isset($_GET['g_fe']) && (@$_POST['sale_status'] == $key) ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Type</label>
                                <select class="form-control" name="sale_type">
                                    <option value="-1">-- Select --</option>
                                    <?php $status = Enum::getAllConstants('EnrollType');
                                          foreach($status as $key => $value) { ?>
                                    <option <?php echo @$_POST['sale_type'] == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
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
                                    <td style="background: #0a98b4;color: #FFF;">SlNo</td>
                                    <td style="background: #0a98b4;color: #FFF;">Code</td>
                                    <td style="background: #0a98b4;color: #FFF;">Sale Type</td>
                                    <td style="background: #0a98b4;color: #FFF;">Status</td>
                                    <td style="background: #0a98b4;color: #FFF;">Canvassed Date</td>
                                    <td style="background: #0a98b4;color: #FFF;">Created Date</td>
                                    <td style="background: #0a98b4;color: #FFF;">Subscriber Name</td>
                                    <td style="background: #0a98b4;color: #FFF;">Address</td>
                                    <td style="background: #0a98b4;color: #FFF;">Phone</td>
                                    <td style="background: #0a98b4;color: #FFF;text-align:right;">Copies</td>
                                    <td style="background: #0a98b4;color: #FFF;">Start Date</td>
                                    <td style="background: #0a98b4;color: #FFF;">Agent Code</td>
                                    <td style="background: #0a98b4;color: #FFF;">Name</td>
                                    <td style="background: #0a98b4;color: #FFF;">Status</td>
                                    <td style="background: #0a98b4;color: #FFF;">Remarks</td>
                                    <td style="background: #0a98b4;color: #FFF;">Canvassed By</td>
                                    <td style="background: #0a98b4;color: #FFF;">Department</td>                                   
                                    <td style="background: #0a98b4;color: #FFF;">CRM Comment</td>
                                    <td style="background: #0a98b4;color: #FFF;">CRM Comment By</td>
                                    <td style="background: #0a98b4;color: #FFF;">CRM Comment Date</td>
                                    <td style="background: #0a98b4;color: #FFF;">CIRC Comment</td>
                                    <td style="background: #0a98b4;color: #FFF;">CIRC Comment By</td>
                                    <td style="background: #0a98b4;color: #FFF;">CIRC Comment Date</td>                                    
                                    <td style="background: #0a98b4;color: #FFF;">Type</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($count) {
                                    $slno = 1;
                                 foreach($records as $r) { ?>
                                 <tr data-id="<?php echo base64_encode($r->sales_code); ?>">                                    
                                    <td><?php echo $slno++; ?></td>
                                    <td><?php echo $r->sales_code; ?></td>
                                    <td><?php echo $r->copytype_name; ?></td>
                                    <td><?php echo Enum::getConstant('EnrollStatus',$r->sales_status); ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($r->sales_can_date)); ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($r->created_date)); ?></td>
                                    <td><?php echo $r->sub_name; ?></td>
                                    <td><?php echo $r->sub_address; ?></td>
                                    <td><?php echo $r->sub_phone; ?></td>
                                    <td style="text-align:right;"><?php echo $r->sales_copies; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($r->sales_start_date)); ?></td>                        
                                    <td><?php echo $r->agent_code; ?></td>
                                    <td><?php echo $r->agent_name; ?></td>
                                    <td><?php echo Enum::getConstant('Status',$r->cancel_flag); ?></td>
                                    <td><?php echo $r->sales_remarks; ?></td>
                                    <td><?php echo $r->sales_can_name; ?></td>
                                    <td><?php echo $r->sales_can_dept; ?></td>
                                    <td><?php echo $r->sales_crm_comment; ?></td>
                                    <td><?php echo $r->sales_crm_by; ?></td>
                                    <td><?php echo $r->sales_crm_date ? date('d-m-Y g:i:A',strtotime($r->sales_crm_date)) : ""; ?></td>                                    
                                    <td><?php echo $r->sales_crc_comment; ?></td>
                                    <td><?php echo $r->sales_crc_by; ?></td>
                                    <td><?php echo $r->sales_crc_date ? date('d-m-Y g:i:A',strtotime($r->sales_crc_date)) : ""; ?></td>                                    
                                    <td><?php echo Enum::getConstant('EnrollType',$r->sales_type); ?></td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='24' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
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
                <?php } ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
       ?>
        <form method="post" class="hide" target="_blank" id="open-approval-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'APPROVAL';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/crm.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
