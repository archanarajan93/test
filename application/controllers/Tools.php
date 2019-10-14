<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class Tools extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->load->model("ToolsModel");		
	}

    public function index() {
	}

    public function ChangeProduct() {
        $label = isset($_GET['g_lb']) ? base64_decode($_GET['g_lb']) : null;
        $this->data['products'] = $this->ToolsModel->UserProducts($this->user->user_id,$label);
		$this->load->view('change-product', $this->data);
    }

    public function UpdateProduct() {
        $pdt = $this->input->post('product',true);
        if($pdt) {
            $data = $this->session->userdata("CIRSTAYLOGIN");
            $data['user_product_code'] = $pdt;
            $this->session->set_userdata("CIRSTAYLOGIN", $data);
            echo json_encode(array("status"=>200,"text"=>"Updated Successfully"));
        }
        else {
            echo json_encode(array("status"=>400,"text"=>"Error Occured"));
        }
    }

    public function ChangeUnit() {
        $this->data['units'] = $this->ToolsModel->UserUnits($this->user->user_id);
		$this->load->view('change-unit', $this->data);
    }

    public function UpdateUnit() {
        $unit = $this->input->post('unit',true);
        if($unit) {
            $data = $this->session->userdata("CIRSTAYLOGIN");
            $data['user_unit_code'] = $unit;
            $this->session->set_userdata("CIRSTAYLOGIN", $data);
            echo json_encode(array("status"=>200,"text"=>"Updated Successfully"));
        }
        else {
            echo json_encode(array("status"=>400,"text"=>"Error Occured"));
        }
    }  
    public function SetBonusDate(){
        $this->data["bonus_list"]=$this->ToolsModel->SaveBonusDateList();
        $this->load->view('setbonus-date',$this->data);
    }
    public function SaveBonusDate(){
        $response=$this->ToolsModel->SaveBonusDate();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Tools/SetBonusDate', 'refresh');
    }
    public function SaveBonusDateEdit(){
        $this->data["bonus_edit"]=$this->ToolsModel->SaveBonusDateEdit();
        $this->load->view('templates/set-bonus-date-edit',$this->data);
    }
    public function UpdateSetBonusDate(){
        echo json_encode($this->ToolsModel->UpdateSetBonusDate());
    }
    public function GenerateBills() {
        $this->data['bill_dte'] = $this->ToolsModel->GetLastbillDate($this->user->user_unit_code);
		$this->load->view('bill-generate', $this->data);
    }
    public function GenerateAgentBills(){
        echo json_encode($this->ToolsModel->GenerateAgentBills());
    }
}
?>