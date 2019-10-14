<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_amnd_type_code" value="<?php echo $amt_rec->type_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Reason Name </label>
            <input value="<?php echo $amt_rec->type_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_amnd_type_name" name="p_amnd_type_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_amnd_type_status" id="p_amnd_type_status" class="form-control">
                <option <?php if($amt_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($amt_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-type-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>