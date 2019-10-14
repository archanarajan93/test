<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_rt_code" value="<?php echo $route_rec->route_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Route Name</label>
            <input value="<?php echo $route_rec->route_name; ?>"  autocomplete="off" required type="text" class="form-control" id="p_rt_name" name="p_rt_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Vehicle Type</label>
            <input value="<?php echo $route_rec->route_vehicle_type; ?>" autocomplete="off" required type="text" class="form-control" id="p_rt_type" name="p_rt_type" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Vehicle Number</label>
            <input value="<?php echo $route_rec->route_vehicle_no; ?>" autocomplete="off" required type="text" class="form-control" id="p_rt_number" name="p_rt_number" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Vehicle Start Time</label>
            <div class="input-group">
                <input required type="text" value="<?php echo $route_rec->route_vehicle_start_time; ?>" class="form-control timepicker" id="p_rt_date" name="p_rt_date"  />
                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
            </div>
        </div>
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_rt_status" id="p_rt_status" class="form-control">
                <option <?php if($route_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($route_rec->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>

            </select>
        </div>

       

        <!--<input type="hidden" id="p_issue_img_flag" value="<?php echo $issue->issue_img_flag; ?>" />
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Issue Cover Image</label>
            <img src="<?php echo base_url('uploads/issue/'.$issue->issue_product_code.'/'.$issue->issue_code.'.jpg'); ?>" style="max-width:100%;" />
        </div>-->

        <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>New Cover Image</label>
            <input type="file" class="form-control" required name="p_issue_img" id="p_issue_img" />      
        </div>-->

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button id="update-route-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>