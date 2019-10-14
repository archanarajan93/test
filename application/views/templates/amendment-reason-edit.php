<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_amnd_code" value="<?php echo $amnd_rec->reason_id; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Reason Name </label>
            <input value="<?php echo $amnd_rec->reason_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_amnd_name" name="p_amnd_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_amnd_status" id="p_amnd_status" class="form-control">
                <option <?php if($amnd_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($amnd_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-reason-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>