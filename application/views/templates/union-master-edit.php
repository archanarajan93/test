<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_un_code" value="<?php echo $union_rec->union_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Name</label>
            <input value="<?php echo $union_rec->union_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_name" name="p_un_name" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Address 1</label>
            <input value="<?php echo $union_rec->union_address1; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_address1" name="p_un_address1" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Address 2</label>
            <input value="<?php echo $union_rec->union_address2; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_address2" name="p_un_address2" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Town</label>
            <input value="<?php echo $union_rec->union_town; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_town" name="p_un_town" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Pincode</label>
            <input value="<?php echo $union_rec->union_pincode; ?>" autocomplete="off" required type="number" class="form-control isNumberKey" id="p_un_pin" name="p_un_pin" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>President</label>
            <input value="<?php echo $union_rec->union_president; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_pres" name="p_un_pres" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>President Mobile</label>
            <input value="<?php echo $union_rec->union_president_phone; ?>" autocomplete="off" required type="number" class="form-control isNumberKey" id="p_un_pres_mobile" name="p_un_pres_mobile" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Secretary</label>
            <input value="<?php echo $union_rec->union_secretary; ?>" autocomplete="off" required type="text" class="form-control" id="p_un_sec" name="p_un_sec" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Secretary Mobile</label>
            <input value="<?php echo $union_rec->union_secretary_phone; ?>" autocomplete="off" required type="number" class="form-control isNumberKey" id="p_un_sec_mobile" name="p_un_sec_mobile" />
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_un_status" id="p_un_status" class="form-control">
                <option <?php if($union_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($union_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
               
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-un-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>