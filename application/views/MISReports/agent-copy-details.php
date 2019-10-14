<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$locale = 'hi';
$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
if(isset($_REQUEST['tableData']))
{
	$FileName="Agent-Details-1-Day-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Agent Details-1 Day</title>
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
                <h1>Agent Details-1 Day</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>
                            Home
                        </a>
                    </li>
                    <li>MIS Reports</li>
                    <li class="active">Agent Details-1 Day</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body">
                        <form id="agent-copy-pilot" method="post" action="<?php echo base_url('MISReports/AgentCopyDetails?g_fe=xEdtsg'); ?>"  onsubmit="return CIRCULATION.utils.formValidation(this);">
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Agent</label>
                               <div class="input-group search-module" data-selected="true">
                                    <input required autocomplete="off" value="<?php echo isset($_POST['agent'])?$_POST['agent']:'';?>" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <input type="hidden" name="agent_rec_sel" class="agent_clr" id="agent_rec_sel" value="<?php echo isset($_POST['agent_rec_sel'])?$_POST['agent_rec_sel']:'';?>">
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                               </div>
                           </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Name</label>
                                <input readonly type="text" value="<?php echo isset($_POST['agent_name'])?$_POST['agent_name']:'';?>" class="form-control agent_clr" id="agent_name" name="agent_name" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent Location</label>
                                <input readonly type="text" value="<?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?>" class="form-control agent_clr" id="agent_loc" name="agent_loc" />
                            </div>
                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>Date</label>
                               <div class="input-group">
                                   <input required type="text" value="<?php echo isset($_POST['copy_date'])?date("d-m-Y",strtotime($_POST['copy_date'])):date('d-m-Y'); ?>" class="form-control" id="copy_date" name="copy_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                   <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                               </div>
                           </div>
                           <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                               <label>Copy Type</label>
                               <select name="copy_type[]" id="copy_type[]" class="form-control select2" multiple>
                                    <?php  
                                        $copy_selected=array();
                                        $default_selected = 'selected';
                                        if(isset($_POST['copy_type'])){
                                            $default_selected = '';
                                        }
                                        foreach($copy_lists as $copy){?>
                                        <option <?php echo $default_selected; if(isset($_POST['copy_type'])&&in_array($copy->copy_code,$_POST['copy_type'])) {$copy_selected[] =$copy->copy_name; echo 'selected';};?>   value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                    <?php }?>
                                </select>
                           </div>                        

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <button class="btn btn-block btn-primary show-report" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                           </div>
                       </form>
                       <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                     </div>
                </div>
                <?php if(isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table width="60%" border="1" class="table table-results" style="width:60%">
                          <tr>
                            <td colspan="2" style="color:#000000; background:#e7f2f4; font-weight:bold; border:1px solid #ecf0f5;">
                                <b>Agent Details-1 Day | Date: <?php echo date("d-M-Y",strtotime($_POST['copy_date']));?> | Agent: <?php echo isset($_POST['agent'])?$_POST['agent'].' - ':'';?><?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?> | Copy Type: <?php echo implode(",",$copy_selected);?></b>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">ACM</td>
                            <td style="border:1px solid #ecf0f5;">ACM NAME</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Promoter</td>
                            <td style="border:1px solid #ecf0f5;">RAHUL S R</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Bureau</td>
                            <td style="border:1px solid #ecf0f5;">VARKALA</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Edition</td>
                            <td style="border:1px solid #ecf0f5;">TRIVANDRUM-CHIRAYANKEEZH</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Route</td>
                            <td style="border:1px solid #ecf0f5;">VARKALA</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Dropping Point</td>
                            <td style="border:1px solid #ecf0f5;">VARKALA MYTHANAM</td>
                          </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Address</td>
                                <td style="border:1px solid #ecf0f5;"><?php echo isset($_POST['agent_name'])?$_POST['agent_name'].', ':'';?><?php echo isset($_POST['agent_loc'])?$_POST['agent_loc']:'';?></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Agent Phone No.</td>
                                <td style="border:1px solid #ecf0f5;">+91 8891823491, 0471 2356553</td>
                            </tr>
                        </table>
                        
                        <table width="45%" class="table table-results" border="1"  style="width:45%">
                          <tr>
                            <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Copy Type</td>
                            <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" align="right">Copy</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Default Sale</td>
                            <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getDailyCanvassedReport()">2</a></td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Gurudeepam</td>
                            <td style="border:1px solid #ecf0f5;cursor:pointer;" align="right"><a onclick="getDailyCanvassedReport()">68</a></td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Internal Work</td>
                            <td style="border:1px solid #ecf0f5;cursor:pointer;" align="right"><a onclick="getDailyCanvassedReport()">5</a></td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Bureau</td>
                            <td style="border:1px solid #ecf0f5;cursor:pointer;" align="right"><a onclick="getDailyCanvassedReport()">5</a></td>
                          </tr>
                            <tr>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Sale Total</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;cursor:pointer;" align="right"><a onclick="getDailyCanvassedReport()">80</a></td>
                            </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">Ente Kaumudi</td>
                            <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getEnteKaumudiReport()">20</a></td>
                          </tr>
                            <tr>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Sponsor Total</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" align="right"><a onclick="getEnteKaumudiReport()">20</a></td>
                            </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">BBS 1 year 2000</td>
                            <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getSchemeDetailsReport()">2</a></td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #ecf0f5;">UNITY 2019 1 year 2250</td>
                            <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getSchemeDetailsReport()">3</a></td>
                          </tr>
                            <tr>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Schemes Total</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" align="right"><a onclick="getSchemeDetailsReport()">5</a></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Free 1</td>
                                <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getDailyCanvassedReport()">68</a></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">Free 2</td>
                                <td style="border:1px solid #ecf0f5;" align="right"><a onclick="getDailyCanvassedReport()">5</a></td>
                            </tr>
                            <tr>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Free Total</td>
                                <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" align="right"><a onclick="getDailyCanvassedReport()">73</a></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                                <td style="border:1px solid #ecf0f5;">&nbsp;</td>
                            </tr>
                          <tr>
                            <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Print Order</td>
                            <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" align="right">120</td>
                          </tr>
                        </table>
                        <table width="45%" class="table table-results" border="1"  style="width:45%">
                          <tr>
                            <td  colspan="3" style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Bundles</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">1</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">Bundle 1</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">75</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">2</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">Bundle 2</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">25</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">3</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">School 1</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">10</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">4</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">School 2</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">5</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">5</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">School 3</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">5</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">6</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">School 4</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">5</td>
                          </tr>
                          <tr>
                          	<td style="border:1px solid #ecf0f5;text-align:left;">&nbsp;</td>
                            <td style="border:1px solid #ecf0f5;text-align:left;">&nbsp;</td>
                            <td style="border:1px solid #ecf0f5;text-align:right;" align="right">&nbsp;</td>
                          </tr>
                          <tr>
                          	<td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                            <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Bundles</td>
                            <td align="right" style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">6</td>
                          </tr>
                          <tr>
                          	<td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">&nbsp;</td>
                            <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Copies</td>
                            <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" align="right">125</td>
                          </tr>
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
                <form method="post" action="<?php echo base_url('MISReports/CRMSchemeReports?g_fe=xEdtsg');?>" target="_blank" id="schdetails_form">
                    <input type="hidden" />
                </form>
                <form method="post" action="<?php echo base_url('MISReports/DailyCanvassedCopiesDetails');?>" target="_blank" id="dailycanv_form">
                    <input type="hidden" />
                </form>
                <form method="post" action="<?php echo base_url('/MISReports/EnteKaumudyDetailed');?>" target="_blank" id="entekaumudi_form">
                    <input type="hidden" />
                </form>
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
        var page = 'AGENT-COPY-DETAILS';
        function getSchemeDetailsReport() {
            $("#schdetails_form").submit();
        }
        function getDailyCanvassedReport() {
            $("#dailycanv_form").submit();
        }
        function getEnteKaumudiReport() {
            $("#entekaumudi_form").submit();
        }
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/mis-reports.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>