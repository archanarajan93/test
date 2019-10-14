<?php
class CRMModel extends CI_Model 
{
	public function __construct() {
		parent::__construct();
	}
    private $entry_type = array(
       "Incoming"=>0,
       "Outgoing" => 1,
       "Action" => 2);
    private $customer = array(
        "Subscriber"=>0,
        "Agent" => 1,
        "General" => 2);
    private $department = array(
        "PMD"=>0,
        "SMD" => 1,
        "EDT" => 2);
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

   //Create
    public function SaveCRM($data)
    {
        $crm_data = $trans_data = array();
        $unit_record   = json_decode(rawurldecode($data["unit_rec"]), true);
        $product_record   = json_decode(rawurldecode($data["product_rec"]), true);
        $customer_type = $data["customer"];
        $status_record = json_decode(rawurldecode($this->input->post('status_record',true)));
        $stats_len     = count($status_record)-1;
        $customer_id   = $customer_name = $customer_addr = $customer_phone = $scheme_code = $fs_code = $fs_name = $cus_ag_code = $cus_ag_name = $cus_ag_phone = null;
        $scheme_type = $scheme_code= $scheme_name = $crm_res_code = $crm_entry_status = $scheme_slno = $scheme_enddate = null;
        $crm_level = 1; $crm_final_flag = 0; $crm_init_res_code=null;$crm_init_entry_status=null;
        if($customer_type == 'Subscriber')
        {
            $sub_record = json_decode(rawurldecode($data["customer_rec"]),true);
            $customer_id  = $sub_record['Code'];
            $customer_name = $sub_record['Name'];
            $customer_addr = $sub_record['Address'];
            $customer_phone = $this->input->post('sub_contact',true);
            $cus_ag_code = $sub_record['AgentCode'];
            $cus_ag_name = $sub_record['Agent Name'];
            $cus_ag_phone = $sub_record['Agent Phone'];
            $scheme_record = json_decode(rawurldecode($this->input->post('scheme_rec_sel')));
            $scheme_type = $scheme_record->sch_type;
            $scheme_code = $scheme_record->Code;
            $scheme_name = $scheme_record->Name;
            $scheme_slno = $scheme_record->SchemeSlNo;
            $scheme_enddate = $scheme_record->SchemeEndDate;
            $fs_code = $this->input->post('sub_executive_code',true);
            $fs_name = $this->input->post('sub_executive',true);
        }
        else if($customer_type == 'Agent')
        {
            $agent_record = json_decode(rawurldecode($data["customer_rec"]),true);
            $customer_id    = $agent_record['Code'];
            $customer_name  = $agent_record['Name'];
            $customer_addr  = $agent_record['Address'];
            $customer_phone = $this->input->post('agent_contact',true);
            $fs_code = $this->input->post('agent_executive_code',true);
            $fs_name = $this->input->post('agent_executive',true);
        }else{
            $customer_name  = $this->input->post('gen_name',true);
            $customer_addr  = $this->input->post('gen_addr',true);
            $customer_phone = $this->input->post('gen_contact',true);
        }

        $this->db->trans_begin();
        $trans_code    = $this->getPrimaryId("TRANS_".$this->user->user_unit_code."_CODE");
        $token_no      = $this->getPrimaryId("TOKEN_".$this->user->user_unit_code."_CODE");
        $crm_data = array(
               'unit_code' => $unit_record['UNIT'],
               'token_no' => $token_no,
               'crm_cust_type' => $this->customer[$customer_type],
               'crm_scheme_slno' => $scheme_slno,
               'sch_scheme_enddate' => $scheme_enddate,
               'crm_cust_id' => $customer_id,
               'crm_name' => $customer_name,
               'crm_address' => $customer_addr,
               'crm_phone' => $customer_phone,
               'crm_scheme_type' => $scheme_type,
               'crm_scheme_code' => $scheme_code,
               'crm_scheme_name' => $scheme_name,
               'crm_fs_code' => $fs_code,
               'crm_fs_name' => $fs_name,
               'crm_ag_code' => $cus_ag_code,
               'crm_ag_name' => $cus_ag_name,
               'crm_ag_phone' => $cus_ag_phone,
               'crm_pdt_code' => $product_record['Code'],
               'crm_dept_code' => $this->department[$this->input->post('dept')],
               'created_by' => $this->user->user_id,
               'created_date' => date("Y-m-d H:i:s"),
               'updated_by' => $this->user->user_id,
               'updated_date' => date("Y-m-d H:i:s")
            );
        if(0 <= $stats_len)
        {
            for($index=0; $index<=$stats_len; $index++)
            {
                $crm_level = $index+1;
                if($index == 0) {
                    $crm_init_entry_status = $status_record[$index]->status;
                    $crm_init_res_code = $status_record[$index]->head;
                }
                if($index == $stats_len){
                    $crm_final_flag = 1;
                    $crm_res_code = $status_record[$index]->head;
                    $crm_entry_status = $status_record[$index]->status;
                }
                $trans_data[] =array(
                            'unit_code' => $unit_record['UNIT'],
                            'trans_token_no' => $token_no,
                            'trans_no' => $trans_code,
                            'trans_entry_type' => $this->entry_type[$status_record[$index]->type],
                            'trans_res_code' => $status_record[$index]->head,
                            'trans_response' => strtoupper($status_record[$index]->remark),
                            'trans_entry_status' => $status_record[$index]->status,
                            'trans_level' => $crm_level,
                            'trans_final_flag' => $crm_final_flag,
                            'created_by' => $this->user->user_id,
                            'created_date' => date('Y-m-d H:i:s')
                            );
                $trans_code = $this->autoIncrement($trans_code);
            }
        }
        $crm_data['crm_level'] = $crm_level;
        $crm_data['crm_final_flag'] = $crm_final_flag;
        $crm_data['crm_res_code'] = $crm_res_code;
        $crm_data['crm_init_entry_status'] = $crm_init_entry_status;
        $crm_data['crm_init_res_code'] = $crm_init_res_code;
        $crm_data['crm_entry_status'] = $crm_entry_status;
        $this->db->insert("pmd_crmmaster", $crm_data);
        if($trans_data) $this->db->insert_batch("pmd_crmtrans", $trans_data);
        $this->updatePrimaryId($token_no, "TOKEN_".$this->user->user_unit_code."_CODE");
        $this->updatePrimaryId($trans_code, "TRANS_".$this->user->user_unit_code."_CODE");
        //$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        else
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('saved_success');
        }
        return $this->Message;
    }
    public function GetCRMDetailed($token_no)
    {
        $response = array("crm"=>array(),"status"=>array());
        $sql1 = "SELECT
                    token_no,
                    DATE_FORMAT(t1.created_date, '%d-%b-%Y %h:%i %p') token_date,
                    crm_cust_type,
                    t1.unit_code,
                    crm_pdt_code,
                    crm_dept_code,
                    crm_cust_id,
                    crm_name,
                    crm_address,
                    crm_phone,
                    crm_scheme_type,
                    crm_scheme_code,
                    crm_scheme_name,
                    crm_fs_code,
                    crm_fs_name,
                    user_emp_name,
                    crm_ag_code,
                    crm_ag_name,
                    crm_ag_phone,
                    crm_scheme_slno,
                    sch_scheme_enddate
                FROM
                    pmd_crmmaster t1
                     INNER JOIN
                    pmd_userdetails t2 ON t1.created_by=t2.user_id
                WHERE token_no = '".$token_no."'";
        $sql2 = "SELECT
                    trans_no,
                    trans_token_no,
                    trans_entry_type,
                    trans_res_code,
                    trans_response,
                    trans_entry_status,
                    t1.created_by,
                    user_emp_name,
                    res_desc,
                    status_name,
                    trans_level,
                    trans_final_flag,
                    DATE_FORMAT(t1.created_date, '%d-%b-%Y %h:%i %p') created_at
                FROM
                    pmd_crmtrans t1
                    INNER JOIN
                    pmd_crmstatus t2 ON t1.trans_entry_status = t2.status_code
                    LEFT JOIN
                    pmd_crmresponse t3 ON t1.trans_res_code = t3.res_code
                    INNER JOIN
                    pmd_userdetails t4 ON t1.created_by=t4.user_id
                WHERE t1.trans_token_no = '".$token_no."' ORDER BY trans_level,t1.created_date";
        $response["crm"] = $this->db->query($sql1)->row();
        $response["status"] = $this->db->query($sql2)->result();
        return $response;
    }
    public function updateCRM($post_data)
    {
        $crm_data          =  array();
        $token_no          = $post_data["token_no"];
        $unit_record       = json_decode(rawurldecode($post_data["unit_rec"]), true);
        $product_record    = json_decode(rawurldecode($post_data["product_rec"]), true);
        $customer_type     = $post_data["customer"];
        $customer_id   = $customer_name = $customer_addr = $customer_phone = $scheme_code = $fs_code = $fs_name = $cus_ag_code = $cus_ag_name = $cus_ag_phone = null;
        $scheme_type = $scheme_code= $scheme_name = $scheme_slno = $scheme_enddate = null;
        if($customer_type == 'Subscriber')
        {
            $sub_record = json_decode(rawurldecode($post_data["customer_rec"]),true);
            $customer_id  = $sub_record['Code'];
            $customer_name = $sub_record['Name'];
            $customer_addr = $sub_record['Address'];
            $customer_phone = $this->input->post('sub_contact',true);
            $scheme_record = json_decode(rawurldecode($this->input->post('scheme_rec_sel')));
            $cus_ag_code = $sub_record['AgentCode'];
            $cus_ag_name = $sub_record['Agent Name'];
            $cus_ag_phone = $sub_record['Agent Phone'];
            $scheme_type = $scheme_record->sch_type;
            $scheme_code = $scheme_record->Code;
            $scheme_name = $scheme_record->Name;
            $scheme_slno = $scheme_record->SchemeSlNo;
            $scheme_enddate = $scheme_record->SchemeEndDate;
            $fs_code = $this->input->post('sub_executive_code',true);
            $fs_name = $this->input->post('sub_executive',true);
        }
        else if($customer_type == 'Agent')
        {
            $agent_record = json_decode(rawurldecode($post_data["customer_rec"]),true);
            $customer_id    = $agent_record['Code'];
            $customer_name  = $agent_record['Name'];
            $customer_addr  = $agent_record['Address'];
            $customer_phone = $this->input->post('agent_contact',true);
            $fs_code = $this->input->post('agent_executive_code',true);
            $fs_name = $this->input->post('agent_executive',true);
        }else{
            $customer_name  = $this->input->post('gen_name',true);
            $customer_addr  = $this->input->post('gen_addr',true);
            $customer_phone = $this->input->post('gen_contact',true);
        }

        $this->db->trans_begin();
        $crm_data = array(
               'unit_code' => $unit_record['UNIT'],
               'crm_cust_type' => $this->customer[$customer_type],
               'crm_scheme_slno' => $scheme_slno,
               'sch_scheme_enddate' => $scheme_enddate,
               'crm_cust_id' => $customer_id,
               'crm_name' => $customer_name,
               'crm_address' => $customer_addr,
               'crm_phone' => $customer_phone,
               'crm_scheme_type' => $scheme_type,
               'crm_scheme_code' => $scheme_code,
               'crm_scheme_name' => $scheme_name,
               'crm_fs_code' => $fs_code,
               'crm_fs_name' => $fs_name,
               'crm_ag_code' => $cus_ag_code,
               'crm_ag_name' => $cus_ag_name,
               'crm_ag_phone' => $cus_ag_phone,
               'crm_pdt_code' => $product_record['Code'],
               'crm_dept_code' => $this->department[$this->input->post('dept')],
               'modified_by' => $this->user->user_id,
               'modified_date' => date("Y-m-d H:i:s")
            );
        $this->db->where('token_no', $token_no);
        $this->db->update("pmd_crmmaster", $crm_data);

        //update trans unitcode
        $crm_trans_data = array(
              'unit_code' => $unit_record['UNIT'],
              'modified_by' => $this->user->user_id,
              'modified_date' => date("Y-m-d H:i:s")
           );
        $this->db->where('trans_token_no', $token_no);
        $this->db->update("pmd_crmtrans", $crm_trans_data);

        //$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        else
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        return $this->Message;
    }
    public function getCRMResults()
    {
        $where_condition ='';
        $token_no = $this->input->post('token_no',true);
        $from_date = $this->input->post('from_date',true);
        $to_date = $this->input->post('to_date',true);
        $cus_name = $this->input->post('cus_name',true);
        $cus_phone = $this->input->post('cus_phone',true);
        $unit_record = $this->input->post('unit_rec_sel',true);
        $pdt_record = $this->input->post('product_rec_sel',true);
        $agent_record = $this->input->post('agent_rec_sel',true);
        if(!empty($token_no)){
            $where_condition .= "AND t1.`token_no` LIKE '%".$token_no."%'";
        }
        if(!empty($from_date)){
            $where_condition .= "AND DATE(t1.`created_date`) >='".date("Y-m-d", strtotime($from_date))."'";
        }
        if(!empty($to_date)){
            $where_condition .= "AND DATE(t1.`created_date`) <='".date("Y-m-d", strtotime($to_date))."'";
        }
        if(!empty($cus_name)){
            $where_condition .= "AND t1.`crm_name` LIKE '%".$cus_name."%'";
        }
        if(!empty($cus_phone)){
            $where_condition .= "AND t1.`crm_phone` LIKE '%".$cus_phone."%'";
        }
        if(!empty($unit_record)){
            $unit_record = json_decode(rawurldecode($unit_record));
            $where_condition .= "AND t1.`unit_code`='".$unit_record->UNIT."'";
        }
        if(!empty($pdt_record)){
            $pdt_record = json_decode(rawurldecode($pdt_record));
            $where_condition .= "AND t1.`crm_pdt_code`='".$pdt_record->Code."'";
        }
        if(!empty($agent_record)){
            $agent_record = json_decode(rawurldecode($agent_record));
            $where_condition .= "AND t1.`crm_cust_id`='".$agent_record->Code."'";
        }
        $sql = "SELECT
                    token_no,
                    DATE_FORMAT(t1.created_date, '%d-%b-%Y') token_date,
                    t1.unit_code,
                    t1.crm_pdt_code,
                    t1.crm_dept_code,
                    t1.crm_name,
                    t1.crm_address,
                    t1.crm_phone,
                    t1.crm_scheme_code,
                    t1.crm_scheme_name,
                    t2.res_desc,
                    t3.status_name,
		    t4.user_login_name,
                    t4.user_emp_name,
		    DATE_FORMAT(t1.created_date, '%d-%b-%Y %h:%i %p') created_at
                FROM
                    pmd_crmmaster t1
                    LEFT JOIN
                    pmd_crmresponse t2 ON t1.crm_res_code = t2.res_code
                    LEFT JOIN
                    pmd_crmstatus t3 ON t1.crm_entry_status = t3.status_code
					LEFT JOIN
                    pmd_userdetails t4 ON t1.created_by=t4.user_id
                WHERE 1=1 ".$where_condition." ORDER BY token_no";
        return $this->db->query($sql)->result();
    }
    public function saveCRMStatus()
    {
        $token_no          = $this->input->post('token_no');
        $level             = $this->input->post('level');
        $entry_status      = $this->input->post('entry_status');
        $res_code          = $this->input->post('res_code') ? $this->input->post('res_code') : null;
        $crm_data = array(
               'token_no' => $token_no,
               'crm_level' => $level,
               'crm_final_flag' => 1,
               'crm_res_code' => $res_code,
               'crm_entry_status' => $entry_status,
               'updated_by' => $this->user->user_id,
               'updated_date' => date("Y-m-d H:i:s")
            );
        if($level == '1') {
            $crm_data['crm_init_entry_status'] = $entry_status;
            $crm_data['crm_init_res_code'] = $res_code;
        }
        $trans_data =array(
              'trans_final_flag' => 0
              );
        $this->db->trans_begin();
        $trans_code  = $this->getPrimaryId("TRANS_".$this->user->user_unit_code."_CODE");
        $trans_new = array(
              'unit_code' => $this->input->post('unit_code'),
              'trans_token_no' => $token_no,
              'trans_no' => $trans_code,
              'trans_entry_type' => $this->entry_type[$this->input->post('entry_type')],
              'trans_res_code' => $res_code,
              'trans_response' => strtoupper($this->input->post('remark')),
              'trans_entry_status' => $entry_status,
              'trans_level' => $level,
              'trans_final_flag' => 1,
              'created_by' => $this->user->user_id,
              'created_date' => date('Y-m-d H:i:s')
              );
        $this->db->where_in('token_no', $token_no);
        $this->db->update('pmd_crmmaster', $crm_data);
        $this->db->where_in('trans_token_no', $token_no);
        $this->db->update('pmd_crmtrans', $trans_data);
        $this->db->insert('pmd_crmtrans', $trans_new);
        $this->updatePrimaryId($trans_code, "TRANS_".$this->user->user_unit_code."_CODE");
        //$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        else
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        return $this->Message;
    }
    public function updateCRMStatus()
    {

        $token_no=$this->input->post('token_no');
        $trans_no=$this->input->post('trans_code');
        $remarks=$this->input->post('remarks');
        $final_flag=$this->input->post('final');
        $level = $this->input->post('level');
        $status_record=json_decode(rawurldecode($this->input->post('status',true)));
        $response_record=json_decode(rawurldecode($this->input->post('response',true)));
        $this->db->trans_begin();
        if($final_flag=='1')
        {
            $crm_data = array(
                   'crm_res_code' => isset($response_record) ? $response_record->Code : null,
                   'crm_entry_status' => $status_record->Code,
                   'updated_by' => $this->user->user_id,
                   'updated_date' => date("Y-m-d H:i:s")
                );
            if($level == '1') {
                $crm_data['crm_init_res_code'] = isset($response_record) ? $response_record->Code : null;
                $crm_data['crm_init_entry_status'] = isset($status_record) ? $status_record->Code : null;
            }
            $this->db->where('token_no', $token_no);
            $this->db->update('pmd_crmmaster', $crm_data);
        }
        else if($level == '1'){
            $crm_data = array(
                   'crm_init_res_code' => isset($response_record) ? $response_record->Code : null,
                   'crm_init_entry_status' => isset($status_record) ? $status_record->Code : null,
                   'updated_by' => $this->user->user_id,
                   'updated_date' => date("Y-m-d H:i:s")
                );
            $this->db->where('token_no', $token_no);
            $this->db->update('pmd_crmmaster', $crm_data);
        }
        $trans_data = array(
              'trans_entry_type' =>  $this->entry_type[$this->input->post('entry_type')] ,
              'trans_res_code' => isset($response_record) ? $response_record->Code : null,
              'trans_response' => $remarks,
              'trans_entry_status' => $status_record->Code,
              'trans_final_flag' => $final_flag,
              'modified_by' => $this->user->user_id,
              'modified_date' => date('Y-m-d H:i:s')
              );

        $this->db->where('trans_no', $trans_no);
        $this->db->update('pmd_crmtrans', $trans_data);

        //$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        else
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
        }
        return $this->Message;
    }
    //Approve
    public function EnrollLists() {

        $copy_type_rec  = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $copy_type      = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;

        $subscriber_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $subscriber     = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;

        $agent_rec      = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $agent_code     = isset($agent_rec['Code']) ? $agent_rec['Code'] : null;
        $agent_slno     = isset($agent_rec['SerialNumber']) ? $agent_rec['SerialNumber'] : null;

        $date_type      = $this->input->post('date_type',true);
        $date_from      = date('Y-m-d',strtotime($this->input->post('date_from',true)));
        $date_to        = date('Y-m-d',strtotime($this->input->post('date_to',true)));

        //$sales_status   = (int)$this->input->post('sale_status',true);
        $sales_type     = (int)$this->input->post('sales_type',true);


        $where = "";

        if($copy_type) {
            $where .= " AND SL.sales_copy_type = '".$copy_type."' ";
        }

        if($subscriber) {
            $where .= " AND SL.sales_sub_code = '".$subscriber."' ";
        }

        if($agent_code) {
            $where .= " AND SL.sales_agent_code = '".$agent_code."' ";
        }

        if($agent_slno) {
            $where .= " AND SL.sales_agent_slno = '".$agent_slno."' ";
        }

        if($date_from && $date_type) {
            $where .= " AND DATE(SL.".$date_type.") >= '".$date_from."' ";
        }

        if($date_from && $date_type) {
            $where .= " AND DATE(SL.".$date_type.") <= '".$date_to."' ";
        }

        if($sales_type) {
            $where .= " AND SL.sales_type = '".$sales_type."' ";
        }
        //if($sales_status >= 0) {  //-1 for All
        //    $where .= " AND SL.sales_status = '".$sales_status."' ";
        //}
        //$where .= " AND SL.sales_status != '". EnrollStatus::Started ."' ";
        $where .= " AND SL.sales_status NOT IN ('".EnrollStatus::Approved."','".EnrollStatus::Rejected."') ";
                
        $qry = "SELECT
                    SL.sales_code,
                    CT.copytype_name,
                    SB.sub_name,
                    SB.sub_address,
                    SB.sub_phone,
                    SL.sales_copies,
                    SL.sales_start_date,
                    SL.sales_end_flag,
                    SL.sales_end_date,
                    SL.created_date,
                    SL.sales_can_date,
                    AG.agent_code,
                    AG.agent_name,
                    AG.cancel_flag,
                    SL.sales_remarks,                                        
                    SL.sales_can_name,
                    IF(SL.sales_can_by = 1, (SELECT user_emp_dept FROM pmd_userdetails WHERE user_emp_id = SL.sales_can_code LIMIT 1),NULL) sales_can_dept,
                    SL.sales_service_name,
                    SL.sales_status,
                    SL.sales_type,
                    IF(SL.sales_crm_by IS NULL, NULL, (SELECT user_emp_name FROM pmd_userdetails WHERE user_id = SL.sales_crm_by LIMIT 1)) AS sales_crm_by,                    
                    SL.sales_crm_date,
                    SL.sales_crm_comment,
                    IF(SL.sales_crc_by IS NULL, NULL, (SELECT user_emp_name FROM pmd_userdetails WHERE user_id = SL.sales_crc_by LIMIT 1)) AS sales_crc_by,
                    SL.sales_crc_date,
                    SL.sales_crc_comment
                FROM
                    pmd_sales SL
                JOIN
                    pmd_copytype CT ON (CT.copytype_code = SL.sales_copy_type AND CT.copy_code = 'CP0001')
                JOIN
                    pmd_subscriber SB ON (SB.sub_code = SL.sales_sub_code AND SB.sub_unit_code = '".$this->user->user_unit_code."')
                JOIN
                    pmd_agent AG ON (AG.agent_slno = SL.sales_agent_slno AND AG.agent_code = SL.sales_agent_code AND AG.agent_unit = '".$this->user->user_unit_code."')
                WHERE
                    SL.unit_code = '".$this->user->user_unit_code."' ".$where;
        return $this->db->query($qry)->result();
    }
    public function ViewEnrollLists($sales_code) {
        $qry = "SELECT
                    SL.sales_reg_no,
                    SL.sales_copy_type,
                    CT.copytype_name,
                    SB.sub_code,
                    SL.sales_sub_code,
                    SB.sub_name,
                    SL.sales_agent_code,
                    SL.sales_agent_slno,
                    AG.agent_name,
                    AG.agent_location,
                    SL.sales_can_by,
                    SL.sales_can_code,
                    SL.sales_can_name,
                    SL.sales_can_date,
                    SL.sales_service_by,
                    SL.sales_service_code,
                    SL.sales_service_name,
                    SL.sales_wel_by,
                    SL.sales_wel_code,
                    SL.sales_wel_name,
                    SL.sales_wel_contact,
                    SL.sales_wel_loc,
                    SL.sales_start_date,
                    SL.sales_end_flag,
                    SL.sales_end_date,
                    SL.sales_copies,
                    SL.sales_remarks,
                    SL.sales_type,
                    P.promoter_name,
                    E.edition_name,
                    SL.sales_reason,
                    RE.reason_name,
                    SL.sales_status
                    FROM
                        pmd_sales SL
                    JOIN
                        pmd_copytype CT ON (CT.copytype_code = SL.sales_copy_type AND CT.copy_code = 'CP0001')
                    JOIN
                        pmd_subscriber SB ON (SB.sub_code = SL.sales_sub_code AND SB.sub_unit_code = '".$this->user->user_unit_code."')
                    JOIN
                        pmd_edition E ON (E.edition_code = SB.sub_edition AND E.edition_unit = SB.sub_unit_code)
                    JOIN
                        pmd_agent AG ON (AG.agent_slno = SL.sales_agent_slno AND AG.agent_code = SL.sales_agent_code AND AG.agent_unit = '".$this->user->user_unit_code."')
                    JOIN
                        pmd_promoter P ON P.promoter_code = (SELECT agent_promoter FROM pmd_agentdetails WHERE agent_code = AG.agent_code AND agent_slno = AG.agent_slno AND agent_product_code = '".$this->user->user_product_code."' LIMIT 1)
                    LEFT JOIN
                        pmd_amend_reason RE ON RE.reason_id = SL.sales_reason
                    WHERE
                        sales_code = '".$sales_code."' AND SL.unit_code = '".$this->user->user_unit_code."'
                    LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function AddComments() {
        $sales_comment  = $this->input->post('sales_comment',true);
        $sales_code     = $this->input->post('sales_code',true);
        if($sales_comment && $sales_code) {
            $this->db->trans_begin();
            $data = array("unit_code"=>$this->user->user_unit_code,
                          "sales_code"=>$sales_code,
                          "sales_comment"=>$sales_comment,
                          "sales_crm_flag"=>$this->user->user_crm_admin,
                          "created_by"=>$this->user->user_id,
                          "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_salescomment',$data);

            //update-sales-table
            $data_upd = array();
            if($this->user->user_crm_admin == 1) {
                $data_upd = array("sales_crm_by"=>$this->user->user_id,
                              "sales_crm_date"=>date('Y-m-d H:i:s'),
                              "sales_crm_comment"=>$sales_comment);
            }
            else {
                $data_upd = array("sales_crc_by"=>$this->user->user_id,
                              "sales_crc_date"=>date('Y-m-d H:i:s'),
                              "sales_crc_comment"=>$sales_comment);
            }
            $this->db->where('unit_code',$this->user->user_unit_code);
            $this->db->where('sales_code',$sales_code);
            $this->db->update('pmd_sales',$data_upd);

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
    public function ViewComments($sales_code) {
        $qry = "SELECT
                    S.sales_comment,
                    S.created_date,
                    U.user_emp_name
                FROM
                    pmd_salescomment S
                        JOIN
                    pmd_userdetails U ON U.user_id = S.created_by
                WHERE S.sales_code = '".$sales_code."'
                ORDER BY S.created_date ASC";
        return $this->db->query($qry)->result();
    }
    public function UpdateApprovalStatus() {
        $sales_status   = (int)$this->input->post('sales_status',true);
        $sales_code     = $this->input->post('sales_code',true);
        if($sales_status >= 0 && $sales_code) {
            $this->db->trans_begin();
            $data = array("sales_status"=>$sales_status,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('unit_code',$this->user->user_unit_code);
            $this->db->where('sales_code',$sales_code);
            $this->db->update('pmd_sales',$data);
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
}