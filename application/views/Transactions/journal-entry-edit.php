<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_je_code" name="p_je_code" value="<?php echo $je_edit->je_code; ?>" />
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Journal Date</label>
            <div class="input-group">
                <input type="text" readonly value="<?php echo date('d-m-Y',strtotime($journal_date));?>" class="form-control" id="jour_date" name="jour_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 p_agent_sel">
            <label>Agent</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $je_edit->je_agent_code;?>" type="text" class="form-control" id="p_agent" name="p_agent" data-request='{"id":"17","search":""}' data-target='[{"selector":"#p_agent_det","indexes":"1,2"}]' data-select="{}" data-multiselect="false" placeholder="" />
                <input type="hidden" name="p_agent_rec_sel" class="p_agent_clr" id="p_agent_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$je_edit->je_agent_code,"SerialNumber"=>$je_edit->je_agent_slno)));?>">
                <div class="input-group-addon btn" id="p_agent_search" data-search="agent"><i class="fa fa-search"></i></div>
            </div>
        </div>
        <span class="col-lg-12 col-md-4 col-sm-6 col-xs-12 p_agent_sel">
            <label>Agent Details</label>
            <input type="text" readonly class="form-control" value="<?php echo $je_edit->agent_name;?><?php echo $je_edit->agent_location;?>" id="p_agent_det" name="p_agent_det" />
        </span>
        
        <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
            <label>Journal Head</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $je_edit->ac_name;?>" type="text" class="form-control" id="p_accounthead" name="p_accounthead" data-request='{"id":"36","search":""}' data-select="{}" data-multiselect="false" placeholder="" />
                <input type="hidden" name="p_accounthead_rec_sel" class="p_packet_reason_clr" id="p_accounthead_rec_sel" value="<?php echo  rawurlencode(json_encode(array("Code"=>$je_edit->je_ac_code,"Debit/Credit"=>$je_edit->je_debit_amount?"DEBIT":"CREDIT")));?>">
                <div class="input-group-addon btn" id="p_accounthead_search" data-search="p_accounthead"><i class="fa fa-search"></i></div>
            </div>
        </div>
        
        <span class="col-lg-12 col-md-4 col-sm-6 col-xs-12">
            <label>Narration</label>
            <input type="text" class="form-control" id="p_je_Narration" name="p_je_Narration" value="<?php echo $je_edit->je_narration;?>" />
        </span>
        <span class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
            <label>Amount</label>
            <input type="number" class="form-control" id="p_je_amount" name="p_je_amount" value="<?php if($je_edit->je_debit_amount) {echo $je_edit->je_debit_amount;} else if($je_edit->je_credit_amount){ echo $je_edit->je_credit_amount; }  ;?>" />
        </span>
        <!--<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_je_status" id="p_je_status" class="form-control">
                <option <?php //if($je_edit->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php //if($je_edit->cancel_flag == Status::Disable){ echo "selected";}?> value="1">Disabled</option>
            </select>
        </div>-->
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12"></div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-je-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>