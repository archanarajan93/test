<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_well_code" value="<?php echo $well_rec->well_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Name</label>
            <input value="<?php echo $well_rec->well_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_well_name" name="p_well_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Phone Number</label>
            <input value="<?php echo $well_rec->well_phone; ?>" autocomplete="off" required type="text" class="form-control" id="p_well_phone" name="p_well_phone" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Location</label>
            <input value="<?php echo $well_rec->well_location; ?>" autocomplete="off" required type="text" class="form-control" id="p_well_location" name="p_well_location" />
        </div>
       
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Remarks</label>
            <input value="<?php echo $well_rec->well_remarks; ?>" autocomplete="off" required type="text" class="form-control" id="p_well_remarks" name="p_well_remarks" />
        </div>
        <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <input value="<?php //echo $residence->cancel_flag; ?>" autocomplete="off" required type="text" class="form-control" id="residence_status" name="residence_status" />
        </div>-->
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_well_status" id="p_well_status" class="form-control">
                <option <?php if($well_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($well_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-well-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>