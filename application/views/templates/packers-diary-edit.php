<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form name="p-packers-form" id="p-packers-form">
            <input type="hidden" id="p_pack_code" name="p_pack_code" value="<?php echo $pack_edit->pack_id; ?>" />
            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label>Date-Time</label>
                <input type="text" class="form-control" value="<?php echo date("d-m-Y h:i A"); ?>" readonly id="p_current_date" name="p_current_date" />
            </span>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>Product</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $pack_edit->pack_product_code;?>" type="text" class="form-control" id="p_product" name="p_product" data-request='{"id":"18","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                    <input type="hidden" name="p_product_rec_sel" class="p_product_clr" id="p_product_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$pack_edit->product_name,"Code"=>$pack_edit->product_code)));?>">
                    <div class="input-group-addon btn" id="p_product_search" data-search="p_product"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>&nbsp;</label>
                <select class="form-control change_optn" id="p_packers_optn" name="p_packers_optn">
                    <option <?php if($pack_edit->pack_call_by == 0){echo "selected";}?> value="0">Agent</option>
                    <option <?php if($pack_edit->pack_call_by == 1){echo "selected";}?> value="1">Subscriber</option>
                </select>
            </div>
            <!--Agent-->
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 p_agent_sel <?php if($pack_edit->pack_call_by == 1){?> hide <?php }?>">
                <label>Agent</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $pack_edit->pack_agent_code;?>" type="text" class="form-control" id="p_agent" name="p_agent" data-request='{"id":"17","search":""}' data-target='[{"selector":"#p_agent_det","indexes":"1,2"}]' data-select="{}" data-multiselect="false" placeholder="" />
                    <input type="hidden" name="p_agent_rec_sel" class="p_agent_clr" id="p_agent_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$pack_edit->pack_agent_code,"SerialNumber"=>$pack_edit->pack_agent_slno,"Name"=>$pack_edit->agent_name,"Location"=>$pack_edit->agent_location)));?>">
                    <div class="input-group-addon btn" id="p_agent_search" data-search="agent"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <span class="col-lg-8 col-md-4 col-sm-6 col-xs-12 p_agent_sel <?php if($pack_edit->pack_call_by == 1){?> hide <?php }?>">
                <label>Agent Details</label>
                <input type="text" readonly class="form-control" value="<?php echo $pack_edit->agent_name;?><?php echo ",".$pack_edit->agent_location;?>" id="p_agent_det" name="p_agent_det" />
            </span>

            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 p_agent_sel <?php if($pack_edit->pack_call_by == 1){?> hide <?php }?>">
                <label>Subscriber</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $pack_edit->pack_sub_code;?>" type="text" class="form-control" id="p_subscriber" name="p_subscriber" data-request='{"id":"23","search":""}' data-target='[{"selector":"#p_sub_det","indexes":"1"}]' data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"sub_agent_code","input":"#p_agent_rec_sel","select":"Code","encode":"true","msg":"Please select agent!"}]' />
                    <div class="input-group-addon btn" id="p_subscriber_search" data-search="p_subscriber"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <span class="col-lg-8 col-md-4 col-sm-6 col-xs-12 p_agent_sel <?php if($pack_edit->pack_call_by == 1){?> hide <?php }?>">
                <label>Subscriber Details</label>
                <input type="text" readonly class="form-control" value="<?php echo $pack_edit->sub_name;?><?php echo ",".$pack_edit->sub_address;?>" id="p_sub_det" name="p_sub_det" />
            </span>
            <!--Subscriber-->
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 p_sub_sel <?php if($pack_edit->pack_call_by == 0){?> hide <?php }?>">
                <label>Subscriber</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $pack_edit->pack_sub_code;?>" type="text" class="form-control" id="p_sub_subscriber" name="p_sub_subscriber" data-request='{"id":"23","search":""}' data-target='[{"selector":"#p_sub_sub_det","indexes":"0,1"},{"selector":"#p_sub_agent_det","indexes":"2,3"}]' data-select="{}" data-multiselect="false" placeholder="" />
                    <input type="hidden" name="p_subscriber_rec_sel" class="p_subscriber_clr" id="p_subscriber_rec_sel" value="<?php echo  rawurlencode(json_encode(array("Code"=>$pack_edit->pack_sub_code,"Agent Name"=>$pack_edit->sub_name,"Agent Location"=>$pack_edit->sub_address)));?>">
                    <div class="input-group-addon btn" id="p_sub_subscriber_search" data-search="p_sub_subscriber"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <span class="col-lg-8 col-md-4 col-sm-6 col-xs-12 p_sub_sel <?php if($pack_edit->pack_call_by == 0){?> hide<?php }?>">
                <label>Subscriber Details</label>
                <input type="text" readonly class="form-control" value="<?php echo $pack_edit->sub_name;?><?php echo ",".$pack_edit->sub_address;?>" id="p_sub_sub_det" name="p_sub_sub_det" />
            </span>
            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12 p_sub_sel <?php if($pack_edit->pack_call_by == 0){?> hide<?php }?>">
                <label>Agent Details</label>
                <input type="text" readonly class="form-control" value="<?php echo $pack_edit->agent_name;?><?php echo ",".$pack_edit->agent_location;?>" id="p_sub_agent_det" name="p_sub_agent_det" />
            </span>

            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>Reason</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $pack_edit->pack_reason;?>" type="text" class="form-control" id="p_packet_reason" name="p_packet_reason" data-request='{"id":"34","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                    <input type="hidden" name="p_packet_reason_rec_sel" class="p_packet_reason_clr" id="p_packet_reason_rec_sel" value="<?php echo  rawurlencode(json_encode(array("Reason"=>$pack_edit->pack_reason)));?>">
                    <div class="input-group-addon btn" id="p_packet_reason_search" data-search="p_packet_reason"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>&nbsp;</label>
                <select class="form-control" id="p_select_plus" name="p_select_plus">
                    <option value="">Select</option>
                    <option <?php if($pack_edit->pack_plus_minus == 'Plus'){echo "selected";}?> value="Plus">Plus</option>
                    <option <?php if($pack_edit->pack_plus_minus == 'minus'){echo "selected";}?> value="minus">Minus</option>
                </select>
            </div>
            <span class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label>Copies</label>
                <input type="text" class="form-control" <?php if($pack_edit->pack_plus_minus == 'Plus' || $pack_edit->pack_plus_minus == 'minus' ){ echo "";}?> id="p_copy" name="p_copy" value="<?php echo $pack_edit->pack_copies;?>" />
            </span>
            <span class="col-lg-8 col-md-4 col-sm-6 col-xs-12">
                <label>Remark</label>
                <input type="text" class="form-control" id="p_remark" name="p_remark" value="<?php echo $pack_edit->pack_remarks ;?>" />
            </span>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <label>Status</label>
                <select name="p_pack_status" id="p_pack_status" class="form-control">
                    <option <?php if($pack_edit->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                    <option <?php if($pack_edit->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>
                </select>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button id="update-pack-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
            </div>
        </form>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>