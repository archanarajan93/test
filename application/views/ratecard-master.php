<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Rate-Card-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Rate Card</title>
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
                <h1>Rate Master</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>Admin Tools</li>
                    <li class="active">Rate Master</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box box-info" style="max-width:350px">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sale Rate Master</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form method="post" action="">
                        <div class="box-body">
                            <table class="table table-sec">
                                <tr>
                                    <td width="75%">Rate Per Copy</td>
                                    <td width="25%"><input type="text" class="form-control isNumberKey" isDecimal="true" id="copy_rate" value="<?php echo $sales_rates["DLY"]->rate_amount;?>" style="text-align:right;padding:8px !important;"/></td>
                                </tr>
                                <tr>
                                    <td width="75%">Sunday Rate Per Copy</td>
                                    <td width="25%"><input type="text" class="form-control isNumberKey" isDecimal="true" id="sunday_copy_rate" value="<?php echo $sales_rates["SUN"]->rate_amount;?>" style="text-align:right;padding:8px !important;"/></td>
                                </tr>
                                <tr>
                                    <td width="75%">Ente Kaumudi</td>
                                    <td width="25%"><input type="text" class="form-control isNumberKey" isDecimal="true" id="ek_copy_rate" value="<?php echo $sales_rates["EK"]->rate_amount;?>" style="text-align:right;padding:8px !important;"/></td>
                                </tr>
                            </table>
                            <!--<span class="col-lg-8"></span>
                            <span class="col-lg-4"></span>
                            <span class="col-lg-8">Rate Per Copy</span>
                            <span class="col-lg-4"><input type="text" class="form-control isNumberKey" value="7.5" /></span>
                            <span class="col-lg-8">Rate Per Copy</span>
                            <span class="col-lg-4"><input type="text" class="form-control isNumberKey" value="7.5" /></span>-->
                        </div>
                        <div class="box-footer">
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                                <button class="btn btn-block btn-primary" type="button" id="save-sales-rates"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box box-warning" style="max-width:900px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Scheme Rate Master</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="overflow-x: auto;">
                            <form action="<?php echo base_url('AdminTools/SaveSchemeCopyRate');?>" name="scheme_rate_form" id="scheme_rate_form" method="post" onsubmit="return CIRCULATION.utils.formValidation(this);" >
                                <table class="table table-sec" style="width:500px">
                                    <tr>
                                        <td>Copy Group</td>
                                        <td colspan="6">
                                            <select id="copy_group_code" name="copy_group_code" class="form-control" required>
                                                <?php foreach($copy_groups as $cpygrp){?>
                                                <option value="<?php echo $cpygrp->group_code;?>"><?php echo $cpygrp->group_name;?></option>
                                                <?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Copy Type</td>
                                        <td colspan="6">
                                            <div class="input-group search-module" data-selected="true" style="width:100%">
                                                <input required data-required="copy_type_clr" autocomplete="off" value="" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"35","search":""}' data-criteria='[{"column":"CT.group_code","input":"#copy_group_code","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                                <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Duration</td>
                                        <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="years" id="years" value="" style="text-align:right;padding:8px !important;" /></td>
                                        <td>Year</td>
                                        <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="months" id="months" value="" style="text-align:right;padding:8px !important;" /></td>
                                        <td>Month</td>
                                        <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="days" id="days" value="" style="text-align:right;padding:8px !important;" /></td>
                                        <td>Days</td>
                                    </tr>
                                    <tr>
                                        <td>Rate</td>
                                        <td colspan="5"><input type="text" required class="form-control isNumberKey" isDecimal="true" name="rate" id="rate" value="" style="text-align:right;padding:8px !important;" /></td>
                                        <td>Rs</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><button class="btn btn-block btn-primary" type="submit" style="width:205px;"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button></td>
                                        <td colspan="4"><button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button" style="width:205px;"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-results <?php if(count($schemes_rates)==0){ echo 'no-data-tbl';}?>" border="1" id="schrate-tbl" style="width:100%">
                                <thead>
                                    <tr>
                                        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy Group</td>
                                        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy Type</td>
                                        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Duration</td>
                                        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5; text-align:right">Amount</td>
                                        <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                if(count($schemes_rates)) {
                                    foreach($schemes_rates as $sch_rte) {
                                    ?>
                                    <tr>
                                        <td style="border:1px solid #ecf0f5;" class="cpygrp-name"><?php echo $sch_rte->group_name; ?><input type="hidden" name="cpygrp-code" id="cpygrp-code" value="<?php echo $sch_rte->rate_code; ?>" /></td>
                                        <td style="border:1px solid #ecf0f5;" class="cpygrp-type"><?php echo $sch_rte->copytype_name; ?></td>
                                        <td style="border:1px solid #ecf0f5;" class="schrate-dur"><?php echo $sch_rte->rate_sch_years?$sch_rte->rate_sch_years." yr(s)":''; ?> <?php echo $sch_rte->rate_sch_months?$sch_rte->rate_sch_months." mnth(s)":''; ?> <?php echo $sch_rte->rate_sch_days?$sch_rte->rate_sch_days." day(s)":''; ?></td>
                                        <td style="border:1px solid #ecf0f5; text-align:right;" class="schrate-amt"><?php echo $sch_rte->rate_amount; ?></td>
                                        <td style="border:1px solid #ecf0f5;" class="remove_on_excel" align="center">
                                            <button data-id="<?php echo $sch_rte->rate_code; ?>" class="btn btn-primary edit-sch-rates"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    <?php
 }
                                }
                                else {
                                    echo "<tr><td colspan='5' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box box-danger" style="max-width:350px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">Other Products</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form method="post" action="">
                        <div class="box-body">
                            <table class="table table-sec">
                                <?php foreach($other_products as $prdt){?>
                                <tr>
                                    <td width="75%"><?php echo $prdt->product_name;?></td>
                                    <td width="25%"><input type="text" class="form-control isNumberKey other_prdt" data-prdtcode="<?php echo $prdt->product_code;?>" isDecimal="true" id="<?php echo $prdt->product_code;?>" value="<?php echo isset($other_prdt_rates[$prdt->product_code])?$other_prdt_rates[$prdt->product_code]->rate_amount:0;?>" style="text-align:right;padding:8px !important;" /></td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                                <button class="btn btn-block btn-primary" type="button" id="other-prdt-rates"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>
                            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-6">
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </div>
                    </form>
                    
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
        var page = 'RATE-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?> 
    <script src="<?php echo base_url('assets/js/admin-tools.js?v='.$this->config->item('version')); ?>"></script> 
    <?php }?>
</body>
</html>
