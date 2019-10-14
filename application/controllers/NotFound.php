<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//include_once APPPATH . 'controllers/BaseController.php';
class NotFound extends CI_Controller  {  
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
	}
    public function Lost()
	{
        $this->load->view('404');
	}
}
