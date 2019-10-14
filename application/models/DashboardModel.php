<?php
class DashboardModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    /**
     * @abstract save new menu items
     * @return object message
     */
	public function createDashboardSetup()
	{
        //clear all user dashboard
        $this->deleteUserDashboard($this->user->user_id);
        //then add new setup
        $data = array();
		$now = date('Y-m-d H:i:s');
        $input_post = $this->input->post('fav_menu');
        if(sizeof($input_post) == 0){
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('updated_success');
            return $this->Message;
        }
        foreach($input_post as $post){
            $post_decoded = json_decode(rawurldecode($post), true);
            $data[] = array(
                'menu_id'   => $post_decoded['menu_id'],
                'menu_user_id' => $this->user->user_id,
                'menu_name' => $post_decoded['menu_name'],
                'menu_link' => $post_decoded['menu_link'],
                'menu_icon' => $post_decoded['menu_icon'],
                'created_date' => $now                
                );
        }
        if($this->db->insert_batch('pmd_dashboard', $data))
        {
            $this->Message->status=200;
            $this->Message->text=$this->lang->line('added_success');
        }else {
            $this->Message->status=400;
            $this->Message->text=$this->lang->line('error_processing');
        }
        return $this->Message;
	}
    /**
     * @abstract saved menu ids
     * @param mixed $user_id 
     * @return array
     */
    public function getDashboardSetup($user_id)
	{
        $menu_ids = array();
        $this->db->select("menu_id");
        $this->db->from('pmd_dashboard');
        $this->db->where('menu_user_id', $user_id);
        $query = $this->db->get(); 
        foreach ($query->result() as $row) {
            $menu_ids[] = $row->menu_id;
        }
        return $menu_ids;
	}
    /**
     * @abstract saved menu items
     * @param mixed $user_id
     * @return array
     */
    public function getDashboard($user_id)
	{
        $this->db->select("menu_id,menu_name,menu_link,menu_icon");
        $this->db->from('pmd_dashboard');
        $this->db->where('menu_user_id', $user_id);
        $this->db->order_by('menu_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
	}
    /**
     * @abstract delete menu items
     * @param mixed $user_id
     */
    private function deleteUserDashboard($user_id)
    {
        $this->db->where('menu_user_id', $user_id);
        $this->db->delete('pmd_dashboard');
    }    
}