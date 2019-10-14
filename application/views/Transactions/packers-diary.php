<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
if(isset($_REQUEST['tableData']))
{
    $FileName="Packers-Diary-".date("F-j-Y").".xlsx";
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
    <title>Circulation | Packer's Diary</title>
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
                <h1>Packer's Diary</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?> "><i class="fa fa-dashboard"></i>Home</a></li>
                    <li>Transactions</li>
                    <li class="active">Packer's Diary</li>                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form  method="post" action="<?php echo base_url('Transactions/CreatePackersDiary'); ?>" name="packers-form" id="packers-form">
                            <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label>Date-Time</label>
                                <input type="text" class="form-control" value="<?php echo date("d-m-Y h:i A"); ?>" readonly id="current_date" name="current_date" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Product</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" tabindex="1" required type="text" data-required="product_clr" class="form-control" id="product" name="product" data-request='{"id":"18","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="product_search" data-search="product"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <select class="form-control" id="packers_optn" tabindex="2" name="packers_optn" required>
                                    <option value="0">Agent</option>
                                    <option value="1">Subscriber</option>
                                </select>
                            </div>
                            <!--Agent-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" required value="" tabindex="3" type="text" data-required="agent_clr" class="form-control" id="agent" name="agent" data-request='{"id":"17","search":""}' data-target='[{"selector":"#agent_det","indexes":"1,2"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 agent_sel">
                                <label>Agent Details</label>
                                <input type="text" readonly class="form-control"  value="" id="agent_det" name="agent_det" />
                            </span>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 agent_sel">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" tabindex="4" required type="text" class="form-control" id="subscriber" data-required="subscriber_clr"  name="subscriber" data-request='{"id":"23","search":""}' data-target='[{"selector":"#sub_det","indexes":"1"}]' data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"sub_agent_code","input":"#agent_rec_sel","select":"Code","encode":"true","msg":"Please select agent!"}]'/>
                                    <div class="input-group-addon btn" id="subscriber_search" data-search="subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 agent_sel">
                                <label>Subscriber Details</label>
                                <input type="text" readonly class="form-control" value="" id="sub_det" name="sub_det" />
                            </span>
                            <!--Subscriber-->
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 sub_sel hide">
                                <label>Subscriber</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" tabindex="5" isRequired type="text" class="form-control" id="sub_subscriber" data-required="subscriber_clr" name="sub_subscriber" data-request='{"id":"23","search":""}' data-target='[{"selector":"#sub_sub_det","indexes":"0,1"},{"selector":"#sub_agent_det","indexes":"2,3"}]' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="sub_subscriber_search" data-search="sub_subscriber"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sub_sel hide">
                                <label>Subscriber Details</label>
                                <input type="text" readonly class="form-control" value="" id="sub_sub_det" name="sub_sub_det" />
                            </span>
                            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sub_sel hide">
                                <label>Agent Details</label>
                                <input type="text" readonly class="form-control" value="" id="sub_agent_det" name="sub_agent_det" />
                            </span>
                            
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>Reason</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" tabindex="6" isRequired type="text"  data-required="packet_reason_clr" class="form-control" id="packet_reason" name="packet_reason" data-request='{"id":"34","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="packet_reason_search" data-search="packet_reason"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <select class="form-control select_plus" tabindex="7" id="select_plus_minus" name="select_plus_minus">
                                    <option value="">Select</option>
                                    <option value="Plus">Plus</option>
                                    <option value="minus">Minus</option>
                                </select>
                            </div>
                            <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label>Copies</label>
                                <input type="number" tabindex="8" class="form-control isNumberKey" readonly id="copy" name="copy" />
                            </span>
                            <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label>Remark</label>
                                <input type="text" class="form-control" tabindex="9" id="remark" name="remark" />
                            </span>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" tabindex="10" type="button" id="save-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>
                        </form>                   
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                     </div>
                </div>
               
                <!--Records-->
                          
                <div class="box">   
                    <form  method="post" action="" name="trans-form" id="trans-form" onsubmit="return CIRCULATION.utils.formValidation(this);">
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>From Date</label>
                            <div class="input-group">
                                <input  type="text" value="<?php echo @$_POST['diary_from_date']?>" class="form-control" id="diary_from_date" name="diary_from_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>To Date</label>
                            <div class="input-group">
                                <input  type="text" value="<?php echo @$_POST['diary_to_date']?>" class="form-control" id="diary_to_date" name="diary_to_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        <span class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <label>Agent Code</label>
                            <input type="text" class="form-control" value="<?php echo @$_POST['diary_agent_code']?>" id="diary_agent_code" name="diary_agent_code" />
                        </span>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-primary" name="search" type="submit"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                            <label>&nbsp;</label>
                            <button onclick="window.location='<?php echo base_url('Transactions/PackersDiary');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Reset</button>
                        </div>
                        </form>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                    <?php $count = count($pack_rec); ?>
                        <div class="box-body table-responsive">
                            <table class="table table-results <?php echo $count ? "" : "no-data-tbl"; ?>"  id="packets-table" width="100%">
                                <thead>
                                    <tr>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Date</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Called By</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Agent Code</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Agent Name</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Location</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Phone</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Sub Code</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Name</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Address</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Reason</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Plus/minus</td>
                                        <td align="right" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Copies</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Remarks</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Created By</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">Created Date</td>
                                        <td align="left" style="color:#000000; background:#cfcdcd; font-weight:bold; border-left:1px solid #ecf0f5;border-top:1px solid #ecf0f5;border-bottom:1px solid #ecf0f5; border-right:none !important;">&nbsp;</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($count){
                                        foreach($pack_rec as $pack) {
                                    ?>
                     <tr data-id="">
                        <td class="diary-date"><?php echo date('d-m-Y',strtotime($pack->pack_date)); ?></td>
                        <td class="diary-age-sub"><?php if($pack->pack_call_by == 0){echo "Agent";}else{ echo "Subscriber";} ?></td>
                        <td class="diary-age-code"><?php echo $pack->pack_agent_code; ?></td>
                        <td class="diary-age-name"><?php echo $pack->agent_name; ?></td>
                        <td class="diary-age-loc"><?php echo $pack->agent_location;?></td>
                        <td class="diary-age-phn"><?php echo $pack->agent_phone; ?></td>
                        <td class="diary-sub-code"><?php echo $pack->pack_sub_code; ?></td>
                        <td class="diary-sub-name"><?php echo $pack->sub_name; ?></td>
                        <td class="diary-sub-addr"><?php echo $pack->sub_address; ?></td>
                        <td><?php echo $pack->pack_reason; ?></td>
                        <td class="diary-plus"><?php if($pack->pack_plus_minus== 'Plus'){ echo "Plus";}else{ echo "Minus";} ?></td>
                        <td align="right" class="diary-copy"><?php echo $pack->pack_copies ; ?></td>
                        <td class="diary-remark"><?php echo $pack->pack_remarks ; ?></td>
                        <td class="diary-create-by"><?php echo $pack->user_emp_name ; ?></td>
                        <td class="diary-create-date"><?php echo $pack->created_date ; ?></td>
                         <?php if(date('d-m-Y',strtotime($pack->pack_date)) == date('d-m-Y')){?>
                        <td>
                            <button data-id="<?php echo $pack->pack_id ; ?>" class="btn btn-primary pack-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>
                        </td>
                        <?php } ?>
                    </tr>
                                    <?php
                                        }
                                    }  
                                else {
                                    echo "<tr><td colspan='25' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                }
                                    ?>
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
                <?php //} ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       <?php 
        $this->load->view('inc/footer');
        $this->load->view('inc/help');     
        ?>
        <!--<form method="post" class="hide" target="_blank" id="open-enroll-form" action=""></form>-->
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'PACKERS-DIARY';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/transactions.js?v='.$this->config->item('version')); ?>"></script>    
    <?php }?>
</body>
</html>
