<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form method="post" id="aggrp_update_form">
            <input type="hidden" id="edt_aggroup_code" value="<?php echo $aggroup["aggroup_details"]->agent_group_code; ?>" />
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <label>Group Name</label>
                <input value="<?php echo $aggroup["aggroup_details"]->agent_group_name; ?>" autocomplete="off" required type="text" class="form-control" id="edt_aggroup_name" name="edt_aggroup_name" />
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <label>Agents</label>
                <table style="width:100%;" id="updt-agents-tbl">
                    <?php
                    $agent_count = count($aggroup["aggroup_agents"]);
                    for($aIndex=0; $aIndex<$agent_count; $aIndex++){
                    ?>
                    <tr>
                        <td style="width:25%;">
                            <div class="input-group search-module <?php if($aIndex!=0){?> margtop-3 <?php }?>" data-selected="true">
                                <input autocomplete="off" value="<?php echo $aggroup["aggroup_agents"][$aIndex]->agent_code;?>" required type="text" class="form-control agent" id="edt_agent_<?php echo $aIndex+1;?>" name="edt_agent_<?php echo $aIndex+1;?>" data-request='{"id":"17","search":"Name"}' data-select="{}" data-multiselect="false" placeholder="" data-selectIndex="0"/>
                                <input type="hidden" name="edt_agent_<?php echo $aIndex+1;?>_rec_sel" class="edt_agent_<?php echo $aIndex+1;?>_clr" id="edt_agent_<?php echo $aIndex+1;?>_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$aggroup["aggroup_agents"][$aIndex]->agent_code,"Name"=>$aggroup["aggroup_agents"][$aIndex]->agent_name,"Location"=>$aggroup["aggroup_agents"][$aIndex]->agent_location,"SerialNumber"=>$aggroup["aggroup_agents"][$aIndex]->agent_slno)));?>">
                                <div class="input-group-addon agent_search btn" id="edt_agent_<?php echo $aIndex+1;?>_search" data-search="edt_agent_<?php echo $aIndex+1;?>"><i class="fa fa-search"></i></div>
                            </div>
                        </td>
                        <td style="width:38%;"><input type="text" class="form-control <?php if($aIndex!=0){?> margtop-3 <?php }?> ag_nme edt_agent_1_clr" value="<?php echo $aggroup["aggroup_agents"][$aIndex]->agent_name;?>" readonly /></td>
                        <td style="width:32%;"><input type="text" class="form-control <?php if($aIndex!=0){?> margtop-3 <?php }?> ag_loc edt_agent_1_clr" value="<?php echo $aggroup["aggroup_agents"][$aIndex]->agent_location;?>" readonly /></td>
                        <?php if($aIndex==$agent_count-1){?>
                        <td style="width:5%;" class="action-btns">
                            <span style="margin-left: 9px;" class="add-btn"><i class="fa fa-plus-square" style="color:dodgerblue; font-size:17px;" aria-hidden="true"></i></span>
                        </td>
                        <?php } else{?>
                        <td style="width:5%;" class="action-btns">
                            <span style="margin-left: 9px;" class="del-btn"><i class="fa fa-trash" style="color:red; font-size:17px;" aria-hidden="true"></i></span>
                        </td>
                        <?php }?>
                    </tr>
                    <?php }?>
                </table>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <label>Upload Agents</label>
                <input autocomplete="off" required type="file" class="form-control" id="edt_agent_lists" name="edt_agent_lists" accept="text/plain"/>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 hide" id="edt_upld_agents_box">
                <label>&nbsp;</label>
                <table class="table table-sec" id="edt_upld_agents_tbl">
                    <thead>
                        <tr>
                            <td><input type="checkbox" id="edt_upload_ag_selall" style="display:none;" /></td>
                            <td>Code</td>
                            <td>Name</td>
                            <td>Location</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="loading"><td colspan="4" align="center"><img src="<?php echo base_url('assets/imgs/blue-loader.gif');?>" width="200" /></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button id="updt-agent-groups" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>