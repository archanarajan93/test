<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class DCR extends BaseController { 

	public function __construct() {
		parent::__construct();
		$this->load->model("DCRModel");
        //$this->encryption_key = $this->config->item('encryption_key');
	}

    public function index() {        
        $this->load->view('dcr', $this->data);
	}

    //public function CategoryMaster() {
    //    $this->data['category_records']= $this->AwardsModel->GetCategory(); 
    //    $this->load->view('award-category-master', $this->data);
    //}

    //public function CategoryAdd() {
    //    $data=array("cat_name"=>strtoupper($this->input->post('award_category',true)));
    //    $response=$this->AwardsModel->SetCategoryAdd($data);
    //    $this->session->set_flashdata('flash_message', json_encode($response));
    //    redirect('/Awards/CategoryMaster?g_fe=YXdhcmRjYXQ=', 'refresh');
    //
    //}  
}
?>