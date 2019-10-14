<?php
class DCRModel extends CI_Model 
{
	public function __construct() {
		parent::__construct();
	}
    public function GetPrimaryId($no_id) {
		$sql 	  = $this->db->query("SELECT no_value FROM newstrack_numbersetup WHERE no_id='$no_id' FOR UPDATE");
		$no_value = $sql->row()->no_value;
		return $no_value;
	}
    public function UpdatePrimaryId($no_value, $no_id, $is_incremented=false) {
		$new_string = $is_incremented ?  $no_value : $this->AutoIncrement($no_value);
		if(!empty($new_string))
		{
			$this->db->query("UPDATE newstrack_numbersetup SET no_value='$new_string' WHERE no_id='$no_id'");
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
}