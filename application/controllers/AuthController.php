<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AuthController extends CI_Controller { 
	public function __construct() {
		parent::__construct();  
        $this->load->helper('Enum');
        $this->load->model("AuthModel");
	}	
	public function index() 
    {            
        $this->load->view('user_login');
    }
    public function DoLogin()
	{
        $user_session = $this->session->userdata("CIRSTAYLOGIN");
        if($user_session && isset($user_session["user_name"])){ redirect("/Dashboard", 'refresh');}
        $response = $this->AuthModel->validateLoginCredentials();
		if($response)
		{        
            $data = array(
                        'user_id'  => $response->user_id,
                        'user_name' => $response->user_name,
                        'user_unit_code' => $response->user_unit,
                        'user_unit_name' => $response->unit_name,
                        'user_product_code' => null,
                        'user_product_name' => null,
                        'user_crm_admin'=>$response->user_crm_admin,
                        'user_kb_type'=> $response->user_kb_type,
                        'user_session_id' => session_id());                    
            $this->session->set_userdata("CIRSTAYLOGIN", $data);
            redirect('/Tools/ChangeProduct', 'refresh');
		}
		else
		{
            $this->session->sess_destroy();
            $this->session->set_flashdata('loginstatus', 'error');
            redirect('/', 'refresh');
		}
	}
	public function Logout($doRedirect=0)
	{           
        $this->session->unset_userdata('CIRSTAYLOGIN');
        $this->session->set_flashdata('loginstatus', 'logout_success');
        $this->session->sess_destroy();
        if($doRedirect=='1'){
            redirect('/');
        }else{
            echo json_encode(array("status"=>200));
        }
	}
}