<div class="box no-border no-padding">
    <div class="box-body no-padding">
            <input type="hidden" value="<?php echo $evt_rec->event_code; ?>" readonly autocomplete="off" required  class="form-control" id="p_even_code" />
        

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Event Name</label>
            <input value="<?php echo $evt_rec->event_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_even_name" name="p_issue_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Event Start Date</label>
            <div class="input-group">
                <input required type="text" value="<?php echo date('d-m-Y',strtotime($evt_rec->event_start_date)); ?>" class="form-control" id="p_even_start_date" name="p_even_start_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Event End Date</label>
            <div class="input-group">
                <input required type="text" value="<?php echo date('d-m-Y',strtotime($evt_rec->event_end_date)); ?>" class="form-control" id="p_event_end_date" name="p_event_end_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_even_status" id="p_even_status" class="form-control">
                <option <?php if($evt_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($evt_rec->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>

            </select>
        </div>
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button id="update-event-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>