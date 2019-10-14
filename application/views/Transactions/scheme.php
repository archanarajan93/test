<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Schemes-".date("F-j-Y").".xlsx";
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($_REQUEST['tableData']);
    //$spreadsheet->getActiveSheet()->setTitle("123");
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
    <title>Circulation | Scheme</title>
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
                <h1>Scheme</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Scheme</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="" name="sch-srch-form" id="sch-srch-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                            <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />
                            <input type="hidden" name="pdt_code" id="pdt_code" value="<?php echo $this->user->user_product_code;?>" />
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme Type</label>
                                <input type="hidden" id="copy_code" value="CP0003" />
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["copy_group"])?$_POST["copy_group"]:'';?>" type="text" class="form-control" id="copy_group" name="copy_group" data-request='{"id":"15","search":""}' data-select="{}" data-multiselect="false" placeholder="" 
                                           data-criteria='[{"column":"group_copy_code","input":"#copy_code","select":"","encode":"false","multiselect":"false","required":"true","msg":"Invalid Copy Code"}]'/>
                                    <?php if(isset($_POST["copy_group_rec_sel"])){?>
                                    <input type="hidden" name="copy_group_rec_sel" class="copy_group_clr" id="copy_group_rec_sel" value="<?php echo $_POST["copy_group_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>                                
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["copy_type"])?$_POST["copy_type"]:'';?>" type="text" class="form-control" id="copy_type" name="copy_type" data-request='{"id":"14","search":""}' data-select="{}" data-multiselect="false" placeholder=""
                                           data-criteria='[{"column":"group_code","input":"#copy_group_rec_sel","select":"Code","encode":"true","multiselect":"false","required":"false"},
                                                            {"column":"RC.rate_pdt_code","input":"#pdt_code","select":"","encode":"false","multiselect":"false","required":"false"}]' />
                                    <?php if(isset($_POST["copy_type_rec_sel"])){?>
                                    <input type="hidden" name="copy_type_rec_sel" class="copy_type_clr" id="copy_type_rec_sel" value="<?php echo $_POST["copy_type_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="copy_type_search" data-search="copy_type"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["subscriber"])?$_POST["subscriber"]:'';?>" type="text" class="form-control" id="subscriber" name="subscriber" data-request='{"id":"23","search":""}'
                                           data-criteria='[{"column":"sub_unit_code","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <?php if(isset($_POST["subscriber_rec_sel"])){?>
                                    <input type="hidden" name="subscriber_rec_sel" class="subscriber_clr" id="subscriber_rec_sel" value="<?php echo $_POST["subscriber_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["agent"])?$_POST["agent"]:'';?>" type="text" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-selectIndex="0" data-target='[{"selector":"#agent_det","indexes":"1,2"}]' 
                                           data-criteria='[{"column":"agent_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <?php if(isset($_POST["agent_rec_sel"])){?>
                                    <input type="hidden" name="agent_rec_sel" class="agent_clr" id="agent_rec_sel" value="<?php echo $_POST["agent_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <label>Agent Details</label>
                                <input type="text" class="form-control agent_clr" name="agent_det" id="agent_det" value="<?php echo isset($_POST["agent_det"])?$_POST["agent_det"]:'';?>" readonly />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Event</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="<?php echo isset($_POST["event"])?$_POST["event"]:'';?>" type="text" class="form-control" id="event" name="event" data-request='{"id":"28","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <?php if(isset($_POST["event_rec_sel"])){?>
                                    <input type="hidden" name="event_rec_sel" class="event_clr" id="event_rec_sel" value="<?php echo $_POST["event_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="event_search" data-search="event"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Scheme No.</label>
                                <input type="text" name="scheme_no" id="scheme_no" class="form-control" value="<?php echo isset($_POST["scheme_no"])?$_POST["scheme_no"]:'';?>"/>
                            </div>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <select class="form-control" id="sch_dte_range" name="sch_dte_range">
                                    <option <?php if(isset($_POST["sch_dte_range"]) && $_POST["sch_dte_range"]=='1') echo 'selected';?> value="1">Starting From</option>
                                    <option <?php if(isset($_POST["sch_dte_range"]) && $_POST["sch_dte_range"]=='2') echo 'selected';?> value="2">Ending From</option>
                                </select>
                            </div>
                                
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>From</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo isset($_POST["from_dte"])?$_POST["from_dte"]:'';?>" class="form-control" id="from_dte" name="from_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>To</label>
                                <div class="input-group">
                                    <input type="text" value="<?php echo isset($_POST["to_dte"])?$_POST["to_dte"]:'';?>" class="form-control" id="to_dte" name="to_dte" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Canvassed By</label>
                                <select class="form-control" id="canvassed_by_type" name="canvassed_by_type">
                                <?php $status = Enum::getAllConstants('CanvassedBy'); 
                                      foreach($status as $key => $value) {
                                          if($value=='Promoter' || $value=='ACM') { continue;}?>
                                <option <?php if(isset($_POST["canvassed_by_type"]) && $_POST["canvassed_by_type"]==$key) echo 'selected';?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <?php $can_title="Agent";
                                  $can_other = 0;
                                    if(isset($_POST["canvassed_by_type"])){
                                        if($_POST["canvassed_by_type"]=='17'){
                                            $can_title="Agent";
                                        }else if($_POST["canvassed_by_type"]=='1'){
                                            $can_title="Staff";
                                        }else{
                                            $can_title="Agent";
                                            $can_other=1;
                                        }
                                    }else{
                                        $can_title="Agent";
                                    }
                                ?>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 <?php if($can_other==1) echo 'hide';?> canvassed_by_users">
                                <label id="can_text"><?php echo $can_title;?></label>
                                <div class="input-group search-module" data-selected="true">
                                    <?php if($can_title=='Agent'){?>
                                    <input autocomplete="off" value="<?php echo isset($_POST["canvassed_by"])?$_POST["canvassed_by"]:'';?>" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-selectIndex="0" data-target='[{"selector":"#canvassed_name","indexes":"1,2"}]' 
                                           data-criteria='[{"column":"agent_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <?php }else{?>
                                    <input autocomplete="off" value="<?php echo isset($_POST["canvassed_by"])?$_POST["canvassed_by"]:'';?>" type="text" class="form-control" id="canvassed_by" name="canvassed_by" data-request='{"id":"17","search":""}' data-selectIndex="0" data-target='[{"selector":"#canvassed_name","indexes":"3"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <?php }?>
                                    <?php if(isset($_POST["canvassed_by_rec_sel"])){?>
                                    <input type="hidden" name="canvassed_by_rec_sel" class="canvassed_by_clr" id="canvassed_by_rec_sel" value="<?php echo $_POST["canvassed_by_rec_sel"];?>">
                                    <?php }?>
                                    <div class="input-group-addon btn" id="canvassed_by_search" data-search="canvassed_by"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 <?php if($can_other==1) echo 'hide';?> canvassed_by_users">
                                <label id="can_det_text"><?php echo $can_title;?> Details</label>
                                <input type="text" class="form-control canvassed_by_clr" name="canvassed_name" id="canvassed_name" value="<?php echo isset($_POST["canvassed_name"])?$_POST["canvassed_name"]:'';?>" readonly/>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12  <?php if($can_other!=1) echo 'hide';?>" id="canvassed_by_others">
                                <label>Others</label>
                                <input type="text" value="<?php echo isset($_POST["canvassed_others"])?$_POST["canvassed_others"]:'';?>" class="form-control" id="canvassed_others" name="canvassed_others" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Pause</label>
                                <select class="form-control" name="pause_status">
                                    <option value="0">--Select--</option>
                                    <option <?php if(isset($_POST["pause_status"]) && $_POST["pause_status"]=='1') echo 'selected';?> value="1">Avoid Pause</option>
                                    <option <?php if(isset($_POST["pause_status"]) && $_POST["pause_status"]=='2') echo 'selected';?> value="2">Pause Alone</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="submit" name="search" value="1"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <a href="<?php echo base_url('Transactions/SchemeCreate'); ?>">
                                    <button class="btn btn-block btn-primary" type="button"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;New</button>
                                </a>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
                <!--Records-->
                <?php $count = count($sch_records); ?>               
                <div class="box">                    
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php echo $count ? "" : "no-data-tbl"; ?>" id="scheme-table" width="100%">
                            <thead>
                                <tr>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">SlNo</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Scheme Code</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Scheme</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Subscriber Name</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Address</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Phone</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Code</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Name</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Location</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Agent Status</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;text-align:right;">Copies</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Start Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">End Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Remarks</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Canvassed By</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Canvassed Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created By</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;">Created Date</td>
                                    <td style="color:#000000; background:#cfcdcd; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($count) {
                                    $slno = 1;
                                    foreach($sch_records as $rec) { 
                                        $scheme_code = Enum::encrypt_decrypt(Encode::Encrypt,$rec->sch_slno,$en_key); 
                                        ?>
                                        <tr>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $slno++; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sch_slno; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->copytype_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sub_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sub_address; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sub_phone; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->agent_code; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->agent_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->agent_location; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo Enum::getConstant('Status',$rec->cancel_flag); ?></td>
                                            <td style="border:1px solid #ecf0f5;text-align:right;"><?php echo $rec->sch_copies; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y',strtotime($rec->sch_from_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y',strtotime($rec->sch_to_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sch_remarks; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->sch_can_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y',strtotime($rec->sch_can_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo $rec->created_name; ?></td>
                                            <td style="border:1px solid #ecf0f5;"><?php echo date('d-m-Y h:i:s A',strtotime($rec->created_date)); ?></td>
                                            <td style="border:1px solid #ecf0f5;" class="remove_on_excel">
                                                <button onclick="window.location='<?php echo base_url('Transactions/SchemeDetails/'.$scheme_code);?>'" class="btn btn-success view-scheme" title="View"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View</button>
                                                <button onclick="window.location='<?php echo base_url('Transactions/SchemeEdit/'.$scheme_code);?>'" class="btn btn-primary edit-scheme" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>
                                                <button onclick="window.location='<?php echo base_url('Transactions/SchemeRenew/'.$scheme_code);?>'" class="btn btn-primary renew-scheme" title="Renew"><i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Renew</button>
                                                <?php if(strtotime($rec->sch_from_date)<= strtotime(date("Y-m-d"))){
                                                          if($rec->sch_paused_flag=='0'){?>
                                                <button data-id="<?php echo $scheme_code; ?>" class="btn btn-warning pause-scheme"><i class="fa fa-pause" aria-hidden="true" title="Pause"></i>&nbsp;Pause</button>
                                                <?php }else{?>
                                                <button data-id="<?php echo $scheme_code; ?>" class="btn btn-success restart-scheme"><i class="fa fa-retweet" aria-hidden="true" title="Restart"></i>&nbsp;Restart</button>
                                                <?php }
                                                      }?>
                                                <button data-id="<?php echo $scheme_code; ?>" class="btn btn-danger del-scheme"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i>&nbsp;Delete</button>
                                             </td>
                                         </tr>
                                <?php }
                                } 
                                else {
                                    echo "<tr><td colspan='19' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";   
                                }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-warning" type="button" onclick="CIRCULATION.utils.exportExcel(null, null, null, null, false, true);"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Excel</button>
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
        <form method="post" class="hide" target="_blank" id="open-enroll-form" action=""></form>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'SCHEME';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
