<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class Settings extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->load->model("SettingsModel");		
	}
    public function index() {
	} 
    public function Product() {
        $this->data['products'] = $this->SettingsModel->UserProducts($this->user->user_id);
		$this->load->view('select-product', $this->data);
    }
    public function UpdateProduct() {
        $pdt = $this->input->post('user-product',true);
        if($pdt) {
            $data = $this->session->userdata("CIRSTAYLOGIN");
            $data['user_product_code'] = $pdt;
            $this->session->set_userdata("CIRSTAYLOGIN", $data);
            redirect('/Dashboard', 'refresh');
        }
        else {
            redirect('/Settings/Product?g_fe=aW52YWxpZA==', 'refresh');
        }
    }
}
?>