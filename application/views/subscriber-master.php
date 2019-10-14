<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Subscriber-Master-".date("F-j-Y").".xlsx";
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
    <title>Circulation |Subscriber</title>
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
                <h1>Subscriber </h1>
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
                        <form method="post" action="<?php echo base_url('Masters/CreateSubscriber'); ?>" name="subscriber_master" id="subscriber_master" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="sub_code" value="<?php echo $sub_code; ?>" name="sub_code" readonly />
                            </span>
                            
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber Name</label>
                                <input autocomplete="off" required type="text" class="form-control isAlpha" id="subcr_name" name="subcr_name" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Address </label>
                                <input autocomplete="off" required type="text" class="form-control" id="subcr_address" name="subcr_address" />
                            </span>
                            <span class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber Phone</label>
                                <input autocomplete="off" required type="number" class="form-control isNumberKey" id="sub_mobile" name="sub_mobile" />
                            </span>
                           
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Edition</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="sub_edition" name="sub_edition" required data-request='{"id":"10","search":""}'  data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"edition_unit","input":"#edit_f","select":"","encode":"false","multiselect":"false","msg":"Unit Required ","required":"true"}]'/>
                                    <div class="input-group-addon btn" id="sub_edition_search" data-search="sub_edition"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Agent Code</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="sub_agent" required name="sub_agent" data-request='{"id":"17","search":""}' data-selectindex="0" data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"agent_unit","input":"#edit_f","select":"","encode":"false","multiselect":"false","msg":"Unit Required ","required":"true"}]' />
                                    <div class="input-group-addon btn" id="sub_agent_search" data-search="sub_agent">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input readonly type="text" value="" class="form-control sub_agent_clr" id="agent_name" name="agent_name" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Location</label>
                                <input readonly type="text" value="" class="form-control sub_agent_clr" id="agent_loc" name="agent_loc" />
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
                                <input class="hidden" type="text" name="edit_f" id="edit_f" value="<?php echo $this->user->user_unit_code;?>" />
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="col-lg-12 col-md-8 col-sm-12 col-xs-12">
                            <table class="table table-results" id="subscribe-table" style="width:100%">
                                <thead>
                                    <tr>

                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Address</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Phone</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Edition</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Agent Code</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"> Agent Name and Location</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">status</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($sub_list)) {
                                        foreach($sub_list as $sub) {?>
                                                    
                                    <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">
                                        
                                        <td class="sub-name"><?php echo $sub->sub_name; ?> </td>
                                        <td class="sub-address"><?php echo $sub->sub_address; ?> </td>
                                        <td class="sub-phn"><?php echo $sub->sub_phone; ?> </td>
                                        <td class="sub-edition"><?php echo $sub->edition_name; ?> </td>
                                         <td class="sub-agent-code"><?php echo $sub->agent_code; ?> </td>
                                        <td class="sub-agent"><?php echo $sub->agent_name.",".$sub->agent_location ; ?> </td>
                                        <td class="sub-status"><?php if( $sub->cancel_flag == Status::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                        <td class="remove_on_excel">
                                            <button data-id="<?php echo $sub->sub_code; ?>"class="btn btn-primary sub-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                            <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                            <?php //if($grp->cancel_flag == 0){?>
                                            <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php }
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
        var page = 'SUBSCRIBER-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
