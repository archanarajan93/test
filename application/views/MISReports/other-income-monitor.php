<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Other-Income-Monitor-".date("F-j-Y").".xls";
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
    <title>Circulation | Other Income Monitor</title>
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
                <h1>Other Income Monitor</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('Dashboard');?> ">
                            <i class="fa fa-dashboard"></i>Home
                        </a>
                    </li>
                    <li>Reports</li>
                    <li class="active">Other Income Monitor</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php if(!isset($_GET['g_fe'])) { ?>
                <div class="box">
                    <div class="box-body">
                        <form id="oim-pilot" method="post" target="_blank" action="<?php echo base_url('MISReports/OtherIncomeMonitor?g_fe=xEdtsg'); ?>">
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
                                   <span class="multiselect-text"><span class="selected-res">1 Selected</span><span class="clear-btn"><i class="fa fa-close"></i></span><input type="hidden" class="multi-search-selected multi_sel_unit" name="multi_sel_unit" value="<?php echo rawurlencode(json_encode(array(array("Code"=>$this->user->user_unit_code,"Name"=>$this->user->user_unit_name))));?>"></span>
                               </div>
                           </div>

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12" id="groupwise-wrap">
                               <label>Scheme</label>
                               <select id="copy_master" name="copy_master" class="hidden" multiple>
                                   <?php foreach($copy_lists as $copy){?>
                                   <option <?php if($copy->copy_name=='SPONSOR' || $copy->copy_name == 'SCHEME') echo 'selected';?> value="<?php echo $copy->copy_code;?>"><?php echo $copy->copy_name;?></option>
                                   <?php }?>
                               </select>
                               <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" type="text" class="form-control" id="scheme" name="scheme" data-request='{"id":"15","search":""}' data-criteria='[{"column":"group_copy_code","input":"#copy_master","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' data-select="{}" data-multiselect="true" placeholder="" />
                                    <div class="input-group-addon btn" id="scheme_search" data-search="scheme"><i class="fa fa-search"></i></div>
                               </div>
                           </div>                           

                           <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                               <label>&nbsp;</label>
                               <button class="btn btn-block btn-primary show-report" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Show</button>
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
                        <table width="100%" class="table table-results" border="1">
                          <thead>
                            <tr>
                                <td colspan="7">
                                    <strong>OTHER INCOME MONITOR</strong> FROM 01-JUL-2019 to 31-JUL-2019&nbsp;|&nbsp;SCHEME : BBS,SDS,SPONSORED,ENTE KAUMUDI
                                </td>
                            </tr>
                            <tr>
                              <td style="color:#FFFFFF" bgcolor="#00a7c7"><strong>Units</strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>BBS</strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>SDS</strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>SPONSORED </strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>ENTE KAUMUDI</strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>Dishonoured Amount</strong></td>
                              <td style="color:#FFFFFF" align="right" bgcolor="#00a7c7"><strong>Total</strong></td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>THIRUVANANTHAPURAM</td>
                              <td align="right">1,23,456</td>
                              <td align="right">56,456</td>
                              <td align="right">4,895</td>
                              <td align="right">6,789</td>
                              <td align="right">5,789</td>
                              <td align="right">5,45,895</td>
                            </tr>
                            <tr>
                              <td>KOLLAM</td>
                              <td align="right">99,456</td>
                              <td align="right">12,456</td>
                              <td align="right">32,456</td>
                              <td align="right">5,800</td>
                              <td align="right">3,569</td>
                              <td align="right">3,55,000</td>
                            </tr>
                            <tr>
                              <td>ALAPUZHA</td>
                              <td align="right">2,21,666</td>
                              <td align="right">10,989</td>
                              <td align="right">55,455</td>
                              <td align="right">9,404</td>
                              <td align="right">9,456</td>
                              <td align="right">9,22,125</td>
                            </tr>
                            <tr>
                              <td>PATHANAMTHITTA</td>
                              <td align="right">88,000</td>
                              <td align="right">69,565</td>
                              <td align="right">12,000</td>
                              <td align="right">9,000</td>
                              <td align="right">7,000</td>
                              <td align="right">1,25,444</td>
                            </tr>
                            <tr>
                              <td>KOTTAYAM</td>
                              <td align="right">1,23,456</td>
                              <td align="right">12,456</td>
                              <td align="right">4,895</td>
                              <td align="right">5,800</td>
                              <td align="right">1,23,456</td>
                              <td align="right">5,45,895</td>
                            </tr>
                            <tr>
                              <td>ERANAKULAM</td>
                              <td align="right">99,456</td>
                              <td align="right">10,989</td>
                              <td align="right">12,000</td>
                              <td align="right">6,789</td>
                              <td align="right">7,000</td>
                              <td align="right">88,000</td>
                            </tr>
                            <tr>
                              <td>THRISSUR</td>
                              <td align="right">1,23,456</td>
                              <td align="right">12,456</td>
                              <td align="right">4,895</td>
                              <td align="right">5,800</td>
                              <td align="right">7,000</td>
                              <td align="right">1,25,444</td>
                            </tr>
                            <tr>
                              <td>MALAPPURAM</td>
                              <td align="right">99,456</td>
                              <td align="right">10,989</td>
                              <td align="right">55,455</td>
                              <td align="right">6,789</td>
                              <td align="right">1,23,456</td>
                              <td align="right">9,22,125</td>
                            </tr>
                            <tr>
                              <td>KOZHIKODE</td>
                              <td align="right">1,23,456</td>
                              <td align="right">12,456</td>
                              <td align="right">4,895</td>
                              <td align="right">5,800</td>
                              <td align="right">3,569</td>
                              <td align="right">3,55,000</td>
                            </tr>
                            <tr>
                              <td>KANNUR</td>
                              <td align="right">99,456</td>
                              <td align="right">10,989</td>
                              <td align="right">55,455</td>
                              <td align="right">6,789</td>
                              <td align="right">1,23,456</td>
                              <td align="right">5,45,895</td>
                            </tr>
                            <tr>
                              <td bgcolor="#CCCCCC"><strong>TOTAL</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>5,45,985</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>7,00,895</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>99,895</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>1,45,895</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>6,45,895</strong></td>
                              <td align="right" bgcolor="#CCCCCC"><strong>45,895</strong></td>
                            </tr>
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