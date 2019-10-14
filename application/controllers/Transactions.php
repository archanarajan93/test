<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class Transactions extends BaseController { 
    public $encryption_key = "";
	public function __construct()
	{
		parent::__construct();
		$this->load->model("TransactionsModel");
        $this->encryption_key = $this->config->item('encryption_key');
	}
    public function index() {       
	}

    //Enroll
    public function Enroll()
    {
        if(isset($_GET['g_fe'])) {
            $this->data["records"]=$this->TransactionsModel->EnrollLists();
        }
        else {
            $this->data["records"]=array();
        }
        $this->load->view('Transactions/enroll', $this->data);
    }
    public function EnrollCreate()
    {
        $this->data["code"] = $this->TransactionsModel->ViewPrimaryId('ERL_'.$this->user->user_unit_code.'_CODE');
        $this->data["records"] = array();
        $this->load->view('Transactions/enroll-create', $this->data);
    }
    public function EnrollEdit()
    {
        $this->data["code"] = $sales_code = base64_decode($_GET['g_fe']);
        $this->data["records"] = $this->TransactionsModel->ViewEnrollLists($sales_code);
        $this->load->view('Transactions/enroll-edit', $this->data);
    }
    public function UpsertEnroll()
    {
        $is_update  = (int)$this->input->post('is_update',true);
        $sales_code = $this->input->post('sales_code',true);
        $response   = $this->TransactionsModel->UpsertEnroll();        
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($is_update === 0 && $sales_code) {
            redirect('/Transactions/EnrollCreate', 'refresh');
        }
        else {
            redirect('/Transactions/EnrollEdit?g_fe='.base64_encode($sales_code), 'refresh');
        }            
    }
    public function StopCopy()
    {
        echo json_encode($this->TransactionsModel->StopCopy());
    } 

    //Start Copy
    public function StartCopy()
    {
        if(isset($_GET['g_fe'])) {
            $this->data["records"]=$this->TransactionsModel->EnrollLists(EnrollStatus::Approved);
        }
        else {
            $this->data["records"]=array();
        }
        $this->load->view('Transactions/start-copy', $this->data);
    }
    public function EditStartCopy()
    {
        $this->data["code"] = $sales_code = base64_decode($_GET['g_fe']);
        $this->data["records"] = $this->TransactionsModel->ViewEnrollLists($sales_code);
        $this->load->view('Transactions/start-copy-edit', $this->data);
    }
    public function ApproveStartCopy()
    {
        echo json_encode($this->TransactionsModel->ApproveStartCopy());
    }

    //Packers Diary
    public function PackersDiary(){
        $this->data["pack_rec"]=$this->TransactionsModel->PackersDiaryLists();
        $this->load->view('Transactions/packers-diary',$this->data);
    }
    public function CreatePackersDiary(){
        
        $response=$this->TransactionsModel->CreatePackersDiary();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/PackersDiary', 'refresh');
    }
    public function ViewPackersDiary(){
        $this->data["pack_edit"]=$this->TransactionsModel->ViewPackersDiary();
        $this->load->view('templates/packers-diary-edit',$this->data);
    }
    public function UpdatePackersDiary(){
        echo json_encode($this->TransactionsModel->UpdatePackersDiary());    
    }

   //Finalize Transaction
   public function FinalizeReceipt(){
       $this->data["list_rept"] = $this->TransactionsModel->GetReceiptFinalize();
       $this->load->view('/Transactions/receipt-finalize',$this->data);
   }
   public function CreateFinalizeReceipt(){
       $response=$this->TransactionsModel->CreateFinalizeReceipt();
       $this->session->set_flashdata('flash_message', json_encode($response));
       redirect('/Transactions/FinalizeReceipt', 'refresh');
   }
   public function RevertReceiptFinalize(){
       $response=$this->TransactionsModel->RevertReceiptFinalize();
       $this->session->set_flashdata('flash_message', json_encode($response));
       redirect('/Transactions/FinalizeReceipt', 'refresh');
   }
   public function FinalizeJournal(){
       $this->data["date_list"]=$this->TransactionsModel->GetJournalFinalize();
       $this->load->view('/Transactions/journal-finalize',$this->data);
   }
   public function CreateFinalizeJournal(){
       $response=$this->TransactionsModel->CreateFinalizeJournal();
       $this->session->set_flashdata('flash_message', json_encode($response));
       redirect('/Transactions/FinalizeJournal', 'refresh');
   }
   public function RevertJournalFinalize(){
       $response=$this->TransactionsModel->RevertJournalFinalize();
       $this->session->set_flashdata('flash_message', json_encode($response));
       redirect('/Transactions/FinalizeJournal', 'refresh');
   }

    //Scheme Details
    public function Scheme()
    {
        $this->data["sch_records"]=$this->TransactionsModel->SchemeDetailsLists();
        $this->data["en_key"] = $this->encryption_key;
        $this->load->view('Transactions/scheme', $this->data);
    }
    public function SchemeCreate()
    {
        $this->data["scheme_code"] = $this->TransactionsModel->ViewPrimaryId('SCH_'.$this->user->user_unit_code.'_CODE');
        $this->load->view('Transactions/scheme-create', $this->data);
    }
    public function SchemeEdit($sch_code)
    {
        $this->data["sch_code"]=$sch_code;
        $this->data["is_renewal"]=0;
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $this->data["sch_details"]=$this->TransactionsModel->SchemeDetails($sch_code);
        $this->load->view('Transactions/scheme-edit', $this->data);
    }
    public function SchemeRenew($sch_code)
    {
        $this->data["sch_code"]=$sch_code;
        $this->data["is_renewal"]=1;
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $this->data["sch_details"]=$this->TransactionsModel->SchemeDetails($sch_code);
        $this->load->view('Transactions/scheme-edit', $this->data);
    }
    public function SchemeDetails($sch_code)
    {
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $this->data["sch_details"]=$this->TransactionsModel->SchemeDetails($sch_code);
        $this->load->view('Transactions/scheme-view', $this->data);
    }
    public function UpsertScheme()
    {
        $response = $this->TransactionsModel->UpsertScheme();
        $this->session->set_flashdata('html_flash_message', json_encode($response));
        redirect('/Transactions/Scheme', 'refresh');
    }
    public function DeleteScheme($sch_code)
    {
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $data=array('sch_slno'=>$sch_code,
                    'cancel_flag'=>'1',
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->TransactionsModel->DeleteScheme($data); 
    }
    public function PauseScheme($sch_code)
    {
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $data=array('sch_slno'=>$sch_code,
                    'sch_paused_flag'=>'1',
                    'sch_paused_by'=>$this->user->user_id
                    );
        echo $this->TransactionsModel->PauseScheme($data); 
    }
    public function RestartScheme($sch_code)
    {
        $sch_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_code, $this->encryption_key);
        $data=array('sch_slno'=>$sch_code,
                    'sch_paused_flag'=>null,
                    'sch_paused_by'=>null
                    );
        echo $this->TransactionsModel->RestartScheme($data); 
    }

    //Other Receipts
    public function OtherReceipts()
    {
        $finalize_date = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        $this->data["sch_rcpt_records"]=$this->TransactionsModel->GetOtherReceipts(date("Y-m-d",strtotime($finalize_date)));
        $this->data["en_key"] = $this->encryption_key;
        $this->load->view('Transactions/other-receipts', $this->data);
    }
    public function CreateOtherReceipts()
    {
        $finalize_date = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        $this->data["sch_rcpt_code"] = $this->TransactionsModel->ViewPrimaryId('SRCT_'.$this->user->user_unit_code.'_CODE');
        $this->data["sch_rcpt_dte"] = $finalize_date?date("d-m-Y", strtotime($finalize_date)):date("d-m-Y");
        $this->load->view('Transactions/other-receipts-create', $this->data);
    }
    public function UpdateOtherReceipts($sch_rcpt_code)
    {
        $this->data["sch_rcpt_code"]=$sch_rcpt_code;
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $this->data["sch_rcpt_details"]=$this->TransactionsModel->GetOtherReceiptDetails($sch_rcpt_code);
        $this->load->view('Transactions/other-receipts-edit', $this->data);
    }
    public function ViewOtherReceipts($sch_rcpt_code)
    {
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $this->data["sch_rcpt_details"]=$this->TransactionsModel->GetOtherReceiptDetails($sch_rcpt_code);
        $this->load->view('Transactions/other-receipts-view', $this->data);
    }
    public function DeleteOtherReceipts($sch_rcpt_code)
    {
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $data=array('srec_no'=>$sch_rcpt_code,
                    'cancel_flag'=>'1',
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->TransactionsModel->DeleteOtherReceipts($data); 
    }
    public function UpsertOtherReceipts()
    {
        $response = $this->TransactionsModel->UpsertOtherReceipts();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/OtherReceipts', 'refresh');
    }

    //Sponsor
    public function Sponsor()
    {
        if(isset($_GET['g_fe'])) {
            $this->data["records"]=$this->TransactionsModel->SponsorLists();
        }
        else {
            $this->data["records"]=array();
        }
        $this->load->view('Transactions/sponsor', $this->data);
    }
    public function CreateSponsor() {
        $this->data["code"] = $this->TransactionsModel->ViewPrimaryId('SPO_'.$this->user->user_unit_code.'_CODE');
        $this->load->view('Transactions/sponsor-create', $this->data);
    }
    public function EditSponsor() {
        $spons_code = base64_decode($_GET['g_fe']);
        if($spons_code) {
            $this->data["code"] = $spons_code;
            $this->data["records"]=$this->TransactionsModel->SponsorDetails($spons_code);
            $this->data["date_records"]=$this->TransactionsModel->SponsorCopyDates($spons_code);
            $this->load->view('Transactions/sponsor-edit', $this->data);
        }
    }
    public function UpsertSponsor()
    {
        $is_update  = (int)$this->input->post('is_update',true);
        $spons_code = $this->input->post('spons_code',true);
        $response   = $this->TransactionsModel->UpsertSponsor();
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($is_update === 0 && $spons_code) {
            redirect('/Transactions/CreateSponsor', 'refresh');
        }
        else {
            redirect('/Transactions/EditSponsor?g_fe='.base64_encode($spons_code), 'refresh');
        }
    }
    public function IsDatesFinalized()
    {
        echo json_encode($this->TransactionsModel->IsDatesFinalized());
    }

    //Journal Entry
    public function JournalEntry(){
        $this->data["je_rec"] = $this->TransactionsModel->GetJournalEntry();
        $this->load->view('/Transactions/journal-entry',$this->data); 
    }
    public function NewJournalEntry(){
        $unit_code = $this->user->user_unit_code;
        $pdt_code = $this->user->user_product_code;
        $type = FinalizeType::Journal;
        $this->data["je_date"] = $this->TransactionsModel->GetLastFinalizeDate($unit_code,$pdt_code,$type);
        $this->data["je_code"] = $this->TransactionsModel->ViewPrimaryId("JE_".$this->user->user_unit_code."_CODE");
        $this->load->view('/Transactions/journal-entry-new',$this->data);
    }
    public function CreateJournalEntry(){
        $response=$this->TransactionsModel->CreateJournalEntry();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/JournalEntry', 'refresh');
    }
    public function EditJournalEntry(){
        $unit_code = $this->user->user_unit_code;
        $pdt_code = $this->user->user_product_code;
        $type = FinalizeType::Journal;
        $this->data["journal_date"] = $this->TransactionsModel->GetLastFinalizeDate($unit_code,$pdt_code,$type);
        $this->data["je_edit"] = $this->TransactionsModel->EditJournalEntry();
        $this->load->view('/Transactions/journal-entry-edit',$this->data);
    }
    public function UpdateJournalEntry(){
        echo json_encode($this->TransactionsModel->UpdateJournalEntry());
    }
    public function DeleteJournalEntry(){
        echo json_encode($this->TransactionsModel->DeleteJournalEntry());
    }

    //Ente Kaumudi
    public function EnteKaumudi()
    {
        if(isset($_GET['g_fe'])) {
            $this->data["records"]=$this->TransactionsModel->EnteKaumudiLists();
        }
        else {
            $this->data["records"]=array();
        }
        $this->load->view('Transactions/ente-kaumudi', $this->data);
    }
    public function CreateEnteKaumudi() {
        $this->data["rate_amount"] = $this->TransactionsModel->GetRate('EK',$this->user->user_product_code);
        $this->data["code"] = $this->TransactionsModel->ViewPrimaryId('EK_'.$this->user->user_unit_code.'_CODE');
        $this->load->view('Transactions/ente-kaumudi-create', $this->data);
    }
    public function EditEnteKaumudi() {
        $ek_slno = base64_decode($_GET['g_fe']);
        if($ek_slno) {
            $this->data["code"] = $ek_slno;
            $this->data["records"]=$this->TransactionsModel->EnteKaumudiDetails($ek_slno);
            $this->data["subs_records"]=$this->TransactionsModel->EnteKaumudiSubscribers($ek_slno);
            $this->load->view('Transactions/ente-kaumudi-edit', $this->data);
        }
    }
    public function UpsertEnteKaumudi()
    {
        $is_update  = (int)$this->input->post('is_update',true);
        $ek_slno    = $this->input->post('ek_slno',true);
        $response   = $this->TransactionsModel->UpsertEnteKaumudi();
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($is_update === 0 && $ek_slno) {
            redirect('/Transactions/CreateEnteKaumudi', 'refresh');
        }
        else {
            redirect('/Transactions/EditEnteKaumudi?g_fe='.base64_encode($ek_slno), 'refresh');
        }
    }
    public function ManageEnteKaumudiStatus()
    {
        echo json_encode($this->TransactionsModel->ManageEnteKaumudiStatus());
    }

    //Free Copy
    public function FreeCopy(){
        
        $this->data["en_key"] = $this->encryption_key;
        $this->data["free_list"] = $this->TransactionsModel->GetFreeCopies();
        $this->load->view('/Transactions/free-copy',$this->data);
    }
    public function CreateFreeCopy(){
        $this->data["free_code"] = $this->TransactionsModel->ViewPrimaryId("FRE_".$this->user->user_unit_code."_CODE");
        $this->load->view('/Transactions/free-copy-create',$this->data);
    }
    public function UpsertFreeCopy(){
        $response=$this->TransactionsModel->UpsertFreeCopy();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/FreeCopy', 'refresh');
    }
    public function FreeCopyEdit($fc_code){
        $this->data["fc_code"]=$fc_code;
        $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        $this->data["free_rec"] = $this->TransactionsModel->GetFreeCopydetails($fc_code);
        $this->load->view('/Transactions/free-copy-edit',$this->data);
    }
    public function PauseFreeCopy($fc_code){
        $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        $data=array('free_slno'=>$fc_code,
                    'free_status'=>CopyStatus::Paused
                    );
        echo $this->TransactionsModel->PauseFreeCopy($data);
    }
    public function RestartFreeCopy($fc_code){
        $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        $data=array('free_slno'=>$fc_code,
                    'free_status'=>CopyStatus::Started
                    );
        echo $this->TransactionsModel->RestartFreeCopy($data);
    }
    public function StopFreeCopy($fc_code){
        $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        $data=array('free_slno'=>$fc_code,
                    'free_status'=>CopyStatus::Stopped
                    );
        echo $this->TransactionsModel->StopFreeCopy($data);
    }
    public function DeleteFreeCopy($fc_code){
        $fc_code = Enum::encrypt_decrypt(Encode::Decrypt,$fc_code, $this->encryption_key);
        $data=array('free_slno'=>$fc_code,
                   'cancel_flag'=>'1',
                   'modified_by'=>$this->user->user_id,
                   'modified_date'=>date('Y-m-d H:i:s')
                   );
        echo $this->TransactionsModel->DeleteFreeCopy($data);
    }

    //InitiateAmendments
    public function InitiateAmendments() {
        $this->data["finalize_date"] = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Amendment);
        $this->load->view('Transactions/initiate-amendments', $this->data);
    }
    public function TriggerInitiateAmendments() {
        $response = $this->TransactionsModel->TriggerInitiateAmendments();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/InitiateAmendments', 'refresh');
    }

    //FinalizeAmendments
    public function FinalizeAmendments(){
        $this->data["finalize_date"] = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Amendment);
        $this->load->view('/Transactions/finalize-amendments',$this->data);
    }
    public function CreateFinalizeAmendments(){
        $response=$this->TransactionsModel->CreateFinalizeAmendments();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/FinalizeAmendments', 'refresh');
    }
    public function RevertFinalizeAmendments(){
        $response=$this->TransactionsModel->RevertFinalizeAmendments();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/FinalizeAmendments', 'refresh');
    }

    //WeekdayAmendments
    public function WeekdayAmendments()
    {
        if(isset($_GET['g_fe'])) {
            $this->data["records"]=$this->TransactionsModel->WeekdayAmendmentsLists();
        }
        else {
            $this->data["records"]=array();
        }
        $this->load->view('Transactions/weekday-amendments', $this->data);
    }
    public function CreateWeekdayAmendments() {
        $this->data["code"] = $this->TransactionsModel->ViewPrimaryId('WDA_'.$this->user->user_unit_code.'_CODE');
        $this->load->view('Transactions/weekday-amendments-create', $this->data);
    }
    public function EditWeekdayAmendments() {
        $wa_code = base64_decode($_GET['g_fe']);
        if($wa_code) {
            $this->data["code"] = $wa_code;
            $this->data["records"]=$this->TransactionsModel->WeekdayAmendmentsDetails($wa_code);
            $this->load->view('Transactions/weekday-amendments-edit', $this->data);
        }
    }
    public function UpsertWeekdayAmendments()
    {
        $is_update  = (int)$this->input->post('is_update',true);
        $wa_code = $this->input->post('wa_code',true);
        $response   = $this->TransactionsModel->UpsertWeekdayAmendments();
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($is_update === 0 && $wa_code) {
            redirect('/Transactions/CreateWeekdayAmendments', 'refresh');
        }
        else {
            redirect('/Transactions/EditWeekdayAmendments?g_fe='.base64_encode($wa_code), 'refresh');
        }
    }
    public function ManageWeekdayAmendmentsStatus()
    {
        echo json_encode($this->TransactionsModel->ManageWeekdayAmendmentsStatus());
    }   

    //Other Receipt PDC
    public function OtherReceiptsPDC(){
        $finalize_date = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        $this->data["sch_rcpt_records"]=$this->TransactionsModel->GetOtherReceiptsPDC(date("Y-m-d",strtotime($finalize_date)));
        $this->data["en_key"] = $this->encryption_key;
        $this->load->view('Transactions/other-receipt-pdc', $this->data);
    }
    public function CreateOtherReceiptsPDC(){
        $finalize_date = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        $this->data["pdc_rcpt_code"] = $this->TransactionsModel->ViewPrimaryId('SPDC_'.$this->user->user_unit_code.'_CODE');
        $this->data["pdc_rcpt_dte"] = $finalize_date?date("d-m-Y", strtotime($finalize_date."+2 day")):date("d-m-Y");
        $this->load->view('Transactions/other-receipt-pdc-create', $this->data);
    }
    public function UpsertOtherReceiptsPDC(){
        $response = $this->TransactionsModel->UpsertOtherReceiptsPDC();
        $this->session->set_flashdata('flash_message', json_encode($response));
        redirect('/Transactions/OtherReceiptsPDC', 'refresh');
    }
    public function ViewOtherReceiptsPDC($sch_rcpt_code)
    {
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $this->data["sch_rcpt_details"]=$this->TransactionsModel->GetOtherReceiptPDCDetails($sch_rcpt_code);
        $this->load->view('Transactions/other-receipt-pdc-view', $this->data);
    }
    public function UpdateOtherReceiptsPDC($sch_rcpt_code)
    {
        $this->data["sch_rcpt_code"]=$sch_rcpt_code;
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $this->data["sch_rcpt_details"]=$this->TransactionsModel->GetOtherReceiptPDCDetails($sch_rcpt_code);
        $this->load->view('Transactions/other-receipt-pdc-edit', $this->data);
    }
    public function DeleteOtherReceiptsPDC($sch_rcpt_code)
    {
        $sch_rcpt_code = Enum::encrypt_decrypt(Encode::Decrypt,$sch_rcpt_code, $this->encryption_key);
        $data=array('pdc_no'=>$sch_rcpt_code,
                    'cancel_flag'=>'1',
                    'modified_by'=>$this->user->user_id,
                    'modified_date'=>date('Y-m-d H:i:s')
                    );
        echo $this->TransactionsModel->DeleteOtherReceiptsPDC($data);
    }

    //Transfer Other PDC
    public function TransferOtherPDC(){
        $this->data["other_pdc_records"] = array();
        if(isset($_POST["search"])){
            $this->data["other_pdc_records"] = $this->TransactionsModel->GetOtherPDCheques(date("Y-m-d",strtotime($_POST["pdc_dte"])));
        }
        $this->load->view('Transactions/transfer-other-pdc', $this->data);
    }
    public function StartTransferOtherPDC(){
        echo $this->TransactionsModel->StartTransferOtherPDC();
    }
    //Receipts
    public function Receipts()
    {
        if(isset($_GET['g_fe'])) {
            $date = date('Y-m-d',strtotime($this->input->post('created_date',true)));
        }
        else {
            $finalize_date = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
            $date  = date("Y-m-d",strtotime($finalize_date . ' +1 day'));
        }
        $this->data["rec_date"]=$date;
        $this->data["records"]=$this->TransactionsModel->ReceiptsLists($date);
        $this->load->view('Transactions/receipts', $this->data);
    }
    public function CreateReceipts() {
        $this->data["code"] = $this->TransactionsModel->ViewPrimaryId('REC_'.$this->user->user_unit_code.'_CODE');
        $this->data["finalize_date"] = $this->TransactionsModel->GetLastFinalizeDate($this->user->user_unit_code,$this->user->user_product_code,FinalizeType::Receipt);
        $this->load->view('Transactions/receipts-create', $this->data);
    }
    public function EditReceipts() {
        $code = base64_decode($_GET['g_fe']);
        if($code) {
            $this->data["code"] = $code;
            $this->data["records"]=$this->TransactionsModel->ReceiptsDetails($code);
            $this->load->view('Transactions/receipts-edit', $this->data);
        }
    }
    public function UpsertReceipts()
    {
        $is_update  = (int)$this->input->post('is_update',true);
        $code       = $this->input->post('code',true);
        $response   = $this->TransactionsModel->UpsertReceipts();
        $this->session->set_flashdata('flash_message', json_encode($response));
        if($is_update === 0) {
            redirect('/Transactions/CreateReceipts', 'refresh');
        }
        else {
            redirect('/Transactions/EditReceipts?g_fe='.base64_encode($code), 'refresh');
        }
    }
}
?>