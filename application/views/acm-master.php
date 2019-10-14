<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="ACM-Master-".date("F-j-Y").".xls";
	header('Content-Type: application/force-download');
	header('Content-disposition: attachment; filename='.$FileName.'');
	header("Pragma: ");
	header("Cache-Control: ");
	echo $_REQUEST['tableData'];
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | ACM Master</title>
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
                <h1>ACM Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
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
                        <?php echo form_open_multipart('Masters/CreateACM','name="acm_form" id="acm_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>ACM Code</label>
                                <input autocomplete="off" readonly type="text" class="form-control" value="<?php echo $acm_code; ?>" />
                                <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>ACM Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="acm_name" name="acm_name" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Phone</label>
                                <input autocomplete="off" required type="number" class="form-control" id="acm_phone" name="acm_phone" />
                            </div>

                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>Region</label>
                            <div class="input-group search-module" data-selected="true">
                                <input autocomplete="off" value="" required type="text" class="form-control" id="region" name="region" data-request='{"id":"21","search":"Name"}' 
                                       data-criteria='[{"column":"region_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]'
                                       data-select="{}" data-multiselect="false" placeholder="Select Region" />
                                <div class="input-group-addon btn" id="region_search" data-search="region"><i class="fa fa-search"></i></div>
                            </div>
                        </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Status</label>
                                <select name="acm_status" id="acm_status" class="form-control">
                                    <option value="0">Active</option>
                                    <option value="1">Disabled</option>
                                </select>
                            </div>                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">                               
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>

                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>

                <!--ACM Records-->
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results" border="1" id="records-table">
                            <thead>
                                <tr>
                                    <td>Unit</td>
                                    <td>ACM Name</td>
                                    <td>Phone</td>
                                    <td>Region</td>
                                    <td>Status</td>
                                    <td class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($acm)) {
                                    foreach($acm as $a) { ?>
                                <tr>                                    
                                    <td><?php echo $a->acm_unit; ?></td>
                                    <td class="acm-name"><?php echo $a->acm_name; ?></td>
                                    <td class="acm-phone"><?php echo $a->acm_phone; ?></td>
                                    <td class="acm-area"><?php echo $a->region_name; ?></td>
                                    <td class="acm-status"> <?php if( $a->cancel_flag == ResidenceStatus::Active){  echo "Active";} else{echo "Disable"; }?></td>
                                    <td class="remove_on_excel" align="center">
                                        <button data-id="<?php echo $a->acm_code; ?>" class="btn btn-primary acm-edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button data-id="<?php echo $a->acm_code; ?>"  <?php echo $a->cancel_flag==1? "disabled":""; ?> class="btn btn-danger acm-delete-btn"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='6' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
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
        var page = 'ACM-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
