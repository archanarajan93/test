<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <span class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 5px;">
        <select name="unit_filter" multiple="multiple" id="unit_filter" placeholder="Select Unit" class="form-control select2" style="height:30px;">
            <option value="">Select</option>
            <?php foreach($unit_list as $unit_rec) { ?>
            <option value="<?php echo $unit_rec->unit_code; ?>"><?php echo $unit_rec->unit_name; ?></option>
            <?php } ?>
        </select>
    </span>
    <span class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 5px;">
        <select name="product_filter" multiple="multiple" id="product_filter" placeholder="Select Product" class="form-control select2" style="height:30px;">
            <option value="">Select</option>
            <?php foreach($product_list as $pdt_rec) { ?>
            <option value="<?php echo $pdt_rec->product_code; ?>"><?php echo $pdt_rec->product_name; ?></option>
            <?php } ?>
        </select>
    </span>
    <span class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 5px;">
        <select name="group_filter" multiple="multiple" id="group_filter" placeholder="Select Group" class="form-control select2" style="height:30px;">
            <option value="">Select</option>
            <?php foreach($group_list as $grp_rec) {
            ?>
            <option value="<?php echo $grp_rec->group_name; ?>"><?php echo $grp_rec->group_name; ?></option>
            <?php } ?>
        </select>
    </span>
</div>
