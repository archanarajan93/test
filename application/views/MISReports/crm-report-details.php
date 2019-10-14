<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Monthly-Evaluation-Detailed-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Monthly Evaluation Detailed</title>
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
                <h1>Monthly Evaluation Detailed</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Monthly Evaluation Detailed</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <?php if($records) { ?>
                        <table class="export-table" width="100%" border="1" style="border:1px solid #c5c4c4 !important;">
                            <tbody>
                                <tr>
                                    <td width="15%">Report Date</td>
                                    <td style='text-align:left;' width="85%" colspan="15">
                                        <?php echo date("d-M-Y");?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($_POST['entry_level'] == '0') echo "First Entry Date"; else if($_POST['entry_level'] == '1') echo "Last Entry Date"; else echo "First & Last Entries Date"; ?>
                                    </td>
                                    <td colspan="15">
                                        &nbsp;<?php echo date('d-M-Y',strtotime($_POST['from_date'])); ?> to <?php echo date('d-M-Y',strtotime($_POST['to_date'])); ?>
                                    </td>
                                </tr>
                                <?php if(isset($_POST['multi_sel_unit'])) { ?>
                                <tr>
                                    <td>Unit</td>
                                    <td colspan="15">
                                        <?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_unit']),true),"UNIT")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['multi_sel_product'])) { ?>
                                <tr>
                                    <td>Product</td>
                                    <td colspan="15">
                                        &nbsp;<?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_product']),true),"Name")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['multi_sel_department'])) { ?>
                                <tr>
                                    <td>Department</td>
                                    <td colspan="15">
                                        &nbsp;<?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_department']),true),"Name")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['multi_sel_entrytype'])) { ?>
                                <tr>
                                    <td>Entry Type</td>
                                    <td colspan="15">
                                        &nbsp;<?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_entrytype']),true),"Name")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['customer'])) { ?>
                                <tr>
                                    <td>Customer</td>
                                    <td colspan="15">
                                        <?php echo $cust_array[$_POST['customer']]; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['multi_sel_response'])) { ?>
                                <tr>
                                    <td>Response Header</td>
                                    <td colspan="15">
                                        &nbsp;<?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_response']),true),"Name")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(isset($_POST['multi_sel_status'])) { ?>
                                <tr>
                                    <td>Entry Status</td>
                                    <td colspan="15">
                                        &nbsp;<?php echo implode(",",array_column(json_decode(rawurldecode($_POST['multi_sel_status']),true),"Name")); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                        <table width="100%">
                            <tr>
                                <td style="padding:5px 0px; font-weight:bold; color:#ff0000;" align="center" colspan="12">
                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                    &nbsp;No Records Found.
                                </td>
                            </tr>
                        </table>
                        <?php } ?>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                    
                </div>

                <?php if($records) { ?>
                <div style="padding:5px !important;" class="box box-info">
                    <div class="box-body pad">
                        <table id="report-table" class="export-table hover" width="100%" border="1">
                            <thead>
                                <tr>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Slno</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Token No</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;" class="remove_on_excel">View</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Date</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Days</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Unit</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Product</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Department</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Latest Header</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Latest Status</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Type</td>
                                    <td class="ellipsis" style="background-color: #7da4e8; color:#fff; font-weight:bold;">Name</td>
                                    <td class="ellipsis" style="background-color: #7da4e8; color:#fff; font-weight:bold;">Address</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Contact No</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Scheme</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Field Staff</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Agency Code</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Agency Name</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Agency Phone</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Created By</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Updated By</td>
                                    <td style="background-color: #7da4e8; color:#fff; font-weight:bold;">Updated Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach($records as $res) { ?>
                                <tr>
                                    <td>
                                        <?php echo $i++; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->token_no; ?>
                                    </td>
                                    <td class="remove_on_excel" align="center">
                                        <a target="_blank" href="<?php echo base_url();?>index.php/CRM/view/<?php echo base64_encode($res->token_no); ?>">
                                            <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $res->report_date; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->passed_days; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->unit_code; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_pdt_code; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_dept; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->res_desc; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->status_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_cus_type; ?>
                                    </td>
                                    <td class="ellipsis">
                                        <?php echo $res->crm_name;  ?>
                                    </td>
                                    <td class="ellipsis">
                                        <?php echo $res->crm_address; ?>
                                    </td>
                                    <td>
                                        <?php echo ($res->crm_phone > 0) ? $res->crm_phone : null; ?>
                                    </td>
                                    <td>
                                        <?php if($res->crm_scheme_name) { echo $res->crm_scheme_name;  } else { echo $res->crm_cust_id; }?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_fs_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_ag_code; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_ag_name; ?>
                                    </td>
                                    <td>
                                        <?php echo $res->crm_ag_phone; ?>
                                    </td>
                                    <td>
                                        <?php echo $user_data[$res->created_userid]; ?>
                                    </td>
                                    <td>
                                        <?php echo $user_data[$res->last_statusby_userid]; ?>
                                    </td>
                                    <td>
                                        <?php echo date("d-m-Y g:i:s A",strtotime($res->updated_date));  ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'MONTHLY-EVALUATION';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>