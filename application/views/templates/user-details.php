<div class="box no-border no-padding">
    <div class="box-body no-padding">
        <input type="hidden" id="user_id" value="<?php echo $user->user_id; ?>"/>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Login User Name</label>
            <input value="<?php echo $user->user_login_name; ?>" readonly autocomplete="off" required type="text" class="form-control" id="user_login_name" name="user_login_name" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Login Password</label>
            <input value="<?php echo $user->user_login_password; ?>" autocomplete="off" required type="text" class="form-control" id="user_login_password" name="user_login_password" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Unit</label>
            <select name="user_unit_code" id="user_unit_code" class="form-control" required>
                <?php foreach($unit_list as $list_unit) { ?>
                <option <?php echo ($user->user_unit == $list_unit->unit_code) ? 'selected' : ''; ?> value="<?php echo $list_unit->unit_code; ?>"><?php echo $list_unit->unit_name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Employee Name</label>
            <div class="input-group search-module" data-selected="true">
                <input autocomplete="off" value="<?php echo $user->user_emp_name; ?>" required type="text" class="form-control" id="employee_name" name="employee_name" data-request='{"id":"1","search":"Employee"}' data-select="{}" data-multiselect="false" placeholder="Select Employee" />                
                <input type="hidden" name="employee_name_rec_sel" class="employee_name_clr" id="employee_name_rec_sel" value="<?php echo rawurlencode(json_encode(array("Code"=>$user->user_emp_id,"Name"=>$user->user_emp_name,"Department"=>$user->user_emp_dept,"Designation"=>$user->user_emp_desig))); ?>">
                <div class="input-group-addon btn" id="employee_name_search" data-search="employee_name"><i class="fa fa-search"></i></div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Employee ID</label>
            <input readonly autocomplete="off" value="<?php echo $user->user_emp_id; ?>" required type="text" class="form-control" id="employee_id" name="employee_id" />
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <label>Employee Department</label>
            <input readonly autocomplete="off" value="<?php echo $user->user_emp_dept; ?>" required type="text" class="form-control" id="employee_department" name="employee_department" />
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Employee Designation</label>
            <input readonly autocomplete="off" value="<?php echo $user->user_emp_desig; ?>" required type="text" class="form-control" id="employee_designation" name="employee_designation" />
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
        <?php
        $al_list = $sub_list = array();
        foreach($user_menus as $m) {
            if($m->sub_menu_id){
                $sub_list[]=$m->sub_menu_id;
            }else{
                $al_list[]=$m->menu_id;
            }
        }                            
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label>Menu Permission</label>
            <select class="form-control select2" multiple="multiple" name="menu_permission[]" id="menu_permission" style="width:100%;">
                <?php foreach($listmenu_records as $list_menu) { ?>
                <option <?php if(in_array($list_menu->menu_id,$al_list)) { ?> selected <?php } ?>value="<?php echo $list_menu->menu_id; ?>"><?php echo $list_menu->menu_name; ?></option> 
                <?php } ?>
            </select>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
            <label>Block SubMenu</label>
            <select class="form-control select2" multiple="multiple" name="sub_menu_permission[]" id="sub_menu_permission" style="width:100%;"> 
                <?php foreach($submenu_records as $list_menu) { ?>
                    <option <?php if(in_array($list_menu->menu_id,$sub_list)) { ?> selected <?php } ?> value="<?php echo $list_menu->menu_id."#".$list_menu->menu_parent_id; ?>"><?php echo $list_menu->menu_parent_name.' > '.$list_menu->menu_name; ?></option>                                   
                <?php } ?>                    
            </select>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

        <?php
        $u_access = $p_access = array();
        foreach($unit_access as $u){$u_access[]=$u->unit_code;}
        foreach($prod_access as $p){$p_access[]=$p->product_code;}
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
            <table class="table table-results" id="unit-access-tbl">
                <thead>
                    <tr>
                        <td width="1%"><input type="checkbox" id="select-all-unit" /></td>
                        <td>Unit Access</td>
                    </tr>
                </thead>
                <?php foreach($unit_list as $list_unit) { ?>
                <tr>
                    <td><input <?php echo in_array($list_unit->unit_code,$u_access) ? 'checked' : ''; ?> type="checkbox" name="unit_access[]" value="<?php echo $list_unit->unit_code; ?>" /></td>
                    <td><?php echo $list_unit->unit_name; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-results" id="product-access-tbl">
                <thead>
                    <tr>
                        <td width="1%"><input type="checkbox" id="select-all-product" /></td>
                        <td>Product Access</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($product_list as $p) { ?>
                    <tr>
                        <td><input <?php echo in_array($p->product_code,$p_access) ? 'checked' : ''; ?> type="checkbox" name="product_access[]" value="<?php echo $p->product_code; ?>" /></td>
                        <td><?php echo $p->product_name; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button id="update-user-details" class="btn btn-block btn-primary" type="button"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button onclick="$('#common-modal').modal('toggle');" class="btn btn-block btn-danger" type="button"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Close</button>
        </div>
    </div>
</div>