<?php
class AuthModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
	}
    public function validateLoginCredentials()
	{
		$user_login_name = $this->input->post('user_login_name', true);
		$user_password   = $this->input->post('user_password', true);
        $sql = "SELECT 
                    U.user_id,
                    U.user_emp_name user_name,
                    user_unit,
                    UN.unit_name,
                    U.user_kb_type,
                    user_emp_dept,
                    user_emp_desig,
                    U.user_crm_admin
                FROM
                    pmd_userdetails U  
                    INNER JOIN 
                    pmd_unit UN ON UN.unit_code=U.user_unit
                WHERE
                    U.user_login_name = '".$user_login_name."'
                        AND U.user_login_password = binary '".$user_password."'
                        AND U.cancel_flag = ".UserStatus::Active;
        return $this->db->query($sql)->row();
	}
}