<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form  name="p_bonus_form" id="p_bonus_form" >
        <input type="hidden" id="p_bonus_date_code" value="<?php echo $bonus_edit->bonus_code; ?>" />
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Select Month</label>
            <div class="input-group">
                <input required type="text" value="<?php echo date('F-Y',strtotime('01-'.$bonus_edit->bonus_month.'-'.$bonus_edit->bonus_year)); ?>" class="form-control monthpicker" id="p_bonus_month" name="p_bonus_month" />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>2% Bonus Date</label>
            <div class="input-group">
                    <input required data-greater="true" data-compare="#p_bonus_5_date" type="text" value="<?php echo date('d-m-Y',strtotime($bonus_edit->bonus_first_date)); ?>" class="form-control" id="p_bonus_2_date" name="p_bonus_2_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>1.5% Bonus Date</label>
            <div class="input-group">
                    <input required data-greater="true" data-compare="#p_bonus_1_date" type="text" value="<?php echo date('d-m-Y',strtotime($bonus_edit->bonus_second_date)); ?>" class="form-control" id="p_bonus_5_date" name="p_bonus_5_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>1% Bonus Date</label>
            <div class="input-group">
                    <input required type="text" value="<?php echo date('d-m-Y',strtotime($bonus_edit->bonus_third_date)); ?>" class="form-control" id="p_bonus_1_date" name="p_bonus_1_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn">
                    <i class="fa fa-calendar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-bonus-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
      </form>
    </div>
</div>