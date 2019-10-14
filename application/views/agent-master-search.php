<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Cumulative-Receipt-Summary-Monthwise-".date("F-j-Y").".xlsx";
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
$today = date('d-m-Y');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Agents Search</title>
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
                <h1>Agents Search</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li class="active">Masters</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>

                <div class="box">
                    <div class="box-body table-responsive">                       
                        <form method="post" action="<?php echo base_url('Masters/AgentSearch?g_fe=cVghTra') ?>" name="ags_form" id="ags_form" onsubmit="return CIRCULATION.utils.formValidation(this);">                         
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Unit</label>
                                <select class="form-control" name="agent_unit" id="agent_unit">
                                    <?php foreach($units as $u) { ?>
                                    <option <?php echo isset($_GET['g_fe']) && (@$_POST['agent_unit'] == $u->unit_code) ? "selected" : ""; ?> value="<?php echo $u->unit_code; ?>"><?php echo $u->unit_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name/Code</label>
                                <input type="text" class="form-control" name="agent_name" id="agent_name" value="<?php echo @$_POST['agent_name']; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Status</label>
                              <select class="form-control" name="agent_status" id="agent_status">
                                <option value="-1">--Select--</option>
                                <?php $status = Enum::getAllConstants('Status');
                                foreach($status as $key => $value) { ?>
                                <option <?php echo isset($_GET['g_fe']) && (@$_POST['agent_status'] == $key) ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="submit" id="search-agency"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Masters/Agent');?>'" class="btn btn-block btn-primary" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Create</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>                          
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>             

                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results" border="1" id="records-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Code</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Name</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Address</td>                                    
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Location</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Phone</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Agent Type</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Status</td>
                                    <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" class="remove_on_excel no-sort">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($c = count($agents)) {
                                    foreach($agents as $a) { ?>
                                <tr>                                    
                                    <td><?php echo $a->agent_code; ?></td>
                                    <td><?php echo $a->agent_name; ?></td>
                                    <td><?php echo $a->agent_address; ?></td>                                    
                                    <td><?php echo $a->agent_location; ?></td>
                                    <td><?php echo $a->agent_phone; ?></td>
                                    <td><?php echo $a->copy_name; ?></td>
                                    <td><?php echo Enum::getConstant('Status',$a->cancel_flag); ?></td>                  
                                    <td class="remove_on_excel" align="center">
                                        <a target="_blank" href="<?php echo base_url('Masters/Agent?g_m=dmlldy1vbmx5&g_id='.base64_encode($a->agent_slno)); ?>">
                                            <button class="btn btn-primary edit-btn"><i class="fa fa-external-link" aria-hidden="true"></i></button> 
                                        </a>
                                        <a target="_blank" href="<?php echo base_url('Masters/Agent?g_m=ZWRpdC1tb2Rl&g_id='.base64_encode($a->agent_slno)); ?>">
                                            <button class="btn btn-primary edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </a>                                                                                
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='8' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" <?php echo $c === 0 ? "disabled" : ""; ?> onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close();" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
        var page = 'AGENT-SEARCH';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>            
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <?php } ?> 
</body>
</html>