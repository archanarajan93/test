<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class AdminTools extends BaseController { 

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model("AdminToolsModel");
	}
    public function index() {       
	}

    //User Master
    public function User()
    {
        $this->data["unit_list"]=$this->AdminToolsModel->UnitsLists();
        $this->data["product_list"]=$this->AdminToolsModel->ProductLists();
        $this->data["listmenu_records"]=$this->AdminToolsModel->MenuList();
        $this->data["submenu_records"]=$this->AdminToolsModel->SubMenuList();        
        $this->load->view('user-master', $this->data);
    } 
    public function CreateUser()
    {
        $response = $this->AdminToolsModel->CreateUserMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/AdminTools/User', 'refresh');
    }
    public function LoginNameAvailable()
    {
        echo json_encode($this->AdminToolsModel->CheckLoginNameAvailable()); 
    }
    public function SearchUser()
    {
        if(isset($_POST['Add'])) {
            $this->data["search_list"]=$this->AdminToolsModel->SearchUsers();
        }
        $this->data["unit_list"]=$this->AdminToolsModel->UnitsLists();
        $this->data["product_list"]=$this->AdminToolsModel->ProductLists();
        $this->load->view('user-search', $this->data);
    } 
    public function ShowUserDetails()
    {
        $this->data["user"]=$this->AdminToolsModel->UserDetails();
        $this->data["unit_list"]=$this->AdminToolsModel->UnitsLists();
        $this->data["product_list"]=$this->AdminToolsModel->ProductLists();
        $this->data["unit_access"]=$this->AdminToolsModel->UserUnits();
        $this->data["prod_access"]=$this->AdminToolsModel->UserProducts();
        $this->data["listmenu_records"]=$this->AdminToolsModel->MenuList();
        $this->data["submenu_records"]=$this->AdminToolsModel->SubMenuList();
        $this->data["user_menus"]=$this->AdminToolsModel->UserMenu();
        echo $this->load->view('templates/user-details', $this->data);
    }
    public function UpdateUser() {
        echo json_encode($this->AdminToolsModel->UpdateUser());
    }  

    //Copy Group Master
    public function CopyGroups()
    {
        $this->data["grpcpy_code"] = $this->AdminToolsModel->GetCopyCode();
        $this->data["cpygrp_code"] = $this->AdminToolsModel->ViewPrimaryId('CPYGRP_CODE');
        $this->data["copies"]=$this->AdminToolsModel->CopyLists();
        $this->data["copy_groups"]=$this->AdminToolsModel->GetCopyGroups();
        $this->load->view('copy-group-master', $this->data);
    }
    public function CreateCopyGroups()
    {
        $response=$this->AdminToolsModel->CreateCopyGroups();        
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/AdminTools/CopyGroups', 'refresh'); 
    }
    public function UpdateCopyGroups()
    {          
        //$product_codes = explode(",",$this->input->post('group_prdts'));
        echo json_encode($this->AdminToolsModel->UpdateCopyGroups());
    }
    public function DeleteCopyGroup()
    { 
        echo json_encode($this->AdminToolsModel->DeleteCopyGroup()); 
    }
    public function ViewCopyGroup(){
        $this->data["grpcpy_code"] = $this->AdminToolsModel->GetCopyCode();
        $this->data["grp_cpy"]=$this->AdminToolsModel->ViewCopyGroup();
        echo $this->load->view('templates/copy-group-details', $this->data);
    }

    //Copy Master
    public function CopyMaster()
    {
        $this->data["copy_lists"]=$this->AdminToolsModel->CopyLists(); 
        $this->load->view('copy-master', $this->data);
    }
    public function CreateCopyMaster()
    {
        $response=$this->AdminToolsModel->CreateCopyMaster(); 
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/AdminTools/CopyMaster', 'refresh');
    }
    public function UpdateCopyMaster()
    {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data=array("copy_code"=>$this->input->post('copy_code'),
                    "copy_name"=>strtoupper($this->input->post('copy_name')),
                    "cancel_flag"=>0,
                    "modified_by"=>$modified_by,
                    "modified_date"=>$modifiedDate
                    );
        echo $this->AdminToolsModel->UpdateCopyMaster($data); 
    } 
    public function DeleteCopyMaster()
    {
        $data=array('copy_code'=>$this->input->post('copy_code'),
                    'cancel_flag'=>1,
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->AdminToolsModel->DeleteCopyMaster($data); 
    }

    //Unit Master
    public function Units()
	{
        $this->data['unit_lists'] = $this->AdminToolsModel->UnitsLists();
		$this->load->view('unit-master', $this->data);
	}
    public function CreateUnit()
	{
        $response=$this->AdminToolsModel->CreateUnitMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/AdminTools/Units', 'refresh');
	}
    public function UpdateUnit() {

        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data = array(
            'unit_code' => strtoupper($this->input->post('unit_code')),
            'unit_name' => strtoupper($this->input->post('unit_name')),
            'modified_by' => $modified_by,
            'modified_date' => $modifiedDate
            );
		echo $this->AdminToolsModel->UpdateUnitMaster($data);
	}
    public function DeleteUnit() {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data=array('unit_code'=>$this->input->post('unit_code'),
                    'cancel_flag' =>'1',
                    'modified_by' => $modified_by,
                    'modified_date' => $modifiedDate);
        echo $this->AdminToolsModel->DeleteUnitMaster($data);

	}
    public function UpdateUnitPriority()
    {
        echo $this->AdminToolsModel->UpdateUnitMasterPriority();
    }
    //Rate Master
    public function RateMaster()
    {
        $this->data["sales_rates"] = array();
        $response = $this->AdminToolsModel->GetRateCard();
        $sales_res = $response["sales"];
        foreach($sales_res as $sales){
            $this->data["sales_rates"][$sales->rate_flag] = $sales;
        }
        $this->data["schemes_rates"] = $response["schemes"];
        $this->data["copy_groups"] = $this->AdminToolsModel->CopyGroupsLists(array('CP0003'));
        $this->data["other_products"] = $this->AdminToolsModel->OtherProductsLists();
        $other_rates = $this->AdminToolsModel->GetOtherProductsRate();
        foreach($other_rates as $rate){
            $this->data["other_prdt_rates"][$rate->rate_pdt_code] = $rate;
        }
        $this->load->view('ratecard-master', $this->data);
    }
    public function SaveSalesCopyRate(){
        echo json_encode($this->AdminToolsModel->SaveSalesCopyRate());
    }
    public function SaveSchemeCopyRate(){
        $response = $this->AdminToolsModel->SaveSchemeCopyRate();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/AdminTools/RateMaster', 'refresh');
    }
    public function EditSchemeCopyRate() {
        $this->data["sch_copy_rate"]=$this->AdminToolsModel->GetSchemeCopyRate();
        echo $this->load->view('templates/ratemaster-scheme-edit-details', $this->data);
    }
    public function UpdateSchemeCopyRate(){
        echo json_encode($this->AdminToolsModel->UpdateSchemeCopyRate());
    }
    public function SaveOtherPrdtsRate(){
        echo json_encode($this->AdminToolsModel->SaveOtherPrdtsRate());
    }
}
?>