<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_group_code" value="<?php echo $grp_cpy->group_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Group Name</label>
            <input value="<?php echo $grp_cpy->group_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_grp_name" name="p_grp_name" />
        </div>
        <span class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Copy Code</label>
            <select name="p_copy_code" id="p_copy_code" class="form-control" required >
                <?php foreach($grpcpy_code as $copy){?>
                <option <?php if( $copy->copy_code == $grp_cpy->group_copy_code){echo "selected";}?> value="<?php echo $copy->copy_code; ?>"><?php echo $copy->copy_name; ?></option>
                <?php }?>
            </select>
        </span>
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_grp_status" id="p_grp_status" class="form-control">
                <option <?php if($grp_cpy->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($grp_cpy->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>

            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-grp-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>