<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthController extends CI_Controller {
    public $Message = null;
	public function __construct() {
		parent::__construct();

        $this->load->helper('form');
        $this->load->model('AuthModel');
        $this->load->library('form_validation');
        $this->load->library('App/Message');
        $this->load->library('App/DBDriver');
        $this->Message = new Message();
        $this->DBDriver = new DBDriver();

	}
	public function index()
    {

    }
    public function CompanyName(){
        $this->data["comp_rec"]=array();
        $this->data['comp_rec'] = $this->AuthModel->NationamCompanyRecord();
        if(isset($_GET['g_fe'])){
            $this->data['comp_name_rec'] = $this->AuthModel->NationamCompanyDetails();
        }

        $this->load->view('stock_exchange_form',$this->data);
    }



}