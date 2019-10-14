<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Agent-Groups-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Agent Groups</title>
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
                <h1>Agent Groups Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Masters</li>
                    <li class="active">Agent Groups</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form action="Masters/CreateAgentGroups" name="agent_groups_form" id="agent_groups_form" method="post" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Group Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="aggroup_name" name="aggroup_name" />
                            </div>
                            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                                <label>Agents</label>
                                <table style="width:100%;" id="agents-tbl">
                                    <tr>
                                        <td style="width:28%;">
                                            <div class="input-group search-module" data-selected="true">
                                                <input autocomplete="off" value="" required type="text" class="form-control agent" id="agent_1" name="agent_1" data-request='{"id":"17","search":"Name"}' data-select="{}" data-multiselect="false" placeholder="" data-selectIndex="0" />
                                                <div class="input-group-addon agent_search btn" id="agent_1_search" data-search="agent_1"><i class="fa fa-search"></i></div>
                                            </div>
                                        </td>
                                        <td style="width:37%;"><input type="text" class="form-control ag_nme agent_1_clr" value="" readonly /></td>
                                        <td style="width:32%;"><input type="text" class="form-control ag_loc agent_1_clr" value="" readonly /></td>
                                        <td style="width:3%;" class="action-btns">
                                            <span style="margin-left: 9px;" class="add-btn"><i class="fa fa-plus-square" style="color:dodgerblue; font-size:17px;" aria-hidden="true"></i></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Upload Agents</label>
                                <input autocomplete="off" required type="file" class="form-control" id="agent_lists" name="agent_lists" accept="text/plain"/>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 hide" id="upld_agents_box">
                                <label>&nbsp;</label>
                                <table class="table table-sec" id="upld_agents_tbl">
                                    <thead>
                                        <tr>
                                            <td><input type="checkbox" id="upload_ag_selall" style="display:none;" /></td>
                                            <td>Code</td>
                                            <td>Name</td>
                                            <td>Location</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="loading"><td colspan="4" align="center"><img src="<?php echo base_url('assets/imgs/blue-loader.gif');?>" width="200" /></td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <button class="btn btn-block btn-primary" type="button" id="add-agent-groups"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>

                <!--Agent Groups Records--><?php "hgh".count($agent_groups);?>
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php if(count($agent_groups)==0){ echo 'no-data-tbl';}?>" border="1" id="aggroup-tbl" style="width:45%">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Code</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Group</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created By</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($agent_groups)) {
                                    foreach($agent_groups as $ag_grp) { ?>
                                <tr>                                    
                                    <td style="border:1px solid #ecf0f5;"><?php echo $ag_grp->agent_group_code; ?><input type="hidden" name="aggroup-code" id="aggroup-code" value="<?php echo $ag_grp->agent_group_code; ?>"/></td>
                                    <td style="border:1px solid #ecf0f5;" class="aggroup-name"><?php echo $ag_grp->agent_group_name; ?></td>
                                    <td style="border:1px solid #ecf0f5;" class="aggroup-name"><?php echo $ag_grp->created_name; ?></td>
                                    <td style="border:1px solid #ecf0f5;" class="remove_on_excel" align="center">
                                        <?php if($ag_grp->created_by != $this->user->user_id){?>
                                        <button data-id="<?php echo $ag_grp->agent_group_code; ?>" class="btn btn-warning view-agent-groups"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        <?php } else{?>
                                        <button data-id="<?php echo $ag_grp->agent_group_code; ?>" class="btn btn-warning view-agent-groups"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        <button data-id="<?php echo $ag_grp->agent_group_code; ?>" class="btn btn-primary edit-agent-groups"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button data-id="<?php echo $ag_grp->agent_group_code; ?>" class="btn btn-danger del-agent-groups"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='3' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
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
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'AGENT-GROUPS-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
