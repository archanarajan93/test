<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Issue-Master-".date("F-j-Y").".xls";
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
    <title>Circulation | Issue Master</title>
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
                <h1>Issue Master</h1>
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
                        <?php echo form_open_multipart('Masters/CreateIssue','name="issue_form" id="issue_form" onsubmit="return CIRCULATION.utils.formValidation(this);" '); ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Issue ID</label>
                                <input autocomplete="off" readonly type="text" class="form-control" value="<?php echo $issue_id; ?>" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Issue Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="issue_name" name="issue_name" />
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Product</label> 
                                <select name="issue_product_code" id="issue_product_code" class="form-control" required>                                    
                                    <?php foreach($product_list as $p) { ?>
                                        <option value="<?php echo $p->product_code; ?>"><?php echo $p->product_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Publish Date</label>
                                <div class="input-group">
                                    <input required type="text" value="" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Issue Cover Image</label>
                                <input type="file" class="form-control" required name="issue_img" />
                            </div>                            

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">     
                                <label>&nbsp;</label>                           
                                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>
                            </div>                           
                        <?php echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>

                <!--Issue Records-->
                <div class="box">
                    <div class="box-header">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <select class="form-control" id="issue-product">
                                    <option value="">Select Product</option>
                                    <?php foreach($product_list as $p) { ?>
                                    <option <?php echo (isset($_GET['p']) && $_GET['p'] == $p->product_code) ? "selected" : ""; ?> value="<?php echo $p->product_code; ?>"><?php echo $p->product_name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-addon btn" style="background: #00a7c7;color: #FFF!important;" id="search-issue"><i class="fa fa-search"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-results" border="1">
                            <thead>
                                <tr>
                                    <td>Issue Name</td>
                                    <td>Product</td>
                                    <td>Publish Date</td>
                                    <td class="remove_on_excel">Cover Image</td>
                                    <td class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($issue)) {
                                    foreach($issue as $i) { ?>
                                <tr>
                                    <td><?php echo $i->issue_name; ?></td>
                                    <td><?php echo $i->product_name; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($i->issue_date)); ?></td>
                                    <td class="remove_on_excel">
                                        <?php if($i->issue_img_flag) { ?>
                                        <img src="<?php echo base_url('uploads/issue/'.$i->issue_product_code.'/'.$i->issue_code.'.jpg'); ?>" onclick="CIRCULATION.utils.enlargeImage($(this));" style="max-width:30px;" />
                                        <?php } ?>
                                    </td>
                                    <td class="remove_on_excel" align="center">
                                        <button data-id="<?php echo $i->issue_code; ?>" data-product="<?php echo $i->issue_product_code; ?>" class="btn btn-primary issue-edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button data-id="<?php echo $i->issue_code; ?>" data-product="<?php echo $i->issue_product_code; ?>" class="btn btn-danger issue-delete-btn"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='5' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
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
        var page = 'ISSUE-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
