<div class="box no-border no-padding">
    <div class="box-body no-padding">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Issue ID</label>
            <input value="<?php echo $issue->issue_code; ?>" readonly autocomplete="off" required type="text" class="form-control" id="p_issue_code" name="p_issue_code" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Issue Name</label>
            <input value="<?php echo $issue->issue_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_issue_name" name="p_issue_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Issue Product</label>
            <select name="p_issue_product_code" id="p_issue_product_code" class="form-control" required>
                <?php foreach($product_list as $p) { ?>
                <option <?php echo ($p->product_code == $issue->issue_product_code) ? "selected" : ""; ?> value="<?php echo $p->product_code; ?>"><?php echo $p->product_name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Publish Date</label>
            <div class="input-group">
                <input required type="text" value="<?php echo date('d-m-Y',strtotime($issue->issue_date)); ?>" class="form-control" id="p_issue_date" name="p_issue_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
            </div>
        </div>

        <input type="hidden" id="p_issue_img_flag" value="<?php echo $issue->issue_img_flag; ?>" />
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Issue Cover Image</label>
            <img src="<?php echo base_url('uploads/issue/'.$issue->issue_product_code.'/'.$issue->issue_code.'.jpg'); ?>" style="max-width:100%;" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>New Cover Image</label>
            <input type="file" class="form-control" required name="p_issue_img" id="p_issue_img" />      
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button id="update-issue-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>