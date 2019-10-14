<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_reg_code" value="<?php echo $reg_rec->region_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Region Name </label>
            <input value="<?php echo $reg_rec->region_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_reg_name" name="p_reg_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_reg_status" id="p_reg_status" class="form-control">
                <option <?php if($reg_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($reg_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-region-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>