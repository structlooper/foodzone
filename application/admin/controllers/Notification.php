<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Notification extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
    }
	public function index() {
        $where = array('n.status!='=>9, 'n.type'=>0);
        $columns = "n.*";
        $join = array();
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_NOTIFICATION.' as n', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
		$this->load->view('notification/index', $this->dataModule);
	}
	public function add(){
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('title', 'title', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['title']= urlencode($this->input->post('title'));
                $data_array['description']= urlencode($this->input->post('description'));
                $data_array['created']= $this->utc_time;
                $data_array['updated']= $this->utc_time;
            
                if($this->Sitefunction->insert(TBL_NOTIFICATION, $data_array)){
                    $notification_id= $this->db->insert_id();
                    $get_all_users= $this->Sitefunction->get_all_rows(TBL_USERS.' as u', "id", array('status'=>1), array(), array(), '', '', array(), "", array(), array());
                    foreach($get_all_users as $rows) {
                        $this->sendPushNotification($rows['id'], $notification_id);
                    }
                    
                    $this->session->set_flashdata('success', $this->lang->line('notification_added_successfully'));
                    redirect(NOTIFICATION_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        $this->load->view('notification/add',$this->dataModule);       
    }
	public function delete() {
		
        $this->Sitefunction->delete(TBL_NOTIFICATION, array('id'=>$this->input->get_post('id')));
        
    }
    
    public function multiple_delete() {
        $ids= $this->input->get_post('id');

        foreach($ids as $id){
            $this->Sitefunction->delete(TBL_NOTIFICATION, array('id'=>$id));
        }

    }

    public function edit($id) {
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_NOTIFICATION, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('title', 'title', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['title']= urlencode($this->input->post('title'));
                $data_array['description']= urlencode($this->input->post('description'));
                $data_array['updated']= $this->utc_time;
                
                if($this->Sitefunction->update(TBL_NOTIFICATION, $data_array, array('id'=>$id))){
                    $this->session->set_flashdata('success', $this->lang->line('notification_updated_successfully'));
                    redirect(NOTIFICATION_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        
        $this->load->view('notification/edit',$this->dataModule);  
    }
}
?>