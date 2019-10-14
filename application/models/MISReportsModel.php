<?php
class MISReportsModel extends CI_Model   
{
	public function __construct() {
		parent::__construct();
	}
    public function GetUnits()
    {
        return  $this->db->query("SELECT unit_code, unit_name FROM pmd_unit WHERE cancel_flag = 0 ORDER BY unit_priority")->result();
    }
    public function GetPromoters()
    {
        return  $this->db->query("SELECT 
                                        promoter_code, 
                                        promoter_name,
                                        promoter_area,
                                        promoter_phone 
                                    FROM
                                        pmd_promoter 
                                    WHERE
                                        cancel_flag = 0 AND
                                        promoter_unit = '".$this->user->user_unit_code."'
                                    ORDER BY promoter_name")->result();
    }
    public function GetCopyMaster()
    {
        return  $this->db->query("SELECT 
                                        copy_code, 
                                        copy_name
                                    FROM
                                        pmd_copymaster 
                                    WHERE
                                        cancel_flag = 0
                                    ORDER BY copy_name")->result();
    }
    public function GetLatestBillingPeriod()
    {
        return  $this->db->query("SELECT 
                                        entry_period, 
                                        entry_date
                                    FROM
                                        pmd_finalize 
                                    WHERE
                                        cancel_flag = 0
                                    ORDER BY entry_date DESC LIMIT 1")->row();
    }
    //Plan For Copies
    public function GetCopiesPlansSummary()
    {
        return  true;
    } 
    public function GetCopiesPlansDetailed()
    {
        return  true;
    } 
    //Scheme Details
    public function GetSchemeSummary()
    {
        return  true;
    } 
    public function GeSchemeDetailed()
    {
        return  true;
    }
    public function GetSchemeCollectionSummary(){
        $scheme_codes = array();
        $where_condition = "";
        $slect_scheme = $this->input->post('select_date');
        $unit_record = json_decode(rawurldecode($this->input->post('multi_sel_unit',true)),true);
        $unit_codes = array_column($unit_record, 'Code');
        $multi_scheme = $this->input->post('multi_sel_scheme',true);
        if($multi_scheme){
            $scheme_record = json_decode(rawurldecode($multi_scheme),true);
            $scheme_codes = array_column($scheme_record, 'Code');
        }
        $from_date = $this->input->post('from_date',true);
        $to_date = $this->input->post('to_date',true);
        $where_condition .= " AND SCH.unit_code IN ('".implode("','",$unit_codes)."')";
        if($slect_scheme == 0){
            $where_condition .= " AND DATE(SCH.sch_can_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(SCH.sch_can_date) <= '".date('Y-m-d',strtotime($to_date)) ."' ";
        }
        else if($slect_scheme == 1){
            $where_condition .= " AND DATE(SCH.created_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(SCH.created_date) <= '".date('Y-m-d',strtotime($to_date)) ."' ";
        }
        else if($slect_scheme == 2){
            $where_condition .= " AND DATE(SCH.sch_from_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(SCH.sch_from_date) <= '".date('Y-m-d',strtotime($to_date)) ."'";
        }
        else if($slect_scheme == 3){
            $where_condition .= " AND DATE(SCH.sch_to_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(SCH.sch_to_date) <= '".date('Y-m-d',strtotime($to_date)) ."'";
        }
        if($scheme_codes){
            $where_condition .= " AND SCH.sch_copy_type IN ('".implode("','",$scheme_codes)."')";
        }
        

    $qry =    "SELECT
                        SCH.unit_code,
                        unit_name,
                        COUNT(*) AS sch_count,
                        SUM(sch_amount) AS sch_amount,
                       (SELECT
                            SUM(srec_amount) 
                         FROM
                             pmd_scheme_receipt
                         WHERE
                                  srec_scheme_code = SCH.sch_slno AND srec_pay_type=1) cash,
                                 (SELECT
                                       SUM(srec_amount) 
                                  FROM
                                       pmd_scheme_receipt
                         WHERE
                                srec_scheme_code = SCH.sch_slno AND srec_pay_type=2) cheque,
                                (SELECT
                                      SUM(pdc_amount) 
                                 FROM
                                      pmd_other_pdc
                        WHERE
                               pdc_scheme_code = SCH.sch_slno) pdc
              FROM
                     pmd_scheme SCH
              JOIN
                    pmd2019.pmd_unit UN on SCH.unit_code = UN.unit_code
              WHERE 1=1 ".$where_condition." GROUP BY SCH.unit_code";
        return $this->db->query($qry)->result();
    }
    public function GetOtherReceiptSummary(){
        $where_condition = "";
        $qry="";
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $copy_type = json_decode(rawurldecode($this->input->post('multi_sel_copy_type',true)),true);
        $copy_type_rec = array_column($copy_type,'Code');
        $where_condition .= " AND DATE(srec_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(srec_date) <= '".date('Y-m-d',strtotime($to_date)) ."' ";
        if($copy_type_rec) $where_condition .= " AND srec_copy_type IN ('".implode("','",$copy_type_rec)."')";
        $other_unit = json_decode(rawurldecode($this->input->post('multi_sel_unit',true)),true);
        $other_unit_rec = array_column($other_unit,'Code');
        $where_condition .= " AND SR.unit_code IN ('".implode("','",$other_unit_rec)."')";
        $canvassed_by = $this->input->post('canvassed_by_type');
        if($canvassed_by == 17){
            $agent_rec = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            if($agent_rec) $where_condition .= " AND SCH.sch_can_code = '".$agent_rec["Code"]."'";
        }
        if($canvassed_by == 1){
            $staff_rec = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            if($staff_rec) $where_condition .= " AND SCH.sch_can_code = '".$staff_rec["Code"]."'";
        }
        if($canvassed_by == 0){
            $canvassed_others = $this->input->post('canvassed_others');
            if($canvassed_others) $where_condition .= " AND SCH.sch_can_name = '".$canvassed_others."'";
        }
        $report_type = $this->input->post('report_type');
        if($report_type=='0'){
            $qry = "SELECT
                        SR.srec_no,
                        SR.unit_code,
                        SR.srec_date,
                        SR.srec_pdt_code,
                        SR.srec_type_code,
                        SR.srec_copy_code,
                        SR.srec_copy_group,
                        SR.srec_copy_type,
                        SR.srec_sub_code,
                        SR.srec_scheme_code,
                        SR.srec_sub_name,
                        SR.srec_amount,
                        SR.srec_pay_type,
                        SR.srec_chq_type,
                        SR.srec_chq_no,
                        SR.srec_chq_date,
                        SR.srec_card_no,
                        SR.srec_card_name,
                        SR.srec_card_exp_date,
                        SR.srec_bank_code,
                        SR.srec_paid_by,
                        SR.srec_promoter_code,
                        SR.created_date,
                        srec_remarks,
                        SCH.sch_agent_code,
                        SCH.sch_can_code,
                        SCH.sch_can_name,
                        SCH.sch_can_dept,
                        SCH.sch_can_date,
                        SCH.sch_from_date,
                        SCH.sch_to_date,
                        SCH.sch_renew_code,
                        BN.bank_name,
                        copytype_name,
                        PR.promoter_name,
                        PR.promoter_area,
                        PR.promoter_phone
                        
            FROM
                       pmd_scheme_receipt SR
           JOIN
                       pmd_scheme SCH  ON (SR.unit_code = SCH.unit_code AND srec_scheme_code = SCH.sch_slno)
            JOIN
                       pmd_bankmaster BN ON srec_bank_code = BN.bank_code
            JOIN
                       pmd_copytype ON SR.srec_copy_type = copytype_code
            JOIN
                       pmd_promoter PR ON (PR.promoter_unit = SR.unit_code AND SR.srec_promoter_code = PR.promoter_code)
            WHERE
                      1=1 ".$where_condition." AND SR.cancel_flag=0";
        }else{
            $qry = "SELECT
                        group_code,
                        group_name,
                        srec_pay_type,
                        SUM(srec_amount) amount
            FROM
                       pmd_scheme_receipt SR
            JOIN
                       pmd_copygroup CG ON SR.srec_copy_group = CG.group_code
            JOIN
                       pmd_scheme SCH  ON (SR.unit_code = SCH.unit_code AND srec_scheme_code = SCH.sch_slno)
            WHERE
                      1=1 ".$where_condition." GROUP BY CG.group_code,srec_pay_type AND SR.cancel_flag=0";
        }
        return $this->db->query($qry)->result();
    }
    public function GetOtherReceiptsPDCSummary(){
        $where_condition = "";
        $qry="";
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $copy_type = json_decode(rawurldecode($this->input->post('multi_sel_copy_type',true)),true);
        $copy_type_rec = array_column($copy_type,'Code');
        $where_condition .= " AND DATE(pdc_date) >= '". date('Y-m-d',strtotime($from_date)) ."' AND DATE(pdc_date) <= '".date('Y-m-d',strtotime($to_date)) ."' ";
        if($copy_type_rec) $where_condition .= " AND pdc_copy_type IN ('".implode("','",$copy_type_rec)."')";
        $other_unit = json_decode(rawurldecode($this->input->post('multi_sel_unit',true)),true);
        $other_unit_rec = array_column($other_unit,'Code');
        $where_condition .= " AND PD.unit_code IN ('".implode("','",$other_unit_rec)."')";
        $canvassed_by = $this->input->post('canvassed_by_type');
        if($canvassed_by == 17){
            $agent_rec = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            if($agent_rec) $where_condition .= " AND SCH.sch_can_code = '".$agent_rec["Code"]."'";
        }
        if($canvassed_by == 1){
            $staff_rec = json_decode(rawurldecode($this->input->post('canvassed_by_rec_sel',true)),true);
            if($staff_rec) $where_condition .= " AND SCH.sch_can_code = '".$staff_rec["Code"]."'";
        }
        if($canvassed_by == 0){
            $canvassed_others = $this->input->post('canvassed_others');
            if($canvassed_others) $where_condition .= " AND SCH.sch_can_name = '".$canvassed_others."'";
        }
        $report_type = $this->input->post('report_type');
        if($report_type=='0'){
            $qry = "SELECT
                        pdc_no,
                        PD.unit_code,
                        pdt_code,
                        pdc_date,
                        pdc_type_code,
                        pdc_copy_code,
                        pdc_copy_group,
                        pdc_copy_type,
                        pdc_sub_code,
                        pdc_agent_code,
                        pdc_agent_slno,
                        pdc_scheme_code,
                        pdc_sub_name,
                        pdc_amount,
                        pdc_pay_type,
                        pdc_chq_type,
                        pdc_chq_no,
                        pdc_chq_date,
                        pdc_bank_code,
                        pdc_paid_by,
                        pdc_promoter_code,
                        pdc_remarks,
                        SCH.sch_agent_code,
                        SCH.sch_can_code,
                        SCH.sch_can_name,
                        SCH.sch_can_dept,
                        SCH.sch_can_date,
                        SCH.sch_from_date,
                        SCH.sch_to_date,
                        SCH.sch_renew_code,
                        BN.bank_name,
                        copytype_name,
                        PR.promoter_name,
                        PR.promoter_area,
                        PR.promoter_phone,
                        PD.created_date
            FROM
                       pmd_other_pdc PD
           JOIN
                       pmd_scheme SCH  ON (PD.unit_code = SCH.unit_code AND PD.pdc_scheme_code = SCH.sch_slno)
            JOIN
                       pmd_bankmaster BN ON PD.pdc_bank_code = BN.bank_code
           LEFT JOIN
                       pmd_copytype ON PD.pdc_type_code = copytype_code
           LEFT JOIN
                       pmd_promoter PR ON (PR.promoter_unit = PD.unit_code AND PD.pdc_promoter_code = PR.promoter_code)
            WHERE
                      1=1 ".$where_condition." AND PD.cancel_flag=0";
        }else{
            $qry = "SELECT
                        group_code,
                        group_name,
                        pdc_pay_type,
                        SUM(pdc_amount) amount
            FROM
                       pmd_other_pdc PD
            JOIN
                       pmd_copygroup CG ON PD.pdc_copy_group = CG.group_code
            JOIN
                       pmd_scheme SCH  ON (PD.unit_code = SCH.unit_code AND pdc_scheme_code = SCH.sch_slno)
            WHERE
                      1=1 ".$where_condition." GROUP BY CG.group_code,pdc_pay_type AND PD.cancel_flag=0";
        }
        return $this->db->query($qry)->result();
    }
}