<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="p_ct_code" value="<?php echo $copy_type_rec->copytype_code; ?>" />
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label> Copy Type Name</label>
            <input value="<?php echo $copy_type_rec->copytype_name; ?>" autocomplete="off" required type="text" class="form-control" id="p_ct_name" name="p_ct_name" />
        </div>

        <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Copy Code</label>
            <input value="<?php  echo $copy_type_rec->copy_code; ?>" autocomplete="off" required type="text" class="form-control" id="p_type_code" name="p_type_code" />
             <?php echo $copy_type_rec->copy_name;?>
         </div>-->
        <span class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
            <label>Copy Code</label>
            <select name="copy_code" id="p_copy_code" class="form-control" required>
                <?php foreach($copy_code as $code){?>
                <option <?php if($code->copy_code == $copy_type_rec->copy_code ){echo "selected";}?> value="<?php echo $code->copy_code;?>"><?php echo $code->copy_name;?></option>
                <?php } ?>
            </select>
        </span>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12" id="unit-wrap">
            <label>Copy Group</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $copy_type_rec->group_name; ?>" type="text" class="form-control" id="p_ct_group" name="p_ct_group" data-request='{"id":"15","search":""}' data-callback="yearType" data-select="{}" data-multiselect="false" placeholder="" data-criteria='[{"column":"group_copy_code","input":"#p_copy_code","select":"","encode":"false","multiselect":"false","msg":"","required":"false"}]' />
                <input type="hidden" name="p_ct_group_rec_sel" class="p_ct_group_clr" id="p_ct_group_rec_sel" value="<?php echo rawurlencode(json_encode(array("Name"=>$copy_type_rec->group_name,"Code"=>$copy_type_rec->group_code)));?>">
                <div class="input-group-addon btn" id="p_ct_group_search" data-search="p_ct_group"><i class="fa fa-search"></i></div>
           
             </div>
        </div>
        <?php if($copy_type_rec->copy_name == 'SCHEME' && $copy_type_rec->group_name == 'UNITY'){?>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 " id="type_year">
            <label>Year</label>
            <div class="input-group">
                <input autocomplete="off" required type="text" value="<?php echo $copy_type_rec->copytype_year; ?>" class="form-control yearpicker" id="p_ct_year" name="p_ct_year" />
                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
           </div>
             </div>
        <?php }?>
        <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12 hide" id="p_type_year">
            <label>Year</label>
            <div class="input-group">
                <input autocomplete="off" required type="text" value="" class="form-control yearpicker" id="p_type_show_year" name="p_type_show_year" />
                <div class="input-group-addon btn"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Status</label>
            <select name="p_ct_status" id="p_ct_status" class="form-control">
                <option <?php if($copy_type_rec->cancel_flag == Status::Active){ echo "selected";}?> value="0">Active</option>
                <option <?php if($copy_type_rec->cancel_flag == Status::Disable){ echo "selected";}?>  value="1">Disabled</option>
               
            </select>
        </div>
        <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</span>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button id="update-ct-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>&nbsp;</label>
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>
<script>
    function yearType() {
        var typeGroup = $("#p_ct_group").val();
        var typeCopyCode = $("#p_copy_code").val();
        if (typeGroup == 'UNITY' && typeCopyCode == 'CP0003') {
            $("#p_type_year").removeClass('hide');
        } else {
            $("#p_type_year").addClass('hide');
        }
    }

</script>