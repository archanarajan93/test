<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_holiday_code" value="<?php echo $holiday_rec->holiday_code; ?>" />
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label> Date</label>
            <div class="input-group">
                <input required type="text" value="<?php echo date('d-m-Y',strtotime($holiday_rec->holiday_date)); ?>" class="form-control" id="p_holiday_date" name="p_holiday_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Description </label>
            <input value="<?php echo $holiday_rec->holiday_desc; ?>" autocomplete="off" required type="text" class="form-control" id="p_holiday_desc" name="p_holiday_desc" />
        </div>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Applicable to Office Only</label>
            <select name="p_holiday_Office" id="p_holiday_Office" class="form-control">
                <option <?php if($holiday_rec->holiday_office == 0){echo "selected";}?> value="0">No</option>
                <option <?php if($holiday_rec->holiday_office == 1){echo "selected";}?> value="1">Yes</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_holiday_status" id="p_holiday_status" class="form-control">
                <option <?php if($holiday_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($holiday_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-holiday-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>