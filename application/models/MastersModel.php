<?php
class MastersModel extends CI_Model 
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

    //Units
    public function UnitsLists()
	{
        return $this->db->query("SELECT 
                                    U.unit_code, U.unit_name
                                FROM
                                    pmd_unit U
                                        INNER JOIN
                                    pmd_unitaccess UA ON U.unit_code = UA.unit_code
                                        AND UA.user_id = '".$this->user->user_id."'
                                WHERE
                                    cancel_flag = 0
                                ORDER BY unit_priority")->result();
    }

    //Product Master
    public function CreateProductMaster()
    {
        $product_code=$this->input->post('product_code',true);
        $product_name=$this->input->post('product_name',true);
        $condition="product_name='".$product_name."' OR product_code='".$product_code."'"; 
        if($this->IsDuplicate('pmd_products',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Product already exists!";
        }
        else
        {
             $this->db->trans_begin(); 
             $query="INSERT INTO pmd_products (`product_priority`,`product_code`,`product_name`,`created_by`,`created_date`)
                SELECT IFNULL(MAX(`product_priority`),0)+1,
                        '".strtoupper($product_code)."',
                        '".strtoupper($product_name)."',
                        ".$this->user->user_id.",
                        '".date('Y-m-d H:i:s')."' FROM `pmd_products`";
            $this->db->query($query);
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
    public function UpdateProductMaster($data)
    {
       
            $this->db->where('product_code', $data['product_code']);
            $this->db->update('pmd_products', $data);
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
    public function DeleteProductMaster($data)
    {
        $this->db->where('product_code', $data['product_code']);
        $this->db->update('pmd_products', $data);
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
    public function ProductLists()
    {
        $query = "SELECT
                         `product_code`,
                         `product_name`,
                         `cancel_flag`
                    FROM
                    `pmd_products` WHERE cancel_flag = 0 ORDER BY product_priority";  
        return $this->db->query($query)->result();
    }
    public function UpdateProductMasterPriority()
    {
        $updateArray=json_decode($this->input->post('pos_Record'),true);
        $this->db->update_batch('pmd_products',$updateArray, 'product_code');
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

    //Product group Master
    public function CreateProductGroups()
    {
        $group_name=strtoupper($this->input->post('group_name',true));
        $product_codes = $this->input->post('group_pdt',true);
        $group_pdts = array();
        $condition=" group_name = '".$group_name."' ";
        if($this->IsDuplicate('pmd_productgroup',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Group Name Already Exists!";
        }else if(!$product_codes || !$group_name)
        {
            $this->Message->status=400;
            $this->Message->text="All fields are mandatory!";
        }
        else
        {
            $this->db->trans_begin();
            $group_code=$this->GetPrimaryId('GRP_CODE');
            foreach($product_codes as $pdt){
                $group_pdts[] = array("product_code"=>$pdt,"group_code"=>$group_code);
            }
            $query="INSERT INTO pmd_productgroup (`group_priority`,`group_code`,`group_name`,`created_by`,`created_date`) SELECT IFNULL(MAX(`group_priority`),0)+1,'".$group_code."','".$group_name."','".$this->user->user_id."','".date('Y-m-d H:i:s')."' FROM `pmd_productgroup`";
            $this->db->query($query);
            $this->db->insert_batch("pmd_group_pdt",$group_pdts);
            $this->UpdatePrimaryId($group_code, 'GRP_CODE');
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
    public function UpdateProductGroups($data,$product_codes)
    {
        if($data['group_name'] && $data['group_code']) {
            $condition=" group_name = '".$data['group_name']."' AND group_code != '".$data['group_code']."'";
            if($this->IsDuplicate('pmd_productgroup',$condition))
            {
                $this->Message->status=400;
                $this->Message->text="Group Name Already Exists!";
            }
            else
            {
                $this->db->trans_begin();
                $this->db->where('group_code', $data['group_code']);
                $this->db->update('pmd_productgroup', $data);
                $this->db->where('group_code', $data['group_code']);
                $this->db->delete('pmd_group_pdt');
                $group_pdts = array();
                foreach($product_codes as $pdt){
                    $group_pdts[] = array("product_code"=>$pdt,"group_code"=>$data['group_code']);
                }
                if($group_pdts) $this->db->insert_batch("pmd_group_pdt",$group_pdts);
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
        return json_encode($this->Message);
    }
    public function DeleteProductGroup($data)
    {
        $this->db->where('group_code', $data['group_code']);
        $this->db->update('pmd_productgroup', $data);
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
    public function GetProductGroups()
    {
        $query = "SELECT  group_code, group_name, group_priority, cancel_flag, (SELECT 
                            GROUP_CONCAT(product_code)
                        FROM
                            pmd_group_pdt GP
                        WHERE
                            GP.group_code = PG.group_code GROUP BY GP.group_code) group_prdts
                FROM
                    pmd_productgroup PG
                WHERE
                    cancel_flag = 0
                ORDER BY group_priority";
        return $this->db->query($query)->result();
    }
    public function UpdateProductGroupPriority()
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
    public function UserUnits() {
        return $this->db->query("SELECT unit_code FROM pmd_unitaccess where user_id = ".$this->input->post('user_id',true))->result();
    }
    public function UserProducts() {
        return $this->db->query("SELECT product_code FROM pmd_productaccess where user_id = ".$this->input->post('user_id',true))->result();
    }
    
    //Issue Master
    public function CreateIssue()
    {
        $issue_name         = $this->input->post('issue_name',true);
        $issue_product_code = $this->input->post('issue_product_code',true);
        $issue_date         = date('Y-m-d',strtotime($this->input->post('issue_date',true)));
        $issue_img_flag     = isset($_FILES['issue_img']['tmp_name']) ? 1 : 0;

        if($issue_name && $issue_product_code && $issue_date) {
            $this->db->trans_begin();
            $issue_code = $this->GetPrimaryId('ISSUE_CODE');

            $data = array("issue_code"=>$issue_code,
                          "issue_name"=>$issue_name,
                          "issue_product_code"=>$issue_product_code,
                          "issue_date"=>$issue_date,
                          "issue_img_flag"=>$issue_img_flag,
                          "cancel_flag"=>0,
                          "created_by"=>$this->user->user_id,
                          "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_product_issue',$data);
            $this->UpdatePrimaryId($issue_code, 'ISSUE_CODE');
            if($this->db->trans_status() === TRUE)
            {
                //upload-image
                $path = 'uploads/issue/'.$issue_product_code;                
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                    chmod('uploads' , 0777);
                    chmod('uploads/issue' , 0777);
                    chmod($path , 0777);
                }
                $file_status = move_uploaded_file($_FILES["issue_img"]["tmp_name"], $path."/".$issue_code.".jpg");
                $file_msg    = $file_status ? "" : " [Error Uploading Image!]";

                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('added_success').$file_msg;
                $this->Message->product=$issue_product_code;
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');                
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
		return $this->Message;
    }
    public function IssueLists($product, $limit = null, $issue_code = null) {
        $lmt = $where = "";
        if($limit) $lmt = " LIMIT ".$limit;
        if($issue_code) $where .= " AND I.issue_code = '".$issue_code."'";
        $qry = "SELECT
                    I.issue_code,
                    I.issue_name,
                    I.issue_product_code,
                    I.issue_date,
                    I.issue_img_flag,
                    P.product_name
                FROM
                    pmd_product_issue I
                        JOIN
                    pmd_products P ON P.product_code = I.issue_product_code
                WHERE
                    I.issue_product_code = '".$product."'
                    AND I.cancel_flag = 0 ".$where.$lmt;
        if($limit === 1) {
            return $this->db->query($qry)->row();
        } else {
            return $this->db->query($qry)->result();
        }
    }
    public function DeleteIssue() {
        $issue_code = $this->input->post('issue_code',true);
        $issue_product_code = $this->input->post('issue_product_code',true);
        if($issue_code && $issue_product_code) {
            $data = array("cancel_flag"=>1,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('issue_code',$issue_code);
            $this->db->where('issue_product_code',$issue_product_code);
            $this->db->update('pmd_product_issue',$data);

            if($this->db->trans_status() === TRUE) {
                unlink('uploads/issue/'.$issue_product_code.'/'.$issue_code.'.jpg');
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('deleted_success');
            }
            else {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function UpdateIssue() {
        $issue_code         = $this->input->post('issue_code',true);
        $issue_name         = $this->input->post('issue_name',true);
        $issue_product_code = $this->input->post('issue_product_code',true);
        $issue_date         = date('Y-m-d',strtotime($this->input->post('issue_date',true)));
        $issue_img_temp     = $_FILES["issue_image"]["tmp_name"];
        $issue_img_flag     = ($issue_img_temp || $this->input->post('issue_img_flag',true)) ? 1 : 0;
        
        if($issue_name && $issue_product_code && $issue_date && $issue_code) {
            $this->db->trans_begin();
            $data = array("issue_name"=>$issue_name,
                          "issue_product_code"=>$issue_product_code,
                          "issue_date"=>$issue_date,
                          "issue_img_flag"=>$issue_img_flag,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('issue_code',$issue_code);
            $this->db->update('pmd_product_issue',$data);
            if($this->db->trans_status() === TRUE)
            {
                //if-new-file
                $file_msg = "";
                if($issue_img_temp) {
                    $path = 'uploads/issue/'.$issue_product_code;
                    unlink($path."/".$issue_code.'.jpg');
                    $file_status = move_uploaded_file($issue_img_temp, $path."/".$issue_code.".jpg");
                    $file_msg    = $file_status ? "" : " [Error Uploading Image!]";
                }
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success').$file_msg;
                $this->Message->product=$issue_product_code;
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
		return $this->Message;

    }

    //Bureau Master
    public function CreateBureauMaster()
	{
        $bureau_name = strtoupper($this->input->post('bureau_name', TRUE));
        $bureau_contact = strtoupper($this->input->post('bureau_contact', TRUE));
        $bureau_mobile = strtoupper($this->input->post('bureau_mobile', TRUE));
        $condition="bureau_name='".$bureau_name."'";
        if($this->IsDuplicate('pmd_bureau',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Bureau Already Exists!";
        }
        else
        {
            $created_by  = $this->user->user_id;
            $currentDate = date('Y-m-d H:i:s');
            $this->db->trans_begin();
            $bureau_code = $this->GetPrimaryId('BUR_'.$this->user->user_unit_code.'_CODE');
            $query="INSERT INTO pmd_bureau (`bureau_priority`,`bureau_code`,`bureau_unit`,`bureau_name`,`bureau_contact_person`,`bureau_mobile`,`created_by`,`created_date`) SELECT IFNULL(MAX(`bureau_priority`),0)+1,'".$bureau_code."','".$this->user->user_unit_code."','".$bureau_name."','".$bureau_contact."','".$bureau_mobile."',".$created_by.",'".$currentDate."' FROM `pmd_bureau`";
            $this->db->query($query);
            $this->UpdatePrimaryId($bureau_code, 'BUR_'.$this->user->user_unit_code.'_CODE');
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
    public function UpdateBureauMaster($data)
	{
        $condition="bureau_name='".$data['bureau_name']."' AND bureau_code!='".$data['bureau_code']."'";
        if($this->IsDuplicate('pmd_bureau',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Bureau Already Exists!";
        }
        else
        {
            $this->db->where('bureau_code', $data['bureau_code']); 
            $this->db->update('pmd_bureau', $data);
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
    public function DeleteBureauMaster($data) 
	{
        $this->db-> where('bureau_code', $data['bureau_code']);
        $this->db->update('pmd_bureau', $data);
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
    public function UpdateBureauPriority()
    {
        $updateArray=json_decode($this->input->post('pos_Record'),true);
        $this->db->update_batch('pmd_bureau',$updateArray, 'bureau_code');
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
    public function BureauLists()
	{
        return $this->db->query("SELECT bureau_code,bureau_name,bureau_unit,bureau_contact_person,bureau_mobile FROM pmd_bureau WHERE cancel_flag = 0 AND bureau_unit = '".$this->user->user_unit_code."' ORDER BY bureau_priority")->result();
    }
    
    //Promoter Master
    public function PromoterACMLists() {
        $qry = "SELECT acm_code,acm_name FROM pmd_acm WHERE cancel_flag = 0 AND acm_unit = '".$this->user->user_unit_code."' ORDER BY acm_name DESC";
        return $this->db->query($qry)->result();
    }
    public function PromoterLists() {
        $qry = "SELECT
                    P.promoter_code,
                    P.promoter_name,
                    P.promoter_area,
                    P.promoter_phone,
                    A.acm_name
                FROM
                    pmd_promoter P
                        JOIN
                    pmd_acm A ON A.acm_code = P.promoter_acm_code
                WHERE
                    P.cancel_flag = 0 AND
                    P.promoter_unit = '".$this->user->user_unit_code."'
                ORDER BY P.created_date DESC";
        return $this->db->query($qry)->result();
    }
    public function ViewPromoter() {
        $qry = "SELECT
                    P.promoter_code,
                    P.promoter_name,
                    P.promoter_area,
                    P.promoter_phone,
                    P.promoter_acm_code,
                    A.acm_name
                FROM
                    pmd_promoter P
                        JOIN
                    pmd_acm A ON A.acm_code = P.promoter_acm_code
                WHERE
                    P.promoter_code = '".$this->input->post('promoter_code',true)."' AND
                    P.cancel_flag = 0 AND
                    P.promoter_unit = '".$this->user->user_unit_code."'
                LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function CreatePromoter() {
        $promoter_name  = $this->input->post('promoter_name',true);
        $promoter_area  = $this->input->post('promoter_area',true);
        $promoter_phone = $this->input->post('promoter_phone',true);
        $promoter_acm   = json_decode(rawurldecode($this->input->post('promoter_acm_code_rec_sel',true)),true);
        $acm_code       = count($promoter_acm) ? $promoter_acm['Code'] : null;

        if($promoter_name && $promoter_area && $promoter_phone && $acm_code) {
            $this->db->trans_begin();
            $no_id = 'PR_'.$this->user->user_unit_code.'_CODE';
            $promoter_code = $this->GetPrimaryId($no_id);
            $data = array("promoter_code"=>$promoter_code,
                          "promoter_name"=>$promoter_name,
                          "promoter_unit"=>$this->user->user_unit_code,
                          "promoter_area"=>$promoter_area,
                          "promoter_phone"=>$promoter_phone,
                          "promoter_acm_code"=>$acm_code,
                          "cancel_flag"=>0,
                          "created_by"=>$this->user->user_id,
                          "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_promoter',$data);
            $this->UpdatePrimaryId($promoter_code, $no_id);
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
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
		return $this->Message;
    }
    public function UpdatePromoter() {
        $promoter_code  = $this->input->post('promoter_code',true);
        $promoter_name  = $this->input->post('promoter_name',true);
        $promoter_area  = $this->input->post('promoter_area',true);
        $promoter_phone = $this->input->post('promoter_phone',true);
        $promoter_acm   = $this->input->post('p_promoter_acm_code',true);

        if($promoter_code && $promoter_name && $promoter_area && $promoter_phone && $promoter_acm) {
            $this->db->trans_begin();
            $data = array("promoter_name"=>$promoter_name,
                          "promoter_area"=>$promoter_area,
                          "promoter_phone"=>$promoter_phone,
                          "promoter_acm_code"=>$promoter_acm,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('promoter_code',$promoter_code);
            $this->db->update('pmd_promoter',$data);
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
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
		return $this->Message;
    }
    public function DeletePromoter() {
        $promoter_code = $this->input->post('promoter_code',true);
        if($promoter_code) {
            $data = array("cancel_flag"=>1,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('promoter_code',$promoter_code);
            $this->db->update('pmd_promoter',$data);
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
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    
    //ACM
    public function ACMLists() {
        $qry = "SELECT acm_unit,acm_code,acm_name,acm_phone,region_name,AC.cancel_flag FROM pmd_acm AC INNER JOIN pmd_region RG ON AC.acm_region=RG.region_code WHERE acm_unit = '".$this->user->user_unit_code."'";
        return $this->db->query($qry)->result();
    }
    public function CreateACM() {
        $acm_name   = $this->input->post('acm_name',true);
        $acm_phone  = $this->input->post('acm_phone',true);
        $acm_region   = json_decode(rawurldecode($this->input->post('region_rec_sel',true)), true);
        $acm_status = $this->input->post('acm_status',true);
        if($acm_name && $acm_phone && $acm_region) {
            $this->db->trans_begin();
            $condition = " acm_name = '".$acm_name."'";
            if($this->IsDuplicate('pmd_acm',$condition)) {
                $this->Message->status=400;
                $this->Message->text="ACM name already taken!";
            }else{
            $acm_code = $this->GetPrimaryId('ACM_'.$this->user->user_unit_code.'_CODE');
            $data = array("acm_code"=>$acm_code,
                          "acm_name"=>strtoupper($acm_name),
                          "acm_unit"=>$this->user->user_unit_code,
                          "acm_phone"=>$acm_phone,
                          "cancel_flag"=>$acm_status,
                          "acm_region"=>$acm_region["Code"],
                          "created_by"=>$this->user->user_id,
                          "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_acm',$data);
            $this->UpdatePrimaryId($acm_code, 'ACM_'.$this->user->user_unit_code.'_CODE');
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
    public function DeleteACM() {
        $acm_code = $this->input->post('acm_code',true);
        if($acm_code) {
            $condition = "promoter_acm_code = '".$acm_code."'";
            if($this->IsDuplicate('pmd_promoter',$condition)) {
                $this->Message->status=400;
                $this->Message->text="This ACM is already linked against a Promoter!";
            }
            else {
                $data = array("cancel_flag"=>1,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('acm_code',$acm_code);
                $this->db->update('pmd_acm',$data);
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
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function ViewACM() {
        $qry = "SELECT acm_unit,acm_code,acm_name,acm_phone,acm_region,region_name,AC.cancel_flag FROM pmd_acm AC INNER JOIN pmd_region RG ON AC.acm_region=RG.region_code WHERE acm_code = '". $this->input->post('acm_code') ."' LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function UpdateACM()
    {
        $acm_code   = $this->input->post('acm_code',true);
        $acm_name   = $this->input->post('acm_name',true);
        $acm_phone  = $this->input->post('acm_phone',true);
        $acm_region   = json_decode(rawurldecode($this->input->post('acm_region',true)), true);
        $acm_status = $this->input->post('acm_status',true);
        if($acm_code && $acm_name && $acm_phone && $acm_region) {
            $condition = "acm_code != '".$acm_code."' AND acm_name = '".$acm_name."'";
            if($this->IsDuplicate('pmd_acm',$condition)) {
                $this->Message->status=400;
                $this->Message->text="ACM name already taken!";
            }
            else {
                //"user_login_name"=>$user_name,
                $this->db->trans_begin();
                $data = array("acm_name"=>strtoupper($acm_name),
                              "acm_phone"=>$acm_phone,
                              "acm_region"=>$acm_region["Code"],
                              "cancel_flag"=>$acm_status,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('acm_code', $acm_code);
                $this->db->update('pmd_acm', $data);
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

    //Residence Association
    public function CreateResidenceAssociation(){
        $res_name  = strtoupper($this->input->post('res_name',true));
        $res_location  = strtoupper($this->input->post('res_location',true));
        $res_cont  = strtoupper($this->input->post('res_cont',true));
        $res_phn  = $this->input->post('res_phn',true);
        $res_remark  = strtoupper($this->input->post('res_remark',true));
        $res_status  = $this->input->post('res_status',true);
        if($res_name && $res_location && $res_cont && $res_phn){
            $condition = " res_name = '".$res_name."'";
            if($this->IsDuplicate('pmd_res_association',$condition)) {
                $this->Message->status=400;
                $this->Message->text=" name already taken!";
            }
            else{
            $this->db->trans_begin();
            $res_code = "RES_".$this->user->user_unit_code;
            $residence_code = $this->GetPrimaryId($res_code);
            $data = array(  "res_code"=>$residence_code,
                            "res_unit"=>$this->user->user_unit_code,
                            "res_name"=>$res_name,
                            "res_location"=>$res_location,
                            "res_contact_person"=>$res_cont,
                            "res_phone"=>$res_phn,
                            "res_remarks"=>$res_remark,
                            "cancel_flag"=>$res_status,
                            "created_by"=>$this->user->user_id,
                            "created_date"=>date('Y-m-d'));
            $this->db->insert('pmd_res_association',$data);
            $this->UpdatePrimaryId($residence_code, $res_code);
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
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function ResidenceAssociationList(){
        $res_unit = $this->user->user_unit_code;
        $qury = "SELECT
                        res_code,
                        res_name,
                        res_location,
                        res_contact_person,
                        res_phone,
                        cancel_flag
                FROM
                        pmd_res_association
                WHERE
                        res_unit='".$res_unit."'";
        return $this->db->query($qury)->result();
    }
    public function ViewResidenceAssociationList(){
        $res_code = $this->input->post('res_code');
        $qury= "SELECT
                        res_code,
                        res_name,
                        res_location,
                        res_contact_person,
                        res_phone,
                        cancel_flag,
                        res_remarks
                FROM
                        pmd_res_association
                WHERE res_code = '".$res_code."' LIMIT 1";
        return $this->db->query($qury)->row();
    }
    public function UpdateResidenceAssociation(){
        $rescode = $this->input->post('res_code');
        $resname = strtoupper($this->input->post('residence_name'));
        $resphn = $this->input->post('res_phone');
        $reslocation = strtoupper($this->input->post('residence_location'));
        $resremarks = strtoupper($this->input->post('residence_remarks'));
        $resperson = strtoupper($this->input->post('residence_cont_person'));
        $resstatus = $this->input->post('residence_status');
        if($rescode && $resname && $resphn && $reslocation){
            $condition = " res_name = '".$resname."' AND res_code!= '".$rescode."'";
            if($this->IsDuplicate('pmd_res_association',$condition)) {
                $this->Message->status=400;
                $this->Message->text=" name already taken!";
            }
            else{
                $this->db->trans_begin();
                $data = array("res_code"=>$rescode,
                                "res_name"=>$resname,
                                "res_location"=>$reslocation,
                                "res_remarks"=>$resremarks,
                                "res_contact_person"=>$resperson,
                                "cancel_flag"=>$resstatus,
                                
                                "res_phone"=>$resphn,
                                "modified_by"=>$this->user->user_id,
                                "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('res_code', $rescode);
                $this->db->update('pmd_res_association', $data);
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
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function DeleteResidenceAssociation(){
    $residence_code = $this->input->post('residence_code',true);
    $this->db->trans_begin();
                $data = array("cancel_flag"=>1,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('res_code',$residence_code);
                $this->db->update('pmd_res_association',$data);
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

    //Copy Type Master
    public function GetCopyCode(){
        $sql = "SELECT  copy_code,
                        copy_name
                 FROM
                        pmd_copymaster";

        return $this->db->query($sql)->result();
    }
    public function CreateCopyTypeMaster(){
        $ct_name = strtoupper($this->input->post('ct_name'));
        $copy_code = $this->input->post('copy_code');
        $ct_group   = json_decode(rawurldecode($this->input->post('ct_group_rec_sel',true)),true);
        $ct_year = $this->input->post('ct_year');
        $ct_group_code       = count($ct_group) ? $ct_group['Code'] : null;
        if($ct_name && $copy_code && $ct_group_code){
            $condition = "copytype_name = '".$ct_name."'";
            if($this->IsDuplicate('pmd_copytype',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Name Already Exists!";
            }else{
                $this->db->trans_begin();
                $copy_type_code = $this->GetPrimaryId('CPT_CODE');
                $data = array("copytype_code"=>$copy_type_code,
                                "copytype_name"=>$ct_name,
                                "copy_code"=>$copy_code,
                                "group_code"=>$ct_group_code,
                                "copytype_year"=>$ct_year,
                                "created_by"=>$this->user->user_id,
                                "created_date"=>date('Y-m-d'));
                $this->db->insert('pmd_copytype',$data);
                $this->UpdatePrimaryId($copy_type_code, 'CPT_CODE');
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
         }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
              }
		return $this->Message;
    }
    public function CopyTypeMasterList(){
        $qury = "SELECT
                        t1.copytype_code,
                        t1.copytype_name,
                        t1.group_code,
                        t1.cancel_flag,
                        t1.copy_code,
                        t1.copytype_year,
                        t2.copy_name,
                        t3.group_name
                FROM
                        pmd_copytype t1
                 JOIN
                        pmd_copymaster t2 ON t1.copy_code = t2.copy_code
                JOIN
                         pmd_copygroup t3 ON t3.group_code = t1.group_code ";
        return $this->db->query($qury)->result();
    }
    public function ViewCopyTypeMaster(){
        $copy_type_code = $this->input->post('ct_code');
        $qury= "SELECT
                        t1.copytype_code,
                        t1.copytype_name,
                        t1.group_code,
                        t1.cancel_flag,
                        t1.copy_code,
                        t1.copytype_year,
                        t2.copy_name,
                        t3.group_name
                FROM
                        pmd_copytype t1
                 JOIN
                        pmd_copymaster t2 ON t1.copy_code = t2.copy_code
                JOIN
                         pmd_copygroup t3 ON t3.group_code = t1.group_code
                WHERE copytype_code = '".$copy_type_code."' LIMIT 1";
        return $this->db->query($qury)->row();
    }
    public function UpdateCopyTypeMaster(){
        $ctCode  = $this->input->post('ctCode',true);
        $cType_name  = strtoupper($this->input->post('ctName',true));
        $cType_Code = $this->input->post('ctypeCode',true);
        $cType_Group = json_decode(rawurldecode($this->input->post('ctypeGroup',true)),true);
        $cType_status = $this->input->post('ctypeStatus',true);
        $cType_show_year=$this->input->post("ctypeShowYear");
        $type_year = $this->input->post('ctypeYear'); 
        if($ctCode && $cType_name ) {
            $condition = "copytype_code != '".$ctCode."' AND copytype_name = '".$cType_name."'";
            if($this->IsDuplicate('pmd_copytype',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Name already taken!";
            }else{
                $this->db->trans_begin();
                $data = array("copytype_code"=>$ctCode,
                              "copytype_name"=>$cType_name,
                              "copy_code"=>$cType_Code,
                              "group_code"=>$cType_Group["Code"],
                              "copytype_year"=>$type_year,
                              "copytype_year"=>$cType_show_year,
                              "cancel_flag"=>$cType_status,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('copytype_code', $ctCode);
                $this->db->update('pmd_copytype', $data);
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
        else{
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Union Master
    public function CreateUnionMaster(){
        $union_name = strtoupper($this->input->post('union_name'));
        $union_address_1 = strtoupper($this->input->post('union_address_1'));
        $union_address_2 = strtoupper($this->input->post('union_address_2'));
        $union_town = strtoupper($this->input->post('union_town'));
        $union_pin = $this->input->post('union_pin');
        //$union_dist = $this->input->post('union_dist');
        $union_president = strtoupper($this->input->post('union_president'));
        $union_pres_mob = $this->input->post('union_pres_mob');
        $union_secretary = strtoupper($this->input->post('union_secretary'));
        $union_sec_mob = $this->input->post('union_sec_mob');
        if($union_name){
            $condition = "union_name = '".$union_name."'";
            if($this->IsDuplicate('pmd_union',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Name Already Exists!";
            }
            else{
                $this->db->trans_begin();
                $union_code = $this->GetPrimaryId("UN_".$this->user->user_unit_code."_CODE");
                $data = array("union_code"=>$union_code,
                    "union_name"=>$union_name,
                    "union_address1"=>$union_address_1,
                    "union_address2"=>$union_address_2,
                    "union_town"=>$union_town,
                    "union_pincode"=>$union_pin,
                    "union_president"=>$union_president,
                    "union_president_phone"=>$union_pres_mob,
                    "union_secretary"=>$union_secretary,
                    "union_secretary_phone"=>$union_sec_mob,
                    "union_unit"=>$this->user->user_unit_code,
                    "created_by"=>$this->user->user_id,
                    "created_date"=>date('Y-m-d'));
                $this->db->insert('pmd_union',$data);
                $this->UpdatePrimaryId($union_code, "UN_".$this->user->user_unit_code."_CODE");
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
        }else{
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
            }
        return $this->Message;
    }
    public function UnionMasterList(){
        $qry = "SELECT
                        union_code,
                        union_name,
                        union_address1,
                        union_address2,
                        union_town,
                        union_president,
                        union_president_phone,
                        union_secretary,
                        union_secretary_phone,
                        cancel_flag
                FROM
                        pmd_union
                WHERE
                       union_unit='".$this->user->user_unit_code."'";
        return $this->db->query($qry)->result();
    }
    public function ViewUnionMaster(){
        $um_code = $this->input->post('um_code');
        $qry = "SELECT
                        union_code,
                        union_name,
                        union_pincode,
                        union_address1,
                        union_address2,
                        union_town,
                        union_president,
                        union_president_phone,
                        union_secretary,
                        union_secretary_phone,
                        cancel_flag
                FROM
                        pmd_union
                WHERE
                        union_code = '".$um_code."'";
        return $this->db->query($qry)->row();
    }
    public function updateUnionMaster(){
       $unCode = $this->input->post('unCode');
       $unName = strtoupper($this->input->post('unName'));
       $unAddress1 = strtoupper($this->input->post('unAddress1'));
       $unAddress2 = strtoupper($this->input->post('unAddress2'));
       $unTown = strtoupper($this->input->post('unTown'));
       $unPincode = $this->input->post('unPincode');
       $unPresident = strtoupper($this->input->post('unPresident'));
       $unPresMobile = $this->input->post('unPresMobile');
       $unSecretary = strtoupper($this->input->post('unSecretary'));
       $unSecMobile = $this->input->post('unSecMobile');
       $unStatus = $this->input->post('unStatus');
       if($unName && $unCode){
           $condition = "union_name ='".$unName."' AND union_code !='".$unCode."'";
           if($this->IsDuplicate('pmd_union',$condition)) {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else{
               $this->db->trans_begin();
               $data = array("union_code"=>$unCode,
                 "union_name"=>$unName,
                 "union_address1"=>$unAddress1,
                 "union_address2"=>$unAddress2,
                 "union_town"=>$unTown,
                 "union_pincode"=>$unPincode,
                 "union_president"=>$unPresident,
                 "union_president_phone"=>$unPresMobile,
                 "union_secretary"=>$unSecretary,
                 "union_secretary_phone"=>$unSecMobile,
                 "cancel_flag"=>$unStatus,
                 "modified_by"=>$this->user->user_id,
                 "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('union_code', $unCode);
               $this->db->update('pmd_union', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }

   //Shakha Master
   public function CreateShakhaMaster(){
       //$shakha_code = $this->input->post('shakha_code');
       $shakha_no = strtoupper($this->input->post('shakha_no'));
       $shakha_name = strtoupper($this->input->post('shakha_name'));
       $shakha_address1 = strtoupper($this->input->post('shakha_address1'));
       $shakha_address2 = strtoupper($this->input->post('shakha_address2'));
       $sakha_town = strtoupper($this->input->post('sakha_town'));
       $shakha_pin = $this->input->post('shakha_pin');
       $shakha_union = json_decode(rawurldecode($this->input->post('shakha_union_rec_sel',true)),true);
       $shakha_president = strtoupper($this->input->post('shakha_president'));
       $shakha_pres_mobile = $this->input->post('shakha_pres_mobile');
       $shakha_secretary = strtoupper($this->input->post('shakha_secretary'));
       $shakha_sec_mobile = $this->input->post('shakha_sec_mobile');
       $shakha_status = $this->input->post('shakha_status');
       if($shakha_name && $shakha_no && $shakha_union["Code"] && $shakha_address1 && $shakha_address2 && $sakha_town && $shakha_pin ){
           $condition= "shakha_name='".$shakha_name."' OR shakha_no='".$shakha_no."'";
           if($this->IsDuplicate('pmd_shakha',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $shakha_code = $this->GetPrimaryId("SHAKHA_".$this->user->user_unit_code."_CODE");

               $data = array("shakha_code"=>$shakha_code,
                               "shakha_name"=>$shakha_name,
                               "shakha_no"=>$shakha_no,
                               "shakha_address1"=>$shakha_address1,
                               "shakha_address2"=>$shakha_address2,
                               "shakha_town"=>$sakha_town,
                               "shakha_pincode"=>$shakha_pin,
                               "shakha_union_code"=>$shakha_union["Code"],
                               "shakha_president"=>$shakha_president,
                               "shakha_unit"=>$this->user->user_unit_code,
                               "shakha_president_phone"=>$shakha_pres_mobile,
                               "shakha_secretary"=>$shakha_secretary,
                               "shakha_secretary_phone"=>$shakha_sec_mobile,
                               "cancel_flag"=>$shakha_status,
                               "created_by"=>$this->user->user_id,
                               "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_shakha',$data);
               $this->UpdatePrimaryId($shakha_code, "SHAKHA_".$this->user->user_unit_code."_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function ShakhaMasterList(){
       $sql = "SELECT
                        t1.shakha_no,
                        t1.shakha_code,
                        t1.shakha_name,
                        t1.shakha_address1,
                        t1.shakha_address2,
                        t1.shakha_town,
                        t1.shakha_pincode,
                        t1.shakha_union_code,
                        t1.shakha_president,
                        t1.shakha_president_phone,
                        t1.shakha_secretary,
                        t1.shakha_secretary_phone,
                        t1.shakha_unit,
                        t1.cancel_flag,
                        t2.union_code,
                        t2.union_name
              FROM
                        pmd_shakha t1
             JOIN
                        pmd_union t2 ON t1.shakha_union_code= t2.union_code
            WHERE
                        t1.shakha_unit='".$this->user->user_unit_code."'";
       return $this->db->query($sql)->result();
   }
   public function ViewShakhaMaster(){
       $s_code = $this->input->post('s_code');
       $sql = "SELECT
                        t1.shakha_no,
                        t1.shakha_code,
                        t1.shakha_name,
                        t1.shakha_address1,
                        t1.shakha_address2,
                        t1.shakha_town,
                        t1.shakha_pincode,
                        t1.shakha_union_code,
                        t1.shakha_president,
                        t1.shakha_president_phone,
                        t1.shakha_secretary,
                        t1.shakha_secretary_phone,
                        t1.cancel_flag,
                        t2.union_code,
                        t2.union_name,
                        t2.union_unit
              FROM
                        pmd_shakha t1
             JOIN
                        pmd_union t2 ON t1.shakha_union_code= t2.union_code
              WHERE
                        t1.shakha_code = '".$s_code."'";
                       
       return $this->db->query($sql)->row();
   }
   public function UpdateShakhaMaster(){
       $shCode = $this->input->post('shCode');
       $shNumber = strtoupper($this->input->post('shNumber'));
       $shName = strtoupper($this->input->post('shName'));
       $shAddress1 = strtoupper($this->input->post('shAddress1'));
       $shAddress2 = strtoupper($this->input->post('shAddress2'));
       $shTown = strtoupper($this->input->post('shTown'));
       $shPincode = $this->input->post('shPincode');
       $shUnion = json_decode(rawurldecode($this->input->post('shUnion',true)),true);
       $shPresident = strtoupper($this->input->post('shPresident'));
       $shPresMobile = $this->input->post('shPresMobile');
       $shSecretary = strtoupper($this->input->post('shSecretary'));
       $shSecMobile = $this->input->post('shSecMobile');
       $shStatus = $this->input->post('shStatus');
       if($shName && $shCode && $shUnion["Code"] && $shAddress1 && $shAddress2 && $shTown && $shPincode){
           $condition= "shakha_name='".$shName."' AND shakha_code !='".$shCode."'";
           if($this->IsDuplicate('pmd_shakha',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Already Exists!";
           }
           else
           {
               $data = array("shakha_code"=>$shCode,
                               "shakha_name"=>$shName,
                               "shakha_no"=>$shNumber,
                               "shakha_address1"=>$shAddress1,
                               "shakha_address2"=>$shAddress2,
                               "shakha_town"=>$shTown,
                               "shakha_pincode"=>$shPincode,
                               "shakha_union_code"=>$shUnion["Code"],
                               "shakha_president"=>$shPresident,
                               "shakha_president_phone"=>$shPresMobile,
                               "shakha_secretary"=>$shSecretary,
                               "shakha_secretary_phone"=>$shSecMobile,
                               "cancel_flag"=>$shStatus,
                               "modified_by"=>$this->user->user_id,
                               "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('shakha_code', $shCode);
               $this->db->update('pmd_shakha', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }

   //Edition Master
   public function CreateEditionMaster(){
       $edition_name = strtoupper($this->input->post('edition_name'));
       //$edition_code = strtoupper($this->input->post('unit_code'));
       $condition="edition_name='".$edition_name."'";
       if($this->IsDuplicate('pmd_edition',$condition))
       {
           $this->Message->status=400;
           $this->Message->text="Name Already Exists!";
       }
       else
       {

           $this->db->trans_begin();
           $edit_code = $this->GetPrimaryId("EDT_".$this->user->user_unit_code."_CODE");
           $created_by  = $this->user->user_id;
           $currentDate = date('Y-m-d H:i:s');
           $query="INSERT INTO pmd_edition (`edition_priority`,`edition_code`,`edition_name`,`created_by`,`created_date`,`cancel_flag`,`edition_unit`) SELECT IFNULL(MAX(`edition_priority`),0)+1,'".$edit_code."','".$edition_name."',".$created_by.",'".$currentDate."','0','".$this->user->user_unit_code."' FROM `pmd_edition`";
           $this->UpdatePrimaryId($edit_code, "EDT_".$this->user->user_unit_code."_CODE");
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
   public function EditionMasterLists(){
       $qury = "SELECT
                        edition_code,
                        edition_name,
                        edition_priority,
                        cancel_flag
                FROM
                        pmd_edition 
                WHERE
                        edition_unit='".$this->user->user_unit_code."' ORDER BY edition_priority";
       return $this->db->query($qury)->result();
   }
   public function ViewEditionMaster(){
       $ed_code = $this->input->post('ed_code');
       $qury = "SELECT
                        edition_code,
                        edition_name,
                        edition_priority,
                        cancel_flag
                FROM
                        pmd_edition
                WHERE
                        edition_code = '".$ed_code."' ORDER BY edition_priority";
       return $this->db->query($qury)->row();
   }
   public function UpdateEditionMaster(){
       $edCode = $this->input->post('edCode');
       $edName = strtoupper($this->input->post('edName'));
       $edstatus = $this->input->post('edstatus');
       if($edName && $edCode){
           $condition="edition_name='".$edName."' AND edition_code!='".$edCode."'";
           if($this->IsDuplicate('pmd_edition',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("edition_code"=>$edCode,
                               "edition_name"=>$edName,
                               "cancel_flag"=>$edstatus,
                               "modified_by"=>$this->user->user_id,
                               "modifie_date"=>date('Y-m-d H:i:s'));
               $this->db->where('edition_code', $edCode);
               $this->db->update('pmd_edition', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function UpdateEditionPriority(){
       $updateArray=json_decode($this->input->post('pos_Record'),true);
       $this->db->update_batch('pmd_edition',$updateArray, 'edition_code');
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

   //Route Master
   public function CreateRouteMaster(){
       $route_name = strtoupper($this->input->post('route_name'));
       $vehicle_type = strtoupper($this->input->post('vehicle_type'));
       $vehicle_number = strtoupper($this->input->post('vehicle_number'));
       $vehicle_date = $this->input->post('vehicle_date',true);
       if($route_name){
           $condition="route_name='".$route_name."'";
           if($this->IsDuplicate('pmd_route',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $route_code = $this->GetPrimaryId("RTE_".$this->user->user_unit_code."_CODE");
               $created_by  = $this->user->user_id;
               $currentDate = date('Y-m-d H:i:s');
               $query="INSERT INTO pmd_route (`route_priority`,`route_code`,`route_name`,`created_by`,`created_date`,`cancel_flag`,`route_vehicle_type`,`route_vehicle_no`,`route_vehicle_start_time`,`route_unit`) SELECT IFNULL(MAX(`route_priority`),0)+1,'".$route_code."','".$route_name."',".$created_by.",'".$currentDate."','0','".$vehicle_type."','".$vehicle_number."','".$vehicle_date."','".$this->user->user_unit_code."' FROM `pmd_route`";
               $this->UpdatePrimaryId($route_code, "RTE_".$this->user->user_unit_code."_CODE");
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
       }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
              }
           return $this->Message;
       }
   public function RouteMasterLists(){
       $qury = "SELECT
                        route_code,
                        route_name,
                        route_vehicle_type,
                        route_vehicle_no,
                        route_vehicle_start_time,
                        cancel_flag,
                        route_unit
                FROM
                        pmd_route 
                WHERE
                       route_unit = '".$this->user->user_unit_code."' ORDER BY route_priority";
       return $this->db->query($qury)->result();
   }
   public function ViewRouteMaster(){
       $rt_code = $this->input->post('rt_code');
       $qury = "SELECT
                        route_code,
                        route_name,
                        route_vehicle_type,
                        route_vehicle_no,
                        route_vehicle_start_time,
                        cancel_flag
                FROM
                        pmd_route 
                WHERE
                        route_code = '".$rt_code."'
                        ORDER BY route_priority";
       return $this->db->query($qury)->row();
   }
   public function UpdateRouteMaster(){
       $rtCode = $this->input->post('rtCode');
       $rtName = strtoupper($this->input->post('rtName'));
       $rtType = strtoupper($this->input->post('rtType'));
       $rtNumber = strtoupper($this->input->post('rtNumber'));
       $rtDate = $this->input->post('rtDate',true);
       $rtstatus = $this->input->post('rtstatus');
       if($rtName){
           $condition="route_name='".$rtName."' AND route_code!='".$rtCode."' ";
           if($this->IsDuplicate('pmd_route',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
             $data = array("route_code"=>$rtCode,
                           "route_name"=>$rtName,
                           "route_vehicle_type"=>$rtType,
                           "route_vehicle_no"=>$rtNumber,
                           "route_vehicle_start_time"=>$rtDate,
                           "cancel_flag"=>$rtstatus,
                           "modified_by"=>$this->user->user_id,
                           "modified_date"=>date('Y-m-d H:i:s'));
           $this->db->where('route_code', $rtCode);
           $this->db->update('pmd_route', $data);
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
       }else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function UpdateRoutePriority(){
       $updateArray=json_decode($this->input->post('pos_Record'),true);
       $this->db->update_batch('pmd_route',$updateArray, 'route_code');
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

   //Dropping Point Master
   public function CreateDroppingMaster($drop_rt_code){
       $drop_name = strtoupper($this->input->post('drop_name'));
       $drop_mal_name = $this->input->post('drop_mal_name');
       //$drop_rt_code = $this->input->post('dr_route_code_rec_sel');
       if($drop_name && $drop_rt_code["Code"]){
           $condition="drop_name='".$drop_name."'";
           if($this->IsDuplicate('pmd_drop_point',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $drop_code = $this->GetPrimaryId("DRP_".$this->user->user_unit_code."_CODE");
               $created_by  = $this->user->user_id;
               $currentDate = date('Y-m-d H:i:s');
               $query="INSERT INTO pmd_drop_point (`drop_priority`,`drop_code`,`drop_name`,`created_by`,`created_date`,`cancel_flag`,`drop_mal_name`,`drop_route_code`,`drop_unit`) SELECT IFNULL(MAX(`drop_priority`),0)+1,'".$drop_code."','".$drop_name."',".$created_by.",'".$currentDate."','0','".$drop_mal_name."','".$drop_rt_code["Code"]."','".$this->user->user_unit_code."' FROM `pmd_drop_point`";
               $this->UpdatePrimaryId($drop_code, "DRP_".$this->user->user_unit_code."_CODE");
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
       }else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function DroppingMasterLists($route_id){
       $query = "SELECT
                        t1.drop_name,
                        t1.drop_code,
                        t1.drop_mal_name,
                        t1.drop_route_code,
                        t1.cancel_flag,
                        t2.route_name,
                        t2.route_code
                 FROM 
                        pmd_drop_point t1
                JOIN
                        pmd_route t2 ON t2.route_code=t1.drop_route_code
                 WHERE
                        drop_unit='".$this->user->user_unit_code."' AND t1.drop_route_code='".$route_id."' ORDER BY drop_priority";
       return $this->db->query($query)->result();
   }
   public function ViewDroppingMaster(){
       $dr_code= $this->input->post('drp_code');
       $query = "SELECT
                        t1.drop_name,
                        t1.drop_code,
                        t1.drop_mal_name,
                        t1.drop_route_code,
                        t1.cancel_flag,
                        t2.route_name,
                        t2.route_code
                 FROM
                        pmd_drop_point t1
                JOIN
                        pmd_route t2 ON t2.route_code=t1.drop_route_code
                WHERE
                        drop_code='".$dr_code."' ORDER BY drop_priority";
       return $this->db->query($query)->row();
   }
   public function GetDroppingRoute(){
       $qury = "SELECT
                        route_code,
                        route_name,
                        route_vehicle_type,
                        route_vehicle_no,
                        route_vehicle_start_time,
                        cancel_flag
                FROM
                        pmd_route 
                WHERE
                        route_unit='".$this->user->user_unit_code."'ORDER BY route_priority";
       return $this->db->query($qury)->result();
   }
   public function UpdateDroppingMaster(){
       $drCode= $this->input->post('drCode');
       $drName= strtoupper($this->input->post('drName'));
       $drMal= $this->input->post('drMal');
       $drRoute= json_decode(rawurldecode($this->input->post('drRoute')),true);
       $drStatus= $this->input->post('drStatus');
       if($drName && $drCode && $drRoute["Code"]){
           $condition="drop_name='".$drName."' AND drop_code!='".$drCode."' ";
           if($this->IsDuplicate('pmd_drop_point',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("drop_code"=>$drCode,
                               "drop_name"=>$drName,
                               "drop_mal_name"=>$drMal,
                               "drop_route_code"=>$drRoute["Code"],
                               "cancel_flag"=>$drStatus,
                               "modified_by"=>$this->user->user_id,
                               "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('drop_code', $drCode);
               $this->db->update('pmd_drop_point', $data);
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
       }else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function UpdateDroppingMasterPriority(){
       $updateArray=json_decode($this->input->post('pos_Record'),true);
       $this->db->update_batch('pmd_drop_point',$updateArray, 'drop_code');
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

   //Account Heads
   public function AccountHeadsLists() {
       $qry = "SELECT ac_code,ac_name,ac_debit_credit,cancel_flag FROM pmd_accountheads ORDER BY ac_code";
       return $this->db->query($qry)->result();
   }
   public function CreateAccountHeads() {
       $ac_name          = strtoupper($this->input->post('ac_name',true));
       $ac_debit_credit  = (int) $this->input->post('ac_debit_credit',true);
       $cancel_flag      = (int) $this->input->post('cancel_flag',true);
       if($ac_name) {
           $this->db->trans_begin();
           $condition = " ac_name = '".$ac_name."'";
           if($this->IsDuplicate('pmd_accountheads',$condition)) {
               $this->Message->status=400;
               $this->Message->text="Account Head name already taken!";
           }else{
               $ac_code = $this->GetPrimaryId('ACC_CODE');
               $data = array("ac_code"=>$ac_code,
                             "ac_name"=>$ac_name,
                             "ac_debit_credit"=>$ac_debit_credit,
                             "cancel_flag"=>$cancel_flag,
                             "created_by"=>$this->user->user_id,
                             "created_date"=>date('Y-m-d H:i:s'));
               $this->db->insert('pmd_accountheads',$data);
               $this->UpdatePrimaryId($ac_code, 'ACC_CODE');
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
   public function ViewAccountHeads() {
       $qry = "SELECT ac_code,ac_name,ac_debit_credit,cancel_flag FROM pmd_accountheads WHERE ac_code = '". $this->input->post('ac_code') ."' LIMIT 1";
       return $this->db->query($qry)->row();
   }
   public function UpdateAccountHeads()
   {
       $ac_code          = $this->input->post('ac_code',true);
       $ac_name          = strtoupper($this->input->post('ac_name',true));
       $cancel_flag      = (int) $this->input->post('cancel_flag',true);
       $ac_debit_credit  = (int) $this->input->post('ac_debit_credit',true);

       if($ac_code && $ac_name) {
           $condition = "ac_code != '".$ac_code."' AND ac_name = '".$ac_name."'";
           if($this->IsDuplicate('pmd_accountheads',$condition)) {
               $this->Message->status=400;
               $this->Message->text="Account Head name already taken!";
           }
           else {
               
               //check in journal entry table if the status is set to cancel flag
               $head_in_use = false;               
               if($cancel_flag == 1) {                  
                    //if exists in je table, set value value to true
                    /*****************************************************/
                    /*****************************************************/
                    /***TO BE DONE AFTER COMPLETING JOURNAL ENTRY TABLE***/
                    /*****************************************************/
                    /*****************************************************/
               }

               if($head_in_use === false) {
                   $this->db->trans_begin();
                   $data = array("ac_name"=>$ac_name,
                                 "ac_debit_credit"=>$ac_debit_credit,
                                 "cancel_flag"=>$cancel_flag,
                                 "modified_by"=>$this->user->user_id,
                                 "modified_date"=>date('Y-m-d H:i:s'));
                   $this->db->where('ac_code', $ac_code);
                   $this->db->update('pmd_accountheads', $data);
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
               else {
                   $this->db->trans_rollback();
                   $this->Message->status=400;
                   $this->Message->text="Cannot disable this Account head. It is already used against Journal Entry";
               }
           }
       }
       else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   //event master
   public function CreateEvent(){
       $event_name = strtoupper($this->input->post('event_name'));
       $start_date = date('Y-m-d',strtotime($this->input->post('start_date')));
       $end_date = date('Y-m-d',strtotime($this->input->post('end_date')));
       if($event_name){
           $condition="event_name='".$event_name."'";
           if($this->IsDuplicate('pmd_events',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $event_code = $this->GetPrimaryId("ENT_".$this->user->user_unit_code."_CODE");
               $data=array("event_unit"=>$this->user->user_unit_code,
                           "event_code"=>$event_code,
                           "event_name"=>$event_name,
                           "event_start_date"=>$start_date,
                           "event_end_date"=>$end_date,
                           "cancel_flag"=>0,
                           "created_by"=>$this->user->user_id,
                           "created_date"=>date('Y-m-d H:i:s'));
               $this->db->insert('pmd_events',$data);
               $this->UpdatePrimaryId($event_code, "ENT_".$this->user->user_unit_code."_CODE");
           
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
}
   public function EventLists(){
       $qury = "SELECT
                    event_code,
                    event_name,
                    event_start_date,
                    event_end_date,
                    cancel_flag 
                FROM 
                    pmd_events
                WHERE
                    event_unit = '". $this->user->user_unit_code."'";
       return $this->db->query($qury)->result();
   }
   public function ViewEvent(){
       $evnt_code = $this->input->post('evnt_code');
       $qury = "SELECT
                    event_code,
                    event_name,
                    event_start_date,
                    event_end_date,
                    cancel_flag
                FROM
                    pmd_events
                WHERE
                    event_code='".$evnt_code."' ";
       return $this->db->query($qury)->row();
   }
   public function UpdateEvent(){
       $evnCode = $this->input->post('evnCode');
       $evnName = strtoupper($this->input->post('evnName'));
       $evnStartdate = date('Y-m-d',strtotime($this->input->post('evnStartdate')));
       $evnEnddate = date('Y-m-d',strtotime($this->input->post('evnEnddate')));
       $evenStatus = $this->input->post('evenStatus');
       if($evnCode && $evnName){
           $condition="event_name='".$evnName."' AND event_code!='".$evnCode."'";
           if($this->IsDuplicate('pmd_events',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("event_unit"=>$this->user->user_unit_code,
                             "event_code"=>$evnCode,
                             "event_name"=>$evnName,
                             "event_start_date"=>$evnStartdate,
                             "event_end_date"=>$evnEnddate,
                             "cancel_flag"=>$evenStatus,
                             "modified_by"=>$this->user->user_id,
                             "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('event_code', $evnCode);
               $this->db->update('pmd_events', $data);
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
       }else {
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }

   //Agency Master
   public function AgentLists() {
       $where = "";
       if($this->input->post('agent_unit')) {
           $where .= " AND A.agent_unit = '". $this->input->post('agent_unit') ."' ";
       }
       if($this->input->post('agent_name')) {
           $where .= " AND (A.agent_name LIKE '%". $this->input->post('agent_name') ."%' OR 
                            A.agent_code LIKE '%". $this->input->post('agent_name') ."%' OR
                            A.agent_location LIKE '%". $this->input->post('agent_name') ."%' OR
                            A.agent_phone LIKE '%". $this->input->post('agent_name') ."%') ";
       }
       if($this->input->post('agent_status') >= 0) {
           $where .= " AND A.cancel_flag = '". $this->input->post('agent_status') ."' ";
       }
       $qry = "SELECT
                    A.agent_slno,
                    A.agent_code,
                    A.agent_name,
                    A.agent_location,
                    A.agent_address,
                    A.agent_phone,
                    A.cancel_flag,
                    C.copy_name
                FROM 
                    pmd_agent A
                JOIN
                    pmd_copymaster C ON C.copy_code = A.agent_type
                WHERE
                    1 = 1 ".$where."
                ORDER BY A.agent_code";
       return $this->db->query($qry)->result();
   }
   public function AgentDetails($agent_slno) {
       $qry = "SELECT * FROM pmd_agent WHERE agent_slno = '". $agent_slno ."'";
       return $this->db->query($qry)->row();
   }
   public function AgentMembershipDetails($agent_slno) {
       $qry = "SELECT 
                    D.*,
                    P.product_name,
                    A.acm_name,
                    R.region_name,
                    PR.promoter_name,
                    B.bureau_name,
                    E.edition_name,
                    RT.route_name,
                    DP.drop_name,
                    U.union_name,
                    S.shakha_name
                FROM 
                    pmd_agentdetails D 
                JOIN
                    pmd_products P ON P.product_code = D.agent_product_code
                JOIN
                    pmd_acm A ON A.acm_code = D.agent_acm 
                JOIN
                    pmd_region R ON R.region_code = D.agent_region
                JOIN
                    pmd_promoter PR ON PR.promoter_code = D.agent_promoter
                JOIN
                    pmd_bureau B ON B.bureau_code = D.agent_bureau
                JOIN
                    pmd_edition E ON E.edition_code = D.agent_edition
                JOIN
                    pmd_route RT ON RT.route_code = D.agent_route
                JOIN
                    pmd_drop_point DP ON DP.drop_code = D.agent_dropping_point
                JOIN
                    pmd_union U ON U.union_code = D.agent_union
                JOIN
                    pmd_shakha S ON S.shakha_code = D.agent_shakha
                WHERE 
                    D.agent_slno = '". $agent_slno ."'";
       return $this->db->query($qry)->result();
   }
   public function UpsertAgentMaster() {
       $is_update   =   (int)$this->input->post('is_update',true);
       $agent_slno  = '';
       if($is_update === 1) {
           $agent_slno = $this->input->post('agent_slno',true);
       }

       //Tab1
       $agent_unit               = $this->user->user_unit_code;
       $agent_code               = strtoupper($this->input->post('agent_code',true));      
       $agent_name               = strtoupper($this->input->post('agent_name',true));
       $agent_address            = strtoupper($this->input->post('agent_address',true));
       $agent_location           = strtoupper($this->input->post('agent_location',true));
       $agent_phone              = $this->input->post('agent_phone',true);
       $agent_aadhar             = $this->input->post('agent_aadhar',true);
       $agent_dob                = date('Y-m-d',strtotime($this->input->post('agent_dob',true)));
       $agent_type               = $this->input->post('agent_type',true);
       $agent_mal_slip           = $this->input->post('agent_mal_slip',true);
       $agent_stall              = $this->input->post('agent_stall',true);
       $agent_mal_name           = $this->input->post('agent_mal_name',true);
       $agent_mal_location       = $this->input->post('agent_mal_location',true);
       $agent_settlement_date    = $this->input->post('agent_settlement_date',true);

       //Tab2
       $product_records         = $this->input->post('product_records',true);
       $data = $data_trans = $data_keys = array();
       if($agent_code && $agent_name && $agent_address && $agent_location) {

           $this->db->trans_begin();
           $condition = " agent_code = '".$agent_code."' ";
           if($is_update === 1) {
               $condition .= " AND agent_slno != '".$agent_slno."'";
           }

           if($this->IsDuplicate('pmd_agent',$condition)) {
               $this->Message->status=400;
               $this->Message->text="Agency name already taken!";
           }else{

               //fetch-id-for-insert-only
               if($is_update === 0) {
                   $agent_slno = $this->GetPrimaryId('AS_'.$agent_unit.'_CODE');

                   //only-for-insert
                   $data_keys = array("agent_slno"=>$agent_slno,"agent_code"=>$agent_code);
               }
               
               $data = array("agent_unit"=>$agent_unit,
                             "agent_name"=>$agent_name,
                             "agent_mal_name"=>$agent_mal_name,
                             "agent_location"=>$agent_location,
                             "agent_mal_location"=>$agent_mal_location,
                             "agent_address"=>$agent_address,
                             "agent_phone"=>$agent_phone,
                             "agent_aadhar"=>$agent_aadhar,
                             "agent_dob"=>$agent_dob,
                             "agent_type"=>$agent_type,
                             "agent_mal_slip"=>$agent_mal_slip,
                             "agent_stall"=>$agent_stall,
                             "agent_settlement_date"=>$agent_settlement_date ? date('Y-m-d',strtotime($agent_settlement_date)) : null,
                             $is_update === 0 ? "created_by"   : "modified_by"=>$this->user->user_id,
                             $is_update === 0 ? "created_date" : "modified_date"=>date('Y-m-d H:i:s'));

               if(count($product_records)) {
                   foreach($product_records as $p) {
                       $r = json_decode(rawurldecode($p),true);
                       $data_trans[] = array("agent_slno"=>$agent_slno,
                                             "agent_unit"=>$agent_unit,
                                             "agent_product_code"=>$r['agent_product'],
                                             "agent_code"=>$agent_code,
                                             "agent_acm"=>$r['agent_acm'],
                                             "agent_region"=>$r['agent_acm_region'],
                                             "agent_promoter"=>$r['agent_promoter'],
                                             "agent_bureau"=>$r['agent_bureau'],
                                             "agent_edition"=>$r['agent_edition'],
                                             "agent_route"=>$r['agent_route'],
                                             "agent_dropping_point"=>$r['agent_drop_point'],
                                             "agent_union"=>$r['agent_union'],
                                             "agent_shakha"=>$r['agent_shakha'],
                                             "agent_doj"=>date('Y-m-d',strtotime($r['agent_doj'])),
                                             "agent_comm"=>$r['agent_comm'],
                                             "agent_comm_flag"=>$r['agent_comm_flag'],
                                             "agent_sec_contr"=>$r['agent_sec'],
                                             "agent_sec_flag"=>$r['agent_sec_flag'],
                                             "agent_bill_print"=>$r['agent_bill_print'],
                                             "agent_slip_print"=>$r['agent_slip_print'],
                                             "agent_bill_bonus"=>$r['agent_bill_bonus'],
                                             "agent_status"=>$r['agent_status'],
                                             "agent_status_date"=>$r['agent_status'] == 0 ? null : date('Y-m-d H:i:s'),
                                             $is_update === 0 ? "created_by"   : "modified_by"=>$this->user->user_id,
                                             $is_update === 0 ? "created_date" : "modified_date"=>date('Y-m-d H:i:s'));
                   }
               }
               
               if($is_update === 0) {
                   //insert tbl
                   $data = array_merge($data_keys,$data);
                   $this->db->insert('pmd_agent',$data);

                   //insert to trans tbl
                   if(count($data_trans)) $this->db->insert_batch('pmd_agentdetails',$data_trans);
                   $this->UpdatePrimaryId($agent_slno, 'AS_'.$agent_unit.'_CODE');

                   $this->Message->agent_slno = null;
               }
               else if($is_update === 1) {
                   //delete-all-trans-record-and-insert-new-data
                   $this->db->where('agent_slno', $agent_slno);
                   $this->db->where('agent_code', $agent_code);
                   $this->db->delete('pmd_agentdetails');

                   //update tbl
                   $this->db->where('agent_slno', $agent_slno);
                   $this->db->where('agent_code', $agent_code);
                   $this->db->update('pmd_agent',$data);

                   //insert to trans tbl
                   if(count($data_trans)) $this->db->insert_batch('pmd_agentdetails',$data_trans);

                   $this->Message->agent_slno = $agent_slno;
               }

               if($this->db->trans_status() === TRUE)
               {
                   $this->db->trans_commit();
                   $this->Message->status=200;
                   $this->Message->text= $is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');
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
   //check-agent-code-already-used
   public function ValidateAgentCode() {
       $is_update  = (int)$this->input->post('is_update',true);
       $agent_code = strtoupper($this->input->post('agent_code',true));
       $agent_slno = $this->input->post('agent_slno',true);
       $condition  = " AND agent_code = '".$agent_code."' ";
       if($is_update === 1) {
           $condition .= " AND agent_slno != '".$agent_slno."' ";
       }
       $qry = "SELECT COUNT(*) AS is_exists FROM pmd_agent WHERE 1 = 1 ". $condition ." LIMIT 1";
       return $this->db->query($qry)->row()->is_exists;
   } 

   //Agent Group
   public function GetAgentGroups() {
        $qry = "SELECT agent_group_code,agent_group_name,agent_product_code,U.user_emp_name created_name,AG.created_by FROM pmd_agentgroup AG INNER JOIN pmd_userdetails U ON AG.created_by=U.user_id  WHERE agent_group_unit = '".$this->user->user_unit_code."'";
        return $this->db->query($qry)->result();
    }
   public function CreateAgentGroups() {
        $agent_group_code = $this->input->post('group_code',true); //null if new group else update
        $is_edit_mode = $agent_group_code ? true : false; 
        $agent_group_name = $this->input->post('group_name',true);
        $trans_data = $final_agents_codes = $final_agents = array();
        $agent_lists = json_decode($this->input->post('agents_lists',true), true);
        //selected agents
        foreach($agent_lists as $agent){
            if(!in_array($agent["Code"],$final_agents_codes))
            {
                $final_agents_codes[] = $agent["Code"];
                $final_agents[] = array("code"=>$agent["Code"],"agentslno"=>$agent["SerialNumber"],"agentname"=>$agent["Name"]);
            }
        }
        if($agent_group_name && $final_agents) {
            $agent_group_name = strtoupper($agent_group_name);
            if($is_edit_mode){
                $condition = " agent_group_name = '".$agent_group_name."' AND agent_group_code!= '".$agent_group_code."'";
            }else{
                $condition = " agent_group_name = '".$agent_group_name."'";
            }
            if($this->IsDuplicate('pmd_agentgroup',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Agent Group name already exists!";
            }else{
            $this->db->trans_begin();
            if(!$is_edit_mode){ 
                $agent_group_code = $this->GetPrimaryId('AGGRP_'.$this->user->user_unit_code.'_CODE');
            }
            //prepare trans data
            foreach($final_agents as $agent){
                $trans_data[] = array(
                                "agent_group_unit" => $this->user->user_unit_code,
                                "agent_group_code" => $agent_group_code,
                                "agent_product_code" => $this->user->user_product_code,
                                "agent_slno" => $agent["agentslno"],
                                "agent_code" => $agent["code"]
                                );
            }
            if($is_edit_mode){//update agent group
                $this->db->where('agent_group_code', $agent_group_code);
                $this->db->delete('pmd_agentgroupdet');
                $data = array("agent_group_name"=>$agent_group_name,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('agent_group_code',$agent_group_code);
                $this->db->update('pmd_agentgroup',$data);
            }else{
                $data = array("agent_group_unit"=>$this->user->user_unit_code,
                              "agent_group_code"=>$agent_group_code,
                              "agent_group_name"=>$agent_group_name,
                              "agent_product_code"=>$this->user->user_product_code,
                              "created_by"=>$this->user->user_id,
                              "created_date"=>date('Y-m-d H:i:s'));
                $this->db->insert('pmd_agentgroup',$data);
                $this->UpdatePrimaryId($agent_group_code, 'AGGRP_'.$this->user->user_unit_code.'_CODE');
            }
            $this->db->insert_batch("pmd_agentgroupdet",$trans_data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text= $is_edit_mode?$this->lang->line('updated_success'):$this->lang->line('added_success');
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
   public function DeleteAgentGroups() {
        $agent_group_code = $this->input->post('agent_group_code',true);
        if($agent_group_code) {
            $this->db->trans_begin();
            $this->db->where('agent_group_code',$agent_group_code);
            $this->db->delete('pmd_agentgroupdet');
            $this->db->where('agent_group_code',$agent_group_code);
            $this->db->delete('pmd_agentgroup');
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
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
   public function ViewAgentGroups() {
       $agent_group_code = $this->input->post('agent_group_code',TRUE);
       $response = array("aggroup_details"=>array(),"aggroup_agents"=>array());
       $qry = "SELECT agent_group_code,agent_group_name FROM pmd_agentgroup AG WHERE agent_group_code = '".$agent_group_code."' LIMIT 1";
       $response["aggroup_details"] = $this->db->query($qry)->row();
       $qry = "SELECT AGD.agent_group_code,A.agent_code,A.agent_slno,A.agent_name,A.agent_location FROM pmd_agentgroupdet AGD INNER JOIN pmd_agent A ON AGD.agent_code=A.agent_code WHERE AGD.agent_group_code = '".$agent_group_code."'";
       $response["aggroup_agents"] = $this->db->query($qry)->result();
       return $response;
    }
   public function UpdateAgentGroups()
    {
        $acm_code   = $this->input->post('acm_code',true);
        $acm_name   = $this->input->post('acm_name',true);
        $acm_phone  = $this->input->post('acm_phone',true);
        $acm_area   = $this->input->post('acm_area',true);
        $acm_status = $this->input->post('acm_status',true);
        if($acm_code && $acm_name && $acm_phone && $acm_area) {
            $condition = "acm_code != '".$acm_code."' AND acm_name = '".$acm_name."'";
            if($this->IsDuplicate('pmd_acm',$condition)) {
                $this->Message->status=400;
                $this->Message->text="ACM name already taken!";
            }
            else {
                //"user_login_name"=>$user_name,
                $this->db->trans_begin();
                $data = array("acm_name"=>strtoupper($acm_name),
                              "acm_phone"=>$acm_phone,
                              "acm_area"=>strtoupper($acm_area),
                              "cancel_flag"=>$acm_status,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
                $this->db->where('acm_code', $acm_code);
                $this->db->update('pmd_acm', $data);
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
   public function GetUploadedAgents(){
       $file_db_agents = array(); $agents_html='';
       $agent_upload_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/temp/';
       if(!is_dir($agent_upload_path)){
           mkdir($agent_upload_path,0777);
       }
       $agent_filename = "agent_".strtotime("now")."_".$this->user->user_id.".txt"; 
       
       if(isset($_FILES["agents_file"]["name"])){
           $file_agent_codes=array();
           $ext = strtolower(pathinfo($_FILES["agents_file"]["name"], PATHINFO_EXTENSION));
           if($ext=='txt'){
               if(move_uploaded_file($_FILES['agents_file']['tmp_name'],$agent_upload_path.$agent_filename)){
                   if ($fh = fopen($agent_upload_path.$agent_filename, 'r')) {
                       while (!feof($fh)) {
                           $ag_code = strtoupper(preg_replace( "/\r|\n/", "", fgets($fh)));
                           if($ag_code) $file_agent_codes[] = $ag_code;
                       }
                       fclose($fh);
                   }
                   unlink($agent_upload_path.$agent_filename);
               }
           }
           if($file_agent_codes){
               $file_db_agents=$this->GetAgents($file_agent_codes);
           }
       }
       //uploaded agents
       foreach($file_db_agents as $agent){
           $agents_html .= '<tr>
                            <td><input type="checkbox" class="up_agents" value="'.rawurlencode(json_encode(array("Code"=>$agent->agent_code,"Name"=>$agent->agent_name,"Location"=>$agent->agent_location,"SerialNumber"=>$agent->agent_slno))).'"/></td>
                            <td>'.$agent->agent_code.'</td><td>'.$agent->agent_name.'</td><td>'.$agent->agent_location.'</td></tr>';
       }
       return $agents_html;
   }
   private function GetAgents($agent_codes){
        $query="SELECT
                    agent_slno,
                    agent_code,
                    agent_name,
                    agent_location
                FROM 
                    pmd_agent
                WHERE 
                    agent_code IN ('".implode("','",$agent_codes)."')";
       return $this->db->query($query)->result();
   }

   //Region Master
   public function CreateRegion(){
       $region_name = strtoupper($this->input->post('region_name'));
       if($region_name){
           $condition="region_name='".$region_name."'";
           if($this->IsDuplicate('pmd_region',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $region_code = $this->GetPrimaryId("REG_".$this->user->user_unit_code."_CODE");

               $data = array("region_code"=>$region_code,
                               "region_name"=>$region_name,
                               "region_unit"=>$this->user->user_unit_code,
                               "cancel_flag"=>0,
                               "created_by"=>$this->user->user_id,
                               "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_region',$data);
               $this->UpdatePrimaryId($region_code, "REG_".$this->user->user_unit_code."_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function RegionLists(){
       $query="SELECT
                    region_unit,
                    region_code,
                    region_name,
                    cancel_flag 
                FROM 
                    pmd_region
                WHERE 
                    region_unit='".$this->user->user_unit_code."'";
       return $this->db->query($query)->result();
   }
   public function ViewRegion(){
       $reg_code = $this->input->post('region_code');
       $query = "SELECT
                    region_unit,
                    region_code,
                    region_name,
                    cancel_flag
                FROM
                    pmd_region
                WHERE
                    region_code='".$reg_code."'";
       return $this->db->query($query)->row();
   }
   public function UpdateRegion(){
       $reg_code=$this->input->post('regCode');
       $reg_name=strtoupper($this->input->post('regName'));
       $reg_status=$this->input->post('regStatus');
       if($reg_name && $reg_code){
           $condition="region_name='".$reg_name."' AND region_code!='".$reg_code."'";
           if($this->IsDuplicate('pmd_region',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array( "region_code"=>$reg_code,
                                 "region_name"=>$reg_name,
                                 "region_unit"=>$this->user->user_unit_code,
                                 "cancel_flag"=>$reg_status,
                                 "modified_by"=>$this->user->user_id,
                                 "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('region_code', $reg_code);
               $this->db->update('pmd_region', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   // Holiday Master
   public function CreateHoliday(){
       $holiday_date = date('Y-m-d',strtotime($this->input->post('holiday_date')));
       $holiday_desc = strtoupper($this->input->post('holiday_desc'));
       $holiday_Office = $this->input->post('holiday_Office');
       $this->db->trans_begin();
       $holiday_code = $this->GetPrimaryId("HLD_".$this->user->user_unit_code."_CODE");
       $data=array("holiday_code"=>$holiday_code,
           "holiday_unit"=>$this->user->user_unit_code,
           "holiday_product_code"=>$this->user->user_product_code,
           "holiday_date"=>$holiday_date,
           "holiday_desc"=>$holiday_desc,
           "holiday_office"=>$holiday_Office,
           "created_by"=>$this->user->user_id,
           "created_date"=>date('Y-m-d'));
       $this->db->insert('pmd_holiday',$data);
       $this->UpdatePrimaryId($holiday_code, "HLD_".$this->user->user_unit_code."_CODE");
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
       return $this->Message;
   }
   public function HolidayList(){
       $query="SELECT
                        holiday_code,
                        holiday_unit,
                        holiday_product_code,
                        holiday_date,
                        holiday_desc,
                        holiday_office,
                        cancel_flag
               FROM 
                        pmd_holiday
                        ORDER BY holiday_date";
       return $this->db->query($query)->result();
   }
   public function ViewHoliday(){
       $holiday_code=$this->input->post('holiCode');
       $query="SELECT
                        holiday_code,
                        holiday_unit,
                        holiday_product_code,
                        holiday_date,
                        holiday_desc,
                        holiday_office,
                        cancel_flag
               FROM
                        pmd_holiday
               WHERE
                        holiday_code='".$holiday_code."'";
       
       return $this->db->query($query)->row();
   }
   public function UpdateHoliday(){
       $hld_code=$this->input->post('hldCode');
       $hld_date=date('Y-m-d',strtotime($this->input->post('hldDate')));
       $hld_desc=strtoupper($this->input->post('hldDesc'));
       $hld_office=$this->input->post('hldoffice');
       $hld_status=$this->input->post('hldStatus');
       $condition="holiday_date='".$hld_date."' AND holiday_code!='".$hld_code."'";
       if($this->IsDuplicate('pmd_holiday',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $data = array("holiday_code"=>$hld_code,
                             "holiday_unit"=>$this->user->user_unit_code,
                             "holiday_product_code"=>$this->user->user_product_code,
                             "holiday_date"=>$hld_date,
                             "holiday_desc"=>$hld_desc,
                             "holiday_office"=>$hld_office,
                             "cancel_flag"=>$hld_status,
                             "modified_by"=>$this->user->user_id,
                             "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('holiday_code', $hld_code);
               $this->db->update('pmd_holiday', $data);
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
       return $this->Message;
   }
   //Subscriber Master
   public function SaveSubscriber(){
       $sub_name=strtoupper($this->input->post('subcr_name'));
       $sub_address=strtoupper($this->input->post('subcr_address'));
       $sub_phone=$this->input->post('sub_mobile');
       $sub_edition=json_decode(rawurldecode($this->input->post('sub_edition_rec_sel',true)),true);
       $sub_agent=json_decode(rawurldecode($this->input->post('sub_agent_rec_sel',true)),true);
       if($sub_name && $sub_address && $sub_phone && $sub_edition["Code"] && $sub_agent["Code"] && $sub_agent["SerialNumber"]){
           $condition=" sub_name='".$sub_name."' AND sub_phone = '".$sub_phone."' ";
           if($this->IsDuplicate('pmd_subscriber',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $subscriber_code = $this->GetPrimaryId("SUB_".$this->user->user_unit_code."_CODE");
               $data=array("sub_code"=>$subscriber_code,
                   "sub_unit_code"=>$this->user->user_unit_code,
                   "sub_name"=>$sub_name,
                   "sub_address"=>$sub_address,
                   "sub_phone"=>$sub_phone,
                   "sub_edition"=>$sub_edition["Code"],
                   "sub_agent_code"=>$sub_agent["Code"],
                   "sub_agent_slno"=>$sub_agent["SerialNumber"],
                   "cancel_flag"=>0,
                   "created_by"=>$this->user->user_id,
                   "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_subscriber',$data);
               $this->UpdatePrimaryId($subscriber_code, "SUB_".$this->user->user_unit_code."_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function SubscriberList() {
       $where      = "";
       $keyword    = $this->input->post('subcr_name',true);
       $agent_rec  = json_decode(rawurldecode($this->input->post('sub_agent_rec_sel',true)),true);
       $agent_code = isset($agent_rec['Code']) ? $agent_rec['Code'] : null;
       $agent_slno = isset($agent_rec['SerialNumber']) ? $agent_rec['SerialNumber'] : null;

       if($keyword) {
           $where .= " AND (t1.sub_name LIKE '%".$keyword."%' OR
                            t1.sub_address LIKE '%".$keyword."%' OR
                            t1.sub_phone LIKE '%".$keyword."%') ";
       }

       if($agent_code) {
           $where .= " AND t1.sub_agent_code = '".$agent_code."' ";
       }

       if($agent_slno) {
           $where .= " AND t1.sub_agent_slno = '".$agent_slno."' ";
       }

       $qry="SELECT
                    t1.sub_code,
                    t1.sub_unit_code,
                    t1.sub_name,
                    t1.sub_address,
                    t1.sub_phone,
                    t1.sub_agent_code,
                    t1.sub_agent_slno,
                    t1.sub_edition,
                    t1.cancel_flag,
                    t2.agent_slno,
                    t2.agent_code,
                    t2.agent_name,
                    t2.agent_location,
                    t3.edition_code,
                    t3.edition_name                    
               FROM 
                    pmd_subscriber t1
               JOIN
                    pmd_agent t2 ON t1.sub_agent_slno=t2.agent_slno
               JOIN
                    pmd_edition t3 ON t3.edition_code=t1.sub_edition
               WHERE
                    t1.sub_unit_code='".$this->user->user_unit_code."' ".$where;
       return $this->db->query($qry)->result();
   }
   public function ViewSubscriber(){
       $subs_code = $this->input->post('subsCode');
       $query = "SELECT
                    t1.sub_code,
                    t1.sub_unit_code,
                    t1.sub_name,
                    t1.sub_address,
                    t1.sub_phone,
                    t1.sub_agent_code,
                    t1.sub_agent_slno,
                    t1.sub_edition,
                    t1.cancel_flag,
                    t2.agent_slno,
                    t2.agent_code,
                    t2.agent_name,
                    t2.agent_location,
                    t3.edition_code,
                    t3.edition_name
               FROM
                    pmd_subscriber t1
               JOIN
                    pmd_agent t2 ON t1.sub_agent_slno=t2.agent_slno
               JOIN
                    pmd_edition t3 ON t3.edition_code=t1.sub_edition
                WHERE
                    sub_code='".$subs_code."' AND t1.sub_unit_code='".$this->user->user_unit_code."'";
       return $this->db->query($query)->row();
   }
   public function UpdateSubscriber(){
       $subscriber_code = $this->input->post('subCode');
       $subscriber_name = strtoupper($this->input->post('subName'));
       $subscriber_addr = strtoupper($this->input->post('subAddress'));
       $subscriber_mob = $this->input->post('subPhn');
       $subscriber_edition = json_decode(rawurldecode($this->input->post('subEditon')),true);
       $subscriber_agent = json_decode(rawurldecode($this->input->post('subAgent')),true);
       $previous_sub_agent = json_decode(rawurldecode($this->input->post('prevSubAgent')),true);
       $subscriber_status = (int)$this->input->post('subStatus');
       if($subscriber_code && $subscriber_name && $subscriber_addr && $subscriber_mob && $subscriber_agent["Code"] && $subscriber_agent["SerialNumber"] && $subscriber_edition["Code"]){
           $condition = " sub_name = '".$subscriber_name."' AND sub_phone = '".$subscriber_mob."' AND sub_code != '".$subscriber_code."' ";
           if($this->IsDuplicate('pmd_subscriber',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
                      $data = array("sub_code"=>$subscriber_code,
                                    "sub_name"=>$subscriber_name,
                                    "sub_address"=>$subscriber_addr,
                                    "sub_agent_code"=>$subscriber_agent["Code"],
                                    "sub_agent_slno"=>$subscriber_agent["SerialNumber"],
                                    "sub_edition"=>$subscriber_edition["Code"],
                                    "sub_phone"=>$subscriber_mob,
                                    "sub_unit_code"=>$this->user->user_unit_code,
                                    "cancel_flag"=>$subscriber_status,
                                    "modified_by"=>$this->user->user_id,
                                    "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('sub_code', $subscriber_code);
               $this->db->update('pmd_subscriber', $data);
               //update amendment if new agent 
               if($previous_sub_agent["Code"] != $subscriber_agent["Code"]){
                   $data_ins = $data_updt = $data_ag_updt = array();
                   $sub_amendments = $this->GetSubAgentAmendments($subscriber_code);
                   if($sub_amendments){
                       $now = date('Y-m-d H:i:s');
                       $today = date("Y-m-d");
                       $yesterday = date("Y-m-d", strtotime("-1 day"));
                       $amendment_code = $this->GetPrimaryId('AMDT_'.$this->user->user_unit_code.'_CODE');
                       foreach($sub_amendments as $samd){
                           if(strtotime($samd->amendment_start_date)<strtotime($today)){//if scheme already started insert new agent & update old one end date
                               $data_ins[] = array("amendment_code"=>$amendment_code, 
                                                    "unit_code"=>$samd->unit_code, 
                                                    "amendment_pdt_code"=>$samd->amendment_pdt_code,
                                                    "amendment_start_date"=>$today,
                                                    "amendment_end_date"=>$samd->amendment_end_date,
                                                    "amendment_agent_code"=>$subscriber_agent["Code"],
                                                    "amendment_agent_slno"=>$subscriber_agent["SerialNumber"],
                                                    "amendment_sub_code"=>$samd->amendment_sub_code,
                                                    "amendment_copy_code"=>$samd->amendment_copy_code,
                                                    "amendment_copy_group"=>$samd->amendment_copy_group,
                                                    "amendment_copy_type"=>$samd->amendment_copy_type,
                                                    "amendment_scheme_code"=>$samd->amendment_scheme_code,
                                                    "amendment_sun"=>$samd->amendment_sun,
                                                    "amendment_mon"=>$samd->amendment_mon,
                                                    "amendment_tue"=>$samd->amendment_tue,
                                                    "amendment_wed"=>$samd->amendment_wed,
                                                    "amendment_thu"=>$samd->amendment_thu,
                                                    "amendment_fri"=>$samd->amendment_fri,
                                                    "amendment_sat"=>$samd->amendment_sat,
                                                    "amendment_copies"=>$samd->amendment_copies,
                                                    "amendment_bfree_flag"=>$samd->amendment_bfree_flag,
                                                    "amendment_pause_flag"=>$samd->amendment_pause_flag,
                                                    "amendment_auto_flag"=>$samd->amendment_auto_flag,
                                                    "created_by"=>$this->user->user_id,
                                                    "created_date"=>$now);
                               $amendment_code = $this->AutoIncrement($amendment_code);
                                $data_updt[] = array("amendment_code"=>$samd->amendment_code,
                                                     "amendment_end_date"=>$yesterday);
                           }else{//else update old one with agency
                                 $data_ag_updt[] = array("amendment_code"=>$samd->amendment_code,
                                                 "amendment_agent_code"=>$subscriber_agent["Code"],
                                                 "amendment_agent_slno"=>$subscriber_agent["SerialNumber"]
                                                 );
                           }
                       }
                       if($data_ins) $this->db->insert_batch('pmd_temp_amendment',$data_ins);
                       if($data_updt) $this->db->update_batch('pmd_temp_amendment',$data_updt, 'amendment_code');
                       if($data_ag_updt) $this->db->update_batch('pmd_temp_amendment',$data_ag_updt, 'amendment_code');
                       $this->UpdatePrimaryId($amendment_code, 'AMDT_'.$this->user->user_unit_code.'_CODE',TRUE);
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
           
           }
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   
   }
   private function GetSubAgentAmendments($sub_code){
     $qury="SELECT
                    amendment_code, 
                    unit_code, 
                    amendment_pdt_code,
                    amendment_start_date,
                    amendment_end_date,
                    amendment_agent_code,
                    amendment_agent_slno,
                    amendment_sub_code,
                    amendment_copy_code,
                    amendment_copy_group,
                    amendment_copy_type,
                    amendment_scheme_code,
                    amendment_sun,
                    amendment_mon,
                    amendment_tue,
                    amendment_wed,
                    amendment_thu,
                    amendment_fri,
                    amendment_sat,
                    amendment_copies,
                    amendment_bfree_flag,
                    amendment_pause_flag,
                    amendment_auto_flag
              FROM
                    pmd_temp_amendment
              WHERE
                    amendment_sub_code='".$sub_code."' AND (amendment_end_date>='".date("Y-m-d H:i:s")."' OR amendment_end_date IS NULL) AND cancel_flag != 0";
       return $this->db->query($qury)->result();
   }
   //Amendment Reason
   public function CreateAmendmentReason(){
       $reason_name = strtoupper($this->input->post('reason_name'));
        if($reason_name){
            $condition="reason_name='".$reason_name."'";
           if($this->IsDuplicate('pmd_amend_reason',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $amend_code = $this->GetPrimaryId("AMND_CODE");
               $data=array("reason_id"=>$amend_code,
                   "reason_name"=>$reason_name,
                   "created_by"=>$this->user->user_id,
                   "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_amend_reason',$data);
               $this->UpdatePrimaryId($amend_code, "AMND_CODE");
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
        }else{
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
   }
   public function AmendmentReasonList(){
       $qury="SELECT
                    reason_id,
                    reason_name,
                    cancel_flag 
              FROM 
                    pmd_amend_reason";
       return $this->db->query($qury)->result();
   }
   public function ViewAmendmentReason(){
       $reason_code= $this->input->post('resonCode');
       $qury="SELECT
                    reason_id,
                    reason_name,
                    cancel_flag
              FROM
                    pmd_amend_reason
              WHERE
                    reason_id='".$reason_code."'";
       return $this->db->query($qury)->row();
   }
   public function UpdateAmendmentReason(){
       $amend_code = $this->input->post('reasonCode');
       $amend_name = strtoupper($this->input->post('reasonName'));
       $amend_status = $this->input->post('reasonStatus');
       if($amend_code && $amend_name){
           $condition="reason_name='".$amend_name."' AND reason_id!='".$amend_code."'";
           if($this->IsDuplicate('pmd_amend_reason',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("reason_id"=>$amend_code,
                             "reason_name"=>$amend_name,
                             "cancel_flag"=>$amend_status,
                             "modified_by"=>$this->user->user_id,
                             "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('reason_id', $amend_code);
               $this->db->update('pmd_amend_reason', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   //Amendment Type
   public function CreateAmendmentType(){
       $type_name=strtoupper($this->input->post('type_name'));
       if($type_name){
           $condition="type_name='".$type_name."'";
           if($this->IsDuplicate('pmd_amendtype',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $type_code = $this->GetPrimaryId("AMT_CODE");
               $data=array("type_code"=>$type_code,
                           "type_name"=>$type_name,
                           "created_by"=>$this->user->user_id,
                           "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_amendtype',$data);
               $this->UpdatePrimaryId($type_code, "AMT_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function AmendmentTypeList(){
       $qury="SELECT
                    type_code,
                    type_name,
                    cancel_flag 
             FROM 
                    pmd_amendtype";
       return $this->db->query($qury)->result();
   }
   public function ViewAmendmentType(){
       $amt_code = $this->input->post('typeCode');
       $qury="SELECT
                    type_code,
                    type_name,
                    cancel_flag
             FROM
                    pmd_amendtype
            WHERE
                    type_code='".$amt_code."'";
       return $this->db->query($qury)->row();
   }
   public function UpdateAmendmentType(){
       $amend_code = $this->input->post('typeCode');
       $amend_name = strtoupper($this->input->post('typeName'));
       $amend_status = $this->input->post('typeStatus');
       if($amend_code && $amend_name){
           $condition="type_name='".$amend_name."' AND type_code!='".$amend_code."'";
           if($this->IsDuplicate('pmd_amendtype',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("type_code"=>$amend_code,
                             "type_name"=>$amend_name,
                             "cancel_flag"=>$amend_status,
                             "modified_by"=>$this->user->user_id,
                             "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('type_code', $amend_code);
               $this->db->update('pmd_amendtype', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   //Wellwisher
   public function CreateWellWisher(){
       $well_name = strtoupper($this->input->post('well_name'));
       $well_phone = $this->input->post('well_phn');
       $well_location = strtoupper($this->input->post('well_location'));
       $well_remark = strtoupper($this->input->post('well_remark'));
       if($well_name){
           $condition="well_name='".$well_name."'";
           if($this->IsDuplicate('pmd_wellwisher',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               
               $this->db->trans_begin();
               $wellwisher_code = $this->GetPrimaryId("WELL_".$this->user->user_unit_code."_CODE");
               $data=array("well_code"=>$wellwisher_code,
                           "well_name"=>$well_name,
                           "well_phone"=>$well_phone,
                           "well_location"=>$well_location,
                           "well_remarks"=>$well_remark,
                           "well_unit"=>$this->user->user_unit_code,
                           "cancel_flag"=>0,
                           "created_by"=>$this->user->user_id,
                           "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_wellwisher',$data);
               $this->UpdatePrimaryId($wellwisher_code, "WELL_".$this->user->user_unit_code."_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function WellWisherList(){
       $qury = "SELECT
                        well_code,well_unit,
                        well_name,
                        well_phone,
                        well_location,
                        well_remarks,
                        cancel_flag 
                FROM 
                       pmd_wellwisher
                WHERE
                       well_unit='".$this->user->user_unit_code."'";
       return $this->db->query($qury)->result();
   }
   public function ViewWellWisher(){
       $wisher_code= $this->input->post('wellCode');
       $qury = "SELECT
                        well_code,
                        well_unit,
                        well_name,
                        well_phone,
                        well_location,
                        well_remarks,
                        cancel_flag
                FROM
                       pmd_wellwisher
                WHERE
                       well_code='".$wisher_code."' AND well_unit='".$this->user->user_unit_code."'";
       return $this->db->query($qury)->row();
   }
   public function UpdateWellWisher(){
       $whiser_code = $this->input->post('welCode');
       $wisher_name = strtoupper($this->input->post('welName'));
       $wisher_phn = $this->input->post('welPhn');
       $wisher_loc = strtoupper($this->input->post('welLoc'));
       $wisher_remark = strtoupper($this->input->post('welRemark'));
       $wisher_status = $this->input->post('welStatus');
       if($whiser_code && $wisher_name){
           $condition="well_name='".$wisher_name."' AND well_code!='".$whiser_code."'";
           if($this->IsDuplicate('pmd_wellwisher',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $data = array("well_code"=>$whiser_code,
                              "well_unit"=>$this->user->user_unit_code,
                              "well_name"=>$wisher_name,
                              "well_phone"=>$wisher_phn,
                              "well_location"=>$wisher_loc,
                              "well_remarks"=>$wisher_remark,
                              "cancel_flag"=>$wisher_status,
                              "modified_by"=>$this->user->user_id,
                              "modified_date"=>date('Y-m-d H:i:s'));
               $this->db->where('well_code', $whiser_code);
               $this->db->update('pmd_wellwisher', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   //Response
   public function CreateResponse(){
       $response_head = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('response_head'))));
       $response_unit = $this->input->post('unit');
       if($this->isDuplicate("pmd_crmresponse","res_desc='".$response_head."' AND res_ag_flag='".$response_unit."'"))
       {
           $this->Message->status=400;
           $this->Message->text="Response head already exist";
       }
       else
       {
           $this->db->trans_start();
           $created_by  = $this->user->user_id;
           $currentDate = date('Y-m-d H:i:s');
           $response_code = $this->getPrimaryId('RESPONSE_CODE');
           $data = array(
               'res_code' => $response_code,
               'res_desc' => strtoupper($response_head),
               'res_ag_flag' => $response_unit,
               'res_cancel_flag' => '0',
               'created_by' => $created_by,
               'created_date' => $currentDate
               );
           $this->db->insert('pmd_crmresponse', $data);
           $this->db->trans_complete();
           if($this->db->trans_status() === TRUE)
           {
               $this->updatePrimaryId($response_code, 'RESPONSE_CODE');
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
   public function ResponseList(){
       $sql = "SELECT res_code,res_desc ,res_ag_flag FROM pmd_crmresponse WHERE res_cancel_flag = 0 ORDER BY res_ag_flag,res_code";
       $result_set = $this->db->query($sql);
       return $result_set->result();
   }
   public function UpdateResponse(){
       $modified_by  = $this->user->user_id;
       $modified_Date = date('Y-m-d H:i:s');
       $Code=$this->input->post('Code');
       $head=trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('head'))));
       if($this->isDuplicate("pmd_crmresponse","res_desc='".$head."'"))
       {
           $this->Message->status=400;
           $this->Message->text="Response head already exist";
       }
       else
       {
           if($head)
           {
               $sql="UPDATE pmd_crmresponse SET res_desc='".strtoupper($head)."', modified_by='".$modified_by."', modified_date='".$modified_Date."' WHERE res_code  = '".$Code."'";
               $this->db->query($sql);
               if($this->db->affected_rows() > 0)
               {
                   $this->Message->status=200;
                   $this->Message->text=$this->lang->line('added_success');
               }
               else
               {
                   $this->Message->status=400;
                   $this->Message->text="Updating failed";
               }
           }
           else
           {
               $this->Message->status=400;
               $this->Message->text="Updated field cann't be empty";
           }
       }
       return $this->Message;
   }
   //Entry Status 
   public function CreateEntryStatus(){
       $status_head = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('status_head'))));
       $status_dept=$this->input->post('department');
       if($this->isDuplicate("pmd_crmstatus","status_name='".$status_head."' AND status_dept_code='".$status_dept."'"))
       {
           $this->Message->status=400;
           $this->Message->text="Status head already exist";
       }
       else
       {
           $this->db->trans_start();
           $created_by  = $this->user->user_id;
           $currentDate = date('Y-m-d H:i:s');
           $status_code = $this->getPrimaryId('STATUS_CODE');
           $data = array(
               'status_code' => $status_code,
               'status_name' => strtoupper($status_head),
               'status_cancel_flag' => '0',
               'status_dept_code'=> $status_dept,
               'created_by' => $created_by,
               'created_date' => $currentDate
               );
           $this->db->insert('pmd_crmstatus', $data);
           $this->db->trans_complete();
           if($this->db->trans_status() === TRUE)
           {
               $this->updatePrimaryId($status_code, 'STATUS_CODE');
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
   public function EntryStatusList(){
       $sql = "SELECT
                    status_code, status_name, status_dept_code
                FROM
                    pmd_crmstatus
                WHERE
                    status_cancel_flag = 0
                ORDER BY status_dept_code , status_code";
       $result_set = $this->db->query($sql);
       return $result_set->result();
   }
   public function UpdateEntryStatus(){
       $modified_by  = $this->user->user_id;
       $modified_Date = date('Y-m-d H:i:s');
       $Code=$this->input->post('Code');
       $head=trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('head'))));
       if($this->isDuplicate("pmd_crmstatus","status_name='".$head."'"))
       {
           $this->Message->status=400;
           $this->Message->text="Status head already exist";
       }
       else
       {
           if($head)
           {
               $sql="UPDATE pmd_crmstatus SET status_name='".strtoupper($head)."', modified_by='".$modified_by."', modified_date='".$modified_Date."' WHERE status_code  = '".$Code."'";
               $this->db->query($sql);
               if($this->db->affected_rows() > 0)
               {
                   $this->Message->status=200;
                   $this->Message->text=$this->lang->line('added_success');
               }
               else
               {
                   $this->Message->status=400;
                   $this->Message->text="Updating failed";
               }
           }
       }
       return $this->Message;
   }
   //Sponsor
   public function CreateSponsor(){
       $sponsor_name=strtoupper($this->input->post('sponsor_name'));
       $sponsor_address=strtoupper($this->input->post('sponsor_address'));
       $sponsor_phn=$this->input->post('sponsor_phn');
       if($sponsor_name){
           $condition="client_name='".$sponsor_name."'";
           if($this->IsDuplicate('pmd_spons_client',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $sponsor_code = $this->GetPrimaryId("SP_".$this->user->user_unit_code."_CODE");
               $data=array("unit_code"=>$this->user->user_unit_code,
                   "client_code"=>$sponsor_code,
                   "client_name"=>$sponsor_name,
                   "client_address"=>$sponsor_address,
                   "client_phone"=>$sponsor_phn,
                   "cancel_flag"=>0,
                   "created_by"=>$this->user->user_id,
                   "created_date"=>date('Y-m-d'));
               $this->db->insert('pmd_spons_client',$data);
               $this->UpdatePrimaryId($sponsor_code, "SP_".$this->user->user_unit_code."_CODE");
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function SponsorList(){
       $qury = "SELECT
                    unit_code,
                    client_code,
                    client_name,
                    client_address,
                    client_phone,
                    cancel_flag 
                FROM 
                    pmd_spons_client";
       return $this->db->query($qury)->result();
   }
   public function ViewSponsor(){
       $cient_code = $this->input->post('clientCode');
       $qury = "SELECT
                    unit_code,
                    client_code,
                    client_name,
                    client_address,
                    client_phone,
                    cancel_flag
                FROM
                    pmd_spons_client
                WHERE
                    client_code = '".$cient_code."'";
       return $this->db->query($qury)->row();
   }
   public function UpdateSponsor(){
       $client_code = $this->input->post('spCode');
       $client_name = strtoupper($this->input->post('spName'));
       $client_addr = strtoupper($this->input->post('spAddress'));
       $client_mob = $this->input->post('spPhn');
       $client_status = $this->input->post('spStatus');
       if($client_code && $client_name){
           $condition="client_name='".$client_name."' AND client_code!='".$client_code."'";
           if($this->IsDuplicate('pmd_spons_client',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $data=array("unit_code"=>$this->user->user_unit_code,
                   "client_code"=>$client_code,
                   "client_name"=>$client_name,
                   "client_address"=>$client_addr,
                   "client_phone"=>$client_mob,
                   "cancel_flag"=>$client_status,
                   "modified_by"=>$this->user->user_id,
                   "modified_date"=>date('Y-m-d'));
               $this->db->where('client_code', $client_code);
               $this->db->update('pmd_spons_client', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
   public function CreateBankMaster(){
       $bank_name = strtoupper($this->input->post('bank_name'));
       $bank_location = strtoupper($this->input->post('bank_loc'));
       $condition= "bank_name='".$bank_name."' AND bank_location='".$bank_location."'";
       if($this->IsDuplicate('pmd_bankmaster',$condition))
       {
           $this->Message->status=400;
           $this->Message->text="Name Already Exists!";
           return $this->Message;
       }

       $this->db->trans_begin();
       $bank_code = $this->GetPrimaryId("BNK_CODE");
       $data=array("bank_code"=>$bank_code,
           "bank_name"=>$bank_name,
           "bank_location"=>$bank_location,
           "bank_disabled"=>0,
           "created_time"=>date('H:i:s'),
           "created_by"=>$this->user->user_id,
           "created_date"=>date('Y-m-d'));
       $this->db->insert('pmd_bankmaster',$data);
       $this->UpdatePrimaryId($bank_code, "BNK_CODE");
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
       return $this->Message;
   }
   public function GetBankDetails(){
       $qry = "SELECT
                    bank_code,
                    bank_name,
                    bank_location 
               FROM 
                    pmd_bankmaster";
       return $this->db->query($qry)->result();
   }
   public function ViewBankMaster(){
       $bnk_code = $this->input->post('bnktCode');
       $qry = "SELECT
                    bank_code,
                    bank_name,
                    bank_location,
                    bank_disabled
               FROM
                    pmd_bankmaster
                WHERE
                    bank_code = '".$bnk_code."'";
       return $this->db->query($qry)->row();
   }
   public function UpdateBankMaster(){
     $bank_code = $this->input->post('bnkCode');
       $bank_name = strtoupper($this->input->post('bnkName'));
       $bank_loc = strtoupper($this->input->post('bnkLoc'));
       $bnk_status = $this->input->post('bnkStatus');
       if($bank_name && $bank_loc && $bank_code){
           $condition="bank_name='".$bank_name."' AND bank_code!='".$bank_code."'";
           if($this->IsDuplicate('pmd_bankmaster',$condition))
           {
               $this->Message->status=400;
               $this->Message->text="Name Already Exists!";
           }
           else
           {
               $this->db->trans_begin();
               $data=array("bank_code"=>$bank_code,
                   "bank_name"=>$bank_name,
                   "bank_location"=>$bank_loc,
                   "created_time"=>date('H:i:s'),
                   "bank_disabled"=>$bnk_status,
                   "modified_by"=>$this->user->user_id,
                   "modified_date"=>date('Y-m-d'));
               $this->db->where('bank_code', $bank_code);
               $this->db->update('pmd_bankmaster', $data);
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
       }else{
           $this->Message->status=400;
           $this->Message->text=$this->lang->line('params_missing');
       }
       return $this->Message;
   }
}