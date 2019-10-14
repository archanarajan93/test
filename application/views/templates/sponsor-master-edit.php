<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form method="post">
            <input type="hidden" id="p_sp_code" value="<?php echo $sp_rec->client_code; ?>" />
            <!--<input value="<?php //echo $this->user->user_unit_code; ?>" autocomplete="off" required type="text" class="hidden" id="p_sub_union" name="p_sub_union" />-->

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Sponsor Name </label>
                <input value="<?php echo $sp_rec->client_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sp_name" name="p_sp_name" />
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Sponsor Address </label>
                <input value="<?php echo $sp_rec->client_address; ?>" autocomplete="off" required type="text" class="form-control" id="p_sp_address" name="p_sp_address" />
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Sponsor Phone</label>
                <input value="<?php echo $sp_rec->client_phone; ?>" autocomplete="off" required type="text" class="form-control isNumberKey" id="p_sp_mobile" name="p_sp_mobile" />
            </div>
           
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Status</label>
                <select name="p_sp_status" id="p_sp_status" class="form-control">
                    <option <?php if($sp_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                    <option <?php if($sp_rec->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>
                </select>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button id="update-sponsor-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>