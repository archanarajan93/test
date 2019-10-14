<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
    public $encryption_key = "";
	public function __construct() {
		parent::__construct();
        $this->load->helper('Enum');
        $this->encryption_key = $this->config->item('encryption_key');
		$this->load->model("ApiModel");
        $this->load->library('App/Routes');
        $this->load->library('App/DBDriver');
        $this->DBDriver = new DBDriver();
        $this->isAuthenticated();
	}
	public function index() {
	}
    //authenticate user session
    protected function isAuthenticated()
    {   
        $user_session = $this->session->userdata("CIRSTAYLOGIN");
        if($user_session['user_id']) {             
            $this->user = (object)$user_session;            
        } else {
            echo json_encode(array("status"=>400,"text"=>"Error! Not Authenticated."));
        }
    } 
	public function endpoint()
	{
		if(isset($_GET['params'])) //get methods routed here
        {
            $routeId = $_GET['routeId'];
            $data = json_decode($_GET['params'], true);
            if($routeId == Routes::EMPLOYEEDETAILS)
            {
                $this->ApiModel->GetEmployeeDetails($data);
            }
            else if($routeId == Routes::ACMDETAILS)
            {
                $this->ApiModel->ACMDetails($data);
            }
            else if($routeId == Routes::PRODUCTGROUPS)
            {
                $this->ApiModel->ProductGroups($data);
            }
	    else if($routeId == Routes::TEAMMEMBER)
            {
                $this->ApiModel->GetTeamMembers($data);
            }
            else if($routeId == Routes::PROMOTER)
            {
                $this->ApiModel->GetPromoters($data);
            }
            else if($routeId == Routes::ACM)
            {
                $this->ApiModel->GetACM($data);
            }
            else if($routeId == Routes::BUREAU)
            {
                $this->ApiModel->GetBureau($data);
            }
            else if($routeId == Routes::UNION)
            {
                $this->ApiModel->GetUnion($data);
            }
            else if($routeId == Routes::SHAKHA)
            {
                $this->ApiModel->GetShakha($data);
            }
            else if($routeId == Routes::EDITION)
            {
                $this->ApiModel->GetEdition($data);
            }
            else if($routeId == Routes::ROUTE)
            {
                $this->ApiModel->GetRoute($data);
            }
            else if($routeId == Routes::DROPPINGPOINT)
            {
                $this->ApiModel->GetDroppingPoint($data);
            }
	    else if($routeId == Routes::UNITS)
            {
                $this->ApiModel->GetUnits($data);
            }
            else if($routeId == Routes::COPYTYPE)
            {
                $this->ApiModel->GetCopyTypes($data);
            }
            else if($routeId == Routes::COPYGROUP)
            {
                $this->ApiModel->GetCopyGroup($data);
            }
            else if($routeId == Routes::MONTH)
            {
                $this->ApiModel->GetMonths();
            }
            else if($routeId == Routes::AGENTMASTER)
            {
                $this->ApiModel->GetAgentMaster($data);
            }
            else if($routeId == Routes::PRODUCTS)
            {
                $this->ApiModel->GetProducts($data);
            }
            else if($routeId == Routes::BILLINGPERIOD || $routeId == Routes::BILLINGPERIODTO)
            {
                $this->ApiModel->GetBillingPeriod($data);
            }
            else if($routeId == Routes::REGION)
            {
                $this->ApiModel->GetRegions($data);
            }
            else if($routeId == Routes::AGENTGROUPS)
            {
                $this->ApiModel->GetAgentGroups($data);
            }
            else if($routeId == Routes::SUBSCRIBERS)
            {
                $this->ApiModel->GetSubscribers($data);
            }
            else if($routeId == Routes::FINALSTATUS)
            {
                $this->ApiModel->GetFinalStatus($data);
            }
            else if($routeId == Routes::AMENDMENTTYPE)
            {
                $this->ApiModel->GetAmendmentType($data);
            }
            else if($routeId == Routes::RESIDENCEASSOCIATION)
            {
                $this->ApiModel->GetResidenceAssociations($data);
            }
            else if($routeId == Routes::WELLWISHER)
            {
                $this->ApiModel->GetWellwishers($data);
            }
	         else if($routeId == Routes::RESPONSEHEAD)
            {
                $this->ApiModel->GetResponseHead($data);
            }
            else if($routeId == Routes::STATUS)
            {
                $this->ApiModel->GetEntryStatus($data);
            }
	    else if($routeId == Routes::EVENTS)
            {
                $this->ApiModel->GetEvents($data);
            }
	    else if($routeId == Routes::DEPARTMENT)
            {
                $this->ApiModel->department($data);
            }
            else if($routeId == Routes::ENTRYTYPE)
            {
                $this->ApiModel->entryType($data);
            }
	    else if($routeId == Routes::AMENDMENTREASON)
            {
                $this->ApiModel->GetAmendmentReason($data);
            }
        else if($routeId == Routes::PACKETREASON)
            {
                $this->ApiModel->GetPacketsDiary($data);
            }
            else if($routeId == Routes::COPYTYPEALL)
            {
                $this->ApiModel->GetCopyTypesAll($data);
            }
            else if($routeId == Routes::ACCOUNTHEAD)
            {
                $this->ApiModel->GetAccountHead($data);
            }
            else if($routeId == Routes::SPONSORCLIENTS)
            {
                $this->ApiModel->GetSponsorClients($data);
            }
            else if($routeId == Routes::SCHEMESUBSCRIBER)
            {
                $this->ApiModel->GetSchemeSubscribers($data);
            }
            else if($routeId == Routes::BANKMASTER)
            {
                $this->ApiModel->GetBanks($data);
            }
            else if($routeId == Routes::TEMPRECEIPT)
            {
                $this->ApiModel->GetTempReceipts($data);
            }
            else if($routeId == Routes::SCHEME)
            {
                $this->ApiModel->GetSchemes($data);
            }
            else if($routeId == Routes::COPYMASTER)
            {
                $this->ApiModel->GetCopyMaster($data);
            }
        }
    }
}
