<?php
if(isset($_REQUEST['tableData']))
{
	$FileName="Agent-Master-".date("F-j-Y").".xls";
	header('Content-Type: application/force-download');
	header('Content-disposition: attachment; filename='.$FileName.'');
	header("Pragma: ");
	header("Cache-Control: ");
	echo $_REQUEST['tableData'];
	exit();
}
$today = date('d-m-Y');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation | Agent Master</title>
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
                <h1>Agent Master</h1>
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
                    <div class="box-body table-responsive" id="agents-inputs">                       
                        <form method="post" action="<?php echo base_url('Masters/UpsertAgentMaster') ?>" name="ag_form" id="ag_form" onsubmit="return CIRCULATION.utils.formValidation(this);" enctype="multipart/form-data">

                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Agent Details</a></li>
                                    <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Membership Details</a></li>
                                </ul>
                                <div class="tab-content">
                                    <!--Tab-1-->
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="row">                                                                                       
                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Serial No</label>
                                                <input autocomplete="off" readonly type="text" class="form-control" name="agent_slno" id="agent_slno" value="<?php echo @$agent_slno; ?>" />
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Agency Code</label>
                                                <input autocomplete="off" type="text" class="form-control" id="agent_code" name="agent_code" value="<?php echo @$agent_details->agent_code; ?>" />
                                            </div>

                                            <input type="hidden" name="is_update" id="is_update" value="<?php echo (isset($agent_details->agent_code) && $_GET['g_m'] == 'ZWRpdC1tb2Rl') ? 1 : 0; ?>" />
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                                <label>Agent Name</label>
                                                <input value="<?php echo @$agent_details->agent_name; ?>" autocomplete="off" required type="text" class="form-control" id="agent_name" name="agent_name" />
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <label>Address</label>
                                                <input value="<?php echo @$agent_details->agent_address; ?>" autocomplete="off" required type="text" class="form-control" id="agent_address" name="agent_address" />
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <label>Location</label>
                                                <input value="<?php echo @$agent_details->agent_location; ?>" autocomplete="off" required type="text" class="form-control" id="agent_location" name="agent_location" />
                                            </div>

                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <label>Phone</label>
                                                <input value="<?php echo @$agent_details->agent_phone; ?>" autocomplete="off" required type="text" class="form-control" id="agent_phone" name="agent_phone" />
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Aadhar Number</label>
                                                <input value="<?php echo @$agent_details->agent_aadhar; ?>" autocomplete="off" required type="text" class="form-control" id="agent_aadhar" name="agent_aadhar" />
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Date of Birth</label>
                                                <div class="input-group">
                                                    <input required type="text" value="<?php echo @$agent_details->agent_dob ? date('d-m-Y',strtotime($agent_details->agent_dob)) : $today; ?>" class="form-control" id="agent_dob" name="agent_dob" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Agent Type</label>
                                                <select class="form-control" name="agent_type" id="agent_type">
                                                    <?php foreach($agent_copy_type as $t) { ?>
                                                    <option <?php echo @$agent_details->agent_type == $t->copy_code ? "selected" : ""; ?> value="<?php echo $t->copy_code; ?>"><?php echo $t->copy_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php $count = count($agent_details); ?>
                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Print slip in Malayalam</label>
                                                <select class="form-control" name="agent_mal_slip" id="agent_mal_slip">
                                                    <option <?php echo ($count && @$agent_details->agent_mal_slip == 1) ? "selected" : ""; ?> value="1">Yes</option>
                                                    <option <?php echo ($count && @$agent_details->agent_mal_slip == 0) ? "selected" : ""; ?> value="0">No</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Stall Agency</label>
                                                <select class="form-control" name="agent_stall" id="agent_stall">
                                                    <option <?php echo @$agent_details->agent_stall == 1 ? "selected" : ""; ?> value="1">Yes</option>
                                                    <option <?php echo @$agent_details->agent_stall == 0 ? "selected" : ""; ?> selected value="0">No</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                                <label>Settlement Date</label>
                                                <div class="input-group">
                                                    <input readonly type="text" value="<?php echo @$agent_details->agent_settlement_date ? date('d-m-Y',strtotime($agent_details->agent_settlement_date)) : ""; ?>" class="form-control" id="agent_settlement_date" name="agent_settlement_date" autocomplete="off" />
                                                    <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div style="width:100%;border-bottom:dashed 1px #CCC;margin-bottom: 12px;margin-top: 12px;">&nbsp;</div></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-red"><strong>MALAYALAM</strong></div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <label>Name</label>
                                                <input value="<?php echo @$agent_details->agent_mal_name; ?>" autocomplete="off" required type="text" class="form-control" id="agent_mal_name" name="agent_mal_name" />
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                                <label>Location</label>
                                                <input value="<?php echo @$agent_details->agent_mal_location; ?>" autocomplete="off" required type="text" class="form-control" id="agent_mal_location" name="agent_mal_location" />
                                            </div>
                                        </div>
                                    </div>

                                    <!--Tab-2-->
                                    <div class="tab-pane" id="tab_2">
                                        <div class="row">
                                            <!--Box-1-->
                                            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 no-padding" id="product-opt-wrap">

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Product</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control" id="agent_product" name="agent_product" data-request='{"id":"18","search":""}' data-select="{}" data-multiselect="false" placeholder=""  />
                                                        <input type="hidden" name="agent_product_rec_sel" class="agent_product_clr" id="agent_product_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_product_search" data-search="agent_product"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>ACM</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control" id="agent_acm" name="agent_acm" data-request='{"id":"2","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                                        <input type="hidden" name="agent_acm_rec_sel" class="agent_acm_clr" id="agent_acm_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_acm_search" data-search="agent_acm"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Region</label>
                                                    <input readonly autocomplete="off" value="" type="text" class="form-control agent_acm_clr" id="agent_region" name="agent_region" placeholder="" />
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Promoter</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control agent_acm_clr" id="agent_promoter" name="agent_promoter" data-request='{"id":"5","search":""}' data-select="{}" data-multiselect="false" placeholder="" 
                                                               data-criteria='[{"column":"promoter_acm_code","input":"#agent_acm_rec_sel","select":"","encode":"true","multiselect":"false","required":"true","msg":"Please select ACM"}]' />
                                                        <input type="hidden" name="agent_promoter_rec_sel" class="agent_promoter_clr" id="agent_promoter_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_promoter_search" data-search="agent_promoter"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Bureau</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control agent_acm_clr" id="agent_bureau" name="agent_bureau" data-request='{"id":"7","search":""}' data-select="{}" data-multiselect="false" placeholder=""/>
                                                        <input type="hidden" name="agent_bureau_rec_sel" class="agent_bureau_clr" id="agent_bureau_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_bureau_search" data-search="agent_bureau"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Edition</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control" id="agent_edition" name="agent_edition" data-request='{"id":"10","search":""}' data-select="{}" data-multiselect="false" placeholder=""  />
                                                        <input type="hidden" name="agent_edition_rec_sel" class="agent_edition_clr" id="agent_edition_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_edition_search" data-search="agent_edition"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Route</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control" id="agent_route" name="agent_route" data-request='{"id":"11","search":""}' data-select="{}" data-multiselect="false" placeholder=""  />
                                                        <input type="hidden" name="agent_route_rec_sel" class="agent_route_clr" id="agent_route_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_route_search" data-search="agent_route"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Dropping Point</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control agent_route_clr" id="agent_dropping_point" name="agent_dropping_point" data-request='{"id":"12","search":""}' data-select="{}" data-multiselect="false" placeholder=""  
                                                               data-criteria='[{"column":"drop_route_code","input":"#agent_route_rec_sel","select":"","encode":"true","multiselect":"false","required":"true","msg":"Please select Route"}]' />
                                                        <input type="hidden" name="agent_dropping_point_rec_sel" class="agent_dropping_point_clr" id="agent_dropping_point_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_dropping_point_search" data-search="agent_dropping_point"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Union</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control agent_acm_clr" id="agent_union" name="agent_union" data-request='{"id":"8","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                                        <input type="hidden" name="agent_union_rec_sel" class="agent_union_clr" id="agent_union_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_union_search" data-search="agent_union"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Shakha</label>
                                                    <div class="input-group search-module" data-selected="true">
                                                        <input autocomplete="off" value="" type="text" class="form-control agent_union_clr" id="agent_shakha" name="agent_shakha" data-request='{"id":"9","search":""}' data-select="{}" data-multiselect="false" placeholder="" 
                                                               data-criteria='[{"column":"shakha_union_code","input":"#agent_union_rec_sel","select":"","encode":"true","multiselect":"false","required":"true","msg":"Please select Union"}]' />
                                                        <input type="hidden" name="agent_shakha_rec_sel" class="agent_shakha_clr" id="agent_shakha_rec_sel" value="">
                                                        <div class="input-group-addon btn" id="agent_shakha_search" data-search="agent_shakha"><i class="fa fa-search"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-1 col-sm-12 col-xs-12">&nbsp;</div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Sec. Contr</label>
                                                    <input autocomplete="off" type="number" class="form-control" id="agent_sec_contr" name="agent_sec_contr" value="0" />
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Sec. Contr in %</label>
                                                    <select class="form-control" name="agent_sec_flag" id="agent_sec_flag">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-12 col-md-1 col-sm-12 col-xs-12">&nbsp;</div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Commission</label>
                                                    <input autocomplete="off" type="number" class="form-control" id="agent_comm" name="agent_comm" value="0" />
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Commission in %</label>
                                                    <select class="form-control" name="agent_comm_flag" id="agent_comm_flag">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-12 col-md-1 col-sm-12 col-xs-12">&nbsp;</div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Date of Joining</label>
                                                    <div class="input-group">
                                                        <input type="text" value="<?php echo $today; ?>" class="form-control avoid-clr" id="agent_doj" name="agent_doj" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" />
                                                        <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Status</label>
                                                    <select class="form-control" name="agent_status" id="agent_status">
                                                        <?php $status = Enum::getAllConstants('Status');
                                                        foreach($status as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Disabled on</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" data-value="<?php echo $today; ?>" class="form-control avoid-clr" id="agent_status_date" name="agent_status_date" autocomplete="off" />
                                                        <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-1 col-sm-12 col-xs-12">&nbsp;</div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Bill Print Needed</label>
                                                    <select class="form-control" name="agent_bill_print" id="agent_bill_print">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Bill Bonus Needed</label>
                                                    <select class="form-control" name="agent_bill_bonus" id="agent_bill_bonus">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>Slip Print Needed</label>
                                                    <select class="form-control" name="agent_slip_print" id="agent_slip_print">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                                    <label>&nbsp;</label>
                                                    <button id="add-to-list" class="btn btn-block btn-warning" type="button">Add to List&nbsp;<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                                                                        
                                            <!--Box-2-->
                                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 no-padding">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="max-height:330px; overflow-y:auto;">
                                                    <table class="table table-results no-data-tbl" border="1" id="products-table" style="width:100% !important;">
                                                        <thead>
                                                            <tr>
                                                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" colspan="4">Products</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Code</td>
                                                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">Product</td>
                                                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;" align="right">Copy</td>
                                                                <td style="background-color: #cfcdcd; font-weight: bold; color:#000000;border:1px solid #ecf0f5;">&nbsp;</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>  
                                                            <?php 
                                                            if(count($membership_details) > 0) {
                                                                foreach($membership_details as $m) {
                                                            ?>
                                                            <tr data-product="<?php echo $m->agent_product_code; ?>">
                                                                <td class="product-code">
                                                                    <?php echo $m->agent_product_code; ?>
                                                                    <textarea class="hide" name="product_records[]">
                                                                        <?php 
                                                                        echo rawurlencode(json_encode(array(
                                                                            "agent_code"=> $m->agent_code,

                                                                            "agent_product"=> $m->agent_product_code,
                                                                            "agent_product_name"=> $m->product_name,

                                                                            "agent_acm"=> $m->agent_acm,
                                                                            "agent_acm_name"=> $m->acm_name,

                                                                            "agent_acm_region"=> $m->agent_region,
                                                                            "agent_acm_region_name"=> $m->region_name,

                                                                            "agent_promoter"=> $m->agent_promoter,
                                                                            "agent_promoter_name"=> $m->promoter_name,

                                                                            "agent_edition"=> $m->agent_edition,
                                                                            "agent_edition_name"=> $m->edition_name,

                                                                            "agent_route"=> $m->agent_route,
                                                                            "agent_route_name"=> $m->route_name,

                                                                            "agent_drop_point"=> $m->agent_dropping_point,
                                                                            "agent_drop_point_name"=> $m->drop_name,

                                                                            "agent_sec"=> $m->agent_sec_contr,
                                                                            "agent_sec_flag"=> $m->agent_sec_flag,
                                                                            "agent_comm"=> $m->agent_comm,
                                                                            "agent_comm_flag"=> $m->agent_comm_flag,
                                                                            "agent_doj"=> $m->agent_doj ? date('d-m-Y',strtotime($m->agent_doj)) : null,

                                                                            "agent_status"=> $m->agent_status,
                                                                            "agent_status_date"=> $m->agent_status ? date('d-m-Y',strtotime($m->agent_status_date)) : null,
                                                                            
                                                                            "agent_bureau"=> $m->agent_bureau,
                                                                            "agent_bureau_name"=> $m->bureau_name,

                                                                            "agent_union"=> $m->agent_union,
                                                                            "agent_union_name"=> $m->union_name,

                                                                            "agent_shakha"=> $m->agent_shakha,
                                                                            "agent_shakha_name"=> $m->shakha_name,

                                                                            "agent_bill_print"=> $m->agent_bill_print,
                                                                            "agent_slip_print"=> $m->agent_slip_print,
                                                                            "agent_bill_bonus"=> $m->agent_bill_bonus
                                                                        )));
                                                                        ?>
                                                                    </textarea>
                                                                </td>
                                                                <td class="product-name"><?php echo $m->product_name; ?></td>
                                                                <td class="product-copy" align="right">0</td>
                                                                <td align="center">
                                                                    <button class="btn btn-primary btn-xs view-from-list" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                                    <button class="btn btn-danger btn-xs delete-from-list" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            }
                                                            else {
                                                                echo '<tr class="no-records">
                                                                        <td colspan="4">No Records Added!</td>
                                                                      </tr>';
                                                            }
                                                            ?>                                                                                                                                                                                                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary" type="button" id="save-agency">
                                    <?php echo (isset($_GET['g_m']) && $_GET['g_m'] == 'ZWRpdC1tb2Rl') 
                                                ? '<i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update' 
                                                : '<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add';                                
                                    ?> 
                                </button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Masters/AgentSearch');?>'" class="btn btn-block btn-warning" type="button" id="search-agency"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            </div>

                            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                                <label>&nbsp;</label>
                                <button 
                                    <?php if(!isset($_GET['g_m'])) { ?> onclick="window.location='<?php echo base_url('Dashboard');?>'" <?php } else { ?> onclick="window.close();" <?php } ?>                                 
                                class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
                            </div>                          
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
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
        var page = 'AGENT-MASTER', mode = '<?php echo @$_GET['g_m']; ?>';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>            
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <!--transliteration-->
    <script src='<?php echo base_url('assets/js/vendor/jsapi.min.js'); ?>' type='text/javascript'></script>
    <?php } ?>
    <script type='text/javascript'>
        // Load the Google Transliterate API
        google.load("elements", "1", {
            packages: "transliteration"
        });
        function onLoad() {
            var options = {
                sourceLanguage:
                    google.elements.transliteration.LanguageCode.ENGLISH,
                destinationLanguage:
                    [google.elements.transliteration.LanguageCode.MALAYALAM],
                shortcutKey: 'ctrl+g',
                transliterationEnabled: true
            };
            // Create an instance on TransliterationControl with the required
            // options.
            var control =
                new google.elements.transliteration.TransliterationControl(options);
            // Enable transliteration in the textbox with id
            // &#39;transliterateTextarea&#39;.
            control.makeTransliteratable(['agent_mal_name']);
            control.makeTransliteratable(['agent_mal_location']);
        }
        google.setOnLoadCallback(onLoad);
    </script>
</body>
</html>