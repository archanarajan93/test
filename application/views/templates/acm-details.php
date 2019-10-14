<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_acm_code" value="<?php echo $acm->acm_code; ?>" />
        <input type="hidden" name="unit_code" id="unit_code" value="<?php echo $this->user->user_unit_code;?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>ACM Name</label>
            <input value="<?php echo $acm->acm_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_acm_name" name="p_acm_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Phone</label>
            <input value="<?php echo $acm->acm_phone; ?>" autocomplete="off" required type="text" class="form-control" id="p_acm_phone" name="p_acm_phone" />
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <label>Region</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $acm->region_name;?>" required type="text" class="form-control" id="edt_region" name="edt_region" data-request='{"id":"21","search":"Name"}' data-select="{}"
                        data-criteria='[{"column":"region_unit","input":"#unit_code","select":"","encode":"false","multiselect":"false","required":"false"}]' data-multiselect="false" placeholder="Select Region" />
                <input type="hidden" name="edt_region_rec_sel" class="edt_region_clr" id="edt_region_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$acm->acm_region,"Name"=>$acm->region_name)));?>">
                <div class="input-group-addon btn" id="edt_region_search" data-search="edt_region"><i class="fa fa-search"></i></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Status</label>
            <select name="p_acm_status" id="p_acm_status" class="form-control">
                <option <?php if($acm->cancel_flag == Status::Active){echo "selected";}?> value="0">Active</option>
                <option <?php if($acm->cancel_flag == Status::Disable){echo "selected";}?> value="1">Disabled</option>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-acm-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>