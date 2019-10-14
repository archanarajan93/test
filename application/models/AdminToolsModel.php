<?php
class AdminToolsModel extends CI_Model 
{
	public function __construct() {
		parent::__construct();
	}
    public function ViewPrimaryId($no_id) {
		$sql 	  = $this->db->query("SELECT no_value FROM pmd_numbersetup WHERE no_id='$no_id'");
		$no_value = $sql->row()->no_value;
		return $no_value;
	}
    public function GetPrimaryId($no_id) {
		$sql 	  = $this->db->query("SELECT no_value FROM pmd_numbersetup WHERE no_id='$no_id' FOR UPDATE");
		$no_value = $sql->row()->no_value;
		return $no_value;
	}
    public function UpdatePrimaryId($no_value, $no_id, $is_incremented=false) {
		$new_string = $is_incremented ?  $no_value : $this->AutoIncrement($no_value);
		if(!empty($new_string))
		{
			$this->db->query("UPDATE pmd_numbersetup SET no_value='$new_string' WHERE no_id='$no_id'");
		}
	}
	private function AutoIncrement($no_value) {
		$sLen=strlen($no_value);
		$string = preg_replace("([^A-Z,^a-z])", "",$no_value);
		$number=preg_replace("([^0-9])", "",$no_value);
		$number=$number+1;
		$new_string=$string.$number;
		$sLenNew=strlen($new_string);
		if ($sLenNew < $sLen)
		{
			$Zero= str_repeat('0',($sLen-$sLenNew));
			$new_string=$string.$Zero.$number;
		}
		return $new_string;
	}
    //Global method to check duplicate exists
    private function IsDuplicate($tbl_name, $tbl_condition = FALSE) {
        return $this->db->query("SELECT EXISTS(SELECT 1 FROM ".$tbl_name." WHERE ".$tbl_condition." LIMIT 1) AS exist")->row()->exist;
    }
    public function CopyGroupsLists($copy_codes=array())
    {
        $where = '';
        if($copy_codes){
            $where .= " AND group_copy_code IN ('".implode("','",$copy_codes)."')";
        }
        return  $this->db->query("SELECT 
                                        group_code, 
                                        group_name
                                    FROM
                                        pmd_copygroup 
                                    WHERE
                                        cancel_flag = 0 ".$where."
                                    ORDER BY group_name")->result();
    }
    //user
    public function MenuList() {
        $query = "SELECT
                        menu_id,menu_parent_id,menu_name
                  FROM
                       pmd_menu
                  WHERE
                        menu_parent_id IS NULL";
        return $this->db->query($query)->result();
    }
    public function SubMenuList() {
        $query = "SELECT
                        M.menu_id,
                        M.menu_parent_id,
                        M.menu_name,
                        (SELECT menu_name FROM pmd_menu WHERE menu_id = M.menu_parent_id AND menu_parent_id IS NULL AND menu_main_id IS NULL AND menu_link IS NULL LIMIT 1) AS menu_parent_name
                  FROM
                        pmd_menu M
                  WHERE
                        M.menu_parent_id IS NOT NULL ORDER BY M.menu_parent_id";
        return $this->db->query($query)->result();
    }
    public function UserMenu() {
        $qry = "SELECT
                    t1.menu_id,
                    t1.sub_menu_id
                FROM
                    pmd_usermenu t1
                WHERE
                    t1.user_id = ".$this->input->post('user_id',true);
        return $this->db->query($qry)->result();
    }    
    public function ProductLists($product_codes=array())
    {
        $where = '';
        if($product_codes){
            $where .= " AND product_code IN ('".implode("','",$product_codes)."')";
        }
        $query = "SELECT
                         `product_code`,
                         `product_name`,
                         `cancel_flag`
                    FROM
                    `pmd_products` WHERE cancel_flag = 0 ".$where." ORDER BY product_priority";  
        return $this->db->query($query)->result();
    }
     public function OtherProductsLists()
    {
        $query = "SELECT
                         `product_code`,
                         `product_name`,
                         `cancel_flag`
                    FROM
                    `pmd_products` WHERE product_code!='DLY' AND cancel_flag = 0 ORDER BY product_priority";  
        return $this->db->query($query)->result();
    }
    public function UserUnits() {
        return $this->db->query("SELECT unit_code FROM pmd_unitaccess where user_id = ".$this->input->post('user_id',true))->result();
    }
    public function UserProducts() {
        return $this->db->query("SELECT product_code FROM pmd_productaccess where user_id = ".$this->input->post('user_id',true))->result();
    }  
    public function SearchUsers()
    {
        $keyword = $this->input->post('search_user',true);
        $unit    = $this->input->post('user_unit_code',true);
        $where_condition = "";

        if($keyword) {
            $where_condition .=" AND t1.`user_emp_name` LIKE '%".$keyword."%'";
        }
        if($unit) {
            $where_condition .= " AND t1.`user_unit` = '".$unit."'";
        }

        $query = "SELECT
                        t1.user_id, 
                        t1.user_emp_name,                         
                        t1.cancel_flag,
                        t2.unit_name
                  FROM
                        pmd_userdetails t1
		                    INNER JOIN
                        pmd_unit t2 ON t1.user_unit = t2.unit_code
		                    WHERE
                        1=1 ".$where_condition." ORDER BY t2.unit_priority,t1.user_emp_name";
        return $this->db->query($query)->result();
    }
    public function UserDetails()
    {
        $query = "SELECT user_unit,user_id,user_login_name,user_login_password,user_emp_id,user_emp_name,user_emp_dept,user_emp_desig FROM pmd_userdetails WHERE user_id = ".$this->input->post('user_id',true);
        return $this->db->query($query)->row();
    }
    public function CreateUserMaster() {
        $user_name   = $this->input->post('user_login_name',true);
        $password    = $this->input->post('user_login_password',true);
        $unit_code   = $this->input->post('user_unit_code',true);
        $emp_rec     = json_decode(rawurldecode($this->input->post('employee_name_rec_sel',true)),true);
        $unit_access = $this->input->post('unit_access',true);
        $pdt_access  = $this->input->post('product_access',true);
        $menu_per    = $this->input->post('menu_permission',true);
        $submenu_per = $this->input->post('sub_menu_permission',true);
        $data_menu_id= array();
        if($user_name && $password && $unit_code && count($emp_rec) && count($unit_access) && count($pdt_access)) {

            $condition = "user_login_name = '".$user_name."'";
            if($this->IsDuplicate('pmd_userdetails',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Login name already taken!";
            }
            else {
                $this->db->trans_begin();
                $data = array("user_unit"=>$unit_code,
                              "user_login_name"=>$user_name,
                              "user_login_password"=>$password,
                              "user_emp_id"=>$emp_rec["Code"],
                              "user_emp_name"=>$emp_rec["Name"],
                              "user_emp_dept"=>$emp_rec["Department"],
                              "user_emp_desig"=>$emp_rec["Designation"],
                              "created_by"=>$this->user->user_id,
                              "created_date"=>date('Y-m-d H:i:s'));
                $this->db->insert('pmd_userdetails', $data);
                $user_id = $this->db->insert_id();

                $u_access = $p_access = array();
                foreach($unit_access as $u) { $u_access[] = array("user_id"=>$user_id,"unit_code"=>$u);    }
                foreach($pdt_access  as $p) { $p_access[] = array("user_id"=>$user_id,"product_code"=>$p); }

                $this->db->insert_batch('pmd_unitaccess',$u_access);
                $this->db->insert_batch('pmd_productaccess',$p_access);

                //menu permission
                foreach($menu_per as $m) {
                    $data_menu_id[]=array("user_id"=>$user_id,"menu_id"=>$m,"sub_menu_id"=>0);
                }
                foreach($submenu_per as $sub_menu) {
                    $rec = explode("#",$sub_menu); $smid = $rec[0]; $mid  = $rec[1];
                    if($smid && $mid) {
                        $data_menu_id[]=array("user_id"=>$user_id,"menu_id"=>$mid,"sub_menu_id"=>$smid);
                    }
                }
                if(count($data_menu_id)) $this->db->insert_batch('pmd_usermenu',$data_menu_id);
                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$this->lang->line('added_success');
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$this->lang->line('error_processing');
                }
            }            
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function UpdateUser()
    {
        $user_id     = $this->input->post('user_id',true);
        $user_name   = $this->input->post('user_login_name',true);
        $password    = $this->input->post('user_login_password',true);
        $unit_code   = $this->input->post('user_unit_code',true);
        $emp_rec     = json_decode(rawurldecode($this->input->post('employee_name_rec_sel',true)),true);
        $unit_access = json_decode($this->input->post('unit_access',true),true);
        $pdt_access  = json_decode($this->input->post('product_access',true),true);
        $menu_per    = json_decode($this->input->post('menu_permission',true),true);
        $submenu_per = json_decode($this->input->post('sub_menu_permission',true),true);
        $data_menu_id= array();
        if($user_id && $user_name && $password && $unit_code && count($emp_rec) && count($unit_access) && count($pdt_access)) {

            $condition = "user_id != ".$user_id." AND user_login_name = '".$user_name."'";
            if($this->IsDuplicate('pmd_userdetails',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Login name already taken!";
            }
            else {
                //"user_login_name"=>$user_name,
                $this->db->trans_begin();
                $data = array("user_unit"=>$unit_code,                              
                              "user_login_password"=>$password,
                              "user_emp_id"=>$emp_rec["Code"],
                              "user_emp_name"=>$emp_rec["Name"],
                              "user_emp_dept"=>$emp_rec["Department"],
                              "user_emp_desig"=>$emp_rec["Designation"],
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('user_id', $user_id);
                $this->db->update('pmd_userdetails', $data);

                //delete old unit and product access records
                $this->db->where('user_id',$user_id);
                $this->db->delete('pmd_unitaccess');
                $this->db->where('user_id',$user_id);
                $this->db->delete('pmd_productaccess');

                $this->db->insert_batch('pmd_unitaccess',$unit_access);
                $this->db->insert_batch('pmd_productaccess',$pdt_access);

                //delete-old-menu-permissions
                $this->db->where('user_id',$user_id);
                $this->db->delete('pmd_usermenu');

                //add-new-menu-permissions
                foreach($menu_per as $m) {
                    $data_menu_id[]=array("user_id"=>$user_id,"menu_id"=>$m,"sub_menu_id"=>0);
                }
                foreach($submenu_per as $sub_menu) {
                    $rec = explode("#",$sub_menu); $smid = $rec[0]; $mid  = $rec[1];
                    if($smid && $mid) {
                        $data_menu_id[]=array("user_id"=>$user_id,"menu_id"=>$mid,"sub_menu_id"=>$smid);
                    }
                }
                if(count($data_menu_id)) $this->db->insert_batch('pmd_usermenu',$data_menu_id);
                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$this->lang->line('updated_success');
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$this->lang->line('error_processing');
                }
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function CheckLoginNameAvailable()
    {
        $login_name=$this->input->post('login_name',true);
        if($login_name)
        {
            $condition="user_login_name='".$login_name."'";
            if($this->IsDuplicate('pmd_userdetails',$condition))
            {
                $this->Message->status=400;
                $this->Message->text="Login Name Already Taken";
            }
            else
            {
                $this->Message->status=200;
                $this->Message->text="Login Name Available";
            }
        }
        else
        {
            $this->Message->status=400;
            $this->Message->text="Login name can't be empty";
        }
        return $this->Message;
    }

    //copy Master
    public function CreateCopyMaster()
    {
        $copy_name=$this->input->post('copy_name',true);
        $condition="copy_name='".$copy_name."'"; 
        if($this->IsDuplicate('pmd_copymaster',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Copy Name already exists!";
        }
        else
        {
             $this->db->trans_begin(); 
             $copy_code = $this->GetPrimaryId('CPY_CODE');
             $query="INSERT INTO pmd_copymaster (`copy_code`,`copy_name`,`created_by`,`created_date`) VALUES ('".$copy_code."','".strtoupper($copy_name)."',".$this->user->user_id.",'".date('Y-m-d H:i:s')."')";
             $this->db->query($query);
             $this->UpdatePrimaryId($copy_code, 'CPY_CODE');
            if($this->db->trans_status() === TRUE)  
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('added_success');
             }  else {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$this->lang->line('error_processing');
                    
                }
            }
        return $this->Message;
    }
    public function UpdateCopyMaster($data)
    {
        $condition="copy_name='".$data['copy_name']."' AND copy_code != '".$data['copy_code']."'"; 
        if($this->IsDuplicate('pmd_copymaster',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Copy Name already exists!";
        }
        else
        {
            $this->db->where('copy_code', $data['copy_code']);
            $this->db->update('pmd_copymaster', $data);
            if($this->db->affected_rows())
            {
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success');
            }else {
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        return json_encode($this->Message);
    } 
    public function DeleteCopyMaster($data)
    {
        $this->db->where('copy_code', $data['copy_code']);
        $this->db->update('pmd_copymaster', $data);
        if($this->db->affected_rows())
        {
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('deleted_success');
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
		return json_encode($this->Message);
    }
    public function CopyLists()
    {
        $query = "SELECT
                         `copy_code`,
                         `copy_name`,
                         `cancel_flag`
                    FROM
                    `pmd_copymaster` WHERE cancel_flag = 0";  
        return $this->db->query($query)->result();
    }

    //Copy group Master
    public function CreateCopyGroups()
    {
        $group_name=strtoupper($this->input->post('copy_group_name',true));
        $copy_code = $this->input->post('copy_code',true);
        $copy_grp = array();
        $condition=" group_name = '".$group_name."'";
        if($this->IsDuplicate('pmd_copygroup',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Group Name Already Exists!";
        }else if(!$group_name || !$copy_code)
        {
            $this->Message->status=400;
            $this->Message->text="All fields are mandatory!";
        }
        else
        {
            $this->db->trans_begin();
            $cpygrp_code=$this->GetPrimaryId('CPYGRP_CODE');
            //foreach($product_codes as $pdt){
            //    $group_pdts[] = array("product_code"=>$pdt,"group_code"=>$group_code);
            //}
            $copy_grp = array("group_code"=>$cpygrp_code,
                              "group_name"=>$group_name,
                              "group_copy_code"=>$copy_code,
                              "created_by"=>$this->user->user_id,
                              "created_date"=>date('Y-m-d H:i:s'),
                              "cancel_flag"=>0);

            $this->db->insert('pmd_copygroup',$copy_grp);
            $this->UpdatePrimaryId($cpygrp_code, 'CPYGRP_CODE');
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('added_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
		return $this->Message;
    }
    public function GetCopyCode(){
        $sql = "SELECT  copy_code,
                        copy_name
                 FROM
                        pmd_copymaster
                WHERE
                    cancel_flag=0";

        return $this->db->query($sql)->result();
    }
    public function UpdateCopyGroups()
    {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $grpName=strtoupper($this->input->post('grpName'));
        $copyCode =$this->input->post('copyCode');
        $grpCode=$this->input->post('grpCode');
        $grpStatus=$this->input->post('grpStatus');
        if( $grpName && $copyCode) {
            $condition=" group_name = '".$grpName."'  AND group_code != '".$grpCode."'";
            if($this->IsDuplicate('pmd_copygroup',$condition))
            {
                $this->Message->status=400;
                $this->Message->text="Group Name Already Exists!";
            }
            else
            {
                $this->db->trans_begin();
                $data=array("group_code"=>$grpCode,
                   "group_copy_code"=>$this->input->post('copyCode'),
                   "group_name"=>strtoupper($this->input->post('grpName')),
                   "cancel_flag"=>$grpStatus,
                   "modified_by"=>$modified_by,
                   "modified_date"=>$modifiedDate);

                $this->db->where('group_code', $this->input->post('grpCode'));
                $this->db->update('pmd_copygroup', $data);
                
                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$this->lang->line('updated_success');
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$this->lang->line('error_processing');
                }
            }
        }
        else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('mandatory_fields_empty'); 
        }
        return $this->Message;
    }
    public function DeleteCopyGroup(){
        $del_group_code = $this->input->post('del_group_code',true);
        $this->db->trans_begin();
        $data = array("cancel_flag"=>1,
                      "modified_by"=>$this->user->user_id,
                      "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->where('group_code',$del_group_code);
        $this->db->update('pmd_copygroup',$data);
        if($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('deleted_success');
        }
        else {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }

        return $this->Message;

    }
    public function GetCopyGroups()
    {
        $query = "SELECT
                        t1.group_code,
                        t1.group_name,
                        t1.group_copy_code,
                        t1.cancel_flag,
                        t2.copy_name
                 FROM
                      pmd_copygroup t1
                 INNER JOIN
                        pmd_copymaster t2 ON t1.group_copy_code = t2.copy_code";
        return $this->db->query($query)->result();
    }
    public function ViewCopyGroup(){
        $qry = "SELECT
                        group_code,
                        group_name,
                       group_copy_code,
                        cancel_flag
                FROM 
                        pmd_copygroup 
                WHERE 
                        group_code = '". $this->input->post('goup_code') ."' LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function UpdateCopyGroupPriority()
    {
        $updateArray=json_decode($this->input->post('pos_Record'),true);
        $this->db->update_batch('pmd_productgroup',$updateArray, 'group_code');
        if($this->db->affected_rows())
        {
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return json_encode($this->Message);
    }

    //Unit Master
    public function UnitsLists()
	{
        return $this->db->query("SELECT unit_code, unit_name FROM pmd_unit WHERE cancel_flag = 0 ORDER BY unit_priority")->result();
    }
    public function CreateUnitMaster()
	{
        $unit_name = strtoupper($this->input->post('unit_name'));
        $unit_code = strtoupper($this->input->post('unit_code'));
        $condition="unit_name='".$unit_name."' OR unit_code='".$unit_code."'";
        if($this->IsDuplicate('pmd_unit',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Unit Already Exists!";
        }
        else
        {
            $this->db->trans_begin();
            $created_by  = $this->user->user_id;
            $currentDate = date('Y-m-d H:i:s');
            $query="INSERT INTO pmd_unit (`unit_priority`,`unit_code`,`unit_name`,`created_by`,`created_date`) SELECT IFNULL(MAX(`unit_priority`),0)+1,'".$unit_code."','".$unit_name."',".$created_by.",'".$currentDate."' FROM `pmd_unit`";
            $this->db->query($query);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('added_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
		return $this->Message;
	}
    public function UpdateUnitMaster($data)
	{
        $condition="unit_name='".$data['unit_name']."'";
        if($this->IsDuplicate('pmd_unit',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Unit Already Exists!";
        }
        else
        {
            $this->db->where('unit_code', $data['unit_code']);
            $this->db->update('pmd_unit', $data);
            if($this->db->affected_rows())
            {
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success');
            }else {
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
		return json_encode($this->Message);
	}
    public function DeleteUnitMaster($data)
	{
        $this->db-> where('unit_code', $data['unit_code']);
        $this->db->update('pmd_unit', $data);
        if($this->db->affected_rows())
        {
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('deleted_success');
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return  json_encode($this->Message);
	}
    public function UpdateUnitMasterPriority()
    {
        $updateArray=json_decode($this->input->post('pos_Record'),true);
        $this->db->update_batch('pmd_unit',$updateArray, 'unit_code');
        if($this->db->affected_rows())
        {
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return json_encode($this->Message);
    }
    //Rate Master
    public function GetRateCard()
	{
        $rate_card = array("sales"=>array(),"schemes"=>array());
        $rate_card["sales"] = $this->db->query("SELECT rate_code,rate_pdt_code,rate_flag,rate_amount FROM pmd_ratecard WHERE rate_pdt_code='DLY' AND rate_flag IS NOT NULL AND rate_copy_type IS NULL")->result();
        $rate_card["schemes"] = $this->db->query("SELECT rate_code,rate_pdt_code,rate_copy_group,group_name,rate_copy_type,copytype_name,rate_sch_years,rate_sch_months,rate_sch_days,rate_amount FROM pmd_ratecard RC 
                                                    INNER JOIN pmd_copygroup CG ON RC.rate_copy_group=CG.group_code
                                                    INNER JOIN pmd_copytype CT ON RC.rate_copy_type=CT.copytype_code WHERE rate_pdt_code='DLY' AND rate_flag IS NULL ORDER BY group_name,copytype_name")->result();
        return $rate_card;
    }
    public function GetSchemeCopyRate()
	{
        $sch_copy_rate = array();
        $rate_code = $this->input->post('rate_code', TRUE);
        if($rate_code){
            $sch_copy_rate=$this->db->query("SELECT rate_code,rate_pdt_code,rate_copy_group,group_name,rate_copy_type,copytype_name,rate_sch_years,rate_sch_months,rate_sch_days,rate_amount FROM pmd_ratecard RC 
                                                    INNER JOIN pmd_copygroup CG ON RC.rate_copy_group=CG.group_code
                                                    INNER JOIN pmd_copytype CT ON RC.rate_copy_type=CT.copytype_code WHERE rate_pdt_code='DLY' AND rate_flag IS NULL AND rate_code = '".$rate_code."' ORDER BY group_name,copytype_name")->row();
        }
        return $sch_copy_rate;
    }
    public function GetOtherProductsRate(){
        return $this->db->query("SELECT rate_code,rate_pdt_code,rate_flag,rate_amount FROM pmd_ratecard WHERE rate_pdt_code!='DLY' AND rate_flag IS NOT NULL AND rate_copy_type IS NULL")->result();
    }
    public function SaveSalesCopyRate(){
        $sales_rates = array();
        //Rate per copy
        $sales_rates[] = array("rate_code"=>"RAT0000001",
                               "rate_flag"=>"DLY",
                               "rate_amount"=>$this->input->post('copy_rate', TRUE),
                               "modified_by"=>$this->user->user_id,
                               "modified_date"=>date('Y-m-d H:i:s'));
        //Sunday Rate per copy
        $sales_rates[] = array("rate_code"=>"RAT0000002",
                               "rate_flag"=>"SUN",
                               "rate_amount"=>$this->input->post('sunday_copy_rate', TRUE),
                               "modified_by"=>$this->user->user_id,
                               "modified_date"=>date('Y-m-d H:i:s'));
        //EK Rate per copy
        $sales_rates[] = array("rate_code"=>"RAT0000003",
                               "rate_flag"=>"EK",
                               "rate_amount"=>$this->input->post('ek_copy_rate', TRUE),
                               "modified_by"=>$this->user->user_id,
                               "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $this->db->update_batch('pmd_ratecard', $sales_rates, 'rate_code');
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return $this->Message;
    }
    public function SaveSchemeCopyRate(){
        $copy_group_code = $this->input->post('copy_group_code',true);
        $copy_type_rec = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $copy_type_code = $copy_type_rec ? $copy_type_rec["Code"] : null;
        $years = $this->input->post('years', TRUE);
        $months = $this->input->post('months', TRUE);
        $days = $this->input->post('days', TRUE);
        $rate = $this->input->post('rate', TRUE);

        if(!$copy_group_code || !$copy_type_code){
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
            return $this->Message;
        }
        
        $condition="rate_copy_type='".$copy_type_code."'";
        if($this->IsDuplicate('pmd_ratecard',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Rates Already Exists!";
        }
        else
        {
            $this->db->trans_begin();
            $rate_code = $this->GetPrimaryId('RATE_CODE');
            $data = array("rate_code"=>$rate_code,
                          "rate_pdt_code"=>'DLY',
                          "rate_copy_group"=>$copy_group_code,
                          "rate_copy_type"=>$copy_type_code,
                          "rate_sch_years"=>$years,
                          "rate_sch_months"=>$months,
                          "rate_sch_days"=>$days,
                          "rate_amount"=>$rate,
                          "created_by"=>$this->user->user_id,
                          "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_ratecard',$data);
            $this->UpdatePrimaryId($rate_code, 'RATE_CODE');
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('added_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        return $this->Message;
    }
    public function UpdateSchemeCopyRate(){
        $rate_code = $this->input->post('rate_code',true);
        $years = $this->input->post('years', TRUE);
        $months = $this->input->post('months', TRUE);
        $days = $this->input->post('days', TRUE);
        $rate = $this->input->post('rate', TRUE);

        if(!$rate_code){
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
            return $this->Message;
        }
        $this->db->trans_begin();
        $data = array("rate_pdt_code"=>'DLY',
                      "rate_sch_years"=>$years,
                      "rate_sch_months"=>$months,
                      "rate_sch_days"=>$days,
                      "rate_amount"=>$rate,
                      "modified_by"=>$this->user->user_id,
                      "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->where('rate_code', $rate_code);
        $this->db->update('pmd_ratecard',$data);
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return $this->Message;
    }
    public function SaveOtherPrdtsRate(){
        $rate_master_code = null;
        $now = date('Y-m-d H:i:s');
        $other_prdts = array();
        $db_other_prdt_rates = $this->GetOtherProductsRate();
        $product_codes = array_column($db_other_prdt_rates, 'rate_pdt_code');
        foreach($db_other_prdt_rates as $db_prdt){
            $other_prdts[$db_prdt->rate_pdt_code] = $db_prdt;
        }
        $other_prdt_rates = json_decode($this->input->post('other_prdt_rates',true));
        $this->db->trans_begin();
        if($other_prdt_rates){
            foreach($other_prdt_rates as $rate){
                if(in_array($rate->prdt_code,$product_codes)){
                    $this->db->query("UPDATE pmd_ratecard SET rate_amount = '".$rate->amount."',modified_by = '".$this->user->user_id."',modified_date = '".$now."'   
                                WHERE rate_code='".$other_prdts[$rate->prdt_code]->rate_code."' AND rate_pdt_code='".$rate->prdt_code."' AND rate_flag IS NOT NULL AND rate_copy_type IS NULL");
                }else{
                    $rate_master_code= $this->GetPrimaryId('RATE_CODE');
                    $this->db->query("INSERT INTO `pmd_ratecard`
                                        (`rate_code`,
                                        `rate_pdt_code`,
                                        `rate_flag`,
                                        `rate_amount`,
                                        `created_by`,
                                        `created_date`)
                                        VALUES
                                        ('".$rate_master_code."',
                                        '".$rate->prdt_code."',
                                        '".$rate->prdt_code."',
                                        '".$rate->amount."',
                                        '".$this->user->user_id."',
                                        '".$now."')");
                    $this->UpdatePrimaryId($rate_master_code, 'RATE_CODE');
                }
            }
        }
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return $this->Message;
    }
}