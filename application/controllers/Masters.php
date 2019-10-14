<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class Masters extends BaseController { 

	public function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model("MastersModel");
	}
    public function index() {       
	}

    //Product Group Master
    public function ProductGroups()
    {
        $this->data["prdts"]=$this->MastersModel->ProductLists(); 
        $this->data["prdt_groups"]=$this->MastersModel->GetProductGroups();
        $this->load->view('product-group-master', $this->data);
    }
    public function CreateProductGroups()
    {
        $response=$this->MastersModel->CreateProductGroups();        
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/ProductGroups', 'refresh'); 
    }
    public function UpdateProductGroups()
    {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data=array("group_code"=>$this->input->post('group_code'),
                    "group_name"=>strtoupper($this->input->post('group_name')),
                    "modified_by"=>$modified_by,
                    "modified_date"=>$modifiedDate
                    );
        $product_codes = explode(",",$this->input->post('group_prdts'));
        echo $this->MastersModel->UpdateProductGroups($data, $product_codes);
    }
    public function DeleteProductGroup()
    {
        $data=array('group_code'=>$this->input->post('group_code'),
                    'cancel_flag'=>'1',
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->MastersModel->DeleteProductGroup($data); 
    }
    public function UpdateProductGroupPriority()
    {
        echo $this->MastersModel->UpdateProductGroupPriority();
    } 

    //Product Master
    public function Products()
    {
        $this->data["prdt_lists"]=$this->MastersModel->ProductLists(); 
        $this->load->view('product-master', $this->data);
    }
    public function CreateProducts()
    {
        $response=$this->MastersModel->CreateProductMaster(); 
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Products', 'refresh');
    }
    public function UpdateProducts()
    {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data=array("product_code"=>$this->input->post('product_code'),
                    "product_name"=>strtoupper($this->input->post('product_name')),
                    "cancel_flag"=>$this->input->post('product_disable'),
                    "modified_by"=>$modified_by,
                    "modified_date"=>$modifiedDate
                    );
        echo $this->MastersModel->UpdateProductMaster($data); 
    } 
    public function DeleteProducts()
    {
        $data=array('product_code'=>$this->input->post('product_code'),
                    'cancel_flag'=>$this->input->post('product_status'),
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->MastersModel->DeleteProductMaster($data); 
    }
    public function UpdateProductsPriority()
    {
        echo $this->MastersModel->UpdateProductMasterPriority(); 
    }

    //Issue Master
    public function Issue() {
        $issue = array();
        $this->data["issue_id"] = $this->MastersModel->ViewPrimaryId('ISSUE_CODE');
        $this->data["product_list"] = $this->MastersModel->ProductLists();
        if(isset($_GET['p'])) { $issue = $this->MastersModel->IssueLists($_GET['p'],10,null); }
        $this->data["issue"] = $issue;
        $this->load->view('issue-master', $this->data);
    }
    public function CreateIssue() {
        $response = $this->MastersModel->CreateIssue();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Issue?p='.$response->product, 'refresh');
    }
    public function ViewIssue() {
        $issue_product_code = $this->input->post('issue_product_code',true);
        $issue_code = $this->input->post('issue_code',true);
        $this->data["issue"] = $this->MastersModel->IssueLists($issue_product_code,1,$issue_code);
        $this->data["product_list"] = $this->MastersModel->ProductLists();
        $this->load->view('templates/issue-master-edit', $this->data);
    }
    public function UpdateIssue() {
        echo json_encode($this->MastersModel->UpdateIssue());
    }
    public function DeleteIssue() {
        echo json_encode($this->MastersModel->DeleteIssue());
    }

    //Bureau Master 
    public function Bureaus()
	{
        $this->data['bureau_lists'] = $this->MastersModel->BureauLists();
		$this->load->view('bureau-master', $this->data);
	}
    public function CreateBureau() 
	{
        $response=$this->MastersModel->CreateBureauMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Bureaus', 'refresh');
	}  
    public function UpdateBureau() {
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data = array(
            'bureau_code' => strtoupper($this->input->post('bureau_code', TRUE)),
            'bureau_name' => strtoupper($this->input->post('bureau_name', TRUE)),
            'bureau_contact_person' => strtoupper($this->input->post('bureau_contact', TRUE)),
            'bureau_mobile' => strtoupper($this->input->post('bureau_mobile', TRUE)),
            'modified_by' => $modified_by,
            'modified_date' => $modifiedDate
            );
		echo $this->MastersModel->UpdateBureauMaster($data);  
	}
    public function DeleteBureau() { 
        $modified_by  = $this->user->user_id;
        $modifiedDate = date('Y-m-d H:i:s');
        $data=array('bureau_code'=>$this->input->post('bureau_code', TRUE),
                    'cancel_flag' =>'1',
                    'modified_by' => $modified_by,
                    'modified_date' => $modifiedDate);
        echo $this->MastersModel->DeleteBureauMaster($data);  

	}
    public function UpdateBureauPriority()
    {
        echo $this->MastersModel->UpdateBureauPriority(); 
    }

   //Promoter
    public function Promoter() {
        $this->data["promoter_code"] = $this->MastersModel->ViewPrimaryId('PR_'.$this->user->user_unit_code.'_CODE');
        $this->data["promoter_list"] = $this->MastersModel->PromoterLists();
        $this->load->view('promoter-master', $this->data);
    }
    public function CreatePromoter() {
        $response = $this->MastersModel->CreatePromoter();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Promoter', 'refresh');
    }
    public function UpdatePromoter() {
        echo json_encode($this->MastersModel->UpdatePromoter());
    }
    public function DeletePromoter() {
        echo json_encode($this->MastersModel->DeletePromoter());
    }
    public function ViewPromoter() {
        $this->data["promoter"]=$this->MastersModel->ViewPromoter();
        $this->data["acm"]=$this->MastersModel->PromoterACMLists();        
        echo $this->load->view('templates/promoter-details', $this->data);
    }

    //ACM
    public function ACM() {
        $this->data["acm_code"] = $this->MastersModel->ViewPrimaryId('ACM_'.$this->user->user_unit_code.'_CODE');
        $this->data["acm"] = $this->MastersModel->ACMLists();
        $this->load->view('acm-master', $this->data);
    }
    public function CreateACM() {
        $response = $this->MastersModel->CreateACM();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/ACM', 'refresh');
    }
    public function UpdateACM() {
        echo json_encode($this->MastersModel->UpdateACM());
    }
    public function DeleteACM() {
        echo json_encode($this->MastersModel->DeleteACM());
    }
    public function ViewACM() {
        $this->data["acm"]=$this->MastersModel->ViewACM();
        echo $this->load->view('templates/acm-details', $this->data);
    }  

    //Residence Association
    public function ResidenceAssociation(){
        $this->data["res_code"] = $this->MastersModel->ViewPrimaryId("RES_".$this->user->user_unit_code);
        $this->data["residence"]= $this->MastersModel->ResidenceAssociationList();
        $this->load->view('residence-master', $this->data);
    }
    public function CreateResidenceAssociation(){
       $response= $this->MastersModel->CreateResidenceAssociation();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/ResidenceAssociation', 'refresh');
    }
    public function ViewResidenceAssociation(){
        $this->data["residence"]= $this->MastersModel->ViewResidenceAssociationList();
        $this->load->view('templates/residence-master-edit', $this->data);
    }
    public function UpdateResidenceAssociation(){
        echo json_encode($this->MastersModel->UpdateResidenceAssociation());
    }
    public function DeleteResidenceAssociation(){
        echo json_encode($this->MastersModel->DeleteResidenceAssociation());
    }

    //Copy Type Master
    public function CopyTypeMaster(){
        $this->data["cpt_code"] = $this->MastersModel->ViewPrimaryId('CPT_CODE');
        $this->data["copy_code"] = $this->MastersModel->GetCopyCode();
        $this->data["ct_rec"] = $this->MastersModel->CopyTypeMasterList();
        $this->load->view('copytype-master', $this->data);
    }
    public function CreateCopyTypeMaster(){
        $response= $this->MastersModel->CreateCopyTypeMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/CopyTypeMaster', 'refresh');
    }
    public function ViewCopyTypeMaster(){
        $this->data["copy_type_rec"]= $this->MastersModel->ViewCopyTypeMaster();
        $this->data["copy_code"] = $this->MastersModel->GetCopyCode();
        $this->load->view('templates/copy-type-master-edit', $this->data);
    }
    public function UpdateCopyTypeMaster(){
        echo json_encode($this->MastersModel->UpdateCopyTypeMaster());
    }
    //Union master
    public function UnionMaster(){
        $this->data["un_code"] = $this->MastersModel->ViewPrimaryId("UN_".$this->user->user_unit_code."_CODE");
        $this->data["union_list"] = $this->MastersModel->UnionMasterList();
        $this->load->view('union-master',$this->data);
    }
    public function CreateUnionMaster(){
        $response= $this->MastersModel->CreateUnionMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/UnionMaster', 'refresh');
    }
    public function ViewUnionMaster(){
        $this->data["union_rec"]= $this->MastersModel->ViewUnionMaster();
        $this->load->view('templates/union-master-edit', $this->data);
    }
    public function updateUnionMaster(){
        echo json_encode($this->MastersModel->updateUnionMaster());
    }

    //Shakha Master
    public function ShakhaMaster(){
        $this->data["sh_code"] = $this->MastersModel->ViewPrimaryId("SHAKHA_".$this->user->user_unit_code."_CODE");
        $this->data["shakha_list"] = $this->MastersModel->ShakhaMasterList();
        $this->load->view('shakha-master',$this->data);
    }
    public function CreateShakhaMaster(){
        $response= $this->MastersModel->CreateShakhaMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/ShakhaMaster', 'refresh');
    }
    public function ViewShakhaMaster(){
        $this->data["shakha_rec"]= $this->MastersModel->ViewShakhaMaster();
        $this->load->view('templates/shakha-master-edit', $this->data);
    }
    public function UpdateShakhaMaster(){
        echo json_encode($this->MastersModel->UpdateShakhaMaster());
    }

    //Edition master
    public function EditionMaster(){
        $this->data["edt_code"] = $this->MastersModel->ViewPrimaryId("EDT_".$this->user->user_unit_code."_CODE");
        $this->data['edit_lists'] = $this->MastersModel->EditionMasterLists();
        $this->load->view('edition-master',$this->data);
    }
    public function CreateEditionMaster(){
        $response= $this->MastersModel->CreateEditionMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/EditionMaster', 'refresh');
    }
    public function ViewEditionMaster(){
        $this->data["edit_rec"]= $this->MastersModel->ViewEditionMaster();
        $this->load->view('templates/edition-master-details', $this->data);
    }
    public function UpdateEditionMaster(){
        echo json_encode($this->MastersModel->UpdateEditionMaster());
    }
    public function UpdateEditionPriority()
    {
        echo $this->MastersModel->UpdateEditionPriority();
    }

    //Route Master
    public function RouteMaster(){
        $this->data["rte_code"] = $this->MastersModel->ViewPrimaryId("RTE_".$this->user->user_unit_code."_CODE");
        $this->data['rte_lists'] = $this->MastersModel->RouteMasterLists();
        $this->load->view('route-master',$this->data);
    }
    public function CreateRouteMaster(){
        $response= $this->MastersModel->CreateRouteMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/RouteMaster', 'refresh');
    }
    public function ViewRouteMaster(){
        $this->data["route_rec"]= $this->MastersModel->ViewRouteMaster();
        $this->load->view('templates/route-master-details', $this->data);
    }
    public function UpdateRouteMaster(){
        echo json_encode($this->MastersModel->UpdateRouteMaster());
    }
    public function UpdateRoutePriority()
    {
        echo $this->MastersModel->UpdateRoutePriority();
    }

    //Dropping Point Master
    public function DroppingMaster($route_id=null){
        $this->data["drop_code"] = $this->MastersModel->ViewPrimaryId("DRP_".$this->user->user_unit_code."_CODE");
        $this->data["drop_rec"] = $this->MastersModel->DroppingMasterLists($route_id);
        $this->data["route_list"] = $this->MastersModel->GetDroppingRoute();
        $this->data["route_id"]=$route_id;
        $this->load->view('dropping-master',$this->data);
    }
    public function CreateDroppingMaster(){
        $drop_rt_code=json_decode(rawurldecode($this->input->post('dr_route_code_rec_sel',true)),true);
        $response= $this->MastersModel->CreateDroppingMaster($drop_rt_code);
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/DroppingMaster/'.$drop_rt_code["Code"], 'refresh');
    }
    public function ViewDroppingMaster(){
        $this->data["dp_rec"]= $this->MastersModel->ViewDroppingMaster();
        $this->load->view('templates/dropping-point-details', $this->data);
    }
    public function UpdateDroppingMaster(){
        echo json_encode($this->MastersModel->UpdateDroppingMaster());
    }
    public function UpdateDroppingMasterPriority(){
        echo $this->MastersModel->UpdateDroppingMasterPriority();
    }

    //Account Heads
    public function AccountHeads() {
        $this->data["acc_code"] = $this->MastersModel->ViewPrimaryId('ACC_CODE');
        $this->data["acc_heads"] = $this->MastersModel->AccountHeadsLists();
        $this->load->view('account-heads-master', $this->data);
    }
    public function CreateAccountHeads() {
        $response = $this->MastersModel->CreateAccountHeads();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/AccountHeads', 'refresh');
    }
    public function UpdateAccountHeads() {
        echo json_encode($this->MastersModel->UpdateAccountHeads());
    }
    public function ViewAccountHeads() {
        $this->data["acc_heads"]=$this->MastersModel->ViewAccountHeads();
        echo $this->load->view('templates/account-heads-details', $this->data);
    }
    
    //Event Master
    public function Event(){
        $this->data["ent_code"] = $this->MastersModel->ViewPrimaryId("ENT_".$this->user->user_unit_code."_CODE");
        $this->data["ent_rec"] = $this->MastersModel->EventLists();
        $this->load->view('event-master',$this->data);
    }
    public function CreateEvent(){
        $response= $this->MastersModel->CreateEvent();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Event', 'refresh');
    }
    public function ViewEvent(){
        $this->data["evt_rec"]= $this->MastersModel->ViewEvent();
        $this->load->view('templates/event-master-details', $this->data);
    }
    public function UpdateEvent(){
        echo json_encode($this->MastersModel->UpdateEvent());
    }

    //Agent Master
    public function Agent(){
        if(isset($_GET['g_id'])) {
            $agent_slno = base64_decode($_GET['g_id']);
            $agent_details = $this->MastersModel->AgentDetails($agent_slno);
            $membership_details = $this->MastersModel->AgentMembershipDetails($agent_slno);
        }
        else {
            $agent_slno = $this->MastersModel->ViewPrimaryId('AS_'.$this->user->user_unit_code.'_CODE');
            $agent_details = $membership_details = array();
        }
        $this->data["agent_slno"]         = $agent_slno;
        $this->data["agent_details"]      = $agent_details;
        $this->data["membership_details"] = $membership_details;
        $this->data["agent_copy_type"]    = $this->MastersModel->GetCopyCode();
        $this->load->view('agent-master',$this->data);
    }
    public function UpsertAgentMaster(){        
        $response= $this->MastersModel->UpsertAgentMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($response->agent_slno) {
            redirect('/Masters/Agent?g_m=ZWRpdC1tb2Rl&g_id='.base64_encode($response->agent_slno), 'refresh');
        }
        else {
            redirect('/Masters/Agent', 'refresh');
        }
    }
    public function AgentSearch(){
        $agents = array();
        if(isset($_GET['g_fe'])) {
            $agents = $this->MastersModel->AgentLists();
        }
        $this->data["units"] = $this->MastersModel->UnitsLists();       
        $this->data["agents"] = $agents;
        $this->load->view('agent-master-search',$this->data);
    }
    public function ValidateAgentCode(){
        echo json_encode($this->MastersModel->ValidateAgentCode());
    }

    //Agent Groups
    public function AgentGroups() {
        $this->data["agent_groups"] = $this->MastersModel->GetAgentGroups();
        $this->load->view('agent-groups-master', $this->data);
    }
    public function CreateAgentGroups() {
        echo json_encode($this->MastersModel->CreateAgentGroups());
    }
    public function DeleteAgentGroups() {
        echo json_encode($this->MastersModel->DeleteAgentGroups());
    }
    public function ViewAgentGroups() {
        $this->data["aggroup"]=$this->MastersModel->ViewAgentGroups();
        echo $this->load->view('templates/agentgroup-view-details', $this->data);
    }
    public function EditAgentGroups() {
        $this->data["aggroup"]=$this->MastersModel->ViewAgentGroups();
        echo $this->load->view('templates/agentgroup-edit-details', $this->data);
    }
    public function GetUploadedAgents() {
        echo $this->MastersModel->GetUploadedAgents();
    }
    
    //Region Master
    public function Region(){
        $this->data['reg_code']=$this->MastersModel->ViewPrimaryId("REG_".$this->user->user_unit_code."_CODE");
        $this->data["region_list"]=$this->MastersModel->RegionLists();
        $this->load->view('region-master',$this->data);
    }
    public function CreateRegion(){
      $response = $this->MastersModel->CreateRegion();
      $this->session->set_flashdata('flash_message', json_encode($response));
      redirect('/Masters/Region', 'refresh');
    }
    public function ViewRegion(){
        $this->data["reg_rec"]= $this->MastersModel->ViewRegion();
        $this->load->view('templates/region-master-details', $this->data);
    }
    public function UpdateRegion(){
        echo json_encode($this->MastersModel->UpdateRegion());
    }
    //Holiday Master
    public function Holiday(){
        $this->data["hld_code"] = $this->MastersModel->ViewPrimaryId("HLD_".$this->user->user_unit_code."_CODE");
        $this->data["holiday_list"]=$this->MastersModel->HolidayList();
        $this->load->view('holiday-master',$this->data);
    }
    public function CreateHoliday(){
        $response = $this->MastersModel->CreateHoliday();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Holiday', 'refresh');
    }
    public function ViewHoliday(){
        $this->data["holiday_rec"]= $this->MastersModel->ViewHoliday();
        $this->load->view('templates/holiday-master-details', $this->data);
    }
    public function UpdateHoliday(){
        echo json_encode($this->MastersModel->UpdateHoliday());
    }
    //subscriber master
    public function Subscriber(){        
        if(isset($_GET['g_fe'])) {
            $this->data["sub_list"]=$this->MastersModel->SubscriberList();
        }
        else {
            $this->data["sub_list"]=array();
        }
        $this->load->view('subscriber-master',$this->data);
    }
    public function CreateSubscriber() {
        $this->data["sub_code"] = $this->MastersModel->ViewPrimaryId("SUB_".$this->user->user_unit_code."_CODE");
        $this->load->view('subscriber-master-create',$this->data);
    }
    public function SaveSubscriber(){
        $response = $this->MastersModel->SaveSubscriber();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/CreateSubscriber', 'refresh');
    }
    public function ViewSubscriber(){
        $this->data["sub_rec"]= $this->MastersModel->ViewSubscriber();
        $this->load->view('templates/subscriber-master-edit', $this->data);
    }
    public function UpdateSubscriber(){
        echo json_encode($this->MastersModel->UpdateSubscriber());
    } 
    public function AmendmentReason(){
        $this->data["amnd_code"] = $this->MastersModel->ViewPrimaryId("AMND_CODE");
        $this->data["amnd_list"]=$this->MastersModel->AmendmentReasonList();
        $this->load->view('amendment-reason',$this->data);
    }
    public function CreateAmendmentReason(){
        $response = $this->MastersModel->CreateAmendmentReason();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/AmendmentReason', 'refresh');
    }
    public function ViewAmendmentReason(){
        $this->data["amnd_rec"]=$this->MastersModel->ViewAmendmentReason();
        $this->load->view('templates/amendment-reason-edit', $this->data);
    }
    public function UpdateAmendmentReason(){
        echo json_encode($this->MastersModel->UpdateAmendmentReason());
    }
    //Amendment Type
    public function AmendmentType(){
        $this->data["amt_code"] = $this->MastersModel->ViewPrimaryId("AMT_CODE");
        $this->data["amt_list"] = $this->MastersModel->AmendmentTypeList();
        $this->load->view('amendment-type-master',$this->data);
    }
    public function CreateAmendmentType(){
        $response = $this->MastersModel->CreateAmendmentType();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/AmendmentType', 'refresh');
    }
    public function ViewAmendmentType(){
        $this->data["amt_rec"] = $this->MastersModel->ViewAmendmentType();
        $this->load->view('templates/amendment-type-edit', $this->data);
    }
    public function UpdateAmendmentType(){
        echo json_encode($this->MastersModel->UpdateAmendmentType());
    }
    //Wellwisher
    public function WellWisher(){
        $this->data["well_code"] = $this->MastersModel->ViewPrimaryId("WELL_".$this->user->user_unit_code."_CODE");
        $this->data["well_list"] = $this->MastersModel->WellWisherList();
        $this->load->view('wellwisher-master',$this->data);
    }
    public function CreateWellWisher(){
        $response = $this->MastersModel->CreateWellWisher();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/WellWisher', 'refresh');
    }
    public function ViewWellWisher(){
        $this->data["well_rec"] = $this->MastersModel->ViewWellWisher();
        $this->load->view('templates/wellwisher-details', $this->data);
    }
    public function UpdateWellWisher(){
        echo json_encode($this->MastersModel->UpdateWellWisher());
    }
    //Response
    public function Response(){
        $this->data["list_respose"]=$this->MastersModel->ResponseList();
        $this->load->view('response-master',$this->data);
    }
    public function CreateResponse(){
        if(empty($this->input->post('response_head')))
        {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('mandatory_fields_empty');
            $this->session->set_flashdata('flash_message', json_encode($this->Message));
        }
        else
        {
            $this->session->set_flashdata('flash_message', json_encode($this->MastersModel->CreateResponse()));
        }
        redirect('/Masters/response', 'refresh');
    }
    public function UpdateResponse(){
        echo json_encode($this->MastersModel->UpdateResponse());
    }
    //Entry status
    public function EntryStatus(){
        $this->data['list_status']=$this->MastersModel->EntryStatusList();
        $this->load->view('entry-status-master',$this->data);
    }
    public function CreateEntryStatus(){
        if(empty($this->input->post('status_head')))
        {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('mandatory_fields_empty');
            $this->session->set_flashdata('flash_message', json_encode($this->Message));
        }
        else
        {
            $this->session->set_flashdata('flash_message', json_encode($this->MastersModel->CreateEntryStatus()));
        }
        redirect('/Masters/EntryStatus', 'refresh');

    }
    public function UpdateEntryStatus()
    {
        echo json_encode($this->MastersModel->UpdateEntryStatus());
    }
    //sponsor master
    public function Sponsor(){
        $this->data["sp_code"] = $this->MastersModel->ViewPrimaryId("SP_".$this->user->user_unit_code."_CODE");
        $this->data["sp_list"]=$this->MastersModel->SponsorList();
        $this->load->view('sponsor-master',$this->data);
    }
    public function CreateSponsor(){
        $response = $this->MastersModel->CreateSponsor();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/Sponsor', 'refresh');
    }
    public function ViewSponsor(){
        $this->data["sp_rec"]= $this->MastersModel->ViewSponsor();
        $this->load->view('templates/sponsor-master-edit', $this->data);
    }
    public function UpdateSponsor(){
        echo json_encode($this->MastersModel->UpdateSponsor());
    }
    public function BankMaster(){
        $this->data["bnk_code"] = $this->MastersModel->ViewPrimaryId("BNK_CODE");
        $this->data["bnk_details"] = $this->MastersModel->GetBankDetails();
        $this->load->view('bank-master',$this->data);
    }
    public function CreateBankMaster(){
        $response = $this->MastersModel->CreateBankMaster();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Masters/BankMaster', 'refresh');
    }
    public function ViewBankMaster(){
        $this->data["bank_rec"]= $this->MastersModel->ViewBankMaster();
        $this->load->view('templates/bank-master-edit', $this->data);
    }
    public function UpdateBankMaster(){
        echo json_encode($this->MastersModel->UpdateBankMaster());
    }
}

?>