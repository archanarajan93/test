<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_dr_code" value="<?php echo $dp_rec->drop_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Drop Name </label>
            <input value="<?php echo $dp_rec->drop_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_dr_name" name="p_dr_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Drop Malayalam Name </label>
            <input value="<?php echo $dp_rec->drop_mal_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_dr_mal" name="p_dr_mal" />
        </div>

        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
            <label>Route Code</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $dp_rec->route_name;?>" required type="text" class="form-control" id="p_drop_route_code" name="p_drop_route_code" data-request='{"id":"11","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                <input type="hidden" name="p_drop_route_code_rec_sel" class="p_drop_route_code_clr" id="p_drop_route_code_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$dp_rec->route_name,"Code"=>$dp_rec->drop_route_code)))?>">
                 <div class="input-group-addon btn" id="p_drop_route_code_search" data-search="dr_route_code">
                    <i class="fa fa-search"></i>
                </div>
            </div>
        </div>
              
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_dr_status" id="p_dr_status" class="form-control">
                <option <?php if($dp_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($dp_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>              
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-drop-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>