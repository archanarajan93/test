<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_sh_code" value="<?php echo $shakha_rec->shakha_code; ?>" />
        <input value="<?php echo $this->user->user_unit_code; ?>" autocomplete="off" required type="text" class="hidden" id="p_sh_union" name="p_sh_union" />
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Shakha No. </label>
            <input value="<?php echo $shakha_rec->shakha_no; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_number" name="p_sh_number" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Name </label>
            <input value="<?php echo $shakha_rec->shakha_name; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sh_name" name="p_sh_name" />
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Address 1</label>
            <input value="<?php echo $shakha_rec->shakha_address1; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_address1" name="p_sh_address1" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Address 2</label>
            <input value="<?php echo $shakha_rec->shakha_address2; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_address2" name="p_sh_address2" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Town</label>
            <input value="<?php echo $shakha_rec->shakha_town; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sh_town" name="p_sh_town" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Pincode</label>
            <input value="<?php echo $shakha_rec->shakha_pincode; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_pin" name="p_sh_pin" />
        </div>
       
        
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
            <label>Union</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $shakha_rec->union_name; ?>" type="text" class="form-control" id="p_shakha_union" name="p_shakha_union" data-request='{"id":"8","search":""}' data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"union_unit","input":"#p_sh_union","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' />
                <input type="hidden" name="p_shakha_union_rec_sel" class="p_shakha_union_clr" id="p_shakha_union_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$shakha_rec->union_name,"Code"=>$shakha_rec->shakha_union_code)))?>">
                <div class="input-group-addon btn" id="p_shakha_union_search" data-search="p_shakha_union"><i class="fa fa-search"></i></div>
            </div>
        </div>
       
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>President</label>
            <input value="<?php echo $shakha_rec->shakha_president; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sh_pres" name="p_sh_pres" />
        </div>
        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>President Mobile</label>
            <input value="<?php echo $shakha_rec->shakha_president_phone; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_pres_mobile" name="p_sh_pres_mobile" />
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Secretary</label>
            <input value="<?php echo $shakha_rec->shakha_secretary; ?>" autocomplete="off" required type="text" class="form-control isAlpha" id="p_sh_sec" name="p_sh_sec" />
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Secretary Mobile</label>
            <input value="<?php echo $shakha_rec->shakha_secretary_phone; ?>" autocomplete="off" required type="text" class="form-control" id="p_sh_sec_mobile" name="p_sh_sec_mobile" />
        </div>
      
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_sh_status" id="p_sh_status" class="form-control">
                <option <?php if($shakha_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($shakha_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
               
            </select>
        </div>
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-sh-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>