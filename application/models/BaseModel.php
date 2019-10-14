<?php
class BaseModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
	}
    public function getMenuItems()
     {
         $sql 	  = $this->db->query("SELECT * FROM pmd_menu WHERE `menu_visible`=".MenuVisibility::Visible." ORDER BY menu_parent_id,menu_priority");
         return $sql->result();
     }
    public function getActiveYear()
    {
        return $this->db->query("SELECT  MAX(ye_year_flag) active_year FROM newstrack_yearend")->row()->active_year;
    }
    public function getPermissions($user_id, $unit_code, $product_code)
    {
        $response = array('%');//default all privileges
        $sql 	  = $this->db->query("SELECT 
                                        right_id
                                    FROM
                                        pmd_managerights
                                    WHERE
                                        right_user_id = '".$user_id."' OR right_user_unit_code = '".$unit_code."' OR right_user_product_code = '".$product_code."'");
        $res = $sql->result();
        $res_len = count($res);
        if(0 < $res_len)
        {
            $response = array();
            for($index=0; $index<$res_len; $index++){
                $response[] = $res[$index]->right_id;
            }
        }
        return $response;
    }
    public function getMenuItemsLoginUsers()
    {
        $query = "SELECT
                        t1.menu_id,t2.menu_name,t3.menu_parent_id,t3.menu_id `sub_menu_id`,t3.menu_name `sub_menu_name`, LOWER(t3.menu_link) menu_link
                  FROM
                        pmd_usermenu t1
                          INNER JOIN
                        pmd_menu t2 ON t2.menu_id=t1.menu_id
                          LEFT JOIN
                        pmd_menu t3 ON t3.menu_id=t1.sub_menu_id
                  WHERE
                        t1.user_id = '".$this->user->user_id."'";
        return $this->db->query($query)->result(); 
    } 
}
?>