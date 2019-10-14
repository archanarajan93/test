<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_promoter_code" value="<?php echo $promoter->promoter_code; ?>" />

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Promoter Name</label>
            <input value="<?php echo $promoter->promoter_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_promoter_name" name="p_promoter_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Promoter Area</label>
            <input value="<?php echo $promoter->promoter_area; ?>" autocomplete="off" required type="text" class="form-control" id="p_promoter_area" name="p_promoter_area" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Promoter Phone</label>
            <input value="<?php echo $promoter->promoter_phone; ?>" autocomplete="off" required type="text" class="form-control" id="p_promoter_phone" name="p_promoter_phone" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Promoter ACM</label>
            <select class="form-control" id="p_promoter_acm_code">
                <?php foreach($acm as $a) { ?>
                <option <?php echo $a->acm_code == $promoter->promoter_acm_code ? "selected" : ""; ?> value="<?php echo $a->acm_code; ?>"><?php echo $a->acm_name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-promoter-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>