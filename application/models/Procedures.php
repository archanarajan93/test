<?php
class Procedures extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
        $this->createProcedures();
	}
    private function createProcedures()
	{//comment if procedure already exist
      //$this->sp_get_userdetails(); 
	}
    private function sp_get_userdetails()
	{
        $this->db->query("DROP PROCEDURE IF EXISTS `sp_get_userdetails`");
        $this->db->query("CREATE PROCEDURE `sp_get_userdetails`(user_id VARCHAR(20))
                          BEGIN
                            SELECT
                                 t1.user_id,
                                 t1.user_name,
                                 t1.user_login_name,
                                 t1.user_login_password,
                                 t1.user_unit_code,
                                 t1.user_product_code,
                                 t1.user_group_code,
                                 t1.user_place,
                                 t1.user_email,
                                 t1.user_mobile,
                                 t1.user_byline_flag,
                                 t1.user_remote,
                                 t1.user_disable,
                                 t1.user_gh_flag
                            FROM
                                pmd_userdetails t1
                                    INNER JOIN
                                newstrack_unit t2 ON t1.user_unit_code = t2.unit_code
                                    INNER JOIN
                                newstrack_products t3 ON t1.user_product_code = t3.product_code
                                    INNER JOIN
                                newstrack_groups t4 ON t1.user_group_code = t4.group_code
		                            INNER JOIN
                                newstrack_user_permission t5 ON (t1.user_id = t5.user_id AND t5.user_base = 1)
		                    WHERE
                              t1.user_id = user_id;
                            SELECT
                                    unit_code, unit_name
                            FROM
                                    newstrack_unit
                            WHERE
                                    unit_cancel_flag = 0 ORDER BY unit_priority;
                            SELECT
                                    product_code, product_name
                            FROM
                                    newstrack_products
                            WHERE
                                    cancel_flag = 0 ORDER BY product_priority; 
                            SELECT
                                    group_code, group_name
                            FROM
                                    newstrack_groups
                            WHERE
                                    group_cancel_flag = 0 ORDER BY group_priority;
                            SELECT
                                    t2.unit_name, t3.product_name, t4.group_name, t1.user_gh_flag, t1.user_base,t1.user_unit_code,t1.user_pdt_code,t1.user_group_code
                            FROM
                                    newstrack_user_permission t1
                                        INNER JOIN
                                    newstrack_unit t2 ON t1.user_unit_code = t2.unit_code
                                        INNER JOIN
                                    newstrack_products t3 ON t1.user_pdt_code = t3.product_code
                                        INNER JOIN
                                    newstrack_groups t4 ON t1.user_group_code = t4.group_code
                            WHERE t1.user_id = user_id ORDER BY user_base DESC,unit_priority ASC;
                            SELECT
                                   t1.menu_id,
                                   t1.sub_menu_id
                            FROM
                                  pmd_usermenu t1
                            WHERE
                                  t1.user_id = user_id;
                            END");
    }
}