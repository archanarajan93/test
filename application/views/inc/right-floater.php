<!--Day calculator-->
<div data-display="false" style="height:auto;" id="right_floater_wrap">
    <div style="position:relative; float:left;height:100px; width:50px;">
        <div class="right_floater_icon" id="toggle_floater_1" data-open="right_floater_inputs_1" data-toggle="fa-sort-alpha-desc">
            <i style="margin-top:10px" class="fa fa-2x fa-sort-alpha-desc" aria-hidden="true"></i>
        </div>
        <div class="right_floater_icon" id="toggle_floater_2" data-open="right_floater_inputs_2" data-toggle="fa-book">
            <i style="margin-top:10px" class="fa fa-2x fa-book" aria-hidden="true"></i>
        </div>
    </div>
    <div class="right_floater_inputs" id="right_floater_inputs_1">
        <div style="width: 100%;background-color:aliceblue;float: left;">
            <form id="dic-form">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Dictionary</label>
                    <input readonly style="text-align:left;color:#36924a;font-weight: bold;" type="text" class="form-control" id="dic_word">
                </span>
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Search Word</label>
                    <input type="text" class="form-control" id="dic_search_word">
                </span>
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label>&nbsp;</label>
                    <button type="reset" id="dic_reset" class="btn btn-block btn-danger"><i class="fa fa-minus-square-o" aria-hidden="true"></i>&nbsp;Reset</button>
                </span>
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label>&nbsp;</label>
                    <button type="button" id="dic_submit" class="btn btn-block btn-info ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</span></button>
                </span>
                <span class="col-xs-12">&nbsp;</span>
            </form>
        </div>
    </div>    
    <div class="right_floater_inputs" id="right_floater_inputs_2">
        <div style="width: 100%;background-color:aliceblue;float: left;">
            <form id="thes-form">
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Thesarus</label>
                    <input readonly style="text-align:left;color:#36924a;font-weight: bold;" type="text" class="form-control" id="thes_word">
                </span>
                <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label>Search Word</label>
                    <input type="text" class="form-control ToMal" id="thes_search_word">
                </span>
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label>&nbsp;</label>
                    <button type="reset" id="dic_reset" class="btn btn-block btn-danger"><i class="fa fa-minus-square-o" aria-hidden="true"></i>&nbsp;Reset</button>
                </span>
                <span class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label>&nbsp;</label>
                    <button type="button" id="thes_submit" class="btn btn-block btn-info ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</span></button>
                </span>
                <div class="btn-group hide" style="margin-top:2px;">
                    <input type="button" class="btn btn-primary btn-sm E_M aruna-font" style="margin-right:2px;" value="മലയാളം" title="Press Ctrl+Alt to Change Language">
                    <input type="button" class="btn btn-primary btn-sm I_V aruna-font" style="margin-right:2px;" value="<?php echo $this->user->user_kb_type == KeyboardPreference::Verifone ? 'വെരിഫോൺ' : 'ഇൻസ്ക്രിപ്‌റ്റ്';  ?>" />
                </div>
                <span class="col-xs-12">&nbsp;</span>
            </form>
        </div>
    </div>
</div>
<!--\.Day Calculator-->