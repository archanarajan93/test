<?php
class AuthModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    

    public function NationamCompanyRecord()
	{
        $where = "";
        $comp_name_id = $this->input->post('comId');
        if($comp_name_id){
            $where .= " AND comp_slno='".$comp_name_id."' ";
        }

		$qry = "SELECT
                    comp_slno,
                    comp_name,
                    current_market_price,
                    market_cap,
                    stock,
                    divident_yield,
                    roce_perc,
                    roce_previous_ann,
                    debt_to_equity,
                    eps,
                    reservs,
                    debt
                FROM
                    employees.national_stock_company
                WHERE
                1=1 ";
        return $this->db->query($qry)->result();

    }
	public function NationamCompanyDetails(){

        $where = "";
        $comp_name_id = $this->input->post('searchInput');
        if($comp_name_id){
            $where .= " AND comp_slno='".$comp_name_id."' ";
        }

		$qry = "SELECT
                    comp_slno,
                    comp_name,
                    current_market_price,
                    market_cap,
                    stock,
                    divident_yield,
                    roce_perc,
                    roce_previous_ann,
                    debt_to_equity,
                    eps,
                    reservs,
                    debt
                FROM
                    employees.national_stock_company
                WHERE
                1=1 ".$where." ";
        return $this->db->query($qry)->result();
    }


}