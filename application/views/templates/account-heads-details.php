<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hide">
            <label>Code</label>
            <input value="<?php echo $acc_heads->ac_code; ?>" readonly autocomplete="off" type="text" class="form-control" id="p_ac_code" name="p_ac_code" />
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Name</label>
            <input value="<?php echo $acc_heads->ac_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_ac_name" name="p_ac_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Type</label>
            <select name="p_ac_debit_credit" id="p_ac_debit_credit" class="form-control">
                <?php $type = Enum::getAllConstants('AccountHeads');
                foreach($type as $key => $value) { ?>
                <option <?php echo $acc_heads->ac_debit_credit == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_ac_status" id="p_ac_status" class="form-control">
                <?php $status = Enum::getAllConstants('Status'); 
                foreach($status as $key => $value) { ?>
                <option <?php echo $acc_heads->cancel_flag == $key ? "selected" : ""; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-ah-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>