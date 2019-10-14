<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'controllers/BaseController.php';

class Dashboard extends BaseController {

    private $child_setup_html = '';
    private $data_saved = array();
    protected $menu_rights = array("parent_menuitem"=>array(),"parent_menuname"=>array(),
                                    "parent_sub_menu"=>array(),"sub_menu"=>array());

	public function __construct()
	{
		parent::__construct();
        $this->load->model("DashboardModel");
	}
	
	public function index()
	{
        //By default load dashboard with saved menus        
        $this->data['favorites'] = $this->DashboardModel->getDashboard($this->user->user_id);
		$this->load->view('dashboard', $this->data);        
	}
	
	public function Setup()
	{
       $this->data_saved = $this->DashboardModel->getDashboardSetup($this->user->user_id);
       $this->data['setup_menu'] = $this->generateSetupHTML();
	   $this->load->view('dashboard-setup', $this->data);
	}

    //method to generate dashboard setup html
    protected function generateSetupHTML()
    {
        $menu_html = '';
        $root_menus = $this->getRootMenuItems();
        $steps = 1;
        foreach($root_menus as $item){
            //access permissions
            if(!in_array($item->menu_id,$this->menu_rights["parent_menuitem"]))
            {
                continue; //only group head allowed to access these pages
            }
            if(is_null($item->menu_link) && empty($item->menu_link)){//only if child for root exists
            $menu_html .= '<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12"><div class="box box-primary">
                  <div class="box-header"><h3 class="box-title"><strong>'.$item->menu_name.'</strong></h3>
                  <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div></div><div class="box-body">';
            $this->child_setup_html = '';
            $this->generateChildSetupHTML($item->menu_id);
            $menu_html .= $this->child_setup_html;
            $menu_html .= '</div></div></div>';
            if($steps%4 === 0) $menu_html .='<div class="col-lg-12"></div>';
            $steps++;
            }
        }
        return $menu_html;
    }

    //method to create dashboard setup child menus html
    private function generateChildSetupHTML($parent_menu_id)
    {
        $menu_rights = isset($this->menu_rights["parent_sub_menu"][$parent_menu_id]) ? $this->menu_rights["parent_sub_menu"][$parent_menu_id] : array();
        $child_menu_items = $this->getChildMenuItems($parent_menu_id);
        if(0 === sizeof($child_menu_items)) return; //no child menu exists.
        $this->child_setup_html .= '<table class="table table-hover table-responsive">';
        foreach($child_menu_items as $item){
            //..permissions ends
            if($menu_rights && in_array($item->menu_id,$menu_rights)){
                continue;
            }
            if(is_null($item->menu_link)){//if menu link is not there,then its a parent of few child menus.
                $this->child_setup_html .= '<tr><td colspan="2" style="border:none;"><strong>'.$item->menu_name.'</strong></td></tr><tr><td colspan="2" style="border:none;">';
                $this->generateChildSetupHTML($item->menu_id);
                $this->child_setup_html .= '</td></tr>';
            }else{//its already a child no recursive call required.
                if(in_array($item->menu_id, $this->data_saved))
                    $this->child_setup_html .= '<tr class="link menu-row"><td><input type="checkbox" checked  name="fav_menu[]" class="fav-chk" value="'.rawurlencode(json_encode($item)).'"></td><td>'.$item->menu_name.'</td></tr>';
                else
                    $this->child_setup_html .= '<tr class="link menu-row"><td><input type="checkbox"  name="fav_menu[]" class="fav-chk" value="'.rawurlencode(json_encode($item)).'"></td><td>'.$item->menu_name.'</td></tr>';

            }
        }
        $this->child_setup_html .= '</table>';
    }
    //save dashboard setup page
    public function createDashboardSetup()
	{
		$this->session->set_flashdata('MESSAGE', json_encode($this->DashboardModel->createDashboardSetup()));
		redirect('/Dashboard/Setup', 'refresh');
	}

}
