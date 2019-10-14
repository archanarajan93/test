<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="CRM-Search-".date("F-j-Y").".xlsx";
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
<?php $today = date('d-m-Y'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | CRM Search</title>
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
                <h1>CRM Search</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">CRM</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="<?php echo base_url('CRM/Search'); ?>" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                         <div class="row form-group form-btns" data-update="false">
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>Token No.</label>
                                <input type="text" class="form-control" value="<?php if(isset($_POST['token_no'])) echo $_POST['token_no'];?>" id="token_no" name="token_no" />
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>From</label>
                                <span class="input-group">
                                    <span class="input-group-addon link" id="from_icon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input data-datemask="DD-MM-YYYY" type="text" class="form-control datepicker" value="<?php if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo $today; } ?>" name="from_date" id="from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                </span>
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>To</label>
                                <span class="input-group">
                                    <span class="input-group-addon link" id="to_icon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input data-datemask="DD-MM-YYYY" data-from="#from_date" value="<?php if(isset($_POST['to_date'])) { echo $_POST['to_date']; } else { echo $today; } ?>" type="text" class="form-control datepicker" name="to_date" id="to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                </span>
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>
                                    Unit
                                    <span class="text-red">[F2]</span>
                                </label>
                                <span class="input-group">
                                    <input data-request='{"id":"13","search":"Code"}' data-select="{}" type="text" class="form-control" name="unit" value="<?php if(isset($_POST['unit'])) echo $_POST['unit']; ?>" placeholder="Press 'F2' here..." id="unit" />
                                    <input type="hidden" name="unit_rec_sel" class="unit_clr" id="unit_rec_sel" value="<?php if(isset($_POST['unit_rec_sel'])) echo @$_POST['unit_rec_sel'];  ?>" />
                                    <span id="unit_search" data-search="unit" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </span>
                            </span>
                            <span class="col-lg-12 visible-lg"></span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>
                                    Product
                                    <span class="text-red">[F2]</span>
                                </label>
                                <span class="input-group">
                                    <input data-request='{"id":"18","search":"Product"}' data-select="{}" type="text" class="form-control" name="product" value="<?php if(isset($_POST['product'])) echo @$_POST['product']; else echo "DLY";?>" placeholder="Press 'F2' here..." id="product" />
                                    <input type="hidden" name="product_rec_sel" class="product_clr" id="product_rec_sel" value="<?php if(isset($_POST['product_rec_sel'])) echo @$_POST['product_rec_sel']; else echo rawurlencode(json_encode(array("Code"=>"DLY","Name"=>"DAILY")));?>" />
                                    <span id="product_search" data-search="product" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </span>
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>
                                    Agent Code
                                    <span class="text-red">[F2]</span>
                                </label>
                                <span class="input-group">
                                    <input data-request='{"id":"17","search":"Code"}' data-select="{}" type="text" class="form-control" name="agent" value="<?php if(isset($_POST['agent'])) echo @$_POST['agent'];?>" placeholder="Press 'F2' here..." id="agent" data-criteria='[{"column":"agent_unit","input":"#unit_rec_sel","select":"Code","encode":"true","msg":"Please select unit!"}]' />
                                    <input type="hidden" name="agent_rec_sel" class="agent_clr" id="agent_rec_sel" value="<?php if(isset($_POST['agent_rec_sel'])) echo @$_POST['agent_rec_sel'];?>" />
                                    <span id="agent_search" data-search="agent" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </span>
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php if(isset($_POST['cus_name'])) echo $_POST['cus_name'];?>" id="agent_name" name="cus_name" />
                            </span>
                            <span class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label>Phone</label>
                                <input type="text" class="form-control" value="<?php if(isset($_POST['cus_phone'])) echo $_POST['cus_phone'];?>" id="agent_contact" name="cus_phone" />
                            </span>
                            <span class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                                <label class="col-xs-12">&nbsp;</label>
                                <button type="submit" class="btn btn-report" name="show_crm">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    SHOW
                                </button>
                                &nbsp;
                                <button type="button" onclick="window.location='<?php echo base_url();?>index.php/CRM/create'" class="btn btn-info">
                                    <i class="fa fa-file-text" aria-hidden="true"></i>
                                    NEW
                                </button>
                                &nbsp;
                                <span class="col-xs-12 visible-xs">&nbsp;</span>
                                <button type="button" onclick="window.location='<?php echo base_url();?>index.php/dashboard'" class="btn btn-danger">
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                    CLOSE
                                </button>
                            </span>
                        </div>  
                            </form>         
                        <?php //echo form_close();?>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                </div>
                </div>
                
                <!-- Records-->
            <div class="box box-info" <?php if(!isset($crm_data)){ echo 'style="display:none;"';}?>>            
              <div class="box-body pad table-responsive table-wrap">
                  <div id="report"></div>
                  <table class="table-bordered hover" style="white-space:nowrap; width:100%;" border="1">
                      <thead>
                          <tr>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Token No.</td>
                              <td class="report-head remove_on_excel" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Date</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Unit</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Product</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Dept.</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Name</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Address</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Contact No.</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Scheme</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Last Response</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Last Status</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Created By</b></td>
                              <td class="report-head" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;"><b>Created At</b></td>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if(0 == count($crm_data)){?>
                            <tr><td align="center" colspan="12" class="text-red" style="padding: 25px !important;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp; No records Found!</td></tr>
                          <?php 
                                }
                                else
                                {
                                    $department = array(
                                                    0 => "PMD",
                                                    1 => "SMD",
                                                    2 => "EDT");
                          foreach($crm_data as $crm){?>                          
                          <tr>
                              <td><?php echo $crm->token_no;?></td>
                              <td>
                                  <a class="text-blue" target="_blank" href="<?php echo site_url("CRM/view/".base64_encode($crm->token_no));?>"><i class="fa fa-share-square-o" aria-hidden="true">&nbsp;</i>View</a>&nbsp;
                                  <a class="text-blue" target="_blank" href="<?php echo site_url("CRM/edit/".base64_encode($crm->token_no));?>"><i class="fa fa-edit" aria-hidden="true">&nbsp;</i>Edit</a>
                              </td>
                              <td><?php echo $crm->token_date;?></td>
                              <td><?php echo $crm->unit_code;?></td>
                              <td><?php echo $crm->crm_pdt_code;?></td>
                              <td><?php echo $department[$crm->crm_dept_code];?></td>
                              <td><?php echo $crm->crm_name;?></td>
                              <td><?php echo $crm->crm_address;?></td>
                              <td><?php echo $crm->crm_phone;?></td>
                              <td><?php echo $crm->crm_scheme_name;?></td>
                              <td><?php echo $crm->res_desc;?></td>
                              <td><?php echo $crm->status_name;?></td>
                              <td><?php echo $crm->user_emp_name;?></td>
                              <td><?php echo $crm->created_at;?></td>
                          </tr>
                          <?php }
                                }?>
                      </tbody>
                      <tfoot>
                          <tr><td align="center" colspan="12" style="padding: 15px !important;">&nbsp;</td></tr>
                      </tfoot>
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
        var page = 'CRM-SEARCH';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/crm.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/Help.js?v='.$this->config->item('version')); ?>"></script>
    <?php }?>
</body>
</html>
