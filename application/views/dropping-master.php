<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Circulation |Dropping Point Master</title>
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
                <h1>Dropping Point Master</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('Dashboard');?>"><i class="fa fa-dashboard"></i>Home</a></li>
                    <li class="active">Masters</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php include_once('inc/alerts.php'); ?>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form method="post" action="<?php echo base_url('Masters/CreateDroppingMaster'); ?>" name="unit_master" id="unit_master" onsubmit="return NEWSTRACK.utils.formValidation(this);">
                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Drop Point Code</label>
                                <input autocomplete="off" required type="text" class="form-control" id="drop_code" value="<?php echo $drop_code; ?>" name="drop_code" readonly />
                            </span>

                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Drop Point Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="drop_name" name="drop_name" />
                            </span>

                            <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <label>Drop Point Malayalam Name</label>
                                <input autocomplete="off" required type="text" class="form-control" id="drop_mal_name" name="drop_mal_name" />
                            </span>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                                <label>Route Code</label>
                                <div class="input-group search-module" data-selected="true">
                                    <input autocomplete="off" value="" required type="text" class="form-control" id="dr_route_code" name="dr_route_code" data-request='{"id":"11","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                                    <div class="input-group-addon btn" id="dr_route_code_search" data-search="dr_route_code"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                           
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-primary add-btn" type="submit" name="Add" id="add"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</button>
                            </span>
                          
                            <span class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
                                <label>&nbsp;</label>
                                <button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>Close</button>
                            </span>
                        </form>
                        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
                    </div>
                </div>                
                <div class="box">
                    <div class="box-header">
                        <span class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <select name="drop_route" id="drop_route" class="form-control">
                                <option value="">Select</option>
                                <?php foreach($route_list as $list){?>
                                <option <?php if($route_id == $list->route_code){ echo "selected";}?> value="<?php echo $list->route_code; ?>"><?php echo $list->route_name; ?></option>
                                <?php } ?>
                            </select>
                        </span> 
                    </div>
                    <?php $count = count($drop_rec); ?>
                    <div class="box-body table-responsive">
                        <table class="table table-results <?php echo $count === 0 ? "no-data-tbl" : ""; ?>" id="drop-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">#</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Drop Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Drop Malayalam Name</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Drop Point Route</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Dropping Point Priority</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;">Status</td>
                                        <td style="background:#cfcdcd; color:#000000; font-weight:bold; border:1px solid #ecf0f5;" class="remove_on_excel"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($count) {
                                    $i=1;
                                    foreach($drop_rec as $dr) {?>
                                    <tr data-save="false" data-drpid="<?php echo $dr->drop_code; ?>">                                      
                                       <td class="dr-code"><?php echo $i++; ?></td>
                                       <td class="dr-name"><?php echo $dr->drop_name; ?> </td>
                                       <td class="dr-mal-name"><?php echo $dr->drop_mal_name; ?> </td>
                                       <td class="dr-route-name"><?php echo $dr->route_name; ?> </td>
                                       <td align="center" class="handle"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></td>
                                       <td class="dr-status"><?php if( $dr->cancel_flag == ResidenceStatus::Active){echo "Active";}else{echo "Disabled";}?> </td>
                                       <td>
                                           <button data-id="<?php echo $dr->drop_code; ?>"class="btn btn-primary drop-edit-btn btn-xs"><i class="fa fa-edit fa-1x"></i></button>                                            
                                           <button class="btn btn-warning cancel-btn btn-xs"><i class="fa fa-times-circle fa-1x"></i></button>
                                           <?php //if($grp->cancel_flag == 0){?>
                                           <!--<button data-id="<?php //echo $grp->group_code; ?>" class="btn btn-danger del-btn btn-xs"><i class="fa fa-trash" aria-hidden="true"></i></button>-->
                                           <?php } ?>
                                       </td>
                                    </tr>
                                    <?php }
                                    else {
                                        echo "<tr><td colspan='7' class='no-records'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> No Records Found!</td></tr>";
                                    } ?>
                                    </tbody>
                            </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view('inc/footer');
              $this->load->view('inc/help'); ?>
    </div>
    <!-- ./wrapper -->
    <script>
        var page = 'DROPPING-POINT-MASTER';
    </script>
    <?php $this->load->view('inc/scripts'); ?>
    <?php if(ENVIRONMENT == 'development' || ENVIRONMENT == 'livedebug'){?>
    <script src="<?php echo base_url('assets/js/masters.js?v='.$this->config->item('version')); ?>"></script>
    <script src="<?php echo base_url('assets/js/build-docs.js?v='.$this->config->item('version')); ?>"></script>
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
            control.makeTransliteratable(['drop_mal_name']);
        }
        google.setOnLoadCallback(onLoad);
    </script>
</body>
</html>
