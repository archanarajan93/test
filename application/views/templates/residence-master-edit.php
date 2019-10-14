<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="res_code" value="<?php echo $residence->res_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Name</label>
            <input value="<?php echo $residence->res_name; ?>" autocomplete="off" required type="text" class="form-control" id="residence_name" name="residence_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Phone Number</label>
            <input value="<?php echo $residence->res_phone; ?>" autocomplete="off" required type="text" class="form-control isNumberKey isMob" id="res_phone" name="res_phone" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Location</label>
            <input value="<?php echo $residence->res_location; ?>" autocomplete="off" required type="text" class="form-control" id="residence_location" name="residence_location" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Contact Person</label>
            <input value="<?php echo $residence->res_contact_person; ?>" autocomplete="off" required type="text" class="form-control" id="residence_cont_person" name="residence_cont_person" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Remarks</label>
            <input value="<?php echo $residence->res_remarks; ?>" autocomplete="off" required type="text" class="form-control" id="residence_remarks" name="residence_remarks" />
        </div>
        <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <input value="<?php echo $residence->cancel_flag; ?>" autocomplete="off" required type="text" class="form-control" id="residence_status" name="residence_status" />
        </div>-->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="residence_status" id="residence_status" class="form-control">
                <option <?php if($residence->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($residence->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
               
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-res-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>