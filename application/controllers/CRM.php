<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class CRM extends BaseController { 

	public function __construct()
	{
		parent::__construct();
        //$this->load->helper('form');
        //$this->load->library('form_validation');
		$this->load->model("CRMModel");
	}
    public function index() {       
	}
   //Create
   public function Create(){
        $this->data["token_no"]  = $this->CRMModel->viewPrimaryId("TOKEN_".$this->user->user_unit_code."_CODE");
        $this->data["user_name"] = $this->user->user_name;
        $this->data["user_unit"] = array("UNIT" => $this->user->user_unit_code);
        $this->data["is_admin"]  = $this->user->user_crm_admin;
        $this->data["user_id"]   = $this->user->user_id;
        $this->load->view('CRM/crm-create',$this->data);
    }
   public function CreateCRM(){
           $data = array();
           $data["unit_rec"] = $this->input->post('unit_rec_sel',true);
           $data["product_rec"] = $this->input->post('product_rec_sel',true);
           $data["customer"] = $this->input->post('customer');
           if($data["customer"]=='Subscriber'){
               $data["customer_rec"] = $this->input->post('subscriber_rec_sel',true);
           }else if($data["customer"]=='Agent'){
               $data["customer_rec"] = $this->input->post('agent_rec_sel',true);
           }else{
               $data["customer_rec"] = $this->input->post('gen_name',true);
           }

           if(empty($data["unit_rec"]) ||
              empty($data["product_rec"]) ||
              empty($data["customer_rec"]) ||
              (empty($this->input->post('cus_ag_code',true)) && $data["customer"]=='Subscriber')
             )
           {
               $this->Message->status=400;
               $this->Message->text=$this->lang->line('mandatory_fields_empty');
               $response = $this->Message;
           }else{
               $response = $this->CRMModel->SaveCRM($data);
           }
           $this->session->set_flashdata('flash_message', json_encode($response));
           redirect('/CRM/create', 'refresh');
   }
   public function Search()
   {
       $this->data["user_unit"] = array("UNIT" => $this->user->user_unit_code);
       if(isset($_POST['show_crm']))
       {
           $this->data["crm_data"] = $this->CRMModel->getCRMResults();
       }
       $this->load->view('CRM/crm-search',$this->data);
   }
   public function view($token_no)
   {
       $this->data["is_admin"] = $this->user->user_crm_admin;
       $this->data["current_user"] = $this->user->user_name;
       $this->data["crm_results"] = $this->CRMModel->GetCRMDetailed(base64_decode($token_no));
       $this->load->view('CRM/crm-view',$this->data);
   }
   public function edit($token_no)
   {
       $this->data["is_admin"] = $this->user->user_crm_admin;
       $this->data["user_id"]  = $this->user->user_id;
       if(isset($_POST['update_crm']))
       {
           $post_data = array();
           $post_data["token_no"] = base64_decode($token_no);
           $post_data["unit_rec"] = $this->input->post('unit_rec_sel',true);
           $post_data["product_rec"] = $this->input->post('product_rec_sel',true);
           $post_data["customer"] = $this->input->post('customer');
           if($post_data["customer"]=='Subscriber'){
               $post_data["customer_rec"] = $this->input->post('subscriber_rec_sel',true);
           }else if($post_data["customer"]=='Agent'){
               $post_data["customer_rec"] = $this->input->post('agent_rec_sel',true);
           }else{
               $post_data["customer_rec"] = $this->input->post('gen_name',true);
           }
           if(empty($post_data["customer_rec"]) || (empty($this->input->post('cus_ag_code',true)) && $post_data["customer"]=='Subscriber')) {
               $this->Message->status=400;
               $this->Message->text=$this->lang->line('mandatory_fields_empty');
               $response = $this->Message;
           }else{
               $response = $this->CRMModel->updateCRM($post_data);
           }
           $this->session->set_flashdata('flash_message', json_encode($response));
       }
       $this->data["current_user"] = $this->user->user_name;
       $this->data["crm_results"] = $this->CRMModel->GetCRMDetailed(base64_decode($token_no));
       $this->load->view('CRM/crm-edit',$this->data);
   }
   public function saveCRMStatus()
   {
       echo json_encode($this->CRMModel->saveCRMStatus());
   }
   public function updatestatus()
   {
       echo json_encode($this->CRMModel->updateCRMStatus());
   }

   //Approve
   public function Approve()
   {
       if(isset($_GET['g_fe'])) {
           $this->data["records"]=$this->CRMModel->EnrollLists();
       }
       else {
           $this->data["records"]=array();
       }
       $this->load->view('CRM/approve', $this->data);
   }
   public function EditApproval()
   {
       $this->data["code"] = $sales_code = base64_decode($_GET['g_fe']);
       $this->data["records"] = $this->CRMModel->ViewEnrollLists($sales_code);
       $this->data["comments"] = $this->CRMModel->ViewComments($sales_code);
       $this->load->view('CRM/approve-edit', $this->data);
   }
   public function AddComments()
   {
       echo json_encode($this->CRMModel->AddComments());
   }
   public function UpdateApprovalStatus()
   {
       echo json_encode($this->CRMModel->UpdateApprovalStatus());
   }   
}
?>