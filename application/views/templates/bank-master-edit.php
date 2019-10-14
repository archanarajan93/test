<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_bnk_code" value="<?php echo $bank_rec->bank_code; ?>" />
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Bank Name</label>
            <input class="form-control" id="p_bank_name" name="p_bank_name" value="<?php echo $bank_rec->bank_name; ?>" required />
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Bank Location</label>
            <input class="form-control" id="p_bank_loc" name="p_bank_loc" value="<?php echo $bank_rec->bank_location; ?>" required />
        </div>
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_bnk_status" id="p_bnk_status" class="form-control">
                <option <?php if($bank_rec->bank_disabled == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($bank_rec->bank_disabled == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-bank-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>