<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';
class MISReports extends BaseController {
	public function __construct() {
		parent::__construct();
		$this->load->model("MISReportsModel");		
	}
    public function index() {
	}
   //Plan for Copies Report
    public function PlanForCopies() 
    {
        $this->data["unit_lists"] = $this->MISReportsModel->GetUnits();
        $this->load->view('MISReports/plan-for-copies', $this->data);
    }
    public function PlanForCopiesSummary(){
        if(isset($_POST['show_summ']))
        {
            $this->data['copyplans_summ']=$this->MISReportsModel->GetCopiesPlansSummary();
        }
        $this->load->view('MISReports/plan-for-copies-summary', $this->data);
    }
    public function PlanForCopiesDetailed(){
        if(isset($_POST['show_detailed']))
        {
            $this->data['copyplans_details']=$this->MISReportsModel->GetCopiesPlansDetailed();
        }
        $this->load->view('MISReports/plan-for-copies-detailed', $this->data);
    }

    //Collection-Target
    public function CollectionTarget()
    {
        $this->data['units']=$this->MISReportsModel->GetUnits();
        $this->data['promoters']=$this->MISReportsModel->GetPromoters();
        $this->load->view('MISReports/collection-target', $this->data);
    }
    public function CollectionTargetSummary()
    {
        $this->load->view('MISReports/collection-target-summary', $this->data);
    }
    public function CollectionTargetDetailed()
    {
        $this->load->view('MISReports/collection-target-detailed', $this->data);
    }
    //Daily-Canvassed-Copies
    public function DailyCanvassedCopies()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->load->view('MISReports/daily-canvassed-copies', $this->data);
    }
    public function DailyCanvassedCopiesDetails()
    {
        $this->load->view('MISReports/daily-canvassed-copies-details', $this->data);
    }
    //Scheme Details Report
    public function SchemeDetails() 
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->data["unit_lists"] = $this->MISReportsModel->GetUnits();
        $this->load->view('MISReports/scheme-details', $this->data);
    }
    public function SchemeDetailsSummary(){
        if(isset($_POST['show_summ']))
        {
            $this->data['scheme_summ']=$this->MISReportsModel->GetSchemeSummary();
        }
        $this->load->view('MISReports/scheme-details-summary', $this->data);
    }
    public function SchemeDetailsDetailed(){
        if(isset($_POST['show_detailed']))
        {
            $this->data['scheme_details']=$this->MISReportsModel->GeSchemeDetailed();
        }
        $this->load->view('MISReports/scheme-details-detailed', $this->data);
    }
    //Cheque-Bounce-Monitor
    public function ChequeBounceMonitor()
    {
        $this->data['promoters']=$this->MISReportsModel->GetPromoters();
        $this->load->view('MISReports/cheque-bounce-monitor', $this->data);
    }
    public function ChequeBounceMonitorSummary()
    {
        $this->load->view('MISReports/cheque-bounce-monitor-summary', $this->data);
    }
    public function ChequeBounceMonitorDetailed()
    {
        $this->load->view('MISReports/cheque-bounce-monitor-detailed', $this->data);
    }
    //Other-Income-Monitor
    public function OtherIncomeMonitor()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->load->view('MISReports/other-income-monitor', $this->data);
    }
    //Monthly Income Split Report
    public function MonthlyIncomeSplit() 
    {
        $this->data["unit_lists"] = $this->MISReportsModel->GetUnits();
        $this->load->view('MISReports/monthly-income-split', $this->data);
    }
    public function MonthlyIncomeSplitDetailed(){
        if(isset($_POST['show_detailed']))
        {
            $this->data['monthinc_details']=$this->MISReportsModel->GeSchemeDetailed();
        }
        $this->load->view('MISReports/monthly-income-split-detailed', $this->data);
    }
    //Agent Details - 1 Day
    public function AgentCopyDetails()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->load->view('MISReports/agent-copy-details', $this->data);
    }
    //Scheme-Reports-Contributors-Non-Contributors
    public function SchemeReports()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->load->view('MISReports/scheme-reports', $this->data);
    }
    //copy-drop-chart
    public function CopyDropChart()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->data['promoters']=$this->MISReportsModel->GetPromoters();
        $this->load->view('MISReports/copy-drop-chart', $this->data);
    }
    public function CopyDropChartSummary()
    {
        $this->load->view('MISReports/copy-drop-chart-summary', $this->data);
    }
    public function CopyDropChartDetailed()
    {
        $this->load->view('MISReports/copy-drop-chart-detailed', $this->data);
    }
    //Ledger Summary
    public function LedgerSummary()
    {
        $this->load->view('MISReports/ledger-summary', $this->data);
    }
    //Agent PrintOrder
    public function AgentPrintOrder()
    {
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->load->view('MISReports/agent-print-order', $this->data);
    }
    //ente-kaumudi
    public function EnteKaumudy()
    {
        $this->load->view('MISReports/ente-kaumudi', $this->data);
    }
    public function EnteKaumudySummary()
    {
        $this->load->view('MISReports/ente-kaumudi-summary', $this->data);
    }
    public function EnteKaumudyDetailed()
    {
        $this->load->view('MISReports/ente-kaumudi-detailed', $this->data);
    }
    public function EnteKaumudySchools()
    {
        $this->load->view('MISReports/ente-kaumudi-schools', $this->data);
    }

    //CRM Scheme Reports
    public function CRMSchemeReports()
    {
        $this->load->view('MISReports/crm-scheme-reports', $this->data);
    }
    public function CRMTokenDetails()
    {
        $this->load->view('MISReports/crm-token-details', $this->data);
    }

    //Cumulative Receipt Summary
    public function CumulativeReceiptSummary()
    {
        $this->load->view('MISReports/cumulative-receipt-summary', $this->data);
    }
    public function CumulativeReceiptSummaryUnitwise()
    {
        $this->load->view('MISReports/cumulative-receipt-summary-unitwise', $this->data);
    }
    public function CumulativeReceiptSummaryMonthwise()
    {
        $this->load->view('MISReports/cumulative-receipt-summary-monthwise', $this->data);
    }
    //Bonus Analysis
    public function BonusAnalysis()
    {
        $this->data["bill_period"] = $this->MISReportsModel->GetLatestBillingPeriod();
        $this->load->view('MISReports/bonus-analysis', $this->data);
    }
    public function BonusAnalysisSummary()
    {
        $this->load->view('MISReports/bonus-analysis-summary', $this->data);
    }
    public function BonusAnalysisDetailed()
    {
        $this->load->view('MISReports/bonus-analysis-detailed', $this->data);
    }
    //Monthly Evaluation
    public function MonthlyEvaluation()
    {
        $this->data["bill_period"] = $this->MISReportsModel->GetLatestBillingPeriod();
        $this->load->view('MISReports/monthly-evaluation', $this->data);
    }
    public function MonthlyEvaluationSummary()
    {
        $this->load->view('MISReports/monthly-evaluation-summary', $this->data);
    }
    public function MonthlyEvaluationDetailed()
    {
        $this->load->view('MISReports/monthly-evaluation-detailed', $this->data);
    }
    public function CRMReports() {
        $apply_unit_access = true;
        $this->data['user_records'] = $this->MISReportsModel->advtUserRecords($apply_unit_access);
        $this->load->view('MISReports/crm-report', $this->data);
    }
    public function CRMReportsDetails(){
        $apply_unit_access = false;
        $this->data['user_records'] = $this->MISReportsModel->advtUserRecords($apply_unit_access);
        $this->data['records'] = $this->MISReportsModel->crmDetailedReport();
        $this->load->view('MISReports/crm-report-details', $this->data);
    }
    public function SchemeCollectionSummary(){
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->data['scheme_rec'] = array();
        if(isset($_GET["g_fe"])){
            $this->data['scheme_rec'] = $this->MISReportsModel->GetSchemeCollectionSummary();
        }
        $this->load->view('MISReports/scheme-collection-summary', $this->data);
    }
    public function OtherReceiptSummary(){
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->data['scheme_rec'] = array();
        if(isset($_GET["g_fe"])){
            $this->data['scheme_rec'] = $this->MISReportsModel->GetOtherReceiptSummary();
        }
        $this->load->view('MISReports/other-receipt-summary', $this->data);
    }
    public function OtherReceiptsPDCSummary(){
        $this->data["copy_lists"] = $this->MISReportsModel->GetCopyMaster();
        $this->data['scheme_rec'] = array();
        if(isset($_GET["g_fe"])){
            $this->data['scheme_rec'] = $this->MISReportsModel->GetOtherReceiptsPDCSummary();
        }
        $this->load->view('MISReports/other-receipt-PDC-summary', $this->data);
    }
}
?>