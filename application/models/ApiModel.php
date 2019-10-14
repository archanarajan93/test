<?php
class ApiModel extends CI_Model
{
	public function __construct() {
		parent::__construct();		
	}		
	public function GetEmployeeDetails($data)
	{
        $hr_db  = $this->load->database('hr_db', TRUE);
        $sql = "SELECT
                    E.unit_code AS Unit,
                    E.emp_name AS Name,
                    D.dept_name AS Department,
                    DES.desig_name As Designation,
                    E.emp_slno AS `Code/hidden`
                FROM
                    hr_employee E
                        JOIN
                    hr_department D ON D.dept_code = E.emp_dept_code
                        JOIN
                    hr_designation DES ON DES.desig_code = E.emp_desig_code
                        WHERE
                    E.emp_disable = 0 AND 
                    E.emp_name LIKE '%".$data['search']."%'" ;
        $sql_res = $hr_db->query($sql)->result();
        $hr_db->close();
        echo json_encode($sql_res);
	}
    public function ACMDetails($data)
	{
        $where_condition="";
        $acm_unit = " AND A.acm_unit = '".$_SESSION['CIRSTAYLOGIN']['user_unit_code']."'";
        $criteria=json_decode($data['criteria'],true); 
        if($criteria)
        {
            foreach($criteria as $item) {
               if($item['input'] != '') {   
                   if($item['column']=='acm_unit'){
                       $acm_unit = " AND A.acm_unit = '".$item['input']."'";
                   }else{
                       $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                   }
               }
            }
        }
        $qry = "SELECT
                    A.acm_name AS `Name`,
                    A.acm_phone AS `Phone`,
                    R.region_name AS `Region`,
                    A.acm_region AS `RegionCode/hidden`,
                    A.acm_code AS `Code/hidden`
                FROM
                    pmd_acm A
                JOIN
                    pmd_region R ON R.region_code = A.acm_region
                WHERE
                    A.cancel_flag = 0 AND
                    (A.acm_name LIKE '%".$data['search']."%' OR A.acm_phone LIKE '%".$data['search']."%') ".$acm_unit.$where_condition."
                ORDER BY
                    A.acm_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function ProductGroups($data) {
        $qry = "SELECT
                    group_code AS Code,
                    group_name AS Name
                FROM
                    pmd_productgroup
                WHERE
                    cancel_flag = 0 AND
                    group_name LIKE '%".$data['search']."%'
                ORDER BY
                    group_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetTeamMembers($data)
	{
        $acm_where='';
        $qry_array = array();
        $work_type = $acm_codes = array();
        $unit= '';
        $criteria=json_decode($data['criteria'],true); 
        if($criteria)
        {
            foreach($criteria as $item) {
               if($item['column'] == 'work_type') {  
                    $work_type = $item['input'];
               }
               if($item['column'] == 'acm') {  
                    $acm_codes_rec = json_decode(rawurldecode($item['input']),true);
                    $acm_codes= array_column($acm_codes_rec,'Code');
               }
               if($item['column'] == 'unit') {
                    $unit= $item['input'];
               }
            }
        }
        if($acm_codes){
            $acm_where .= " AND promoter_acm_code IN ('".implode(",",$acm_codes)."')";
        }
        if(in_array(WorkType::Promoter,$work_type)){
            $qry_array[] = "SELECT
                                 promoter_name AS `Name`,
                                 promoter_area AS `Location`,
                                 'Promoter' AS `Member Type`
                             FROM
                                 pmd_promoter WHERE cancel_flag=0 AND promoter_unit='".$unit."' ".$acm_where;
        }
        if(in_array(WorkType::Bureau,$work_type)){
            $qry_array[] = "SELECT
                                 bureau_name AS `Name`,
                                 bureau_name AS `Location`,
                                 'Bureau' AS `Member Type`
                             FROM
                                 pmd_bureau WHERE cancel_flag=0 AND bureau_unit='".$unit."'";
        }
        if(in_array(WorkType::Internal_Work,$work_type)){
            /*$hr_db  = $this->load->database('hr_db', TRUE);
            $sql = "SELECT
                        E.unit_code AS Unit,
                        E.emp_slno AS Code,
                        E.emp_name AS Name,
                        D.dept_name AS Department,
                        DES.desig_name As Designation
                    FROM
                        hr_employee E
                            JOIN
                        hr_department D ON D.dept_code = E.emp_dept_code
                            JOIN
                        hr_designation DES ON DES.desig_code = E.emp_desig_code
                            WHERE
                        E.emp_disable = 0 AND 
                        E.emp_name LIKE '%".$data['search']."%'" ;
            $sql_res = $hr_db->query($sql)->result();
            $hr_db->close();*/
            $qry_array[] = "SELECT
                                 'ARUN CH' AS `Name`,
                                 'SYSTEMS DEPT' AS `Location`,
                                 'Staff' AS `Member Type`";
            $qry_array[] = "SELECT
                                 'ANOOP R NAIR' AS `Name`,
                                 'SYSTEMS DEPT' AS `Location`,
                                 'Staff' AS `Member Type`";
            $qry_array[] = "SELECT
                                 'PRAVEEN SL' AS `Name`,
                                 'SYSTEMS DEPT' AS `Location`,
                                 'Staff' AS `Member Type`";
        }
        $qry = implode(' UNION ', $qry_array);
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetPromoters($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    promoter_name AS Name,
                    promoter_area AS Area,
                    promoter_phone AS Phone,
                    promoter_code AS `Code/hidden`
                FROM
                    pmd_promoter
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    promoter_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetACM($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    A.acm_name AS `Name`,
                    A.acm_phone AS `Phone`,
                    R.region_name AS `Region`,
                    A.acm_region AS `RegionCode/hidden`,
                    A.acm_code AS `Code/hidden`
                FROM
                    pmd_acm A
                JOIN
                    pmd_region R ON R.region_code = A.acm_region
                WHERE
                    A.cancel_flag = 0 ".$where_condition."
                ORDER BY
                    A.acm_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetBureau($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    bureau_name AS Name,
                    bureau_mobile AS Phone,
                    bureau_code AS `Code/hidden`
                FROM
                    pmd_bureau
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    bureau_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetUnion($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    union_name AS Name,
                    union_president AS President,
                    union_president_phone AS Phone,
                    union_code AS `Code/hidden`
                FROM
                    pmd_union
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    union_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetShakha($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                  
                    shakha_name AS Name,
                    shakha_president AS `Contact Person`,
                    shakha_president_phone AS Phone,
                    shakha_address1 AS Location,
                    shakha_code AS `Code/hidden`
                FROM
                    pmd_shakha
                WHERE
                   1=1 ".$where_condition." AND cancel_flag = 0 
                ORDER BY
                    shakha_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetEdition($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    edition_name AS Name,
                    edition_code AS `Code/hidden`
                FROM
                    pmd_edition
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    edition_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetRoute($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
	if($where_condition == '') $where_condition = " AND route_unit = '".$this->user->user_unit_code."' ";
	
        $qry = "SELECT                    
                    route_name AS Name,
                    route_vehicle_type AS Vehicle,
                    route_code AS `Code/hidden`
                FROM
                    pmd_route
                WHERE
                   route_unit = '".$this->user->user_unit_code."' ".$where_condition." AND cancel_flag = 0 
                ORDER BY
                    route_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetDroppingPoint($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    drop_name AS `Name`,
                    drop_code AS `Code/hidden`
                FROM
                    pmd_drop_point
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    drop_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetUnits($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] != '') {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT
                    unit_code AS Code,
                    unit_name AS Name
                FROM
                    pmd_unit
                WHERE
                    cancel_flag = 0 ".$where_condition."
                ORDER BY
                    unit_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetCopyTypes($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($criteria[0]['input'] && $criteria[0]['multiselect'] == 'true') {
                    $copy_group_codes = isset($criteria[0]['input']) ? array_column($criteria[0]['input'], 'Code') : array(); 
                    if($copy_group_codes) $where_condition.=" AND ".$item['column']." IN ('".implode("','",$copy_group_codes)."')";
                }
                else if(is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    $where_condition.=" AND ".$item['column']." IN ('".implode("','",$rec)."')";
                }
                else if($item['input'] != '') {
                    $where_condition.=" AND ".$item['column']." = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT                    
                    CT.copytype_name AS `Name`,
                    CT.copytype_code AS `Code/hidden`,
                    CT.group_code AS `Copy Group/hidden`,
                    CT.copy_code AS `Copy Code/hidden`,
                    rate_sch_years AS `Years/hidden`,
                    rate_sch_months AS `Months/hidden`,
                    rate_sch_days AS `Days/hidden`,
                    rate_amount AS `Amount/hidden`
                FROM
                    pmd_copytype CT
                    INNER JOIN 
                    pmd_ratecard RC ON CT.copytype_code = RC.rate_copy_type
                WHERE
                    1=1 ".$where_condition." AND CT.cancel_flag = 0
                ORDER BY
                    copytype_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetCopyTypesAll($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['column'] == 'avoid_entekaumudi') {
                    $where_condition.=" AND CG.group_code != 'CPG0000006'"; //avoid EnteKaumudi for sponsor 
                }
                else {
                    if($criteria[0]['input'] && $criteria[0]['multiselect'] == 'true') {
                        $copy_group_codes = isset($criteria[0]['input']) ? array_column($criteria[0]['input'], 'Code') : array(); 
                        if($copy_group_codes) $where_condition.=" AND ".$item['column']." IN ('".implode("','",$copy_group_codes)."')";
                    }
                    else if(is_array($item['input'])) {
                        $rec = array_column($item['input'], 'Code');
                        $where_condition.=" AND ".$item['column']." IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input'] != '') {
                        $where_condition.=" AND ".$item['column']." = '".$item['input']."'";
                    }
                }
            }
        }
        if($data['search']) $where_condition .= " AND (copytype_code LIKE '%".$data['search']."%' OR copytype_name LIKE '%".$data['search']."%')";
        $qry = "SELECT                    
                    CT.copytype_name AS `Name`,
                    CG.group_name AS `Group`,
                    CM.copy_name AS `Copy`,
                    CT.copytype_code AS `Code/hidden`,
                    CT.group_code AS `Copy Group/hidden`,
                    rate_sch_years AS `Years/hidden`,
                    rate_sch_months AS `Months/hidden`,
                    rate_sch_days AS `Days/hidden`,
                    rate_amount AS `Amount/hidden`,
                    CM.copy_code AS `Copy Code/hidden`
                FROM
                    pmd_copytype CT
                    INNER JOIN
                    pmd_copygroup CG ON CT.group_code=CG.group_code
                    INNER JOIN
                    pmd_copymaster CM ON CG.group_copy_code=CM.copy_code
                    LEFT JOIN 
                    pmd_ratecard RC ON CT.copytype_code = RC.rate_copy_type
                WHERE
                    1=1 ".$where_condition." AND CT.cancel_flag = 0
                ORDER BY
                    copytype_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetCopyGroup($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['column']=='group_copy_code'){
                    if($item['input'] != '') {
                        if($item['input'] && $item['multiselect'] == 'true') {
                            $copy_group_codes = isset($item['input']) ? array_column($item['input'], 'Code') : array();
                            if($copy_group_codes) $where_condition.=" AND ".$item['column']." IN ('".implode("','",$copy_group_codes)."')";
                        }
                        else if(is_array($item['input']))
                        {
                            $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$item['input'])."')";
                        }else{
                            $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                        }
                    }
                }
            }
        }
        if($data['search']) $where_condition .= " AND (group_code LIKE '%".$data['search']."%' OR group_name LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    group_name AS Name,
                    copy_name AS Type,
                    group_code AS Code
                FROM
                    pmd_copygroup CG
                INNER JOIN
                    pmd_copymaster CP ON CP.copy_code=CG.group_copy_code
                WHERE
                    CP.cancel_flag = 0 AND CG.cancel_flag=0 ".$where_condition."
                ORDER BY
                    copy_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetMonths()
	{
        $months = array(array("Month"=>"January"),
            array("Month"=>"February"),
            array("Month"=>"March"),
            array("Month"=>"April"),
            array("Month"=>"May"),
            array("Month"=>"June"),
            array("Month"=>"July"),
            array("Month"=>"August"),
            array("Month"=>"September"),
            array("Month"=>"October"),
            array("Month"=>"November"),
            array("Month"=>"December"));
        echo json_encode($months);
    }
    public function GetAgentMaster($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        if($where_condition == '') $where_condition .= " AND agent_unit = '".$this->user->user_unit_code."' ";
        if($data['search'])  $where_condition .= " AND (agent_code LIKE '%".$data['search']."%' OR agent_name LIKE '%".$data['search']."%' OR agent_location LIKE '%".$data['search']."%')";
        
        $qry = "SELECT
                    A.agent_code AS `Code`,
                    A.agent_name AS `Name`,
                    A.agent_location AS `Location`,
                    A.agent_phone AS `Phone No`,
                    A.agent_address AS `Address`,
                    P.promoter_name AS `Promoter Name`,
                    A.agent_slno AS `SerialNumber/hidden`,
                    P.promoter_code AS `PromoterCode/hidden`
                FROM
                    pmd_agent A
                    JOIN
                    pmd_promoter P ON P.promoter_code = (SELECT agent_promoter FROM pmd_agentdetails WHERE agent_code = A.agent_code AND agent_slno = A.agent_slno AND agent_product_code = '".$this->user->user_product_code."' AND agent_status = 0 LIMIT 1)
                WHERE
                   1=1 ".$where_condition." AND A.cancel_flag=0 ";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetProducts($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] != '') {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        if($data['search'])  $where_condition .= " AND (product_code LIKE '%".$data['search']."%' OR product_name LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    product_code AS Code,
                    product_name AS Name
                FROM
                    pmd_products
                WHERE
                    cancel_flag = 0 AND  product_code!='FSH' ".$where_condition."
                ORDER BY
                    product_priority";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetBillingPeriod($data)
	{
        $qry = "SELECT
                    entry_period AS `Bill Period`
                FROM
                    pmd_finalize
                WHERE
                    cancel_flag = 0 AND 
                    unit_code = '". $_SESSION['CIRSTAYLOGIN']['user_unit_code'] ."' AND
                    product_code = '". $_SESSION['CIRSTAYLOGIN']['user_product_code'] ."' AND entry_type = '".FinalizeType::Bill."'
                ORDER BY
                    entry_date DESC";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetRegions($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] != '') {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }
        $qry = "SELECT
                    region_name AS Name,
		    region_code AS `Code/hidden`
                FROM
                    pmd_region
                WHERE
                    1=1 ".$where_condition." AND cancel_flag = 0";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetAgentGroups($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }

        if($where_condition == '') $where_condition.=" AND agent_group_unit = '".$this->user->user_unit_code."'";

        $qry = "SELECT
                    agent_group_name AS `Name`,
                    agent_group_code AS `Code/hidden`
                FROM
                    pmd_agentgroup
                WHERE
                    1 = 1 ".$where_condition."
                ORDER BY
                    agent_group_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetSubscribers($data)
	{
        $where_condition="";
        $unit_code = $this->user->user_unit_code;
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                    if($item['column'] == 'sub_unit_code') $unit_code = $item['input'];
                }
            }
        }
        
        if($data['search']) $where_condition .= " AND (sub_code LIKE '%".$data['search']."%' OR sub_name LIKE '%".$data['search']."%' OR sub_address LIKE '%".$data['search']."%' OR sub_agent_code LIKE '%".$data['search']."%' OR sub_agent_slno LIKE '%".$data['search']."%' OR sub_edition LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    S.sub_name AS `Name`,
                    S.sub_address AS `Address`,
                    A.agent_name AS `Agent Name`,
                    A.agent_location AS `Agent Location`,
                    E.edition_name AS `Edition`,
                    P.promoter_name AS `Promoter`,
                    S.sub_code AS `Code/hidden`,
                    A.agent_code `AgentCode/hidden`,
                    A.agent_slno `AgentSlNo/hidden`,
                    P.promoter_code AS `PromoterCode/hidden`,                    
                    S.sub_phone AS `Phone No`,
                    A.agent_phone AS `Agent Phone`
                FROM
                    pmd_subscriber S
                JOIN
                    pmd_edition E ON (E.edition_unit = '".$unit_code."' AND E.edition_code = S.sub_edition)
                JOIN
                    pmd_agent A ON (A.agent_unit = '".$unit_code."' AND A.agent_code = S.sub_agent_code)
                JOIN
                    pmd_promoter P ON P.promoter_code = (SELECT agent_promoter FROM pmd_agentdetails WHERE agent_unit = '".$unit_code."' AND agent_code = A.agent_code AND agent_slno = A.agent_slno AND agent_product_code = '".$this->user->user_product_code."' AND agent_status = 0 LIMIT 1)
                WHERE
                    1 = 1 ".$where_condition." AND S.cancel_flag=0
                ORDER BY
                    S.sub_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetFinalStatus($data)
    {
        $sql = "SELECT                    
                    status_name AS `Name`,
                    status_code AS `Code/hidden`
                FROM
                    pmd_crmstatus
                WHERE
                    status_cancel_flag = 0 AND status_code IN ('S00000027','S00000026','S00000024','S00000022','S00000023','S00000001','S00000005','S00000020','S00000009','S00000007','S00000019','S00000014','S00000011','S00000003','S00000004','S00000006','S00000021','S00000028') ORDER BY status_priority";
        $result_set = $this->db->query($sql);
        echo json_encode($result_set->result());
    }
    public function GetAmendmentType($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }

        $qry = "SELECT
                    type_name AS `Name`,
                    type_code AS `Code/hidden`
                FROM
                    pmd_amendtype
                WHERE
                    1 = 1 ".$where_condition."
                ORDER BY
                    type_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetResidenceAssociations($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }

        if($where_condition == '') $where_condition.=" AND res_unit = '".$this->user->user_unit_code."'";

        $qry = "SELECT
                    res_name AS `Name`,
                    res_location AS `Location`,
                    res_contact_person AS `Contact Person`,
                    res_phone AS `Phone`,
                    res_code AS `Code/hidden`
                FROM
                    pmd_res_association                
                WHERE
                    1=1 ".$where_condition." AND cancel_flag = 0
                ORDER BY
                    res_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetWellwishers($data)
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }

        if($where_condition == '') $where_condition.=" AND well_unit = '".$this->user->user_unit_code."'";

        $qry = "SELECT
                    well_name AS `Name`,
                    well_location AS `Location`,
                    well_phone AS `Phone`,
                    well_code AS `Code/hidden`
                FROM
                    pmd_wellwisher
                WHERE
                    1=1 ".$where_condition." AND cancel_flag = 0
                ORDER BY
                    well_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetResponseHead($data)
    {
        $where_condition=$dept="";
		$criteria=json_decode($data['criteria'],true);
		if($criteria)
		{
            foreach($criteria as $item)
            {
                if($item['column'])
                {
                    if($item['input'] == 'PMD' || $item['input'] == 'SMD' || $item['input'] == 'EDT') {
                        if($item['input']=='PMD') { $dept=0; } else if($item['input']=='SMD') { $dept=1;} else if($item['input']=='EDT') { $dept=2; }
                        $where_condition.=" AND (`".$item['column']."` = '".$dept."' OR  `".$item['column']."` = 3) ";
                    }
                    else if($criteria[1]['input'] == 'PMD' && $criteria[0]['input'] != '2') {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']."' ";
                    }
                    else if($criteria[1]['input'] == 'PMD' && $criteria[0]['input'] == '2') {
                        $where_condition.=" AND `res_ag_flag` IN ('0','3') ";
                    }
                }
            }
		}
        $sql = "SELECT
                     res_code as Code,
                     res_desc AS Name
                 FROM
                     pmd_crmresponse WHERE 1=1 AND (`res_code` LIKE '%".$data['search']."%'
                        OR `res_desc` LIKE '%".$data['search']."%')".$where_condition ." AND res_cancel_flag = 0 ORDER BY res_priority,res_desc";
        $result_set = $this->db->query($sql);
        echo json_encode($result_set->result());
    }
    public function GetEntryStatus($data)
    {
        $where_condition=$dept=$status="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            if($criteria[0]['input']=='Incoming') { $status=0; } else if($criteria[0]['input']=='Outgoing') { $status=0;} else if($criteria[0]['input']=='Action') { $status=1;}
            $where_condition.=" AND (`".$criteria[0]['column']."` = '".$status."') ";

            if($criteria[0]['input'] != 'Action') {
                if($criteria[1]['input']=='PMD') { $dept=0; } else if($criteria[1]['input']=='SMD') { $dept=1;} else if($criteria[1]['input']=='EDT') { $dept=2; }
                $where_condition.=" AND (`".$criteria[1]['column']."` = '".$dept."' OR  `".$criteria[1]['column']."` = 3) ";
            }
            if($this->user->user_crm_admin == 2) {
                $where_condition .= " AND status_admin_flag = 2";
            }
        }

        $sql = "SELECT
                     status_code as Code,
                     status_name AS Name
                 FROM
                     pmd_crmstatus WHERE 1=1 $where_condition AND  (`status_code` LIKE '%".$data['search']."%'
                        OR `status_name` LIKE '%".$data['search']."%') AND status_cancel_flag = 0 ORDER BY status_priority";
        $result_set = $this->db->query($sql);
        echo json_encode($result_set->result());
    }
    public function GetEvents($data)
    {        
        $sql = $this->db->query("SELECT                                     
                                    `event_name` AS `Name`,
                                    DATE_FORMAT(event_start_date, '%d-%b-%Y') AS `Start Date`,
                                    DATE_FORMAT(event_end_date, '%d-%b-%Y') AS `End Date`,
                                    `event_code` AS `Code/hidden`
                                FROM 
                                    `pmd_events`
                                WHERE
                                    `cancel_flag` = 0 ORDER BY event_start_date DESC");
		echo json_encode($sql->result());
    }
    public function GetAmendmentReason($data)
    {
        $sql = $this->db->query("SELECT reason_name AS `Name`, reason_id  AS `Code/hidden` FROM pmd_amend_reason WHERE cancel_flag = 0 ORDER BY reason_name");
		echo json_encode($sql->result());
    }
    public function department($data) {
        echo json_encode(array(0 => array("Code/hidden"=>"0","Name"=>"PMD"),1 => array("Code/hidden"=>"1","Name"=>"SMD"),2 => array("Code/hidden"=>"2","Name"=>"EDT")));
    }
    public function entryType($data) {
        echo json_encode(array(0 => array("Code/hidden"=>"0","Name"=>"INCOMING"),1 => array("Code/hidden"=>"1","Name"=>"OUTGOING"),2 => array("Code/hidden"=>"2","Name"=>"ACTION")));
    }
    public function GetPacketsDiary($data){
        $where_condition="";
        if($data['search'])  $where_condition .= " AND (reason_id LIKE '%".$data['search']."%' OR reason_desc LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    
                    reason_desc AS `Reason`,
                    reason_id AS `Code/hidden`
                FROM
                    pmd_packer_reason";
                
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetAccountHead($data){
        $where_condition="";
        if($data['search']) $where_condition .= " AND (ac_code LIKE '%".$data['search']."%' OR ac_name LIKE '%".$data['search']."%' OR ac_debit_credit LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    ac_name AS `Name`,
                    IF(ac_debit_credit = ".AccountHeads::Credit.", 'CREDIT','DEBIT') AS `Debit/Credit`,
                    ac_code AS `Code/hidden`
                FROM
                    pmd_accountheads
                WHERE
                  1=1  ".$where_condition." AND `cancel_flag` = 0";

        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetSponsorClients($data) 
	{
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if($item['input'] && $item['column'] && is_array($item['input'])) {
                    $rec = array_column($item['input'], 'Code');
                    if(count($rec)) {
                        $where_condition.=" AND `".$item['column']."` IN ('".implode("','",$rec)."')";
                    }
                    else if($item['input']['Code']) {
                        $where_condition.=" AND `".$item['column']."` = '".$item['input']['Code']."'";
                    }
                }
                else if($item['input'] && $item['column']) {
                    $where_condition.=" AND `".$item['column']."` = '".$item['input']."'";
                }
            }
        }

        $qry = "SELECT
                    client_name AS `Name`,
                    client_address AS `Address`,
                    client_phone AS `Phone`,
                    client_code AS `Code/hidden`
                FROM
                    pmd_spons_client
                WHERE
                    unit_code = '".$this->user->user_unit_code."' AND cancel_flag = 0 ".$where_condition."
                ORDER BY
                    client_name";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetSchemeSubscribers($data)
	{
        $copy_name = $copy_group = null;
        $qry=$where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                if(isset($item['condition']) && $item['condition']=='true'){
                    $copt_type_rec = json_decode(rawurldecode($item['input']), true);
                    $copy_name = $copt_type_rec["Copy"];
                    $copy_group = $copt_type_rec["Group"];
                }else{
                    if($item['input'] && $item['column'] && is_array($item['input'])) {
                        $rec = array_column($item['input'], 'Code');
                        if(count($rec)) {
                            $where_condition.=" AND ".$item['column']." IN ('".implode("','",$rec)."')";
                        }
                        else if($item['input']['Code']) {
                            $where_condition.=" AND ".$item['column']." = '".$item['input']['Code']."'";
                        }
                    }
                    else if($item['input'] && $item['column']) {
                        $where_condition.=" AND ".$item['column']." = '".$item['input']."'";
                    }
                }
            }
        }
        if($copy_name=='SCHEME'){
            $qry = "SELECT
                    SCH.sch_slno AS `Serial No`,
                    CT.copytype_name AS `Type`,
                    S.sub_name AS `Name`,
                    S.sub_address AS `Address`,
                    SCH.sch_amount AS `Amount`,
                    SCH.sch_balance AS `Pending Amount`,
                    S.sub_code AS `Subscriber Code/hidden`,
                    S.sub_agent_code AS `Agent Code/hidden`,
                    S.sub_agent_slno AS `Agent Slno/hidden`
                FROM
                    pmd_scheme SCH
                    INNER JOIN 
                    pmd_subscriber S ON S.sub_unit_code='".$this->user->user_unit_code."' AND SCH.sch_balance>0 AND  SCH.sch_sub_code = S.sub_code AND S.cancel_flag=0
                    INNER JOIN 
                    pmd_copytype CT ON SCH.sch_copy_type = CT.copytype_code AND CT.cancel_flag = 0
                WHERE
                    SCH.unit_code='".$this->user->user_unit_code."' AND SCH.sch_balance>0 ".$where_condition." AND SCH.cancel_flag = 0
                ORDER BY
                    SCH.sch_from_date DESC";
        }else if($copy_name=='SPONSOR'){
            if($copy_group == 'SPONSOR'){
                $qry = "SELECT
                    SP.spons_code AS `Serial No`,
                    CT.copytype_name AS `Type`,
                    SC.client_name AS `Name`,
                    SC.client_address AS `Address`,
                    SP.spons_deal_amt AS `Amount`,
                    SP.spons_balance AS `Pending Amount`,
                    SP.spons_client_code AS `Subscriber Code/hidden`,
                    SP.spons_agent_code AS `Agent Code/hidden`,
                    SP.spons_agent_slno AS `Agent Slno/hidden`
                FROM
                    pmd_sponsor SP
                    INNER JOIN 
                    pmd_spons_client SC ON SC.unit_code='".$this->user->user_unit_code."' AND SP.spons_balance>0 AND  SP.spons_client_code = SC.client_code AND SC.cancel_flag=0
                    INNER JOIN 
                    pmd_copytype CT ON SP.spons_copy_type = CT.copytype_code AND CT.cancel_flag = 0
                WHERE
                    SP.unit_code='".$this->user->user_unit_code."' AND SP.spons_balance>0 ".$where_condition." AND SP.cancel_flag = 0
                ORDER BY
                    SP.created_date DESC";
            }elseif($copy_group == 'ENTE KAUMUDI'){
                $qry = "SELECT
                    EK.ek_slno AS `Serial No`,
                    CT.copytype_name AS `Type`,
                    SC.client_name AS `Name`,
                    SC.client_address AS `Address`,
                    EK.ek_deal_amt AS `Amount`,
                    EK.ek_balance AS `Pending Amount`,
                    EK.ek_client_code AS `Subscriber Code/hidden`,
                    '' AS `Agent Code/hidden`,
                    '' AS `Agent Slno/hidden`
                FROM
                    pmd_ek EK
                    INNER JOIN 
                    pmd_spons_client SC ON SC.unit_code='".$this->user->user_unit_code."' AND EK.ek_balance>0 AND EK.ek_client_code = SC.client_code AND SC.cancel_flag=0
                    INNER JOIN 
                    pmd_copytype CT ON EK.ek_copy_type = CT.copytype_code AND CT.cancel_flag = 0
                WHERE
                    EK.unit_code='".$this->user->user_unit_code."' AND EK.ek_balance>0 ".$where_condition."
                ORDER BY
                    EK.created_date DESC";
            }
        }
        $res = $qry? $this->db->query($qry)->result():array();
        echo json_encode($res);
    }
    public function GetBanks($data)
	{
        $qry = "SELECT
                    bank_name AS `Name`,
                    bank_location AS `Address`,
                    bank_code AS `Code/hidden`
                FROM
                    pmd_bankmaster
                WHERE
                    (`bank_name` LIKE '%".$data['search']."%' OR `bank_location` LIKE '%".$data['search']."%')
                ORDER BY bank_name , bank_location";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
    public function GetTempReceipts($data)
	{
        $where_condition="";
        //$criteria=json_decode($data['criteria'],true);
        //if($criteria)
        //{
        //    foreach($criteria as $item) {
        //        if($item['input'] && $item['column'] && is_array($item['input'])) {
        //            $rec = array_column($item['input'], 'Code');
        //            if(count($rec)) {
        //                $where_condition.=" AND ".$item['column']." IN ('".implode("','",$rec)."')";
        //            }
        //            else if($item['input']['Code']) {
        //                $where_condition.=" AND ".$item['column']." = '".$item['input']['Code']."'";
        //            }
        //        }
        //        else if($item['input'] && $item['column']) {
        //            $where_condition.=" AND ".$item['column']." = '".$item['input']."'";
        //        }
        //    }
        //}
        //$qry = "SELECT
        //            RCPT0005 AS RECEIPT";
        //$res = $this->db->query($qry)->result();
        //echo json_encode($res);
        $months = array(
            array("Code"=>"100001"),
            array("Code"=>"100002"),
            array("Code"=>"100003"),
            array("Code"=>"100004"),
            array("Code"=>"100005"),
            array("Code"=>"100006"),
            array("Code"=>"100007"));
        echo json_encode($months);
    }
    public function GetSchemes($data)
    {
        $subscriber_code = $unit_code = '';
		$criteria=json_decode($data['criteria'],true);
		if($criteria)
		{
			foreach($criteria as $item)
			{
                if($item['column']=='scheme')
                {
                    $subscriber_code = $item['input'];
                }
				else if($item['column']=='unit_code')
				{
                    $unit_code = $item['input'];
				}
			}
		}
        //if($data['search']) {
        //    $where_sch_det = " AND (sch_slno LIKE '%".$data['search']."%' OR sch_name LIKE '%".$data['search']."%')";
        //}
        //$secdb = $this->load->database('secdb', TRUE);
        $sql = "SELECT
                    CT.copytype_code `Code`,
                    CT.copytype_name `Name`,
                    'Scheme' `Type`,
                    '1' AS `sch_type/hidden`,
                    SCH.sch_can_name AS `fs_name/hidden`,
                    SCH.sch_slno AS `SchemeSlNo`,
                    SCH.sch_to_date AS `SchemeEndDate/hidden`
                FROM
                    pmd_scheme SCH
                        INNER JOIN
                    pmd_copytype CT ON SCH.sch_copy_type = CT.copytype_code AND SCH.sch_renew_code=''
                WHERE
                    SCH.unit_code = '".$unit_code."' AND sch_sub_code = '".$subscriber_code."' AND SCH.sch_renew_code='' AND (sch_slno LIKE '%".$data['search']."%' OR CT.copytype_name LIKE '%".$data['search']."%')
                UNION SELECT
                    free_slno AS `Code`,
                    'Free' AS `Name`,
                    'Free' AS `Type`,
                    '2' AS `sch_type/hidden`,
                    NULL AS `fs_name/hidden`,
                    free_slno AS `SchemeSlNo`,
                    NULL AS `SchemeEndDate/hidden`
                FROM
                    pmd_free
                WHERE
                    unit_code = '".$unit_code."'
                    AND  free_sub_code = '".$subscriber_code."'
                UNION SELECT
                    SA.sales_code AS `Code`,
                    CT.copytype_name AS `Name`,
                    CT.copytype_name AS `Type`,
                    '3' AS `sch_type/hidden`,
                    sales_can_name as `fs_name/hidden`,
                    sales_code AS `SchemeSlNo`,
                    NULL AS `SchemeEndDate/hidden`
                FROM
                    pmd_sales SA
                    INNER JOIN
                    pmd_copytype CT ON SA.sales_copy_type = CT.copytype_code
                WHERE
                    SA.unit_code = '".$unit_code."' AND SA.sales_sub_code = '".$subscriber_code."'
                UNION SELECT
                    EK.ek_slno AS `Code`,
                    SPC.client_name AS `Name`,
                    'Entekaumudi' AS `Type`,
                    '4' AS `sch_type/hidden`,
                    EK.ek_can_name AS `fs_name/hidden`,
                    EK.ek_slno AS `SchemeSlNo`,
                    NULL AS `SchemeEndDate/hidden`
                FROM
                    pmd_ek EK  
                        INNER JOIN
                    pmd_spons_client SPC on EK.unit_code='".$unit_code."' AND EK.unit_code = SPC.unit_code AND EK.ek_client_code = SPC.client_code
                        INNER JOIN
                    pmd_ek_trans EKT ON EKT.unit_code= '".$unit_code."' AND EK.ek_slno = EKT.ek_slno
                WHERE
                   EK.unit_code = '".$unit_code."' AND EKT.ek_sub_code = '".$subscriber_code."'
                UNION SELECT
                    SP.spons_code AS `Code`,
                    SPC.client_name AS `Name`,
                    'Sponsor' AS `Type`,
                    '5' AS `sch_type/hidden`,
                    SP.spons_can_name AS `fs_name/hidden`,
                    SP.spons_code AS `SchemeSlNo`,
                    NULL AS `SchemeEndDate/hidden`
                FROM
                    pmd_sponsor SP
                    INNER JOIN
                    pmd_spons_client SPC ON SP.unit_code = '".$unit_code."' AND SPC.client_code = SP.spons_client_code
                WHERE
                        SP.spons_client_code='".$subscriber_code."' AND SP.unit_code = '".$unit_code."'";
        $result_set = $this->db->query($sql);
        echo json_encode($result_set->result());
    }
    public function GetCopyMaster($data){
        $where_condition="";
        $criteria=json_decode($data['criteria'],true);
        if($criteria)
        {
            foreach($criteria as $item) {
                 if(is_array($item['input'])) {
                    $where_condition.=" AND ".$item['column']." IN ('".implode("','",$item['input'])."')";
                }
                else if($item['input'] != '') {
                    $where_condition.=" AND ".$item['column']." = '".$item['input']."'";
                }
            }
        }
        if($data['search']) $where_condition .= " AND (copy_code LIKE '%".$data['search']."%' OR copy_name LIKE '%".$data['search']."%')";
        $qry = "SELECT
                    copy_name AS `Name`,
                    copy_code AS `Code/hidden`
                FROM
                    pmd_copymaster
                WHERE
                    cancel_flag = 0 ".$where_condition."";
        $res = $this->db->query($qry)->result();
        echo json_encode($res);
    }
}
