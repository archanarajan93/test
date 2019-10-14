<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Scheme-Reports-Contributors-Non-Contributors-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Scheme Reports - Contributors/Non Contributors</title>
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
                <h1>Scheme Reports - Contributors/Non Contributors</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li class="active">MIS Reports</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="sr-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/SchemeReports?g_fe=xEdtsg'); ?>">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                              <label>Date Type</label>
                              <select class="form-control">
                                  <option>Copy Starting</option>
                                  <option>Entry</option>
                                  <option>Canvassed</option>
                              </select>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date From</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date To</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="issue_date" name="issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                               <label>Units</label>
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />                                     
                                   <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Scheme Groups</label>
                               <select id="copy_master" name="copy_master" class="hidden" multiple>
                                 <?php foreach($copy_lists as $copy){?>
                                   <option <?php if($copy->copy_name == 'SCHEME') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                 <?php }?>
                               </select>
                               <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="true" placeholder="" 
                                           data-criteria='[{"column":"group_copy_code","input":"#copy_master","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' />
                                    <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                               </div>
                           </div>                           

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Scheme</label>                                
                               <div class="input-group search-module" data-selected="true">
                                   <input autocomplete="off" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="true" placeholder=""
                                          data-criteria='[{"column":"group_code","input":".multi_sel_scheme","select":"","encode":"true","multiselect":"true","msg":"Scheme Groups Required","required":"true"}]' />
                                   <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <?php } elseif(isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body table-responsive">
                    <table width="100%" border="1" class="table table-results">
                      <thead>
                        <tr>
                          <td colspan="10" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
                            <strong>
                                Scheme Reports - Contributors/Non Contributors From 01-Sept-2019 to 28-Jun-2019 | Date Type: Copy Starting Date | Scheme Group: Unity, BBS | Schemes: BBS 1 YEAR 2000, SBS 1 YEAR 2000                                 
                            </strong>
                          </td>
                        </tr>
                        <tr>
                          <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>SlNo</strong></td>
                          <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Name</strong></td>
                          <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Department</strong></td>
                          <td align="right"  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Target</strong></td>
                          <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Count</strong></td>
                          <td align="right"  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Amount</strong></td>
                          <td align="right"  style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Balance</strong></td>
                          <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Emp Code</strong></td>
                          <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Company</strong></td>
                          <td align="center" style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Unit</strong></td>
                        </tr>
                      </thead>
                        <tbody>
                            <tr>
                                <td style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color:#cfcdcd;border:1px solid #ecf0f5;"><strong>THIRUVANANTHAPURAM</strong></td>
                                <td style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="right"  style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="center" style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="right"  style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="right"  style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="center" style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="center" style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td align="center" style="background-color:#cfcdcd;border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="color:#D10000;"><strong>FINANCE &amp; ACCOUNTS-COMM</strong></td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>MOHANAN N</td>
                                <td>FINANCE &amp; ACCOUNTS</td>
                                <td align="right">8,000</td>
                                <td align="right">4</td>
                                <td align="right">9,000</td>
                                <td align="right">0</td>
                                <td align="center">KKCC799</td>
                                <td align="center">KC</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>SAJINA KHANAM</td>
                                <td>FINANCE &amp; ACCOUNTS</td>
                                <td align="right">8,000</td>
                                <td align="right">1</td>
                                <td align="right">2,250</td>
                                <td align="right">5,750</td>
                                <td align="center">C1123</td>
                                <td align="center">KK</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>Total</strong></td>
                                <td>&nbsp;</td>
                                <td align="right"><strong>16,000</strong></td>
                                <td align="right"><strong>5</strong></td>
                                <td align="right"><strong>11,250</strong></td>
                                <td align="right"><strong>5,750</strong></td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="color: #D10000"><strong>HR - ADMINISTRATION</strong></td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>ARUN M V</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>PRAMOD KUMAR K</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>Total</strong></td>
                                <td>&nbsp;</td>
                                <td align="right"><strong>16,000</strong></td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">16,000</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="color: #D10000"><strong>HR - ADMINISTRATION-COMM</strong></td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="right">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                                <td align="center">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>HARIKRISHNADAS S</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>K V VIJAYAN</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>PRAMOD G A</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>PRAN S R</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>SHARAN RAJ R</td>
                                <td>HR - ADMINISTRATION</td>
                                <td align="right">8,000</td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">8,000</td>
                                <td align="center">C600</td>
                                <td align="center">RPP</td>
                                <td align="center">TVM</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><strong>Total</strong></td>
                                <td>&nbsp;</td>
                                <td align="right"><strong>16,000</strong></td>
                                <td align="right">0</td>
                                <td align="right">0</td>
                                <td align="right">40,000</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;"><strong>Grand Total</strong></td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right"><strong>32,000</strong></td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">10</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">11,250</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">61,750</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>                                                
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.close()" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
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
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'SCHEME-REPORTS';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>