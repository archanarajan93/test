<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <form method="post" id="aggrp_update_form">
            <input type="hidden" id="edt_rate_code" value="<?php echo $sch_copy_rate->rate_code; ?>" />
            <table class="table table-sec" style="width:100%">
                <tr>
                    <td>Copy Group</td>
                    <td colspan="6">
                        <input type="text" class="form-control" readonly value="<?php echo $sch_copy_rate->group_name; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>Copy Type</td>
                    <td colspan="6">
                        <input type="text" class="form-control" readonly value="<?php echo $sch_copy_rate->copytype_name; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Duration</td>
                    <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="edt_years" id="edt_years" value="<?php echo $sch_copy_rate->rate_sch_years; ?>" style="text-align:right;padding:8px !important;" /></td>
                    <td>Year</td>
                    <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="edt_months" id="edt_months" value="<?php echo $sch_copy_rate->rate_sch_months; ?>" style="text-align:right;padding:8px !important;" /></td>
                    <td>Month</td>
                    <td><input type="text" required class="form-control isNumberKey" isDecimal="true" name="edt_days" id="edt_days" value="<?php echo $sch_copy_rate->rate_sch_days; ?>" style="text-align:right;padding:8px !important;" /></td>
                    <td>Days</td>
                </tr>
                <tr>
                    <td>Rate</td>
                    <td colspan="5"><input type="text" required class="form-control isNumberKey" isDecimal="true" name="edt_rate" id="edt_rate" value="<?php echo $sch_copy_rate->rate_amount; ?>" style="text-align:right;padding:8px !important;" /></td>
                    <td>Rs</td>
                </tr>
                <!--<tr>
                    <td colspan="3"><button class="btn btn-block btn-primary" type="submit" style="width:205px;"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Save</button></td>
                    <td colspan="4"><button onclick="window.location='<?php echo base_url('Dashboard');?>'" class="btn btn-block btn-danger" type="button" style="width:205px;"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button></td>
                </tr>-->
            </table>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button id="update-scheme-rates" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>&nbsp;</label>
                <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
            </div>
        </form>
    </div>
</div>