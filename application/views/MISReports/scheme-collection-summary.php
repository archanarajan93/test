<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Scheme Collection Summary-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Scheme Collection Summary</title>
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
                <h1>Scheme Collection Summary</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Scheme Collection Summary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="oim-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/SchemeCollectionSummary?g_fe=xEdtsg'); ?>" onsubmit="return CIRCULATION.utils.formValidation(this);">
                           
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                                <label>Date Type</label>
                                <select id="select_date" name="select_date" class="form-control" tabindex="1">
                                    <option value="0"> Canvas Date</option>
                                    <option value="1"> Entry Date</option>
                                    <option value="2"> Copy Starting </option>
                                    <option value="3"> Copy Ending </option>
                                </select>
                            </div>  
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date From</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo date('d-m-Y'); ?>" tabindex="2" data-compare="#to_date" class="form-control" id="from_date" name="from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  autocomplete="off"/>
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date To</label>
                               <div class="input-group">
                                   <input required type="text" tabindex="3" value="<?php echo date('d-m-Y'); ?>" class="form-control" id="to_date" name="to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off"/>
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Units</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input required data-required="multi_sel_unit" autocomplete="off" value="<?php echo $this->user->user_unit_code;?>" tabindex="4" type="text" class="form-control" id="unit" name="unit" data-request='{"id":"13","search":""}' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="unit_search" data-search="unit"><i class="fa fa-search"></i></div>
                                    <span class="multiselect-text"><span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span>
                                    <input type="hidden" class="multi-search-selected multi_sel_unit" name="multi_sel_unit" value="<?php echo rawurlencode(json_encode(array(array("Code"=>$this->user->user_unit_code,"Name"=>$this->user->user_unit_name))));?>"></span>
                                    </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                                <label>Scheme</label>
                                <select id="copy_master" name="copy_master" class="hidden">
                                    <?php foreach($copy_lists as $copy){?>
                                    <option <?php if($copy->copy_name == 'SCHEME') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                    <?php }?>
                                </select>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off"  tabindex="5" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"35","search":""}' 
                                           data-criteria='[{"column":"CG.group_copy_code","input":"#copy_master","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" tabindex="6" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>
                <?php } elseif(isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table width="100%" class="table table-results">
                          <thead>
                            <tr>
                                <td colspan="8" style="background-color: #e7f2f4; font-weight: bold; color:#000000;">
                                    <strong>Scheme Collection Summary</strong> FROM <?php echo $_POST['from_date']; ?> to <?php echo $_POST['to_date'];?>&nbsp;<?php $multi_scheme=isset($_POST['multi_sel_scheme'])?$_POST['multi_sel_scheme']:''; if($multi_scheme) { $scheme_record = json_decode(rawurldecode($multi_scheme),true);  echo "| Scheme: "; foreach($scheme_record as $sch){ 
                                                                                                                                                                   echo " ".$sch["Name"];} }?>
                                </td>
                            </tr>
                            <tr>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Sl No</strong></td>
                              <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Unit Name</strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Count</strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Amount </strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Cash</strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Cheque</strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>PDC</strong></td>
                              <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;"><strong>Balance</strong></td>
                            </tr>
                          </thead>
                             <tbody>
                                    <?php
                          $sch_amount = $sch_cash = $sch_cheque = $sch_pdc = $sch_balance = $total_balance = 0;
                          if(count($scheme_rec)) {
                              $i=1;
                              
                              foreach($scheme_rec as $sh) {
                                  $sch_amount += $sh->sch_amount;
                                  $sch_cash += $sh->cash;
                                  $sch_cheque += $sh->cheque;
                                  $sch_pdc += $sh->pdc;
                                  $sch_balance = $sh->sch_amount-$sh->cash-$sh->cheque-$sh->pdc;
                                  $total_balance += $sch_balance;
                                  ?>
                                                   
                                    <tr data-save="false" data-grpid="<?php //echo $ct->group_code; ?>">
                                       
                                        <td class="sh-number"><?php echo $i++; ?></td>
                                        <td class="sh-name"><?php echo $sh->unit_name; ?></td>
                                        <td align="right" class="sh-add1"><?php echo $sh->sch_count; ?></td>
                                        <td align="right" class="sh-add1"><?php echo moneyFormat($sh->sch_amount); ?></td>
                                        <td align="right" class="sh-add1"><?php echo moneyFormat($sh->cash); ?></td>
                                        <td align="right" class="sh-add1"><?php echo moneyFormat($sh->cheque); ?></td>
                                        <td align="right" class="sh-add1"><?php echo moneyFormat($sh->pdc); ?></td>
                                        <td align="right" class="sh-add1"><?php echo moneyFormat($sch_balance); ?></td>
                                      
                                    </tr>
                                    <?php }
                          }
                          else {
                              echo "<tr><td colspan='8 ' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";  
                          } if(count($scheme_rec)) {?>
                                 <tr>
                                     <td bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong></strong></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong><?php echo count($sh->sch_count);?></strong></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong></strong><?php echo moneyFormat($sch_amount);?></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong></strong><?php echo moneyFormat($sch_cash);?></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong></strong><?php echo moneyFormat($sch_cheque);?></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong><?php echo moneyFormat($sch_pdc);?></strong></td>
                                     <td align="right" bgcolor="#CCCCCC"><strong><?php echo moneyFormat($total_balance);?></strong></td>
                                 </tr> 
                                 <?php }?>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
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
        var page = 'OTHER-INCOME-MONITOR';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>