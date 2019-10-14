<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Users-".date("F-j-Y").".xlsx";
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
    <title>Circulation | User Search</title>
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
                <h1>User Search</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">Admin Tools</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive ">
                        <?php echo form_open_multipart('AdminTools/SearchUser?g_fe=c2VhcmNo ','name="user_search" id="user_search" '); ?>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Search User</label>
                            <input type="text" class="form-control" id="search_user" name="search_user" value="<?php echo @$_POST['search_user']; ?>" autocomplete="off" />
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Unit</label>
                            <select name="user_unit_code" id="" class="form-control">
                                <option value="">Select</option>
                                <?php foreach($unit_list as $list_unit) { ?>
                                <option <?php if(@$_POST['user_unit_code']==$list_unit->unit_code) { ?> selected <?php } ?> value="<?php echo $list_unit->unit_code; ?>"><?php echo $list_unit->unit_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>                                              
                        <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-primary add-btn" id="add" name="Add" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;<font class="hidden-xs hidden-sm">Search</font></button>
                        </span>
                        <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;<font class="hidden-xs hidden-sm">Close</font></button>
                        </span>
                        <span class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('AdminTools/User');?>'" class="btn btn-block btn-primary" type="button"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<font class="hidden-xs hidden-sm">New User</font></button>
                        </span>
                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body">
                        <table class="table table-results <?php echo count($search_list) == 0 ? "no-data-tbl" : ""; ?>" id="additional-table"  width="100%">
                                <thead>
                                    <tr>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">#</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Name</td>                                        
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Unit</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Status</td>
                                     </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($search_list))
                                    {
                                        $i=1;
                                        foreach($search_list as $list_search) {
                                    ?>
                                    <tr class="show-user-details" style="cursor:pointer;" data-user="<?php echo $list_search->user_id; ?>"> 
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $list_search->user_emp_name; ?></td>                                        
                                        <td><?php echo $list_search->unit_name; ?></td> 
                                        <td>
                                            <?php 
                                            if($list_search->user_disable == '1') { 
                                                echo "<font style='color:red'><i class='fa fa-lock' aria-hidden='true'></i> DISABLED</font>"; 
                                            } else {
                                                echo "<font style='color:green'><i class='fa fa-check-circle' aria-hidden='true'></i> ACTIVE</font>";
                                            }
                                            ?>
                                        </td>                                        
                                    </tr>
                                    <?php 
                                            $i++;
                                        }
                                    }else {
                                    echo '<tr><td class="no-records" colspan="4"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No Records Found</td></tr>';
                                    }
                                    ?> 
                                </tbody>
                            </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->          
        </div>
        <!-- /.content-wrapper -->
       <?php $this->load->view('inc/footer'); $this->load->view('inc/help');?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'USER-SEARCH';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/admin-tools.js?v='.$this->config->item('version')); ?>"></script>    
     <?php }?>
</body>
</html>
