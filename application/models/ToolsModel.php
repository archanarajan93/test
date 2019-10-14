<?php
class ToolsModel extends CI_Model
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
    public function UserProducts($user_id,$label = null) {
        $where = "";
        if($label) $where = " AND P.product_label = '".$label."' ";
        $qry = "SELECT
                    P.product_code,
                    P.product_name,
                    P.product_icon,
                    P.product_color,
                    P.product_label,
                    L.label_name
                FROM
                    pmd_productaccess A
                JOIN
                    pmd_products P ON P.product_code = A.product_code
                JOIN
                    pmd_productslabel L ON L.label_code = P.product_label
                WHERE
                    A.user_id = ".$user_id."
                AND P.cancel_flag = 0 ".$where."
                ORDER BY P.product_priority";
        return $this->db->query($qry)->result();
    }

    public function UserUnits($user_id) {
        $qry = "SELECT
                    U.unit_code,
                    U.unit_name
                FROM
                    pmd_unitaccess A
                JOIN
                    pmd_unit U ON U.unit_code = A.unit_code
                WHERE
                    A.user_id = ".$user_id."
                AND U.cancel_flag = 0
                ORDER BY U.unit_priority";
        return $this->db->query($qry)->result();
    }
    public function SaveBonusDate(){
        $str_bonus_date = strtotime('01-'.$this->input->post('bonus_month', TRUE));
        $bonus_month = date('m',$str_bonus_date);
        $bonus_year = date('Y',$str_bonus_date);
        $bonus_2_date = date('Y-m-d',strtotime($this->input->post('bonus2_date', TRUE)));
        $bonus_1_5_date = date('Y-m-d',strtotime($this->input->post('bonus5_date', TRUE)));
        $bonus_1_date = date('Y-m-d',strtotime($this->input->post('bonus1_date', TRUE)));
        $condition="bonus_month='".$bonus_month."' AND bonus_year='".$bonus_year."'";
        if($this->IsDuplicate('pmd_bonusdate',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Already Exists!";
        }
        else
        {
            $this->db->trans_begin();
            $bonus_code = $this->GetPrimaryId("BNS_CODE");
            $data =   array("bonus_code"=>$bonus_code,
                            "bonus_first_per"=>2,
                            "bonus_first_date"=>$bonus_2_date,
                            "bonus_second_per"=>1.5,
                            "bonus_second_date"=>$bonus_1_5_date,
                            "bonus_third_per"=>1,
                            "bonus_third_date"=>$bonus_1_date,
                            "bonus_month"=>$bonus_month,
                            "bonus_year"=>$bonus_year,
                            "created_by"=>$this->user->user_id,
                            "created_date"=>date('Y-m-d H:i:s'));
            $this->db->insert('pmd_bonusdate',$data);
            $this->UpdatePrimaryId($bonus_code, "BNS_CODE");
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
    public function SaveBonusDateList(){
        $qury="SELECT
                    bonus_code,
                    bonus_first_per,
                    bonus_first_date,
                    bonus_second_per,
                    bonus_second_date,
                    bonus_third_per,
                    bonus_third_date,
                    bonus_month,
                    bonus_year 
                FROM
                     pmd_bonusdate";
        return $this->db->query($qury)->result();
    }
    public function SaveBonusDateEdit(){
        $bonus_date_code = $this->input->post('bonusCode');
        $query = "SELECT
                    bonus_code,
                    bonus_first_per,
                    bonus_first_date,
                    bonus_second_per,
                    bonus_second_date,
                    bonus_third_per,
                    bonus_third_date,
                    bonus_month,
                    bonus_year
                FROM
                     pmd_bonusdate
                WHERE
                    bonus_code='".$bonus_date_code."'";
        return $this->db->query($query)->row();
    }
    public function UpdateSetBonusDate(){
        $set_bonus_code = $this->input->post('bonusCode');
        $set_bonus_first_date = date('Y-m-d',strtotime($this->input->post('bonusDateFrst',true)));
        $set_bonus_sec_date = date('Y-m-d',strtotime($this->input->post('bonusDateSec',true)));
        $set_bonus_third_date = date('Y-m-d',strtotime($this->input->post('bonusDateThrd',true)));
        $set_bonus_date = strtotime('01-'.$this->input->post('bonusMonth',true));
        $set_bonus_year = date('Y',$set_bonus_date);
        $set_bonus_month =date('m',$set_bonus_date);
        $condition="bonus_month='".$set_bonus_month."' AND bonus_year='".$set_bonus_year."' AND bonus_code!='".$set_bonus_code."'";
        if($this->IsDuplicate('pmd_bonusdate',$condition))
        {
            $this->Message->status=400;
            $this->Message->text="Already Exists!";
        }
        else
        {
            $data = array("bonus_code"=>$set_bonus_code,
                            "bonus_first_per"=>2,
                            "bonus_first_date"=>$set_bonus_first_date,
                            "bonus_second_per"=>1.5,
                            "bonus_second_date"=>$set_bonus_sec_date,
                            "bonus_third_per"=>1,
                            "bonus_third_date"=>$set_bonus_third_date,
                            "bonus_month"=>$set_bonus_month,
                            "bonus_year"=>$set_bonus_year,
                            "modified_by"=>$this->user->user_id,
                            "modified_date"=>date('Y-m-d H:i:s'));
            $this->db->where('bonus_code', $set_bonus_code);
            $this->db->update('pmd_bonusdate', $data);
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
    public function GetLastbillDate($unit_code){
        $query = "SELECT
                    entry_date
                FROM
                     pmd_finalize
                WHERE
                    unit_code='".$unit_code."' AND product_code ='DLY' AND entry_type='".FinalizeType::Bill."' ORDER BY entry_date desc limit 1";
        return $this->db->query($query)->row()->entry_date;
    }
    /*Billing*/
    public function GenerateAgentBills(){
        $now = date("Y-m-d H:i:s");
        $dly_bills = $dly_jours = $dly_rcpts = $jour_entry = $agents = $agents_bills = $security_contr = $agent_sec_contr = $agent_opbal_record = 
            $agent_opbal = $agents_details = $agent_rcpts = $prdts_comm = $bonus_rcpts = $finalize_bill = $sec_contributions = array();
        $agents_details = array("bill_amt"=>0,"jour_amt"=>0,"sc_amt"=>0,"rcpt_amt"=>0,"crdt_jour_amt"=>0);
        $prdts = $this->GetProducts();
        foreach($prdts as $prdt){
            $prdts_comm[$prdt->product_code] = $prdt;
        }
        
        $bill_last_finalize = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Bill);
        $bill_start_date = date("Y-m-d", strtotime($bill_last_finalize." +1 day"));
        $bill_end_date = date("Y-m-t", strtotime($bill_start_date));
        $bill_period = strtoupper(date("d-M-Y", strtotime($bill_start_date))." TO ".date("d-M-Y", strtotime($bill_end_date)));
        $bill_dte_pieces = explode("-",$bill_start_date);
        $bill_mnth = (int)$bill_dte_pieces[1];
        $prev_last_date = date("Y-m-t", strtotime("1-".($bill_mnth==1?12:$bill_mnth-1)."-".$bill_dte_pieces[0]));
        $finalize_status = $this->FinalizeAll($prdts, $bill_end_date);
        if($finalize_status->status === 400){
            $this->Message->status=400;
            $this->Message->text="Error occured during finalization.";
            return $this->Message;
        }
        $bill_period = explode(" ",date("j Y",strtotime($bill_start_date)));
        $bonus_details = $this->GetBonusDate($bill_period[0], $bill_period[1]);
        if(!$bonus_details){
            $this->Message->status=400;
            $this->Message->text="Bonus date for the bill period is not finalised.";
            return $this->Message;
        }
        $bill_amends = $this->GetBillAmendments($this->user->user_unit_code,$bill_start_date,$bill_end_date,"CP0001");
        $bill_receipts = $this->GetBillReceipts($this->user->user_unit_code,$bill_start_date,$bill_end_date);
        $bill_journals = $this->GetBillJournals($this->user->user_unit_code,$bill_start_date,$bill_end_date);

        //Get scheme and billable free commision
        $copy_where=" AND amendment_copy_code = 'CP0003' ";
        $scheme_amendments = $this->GetSchemeAmendments($this->user->user_unit_code,$this->user->user_product_code,$bill_end_date,$bill_end_date,$copy_where);
        $copy_where=" AND amendment_copy_code = 'CP0002' AND amendment_bfree_flag=1 ";
        $bfree_amendments = $this->GetSchemeAmendments($this->user->user_unit_code,$this->user->user_product_code,$bill_end_date,$bill_end_date,$copy_where);
        $ek_amendments = $this->GetEKAmendments($this->user->user_unit_code,$bill_start_date,$bill_end_date);

        $this->db->trans_begin();
        $no_id      = 'BILL_'.$this->user->user_unit_code.'_CODE';
        $bill_no    = $je_no = null;
        $bill_slno  = 1;
        //loop each amendments
        foreach($bill_amends as $amendment){
            $agent_code = $amendment->amendment_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            if(!isset($agents_details[$agent_code][$amendment->amendment_pdt_code]["bill_amt"])) $agents_details[$agent_code][$amendment->amendment_pdt_code]["bill_amt"]=0;
            $agents_details[$agent_code][$amendment->amendment_pdt_code]["bill_amt"] += $amendment->amount;
            $sunday_flag = 0;
            if($amendment->amendment_pdt_code == 'DLY' && date("D", strtotime($amendment->amendment_date))=='Sun') $sunday_flag = 1;
            $dly_bills[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>$amendment->amendment_pdt_code,
                                 "bill_no"=>$bill_no,
                                 "bill_date"=>$amendment->amendment_date,
                                 "bill_agent_code"=>$amendment->amendment_agent_code,
                                 "bill_ac_code"=>BillType::Bill,
                                 "bill_copies"=>$amendment->total_copies,
                                 "bill_rate_per_copy"=>$amendment->rate_per_copy,
                                 "bill_comm_amt"=>$amendment->amendment_comm_amt,
                                 "bill_debit_amt"=>$amendment->amount,
                                 "bill_sun_flag" => $sunday_flag,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Bill);
        }
        //loop each receipts
        $bill_slno = 1;
        foreach($bill_receipts as $rcpt){
            $agent_code = $rcpt->rec_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            //calulate bonus rdate rcpts amt
            if(!isset($bonus_rcpts[$agent_code][$bonus_details->bonus_first_date]["rcpt_amt"])) $bonus_rcpts[$agent_code][$bonus_details->bonus_first_date]["rcpt_amt"]=0;
            if(!isset($bonus_rcpts[$agent_code][$bonus_details->bonus_second_date]["rcpt_amt"])) $bonus_rcpts[$agent_code][$bonus_details->bonus_second_date]["rcpt_amt"]=0;
            if(!isset($bonus_rcpts[$agent_code][$bonus_details->bonus_third_date]["rcpt_amt"])) $bonus_rcpts[$agent_code][$bonus_details->bonus_third_date]["rcpt_amt"]=0;

            if(strtotime($rcpt->rec_date)<=strtotime($bonus_details->bonus_first_date)){
                $bonus_rcpts[$agent_code][$bonus_details->bonus_first_date]["rcpt_amt"]+= $rcpt->rec_total;
            }
            if(strtotime($rcpt->rec_date)<=strtotime($bonus_details->bonus_second_date)){
                $bonus_rcpts[$agent_code][$bonus_details->bonus_second_date]["rcpt_amt"]+= $rcpt->rec_total;
            }
            if(strtotime($rcpt->rec_date)<=strtotime($bonus_details->bonus_third_date)){
                $bonus_rcpts[$agent_code][$bonus_details->bonus_third_date]["rcpt_amt"]+= $rcpt->rec_total;
            }
            if(!isset($agents_details[$agent_code][$rcpt->product_code]["rcpt_amt"])) $agents_details[$agent_code][$rcpt->product_code]["rcpt_amt"]=0;
            $agents_details[$agent_code][$rcpt->product_code]["rcpt_amt"] += $rcpt->rec_total;
            $agent_rcpts[$agent_code][] = $rcpt;
            $dly_rcpts[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>$rcpt->product_code,
                                 "bill_no"=>$bill_no,
                                 "bill_date"=>$rcpt->rec_date,
                                 "bill_agent_code"=>$rcpt->rec_agent_code,
                                 "bill_ac_code"=>BillType::Receipt,
                                 "bill_debit_amt"=>null,
                                 "bill_credit_amt"=>$rcpt->rec_total,
                                 "bill_rec_no"=>$rcpt->rec_no,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Receipt);
        }
        //loop each journals
        $bill_slno = 1;
        foreach($bill_journals as $journal){
            $agent_code = $journal->je_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            if(!isset($agents_details[$agent_code][$journal->je_pdt_code]["jour_amt"])) $agents_details[$agent_code][$journal->je_pdt_code]["jour_amt"]=0;
            if(!isset($agents_details[$agent_code][$journal->je_pdt_code]["crdt_jour_amt"])) $agents_details[$agent_code][$journal->je_pdt_code]["crdt_jour_amt"]=0;
            if($journal->je_debit_amount>0){
                $agents_details[$agent_code][$journal->je_pdt_code]["jour_amt"] += $journal->je_debit_amount;
            }else{
                $agents_details[$agent_code][$journal->je_pdt_code]["crdt_jour_amt"] += $journal->je_credit_amount;
            }
            $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>$journal->je_pdt_code,
                                 "bill_no"=>$bill_no,
                                 "bill_date"=>$journal->je_date,
                                 "bill_agent_code"=>$journal->je_agent_code,
                                 "bill_ac_code"=>BillType::Journal,
                                 "bill_debit_amt"=>$journal->je_debit_amount,
                                 "bill_credit_amt"=>$journal->je_credit_amount,
                                 "bill_rec_no"=>$journal->je_code,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Journal);
        }
        //loop each scheme comm
        $bill_slno = 1;
        foreach($scheme_amendments as $sch_amd){
            $agent_code = $sch_amd->amendment_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            $sch_amount = $prdts_comm[$sch_amd->amendment_pdt_code]->product_sch_comm*$sch_amd->total_copies;
            if($sch_amount>0){
                if(!isset($agents_details[$agent_code][$sch_amd->amendment_pdt_code]["crdt_jour_amt"])) $agents_details[$agent_code][$sch_amd->amendment_pdt_code]["crdt_jour_amt"]=0;
                $agents_details[$agent_code][$sch_amd->amendment_pdt_code]["crdt_jour_amt"] += $sch_amount;
                if($je_no){
                    $je_no = $this->AutoIncrement($je_no);
                }else{
                    $je_no = $this->GetPrimaryId("JE_".$this->user->user_unit_code."_CODE");
                }
                $jour_entry[] = array("unit_code"=>$this->user->user_unit_code,
                                     "je_pdt_code"=>$sch_amd->amendment_pdt_code,
                                     "je_code"=>$je_no,
                                     "je_date"=>$bill_end_date,
                                     "je_agent_code"=>$sch_amd->amendment_agent_code,
                                     "je_agent_slno"=>$sch_amd->amendment_agent_slno,
                                     "je_ac_code"=>"JE00032",
                                     "je_credit_amount"=>$sch_amount,
                                     "je_voucher_no"=>"10/".date("m"),
                                     "je_bill_no"=>$bill_no,
                                     "created_by"=>$this->user->user_id,
                                     "created_date"=>$now);

                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                     "pdt_code"=>$sch_amd->amendment_pdt_code,
                                     "bill_no"=>$bill_no,
                                     "bill_date"=>$bill_end_date,
                                     "bill_agent_code"=>$sch_amd->amendment_agent_code,
                                     "bill_ac_code"=>BillType::Journal,
                                     "bill_debit_amt"=>null,
                                     "bill_credit_amt"=>$sch_amount,
                                     "bill_rec_no"=>$je_no,
                                     "bill_slno"=>$bill_slno++,
                                     "bill_type"=>BillTypeCode::Journal);
            }
        }
        //loop each billable free comm
        $bill_slno = 1;
        foreach($bfree_amendments as $bfree_amd){
            $agent_code = $bfree_amd->amendment_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            $sch_amount = $prdts_comm[$bfree_amd->amendment_pdt_code]->product_bfree_comm*$bfree_amd->total_copies;
            if($sch_amount>0){
                if(!isset($agents_details[$agent_code][$bfree_amd->amendment_pdt_code]["crdt_jour_amt"])) $agents_details[$agent_code][$bfree_amd->amendment_pdt_code]["crdt_jour_amt"]=0;
                $agents_details[$agent_code][$bfree_amd->amendment_pdt_code]["crdt_jour_amt"] += $sch_amount;
                if($je_no){
                    $je_no = $this->AutoIncrement($je_no);
                }else{
                    $je_no = $this->GetPrimaryId("JE_".$this->user->user_unit_code."_CODE");
                }
                $jour_entry[] = array("unit_code"=>$this->user->user_unit_code,
                                     "je_pdt_code"=>$bfree_amd->amendment_pdt_code,
                                     "je_code"=>$je_no,
                                     "je_date"=>$bill_end_date,
                                     "je_agent_code"=>$bfree_amd->amendment_agent_code,
                                     "je_agent_slno"=>$bfree_amd->amendment_agent_slno,
                                     "je_ac_code"=>"JE00041",
                                     "je_credit_amount"=>$sch_amount,
                                     "je_voucher_no"=>"10/".date("m"),
                                     "je_bill_no"=>$bill_no,
                                     "created_by"=>$this->user->user_id,
                                     "created_date"=>$now);

                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                     "pdt_code"=>$bfree_amd->amendment_pdt_code,
                                     "bill_no"=>$bill_no,
                                     "bill_date"=>$bill_end_date,
                                     "bill_agent_code"=>$bfree_amd->amendment_agent_code,
                                     "bill_ac_code"=>BillType::Journal,
                                     "bill_debit_amt"=>null,
                                     "bill_credit_amt"=>$sch_amount,
                                     "bill_rec_no"=>$je_no,
                                     "bill_slno"=>$bill_slno++,
                                     "bill_type"=>BillTypeCode::Journal);
            }
        }
        //loop each EK  comm
        $bill_slno = 1;
        foreach($ek_amendments as $ek_amd){
            $agent_code = $ek_amd->amendment_agent_code;
            if(!in_array($agent_code,$agents))
            {
                if($bill_no){
                    $bill_no = $this->AutoIncrement($bill_no);
                }else{
                    $bill_no = $this->GetPrimaryId($no_id);
                }
                $agents[] = $agent_code;
                $agents_bills[$agent_code] = $bill_no;
            }else{
                $bill_no = $agents_bills[$agent_code];
            }
            $sch_amount = $prdts_comm["DLY"]->product_ek_comm*$ek_amd->total_copies;
            if($sch_amount>0){
                if(!isset($agents_details[$agent_code]["DLY"]["crdt_jour_amt"])) $agents_details[$agent_code]["DLY"]["crdt_jour_amt"]=0;
                $agents_details[$agent_code]["DLY"]["crdt_jour_amt"] += $sch_amount;
                if($je_no){
                    $je_no = $this->AutoIncrement($je_no);
                }else{
                    $je_no = $this->GetPrimaryId("JE_".$this->user->user_unit_code."_CODE");
                }
                $jour_entry[] = array("unit_code"=>$this->user->user_unit_code,
                                     "je_pdt_code"=>"DLY",
                                     "je_code"=>$je_no,
                                     "je_date"=>$bill_end_date,
                                     "je_agent_code"=>$ek_amd->amendment_agent_code,
                                     "je_agent_slno"=>$ek_amd->amendment_agent_slno,
                                     "je_ac_code"=>"JE00041",
                                     "je_credit_amount"=>$sch_amount,
                                     "je_voucher_no"=>"10/".date("m"),
                                     "je_bill_no"=>$bill_no,
                                     "created_by"=>$this->user->user_id,
                                     "created_date"=>$now);

                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                     "pdt_code"=>"DLY",
                                     "bill_no"=>$bill_no,
                                     "bill_date"=>$bill_end_date,
                                     "bill_agent_code"=>$ek_amd->amendment_agent_code,
                                     "bill_ac_code"=>BillType::Journal,
                                     "bill_debit_amt"=>null,
                                     "bill_credit_amt"=>$sch_amount,
                                     "bill_rec_no"=>$je_no,
                                     "bill_slno"=>$bill_slno++,
                                     "bill_type"=>BillTypeCode::Journal);
            }
        }
        //get agent security contribution
        $agent_sec_record = $this->GetAgentSecContribution($agents);
        foreach($agent_sec_record as $sec_rec){
            $agent_sec_contr[$sec_rec->agent_code]  =  $sec_rec;     
        }
        //add agents opening balanace
        $agent_opbal_record = $this->GetAgentOpeningBalance($prev_last_date);
        foreach($agent_opbal_record as $opbal_rec){
            if(!isset($agent_opbal[$opbal_rec->tb_agent_code]["opbal"])) $agent_opbal[$opbal_rec->tb_agent_code]["opbal"] = 0;
            $agent_opbal[$opbal_rec->tb_agent_code]["opbal"] +=  $opbal_rec->tb_debit_amount;
            $agent_opbal[$opbal_rec->tb_agent_code]["opbal"] -=  $opbal_rec->tb_credit_amount;
           $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>$opbal_rec->pdt_code,
                                 "bill_no"=>null,
                                 "bill_date"=>$bill_start_date,
                                 "bill_agent_code"=>$opbal_rec->tb_agent_code,
                                 "bill_ac_code"=>BillType::OpeningBalance,
                                 "bill_debit_amt"=>$opbal_rec->tb_debit_amount,
                                 "bill_credit_amt"=>$opbal_rec->tb_credit_amount,
                                 "bill_rec_no"=>null,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::OPBal);
        }
        //add security contribution for agents
        $bill_slno = 1;
        foreach($agents as $ag_code){
            $sec_amt = 0;
            if(isset($agents_details[$ag_code]["bill_amt"])){
                if($agent_sec_contr[$ag_code]->agent_sec_flag=='1'){
                    $sec_amt = $agents_details[$ag_code]["DLY"]["bill_amt"]+$agent_sec_contr[$ag_code]->agent_sec_contr;
                }else{
                    $sec_amt = $agents_details[$ag_code]["DLY"]["bill_amt"]+($agents_details[$ag_code]["DLY"]["bill_amt"]*($agent_sec_contr[$ag_code]->agent_sec_contr/100));
                }
                $sec_amt = round($sec_amt,3);
            }
            if($sec_amt>0){
                $security_contr[] = array("unit_code"=>$this->user->user_unit_code,
                                         "sec_date"=>$bill_end_date,
                                         "sec_agent_code"=>$ag_code,
                                         "sec_agent_slno"=>$agent_sec_contr[$ag_code]->agent_slno,
                                         "sec_type"=>SCType::SecurityContribution,
                                         "sec_debit_amt"=>$sec_amt,
                                         "sec_credit_amt"=> null,
                                         "sec_trans_no"=>$agents_bills[$ag_code],
                                         "created_by"=>$this->user->user_id,
                                         "created_date"=>$now);
                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                     "pdt_code"=>"DLY",
                                     "bill_no"=>$agents_bills[$ag_code],
                                     "bill_date"=>$bill_end_date,
                                     "bill_agent_code"=>$ag_code,
                                     "bill_ac_code"=>BillType::SecurityContribution,
                                     "bill_debit_amt"=>$sec_amt,
                                     "bill_credit_amt"=>null,
                                     "bill_rec_no"=>null,
                                     "bill_slno"=>$bill_slno++,
                                     "bill_type"=>BillTypeCode::SecurityContribution);
            }
            //add agent bonus percentage
            if(!isset($agent_opbal[$ag_code]["opbal"]))  $agent_opbal[$ag_code]["opbal"]=0;
            if(isset($bonus_rcpts[$ag_code][$bonus_details->bonus_first_date]["rcpt_amt"]) && ($agent_opbal[$ag_code]["opbal"]-$bonus_rcpts[$ag_code][$bonus_details->bonus_first_date]["rcpt_amt"] <=0)){
                $bonus_amt = $agents_details[$ag_code]["DLY"]["bill_amt"]*($bonus_details->bonus_first_per/100);
                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>"DLY",
                                 "bill_no"=>$agents_bills[$ag_code],
                                 "bill_date"=>$bill_end_date,
                                 "bill_agent_code"=>$ag_code,
                                 "bill_ac_code"=>BillType::Bonus,
                                 "bill_debit_amt"=>null,
                                 "bill_credit_amt"=>$bonus_amt,
                                 "bill_rec_no"=>null,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Bonus);
                
            }
            //second bonus percentage
            else if(isset($bonus_rcpts[$ag_code][$bonus_details->bonus_second_date]["rcpt_amt"]) && ($agent_opbal[$ag_code]["opbal"]-$bonus_rcpts[$ag_code][$bonus_details->bonus_second_date]["rcpt_amt"] <=0)){
                $bonus_amt = $agents_details[$ag_code]["DLY"]["bill_amt"]*($bonus_details->bonus_second_per/100);
                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>"DLY",
                                 "bill_no"=>$agents_bills[$ag_code],
                                 "bill_date"=>$bill_end_date,
                                 "bill_agent_code"=>$ag_code,
                                 "bill_ac_code"=>BillType::Bonus,
                                 "bill_debit_amt"=>null,
                                 "bill_credit_amt"=>$bonus_amt,
                                 "bill_rec_no"=>null,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Bonus);
                
            }
            //third bonus percentage
            else if(isset($bonus_rcpts[$ag_code][$bonus_details->bonus_third_date]["rcpt_amt"]) && ($agent_opbal[$ag_code]["opbal"]-$bonus_rcpts[$ag_code][$bonus_details->bonus_third_date]["rcpt_amt"] <=0)){
                $bonus_amt = $agents_details[$ag_code]["DLY"]["bill_amt"]*($bonus_details->bonus_third_per/100);
                $dly_jours[] = array("unit_code"=>$this->user->user_unit_code,
                                 "pdt_code"=>"DLY",
                                 "bill_no"=>$agents_bills[$ag_code],
                                 "bill_date"=>$bill_end_date,
                                 "bill_agent_code"=>$ag_code,
                                 "bill_ac_code"=>BillType::Bonus,
                                 "bill_debit_amt"=>null,
                                 "bill_credit_amt"=>$bonus_amt,
                                 "bill_rec_no"=>null,
                                 "bill_slno"=>$bill_slno++,
                                 "bill_type"=>BillTypeCode::Bonus);
                
            }
        }
        //security intrest 
        $bill_month = date("M", strtotime($bill_start_date));
        if($bill_month=='Jun' || $bill_month=='Dec'){
            $sec_contributions = $this->GetSecurityContributions();
            foreach($sec_contributions as $sec){
                $security_contr[] = array("unit_code"=>$this->user->user_unit_code,
                                         "sec_date"=>$bill_end_date,
                                         "sec_agent_code"=>$sec->sec_agent_code,
                                         "sec_agent_slno"=>$sec->sec_agent_slno,
                                         "sec_type"=>SCType::SecurityInterest,
                                         "sec_debit_amt"=>null,
                                         "sec_credit_amt"=>round($sec->sec_credit_amt*0.025,3),
                                         "sec_trans_no"=>null,
                                         "created_by"=>$this->user->user_id,
                                         "created_date"=>$now);
            }
        }
        //finalize bill for all prdts
        foreach($prdts as $pdt){
            $finalize_bill[] = array(
                "unit_code"=>$this->user->user_unit_code,
                "product_code"=>$pdt,
                "entry_type"=>FinalizeType::Bill,
                "entry_date"=>$bill_end_date,
                "entry_period"=>$bill_period,
                "created_by"=>$this->user->user_id,
                "created_date"=>$now
                );
        }
        //insert data to the db
        $this->db->insert_batch('pmd_dly_bill',$dly_bills);
        $this->db->insert_batch('pmd_dly_bill',$dly_rcpts);
        $this->db->insert_batch('pmd_dly_bill',$dly_jours);
        $this->db->insert_batch('pmd_journal',$jour_entry);
        $this->db->insert_batch('pmd_security',$security_contr);
        $this->db->insert_batch('pmd_finalize',$finalize_bill);
        if($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('billed_success');
        }
        else
        {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return $this->Message;
    }
    private function GetBillAmendments($unit,$bill_start_date,$bill_end_date,$copy_code){
        $sql = "SELECT
                    amendment_date,
                    amendment_pdt_code,
                    amendment_agent_code,
                    SUM(amendment_total) total_copies,
                    amendment_rate_per_copy,
                    SUM(amendment_amt) AS amount,
                    SUM(amendment_comm_amt) AS amendment_comm_amt
                FROM
                       pmd_amendment 
                GROUP BY amendment_date,amendment_pdt_code,amendment_agent_code
                WHERE
                   unit_code ='".$unit."' AND amendment_copy_code='".$copy_code."' AND amendment_date>='".$bill_start_date."' AND  amendment_date<='".$bill_end_date."' ORDER BY amendment_pdt_code,amendment_agent_code,amendment_date";
        return $this->db->query($sql)->result();
    }
    private function GetSchemeAmendments($unit,$bill_start_date,$bill_end_date,$copy_where=''){
        $sql = "SELECT
                    amendment_pdt_code,
                    amendment_date,
                    amendment_agent_code,
                    amendment_agent_slno,
                    SUM(amendment_total) total_copies
                FROM
                       pmd_amendment 
                GROUP BY amendment_pdt_code,amendment_agent_code,amendment_date
                WHERE
                   unit_code ='".$unit."' ".$copy_where." AND amendment_date>='".$bill_start_date."' AND  amendment_date<='".$bill_end_date."' ORDER BY amendment_pdt_code,amendment_agent_code,amendment_date";
        return $this->db->query($sql)->result();
    }
    private function GetEKAmendments($unit,$bill_start_date,$bill_end_date){
        $sql = "SELECT
                    amendment_agent_code,
                    amendment_agent_slno,
                    count(*) total_copies
                FROM
                       pmd_temp_amendment
                GROUP BY amendment_agent_code
                WHERE
                   unit_code ='".$unit."' AND amendment_pdt_code = 'DLY' AND amendment_copy_type='CPT0000006' AND 
((amendment_start_date>='".$bill_start_date."' AND (amendment_end_date<='".$bill_end_date."' OR amendment_end_date IS NULL)) ORDER BY amendment_start_date";
        return $this->db->query($sql)->result();
    }
    private function GetBillReceipts($unit,$bill_start_date,$bill_end_date){
        $sql = "SELECT
                    rec_no,
                    product_code,
                    rec_date,
                    rec_agent_code,
                    rec_total
                FROM
                       pmd_receipt
                WHERE
                   unit_code = '".$unit."' AND rec_date>='".$bill_start_date."' AND  rec_date<='".$bill_end_date."' ORDER BY rec_agent_code,rec_date";
        return $this->db->query($sql)->result();
    }
    private function GetBillJournals($unit,$bill_start_date,$bill_end_date){
        $sql = "SELECT
                    je_code,
                    je_date,
                    je_pdt_code,
                    je_agent_code,
                    je_debit_amount,
                    je_credit_amount
                FROM
                       pmd_journal 
                GROUP BY je_agent_code,je_date
                WHERE
                   unit_code ='".$unit."' AND je_date>='".$bill_start_date."' AND  je_date<='".$bill_end_date."' ORDER BY je_agent_code,je_date";
        return $this->db->query($sql)->result();
    }
    private function GetProducts(){
        $sql = "SELECT
                    product_code,
                    product_name,
                    product_sch_comm,
                    product_ek_comm,
                    product_bfree_comm
                FROM
                       pmd_products
                WHERE
                   product_code != 'FSH' ORDER BY product_priority";
        return $this->db->query($sql)->result();
    }
    private function GetAgentSecContribution($agent_codes){
        $sql = "SELECT
                agent_slno,
                agent_code,
                agent_sec_contr,
                agent_sec_flag
            FROM
                   pmd_agentdetails 
            WHERE
               agent_unit ='".$this->user->user_unit_code."' AND agent_code IN (".implode("','", $agent_codes).")";
        return $this->db->query($sql)->result();
    }
    private function GetBonusDate($bonus_mnth, $bonus_yr){
        $sql = "SELECT
                bonus_first_per,
                bonus_first_date,
                bonus_second_per,
                bonus_second_date,
                bonus_third_per,
                bonus_third_date
            FROM
                   pmd_bonusdate 
            WHERE
               bonus_month ='".$bonus_mnth."' AND bonus_year ='".$bonus_yr."'";
        return $this->db->query($sql)->row();
    }
    private function GetAgentOpeningBalance($prev_date){
        $sql = "SELECT
                tb_date,
                pdt_code,
                tb_agent_code,
                IF(tb_debit_amount IS NULL, 0 , tb_debit_amount) tb_debit_amount,
                IF(tb_credit_amount IS NULL, 0 , tb_credit_amount) tb_credit_amount
            FROM
                   pmd_trialbalance 
            WHERE
              unit_code='".$this->user->user_unit_code."' AND tb_date ='".$prev_date."' ORDER BY tb_agent_code,pdt_code";
        return $this->db->query($sql)->result();
    }
    private function GetSecurityContributions(){
        $sql = "SELECT
                sec_agent_code,
                sec_agent_slno,
                SUM(sec_credit_amt) as sec_credit_amt
            FROM
                   pmd_security 
            WHERE
              (sec_type='".SCType::SecurityReceipts."' OR sec_type='".SCType::SecurityInterest."') GROUP BY sec_agent_code";
        return $this->db->query($sql)->result();
    }
    private function FinalizeAll($products, $finalize_dte){
        $now = date('Y-m-d H:i:s');
        $finalize_type = Enum::getAllConstants('FinalizeType');
        $finalize = array();
        foreach($finalize_type as $key=>$ftype){
            if($key=='AMEND' || $key=='JOUR' || $key=='RCPT'){
                $finalize[$ftype] = $key;
            }
        }
        $this->db->trans_begin();
        foreach($products as $prdt){
            foreach($finalize as $fin){
                $finalize_record=array("unit_code"=>$this->user->user_unit_code,"product_code"=>$prdt->product_code,"entry_type"=>$fin,"entry_date"=>$finalize_dte,"cancel_flag"=>0,"created_by"=>$this->user->user_id,"created_date"=>$now);
                $insert_query = $this->db->insert_string('pmd_finalize', $finalize_record);
                $insert_query .= " ON DUPLICATE KEY UPDATE modified_by=".$this->user->user_id.",modified_date='".$now."'";
                $this->db->query($insert_query);
            }
        }
        if($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $this->Message->status=200;
            $this->Message->text="Finalized successfully.";
        }
        else {
            $this->db->trans_rollback();
            $this->Message->status=400;
            $this->Message->text="Error occured during finalization";
        }
        return $this->Message;
    }

    /*Outstandings*/
    public function GenerateOutstandings(){
           $agents_bills = $security_contr = $agent_os = array();
           $bill_debit_credit = array("debit"=>0,"credit"=>0);
           $bill_last_finalize = $this->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Bill);
           $bill_start_date = date("Y-m-01", strtotime($bill_last_finalize));
           $bill_end_date = date("Y-m-d", strtotime($bill_last_finalize));

           $query = "SELECT
                    agent_code,
                    agent_slno,
                    agent_sec_contr,
                    agent_sec_flag,
                    agent_comm,
                    agent_comm_flag
                FROM
                     pmd_agentdetails
                WHERE
                    agent_unit='".$this->user->user_unit_code."' AND agent_status=0  ORDER BY agent_code";
            $agents_lists = $this->db->query($query)->result(); 
            
            foreach($agents_lists as $agent){
                $agent_details = $this->GetAgentBillDetails($this->user->user_unit_code,$bill_start_date,$bill_end_date,$agent->agent_code);
                $agent_sec_cont = $this->GetAgentSecurity($this->user->user_unit_code,$bill_start_date,$bill_end_date,$agent->agent_code);
                foreach($agent_sec_cont as $secc){
                    $security_contr[$secc->sec_type] = $secc->credit_amt;
                }
                foreach($agent_details as $agent_det){
                    $agents_bills[$agent_det->pdt_code][$agent_det->bill_ac_code] = $agent_det;
                    $bill_debit_credit["debit"] += $agent_det->debit_amt;
                    $bill_debit_credit["credit"] += $agent_det->credit_amt;
                }
                foreach($agents_bills as $key=>$ag_bill){
                    $agent_os[] = array("unit_code"=>$this->user->user_unit_code,
                                    "pdt_code"=>$key,
                                    "os_from_date"=>$bill_start_date,
                                    "os_to_date"=>$bill_end_date,
                                    "os_agent_code"=>$agent->agent_code,
                                    "os_agent_slno"=>$agent->agent_slno,
                                    "os_op_bal"=>$ag_bill[BillType::OpeningBalance]->debit_amt>0?$ag_bill[BillType::OpeningBalance]->debit_amt:($ag_bill[BillType::OpeningBalance]->credit_amt!=0?(-$ag_bill[BillType::OpeningBalance]->credit_amt):0),
                                    "os_bill"=>$ag_bill[BillType::Bill]->debit_amt,
                                    "os_receipt"=>$ag_bill[BillType::Receipt]->debit_amt,
                                    "os_sale_copies"=>$ag_bill[BillType::Bill]->copies,
                                    "os_return_amt"=>0,
                                    "os_debit"=>$ag_bill[BillType::Journal]->debit_amt,
                                    "os_credit"=>$ag_bill[BillType::Journal]->credit_amt,
                                    "os_sec_per"=>$agent->agent_sec_contr,
                                    "os_sec_flag"=>$agent->agent_sec_flag,
                                    "os_sec_contr"=>((isset($security_contr[SCType::SecurityReceipts])?$security_contr[SCType::SecurityReceipts]:0)+(isset($security_contr[SCType::SecurityInterest])?$security_contr[SCType::SecurityReceipts]:0)),
                                    "os_sec_amt"=>$ag_bill[BillType::Bill]->copies,
                                    "os_comm_per"=>$agent->agent_comm,
                                    "os_comm_flag"=>$agent->agent_comm_flag,
                                    "os_collectable"=>$bill_debit_credit["debit"]-$bill_debit_credit["credit"],
                                    "os_target"=>0);
                }
            }
            $this->db->trans_begin();
            $this->db->where('os_from_date', $bill_start_date);
            $this->db->where('os_to_date', $bill_end_date);
            $this->db->delete('pmd_outstanding');
            if($agent_os) $this->db->insert_batch('pmd_outstanding',$agent_os);
            if($this->db->trans_status() === TRUE)
            {
                $this->db->trans_commit();
                $this->Message->status=200;
                $this->Message->text= "Outstanding Generated Successfully.";
            }
            else
            {
                $this->db->trans_rollback();
                $this->Message->status=400;
                $this->Message->text=$this->lang->line('error_processing');
            }
	    return $this->Message;
    }
    private function GetAgentBillDetails($unit_code,$bill_from_dte,$bill_to_dte,$agent_code){
        $query = "SELECT
                    pdt_code,
                    bill_no,
                    bill_agent_code,
                    bill_ac_code,
                    SUM(bill_copies) copies,
                    SUM(bill_debit_amt) debit_amt,
                    SUM(bill_credit_amt) credit_amt
                FROM
                     pmd_dly_bill
                WHERE
                    unit_code='".$unit_code."' AND bill_date>='".$bill_from_dte."' AND bill_date<='".$bill_to_dte."' AND bill_agent_code='".$agent_code."' GROUP BY pdt_code,bill_ac_code ORDER BY bill_agent_code";
        return $this->db->query($query)->result();
    }
    private function GetAgentSecurity($unit_code,$bill_from_dte,$bill_to_dte,$agent_code){
        $query = "SELECT
                    sec_agent_code,
                    sec_type,
                    SUM(sec_debit_amt) debit_amt,
                    SUM(sec_credit_amt) credit_amt
                FROM
                     pmd_security
                WHERE
                    unit_code='".$unit_code."' AND sec_date>='".$bill_from_dte."' AND sec_date<='".$bill_to_dte."' AND sec_agent_code='".$agent_code."' GROUP BY sec_type";
        return $this->db->query($query)->result();
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
}