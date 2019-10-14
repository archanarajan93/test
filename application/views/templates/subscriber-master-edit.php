<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form method="post">
            <input type="hidden" id="p_sub_code" value="<?php echo $sub_rec->sub_code; ?>" />
            <input value="<?php echo $this->user->user_unit_code; ?>" autocomplete="off" required type="text" class="hidden" id="p_sub_union" name="p_sub_union" />

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Subscriber Name </label>
                <input value="<?php echo $sub_rec->sub_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sub_name" name="p_sub_name" />
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Subscriber Address </label>
                <input value="<?php echo $sub_rec->sub_address; ?>" autocomplete="off" required type="text" class="form-control" id="p_sub_address" name="p_sub_address" />
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Subscriber Phone</label>
                <input value="<?php echo $sub_rec->sub_phone; ?>" autocomplete="off" required type="text" class="form-control isNumberKey" id="p_sub_mobile" name="p_sub_mobile" />
            </div>
            <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                <label>Edition</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $sub_rec->edition_name; ?>" type="text" class="form-control" id="p_sub_edition" name="p_sub_edition" data-request='{"id":"10","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"edition_unit","input":"#p_sub_union","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' />
                    <input type="hidden" name="p_sub_edition_rec_sel" class="sub_edition_clr" id="p_sub_edition_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sub_rec->edition_name,"Code"=>$sub_rec->edition_code)));?>">
                    <div class="input-group-addon btn" id="p_sub_edition_search" data-search="p_sub_edition"><i class="fa fa-search"></i></div>
                </div>
            </div>

            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
                <label>Agent Code</label>
                <div class="input-group search-module" data-selected="true">
                    <input autocomplete="off" value="<?php echo $sub_rec->agent_code; ?>" type="text" class="form-control" data-selectindex="0" id="p_sub_agent" name="p_sub_agent" data-request='{"id":"17","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"agent_unit","input":"#p_sub_union","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' />
                    <input type="hidden" name="p_sub_agent_rec_sel" class="sub_agent_clr"  id="p_sub_agent_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$sub_rec->agent_name,"Code"=>$sub_rec->agent_code,"SerialNumber"=>$sub_rec->agent_slno )));?>">
                    <div class="input-group-addon btn" id="p_sub_agent_search" data-search="p_sub_agent"><i class="fa fa-search"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>Agent Name</label>
                <input readonly type="text" value="" class="form-control sub_agent_clr" id="p_agent_name" name="agent_name" />
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                <label>Agent Location</label>
                <input readonly type="text" value="" class="form-control sub_agent_clr" id="p_agent_loc" name="agent_loc" />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Status</label>
                <select name="p_sub_status" id="p_sub_status" class="form-control">
                    <option <?php if($sub_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                    <option <?php if($sub_rec->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>
                </select>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button id="update-sub-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>