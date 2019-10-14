<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller { 
    /**
	 * Parent controller
     * Description: menu rendering, permission settings, 
     * common methods.     
	 */
    protected $menu_items    = array();
    public $permissions   = array();
    protected $menu_rights   = array("parent_menuitem"=>array(),"parent_menuname"=>array(),"parent_sub_menu"=>array(),"sub_menu"=>array()); 
    private $child_menu_html = '';
    public $user    = null;
    public $nt_year = null;
    public $Message = null;
    public $default_theme = "skin-blue";
    /*
     * Constructor function:
     * Description: To initailise the member variables
     *
     */
    public function __construct()
	{ 		
	parent::__construct();
        $this->load->helper('Enum');
        $this->load->helper('SeedData');        
        $this->isAuthenticated();                
        $this->loadMenuItems();
        $this->MenuItemsAuthorized();//access menu permissions
        $this->getAccessPermissions();
        $this->isAuthorized();        
        $this->load->library('App/Message');
        $this->load->library('App/DBDriver');         
        $this->createProcedures();
        $this->Message = new Message();
        $this->DBDriver = new DBDriver();
        $this->data['menu'] = $this->generateMenuHTML();
        $this->data['upload_path'] = $this->config->item("upload_path");
	}  
    //authenticate user session
    protected function isAuthenticated()
    {   
        $user_session = $this->session->userdata("CIRSTAYLOGIN");
        if($user_session['user_id']) {             
            $this->user = (object)$user_session;            
        } else {
            redirect('/', 'refresh');
        }
    } 
    //method to get access permissions
    private function getAccessPermissions()
    {
        if(!(isset($_SESSION['CIRCPERMISSIONS']) && ($this->permissions = $_SESSION['CIRCPERMISSIONS']))) //no access rights in session
        {
            $this->permissions = $this->BaseModel->getPermissions($this->user->user_id, $this->user->user_unit_code, $this->user->user_product_code);
            $this->session->set_userdata('CIRCPERMISSIONS', $this->permissions);
        }
    }
    //method to generate menu html
    protected function generateMenuHTML()
    {
        $menu_html = '';
        $root_menus = $this->getRootMenuItems();
        foreach($root_menus as $item){
            if(!in_array($item->menu_id,$this->menu_rights["parent_menuitem"]))
            {
                continue; 
            }
            $menu_link = is_null($item->menu_link) ? '#' : base_url($item->menu_link);
            $menu_html .= '<li class="treeview">
                           <a href="'.$menu_link.'"><i class="fa '.$item->menu_icon.'"></i> <span>'.$item->menu_name.'</span>';
            $this->child_menu_html = '';
            $this->generateChildMenuHTML($item->menu_id);
            $menu_html.=$this->child_menu_html !== '' ? '<i class="fa fa-angle-left pull-right"></i></a>' : '</a>';
            $menu_html .= $this->child_menu_html;
            $menu_html .= '</li>';
        }
        return $menu_html;
    }
    //method to get root level menu items
    protected function getRootMenuItems()
    {
        $root_menu_items = array();
        foreach($this->menu_items as $item){
            if(is_null($item->menu_parent_id) || empty($item->menu_parent_id))
                $root_menu_items[] = $item;
        }
        return $root_menu_items;
    }
    //method to get child level menu items
    protected function getChildMenuItems($parent_menu_id)
    {
        $child_menu_items = array();
        foreach($this->menu_items as $item){
            if($item->menu_parent_id && $item->menu_parent_id === $parent_menu_id)
                $child_menu_items[] = $item;
        }
        return $child_menu_items;
    }
    //method to create child menus html
    private function generateChildMenuHTML($parent_menu_id)
    {
        $menu_rights = isset($this->menu_rights["parent_sub_menu"][$parent_menu_id]) ? $this->menu_rights["parent_sub_menu"][$parent_menu_id] : array();
        $child_menu_items = $this->getChildMenuItems($parent_menu_id);
        if(0 === sizeof($child_menu_items)) return; //no child menu exists.
        $this->child_menu_html .= '<ul class="treeview-menu" style="display:none;top:41px;">';
        foreach($child_menu_items as $item){
            //access permissions
            /*if(($item->menu_id == '16' || $item->menu_id == '14'|| $item->menu_id == '19'|| $item->menu_id == '115') && $this->user->user_id != $this->user->grouphead_user_id) {
                continue;
                //only group head allowed to access these pages
            }
            //..permissions ends
            if($menu_rights && in_array($item->menu_id,$menu_rights)){
                continue;
            }*/
            if(is_null($item->menu_link)){//if menu link is not there,then its a parent of few child menus.
                $this->child_menu_html .= '<li><a href="#"><i class="fa '.$item->menu_icon.'"></i>'.$item->menu_name.'<i class="fa fa-angle-left pull-right"></i></a>';
                $this->generateChildMenuHTML($item->menu_id);
                $this->child_menu_html .= '</li>';
            }else{//its already a child no recursive call required.
                $this->child_menu_html .= '<li><a href="'.base_url($item->menu_link).'"><i class="fa '.$item->menu_icon.'"></i>'.$item->menu_name.'</a></li>';
            }
        }
        $this->child_menu_html .= '</ul>';
    }
    //method to load menu items array
    private function loadMenuItems()
    {
        if(isset($_SESSION['NTMENU'])) $this->menu_items = @json_decode($_SESSION['NTMENU']);
        if(0 == count($this->menu_items)) //no menu in session
        {
            $this->load->model("BaseModel");
            $this->menu_items = $this->BaseModel->getMenuItems();
            $this->session->set_userdata('NTMENU', json_encode($this->menu_items));
        }
    }    
    //create all necessary procedures
    private function createProcedures()
    {
        $this->load->model("Procedures");
    }
	 //is authorized to access this.
    protected function isAuthorized()
    {
        return true; 

        //if($this->permissions[0] == '%') return; //all privileges
        $route = strtolower($this->uri->uri_string);
        $route_parts = explode("/", $route);        
        /* url address to block without authorized menu items    start here */ 
        $url_address = $this->uri->uri_string ? explode("/",$this->uri->uri_string) : array();
        if(!in_array($url_address[0],preg_replace('/\s+/', '',$this->menu_rights["parent_menuname"])) && !(in_array("Pages",preg_replace('/\s+/', '',$this->menu_rights["parent_menuname"])) && $url_address[0] == 'Epaper')) {
            $this->session->set_flashdata('NTACCESS', 'You have no permission to access this');
            redirect('Dashboard?access=403', 'refresh');
        }else{
            if((isset($this->menu_rights["sub_menu"][$route_parts[0]]) && in_array($route,$this->menu_rights["sub_menu"][$route_parts[0]])) ||
                (isset($this->menu_rights["sub_menu"][$route_parts[0]]) && ($route == "digitallibrary/gallerysearchmodal" || $route == "digitallibrary/searchgallery") && in_array("digitallibrary/manage",$this->menu_rights["sub_menu"][$route_parts[0]]))){
                $this->session->set_flashdata('NTACCESS', 'You have no permission to access this');
                redirect('Dashboard?access=403', 'refresh');
            }
        }
        /* url address to block without authorized menu items    end */

        if($route == 'news/groupbin' && in_array('M.1',$this->permissions))
        {
            $this->session->set_flashdata('NTACCESS', 'You have no permission to access this.');
            redirect('Dashboard?access=403', 'refresh');
        }
    }
    public function getTZDateTime($date_time=null, $format=null){
        $tz = new DateTimeZone($_COOKIE["USERTZ"]?$_COOKIE["USERTZ"]:$this->config->item("default_tz"));
        $date = new DateTime($date_time ? $date_time : "now");
        $date->setTimezone($tz);
        return $date->format($format ? $format : "d-M-Y H:i:s");
    }
	public function sendEmail($from_email,$to_email,$subject,$template_name,$from_name, $tmpl_data=array()) {
        $response = new Message();
        $configemail = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'arunch.kaumudi@gmail.com',
        'smtp_pass' => '8891823491',
        'mailtype'  => 'html', 
        'charset'   => 'iso-8859-1'
        );
        $CI =& get_instance();

        $CI->load->library('email', $configemail);

        $CI->email->initialize($configemail);
        $CI->email->set_newline("\r\n");

        $CI->email->from($from_email,$from_name); 
        $CI->email->to($to_email); 

        $CI->email->subject($subject);
        $msg_body = $this->load->view('emails/'.$template_name.'.php',$tmpl_data,TRUE);
        $CI->email->message($msg_body);      
        if($CI->email->send()) 
        {
            $response->status=200;
            $response->text="We have sent an email to your registered email address";
        }
        else
        {
            $response->status=400;
            $response->text="Error occured in sending email";
        }
        return json_encode($response);
   }     
    public function MenuItemsAuthorized()
    {
        $this->load->model("BaseModel");
        $parent_menuitem=$parent_menuname=$sub_menu=$parent_sub_menu=array();
        $itemRecords=$this->BaseModel->getMenuItemsLoginUsers();
        foreach($itemRecords as $list_items)
        {
            if($list_items->menu_link){
                $split_item = explode("/",$list_items->menu_link);
                $sub_menu[$split_item[0]][] = $list_items->menu_link;
                $parent_sub_menu[$list_items->menu_parent_id][] = $list_items->sub_menu_id;
            }else{
                $parent_menuitem[]=$list_items->menu_id;
                $parent_menuname[]=$list_items->menu_name;
            }
        }
        //Default Dashboard
        if(!in_array('1',$parent_menuitem))
        { 
            array_push($parent_menuitem,"1");
        }
        if(!in_array('Profiles',$parent_menuname)){
            array_push($parent_menuname,"Profiles");
            if(!in_array('Dashboard',$parent_menuname))
            {
                array_push($parent_menuname,"Dashboard");
            }
        }

        $this->menu_rights=array("parent_menuitem"=>$parent_menuitem,
                       "parent_menuname"=>$parent_menuname,
                        "parent_sub_menu"=> $parent_sub_menu,
                        "sub_menu" => $sub_menu);
    } 
    private function userLogout(){
        $this->load->model("AuthModel");        
        $this->session->unset_userdata('CIRSTAYLOGIN');
        $this->session->set_flashdata('loginstatus', 'logout_success');
        $this->session->sess_destroy();
        redirect('/');
    }
}
