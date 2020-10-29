<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class State extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        $this->dataModule['country']= $this->Sitefunction->get_rows(TBL_COUNTRY, 'id, name', array('status'=>1));
	}
	public function index() {
        $where = array('s.status!='=>9);
        $columns = "s.*, c.name as country_name";
        $join = array(TBL_COUNTRY.' as c' => "c.id=s.country_id");
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_STATE.' as s', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
		$this->load->view('state/index', $this->dataModule);
	}
	public function add(){
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('country_id', 'country', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{

                $data_array['name']= urlencode($this->input->post('name'));
                $data_array['country_id']= $this->input->post('country_id');
                $data_array['created']= $this->utc_time;
                $data_array['updated']= $this->utc_time;
                
                if($this->Sitefunction->insert(TBL_STATE, $data_array)){
                    $this->session->set_flashdata('success', $this->lang->line('state_added_successfully'));
                    redirect(STATE_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
       
        $this->load->view('state/add',$this->dataModule);       
    }
	public function delete() {
		
        $this->Sitefunction->delete(TBL_STATE, array('id'=>$this->input->get_post('id')));
        
    }
    
    public function multiple_delete() {
        $ids= $this->input->get_post('id');

        foreach($ids as $id){
            $this->Sitefunction->delete(TBL_STATE, array('id'=>$id));
        }

    }

    public function edit($id) {
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_STATE, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('country_id', 'country', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['name']= urlencode($this->input->post('name'));
                $data_array['country_id']= $this->input->post('country_id');
                $data_array['updated']= $this->utc_time;
                
                $data_array['updated']=$this->utc_time;
                if($this->Sitefunction->update(TBL_STATE, $data_array, array('id'=>$id))){
                    $this->session->set_flashdata('success', $this->lang->line('state_updated_successfully'));
                    redirect(STATE_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
                
        }
        
        $this->load->view('state/edit',$this->dataModule);  
    }
}
?>