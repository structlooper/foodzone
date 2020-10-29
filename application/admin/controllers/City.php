<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class City extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        $this->dataModule['state']= $this->Sitefunction->get_rows(TBL_STATE, 'id, name', array('status'=>1));
	}
	public function index() {
        $where = array('c.status!='=>9);
        $columns = "c.*, s.name as state_name";
        $join = array(TBL_STATE.' as s' => "s.id=c.state_id");
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_CITY.' as c', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
		$this->load->view('city/index', $this->dataModule);
	}
	public function add(){
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'city name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('state_id', 'state', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['name']= urlencode($this->input->post('name'));
                $data_array['state_id']= $this->input->post('state_id');
                $data_array['created']= $this->utc_time;
                $data_array['updated']= $this->utc_time;
                
                if($this->Sitefunction->insert(TBL_CITY, $data_array)){
                    $this->session->set_flashdata('success', $this->lang->line('city_added_successfully'));
                    redirect(CITY_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
       
        $this->load->view('city/add',$this->dataModule);       
    }
	public function delete() {
		
        $this->Sitefunction->delete(TBL_CITY, array('id'=>$this->input->get_post('id')));
        
    }
    
    public function multiple_delete() {
        $ids= $this->input->get_post('id');

        foreach($ids as $id){
            $this->Sitefunction->delete(TBL_CITY, array('id'=>$id));
        }

    }

    public function edit($id) {
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_CITY, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'city name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('state_id', 'state', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['name']= urlencode($this->input->post('name'));
                $data_array['state_id']= $this->input->post('state_id');
                $data_array['updated']= $this->utc_time;
                
                $data_array['updated']=$this->utc_time;
                if($this->Sitefunction->update(TBL_CITY, $data_array, array('id'=>$id))){
                    $this->session->set_flashdata('success', $this->lang->line('city_updated_successfully'));
                    redirect(CITY_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        
        $this->load->view('city/edit',$this->dataModule);  
    }
}
?>