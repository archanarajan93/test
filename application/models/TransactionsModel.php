<?php
class TransactionsModel extends CI_Model
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
    //Get Rates
    public function GetRate($rate_flag, $rate_pdt_code) {
        $qry = "SELECT rate_amount FROM pmd_ratecard WHERE rate_flag = '".$rate_flag."' AND rate_pdt_code = '".$rate_pdt_code."'";
        return $this->db->query($qry)->row()->rate_amount;
    }
    //IsDatesFinalized
    public function IsDatesFinalized() {
        $finalize_date          = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Amendment);
        $str_finalize_date      = strtotime($finalize_date);
        $date_records           = json_decode($this->input->post("date_rec", TRUE),true);
        $finalized_dates        = array();

        if(count($date_records)) {
            foreach($date_records as $dt) {
                $each_date      = date("Y-m-d",strtotime($dt));
                if( strtotime($each_date) <= $str_finalize_date ) {
                    $finalized_dates[] = $dt;
                }
            }
            if(count($finalized_dates)) {
                $this->Message->status=400;
                $this->Message->text="Date(s), ". implode(",",$finalized_dates) ." Already Finalized!";
            }
            else {
                $this->Message->status=200;
                //$this->Message->text="Success";
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Enroll Sales
    public function EnrollLists($sl_status = null) {

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
        $sales_status   = (int)$this->input->post('sales_status',true);

        if($sl_status) $sales_status = $sl_status;

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

        if($date_to && $date_type) {
            $where .= " AND DATE(SL.".$date_type.") <= '".$date_to."' ";
        }

        if($sales_status >= 0) {
            $where .= " AND SL.sales_status = '".$sales_status."' ";
        }

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
                    IF(SL.sales_service_by = 1, (SELECT user_emp_dept FROM pmd_userdetails WHERE user_emp_id = SL.sales_service_code LIMIT 1),NULL) sales_service_dept,
                    SL.sales_crm_token,
                    SL.sales_status
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
                    SL.sales_copy_group,
                    SL.sales_copy_code,
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
    public function UpsertEnroll()
    {
        $is_valid           = true;
        $is_update          = (int)$this->input->post('is_update',true);
        $sales_reg_no       = $this->input->post('sales_reg_no',true);

        $sale_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $sale_type          = isset($sale_type_rec['Code']) ? $sale_type_rec['Code'] : null;
        $sale_copy_group    = isset($sale_type_rec['Copy Group']) ? $sale_type_rec['Copy Group'] : null;
        $sale_copy_code     = isset($sale_type_rec['Copy Code']) ? $sale_type_rec['Copy Code'] : null;

        $sales_sub_code_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $sales_sub_code     = isset($sales_sub_code_rec['Code']) ? $sales_sub_code_rec['Code'] : null;
        $sales_agent_code   = isset($sales_sub_code_rec['AgentCode']) ? $sales_sub_code_rec['AgentCode'] : null;
        $sales_agent_slno   = isset($sales_sub_code_rec['AgentSlNo']) ? $sales_sub_code_rec['AgentSlNo'] : null;

        $sales_can_by       = (int)$this->input->post('canvassed_by_type',true);        
        if($sales_can_by) {
            $sales_can_rec  = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            $sales_can_code = isset($sales_can_rec['Code']) ? $sales_can_rec['Code'] : null;
            $sales_can_name = isset($sales_can_rec['Name']) ? $sales_can_rec['Name'] : null;
            $sales_can_loc  = isset($sales_can_rec['Location']) ? $sales_can_rec['Location'] : null;
            if($sales_can_by == 17) $sales_can_name = $sales_can_name.' '.$sales_can_loc; //append location also if type is agent
            if(!$sales_can_code || !$sales_can_name) $is_valid = false;            
        }
        else {
            $sales_can_code = null;
            $sales_can_name = $this->input->post('canvassed_by_others',true);
            if(!$sales_can_name) $is_valid = false;
        }
        $sales_can_date     = date('Y-m-d',strtotime($this->input->post('sales_can_date',true)));

        $sales_service_by   = (int)$this->input->post('serviced_by_type',true);
        $sales_service_rec  = json_decode(rawurldecode($this->input->post('serviced_by_rec_sel',true)),true);
        $sales_service_code = isset($sales_service_rec['Code']) ? $sales_service_rec['Code'] : null;
        $sales_service_name = isset($sales_service_rec['Name']) ? $sales_service_rec['Name'] : null;
        $sales_service_loc  = isset($sales_service_rec['Location']) ? $sales_service_rec['Location'] : null;
        if($sales_service_by == 17) $sales_service_name = $sales_service_name.' '.$sales_service_loc; //append location also if type is agent

        $sales_wel_by       = (int)$this->input->post('wellwisher_type',true);
        $sales_wel_rec      = json_decode(rawurldecode($this->input->post('wellwisher_rec_sel',true)),true);
        $sales_wel_code     = isset($sales_wel_rec['Code']) ? $sales_wel_rec['Code'] : null;
        $sales_wel_name     = isset($sales_wel_rec['Name']) ? $sales_wel_rec['Name'] : null;
        $sales_wel_contact  = isset($sales_wel_rec['Contact Person']) ? $sales_wel_rec['Contact Person'] : null;
        $sales_wel_loc      = isset($sales_wel_rec['Location']) ? $sales_wel_rec['Location'] : null;

        $sales_start_date   = date('Y-m-d',strtotime($this->input->post('sales_start_date',true)));
        $sales_end_flag     = (int)$this->input->post('sales_end_flag',true);
        $sales_end_date     = $sales_end_flag ? date('Y-m-d',strtotime($this->input->post('sales_end_date',true))) : null;

        $sales_copies       = $this->input->post('sales_copies',true);
        $sales_remarks      = $this->input->post('sales_remarks',true);
        $sales_type         = $this->input->post('sales_type',true);

        if($sales_reg_no && $sale_type && $sale_copy_group && $sale_copy_code && $sales_sub_code && $sales_agent_code && $sales_agent_slno &&
           $sales_can_date && $sales_service_code && $sales_service_name && $sales_wel_code && $sales_start_date && $is_valid === true) {

            $this->db->trans_begin();
            $data = $data_upd = array();
            $no_id = "";
            if($is_update === 0) {
                $no_id = 'ERL_'.$this->user->user_unit_code.'_CODE';
                $sales_code = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "sales_code"=>$sales_code,
                                    "sales_pdt_code"=>$this->user->user_product_code);
            }
            else {
                $sales_code = $this->input->post('sales_code',true); 
            }

            $data = array("sales_copy_type"=>$sale_type,
                          "sales_copy_group"=>$sale_copy_group,
                          "sales_copy_code"=>$sale_copy_code,                       
                          "sales_reg_no"=>$sales_reg_no,                          
                          "sales_sub_code"=>$sales_sub_code,
                          "sales_agent_code"=>$sales_agent_code,
                          "sales_agent_slno"=>$sales_agent_slno,
                          "sales_can_by"=>$sales_can_by,
                          "sales_can_code"=>$sales_can_code,
                          "sales_can_name"=>$sales_can_name,
                          "sales_can_date"=>$sales_can_date,
                          "sales_wel_by"=>$sales_wel_by,
                          "sales_wel_code"=>$sales_wel_code,
                          "sales_wel_name"=>$sales_wel_name,
                          "sales_wel_contact"=>$sales_wel_contact,
                          "sales_wel_loc"=>$sales_wel_loc,
                          "sales_service_by"=>$sales_service_by,
                          "sales_service_code"=>$sales_service_code,
                          "sales_service_name"=>$sales_service_name,
                          "sales_start_date"=>$sales_start_date,
                          "sales_end_flag"=>$sales_end_flag,
                          "sales_end_date"=>$sales_end_date,
                          "sales_copies"=>$sales_copies,
                          "sales_remarks"=>$sales_remarks,                          
                          "sales_type"=>$sales_type,
                          $is_update === 0 ? "created_by": "modified_by"=>$this->user->user_id,
                          $is_update === 0 ? "created_date": "modified_date"=>date('Y-m-d H:i:s'));

            if($is_update === 0) {
                $data = array_merge($data,$data_upd);
                $this->db->insert('pmd_sales',$data);
            }
            else {
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('sales_code',$sales_code);
                $this->db->update('pmd_sales',$data);
            }          

            if($is_update === 0) {
                $this->UpdatePrimaryId($sales_code, $no_id);
            }

            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');                
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
    public function StopCopy() {
        $reason_rec  = json_decode(rawurldecode($this->input->post('reason_rec',true)),true);
        $reason      = isset($reason_rec['Code']) ? $reason_rec['Code'] : null;
        $sales_code  = $scheme_code = $this->input->post('sales_code',true);
        $subscriber_code = $this->input->post('subscriber_code',true);
        if($reason && $sales_code && $subscriber_code) {
            $this->db->trans_begin();

            $amend_status = new stdClass();
            $sts = $this->StopAmendment($scheme_code,$subscriber_code);
            $amend_status->status = $sts->status;
            $amend_status->text = $sts->text;

            $data = array("sales_reason"=>$reason,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('unit_code',$this->user->user_unit_code);
            $this->db->where('sales_code',$sales_code);
            $this->db->update('pmd_sales',$data);
            if($this->db->trans_status() === TRUE && $amend_status->status == 200)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$amend_status->status == 400 ? $amend_status->text : $this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Start Copy
    public function ApproveStartCopy() {
        $sales_status     = EnrollStatus::Started;
        $sales_code       = $this->input->post('sales_code',true);
        $sales_copy_type  = $this->input->post('sales_copy_type',true);
        $sales_copy_group = $this->input->post('sales_copy_group',true);
        $sales_copy_code  = $this->input->post('sales_copy_code',true);
        $sales_sub_code   = $this->input->post('sales_sub_code',true);
        $sales_agent_code = $this->input->post('sales_agent_code',true);
        $sales_agent_slno = $this->input->post('sales_agent_slno',true);
        $sales_copies     = (int)$this->input->post('sales_copies',true);
        $sales_start_date = date('Y-m-d',strtotime($this->input->post('sales_start_date',true)));
        $sales_end_date   = $this->input->post('sales_end_date',true) ? date('Y-m-d',strtotime($this->input->post('sales_end_date',true))) : null;

        if($sales_code && $sales_start_date && $sales_copy_type && $sales_copy_group && $sales_copy_code && $sales_sub_code && $sales_agent_code && $sales_agent_slno && $sales_copies > 0) {
            $this->db->trans_begin();
            //check-current-copy-status
            $condition=" unit_code = '".$this->user->user_unit_code."' AND sales_code = '".$sales_code."' AND sales_status = '".$sales_status."' ";
            if($this->IsDuplicate('pmd_sales',$condition)) {
                $this->Message->status=400;
                $this->Message->text="Copy Already Started!";
            }
            else {               
                //$week_day    = strtoupper(date("D",strtotime($sales_start_date))); //returns SUN, MON etc
                //$rate_flag   = $week_day == 'SUN' ? 'SUN' : $this->user->user_product_code;
                //$rate_qry    = "SELECT rate_amount FROM pmd_ratecard WHERE rate_pdt_code = '".$this->user->user_product_code."' AND rate_flag = '". $rate_flag ."' LIMIT 1";
                //$rate_amount = $this->db->query($rate_qry)->row()->rate_amount;
                $rate_amount  = 0;
                $data_amend   = array("amendment_agent_code"=>$sales_agent_code,
                                      "amendment_agent_slno"=>$sales_agent_slno,
                                      "amendment_sub_code"=>$sales_sub_code,
                                      "amendment_copy_code"=>$sales_copy_code,
                                      "amendment_copy_group"=>$sales_copy_group,
                                      "amendment_copy_type"=>$sales_copy_type,
                                      "amendment_scheme_code"=>$sales_code);
                $amend_status = $this->CreateAmendment($data_amend, $sales_start_date, $sales_end_date, $sales_copies, $rate_amount);

                if($amend_status->status === 200) {
                    //update pmd_sales table
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
                    $this->db->trans_rollback();
                    $this->Message->status=$amend_status->status;
                    $this->Message->text=$amend_status->text;
                }           
            }    
        }
        else {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Packers diary
    public function CreatePackersDiary(){
        //$current_date = date('Y-m-d',strtotime($this->input->post('current_date')),true);
        $product_rec = json_decode(rawurldecode($this->input->post('product_rec_sel',true)),true);
        $pack_call_by = $this->input->post('packers_optn');
        $pack_agent = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $pack_reason = json_decode(rawurldecode($this->input->post('packet_reason_rec_sel',true)),true);
        if($pack_call_by == '1'){
            $pack_sub = json_decode(rawurldecode($this->input->post('sub_subscriber_rec_sel',true)),true);
            $pack_agent["Code"]=$pack_sub["AgentCode"];
            $pack_agent["SerialNumber"]=$pack_sub["AgentSlNo"];
        }else{

            $pack_sub = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        }
        $select_plus = $this->input->post('select_plus_minus');
        $pack_copies = $this->input->post('copy');
        $pack_remark = strtoupper($this->input->post('remark'));
        $this->db->trans_begin();
        $pack_id = $this->GetPrimaryId("PACK_CODE");
        $data = array("pack_id"=>$pack_id,
            "unit_code"=>$this->user->user_unit_code,
            "pack_date"=>date('Y-m-d H:i:s'),
            "pack_call_by"=>$pack_call_by,
            "pack_agent_code"=>$pack_agent["Code"],
            "pack_agent_slno"=>$pack_agent["SerialNumber"],
            "pack_product_code"=>$product_rec["Code"],
            "pack_sub_code"=>$pack_sub["Code"],
            "pack_reason"=>$pack_reason["Reason"],
            "pack_plus_minus"=>$select_plus,
            "pack_copies"=>$pack_copies,
            "pack_remarks"=>$pack_remark,
            "created_by"=>$this->user->user_id,
            "created_date"=>date('Y-m-d H:i:s'));
        $this->db->insert('pmd_packer_diary',$data);
        $this->UpdatePrimaryId($pack_id, "PACK_CODE");
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
        return $this->Message;
    }
    public function PackersDiaryLists(){
        $where_condition = "";
        $diary_agent_code = $this->input->post('diary_agent_code',true);
        $from_date = $this->input->post('diary_from_date',true);
        $to_date = $this->input->post('diary_to_date',true);
        if($from_date){
            $where_condition .= " AND DATE(t1.pack_date) >= '". date('Y-m-d',strtotime($from_date)) ."' ";
        }
        if($to_date){
            $where_condition .= " AND DATE(t1.pack_date) <= '".date('Y-m-d',strtotime($to_date)) ."' ";
        }
        if($diary_agent_code){
            $where_condition .= " AND t1.pack_agent_code='".$diary_agent_code."'";
        }
        if(!isset($_POST['search'])){
            $where_condition .= " AND DATE(t1.pack_date) = '".date('Y-m-d')."'";
        }
       $qury = "SELECT
                    t1.unit_code,pack_date,
                    t1.pack_call_by,
                    t1.pack_agent_code,
                    t1.pack_agent_slno,
                    t1.pack_product_code,
                    t1.pack_sub_code,
                    t1.pack_reason,
                    t1.pack_plus_minus,
                    t1.pack_copies,
                    t1.pack_remarks,
                    t1.created_by,
                    t1.created_date,
                    t1.pack_id,
                    t2.agent_slno,
                    t2.agent_name,
                    t2.agent_location,
                    t2.agent_phone,
                    t3.sub_name,
                    t3.sub_address,
                    t4.user_login_name,
                    t4.user_emp_name
            FROM 
                    pmd_packer_diary t1
            LEFT JOIN
                    pmd_agent t2 ON t1.pack_agent_code = t2.agent_code
            LEFT JOIN
                    pmd_subscriber t3 ON t1.pack_sub_code = t3.sub_code
            LEFT JOIN
                    pmd_userdetails t4 ON t1.created_by = t4.user_id
            WHERE 1=1 ".$where_condition;
        return $this->db->query($qury)->result();
    }
    public function ViewPackersDiary(){
       
        $pack_code = $this->input->post('packCode');
        $qury = "SELECT
                    t1.unit_code,
                    t1.pack_date,
                    t1.pack_call_by,
                    t1.pack_agent_code,
                    t1.pack_agent_slno,
                    t1.pack_product_code,
                    t1.pack_sub_code,
                    t1.pack_reason,
                    t1.cancel_flag,
                    t1.pack_plus_minus,
                    t1.pack_copies,
                    t1.pack_remarks,
                    t1.created_by,
                    t1.created_date,
                    t1.pack_id,
                    t2.agent_slno,
                    t1.pack_agent_code,
                    t2.agent_name,
                    t2.agent_location,
                    t2.agent_phone,
                    t3.sub_name,
                    t3.sub_address,
                    t4.product_code,
                    t4.product_name
            FROM
                    pmd_packer_diary t1
            LEFT JOIN
                    pmd_agent t2 ON t1.pack_agent_code = t2.agent_code
            LEFT JOIN
                    pmd_subscriber t3 ON t1.pack_sub_code = t3.sub_code
            LEFT JOIN
                    pmd_products t4 ON t4.product_code = t1.pack_product_code
            WHERE
                    t1.pack_id='".$pack_code."'";
        return $this->db->query($qury)->row();
    }
    public function UpdatePackersDiary(){
        $diary_id = $this->input->post('diaryCode');
        $diary_prdt = json_decode(rawurldecode($this->input->post('diaryPrdt')));
        $diary_call_by = $this->input->post('diaryOptn');
        $diary_agent = json_decode(rawurldecode($this->input->post('diaryAgent')));
        $diary_sub = json_decode(rawurldecode($this->input->post('diarySub')));
        //$diary_sub_detl =
        $diary_reason = json_decode(rawurldecode($this->input->post('diaryReason',true)),true);
        $diary_plus = $this->input->post('diaryPlus');
        $diary_copies = $this->input->post('diaryCopy');
        $diary_remark = strtoupper($this->input->post('diaryRemark'));
        $diary_status = $this->input->post('diaryStatus');

        $data = array("pack_id"=>$diary_id,
                      "unit_code"=>$this->user->user_unit_code,
                      "pack_date"=>date('Y-m-d H:i:s'),
                      "pack_call_by"=>$diary_call_by,
                      "pack_agent_slno"=>$diary_agent->SerialNumber,
                      "pack_agent_code"=>$diary_agent->Code,
                      "pack_product_code"=>$diary_prdt->Code,
                      "pack_sub_code"=>$diary_sub->Code,
                      "pack_reason"=>$diary_reason["Reason"],
                      "pack_plus_minus"=>$diary_plus,
                      "pack_copies"=>$diary_copies,
                      "pack_remarks"=>$diary_remark,
                      "cancel_flag"=>$diary_status,
                      "modified_by"=>$this->user->user_id,
                      "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->where('pack_id', $diary_id);
        $this->db->update('pmd_packer_diary', $data);
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

    //Finalize
    public function CreateFinalizeReceipt(){
        $date = date('Y-m-d',strtotime($this->input->post('receipt_from_date')));
        $data = array("unit_code"=>$this->user->user_unit_code,
            "entry_date"=>$date,
            "product_code"=>$this->user->user_product_code,
            "entry_type"=>FinalizeType::Receipt,
            "cancel_flag"=>0,
            "created_by"=>$this->user->user_id,
            "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_finalize',$data);
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
        return $this->Message;
    }
    public function RevertReceiptFinalize(){
        $date_recei = date('Y-m-d',strtotime($this->input->post('receipt_from_date')));
        $data = array("unit_code"=>$this->user->user_unit_code,
            "entry_date"=>$date_recei,
            "product_code"=>$this->user->user_product_code,
            "entry_type"=>FinalizeType::Receipt,
            "cancel_flag"=>1,
            "modified_by"=>$this->user->user_id,
            "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->where('entry_type', FinalizeType::Receipt);
        $this->db->where('product_code', $this->user->user_product_code);
        $this->db->where('entry_date', $date_recei);
        $this->db->where('unit_code', $this->user->user_unit_code);
        $this->db->update('pmd_finalize',$data);
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
        return $this->Message;
    }
    public function GetReceiptFinalize(){

        $qury = "SELECT
                    entry_date
                 FROM
                    pmd_finalize
                WHERE
                    cancel_flag=0 AND entry_type='".FinalizeType::Receipt."' ORDER BY entry_date DESC LIMIT 1";
        return $this->db->query($qury)->row();
    }
    public function CreateFinalizeJournal(){
        $unit_code = $this->user->user_unit_code;
        $pdt_code = $this->user->user_product_code;
        $type = FinalizeType::Journal;
        $last_date = $this->GetLastFinalizeDate($unit_code,$pdt_code,$type);
        $date_to = date('Y-m-d',strtotime($this->input->post('jour_to_date')));
        if($last_date && strtotime($date_to) <= strtotime($last_date) ){
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('date_finalize');
            return $this->Message;
        }

        $data = array("unit_code"=>$this->user->user_unit_code,
            "entry_date"=>$date_to,
            "product_code"=>$this->user->user_product_code,
            "entry_type"=>FinalizeType::Journal,
            "cancel_flag"=>0,
            "created_by"=>$this->user->user_id,
            "created_date"=>date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $this->db->insert('pmd_finalize',$data);
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
        return $this->Message;
    }
    public function RevertJournalFinalize(){
        $date_jour = date('Y-m-d',strtotime($this->input->post('diary_from_date')));
            $data = array("unit_code"=>$this->user->user_unit_code,
                "entry_date"=>$date_jour,
                "product_code"=>$this->user->user_product_code,
                "entry_type"=>FinalizeType::Journal,
                "cancel_flag"=>1,
                "modified_by"=>$this->user->user_id,
                "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('entry_type', FinalizeType::Journal);
            $this->db->where('product_code', $this->user->user_product_code);
            $this->db->where('entry_date', $date_jour);
            $this->db->where('unit_code', $this->user->user_unit_code);
            $this->db->update('pmd_finalize',$data);
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
        return $this->Message;
    }
    public function GetJournalFinalize(){
       
        $qury = "SELECT
                    entry_date
                 FROM
                    pmd_finalize
                WHERE
                    cancel_flag=0 AND entry_type='".FinalizeType::Journal."' ORDER BY entry_date DESC LIMIT 1";
        return $this->db->query($qury)->row();
    }

    //Scheme Details
    public function SchemeDetailsLists() {
        $where='';
        if(!isset($_POST['search'])){
            $where .= " AND DATE(SC.created_date)='".date("Y-m-d")."'";
        }else{
            $subscriber_rec     = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
            $sch_sub_code       = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
            $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
            $sch_copy_type      = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
            $agent_rec          = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
            $agent_code         = isset($agent_rec['Code']) ? $agent_rec['Code'] : null;
            $event_rec          = json_decode(rawurldecode($this->input->post('event_rec_sel',true)),true);
            $event_code         = isset($event_rec['Code']) ? $event_rec['Code'] : null;
            $scheme_no          = $this->input->post('scheme_no',true);
            $sch_dte_range      = $this->input->post('sch_dte_range',true);
            $from_dte           = $this->input->post('from_dte',true);
            $to_dte             = $this->input->post('to_dte',true);
            $str_from_dte       = strtotime($from_dte);
            $str_to_dte         = strtotime($to_dte);
            $pause_status       = $this->input->post('pause_status',true);
            $canvassed_by_type  = $this->input->post('canvassed_by_type',true);

            if($canvassed_by_type){
                $can_rec  = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
                $sch_can_code = isset($can_rec['Code']) ? $can_rec['Code'] : null;
                $sch_can_name = null;
            }else{
                $sch_can_code = null;
                $sch_can_name = $this->input->post('canvassed_others',true);
            }
            if($sch_sub_code){
                $where .= " AND SC.sch_sub_code='".$sch_sub_code."'";
            }
            if($agent_code){
                $where .= " AND SC.sch_agent_code='".$agent_code."'";
            }
            if($sch_copy_type){
                $where .= " AND SC.sch_copy_type='".$sch_copy_type."'";
            }
            if($event_code){
                $where .= " AND SC.sch_event_code='".$event_code."'";
            }
            if($scheme_no){
                $where .= " AND SC.sch_slno='".$scheme_no."'";
            }
            if($sch_dte_range=='1'){
                if($from_dte && $to_dte && $str_from_dte<=$str_to_dte){
                    $where .= " AND SC.sch_from_date >='".date("Y-m-d H:i:s", $str_from_dte)."' AND SC.sch_from_date<='".date("Y-m-d H:i:s",$str_to_dte)."'";
                }
            }else if($sch_dte_range=='2'){
                if($from_dte && $to_dte && $str_from_dte<=$str_to_dte){
                    $where .= " AND SC.sch_to_date >='".date("Y-m-d H:i:s", $str_from_dte)."' AND SC.sch_to_date<='".date("Y-m-d H:i:s",$str_to_dte)."'";
                }
            }
            else if($sch_dte_range=='3'){
                if($from_dte && $to_dte && $str_from_dte<=$str_to_dte){
                    $where .= " AND DATE(SC.created_date) >='".date("Y-m-d", $str_from_dte)."' AND DATE(SC.created_date)<='".date("Y-m-d",$str_to_dte)."'";
                }
            }
            else if($sch_dte_range=='4'){
                if($from_dte && $to_dte && $str_from_dte<=$str_to_dte){
                    $where .= " AND DATE(SC.sch_can_date) >='".date("Y-m-d", $str_from_dte)."' AND DATE(SC.sch_can_date)<='".date("Y-m-d",$str_to_dte)."'";
                }
            }
            if($sch_can_code){
                $where .= " AND SC.sch_can_code='".$sch_can_code."'";
            }
            if($sch_can_name){
                $where .= " AND SC.sch_can_name='".$sch_can_name."'";
            }
            if($pause_status=='1'){
                $where .= " AND SC.sch_paused_flag='0'";
            }else if($pause_status=='2'){
                $where .= " AND SC.sch_paused_flag='1'";
            }
        }
        $qry = "SELECT
                    SC.sch_slno,
                    CT.copytype_name,
                    SB.sub_name,
                    SB.sub_address,
                    SB.sub_phone,
                    AG.agent_code,
                    AG.agent_name,
                    AG.agent_location,
                    AG.cancel_flag,
                    SC.sch_can_name,
                    SC.sch_can_date,
                    SC.sch_copies,
                    SC.sch_from_date,
                    SC.sch_to_date,
                    SC.sch_remarks,
                    SC.sch_paused_flag,
                    US.user_emp_name created_name,
                    SC.created_date
                FROM
                    pmd_scheme SC
                JOIN
                    pmd_copytype CT ON (CT.copytype_code = SC.sch_copy_type AND CT.copy_code = 'CP0003')
                JOIN
                    pmd_subscriber SB ON (SB.sub_code = SC.sch_sub_code AND SB.sub_unit_code = '".$this->user->user_unit_code."')
                JOIN
                    pmd_agent AG ON (AG.agent_unit = '".$this->user->user_unit_code."' AND AG.agent_slno = SC.sch_agent_slno)
                JOIN
                    pmd_userdetails US ON SC.created_by=US.user_id 
                WHERE
                    1 = 1 ".$where." AND SC.cancel_flag = 0";
        return $this->db->query($qry)->result();
    }
    public function SchemeDetails($sch_code) {
        $qry = "SELECT
                    SC.sch_slno,
                    SC.sch_reg_no,
                    CG.group_code,
                    CG.group_name,
                    CT.copytype_code,
                    CT.copytype_name,
                    RC.rate_sch_years,
                    RC.rate_sch_months,
                    RC.rate_sch_days,
                    RC.rate_amount,
                    SB.sub_code,
                    SB.sub_name,
                    SB.sub_address,
                    SB.sub_phone,
                    AG.agent_code,
                    AG.agent_slno,
                    AG.agent_name,
                    AG.agent_location,
                    AG.cancel_flag,
                    SH.shakha_code,
                    SH.shakha_name,
                    EV.event_code,
                    EV.event_name,
                    SC.sch_can_flag,
                    SC.sch_can_code,
                    SC.sch_can_name,
                    SC.sch_can_dept,
                    SC.sch_can_date,
                    IF(SC.sch_can_flag=17, 
                       (SELECT CONCAT(agent_code,' ',agent_name,' ',agent_location) FROM pmd_agent WHERE agent_unit='".$this->user->user_unit_code."' AND agent_code=SC.sch_can_code),'') canvassed_agent,
                    SC.sch_copies,
                    SC.sch_from_date,
                    SC.sch_to_date,
                    SC.sch_inc_amount,
                    SC.sch_inc_paid_amount,
                    SC.sch_remarks,
                    sch_renew_code,
                    SC.created_date
                FROM
                    pmd_scheme SC
                JOIN
                    pmd_copygroup CG ON SC.sch_copy_group=CG.group_code
                JOIN
                    pmd_copytype CT ON (CT.copytype_code = SC.sch_copy_type AND CT.copy_code = 'CP0003')
                JOIN
                    pmd_ratecard RC ON RC.rate_pdt_code='".$this->user->user_product_code."' AND RC.rate_copy_type = CT.copytype_code
                JOIN
                    pmd_subscriber SB ON (SB.sub_code = SC.sch_sub_code AND SB.sub_unit_code = '".$this->user->user_unit_code."')
                JOIN
                    pmd_agent AG ON (AG.agent_unit = '".$this->user->user_unit_code."' AND AG.agent_slno = SC.sch_agent_slno)
                LEFT JOIN
                    pmd_shakha SH ON SH.shakha_unit='".$this->user->user_unit_code."' AND SH.shakha_code = SC.sch_shakha_code
                LEFT JOIN
                    pmd_events EV ON EV.event_code = SC.sch_event_code
                
                WHERE
                   SC.unit_code='".$this->user->user_unit_code."' AND SC.sch_slno='".$sch_code."' AND SC.cancel_flag=0";
        return $this->db->query($qry)->row();
    }
    public function UpsertScheme()
    {
        $is_valid           = true;
        $sch_code           = $this->input->post("sch_code", TRUE);
        $old_sch_code       = $sch_code; //for renewal
        $is_renewal         = $this->input->post("is_renewal", TRUE) == '1' ? true : false;
        if($sch_code){
            $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
            $old_sch_code = $sch_code;
        }
        $is_update          = $sch_code ? true : false;
        
        $sch_reg_no         = $this->input->post('sch_reg_no',true);
        $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $sch_copy_type      = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $sch_copy_group     = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $sch_copy_code      = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;
        $sch_amount         = isset($copy_type_rec['Amount']) ? $copy_type_rec['Amount'] : null;
        $subscriber_rec     = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $sch_sub_code       = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
        $sch_agent_code     = isset($subscriber_rec['AgentCode']) ? $subscriber_rec['AgentCode'] : null;
        $sch_agent_slno     = isset($subscriber_rec['AgentSlNo']) ? $subscriber_rec['AgentSlNo'] : null;

        $shakha_rec         = json_decode(rawurldecode($this->input->post('shakha_rec_sel',true)),true);
        $sch_shakha_code    = isset($shakha_rec['Code']) ? $shakha_rec['Code'] : null;
        $event_rec          = json_decode(rawurldecode($this->input->post('event_rec_sel',true)),true);
        $sch_event_code     = isset($event_rec['Code']) ? $event_rec['Code'] : null;

        $sch_from_date      = date("Y-m-d H:i:s", strtotime($this->input->post('sch_start_date',true)));
        $sch_to_date        = date("Y-m-d H:i:s", strtotime($this->input->post('sch_end_date',true)));
        //$sch_prev_from_date = date("Y-m-d H:i:s", strtotime($this->input->post('sch_prev_from_dte',true)));
        $sch_prev_to_date   = date("Y-m-d H:i:s", strtotime($this->input->post('sch_prev_to_dte',true)));
        $str_from_dte       = strtotime($sch_from_date);

        //if($str_from_dte<strtotime(date("Y-m-d")) || strtotime($sch_from_date)>strtotime($sch_to_date)){
        //    $this->Message->status=400;
        //    $this->Message->text="Error! Scheme start date should be a future date.";
        //    return $this->Message;
        //}
        if($is_renewal === true && $str_from_dte<strtotime($sch_prev_to_date)){
            $this->Message->status=400;
            $this->Message->text="Error! Scheme renew date should be a future date.";
            return $this->Message;
        }
        $sch_can_flag       = (int)$this->input->post('canvassed_by_type',true);        
        if($sch_can_flag) {
            $can_rec  = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            $sch_can_code = isset($can_rec['Code']) ? $can_rec['Code'] : null;
            $sch_can_name = isset($can_rec['Name']) ? $can_rec['Name'] : null;
            $sch_can_dept_code = isset($can_rec['Department']) ? $can_rec['Department'] : null;
            if(!$sch_can_code || !$sch_can_name) $is_valid = false;            
        }
        else {
            $sch_can_code = null;
            $sch_can_dept_code = null;
            $sch_can_name = $this->input->post('canvassed_others',true);
            if(!$sch_can_name) $is_valid = false;
        }
        $canvassed_date = $this->input->post('canvassed_date',true);
        $sch_can_date      = date('Y-m-d',strtotime($canvassed_date));

        $sch_inc_amt       = $this->input->post('inc_amt',true);
        $sch_inc_paid_amt  = $this->input->post('inc_paid',true);
        $sch_remarks          = $this->input->post('remarks',true);

        if($sch_reg_no && $sch_copy_type && $sch_copy_group && $sch_amount && $sch_sub_code &&
           $sch_agent_code && $sch_agent_slno && $sch_from_date && $sch_to_date && $canvassed_date && $is_valid === true) {

            $now = date('Y-m-d H:i:s');
            $data = $data_upd = array();
            $no_id = "";
            $this->db->trans_begin();
            if($is_update===false || $is_renewal === true) {
                $no_id = 'SCH_'.$this->user->user_unit_code.'_CODE';
                $sch_code = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "sch_slno"=>$sch_code,
                                    "sch_pdt_code"=>$this->user->user_product_code,
                                    "sch_from_date" => $sch_from_date);
                if($is_renewal === true){
                    $data_upd["sch_old_scheme"] = $old_sch_code;
                }
            }
            $data = array(
                          "sch_reg_no" => $sch_reg_no,
                          "sch_copy_type" => $sch_copy_type,
                          "sch_copy_group" => $sch_copy_group,
                          "sch_sub_code" => $sch_sub_code,
                          "sch_agent_code" => $sch_agent_code,
                          "sch_agent_slno" => $sch_agent_slno,
                          "sch_shakha_code" => $sch_shakha_code,
                          "sch_event_code" => $sch_event_code,
                          "sch_to_date" => $sch_to_date,
                          "sch_can_flag" => $sch_can_flag,
                          "sch_can_code" => $sch_can_code,
                          "sch_can_name" => strtoupper($sch_can_name),
                          "sch_can_dept" => $sch_can_dept_code,
                          "sch_can_date" => $sch_can_date,
                          "sch_remarks" => strtoupper($sch_remarks),
                          "sch_amount" =>  $sch_amount,
                          "sch_balance" =>  $sch_amount,
                          "sch_inc_amount" => $sch_inc_amt,
                          "sch_inc_paid_amount" => $sch_inc_paid_amt,
                          "sch_copies" =>1,
                          "cancel_flag" =>0,
                          $is_update ? "modified_by": "created_by"=> $this->user->user_id,
                          $is_update ? "modified_date": "created_date"=>$now
                );
            $amend_data= array(
                    "amendment_agent_code"=>$sch_agent_code,
                    "amendment_agent_slno"=>$sch_agent_slno,
                    "amendment_sub_code"=>$sch_sub_code,
                    "amendment_copy_code"=>$sch_copy_code,
                    "amendment_copy_group"=>$sch_copy_group,
                    "amendment_copy_type"=>$sch_copy_type
                    );
            if($is_update === FALSE  || $is_renewal === true) {
                $amend_data["amendment_scheme_code"] = $sch_code;
                $amend_status = $this->CreateAmendment($amend_data,$sch_from_date,$sch_to_date,1,0);
                if($amend_status->status === 200){
                    $data = array_merge($data,$data_upd);
                    $this->db->insert('pmd_scheme',$data);
                    $this->UpdatePrimaryId($sch_code, $no_id);
                    if($is_renewal)
                    {
                        $data = array(
                            "sch_renew_code" => $sch_code,
                            "sch_renewed_by" => $this->user->user_id,
                            "sch_renewed_date" => $now
                            );
                        $this->db->where('unit_code',$this->user->user_unit_code);
                        $this->db->where('sch_slno',$old_sch_code);
                        $this->db->update('pmd_scheme',$data);
                    }
                }else{
                    $this->Message->status=400;
                    $this->Message->text=$amend_status->text;
                    return $this->Message;
                }
            }
            else {//update
                $amend_status = $this->UpdateAmendment($amend_data, $sch_code, $sch_to_date);
                if($amend_status->status === 400){
                    $this->Message->status=400;
                    $this->Message->text=$amend_status->text;
                    return $this->Message;
                }
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('sch_slno',$sch_code);
                $this->db->update('pmd_scheme',$data);
            } 
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                if($is_renewal === TRUE){
                    $this->Message->text= "Renewed Successfully with Scheme No. <strong style='color:#16964f; font-size:18px;'>".$sch_code."</strong>.";
                } else if($is_update === TRUE){
                    $this->Message->text= "Scheme No. <strong style='color:#16964f; font-size:18px;'>".$sch_code."</strong> Updated Successfully.";
                } else{
                    $this->Message->text= "Scheme No. <strong style='color:#16964f; font-size:18px;'>".$sch_code."</strong> Created Successfully.";
                }                
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
    public function DeleteScheme($data)
    {
        $scheme_det = $this->SchemeDetails($data['sch_slno']);
        $amend_data= array(
                    "amendment_agent_code"=>$scheme_det->agent_code,
                    "amendment_agent_slno"=>$scheme_det->agent_slno,
                    "amendment_sub_code"=>$scheme_det->sub_code,
                    "amendment_copy_type"=>$scheme_det->copytype_code,
                    "amendment_scheme_code"=>$scheme_det->sch_slno
                    );
        $this->db->trans_begin();
        $amend_status = $this->StopAmendment($amend_data, $scheme_det->sch_from_date, date("Y-m-d 00:00:00"), $data['sch_slno'], 1, 0);
        if($amend_status->status === 200){
            $this->db->where('sch_slno', $data['sch_slno']);
            $this->db->update('pmd_scheme', $data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('deleted_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');                
            }
        }else{
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$amend_status->text;
        }
		return json_encode($this->Message);
    }
    public function PauseScheme($data)
    {
        $scheme_det = $this->SchemeDetails($data['sch_slno']);
        $amend_data= array(
                    "amendment_agent_code"=>$scheme_det->agent_code,
                    "amendment_agent_slno"=>$scheme_det->agent_slno,
                    "amendment_sub_code"=>$scheme_det->sub_code,
                    "amendment_copy_type"=>$scheme_det->copytype_code,
                    "amendment_scheme_code"=>$scheme_det->sch_slno
                    );
        $this->db->trans_begin();
        $amend_status = $this->StopAmendment($amend_data, $scheme_det->sch_from_date, date("Y-m-d 00:00:00"), $data['sch_slno'], 1, 0);
        if($amend_status->status === 200){
            $this->db->where('sch_slno', $data['sch_slno']);
            $this->db->update('pmd_scheme', $data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text="Scheme Paused Successfully.";
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');                
            }
        }else{
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$amend_status->text;
        }
		return json_encode($this->Message);
    }
    public function RestartScheme($data)
    {
        $scheme_det = $this->SchemeDetails($data['sch_slno']);
        $amend_data= array(
                    "amendment_agent_code"=>$scheme_det->agent_code,
                    "amendment_agent_slno"=>$scheme_det->agent_slno,
                    "amendment_sub_code"=>$scheme_det->sub_code,
                    "amendment_copy_type"=>$scheme_det->copytype_code,
                    "amendment_scheme_code"=>$scheme_det->sch_slno
                    );
        $this->db->trans_begin();
        $amend_status = $this->CreateAmendment($amend_data,date("Y-m-d 00:00:00"),$scheme_det->sch_to_date,1,0);
        if($amend_status->status === 200){
            //now update scheme table paused flag
            $this->db->where('sch_slno', $data['sch_slno']);
            $this->db->update('pmd_scheme', $data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text="Scheme Restarted Successfully.";
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');                
            }
        }else{
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$amend_status->text;
        }
		return json_encode($this->Message);
    }    

    //Other Receipts
    public function GetOtherReceipts($date=null) {
        $where='';
        if(!isset($_POST['search'])){
            if($date){
                $where .= " AND DATE(SR.created_date)>='".$date."'";
            }else{
                $where .= " AND DATE(SR.created_date)>='".date("Y-m-d")."'";
            }
        }else{

            $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
            $copy_type          = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
            $from_dte           = $this->input->post('from_dte',true);
            $to_dte             = $this->input->post('to_dte',true);
            $str_from_dte       = strtotime($from_dte);
            $str_to_dte         = strtotime($to_dte);
            if($copy_type){
                $where .= " AND SR.srec_ac_code='".$copy_type."'";
            }
            if($from_dte && $to_dte && $str_from_dte>=$str_to_dte){
                $where .= " AND SR.srec_date >='".date("Y-m-d H:i:s", $str_from_dte)."' AND SR.srec_date<='".date("Y-m-d H:i:s",$str_to_dte)."'";
            }
        }
        $qry = "SELECT
                    srec_no,
                    srec_date,
                    CT.copytype_code,
                    CT.copytype_name,
                    IF(SR.srec_type_code='".OtherReceipts::Scheme."',(SELECT CONCAT(sub_code,'#&',sub_name,'#&',sub_address,'#&',sub_phone) FROM pmd_scheme SCH INNER JOIN pmd_subscriber SB ON SB.sub_unit_code='".$this->user->user_unit_code."' AND SCH.sch_sub_code=SB.sub_code WHERE SCH.unit_code='".$this->user->user_unit_code."' AND SCH.sch_slno=SR.srec_scheme_code),
                    IF(SR.srec_type_code='".OtherReceipts::EK."',(SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_ek EK INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND EK.ek_client_code=SPC.client_code WHERE EK.unit_code='".$this->user->user_unit_code."' AND EK.ek_slno=SR.srec_scheme_code),
                                                                 (SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_sponsor SP INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND SP.spons_client_code=SPC.client_code WHERE SP.unit_code='".$this->user->user_unit_code."' AND SP.spons_code=SR.srec_scheme_code))) AS subscriber,
                    SR.srec_scheme_code,
                    SR.srec_amount,
                    SR.srec_pay_type,
                    SR.srec_chq_no,
                    SR.srec_chq_date,
                    SR.srec_card_no,
                    SR.srec_card_name,
                    SR.srec_paid_by,
                    PR.promoter_code,
                    PR.promoter_name,
                    PR.promoter_area,
                    SR.srec_temp_rec,
                    SR.srec_remarks,
                    US.user_emp_name created_name,
                    SR.created_date
                FROM
                    pmd_scheme_receipt SR
                JOIN
                    pmd_copytype CT ON CT.copytype_code = SR.srec_copy_type
                JOIN
                    pmd_userdetails US ON SR.created_by=US.user_id
                LEFT JOIN
                    pmd_promoter PR ON PR.promoter_code=SR.srec_promoter_code
                WHERE
                   SR.unit_code='".$this->user->user_unit_code."' AND SR.srec_pdt_code='".$this->user->user_product_code."' ".$where." AND SR.cancel_flag=0";
        return $this->db->query($qry)->result();
    }
    public function UpsertOtherReceipts()
    {
        $is_valid = true;
        $sch_rcpt_no      = $this->input->post("sch_rcpt_no", TRUE);
        if($sch_rcpt_no){
            $sch_rcpt_no = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_no, $this->encryption_key);
        }
        $receipt_type       = null;
        $is_update          = $sch_rcpt_no ? true : false;
        $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $copy_type_code     = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $copy_group_code    = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $copy_code          = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;
        $copy_name          = isset($copy_type_rec['Copy']) ? $copy_type_rec['Copy'] : null;
        $copy_group_name    = isset($copy_type_rec['Group']) ? $copy_type_rec['Group'] : null;
        if($copy_name=='SCHEME'){
            $receipt_type = OtherReceipts::Scheme;
        }else if($copy_name=='SPONSOR'){
            if($copy_group_name=='ENTE KAUMUDI'){
                $receipt_type = OtherReceipts::EK;
            } else {
                $receipt_type = OtherReceipts::Sponsor;
            }
        }
        $subscriber_rec     = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $sch_sub_code       = isset($subscriber_rec['Subscriber Code']) ? $subscriber_rec['Subscriber Code'] : null;
        $sch_sub_name       = isset($subscriber_rec['Name']) ? $subscriber_rec['Name'] : null;
        $scheme_no          = isset($subscriber_rec['Serial No']) ? $subscriber_rec['Serial No'] : null;
        //$pending_amt        = isset($subscriber_rec['Pending Amount']) ? (int)$subscriber_rec['Pending Amount'] : 0;
        $sch_against_bounce = $this->input->post('against_chqbounce',true);
        $receipt_rec        = json_decode(rawurldecode($this->input->post('receipt_no_rec_sel',true)),true);
        $receipt_no         = isset($receipt_rec['Code']) ? $receipt_rec['Code'] : null;
        $receipt_amount     = (int)$this->input->post('sch_amt',true);
        $pay_type           = $this->input->post('pay_type',true);
        $bank_rec           = json_decode(rawurldecode($this->input->post('bank_rec_sel',true)),true);
        if($pay_type == PayType::Cheque){
            $cheque_date        = $this->input->post('sch_chq_dte',true);
            $sch_chq_no         = $this->input->post('sch_chq_no',true);
            $sch_chq_dte        = $cheque_date?date("Y-m-d",strtotime($cheque_date)):null;
            $bank_code          = isset($bank_rec['Code']) ? $bank_rec['Code'] : null;
            if(!$sch_chq_no || !$cheque_date || !$bank_code) $is_valid = false;
            $sch_card_no        = null;
            $sch_card_name      = null;
            $sch_card_exp       = null;
        }else if($pay_type == PayType::Card){
            $sch_chq_no         = null;
            $sch_chq_dte        = null;
            $sch_card_no        = $this->input->post('sch_card_no',true);
            $sch_card_name      = $this->input->post('sch_card_name',true);
            $sch_card_exp       = $this->input->post('sch_card_exp',true);
            $bank_code          = isset($bank_rec['Code']) ? $bank_rec['Code'] : null;
            if(!$sch_card_no || !$sch_card_name || !$bank_code) $is_valid = false;
        }else{
            $sch_chq_no         = null;
            $sch_chq_dte        = null;
            $sch_card_no        = null;
            $sch_card_name      = null;
            $sch_card_exp       = null;
            $bank_code          = null;
        }
        $sch_pay_mode       = $this->input->post('payment_mode',true);
        $promoter_rec       = json_decode(rawurldecode($this->input->post('promoter_rec_sel',true)),true);
        $promoter_code      = isset($promoter_rec['Code']) ? $promoter_rec['Code'] : null;
        $tmprcpt_rec        = json_decode(rawurldecode($this->input->post('tmp_rcpt_rec_sel',true)),true);
        $sch_tmp_rcpt       = isset($tmprcpt_rec['Receipt No']) ? $tmprcpt_rec['Receipt No'] : null;
        $remarks            = $this->input->post('remarks',true);
        $finalize_date      = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);

        if(!$finalize_date){
            $this->Message->status=400;
            $this->Message->text="Please finalize the date first.";
            return $this->Message;
        }
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        if($copy_type_code && $receipt_type && $sch_sub_code && $scheme_no && $receipt_amount>0 && $is_valid) {

            $now = date('Y-m-d H:i:s');
            $data = $data_upd = array();
            $no_id = "";
            $this->db->trans_begin();
            if($is_update===FALSE) {
                $no_id = 'SRCT_'.$this->user->user_unit_code.'_CODE';
                $sch_rcpt_no = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "srec_no"=>$sch_rcpt_no,
                                    "srec_date"=>date("Y-m-d", strtotime($finalize_date." +1 day")),
                                    "srec_pdt_code"=>$this->user->user_product_code,
                                    "srec_amount"=> $receipt_amount);
            }
           $data = array(
                          "srec_type_code"=>$receipt_type,
                          "srec_copy_code"=>$copy_code,
                          "srec_copy_group"=>$copy_group_code,
                          "srec_copy_type"=>$copy_type_code,
                          "srec_sub_code"=> $sch_sub_code,
                          "srec_scheme_code"=> $scheme_no,
                          "srec_sub_name"=> $sch_sub_name,
                          "srec_against_dis"=> $sch_against_bounce,
                          "srec_against_dis_code"=> $receipt_no,
                          "srec_pay_type"=> $pay_type,
                          "srec_chq_type"=> 0,
                          "srec_chq_no"=> $sch_chq_no,
                          "srec_chq_date"=> $sch_chq_dte,
                          "srec_card_no"=> $sch_card_no,
                          "srec_card_name"=> $sch_card_name,
                          "srec_card_exp_date"=> $sch_card_exp,
                          "srec_bank_code"=> $bank_code,
                          "srec_paid_by"=> $sch_pay_mode,
                          "srec_promoter_code"=> $promoter_code,
                          "srec_temp_rec"=> $sch_tmp_rcpt,
                          "srec_remarks"=>$remarks,
                          "cancel_flag"=> 0,
                          $is_update ? "modified_by": "created_by"=> $this->user->user_id,
                          $is_update ? "modified_date": "created_date"=>$now
                );
            if($is_update === FALSE) {
                $data = array_merge($data,$data_upd);
                $this->db->insert('pmd_scheme_receipt',$data);
                $this->UpdatePrimaryId($sch_rcpt_no, $no_id);
                if($receipt_type == OtherReceipts::Scheme){
                    $query = "UPDATE pmd_scheme SET sch_balance=sch_balance-".$receipt_amount.", sch_paid_amount=sch_paid_amount+".$receipt_amount." WHERE sch_slno='".$scheme_no."'";
                }else if($receipt_type == OtherReceipts::EK){
                    $query = "UPDATE pmd_ek SET ek_balance=ek_balance-".$receipt_amount.", ek_paid_amt=ek_paid_amt+".$receipt_amount." WHERE ek_slno='".$scheme_no."'";
                }else {
                    $query = "UPDATE pmd_sponsor SET spons_balance=spons_balance-".$receipt_amount.", spons_paid_amt=spons_paid_amt+".$receipt_amount." WHERE spons_code='".$scheme_no."'";
                }
                $this->db->query($query);
            }
            else {//update
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('srec_no',$sch_rcpt_no);
                $this->db->update('pmd_scheme_receipt',$data);
            } 
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text= $is_update === TRUE ?  $this->lang->line('updated_success') : $this->lang->line('added_success') ;           
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
    public function GetOtherReceiptDetails($sch_rcpt_code) {
        $qry = "SELECT
                    srec_no,
                    srec_date,
                    CT.copytype_code,
                    CT.copytype_name,
                    BM.bank_code,
                    BM.bank_name,
                    IF(SR.srec_type_code='".OtherReceipts::Scheme."',(SELECT CONCAT(sub_code,'#&',sub_name,'#&',sub_address,'#&',sub_phone) FROM pmd_scheme SCH INNER JOIN pmd_subscriber SB ON SB.sub_unit_code='".$this->user->user_unit_code."' AND SCH.sch_sub_code=SB.sub_code WHERE SCH.unit_code='".$this->user->user_unit_code."' AND SCH.sch_slno=SR.srec_scheme_code),
                    IF(SR.srec_type_code='".OtherReceipts::EK."',(SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_ek EK INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND EK.ek_client_code=SPC.client_code WHERE EK.unit_code='".$this->user->user_unit_code."' AND EK.ek_slno=SR.srec_scheme_code),
                                                                 (SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_sponsor SP INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND SP.spons_client_code=SPC.client_code WHERE SP.unit_code='".$this->user->user_unit_code."' AND SP.spons_code=SR.srec_scheme_code))) AS subscriber,
                    SR.srec_scheme_code,
                    SR.srec_against_dis,
                    SR.srec_against_dis_code,
                    SR.srec_amount,
                    SR.srec_pay_type,
                    SR.srec_chq_no,
                    SR.srec_chq_date,
                    SR.srec_card_no,
                    SR.srec_card_name,
                    SR.srec_card_exp_date,
                    SR.srec_dis_flag,
                    SR.srec_dis_no,
                    SR.srec_paid_by,
                    PR.promoter_code,
                    PR.promoter_name,
                    PR.promoter_area,
                    SR.srec_temp_rec,
                    SR.srec_remarks
                FROM
                    pmd_scheme_receipt SR
                JOIN
                    pmd_copytype CT ON CT.copytype_code = SR.srec_copy_type
                LEFT JOIN
                    pmd_promoter PR ON PR.promoter_code=SR.srec_promoter_code
                LEFT JOIN
                    pmd_bankmaster BM ON BM.bank_code=SR.srec_bank_code 
                WHERE
                   SR.unit_code='".$this->user->user_unit_code."' AND SR.srec_pdt_code='".$this->user->user_product_code."' AND SR.srec_no='".$sch_rcpt_code."' AND SR.cancel_flag=0";
        return $this->db->query($qry)->row();
    }
    public function DeleteOtherReceipts($data)
    {
        $scheme_rcpt_det = $this->GetOtherReceiptDetails($data['srec_no']);
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        if(strtotime($scheme_rcpt_det->srec_date)<=strtotime($finalize_date)&& $this->user->user_id!='1'){
            $this->Message->status=400;
            $this->Message->text="Dates are already finalized.";
            return json_encode($this->Message);
        }
        $this->db->trans_begin();
        if($scheme_rcpt_det->srec_type_code == OtherReceipts::Scheme){
            $query = "UPDATE pmd_scheme SET sch_balance=sch_balance+".$scheme_rcpt_det->srec_amount.", sch_paid_amount=sch_paid_amount-".$scheme_rcpt_det->srec_amount." WHERE sch_slno='".$scheme_rcpt_det->srec_scheme_code."'";
        }else if($scheme_rcpt_det->srec_type_code == OtherReceipts::EK){
            $query = "UPDATE pmd_ek SET ek_balance=ek_balance+".$scheme_rcpt_det->srec_amount.", ek_paid_amt=ek_paid_amt-".$scheme_rcpt_det->srec_amount." WHERE ek_slno='".$scheme_rcpt_det->srec_scheme_code."'";
        }else {
            $query = "UPDATE pmd_sponsor SET spons_balance=spons_balance+".$scheme_rcpt_det->srec_amount.", spons_paid_amt=spons_paid_amt-".$scheme_rcpt_det->srec_amount." WHERE spons_code='".$scheme_rcpt_det->srec_scheme_code."'";
        }
        $this->db->query($query);
        $this->db->where('srec_no', $data['srec_no']);
        $this->db->update('pmd_scheme_receipt', $data);
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('deleted_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');                
        }
		return json_encode($this->Message);
    }

    //Sponsor
    public function SponsorLists() {

        $spo_client_rec = json_decode(rawurldecode($this->input->post('sponsor_client_rec_sel',true)),true);
        $spo_client     = isset($spo_client_rec['Code']) ? $spo_client_rec['Code'] : null;

        $agent_rec      = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $agent_code     = isset($agent_rec['Code']) ? $agent_rec['Code'] : null;
        $agent_slno     = isset($agent_rec['SerialNumber']) ? $agent_rec['SerialNumber'] : null;

        $date_from      = date('Y-m-d',strtotime($this->input->post('date_from',true)));
        $date_to        = date('Y-m-d',strtotime($this->input->post('date_to',true)));

        $where = "";

        if($agent_code) {
            $where .= " AND S.spons_agent_code = '".$agent_code."' ";
        }

        if($agent_slno) {
            $where .= " AND S.spons_agent_slno = '".$agent_slno."' ";
        }

        if($spo_client) {
            $where .= " AND S.spons_client_code = '".$spo_client."' ";
        }

        if($date_from) {
            $where .= " AND DATE(S.created_date) >= '".$date_from."' ";
        }

        if($date_to) {
            $where .= " AND DATE(S.created_date) <= '".$date_to."' ";
        }

        $qry = "SELECT
                    S.spons_code,
                    C.client_name,
                    C.client_address,
                    C.client_phone,
                    S.spons_deal_amt,
                    S.spons_copies,
                    S.spons_can_name,
                    S.spons_agent_code
                FROM
                    pmd_sponsor S
                JOIN
                    pmd_spons_client C ON (C.client_code = S.spons_client_code AND C.unit_code = '".$this->user->user_unit_code."')
                WHERE
                    S.unit_code = '".$this->user->user_unit_code."' AND S.cancel_flag = 0 ".$where;
        return $this->db->query($qry)->result();
    }
    public function SponsorDetails($spons_code) {
        $qry = "SELECT
                    S.spons_reg_no,
                    S.spons_agent_code,
                    S.spons_agent_slno,
                    S.spons_client_code,
                    S.spons_can_by,
                    S.spons_can_name,
                    S.spons_inc_amt,
                    S.spons_inc_paid,
                    S.spons_deal_amt,
                    S.spons_rate_per_copy,
                    S.spons_copies,
                    S.spons_copy_type,
                    S.spons_copy_group,
                    S.spons_copy_code,
                    CG.group_name,
                    C.client_name,
                    C.client_address,
                    C.client_phone,
                    A.agent_name,
                    A.agent_location
                FROM
                    pmd_sponsor S
                JOIN
                    pmd_copygroup CG ON (CG.group_code = S.spons_copy_group AND CG.group_copy_code = S.spons_copy_code)
                JOIN
                    pmd_spons_client C ON (C.client_code = S.spons_client_code AND C.unit_code = '".$this->user->user_unit_code."')
                JOIN
                    pmd_agent A ON (A.agent_slno = S.spons_agent_slno AND A.agent_code = S.spons_agent_code AND A.agent_unit = '".$this->user->user_unit_code."')
                WHERE
                    S.unit_code = '".$this->user->user_unit_code."' AND S.spons_code = '".$spons_code."' LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function SponsorCopyDates($spons_code) {
        $qry = "SELECT
                    D.sdet_date,
                    D.sdet_copies
                FROM
                    pmd_sponsordetails D
                WHERE
                    D.unit_code = '".$this->user->user_unit_code."' AND D.spons_code = '".$spons_code."' ORDER BY D.sdet_date ASC";
        return $this->db->query($qry)->result();
    }
    public function UpsertSponsor()
    {
        $is_valid              = true;
        $is_update             = (int)$this->input->post('is_update',true);
        $spons_reg_no          = $this->input->post('spons_reg_no',true);

        $sale_type_rec         = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $sale_type             = isset($sale_type_rec['Code']) ? $sale_type_rec['Code'] : null;
        $sale_copy_group       = isset($sale_type_rec['Copy Group']) ? $sale_type_rec['Copy Group'] : null;
        $sale_copy_code        = isset($sale_type_rec['Copy Code']) ? $sale_type_rec['Copy Code'] : null;

        $spons_client_code_rec = json_decode(rawurldecode($this->input->post('sponsor_client_rec_sel',true)),true);
        $spons_client_code     = isset($spons_client_code_rec['Code']) ? $spons_client_code_rec['Code'] : null;

        $spons_agent_code_rec  = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $spons_agent_code      = isset($spons_agent_code_rec['Code']) ? $spons_agent_code_rec['Code'] : null;
        $spons_agent_slno      = isset($spons_agent_code_rec['SerialNumber']) ? $spons_agent_code_rec['SerialNumber'] : null;

        $spons_can_by          = (int)$this->input->post('canvassed_by_type',true);
        if($spons_can_by) {
            $sales_can_rec     = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            $sales_can_code    = isset($sales_can_rec['Code']) ? $sales_can_rec['Code'] : null;
            $sales_can_name    = isset($sales_can_rec['Name']) ? $sales_can_rec['Name'] : null;
            $sales_can_loc     = isset($sales_can_rec['Location']) ? $sales_can_rec['Location'] : null;
            if($spons_can_by == 17) $sales_can_name = $sales_can_name.' '.$sales_can_loc; //append location also if type is agent
            if(!$sales_can_code || !$sales_can_name) $is_valid = false;
        }
        else {
            $sales_can_code    = null;
            $sales_can_name    = $this->input->post('canvassed_by_others',true);
            if(!$sales_can_name) $is_valid = false;
        }

        $spons_inc_amt         = $this->input->post('spons_inc_amt',true);
        $spons_inc_paid        = $this->input->post('spons_inc_paid',true);
        $spons_deal_amt        = $this->input->post('spons_deal_amt',true);
        $spons_rate_per_copy   = $this->input->post('spons_rate_per_copy',true);
        $spons_copies          = $this->input->post('spons_copies',true);

        //trans-table
        $sponsor_copies_rec    = $this->input->post('sponsor_copies_rec',true);

        if($sale_type && $sale_copy_group && $sale_copy_code && $spons_reg_no && $spons_client_code && $spons_agent_code && 
            $spons_agent_slno && $spons_deal_amt && $spons_rate_per_copy && $spons_copies && $is_valid === true) {

            $this->db->trans_begin();

            $data = $data_upd = $data_trans = array();
            $no_id = "";
            if($is_update === 0) {
                $no_id = 'SPO_'.$this->user->user_unit_code.'_CODE';
                $spons_code = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "spons_code"=>$spons_code,
                                    "spons_pdt_code"=>$this->user->user_product_code,
                                    "spons_agent_code"=>$spons_agent_code,
                                    "spons_agent_slno"=>$spons_agent_slno,
                                    "spons_deal_amt"=>$spons_deal_amt,
                                    "spons_rate_per_copy"=>$spons_rate_per_copy,
                                    "spons_copies"=>$spons_copies,
                                    "spons_copy_type"=>$sale_type,
                                    "spons_copy_group"=>$sale_copy_group,
                                    "spons_copy_code"=>$sale_copy_code);
            }
            else {
                $spons_code = $this->input->post('spons_code',true);
            }

            $has_amend_error = false;
            $amend_error_text= "";
            if($is_update === 0 && count($sponsor_copies_rec)) {
                foreach($sponsor_copies_rec as $r) {
                    if($has_amend_error === true) continue; //skip all loop if any error occurs
                    $rec = explode("#SEP#",$r);
                    $data_amend   = array("amendment_agent_code"=>$spons_agent_code,
                                          "amendment_agent_slno"=>$spons_agent_slno,
                                          "amendment_sub_code"=>null,
                                          "amendment_copy_code"=>$sale_copy_code,
                                          "amendment_copy_group"=>$sale_copy_group,
                                          "amendment_copy_type"=>$sale_type,
                                          "amendment_scheme_code"=>$spons_code);
                    $amend_status = $this->CreateAmendment($data_amend, date('Y-m-d',strtotime($rec[0])), null, $rec[1], $spons_rate_per_copy);
                    if($amend_status->status != 200) {
                        $has_amend_error = true;
                        $amend_error_text= $amend_status->text;
                    }
                }
            }

            if($has_amend_error === false) {

                $data = array("spons_reg_no"=>strtoupper($spons_reg_no),
                              "spons_client_code"=>$spons_client_code,
                              "spons_can_by"=>$spons_can_by,
                              "spons_can_code"=>$sales_can_code,
                              "spons_can_name"=>$sales_can_name,                          
                              "spons_inc_amt"=>$spons_inc_amt,
                              "spons_inc_paid"=>$spons_inc_paid,                          
                              $is_update === 0 ? "created_by": "modified_by"=>$this->user->user_id,
                              $is_update === 0 ? "created_date": "modified_date"=>date('Y-m-d H:i:s'));

                if($is_update === 0) {
                    $data = array_merge($data,$data_upd);
                    $this->db->insert('pmd_sponsor',$data);
                }
                else {
                    $this->db->where('unit_code',$this->user->user_unit_code);
                    $this->db->where('spons_code',$spons_code);
                    $this->db->update('pmd_sponsor',$data);
                }

                //trans table entry
                //if($is_update === 1) {
                //    $this->db->where('unit_code',$this->user->user_unit_code);
                //    $this->db->where('spons_code',$spons_code);
                //    $this->db->delete('pmd_sponsordetails');
                //}
                if($is_update === 0 && count($sponsor_copies_rec)) {
                    foreach($sponsor_copies_rec as $r) {
                        $rec = explode("#SEP#",$r);
                        $data_trans[] = array("unit_code"=>$this->user->user_unit_code,
                                              "spons_code"=>$spons_code,
                                              "sdet_date"=>date('Y-m-d',strtotime($rec[0])),
                                              "sdet_copies"=>$rec[1]);
                    }
                    $this->db->insert_batch('pmd_sponsordetails',$data_trans);
                }

                if($is_update === 0) {
                    $this->UpdatePrimaryId($spons_code, $no_id);
                }

                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');
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
                $this->Message->text=$amend_error_text;
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Journal Entry
    public function CreateJournalEntry(){
        $jour_credit=$jour_debit=null;
        $jour_agent = json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $jour_date= date('Y-m-d',strtotime($this->input->post('jour_date')));
        $jour_head = json_decode(rawurldecode($this->input->post('accounthead_rec_sel',true)),true);
        if($jour_head["Debit/Credit"] == "DEBIT"){
            $jour_debit =$this->input->post('jour_amount');
        }
        else if($jour_head["Debit/Credit"] == "CREDIT"){
            $jour_credit=$this->input->post('jour_amount');
        }
        $jour_narration=strtoupper($this->input->post('jour_narrate',true));
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Journal);
        if(!$finalize_date || strtotime($finalize_date." +1 day")>strtotime($jour_date)){
            $this->Message->status=400;
            $this->Message->text="Date already finalized.";
            return $this->Message;
        }
        $this->db->trans_begin();
        $je_code = $this->GetPrimaryId("JE_".$this->user->user_unit_code."_CODE");
        $data = array("je_code"=>$je_code,
            "unit_code"=>$this->user->user_unit_code,
            "je_pdt_code"=>$this->user->user_product_code,
            "je_agent_code"=>$jour_agent["Code"],
            "je_agent_slno"=>$jour_agent["SerialNumber"],
            "je_debit_amount"=>$jour_debit,
            "je_credit_amount"=>$jour_credit,
            "je_ac_code"=>$jour_head["Code"],
            "je_narration"=>$jour_narration,
            "je_date"=>$jour_date,
            "cancel_flag"=>0,
            "created_by"=>$this->user->user_id,
            "created_date"=>date('Y-m-d H:i:s'));

        $this->db->insert('pmd_journal',$data);
        $this->UpdatePrimaryId($je_code, "JE_".$this->user->user_unit_code."_CODE");
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
        return $this->Message;
    }
    public function GetJournalEntry(){
        $where_condition =  "";
        $finalize_date   =  $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Journal);
        $journal_date    =  date('Y-m-d',strtotime($finalize_date." +1 day"));
        $jour_agent      =  json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $from_date       =  $this->input->post('jour_from_date') ? date('Y-m-d',strtotime($this->input->post('jour_from_date'))) : $journal_date;
        $to_date         =  $this->input->post('jour_to_date') ? date('Y-m-d',strtotime($this->input->post('jour_to_date'))) : $journal_date;
        if($from_date){
            $where_condition .= " AND DATE(t1.je_date) >= '". $from_date ."'";
        }
        if($to_date){
            $where_condition .= " AND DATE(t1.je_date) <= '". $to_date ."'";
        }
        if($jour_agent){
            $where_condition .= " AND t1.je_agent_code = '". $jour_agent["Code"]."'";
        }
        
      $qury = "SELECT
                    t1.je_code,
                    t1.je_date,
                    t1.je_agent_code,
                    t1.je_ac_code,
                    t1.je_debit_amount,
                    t1.je_credit_amount,
                    t1.je_narration,
                    t1.cancel_flag,
                    t2.agent_slno,
                    t2.agent_code,
                    t2.agent_name,
                    t2.agent_location,
                    t2.agent_phone,
                    t3.ac_code,
                    t3.ac_name
                FROM
                    pmd_journal t1
               JOIN pmd_agent t2 ON  je_agent_slno = t2.agent_slno
               JOIN pmd_accountheads t3 ON t1.je_ac_code = t3.ac_code
                WHERE
                    t1.cancel_flag=0
                    ".$where_condition;
        return $this->db->query($qury)->result();
    }
    public function EditJournalEntry(){
        $je_id = $this->input->post('jeCode');
        $qury = "SELECT
                    t1.je_code,
                    t1.je_date,
                    t1.je_agent_code,
                    t1.je_ac_code,
                    t1.je_debit_amount,
                    t1.je_credit_amount,
                    t1.je_agent_slno,
                    t1.je_narration,
                    t1.cancel_flag,
                    t2.agent_slno,
                    t2.agent_code,
                    t2.agent_name,
                    t2.agent_location,
                    t2.agent_phone,
                    t3.ac_code,
                    t3.ac_name
                FROM
                    pmd_journal t1
               JOIN pmd_agent t2 ON  je_agent_slno = t2.agent_slno
               JOIN pmd_accountheads t3 ON t1.je_ac_code= t3.ac_code
                WHERE
                    t1.je_code = '".$je_id."' ";
        return $this->db->query($qury)->row();
    }
    public function UpdateJournalEntry(){
        $journal_credit=$journal_debit=null;
        $journal_entry_code = $this->input->post('jeCode');
        $journal_entry_agent = json_decode(rawurldecode($this->input->post('jeAgentcode',true)),true);
        $journal_entry_head = json_decode(rawurldecode($this->input->post('jeAccntHead',true)),true);
        $journal_entry_narratn = strtoupper($this->input->post('jeNarration',true));
        $jour_date = $this->input->post('jour_date');
        if($journal_entry_head["Debit/Credit"] == "DEBIT"){
            $journal_debit =$this->input->post('jeAmount');
        }
        else if($journal_entry_head["Debit/Credit"] == "CREDIT"){
            $journal_credit=$this->input->post('jeAmount');
        }
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Journal);
        if(!$finalize_date || strtotime($finalize_date." +1 day")>strtotime($jour_date)){
            $this->Message->status=400;
            $this->Message->text="Date already finalized.";
            return $this->Message;
        }
        if(($journal_debit>0 || $journal_credit>0) && isset($journal_entry_agent["Code"]) && isset($journal_entry_head["Code"])){
            $data = array(  "je_code"=>$journal_entry_code,
                            "unit_code"=>$this->user->user_unit_code,
                            "je_pdt_code"=>$this->user->user_product_code,
                            "je_agent_code"=>$journal_entry_agent["Code"],
                            "je_agent_slno"=>$journal_entry_agent["SerialNumber"],
                            "je_debit_amount"=>$journal_debit,
                            "je_credit_amount"=>$journal_credit,
                            "je_ac_code"=>$journal_entry_head["Code"],
                            "je_narration"=>$journal_entry_narratn,
                            "modified_by"=>$this->user->user_id,
                            "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('je_code', $journal_entry_code);
            $this->db->update('pmd_journal', $data);
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
        }else{
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function DeleteJournalEntry(){
        $journal_code = $this->input->post('journalCode',true);
        $this->db->trans_begin();
        $data = array("cancel_flag"=>1,
                      "modified_by"=>$this->user->user_id,
                      "modified_date"=>date('Y-m-d H:i:s'));
        $this->db->where('je_code',$journal_code);
        $this->db->update('pmd_journal',$data);
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

    //Ente Kaumudi
    public function EnteKaumudiLists() {
        $spo_client_rec = json_decode(rawurldecode($this->input->post('sponsor_client_rec_sel',true)),true);
        $spo_client     = isset($spo_client_rec['Code']) ? $spo_client_rec['Code'] : null;

        $date_from      = date('Y-m-d',strtotime($this->input->post('date_from',true)));
        $date_to        = date('Y-m-d',strtotime($this->input->post('date_to',true)));

        $where = "";
        if($spo_client) {
            $where .= " AND E.ek_client_code = '".$spo_client."' ";
        }

        if($date_from) {
            $where .= " AND DATE(E.created_date) >= '".$date_from."' ";
        }

        if($date_to) {
            $where .= " AND DATE(E.created_date) <= '".$date_to."' ";
        }

        $qry = "SELECT
                    E.ek_slno,
                    E.ek_deal_amt,
                    E.ek_copies,
                    E.created_date,
                    C.client_name,
                    C.client_address,
                    C.client_phone
                FROM
                    pmd_ek E
                JOIN
                    pmd_spons_client C ON (C.client_code = E.ek_client_code AND C.unit_code = '".$this->user->user_unit_code."')
                WHERE
                    E.unit_code = '".$this->user->user_unit_code."' ".$where;
        return $this->db->query($qry)->result();
    }
    public function EnteKaumudiDetails($ek_slno) {  
        $qry = "SELECT
                    K.ek_slno,
                    K.ek_copy_type,
                    K.ek_reg_no,
                    K.ek_client_code,
                    K.ek_can_by,
                    K.ek_can_code,
                    K.ek_can_name,
                    K.ek_deal_amt,
                    K.ek_rate,
                    K.ek_copies,
                    K.ek_inc_amt,
                    K.ek_inc_paid,
                    C.client_name,
                    C.client_address,
                    C.client_phone
                FROM
                    pmd_ek K
                JOIN
                    pmd_spons_client C ON (C.client_code = K.ek_client_code AND C.unit_code = '".$this->user->user_unit_code."')                
                WHERE
                    K.unit_code = '".$this->user->user_unit_code."' AND K.ek_slno = '".$ek_slno."' LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function EnteKaumudiSubscribers($ek_slno) {
        $qry = "SELECT
                    ET.etrans_copies,
                    ET.etrans_start_date,
                    ET.etrans_status,
                    ET.etrans_status_date,
                    ET.ek_sub_code,
                    ET.ek_agent_code,
                    ET.ek_agent_slno,
                    S.sub_name,
                    S.sub_address,
                    A.agent_name,
                    A.agent_location
                FROM
                    pmd_ek_trans ET
                        JOIN
                    pmd_subscriber S ON (S.sub_code = ET.ek_sub_code AND S.sub_unit_code = '".$this->user->user_unit_code."')
                        JOIN
                    pmd_agent A ON (A.agent_slno = ET.ek_agent_slno AND A.agent_code = ET.ek_agent_code AND A.agent_unit = '".$this->user->user_unit_code."')
                WHERE
                    ET.unit_code = '".$this->user->user_unit_code."' AND
                    ET.ek_slno = '".$ek_slno."'
                ORDER BY etrans_start_date";
        return $this->db->query($qry)->result();
    }
    public function UpsertEnteKaumudi()
    {
        $is_valid           = true;
        $is_update          = (int)$this->input->post('is_update',true);
        $ek_reg_no          = strtoupper($this->input->post('ek_reg_no',true));
        $ek_client_code_rec = json_decode(rawurldecode($this->input->post('sponsor_client_rec_sel',true)),true);
        $ek_client_code     = isset($ek_client_code_rec['Code']) ? $ek_client_code_rec['Code'] : null;
        $ek_can_by          = (int)$this->input->post('canvassed_by_type',true);

        if($ek_can_by) {
            $ek_can_rec     = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            $ek_can_code    = isset($ek_can_rec['Code']) ? $ek_can_rec['Code'] : null;
            $ek_can_name    = isset($ek_can_rec['Name']) ? $ek_can_rec['Name'] : null;
            $ek_can_loc     = isset($ek_can_rec['Location']) ? $ek_can_rec['Location'] : null;
            if($ek_can_by == 17) $ek_can_name = $ek_can_name.' '.$ek_can_loc; //append location also if type is agent
            if(!$ek_can_code || !$ek_can_name) $is_valid = false;
        }
        else {
            $ek_can_code    = null;
            $ek_can_name    = $this->input->post('canvassed_by_others',true);
            if(!$ek_can_name) $is_valid = false;
        }

        $ek_inc_amt         = $this->input->post('ek_inc_amt',true);
        $ek_inc_paid        = $this->input->post('ek_inc_paid',true);
        $ek_deal_amt        = $this->input->post('ek_deal_amount',true);
        $ek_rate            = $this->input->post('ek_rate',true);
        $ek_copies          = $this->input->post('ek_copies',true);
        $ek_copy_type       = "CPT0000006"; //entekaumudi copy type
        $ek_copy_group      = "CPG0000006";
        $ek_copy_code       = "CP0004";        

        //trans-table
        $copies_rec         = $this->input->post('ek_copies_rec',true);

        //check duplicate subscribers exists under same EK slno
        $subscribers        = array();
        $has_duplicate_subs = false;
        foreach($copies_rec as $r) {
            $rec = json_decode(rawurldecode($r),true);
            $subscribers[] = $rec['SubCode'];
        }
        if(count(array_unique($subscribers)) < count($subscribers)) $has_duplicate_subs = true;

        if($ek_reg_no && $ek_client_code && $ek_deal_amt && $ek_rate && $ek_copies && $is_valid === true && $has_duplicate_subs === false) {

            $this->db->trans_begin();

            $data = $data_upd = $data_trans = array();
            $no_id = "";
            if($is_update === 0) {
                $no_id = 'EK_'.$this->user->user_unit_code.'_CODE';
                $ek_slno = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "ek_slno"=>$ek_slno,
                                    "ek_copy_type"=>$ek_copy_type,
                                    "ek_copy_group"=>$ek_copy_group,
                                    "ek_copy_code"=>$ek_copy_code,                                                                       
                                    "ek_deal_amt"=>$ek_deal_amt,
                                    "ek_paid_amt"=>0,
                                    "ek_balance"=>$ek_deal_amt,
                                    "ek_rate"=>$ek_rate,
                                    "ek_copies"=>$ek_copies,
                                    "ek_inc_amt"=>$ek_inc_amt,
                                    "ek_inc_paid"=>$ek_inc_paid);
            }
            else {
                $ek_slno = $this->input->post('ek_slno',true);
            }

            $has_amend_error = false;
            $amend_error_text= "";
            if($is_update === 0 && count($copies_rec)) {
                foreach($copies_rec as $r) {
                    if($has_amend_error === true) continue; //skip all loop if any error occurs
                    $rec = json_decode(rawurldecode($r),true);
                    $data_amend   = array("amendment_agent_code"=>$rec['AgentCode'],
                                          "amendment_agent_slno"=>$rec['AgentSlNo'],
                                          "amendment_sub_code"=>$rec['SubCode'],
                                          "amendment_copy_code"=>$ek_copy_code,
                                          "amendment_copy_group"=>$ek_copy_group,
                                          "amendment_copy_type"=>$ek_copy_type,
                                          "amendment_scheme_code"=>$ek_slno,
                                          "amendment_sun"=>0,
                                          "amendment_sat"=>0);
                    $amend_status = $this->CreateAmendment($data_amend, date('Y-m-d',strtotime($rec['StartDate'])), null, $rec['Copies'], $ek_rate);
                    if($amend_status->status != 200) {
                        $has_amend_error = true;
                        $amend_error_text= $amend_status->text;
                    }
                }
            }

            if($has_amend_error === false) {

                $data = array("ek_reg_no"=>$ek_reg_no,
                              "ek_client_code"=>$ek_client_code,
                              "ek_can_by"=>$ek_can_by,
                              "ek_can_code"=>$ek_can_code,
                              "ek_can_name"=>$ek_can_name,
                              $is_update === 0 ? "created_by": "modified_by"=>$this->user->user_id,
                              $is_update === 0 ? "created_date": "modified_date"=>date('Y-m-d H:i:s'));

                if($is_update === 0) {
                    $data = array_merge($data,$data_upd);
                    $this->db->insert('pmd_ek',$data);
                }
                else {
                    $this->db->where('unit_code',$this->user->user_unit_code);
                    $this->db->where('spons_code',$ek_slno);
                    $this->db->update('pmd_ek',$data);
                }

                //trans table entry
                if($is_update === 0 && count($copies_rec)) {
                    foreach($copies_rec as $r) {
                        $rec = json_decode(rawurldecode($r),true);
                        $data_trans[] = array("unit_code"=>$this->user->user_unit_code,
                                              "ek_slno"=>$ek_slno,
                                              "ek_sub_code"=>$rec["SubCode"],
                                              "ek_agent_code"=>$rec["AgentCode"],
                                              "ek_agent_slno"=>$rec["AgentSlNo"],
                                              "etrans_copies"=>$rec["Copies"],
                                              "etrans_start_date"=>date('Y-m-d',strtotime($rec["StartDate"])));                                     
                    }
                    $this->db->insert_batch('pmd_ek_trans',$data_trans);
                }

                if($is_update === 0) {
                    $this->UpdatePrimaryId($ek_slno, $no_id);
                }

                if($this->db->trans_status() === TRUE)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');
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
                $this->Message->text=$amend_error_text;
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$has_duplicate_subs === false ? $this->lang->line('params_missing') : "Duplicate Subscribers Found!";
        }
        return $this->Message;
    }
    public function ManageEnteKaumudiStatus() {
        $records       = json_decode($this->input->post('records',true),true);
        $new_status    = (int)$this->input->post('new_status',true);
        if(count($records)) {
            $this->db->trans_begin();

            $params_missed = $is_same_status  = false;
            foreach($records as $r) {
                if($r['subscriber_code'] && $r['scheme_code']) {
                    if($new_status == $r['current_status']) $is_same_status = true;
                }
                else {
                    $params_missed = true;
                }
            }

            if($is_same_status === true || $params_missed === true) {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$params_missed === true ? $this->lang->line('params_missing') : "Some subscribers are already ".Enum::getConstant('CopyStatus',$new_status);
            }
            else {
                $amend_status = new stdClass();
                $amend_status->status = 400;
                $has_amend_error = false;
                $amend_error_text= "";

                //amendment entry
                foreach($records as $r) {
                    $scheme_code     = $r['scheme_code'];
                    $subscriber_code = $r['subscriber_code'];
                    if($new_status == CopyStatus::Paused) {
                        $amend_status = $this->StopAmendment($scheme_code,$subscriber_code);
                    }
                    else if($new_status == CopyStatus::Started) {
                        $amend_status = $this->StartAmendment($scheme_code,$subscriber_code);
                    }
                    if($amend_status->status != 200) {
                        $has_amend_error = true;
                        $amend_error_text= $amend_status->text;
                    }
                }

                if($has_amend_error === false) {

                    foreach($records as $r) {
                        $data = array("etrans_status"=>$new_status,
                                      "etrans_status_date"=>date('Y-m-d H:i:s'));
                        $this->db->where('unit_code',$this->user->user_unit_code);
                        $this->db->where('ek_slno',$r['scheme_code']);
                        $this->db->where('ek_sub_code',$r['subscriber_code']);
                        $this->db->update('pmd_ek_trans',$data);
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
                else {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$amend_error_text;
                }
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }

    //Free copy
    public function UpsertFreeCopy(){
        $fc_code= $this->input->post('fc_code');
        if($fc_code){
            $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        }
        $is_update = $fc_code ? true : false;
        $free_end_date = null;
        $free_reg = strtoupper($this->input->post('free_reg',true));
        $free_sub = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $free_copy_type = json_decode(rawurldecode($this->input->post('copy_group_rec_sel',true)),true);
        $free_strt_date = date('Y-m-d',strtotime($this->input->post('start_dte')));
        $free_prev_from_dte = date('Y-m-d',strtotime($this->input->post('prev_start_date')));
        $free_prev_to_dte = date('Y-m-d',strtotime($this->input->post('prev_end_date')));
        $free_end_flag = $this->input->post('endflag',true);
        if($free_end_flag == 1){
            $free_end_date = date('Y-m-d',strtotime($this->input->post('end_dte')));
        }else{
            $free_end_date = null;
        }
        $free_comm_app = $this->input->post('comm_app',true);
        $free_copy = $this->input->post('free_copy',true);
        $free_remark = strtoupper($this->input->post('remark',true));
        if($free_reg && $free_sub  && $free_copy_type && $free_strt_date  && $free_copy > 0){
            $this->db->trans_begin();
            $data = $data_upd = array();
            if($is_update == false){
                $fc_code = $this->GetPrimaryId("FRE_".$this->user->user_unit_code."_CODE");
                $data_upd = array("unit_code"=>$this->user->user_unit_code,
                    "free_slno"=>$fc_code,
                    "free_pdt_code"=>$this->user->user_product_code );
            }
            $data =  array( "free_reg_no"=>$free_reg,
                            "free_sub_code"=>$free_sub["Code"],
                            "free_agent_code"=>$free_sub["AgentCode"],
                            "free_agent_slno"=>$free_sub["AgentSlNo"],
                            "free_copy_type"=>$free_copy_type["Code"],
                            "free_copies"=>$free_copy,
                            "free_start_date"=>$free_strt_date,
                            "free_end_flag"=>$free_end_flag,
                            "free_end_date"=>$free_end_date,
                            "free_comm"=>$free_comm_app,
                            "free_remarks"=>$free_remark ? $free_remark : null,
                            "cancel_flag"=>0,
                            $is_update ? "modified_by" : "created_by"=>$this->user->user_id,
                            $is_update ? "modified_date" : "created_date"=>date('Y-m-d H:i:s'));
            $amend_data= array(
                    "amendment_agent_code"=>$free_sub["AgentCode"],
                    "amendment_agent_slno"=>$free_sub["AgentSlNo"],
                    "amendment_sub_code"=>$free_sub["Code"],
                    "amendment_copy_code"=>$free_copy_type["Copy Code"],
                    "amendment_copy_group"=>$free_copy_type["Copy Group"],
                    "amendment_copy_type"=>$free_copy_type["Code"],
                    "amendment_scheme_code"=>$fc_code
                    );
            if($is_update === false){
               $amend_status = $this->CreateAmendment($amend_data,$free_strt_date,$free_end_date,$free_copy,0);
               if($amend_status->status === 200){
                    $data = array_merge($data,$data_upd);
                    $this->db->insert('pmd_free',$data);
                    $this->UpdatePrimaryId($fc_code, "FRE_".$this->user->user_unit_code."_CODE");
               }else{
                  $this->Message->status=400;
                  $this->Message->text=$amend_status->text;
                  return $this->Message;
              }
            }
            else{
                 if(strtotime($free_prev_from_dte)!=strtotime($free_strt_date) || strtotime($free_prev_to_dte)!=strtotime($free_end_date)){
                    $amend_status = $this->StopAmendment($amend_data, $free_prev_from_dte, date("Y-m-d 00:00:00"), $fc_code, $free_copy, 0);
                    if($amend_status->status === 200){
                        $amend_status = $this->CreateAmendment($amend_data,$free_strt_date,$free_end_date,$free_copy,0);
                        if($amend_status->status === 400){
                            $this->Message->status=400;
                            $this->Message->text=$amend_status->text;
                            return $this->Message;
                        }
                    }else{
                        $this->Message->status=400;
                        $this->Message->text=$amend_status->text;
                        return $this->Message;
                    }
                }
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('free_slno',$fc_code);
                $this->db->update('pmd_free',$data);
            }
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text= $is_update === TRUE ? $this->lang->line('updated_success') : $this->lang->line('added_success');
            } else {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        else{
        $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function GetFreeCopies(){
        $where_condition =  "";
        //$finalize_date   =  $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Journal);
        //$free_date    =  date('Y-m-d',strtotime($finalize_date." +1 day"));
        $free_agent      =  json_decode(rawurldecode($this->input->post('agent_rec_sel',true)),true);
        $from_date       =  $this->input->post('free_from_date') ? date('Y-m-d',strtotime($this->input->post('free_from_date'))) : date('Y-m-d');
        $to_date         =  $this->input->post('free_to_date') ? date('Y-m-d',strtotime($this->input->post('free_to_date'))) : date('Y-m-d');
        if($from_date){
            $where_condition .= " AND DATE(t1.created_date) >= '". $from_date ."'";
        }
        if($to_date){
            $where_condition .= " AND DATE(t1.created_date) <= '". $to_date ."'";
        }
        if($free_agent){
            $where_condition .= " AND t1.free_agent_code = '". $free_agent["Code"]."'";
        }

        $sql = "SELECT
                        t1.unit_code,
                        t1.free_slno,
                        t1.free_reg_no,
                        t1.free_pdt_code,
                        t1.free_sub_code,
                        t1.free_agent_code,
                        t1.free_agent_slno,
                        t1.free_copy_type,
                        t1.free_copies,
                        t1.free_start_date,
                        t1.free_end_date,
                        t1.free_remarks,
                        t1.free_status,
                        t1.free_agent_code,
                        t1.free_agent_slno,
                        t1.cancel_flag,
                        t1.created_by,
                        t1.created_date,
                        t2.sub_name,
                        t2.sub_address,
                        t2.sub_phone,
                        t3.agent_code,
                        t3.agent_name,
                        t3.agent_location,
                        t4.user_login_name,
                        t4.user_emp_name,
                        t5.copytype_name
                FROM
                       pmd_free t1
                JOIN
                       pmd_copytype t5 ON (t5.copytype_code = t1.free_copy_type AND t5.copy_code = 'CP0002')
                JOIN
                      pmd_subscriber t2 ON  ( t2.sub_unit_code = '". $this->user->user_unit_code ."' AND t1.free_sub_code = t2.sub_code  )
                JOIN
                      pmd_agent t3 ON   (t3.agent_unit = '". $this->user->user_unit_code ."' AND t1.free_agent_slno = t3.agent_slno AND t1.free_agent_code = t3.agent_code  )
                JOIN
                     pmd_userdetails t4 ON (t4.user_unit = '". $this->user->user_unit_code ."' AND t1.created_by = t4.user_id)
                
                WHERE
                    t1.unit_code = '". $this->user->user_unit_code ."' AND
                     t1.cancel_flag = 0 ".$where_condition;
        return $this->db->query($sql)->result();
    }
    public function GetFreeCopydetails($fc_code) {
        $sql = "SELECT
                        t1.unit_code,
                        t1.free_slno,
                        t1.free_reg_no,
                        t1.free_pdt_code,
                        t1.free_sub_code,
                        t1.free_agent_code,
                        t1.free_agent_slno,
                        t1.free_copy_type,
                        t1.free_copies,
                        t1.free_start_date,
                        t1.free_end_date,
                        t1.free_remarks,
                        t1.free_comm,
                        t1.free_agent_code,
                        t1.free_agent_slno,
                        t1.free_end_flag,
                        t1.cancel_flag,
                        t1.created_by,
                        t1.created_date,
                        t1.free_status,
                        t2.sub_name,
                        t2.sub_address,
                        t2.sub_phone,
                        t3.agent_code,
                        t3.agent_name,
                        t3.agent_slno,
                        t3.agent_location,
                        t4.user_login_name,
                        t4.user_emp_name,
                        t5.copytype_name,
                        t5.copy_code,
                        t5.group_code
                FROM
                       pmd_free t1
                JOIN
                      pmd_subscriber t2 ON (sub_unit_code = '".$this->user->user_unit_code."' AND t1.free_sub_code = t2.sub_code)
                JOIN
                      pmd_agent t3 ON  (agent_unit = '".$this->user->user_unit_code."' AND t1.free_agent_code = t3.agent_code)
                JOIN
                     pmd_userdetails t4 ON t1.created_by = t4.user_id
                JOIN
                    pmd_copytype t5 ON (t5.copytype_code = t1.free_copy_type AND t5.copy_code = 'CP0002')
                WHERE
                   t1.free_slno='".$fc_code."' AND t1.cancel_flag=0";
        return $this->db->query($sql)->row();
    }
    public function PauseFreeCopy($data){
            $this->db->where('free_slno', $data['free_slno']);
            $this->db->update('pmd_free', $data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=" Paused Successfully.";
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
		return json_encode($this->Message);
    }
    public function RestartFreeCopy($data){
            $this->db->where('free_slno', $data['free_slno']);
            $this->db->update('pmd_free', $data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=" Restarted Successfully.";
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
		return json_encode($this->Message);
    }
    public function StopFreeCopy($data){
        $this->db->where('free_slno', $data['free_slno']);
        $this->db->update('pmd_free', $data);
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=" Stoped Successfully.";
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
		return json_encode($this->Message);
    }
    public function DeleteFreeCopy($data){
        $this->db->trans_begin();
            $this->db->where('free_slno',$data['free_slno']);
        $this->db->update('pmd_free',$data);
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
       
        return json_encode($this->Message);
    }

    //InitiateAmendments
    public function TriggerInitiateAmendments() {
        $this->db->trans_begin();
        //1.CheckIsDateFinalized
        $last_fin_date     = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Amendment);
        $str_last_fin_date = strtotime($last_fin_date);
        $str_post_date     = strtotime($this->input->post('next_finalize_date',true));
        $post_date         = date('Y-m-d',$str_post_date);
        $include_ek        = (int)$this->input->post('include_ek',true);
        $data              = array();

        if($str_post_date > $str_last_fin_date) {
            
            //2.CheckDateIsHoliday
            $hqry = "SELECT
                           holiday_desc,
                           holiday_date
                      FROM 
                           pmd_holiday 
                      WHERE 
                          holiday_unit = '". $this->user->user_unit_code ."' AND
                          holiday_product_code = '". $this->user->user_product_code ."' AND
                          DATE(holiday_date) = '". $post_date ."' AND
                          holiday_office = 0
                      LIMIT 1";
            $hres = $this->db->query($hqry)->row();
            if(isset($hres->holiday_date)) {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text="Date already set as holiday (". $hres->holiday_desc .")!";
            }
            else {
                //3.CheckDateAlreadyInitiated
                $iqry = "SELECT 
                                COUNT(*) AS is_amend_intiated 
                            FROM 
                                pmd_finalize
                            WHERE
                                unit_code = '". $this->user->user_unit_code ."' AND
                                product_code = '". $this->user->user_product_code ."' AND
                                entry_type = '". FinalizeType::InitiateAmendments ."' AND
                                DATE(entry_date) = '". $post_date ."' AND
                                cancel_flag = 0
                            LIMIT 1";
                $is_amend_intiated = $this->db->query($iqry)->row()->is_amend_intiated;

                if($is_amend_intiated) {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text="Amendment already intiated on this date!";
                }
                else {

                    $where = "";
                    if($include_ek === 0) {
                        $where = " AND amendment_copy_type != 'CPT0000006'";
                    }
                    $aqry = "SELECT 
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
                                    amendment_pause_flag, 
                                    amendment_auto_flag,
                                    amendment_bfree_flag
                                FROM
                                    pmd_temp_amendment
                                WHERE
                                    unit_code = '". $this->user->user_unit_code ."' AND
                                    amendment_pdt_code = '". $this->user->user_product_code ."' AND
                                    DATE(amendment_start_date) <= '". $post_date ."' AND
                                   (DATE(amendment_end_date)   >= '". $post_date ."' OR amendment_end_date IS NULL ) AND
                                    amendment_pause_flag = 0 AND
                                    cancel_flag = 0". $where;
                    $aresults = $this->db->query($aqry)->result();
                    $count    = count($aresults);
                    if($count) {
                        $amendment_code = $this->GetPrimaryId('AMD_'.$this->user->user_unit_code.'_CODE');
                        $week_day       = strtoupper(date("D",$str_post_date)); //returns SUN, MON etc
                        $rate_flag      = $week_day == 'SUN' ? 'SUN' : $this->user->user_product_code;
                        $rate           = $this->GetRate($rate_flag, $this->user->user_product_code);
                        $available_days = $agent_comm = array();
                        foreach($aresults as $r) {

                            $available_days['SUN'] = $r->amendment_sun;
                            $available_days['MON'] = $r->amendment_mon;
                            $available_days['TUE'] = $r->amendment_tue;
                            $available_days['WED'] = $r->amendment_wed;
                            $available_days['THU'] = $r->amendment_thu;
                            $available_days['FRI'] = $r->amendment_fri;
                            $available_days['SAT'] = $r->amendment_sat;

                            if(isset($available_days[$week_day]) && $available_days[$week_day] == 1) {

                                $amendment_rate_per_copy = $r->amendment_copy_code == 'CP0001' ? $rate : 0;
                                
                                if(isset($agent_comm[$r->amendment_agent_slno])) {
                                    $agent_commiss   = $agent_comm[$r->amendment_agent_slno]['commission'];
                                    $agent_comm_flag = $agent_comm[$r->amendment_agent_slno]['commission_flag'];
                                }
                                else {
                                    $cqry = "SELECT
                                                agent_comm,
                                                agent_comm_flag
                                            FROM
                                                pmd_agentdetails
                                            WHERE
                                                agent_unit = '".$this->user->user_unit_code."' AND
                                                agent_product_code = '".$this->user->user_product_code."' AND
                                                agent_slno = '".$r->amendment_agent_slno."' AND
                                                agent_code = '".$r->amendment_agent_code."'
                                            LIMIT 1";
                                    $cresults = $this->db->query($cqry)->row();
                                    $agent_commiss   = $cresults->agent_comm;
                                    $agent_comm_flag = $cresults->agent_comm_flag;
                                    $agent_comm[$r->amendment_agent_slno]['commission']      = $agent_commiss;
                                    $agent_comm[$r->amendment_agent_slno]['commission_flag'] = $agent_comm_flag;
                                }

                                $amendment_commison  =
                                $amendment_comm_flag =
                                $amendment_amt       = 
                                $amendment_comm_amt  = 0;

                                if($agent_comm_flag == 1 && $r->amendment_copy_code == 'CP0001') { //commission in %
                                    $amendment_commison  = $agent_commiss;
                                    $amendment_comm_flag = $agent_comm_flag;
                                    $amendment_amt       = $amendment_rate_per_copy*$r->amendment_copies;
                                    $amendment_comm_amt  = ($amendment_amt*$agent_commiss)/100;
                                }
                                else if($agent_comm_flag == 0 && $r->amendment_copy_code == 'CP0001') { 
                                    $amendment_commison  = $agent_commiss;
                                    $amendment_comm_flag = $agent_comm_flag;
                                    $amendment_amt       = $amendment_rate_per_copy*$r->amendment_copies;
                                    $amendment_comm_amt  = $agent_commiss*$r->amendment_copies;
                                }

                                $data[] = array("amendment_code"=>$amendment_code,
                                                "unit_code"=>$this->user->user_unit_code,
                                                "amendment_pdt_code"=>$this->user->user_product_code,
                                                "amendment_date"=>$post_date,
                                                "amendment_agent_code"=>$r->amendment_agent_code,
                                                "amendment_agent_slno"=>$r->amendment_agent_slno,
                                                "amendment_sub_code"=>$r->amendment_sub_code,
                                                "amendment_copy_code"=>$r->amendment_copy_code,
                                                "amendment_copy_group"=>$r->amendment_copy_group,
                                                "amendment_copy_type"=>$r->amendment_copy_type,
                                                "amendment_scheme_code"=>$r->amendment_scheme_code,
                                                "amendment_prev_copies"=>0,
                                                "amendment_plus"=>$r->amendment_copies,
                                                "amendment_minus"=>0,
                                                "amendment_total"=>$r->amendment_copies,
                                                "amendment_auto_flag"=>$r->amendment_auto_flag,
                                                "amendment_rate_per_copy"=>$amendment_rate_per_copy,
                                                "amendment_commison"=>$amendment_commison,
                                                "amendment_comm_flag"=>$amendment_comm_flag,
                                                "amendment_amt"=>round($amendment_amt,2),
                                                "amendment_comm_amt"=>round($amendment_comm_amt,2),
                                                "amendment_bfree_flag"=>$r->amendment_bfree_flag,                                                
                                                "cancel_flag"=>0);
                                $amendment_code = $this->AutoIncrement($amendment_code);

                                //if end date is available and equal to init date, insert negative entries
                                if($r->amendment_end_date && strtotime($r->amendment_end_date) == $str_post_date) {
                                    $data[] = array("amendment_code"=>$amendment_code,
                                                    "unit_code"=>$this->user->user_unit_code,
                                                    "amendment_pdt_code"=>$this->user->user_product_code,
                                                    "amendment_date"=>$post_date,
                                                    "amendment_agent_code"=>$r->amendment_agent_code,
                                                    "amendment_agent_slno"=>$r->amendment_agent_slno,
                                                    "amendment_sub_code"=>$r->amendment_sub_code,
                                                    "amendment_copy_code"=>$r->amendment_copy_code,
                                                    "amendment_copy_group"=>$r->amendment_copy_group,
                                                    "amendment_copy_type"=>$r->amendment_copy_type,
                                                    "amendment_scheme_code"=>$r->amendment_scheme_code,
                                                    "amendment_prev_copies"=>$r->amendment_copies,
                                                    "amendment_plus"=>0,
                                                    "amendment_minus"=>$r->amendment_copies,
                                                    "amendment_total"=>-$r->amendment_copies,
                                                    "amendment_auto_flag"=>$r->amendment_auto_flag,
                                                    "amendment_rate_per_copy"=>$amendment_rate_per_copy,
                                                    "amendment_commison"=>$amendment_commison,
                                                    "amendment_comm_flag"=>$amendment_comm_flag,
                                                    "amendment_amt"=>-round($amendment_amt,2),
                                                    "amendment_comm_amt"=>-round($amendment_comm_amt,2),
                                                    "amendment_bfree_flag"=>$r->amendment_bfree_flag,
                                                    "cancel_flag"=>0);
                                    $amendment_code = $this->AutoIncrement($amendment_code);
                                }//minus entries
                            }//if available on week days
                        }//forloop

                        $this->db->insert_batch('pmd_amendment',$data);
                        $this->UpdatePrimaryId($amendment_code,'AMD_'.$this->user->user_unit_code.'_CODE',false);

                        //7.Finalize date to avoid multiple initiate amendments
                        $finalize_data = array("unit_code"=>$this->user->user_unit_code,
                                               "product_code"=>$this->user->user_product_code,
                                               "entry_type"=>FinalizeType::InitiateAmendments,
                                               "entry_date"=>$post_date,
                                               "entry_period"=>null,
                                               "cancel_flag"=>0,
                                               "created_by"=>$this->user->user_id,
                                               "created_date"=>date('Y-m-d H:i:s'));
                        $this->db->insert('pmd_finalize',$finalize_data);

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
                        $this->db->trans_rollback();
                        $this->Message->status=400;
                        $this->Message->text="No amendments found!";
                    }
                }//else amend not intiated already
           }//else not holiday
        }
        else {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text="Date already finalized!";
        }
        return $this->Message;
    }

    //FinalizeAmendments
    public function CreateFinalizeAmendments() {        
        if($this->input->post('amend_date')) {
            $this->db->trans_begin();
            $date = date('Y-m-d', strtotime($this->input->post('amend_date')));
            $condition=" unit_code        = '".$this->user->user_unit_code."' AND 
                         product_code     = '".$this->user->user_product_code."' AND
                         entry_type       = '".FinalizeType::Amendment."' AND
                         DATE(entry_date) = '".$date."' AND
                         cancel_flag      = 0";       
            if($this->IsDuplicate('pmd_finalize',$condition)) {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text="Date already finalized!";
            }
            else {
                $data = array("unit_code"=>$this->user->user_unit_code,
                              "entry_date"=>$date,
                              "product_code"=>$this->user->user_product_code,
                              "entry_type"=>FinalizeType::Amendment,
                              "cancel_flag"=>0,
                              "created_by"=>$this->user->user_id,
                              "created_date"=>date('Y-m-d H:i:s'));
                $this->db->insert('pmd_finalize',$data);
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
        } else {
            $this->Message->status=400;
            $this->Message->text="Invalid Date!";
        }
        return $this->Message;
    }
    public function RevertFinalizeAmendments() {

        if($this->input->post('amend_date')) {
            $this->db->trans_begin();
            $date = date('Y-m-d',strtotime($this->input->post('amend_date')));
            $data = array("cancel_flag"=>1,
                          "modified_by"=>$this->user->user_id,
                          "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('entry_type', FinalizeType::Amendment);
            $this->db->where('unit_code', $this->user->user_unit_code);
            $this->db->where('product_code', $this->user->user_product_code);
            $this->db->where('entry_date', $date);           
            $this->db->update('pmd_finalize',$data);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success');
            }  else {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text="Invalid Date!";
        }      
        return $this->Message;
    }

    //WeekdayAmendments
    public function WeekdayAmendmentsLists() {

        $start_date     = date('Y-m-d',strtotime($this->input->post('start_date',true)));
        $end_date       = date('Y-m-d',strtotime($this->input->post('end_date',true)));

        $copy_type_rec  = json_decode(rawurldecode($this->input->post('copy_group_rec_sel',true)),true);
        $wa_copy_type   = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $wa_copy_group  = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $wa_copy_code   = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;

        $subscriber_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $wa_sub_code    = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
        $wa_agent_code  = isset($subscriber_rec['AgentCode']) ? $subscriber_rec['AgentCode'] : null;
        $wa_agent_slno  = isset($subscriber_rec['AgentSlNo']) ? $subscriber_rec['AgentSlNo'] : null;

        $where = "";

        if($wa_copy_type) {
            $where .= " AND W.wa_copy_type = '".$wa_copy_type."' ";
        }

        if($wa_copy_group) {
            $where .= " AND W.wa_copy_group = '".$wa_copy_group."' ";
        }

        if($wa_copy_code) {
            $where .= " AND W.wa_copy_code = '".$wa_copy_code."' ";
        }

        if($wa_sub_code) {
            $where .= " AND W.wa_sub_code = '".$wa_sub_code."' ";
        }

        if($wa_agent_code) {
            $where .= " AND W.wa_agent_code = '".$wa_agent_code."' ";
        }

        if($wa_agent_slno) {
            $where .= " AND W.wa_agent_slno = '".$wa_agent_slno."' ";
        }

        if($start_date) {
            $where .= " AND DATE(W.created_date) >= '".$start_date."' ";
        }

        if($end_date) {
            $where .= " AND DATE(W.created_date) <= '".$end_date."' ";
        }

        $qry = "SELECT
                    W.wa_code,
                    W.wa_agent_code,
                    W.wa_copies,
                    W.wa_start_date,
                    W.wa_end_flag,
                    W.wa_end_date,
                    W.wa_remarks,
                    W.created_date,
                    CG.group_name,
                    S.sub_name,
                    S.sub_address,
                    S.sub_phone,
                    A.agent_name,
                    A.agent_location,
                    A.agent_phone,
                    U.user_emp_name
                FROM
                    pmd_weekdayamend W
                JOIN
                    pmd_copygroup CG ON (CG.group_code = W.wa_copy_group AND CG.group_copy_code = W.wa_copy_code)
                JOIN
                    pmd_subscriber S ON (S.sub_unit_code = '".$this->user->user_unit_code."' AND S.sub_code = W.wa_sub_code)
                JOIN
                    pmd_agent A ON (A.agent_unit = '".$this->user->user_unit_code."' AND A.agent_slno = W.wa_agent_slno AND A.agent_code = W.wa_agent_code)
                JOIN
                    pmd_userdetails U ON U.user_id = W.created_by
                WHERE
                    W.unit_code = '".$this->user->user_unit_code."' AND
                    W.wa_pdt_code = '".$this->user->user_product_code."' AND
                    W.cancel_flag = 0 ".$where;
        return $this->db->query($qry)->result();
    }
    public function WeekdayAmendmentsDetails($wa_code) {

        $qry = "SELECT
                    W.wa_reg_no,
                    W.wa_code,
                    W.wa_sub_code,
                    W.wa_agent_code,
                    W.wa_agent_slno,
                    W.wa_copy_type,
                    W.wa_copy_group,
                    W.wa_copy_code,
                    W.wa_copies,
                    W.wa_start_date,
                    W.wa_end_flag,
                    W.wa_end_date,
                    W.wa_remarks,
                    W.wa_sun,
                    W.wa_mon,
                    W.wa_tue,
                    W.wa_wed,
                    W.wa_thu,
                    W.wa_fri,
                    W.wa_sat,
                    W.wa_status,
                    CG.group_name,
                    S.sub_name,
                    A.agent_name,
                    A.agent_location
                FROM
                    pmd_weekdayamend W
                JOIN
                    pmd_copygroup CG ON (CG.group_code = W.wa_copy_group AND CG.group_copy_code = W.wa_copy_code)
                JOIN
                    pmd_subscriber S ON (S.sub_unit_code = '".$this->user->user_unit_code."' AND S.sub_code = W.wa_sub_code)
                JOIN
                    pmd_agent A ON (A.agent_unit = '".$this->user->user_unit_code."' AND A.agent_slno = W.wa_agent_slno AND A.agent_code = W.wa_agent_code)
                WHERE
                    W.wa_code = '".$wa_code."' AND
                    W.unit_code = '".$this->user->user_unit_code."' AND
                    W.wa_pdt_code = '".$this->user->user_product_code."' AND
                    W.cancel_flag = 0
                LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function UpsertWeekdayAmendments()
    {
        $is_update      = (int)$this->input->post('is_update',true);
        $wa_reg_no      = $this->input->post('wa_reg_no',true);

        $copy_type_rec  = json_decode(rawurldecode($this->input->post('copy_group_rec_sel',true)),true);
        $wa_copy_type   = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $wa_copy_group  = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $wa_copy_code   = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;

        $subscriber_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $wa_sub_code    = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
        $wa_agent_code  = isset($subscriber_rec['AgentCode']) ? $subscriber_rec['AgentCode'] : null;
        $wa_agent_slno  = isset($subscriber_rec['AgentSlNo']) ? $subscriber_rec['AgentSlNo'] : null;

        $wa_start_date  = date('Y-m-d',strtotime($this->input->post('wa_start_date',true)));
        $wa_end_flag    = (int)$this->input->post('wa_end_flag',true);
        $wa_end_date    = $wa_end_flag == 0 ? null : date('Y-m-d',strtotime($this->input->post('wa_end_date',true)));
        $wa_copies      = $this->input->post('wa_copies',true);
        $wa_sun         = (int)$this->input->post('wa_sun',true);
        $wa_mon         = (int)$this->input->post('wa_mon',true);
        $wa_tue         = (int)$this->input->post('wa_tue',true);
        $wa_wed         = (int)$this->input->post('wa_wed',true);
        $wa_thu         = (int)$this->input->post('wa_thu',true);
        $wa_fri         = (int)$this->input->post('wa_fri',true);
        $wa_sat         = (int)$this->input->post('wa_sat',true);
        $wa_remarks     = $this->input->post('wa_remarks',true);

        if($wa_reg_no && $wa_copy_type && $wa_copy_group && $wa_copy_code && $wa_sub_code && $wa_agent_code && $wa_agent_slno && $wa_start_date && $wa_copies) {

            $this->db->trans_begin();
            $data = $data_upd = array();
            $no_id = "";
            if($is_update === 0) {
                $no_id = 'WDA_'.$this->user->user_unit_code.'_CODE';
                $wa_code = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "wa_code"=>$wa_code,
                                    "wa_pdt_code"=>$this->user->user_product_code,
                                    "wa_sub_code"=>$wa_sub_code,
                                    "wa_agent_code"=>$wa_agent_code,
                                    "wa_agent_slno"=>$wa_agent_slno,
                                    "wa_copy_type"=>$wa_copy_type,
                                    "wa_copy_group"=>$wa_copy_group,
                                    "wa_copy_code"=>$wa_copy_code,
                                    "wa_start_date"=>$wa_start_date,
                                    "wa_end_flag"=>$wa_end_flag,
                                    "wa_end_date"=>$wa_end_date,
                                    "wa_copies"=>$wa_copies,
                                    "wa_sun"=>$wa_sun,
                                    "wa_mon"=>$wa_mon,
                                    "wa_tue"=>$wa_tue,
                                    "wa_wed"=>$wa_wed,
                                    "wa_thu"=>$wa_thu,
                                    "wa_fri"=>$wa_fri,
                                    "wa_sat"=>$wa_sat,
                                    "wa_status"=>CopyStatus::Started,
                                    "wa_status_by"=>$this->user->user_id,
                                    "wa_status_date"=>date('Y-m-d H:i:s'),                                                                                                      
                                    "cancel_flag"=>0);
            }
            else {
                $wa_code = $this->input->post('wa_code',true);
            }

            $data = array("wa_reg_no"=>strtoupper($wa_reg_no),
                          "wa_remarks"=>$wa_remarks,
                          $is_update === 0 ? "created_by": "modified_by"=>$this->user->user_id,
                          $is_update === 0 ? "created_date": "modified_date"=>date('Y-m-d H:i:s'));

            if($is_update === 0) {
                $data_amend   = array("amendment_agent_code"=>$wa_agent_code,
                                      "amendment_agent_slno"=>$wa_agent_slno,
                                      "amendment_sub_code"=>$wa_sub_code,
                                      "amendment_copy_code"=>$wa_copy_code,
                                      "amendment_copy_group"=>$wa_copy_group,
                                      "amendment_copy_type"=>$wa_copy_type,
                                      "amendment_scheme_code"=>$wa_code,
                                      "amendment_sun"=>$wa_sun,
                                      "amendment_mon"=>$wa_mon,
                                      "amendment_tue"=>$wa_tue,
                                      "amendment_wed"=>$wa_wed,
                                      "amendment_thu"=>$wa_thu,
                                      "amendment_fri"=>$wa_fri,
                                      "amendment_sat"=>$wa_sat);
                $rate_per_copy = 0;
                $amend_status = $this->CreateAmendment($data_amend, $wa_start_date, $wa_end_date, $wa_copies, $rate_per_copy);
                $data = array_merge($data,$data_upd);
                $this->db->insert('pmd_weekdayamend',$data);
            }
            else {
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('wa_pdt_code',$this->user->user_product_code);
                $this->db->where('wa_code',$wa_code);
                $this->db->update('pmd_weekdayamend',$data);

                $amend_status = new stdClass();
                $amend_status->status = 200;
            }

            if($is_update === 0) {
                $this->UpdatePrimaryId($wa_code, $no_id);
            }

            if($this->db->trans_status() === TRUE && $amend_status->status === 200)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text= $amend_status->status == 400 ? $amend_status->text : $this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }
    public function ManageWeekdayAmendmentsStatus() {

        $this->db->trans_begin();
        $scheme_code = $this->input->post('wa_code',true);
        $wa_status   = (int)$this->input->post('wa_status',true);
        if($wa_status >= 0) {
            $condition=" unit_code = '".$this->user->user_unit_code."' AND
                         wa_pdt_code = '".$this->user->user_product_code."' AND
                         wa_code = '".$scheme_code."' AND
                         wa_status = ".$wa_status." ";
            if($this->IsDuplicate('pmd_weekdayamend',$condition)) {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text="Amendment already in this status!";
            }
            else {
                $subscriber_code = null;
                $amend_status = new stdClass();
                $amend_status->status = 400;
                $amend_status->text = "Initializing Error!";
                if(CopyStatus::Started) {
                    $sts = $this->StartAmendment($scheme_code,$subscriber_code);
                    $amend_status->status = $sts->status;
                    $amend_status->text = $sts->text;
                }
                else if(CopyStatus::Stopped === $wa_status || CopyStatus::Paused === $wa_status) {
                    $sts = $this->StopAmendment($scheme_code,$subscriber_code);
                    $amend_status->status = $sts->status;
                    $amend_status->text = $sts->text;
                }

                //update weekdayamend table
                $data = array("wa_status"=> 1,
                              "wa_status_by"=> $this->user->user_id,
                              "wa_status_date"=> date('Y-m-d H:i:s'));
                $this->db->where('unit_code', $this->user->user_unit_code);
                $this->db->where('wa_pdt_code', $this->user->user_product_code);
                $this->db->where('wa_code', $scheme_code);
                $this->db->update('pmd_weekdayamend',$data);

                if($this->db->trans_status() === TRUE && $amend_status->status === 200)
                {
                    $this->db->trans_commit();
                    $this->Message->status=200;
                    $this->Message->text=$this->lang->line('updated_success');
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->Message->status=400;
                    $this->Message->text=$amend_status->status == 400 ? $amend_status->text : $this->lang->line('error_processing');
                }
            }      
        }
        else {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text="Invalid Status Selected!";
        }
        return $this->Message;
    }

    //Other Receipt PDC
    public function UpsertOtherReceiptsPDC()
    {
        $is_valid = true;
        $sch_rcpt_no      = $this->input->post("sch_rcpt_no", TRUE);
        if($sch_rcpt_no){
            $sch_rcpt_no = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_no, $this->encryption_key);
        }
        $receipt_type       = null;
        $is_update          = $sch_rcpt_no ? true : false;
        $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
        $copy_type_code     = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $copy_group_code    = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $copy_code          = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;
        $copy_name          = isset($copy_type_rec['Copy']) ? $copy_type_rec['Copy'] : null;
        $copy_group_name    = isset($copy_type_rec['Group']) ? $copy_type_rec['Group'] : null;
        if($copy_name=='SCHEME'){
            $receipt_type = OtherReceipts::Scheme;
        }else if($copy_name=='SPONSOR'){
            if($copy_group_name=='ENTE KAUMUDI'){
                $receipt_type = OtherReceipts::EK;
            } else {
                $receipt_type = OtherReceipts::Sponsor;
            }
        }
        $subscriber_rec     = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $sch_sub_code       = isset($subscriber_rec['Subscriber Code']) ? $subscriber_rec['Subscriber Code'] : null;
        $sch_sub_name       = isset($subscriber_rec['Name']) ? $subscriber_rec['Name'] : null;
        $sch_agent_code     = isset($subscriber_rec['Agent Code']) ? $subscriber_rec['Agent Code'] : null;
        $sch_agent_slno     = isset($subscriber_rec['Agent Slno']) ? $subscriber_rec['Agent Slno'] : null;
        $scheme_no          = isset($subscriber_rec['Serial No']) ? $subscriber_rec['Serial No'] : null;
        $sch_against_bounce = $this->input->post('against_chqbounce',true);
        $receipt_rec        = json_decode(rawurldecode($this->input->post('receipt_no_rec_sel',true)),true);
        $receipt_no         = isset($receipt_rec['Code']) ? $receipt_rec['Code'] : null;
        $receipt_amount     = (int)$this->input->post('sch_amt',true);
        $bank_rec           = json_decode(rawurldecode($this->input->post('bank_rec_sel',true)),true);
        $cheque_date        = $this->input->post('sch_chq_dte',true);
        $sch_chq_no         = $this->input->post('sch_chq_no',true);
        $sch_chq_dte        = $cheque_date?date("Y-m-d",strtotime($cheque_date)):null;
        $bank_code          = isset($bank_rec['Code']) ? $bank_rec['Code'] : null;
        if(!$sch_chq_no || !$cheque_date || !$bank_code) $is_valid = false;
        $sch_pay_mode       = $this->input->post('payment_mode',true);
        $promoter_rec       = json_decode(rawurldecode($this->input->post('promoter_rec_sel',true)),true);
        $promoter_code      = isset($promoter_rec['Code']) ? $promoter_rec['Code'] : null;
        $tmprcpt_rec        = json_decode(rawurldecode($this->input->post('tmp_rcpt_rec_sel',true)),true);
        $sch_tmp_rcpt       = isset($tmprcpt_rec['Receipt No']) ? $tmprcpt_rec['Receipt No'] : null;
        $remarks            = $this->input->post('remarks',true);
        $finalize_date      = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);

        if(!$finalize_date){
            $this->Message->status=400;
            $this->Message->text="Please finalize the date first.";
            return $this->Message;
        }
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        if($copy_type_code && $receipt_type && $sch_sub_code && $scheme_no && $receipt_amount>0 && $is_valid) {

            $now = date('Y-m-d H:i:s');
            $data = $data_upd = array();
            $no_id = "";
            $this->db->trans_begin();
            if($is_update===FALSE) {
                $no_id = 'SPDC_'.$this->user->user_unit_code.'_CODE';
                $sch_rcpt_no = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "pdc_no"=>$sch_rcpt_no,
                                    "pdc_date"=>date("Y-m-d", strtotime($finalize_date." +1 day")),
                                    "pdt_code"=>$this->user->user_product_code,
                                    "pdc_amount"=> $receipt_amount);
            }
            $data = array(
                           "pdc_type_code"=>$receipt_type,
                           "pdc_copy_code"=>$copy_code,
                           "pdc_copy_group"=>$copy_group_code,
                           "pdc_copy_type"=>$copy_type_code,
                           "pdc_sub_code"=> $sch_sub_code,
                           "pdc_agent_code"=> $sch_agent_code,
                           "pdc_agent_slno"=> $sch_agent_slno,
                           "pdc_scheme_code"=> $scheme_no,
                           "pdc_sub_name"=> $sch_sub_name,
                           "pdc_against_dis"=> $sch_against_bounce,
                           "pdc_against_dis_code"=> $receipt_no,
                           "pdc_chq_no"=> $sch_chq_no,
                           "pdc_chq_date"=> $sch_chq_dte,
                           "pdc_bank_code"=> $bank_code,
                           "pdc_paid_by"=> $sch_pay_mode,
                           "pdc_promoter_code"=> $promoter_code,
                           "pdc_temp_rec"=> $sch_tmp_rcpt,
                           "pdc_remarks"=>$remarks,
                           "cancel_flag"=> 0,
                           $is_update ? "modified_by": "created_by"=> $this->user->user_id,
                           $is_update ? "modified_date": "created_date"=>$now
                 );
            if($is_update === FALSE) {
                $data = array_merge($data,$data_upd);
                $this->db->insert('pmd_other_pdc',$data);
                $this->UpdatePrimaryId($sch_rcpt_no, $no_id);
                if($receipt_type == OtherReceipts::Scheme){
                    $query = "UPDATE pmd_scheme SET sch_balance=sch_balance-".$receipt_amount.", sch_paid_amount=sch_paid_amount+".$receipt_amount." WHERE sch_slno='".$scheme_no."'";
                }else if($receipt_type == OtherReceipts::EK){
                    $query = "UPDATE pmd_ek SET ek_balance=ek_balance-".$receipt_amount.", ek_paid_amt=ek_paid_amt+".$receipt_amount." WHERE ek_slno='".$scheme_no."'";
                }else {
                    $query = "UPDATE pmd_sponsor SET spons_balance=spons_balance-".$receipt_amount.", spons_paid_amt=spons_paid_amt+".$receipt_amount." WHERE spons_code='".$scheme_no."'";
                }
                $this->db->query($query);
            }
            else {//update
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('pdc_no',$sch_rcpt_no);
                $this->db->update('pmd_other_pdc',$data);
            }
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text= $is_update === TRUE ?  $this->lang->line('updated_success') : $this->lang->line('added_success') ;
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
    public function GetOtherReceiptsPDC($date=null) {
        $where='';
        if(!isset($_POST['search'])){
            if($date){
                $where .= " AND DATE(SR.created_date)>='".$date."'";
            }else{
                $where .= " AND DATE(SR.created_date)>='".date("Y-m-d")."'";
            }
        }else{

            $copy_type_rec      = json_decode(rawurldecode($this->input->post('copy_type_rec_sel',true)),true);
            //$copy_type          = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
            $from_dte           = $this->input->post('from_dte',true);
            $to_dte             = $this->input->post('to_dte',true);
            $str_from_dte       = strtotime($from_dte);
            $str_to_dte         = strtotime($to_dte);
            //if($copy_type){
            //    $where .= " AND SR.srec_ac_code='".$copy_type."'";
            //}
            if($from_dte && $to_dte && $str_from_dte>=$str_to_dte){
                $where .= " AND SR.pdc_date >='".date("Y-m-d H:i:s", $str_from_dte)."' AND SR.pdc_date<='".date("Y-m-d H:i:s",$str_to_dte)."'";
            }
        }
        $qry = "SELECT
                    pdc_no,
                    pdc_date,
                    CT.copytype_code,
                    CT.copytype_name,
                    IF(SR.pdc_type_code='".OtherReceipts::Scheme."',(SELECT CONCAT(sub_code,'#&',sub_name,'#&',sub_address,'#&',sub_phone) FROM pmd_scheme SCH INNER JOIN pmd_subscriber SB ON SB.sub_unit_code='".$this->user->user_unit_code."' AND SCH.sch_sub_code=SB.sub_code WHERE SCH.unit_code='".$this->user->user_unit_code."' AND SCH.sch_slno=SR.pdc_scheme_code),
                    IF(SR.pdc_type_code='".OtherReceipts::EK."',(SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_ek EK INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND EK.ek_client_code=SPC.client_code WHERE EK.unit_code='".$this->user->user_unit_code."' AND EK.ek_slno=SR.pdc_scheme_code),
                                                                 (SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_sponsor SP INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND SP.spons_client_code=SPC.client_code WHERE SP.unit_code='".$this->user->user_unit_code."' AND SP.spons_code=SR.pdc_scheme_code))) AS subscriber,
                    SR.pdc_scheme_code,
                    SR.pdc_amount,
                    SR.pdc_chq_no,
                    SR.pdc_chq_date,
                    SR.pdc_paid_by,
                    PR.promoter_code,
                    PR.promoter_name,
                    PR.promoter_area,
                    SR.pdc_temp_rec,
                    SR.pdc_remarks,
                    US.user_emp_name created_name,
                    SR.created_date
                FROM
                    pmd_other_pdc SR
                JOIN
                    pmd_copytype CT ON CT.copytype_code = SR.pdc_copy_type
                JOIN
                    pmd_userdetails US ON SR.created_by=US.user_id
                LEFT JOIN
                    pmd_promoter PR ON PR.promoter_code=SR.pdc_promoter_code
                WHERE
                   SR.unit_code='".$this->user->user_unit_code."' AND SR.pdt_code='".$this->user->user_product_code."' ".$where." AND SR.cancel_flag=0";
        return $this->db->query($qry)->result();
    }
    public function GetOtherReceiptPDCDetails($sch_rcpt_code){
        $qry = "SELECT
                    pdc_no,
                    pdc_date,
                    CT.copytype_code,
                    CT.copytype_name,
                    BM.bank_code,
                    BM.bank_name,
                    IF(SR.pdc_type_code='".OtherReceipts::Scheme."',(SELECT CONCAT(sub_code,'#&',sub_name,'#&',sub_address,'#&',sub_phone) FROM pmd_scheme SCH INNER JOIN pmd_subscriber SB ON SB.sub_unit_code='".$this->user->user_unit_code."' AND SCH.sch_sub_code=SB.sub_code WHERE SCH.unit_code='".$this->user->user_unit_code."' AND SCH.sch_slno=SR.pdc_scheme_code),
                    IF(SR.pdc_type_code='".OtherReceipts::EK."',(SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_ek EK INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND EK.ek_client_code=SPC.client_code WHERE EK.unit_code='".$this->user->user_unit_code."' AND EK.ek_slno=SR.pdc_scheme_code),
                                                                 (SELECT CONCAT(client_code,'#&',client_name,'#&',client_address,'#&',client_phone) FROM pmd_sponsor SP INNER JOIN pmd_spons_client SPC ON SPC.unit_code='".$this->user->user_unit_code."' AND SP.spons_client_code=SPC.client_code WHERE SP.unit_code='".$this->user->user_unit_code."' AND SP.spons_code=SR.pdc_scheme_code))) AS subscriber,
                    SR.pdc_scheme_code,
                    SR.pdc_against_dis,
                    SR.pdc_against_dis_code,
                    SR.pdc_amount,
                    SR.pdc_chq_no,
                    SR.pdc_chq_date,
                    SR.pdc_dis_flag,
                    SR.pdc_type_code,
                    SR.pdc_dis_no,
                    SR.pdc_paid_by,
                    PR.promoter_code,
                    PR.promoter_name,
                    PR.promoter_area,
                    SR.pdc_temp_rec,
                    SR.pdc_remarks,
                    CG.group_name,
                    CM.copy_name
                FROM
                    pmd_other_pdc SR
                JOIN
                    pmd_copytype CT ON CT.copytype_code = SR.pdc_copy_type
                JOIN
                    pmd_copygroup CG ON CG.group_code = CT.group_code
                JOIN
                    pmd_copymaster CM ON CM.copy_code = CT.copy_code
                LEFT JOIN
                    pmd_promoter PR ON PR.promoter_code=SR.pdc_promoter_code
                LEFT JOIN
                    pmd_bankmaster BM ON BM.bank_code=SR.pdc_bank_code
                WHERE
                   SR.unit_code='".$this->user->user_unit_code."' AND SR.pdt_code='".$this->user->user_product_code."' AND SR.pdc_no='".$sch_rcpt_code."' AND SR.cancel_flag=0";
        return $this->db->query($qry)->row();
    }
    public function DeleteOtherReceiptsPDC($data)
    {
        $scheme_rcpt_det = $this->GetOtherReceiptPDCDetails($data['pdc_no']);
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        if(strtotime($scheme_rcpt_det->pdc_date)<=strtotime($finalize_date)&& $this->user->user_id!='1'){
            $this->Message->status=400;
            $this->Message->text="Dates are already finalized.";
            return json_encode($this->Message);
        }
        $this->db->trans_begin();
        if($scheme_rcpt_det->pdc_type_code == OtherReceipts::Scheme){
            $query = "UPDATE pmd_scheme SET sch_balance=sch_balance+".$scheme_rcpt_det->pdc_amount.", sch_paid_amount=sch_paid_amount-".$scheme_rcpt_det->pdc_amount." WHERE sch_slno='".$scheme_rcpt_det->pdc_scheme_code."'";
        }else if($scheme_rcpt_det->pdc_type_code == OtherReceipts::EK){
            $query = "UPDATE pmd_ek SET ek_balance=ek_balance+".$scheme_rcpt_det->pdc_amount.", ek_paid_amt=ek_paid_amt-".$scheme_rcpt_det->pdc_amount." WHERE ek_slno='".$scheme_rcpt_det->pdc_scheme_code."'";
        }else {
            $query = "UPDATE pmd_sponsor SET spons_balance=spons_balance+".$scheme_rcpt_det->pdc_amount.", spons_paid_amt=spons_paid_amt-".$scheme_rcpt_det->pdc_amount." WHERE spons_code='".$scheme_rcpt_det->pdc_scheme_code."'";
        }
        $this->db->query($query);
        $this->db->where('pdc_no', $data['pdc_no']);
        $this->db->update('pmd_other_pdc', $data);
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('deleted_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
		return json_encode($this->Message);
    }

    //Receipts
    public function ReceiptsLists() {

        $start_date     = date('Y-m-d',strtotime($this->input->post('start_date',true)));
        $end_date       = date('Y-m-d',strtotime($this->input->post('end_date',true)));

        $copy_type_rec  = json_decode(rawurldecode($this->input->post('copy_group_rec_sel',true)),true);
        $wa_copy_type   = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $wa_copy_group  = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $wa_copy_code   = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;

        $subscriber_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $wa_sub_code    = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
        $wa_agent_code  = isset($subscriber_rec['AgentCode']) ? $subscriber_rec['AgentCode'] : null;
        $wa_agent_slno  = isset($subscriber_rec['AgentSlNo']) ? $subscriber_rec['AgentSlNo'] : null;

        $where = "";

        if($wa_copy_type) {
            $where .= " AND W.wa_copy_type = '".$wa_copy_type."' ";
        }

        if($wa_copy_group) {
            $where .= " AND W.wa_copy_group = '".$wa_copy_group."' ";
        }

        if($wa_copy_code) {
            $where .= " AND W.wa_copy_code = '".$wa_copy_code."' ";
        }

        if($wa_sub_code) {
            $where .= " AND W.wa_sub_code = '".$wa_sub_code."' ";
        }

        if($wa_agent_code) {
            $where .= " AND W.wa_agent_code = '".$wa_agent_code."' ";
        }

        if($wa_agent_slno) {
            $where .= " AND W.wa_agent_slno = '".$wa_agent_slno."' ";
        }

        if($start_date) {
            $where .= " AND DATE(W.created_date) >= '".$start_date."' ";
        }

        if($end_date) {
            $where .= " AND DATE(W.created_date) <= '".$end_date."' ";
        }

        $qry = "SELECT
                    W.wa_code,
                    W.wa_agent_code,
                    W.wa_copies,
                    W.wa_start_date,
                    W.wa_end_flag,
                    W.wa_end_date,
                    W.wa_remarks,
                    W.created_date,
                    CG.group_name,
                    S.sub_name,
                    S.sub_address,
                    S.sub_phone,
                    A.agent_name,
                    A.agent_location,
                    A.agent_phone,
                    U.user_emp_name
                FROM
                    pmd_weekdayamend W
                JOIN
                    pmd_copygroup CG ON (CG.group_code = W.wa_copy_group AND CG.group_copy_code = W.wa_copy_code)
                JOIN
                    pmd_subscriber S ON (S.sub_unit_code = '".$this->user->user_unit_code."' AND S.sub_code = W.wa_sub_code)
                JOIN
                    pmd_agent A ON (A.agent_unit = '".$this->user->user_unit_code."' AND A.agent_slno = W.wa_agent_slno AND A.agent_code = W.wa_agent_code)
                JOIN
                    pmd_userdetails U ON U.user_id = W.created_by
                WHERE
                    W.unit_code = '".$this->user->user_unit_code."' AND
                    W.wa_pdt_code = '".$this->user->user_product_code."' AND
                    W.cancel_flag = 0 ".$where;
        return $this->db->query($qry)->result();
    }
    public function ReceiptsDetails($wa_code) {

        $qry = "SELECT
                    W.wa_reg_no,
                    W.wa_code,
                    W.wa_sub_code,
                    W.wa_agent_code,
                    W.wa_agent_slno,
                    W.wa_copy_type,
                    W.wa_copy_group,
                    W.wa_copy_code,
                    W.wa_copies,
                    W.wa_start_date,
                    W.wa_end_flag,
                    W.wa_end_date,
                    W.wa_remarks,
                    W.wa_sun,
                    W.wa_mon,
                    W.wa_tue,
                    W.wa_wed,
                    W.wa_thu,
                    W.wa_fri,
                    W.wa_sat,
                    W.wa_status,
                    CG.group_name,
                    S.sub_name,
                    A.agent_name,
                    A.agent_location
                FROM
                    pmd_weekdayamend W
                JOIN
                    pmd_copygroup CG ON (CG.group_code = W.wa_copy_group AND CG.group_copy_code = W.wa_copy_code)
                JOIN
                    pmd_subscriber S ON (S.sub_unit_code = '".$this->user->user_unit_code."' AND S.sub_code = W.wa_sub_code)
                JOIN
                    pmd_agent A ON (A.agent_unit = '".$this->user->user_unit_code."' AND A.agent_slno = W.wa_agent_slno AND A.agent_code = W.wa_agent_code)
                WHERE
                    W.wa_code = '".$wa_code."' AND
                    W.unit_code = '".$this->user->user_unit_code."' AND
                    W.wa_pdt_code = '".$this->user->user_product_code."' AND
                    W.cancel_flag = 0
                LIMIT 1";
        return $this->db->query($qry)->row();
    }
    public function UpsertReceipts()
    {
        $is_update      = (int)$this->input->post('is_update',true);
        $wa_reg_no      = $this->input->post('wa_reg_no',true);

        $copy_type_rec  = json_decode(rawurldecode($this->input->post('copy_group_rec_sel',true)),true);
        $wa_copy_type   = isset($copy_type_rec['Code']) ? $copy_type_rec['Code'] : null;
        $wa_copy_group  = isset($copy_type_rec['Copy Group']) ? $copy_type_rec['Copy Group'] : null;
        $wa_copy_code   = isset($copy_type_rec['Copy Code']) ? $copy_type_rec['Copy Code'] : null;

        $subscriber_rec = json_decode(rawurldecode($this->input->post('subscriber_rec_sel',true)),true);
        $wa_sub_code    = isset($subscriber_rec['Code']) ? $subscriber_rec['Code'] : null;
        $wa_agent_code  = isset($subscriber_rec['AgentCode']) ? $subscriber_rec['AgentCode'] : null;
        $wa_agent_slno  = isset($subscriber_rec['AgentSlNo']) ? $subscriber_rec['AgentSlNo'] : null;

        $wa_start_date  = date('Y-m-d',strtotime($this->input->post('wa_start_date',true)));
        $wa_end_flag    = (int)$this->input->post('wa_end_flag',true);
        $wa_end_date    = $wa_end_flag == 0 ? null : date('Y-m-d',strtotime($this->input->post('wa_end_date',true)));
        $wa_copies      = $this->input->post('wa_copies',true);
        $wa_sun         = (int)$this->input->post('wa_sun',true);
        $wa_mon         = (int)$this->input->post('wa_mon',true);
        $wa_tue         = (int)$this->input->post('wa_tue',true);
        $wa_wed         = (int)$this->input->post('wa_wed',true);
        $wa_thu         = (int)$this->input->post('wa_thu',true);
        $wa_fri         = (int)$this->input->post('wa_fri',true);
        $wa_sat         = (int)$this->input->post('wa_sat',true);
        $wa_remarks     = $this->input->post('wa_remarks',true);

        if($wa_reg_no && $wa_copy_type && $wa_copy_group && $wa_copy_code && $wa_sub_code && $wa_agent_code && $wa_agent_slno && $wa_start_date && $wa_copies) {

            $this->db->trans_begin();
            $data = $data_upd = array();
            $no_id = "";
            if($is_update === 0) {
                $no_id = 'WDA_'.$this->user->user_unit_code.'_CODE';
                $wa_code = $this->GetPrimaryId($no_id);
                $data_upd   = array("unit_code"=>$this->user->user_unit_code,
                                    "wa_code"=>$wa_code,
                                    "wa_pdt_code"=>$this->user->user_product_code,
                                    "wa_sub_code"=>$wa_sub_code,
                                    "wa_agent_code"=>$wa_agent_code,
                                    "wa_agent_slno"=>$wa_agent_slno,
                                    "wa_copy_type"=>$wa_copy_type,
                                    "wa_copy_group"=>$wa_copy_group,
                                    "wa_copy_code"=>$wa_copy_code,
                                    "wa_start_date"=>$wa_start_date,
                                    "wa_end_flag"=>$wa_end_flag,
                                    "wa_end_date"=>$wa_end_date,
                                    "wa_copies"=>$wa_copies,
                                    "wa_sun"=>$wa_sun,
                                    "wa_mon"=>$wa_mon,
                                    "wa_tue"=>$wa_tue,
                                    "wa_wed"=>$wa_wed,
                                    "wa_thu"=>$wa_thu,
                                    "wa_fri"=>$wa_fri,
                                    "wa_sat"=>$wa_sat,
                                    "wa_status"=>CopyStatus::Started,
                                    "wa_status_by"=>$this->user->user_id,
                                    "wa_status_date"=>date('Y-m-d H:i:s'),
                                    "cancel_flag"=>0);
            }
            else {
                $wa_code = $this->input->post('wa_code',true);
            }

            $data = array("wa_reg_no"=>strtoupper($wa_reg_no),
                          "wa_remarks"=>$wa_remarks,
                          $is_update === 0 ? "created_by": "modified_by"=>$this->user->user_id,
                          $is_update === 0 ? "created_date": "modified_date"=>date('Y-m-d H:i:s'));

            if($is_update === 0) {
                $data_amend   = array("amendment_agent_code"=>$wa_agent_code,
                                      "amendment_agent_slno"=>$wa_agent_slno,
                                      "amendment_sub_code"=>$wa_sub_code,
                                      "amendment_copy_code"=>$wa_copy_code,
                                      "amendment_copy_group"=>$wa_copy_group,
                                      "amendment_copy_type"=>$wa_copy_type,
                                      "amendment_scheme_code"=>$wa_code,
                                      "amendment_sun"=>$wa_sun,
                                      "amendment_mon"=>$wa_mon,
                                      "amendment_tue"=>$wa_tue,
                                      "amendment_wed"=>$wa_wed,
                                      "amendment_thu"=>$wa_thu,
                                      "amendment_fri"=>$wa_fri,
                                      "amendment_sat"=>$wa_sat);
                $rate_per_copy = 0;
                $amend_status = $this->CreateAmendment($data_amend, $wa_start_date, $wa_end_date, $wa_copies, $rate_per_copy);
                $data = array_merge($data,$data_upd);
                $this->db->insert('pmd_weekdayamend',$data);
            }
            else {
                $this->db->where('unit_code',$this->user->user_unit_code);
                $this->db->where('wa_pdt_code',$this->user->user_product_code);
                $this->db->where('wa_code',$wa_code);
                $this->db->update('pmd_weekdayamend',$data);

                $amend_status = new stdClass();
                $amend_status->status = 200;
            }

            if($is_update === 0) {
                $this->UpdatePrimaryId($wa_code, $no_id);
            }

            if($this->db->trans_status() === TRUE && $amend_status->status === 200)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text=$is_update === 0 ? $this->lang->line('added_success') : $this->lang->line('updated_success');
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text= $amend_status->status == 400 ? $amend_status->text : $this->lang->line('error_processing');
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('params_missing');
        }
        return $this->Message;
    }


    /**
     * Summary of GetLastFinalizeDate
     * @param mixed $unit_code 
     * @param mixed $pdt_code 
     * @param mixed $type 
     * @return mixed
     */
    public function GetLastFinalizeDate($unit_code,$pdt_code,$type){
        $qry = "SELECT
                    MAX(entry_date) finalize_date
                FROM
                    pmd_finalize
                WHERE
                    unit_code ='".$unit_code."' AND product_code='".$pdt_code."' AND entry_type='".$type."' AND cancel_flag=0";
        return $this->db->query($qry)->row()->finalize_date;
    }
    /**
     * Summary of CreateAmendment
     * @param mixed $data_amend 
     * @param mixed $start_date 
     * @param mixed $end_date 
     * @param mixed $copies 
     * @param mixed $rate_per_copy 
     * @return mixed
     */
    public function CreateAmendment($data_amend, $start_date, $end_date = null, $copies=1, $rate_per_copy = 0) {
        //amendment table entry
        //1. get last finalize date
        $finalize_date = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Amendment);
        if($finalize_date) {
            $str_start_date         = strtotime($start_date);
            $str_finalize_date      = strtotime($finalize_date);
            $next_finalize_date     = date('Y-m-d', strtotime($finalize_date . ' +1 day'));
            $str_next_finalize_date = strtotime($next_finalize_date);

            if( $str_start_date <= $str_finalize_date ) {
                //start date < last finalize date
                $this->Message->status=400;
                $this->Message->text="Date Already Finalized!";
            }
            else {
                $amendment_code                     = $this->GetPrimaryId('AMDT_'.$this->user->user_unit_code.'_CODE');
                $data_amend["unit_code"]            = $this->user->user_unit_code;
                $data_amend["amendment_pdt_code"]   = $this->user->user_product_code;
                $data_amend["amendment_start_date"] = $start_date;
                $data_amend["amendment_end_date"]   = $end_date;
                $data_amend["created_by"]           = $this->user->user_id;
                $data_amend["created_date"]         = date('Y-m-d H:i:s');
                $data_amend["amendment_code"]       = $amendment_code;
                $data_amend["amendment_copies"]     = $copies;
                $this->db->insert('pmd_temp_amendment',$data_amend);
                $this->UpdatePrimaryId($amendment_code, 'AMDT_'.$this->user->user_unit_code.'_CODE');
                $this->Message->status=200;
                $this->Message->text=$this->lang->line('updated_success');         
            }
        }
        else {
            $this->Message->status=400;
            $this->Message->text="No Finalized Date Found!";
        }
        return $this->Message;
    }
    public function StopAmendment($scheme_code,$subscriber_code = null) {
        $data = array("amendment_pause_flag"=> 1,
                      "modified_by"=> $this->user->user_id,
                      "modified_date"=> date('Y-m-d H:i:s'));
        $this->db->where('unit_code', $this->user->user_unit_code);
        $this->db->where('amendment_pdt_code', $this->user->user_product_code);       
        $this->db->where('amendment_scheme_code', $scheme_code);
        if($subscriber_code) $this->db->where('amendment_sub_code', $subscriber_code);  
        $this->db->update('pmd_temp_amendment',$data);
        if($this->db->affected_rows()) {
            $this->Message->status=200;
            $this->Message->text="";
        }
        else {
            $this->Message->status=400;
            $this->Message->text="Error Occured in updating amendment";
        }
        return $this->Message;
    }
    public function StartAmendment($scheme_code,$subscriber_code = null) {
        $data = array("amendment_pause_flag"=> 0,
                      "modified_by"=> $this->user->user_id,
                      "modified_date"=> date('Y-m-d H:i:s'));
        $this->db->where('unit_code', $this->user->user_unit_code);
        $this->db->where('amendment_pdt_code', $this->user->user_product_code);
        $this->db->where('amendment_scheme_code', $scheme_code);
        if($subscriber_code) $this->db->where('amendment_sub_code', $subscriber_code);
        $this->db->update('pmd_temp_amendment',$data);
        if($this->db->affected_rows()) {
            $this->Message->status=200;
            $this->Message->text="";
        }
        else {
            $this->Message->status=400;
            $this->Message->text="Error Occured in updating amendment";
        }
        return $this->Message;
    }    
}
