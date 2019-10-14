<!--Help Section-->
<div id="helpModal" class="modal fade pop-more" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <form action="#">
                    <a class="close" href="#" data-dismiss="modal">×</a>
                    <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                    <input id="help_search" class="form-control ToMal" type="search" name="s" placeholder="Search Here..." />
                    <span class="btn-group pull-right hide">
                        <input type="button" class="btn btn-primary btn-sm E_M aruna-font" style="margin-right:2px;" value="English" title="Press Ctrl+Alt to Change Language">
                        <input type="button" class="btn btn-primary btn-sm I_V aruna-font" style="margin-right:2px;" value="<?php //echo $this->user->user_kb_type == KeyboardPreference::Verifone ? 'വെരിഫോൺ' : 'ഇൻസ്ക്രിപ്‌റ്റ്';  ?>" />
                    </span>
                </form>
                <div class="row" style="margin-top:10px;" id="hlp_filters"></div>
            </div>
            <div class="modal-body">
                <div id="no-records"> No records found!</div>
                <img class="hide" src="<?php echo base_url('assets/imgs/loading.gif'); ?>" id="loader" />
                <div id="help-info" data-multiselect="false" class="table-responsive table-help" data-height="470" style="height:470px;">
                    <table class="traverseTable table-hover no-wrap" border="0" id="help-table">
                        <thead id="help-thead"></thead>
                        <tbody id="help-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!--\.Help Section-->