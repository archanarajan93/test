<?php
class SettingsModel extends CI_Model
{
	public function __construct() {
		parent::__construct();
	}
    public function UserProducts($user_id) {
        $qry = "SELECT
                    P.product_code,
                    P.product_name,
                    P.product_icon,
                    P.product_color
                FROM
                    pmd_productaccess A
                JOIN
                    pmd_products P ON P.product_code = A.product_code
                WHERE
                    A.user_id = ".$user_id."
                AND P.cancel_flag = 0
                ORDER BY P.product_priority";
        return $this->db->query($qry)->result();
    }
}