<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Owners extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        $this->dataModule['country']= $this->Sitefunction->get_rows(TBL_COUNTRY, 'id, name', array('status'=>1));
      
	}
	public function index() {
        $where = array('o.status!='=>9);
        $columns = "o.*, s.name as state_name, ct.name as city_name, c.name as country_name";
        $join = array(TBL_STATE.' as s' => "s.id=o.state_id", TBL_CITY.' as ct'=> "ct.id=o.city_id", TBL_COUNTRY." as c" => "c.id=o.country_id");
        $group_by = 'o.id';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_OWNERS.' as o', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
        
		$this->load->view('owners/index', $this->dataModule);
	}
	
	public function delete() {
		
        $this->Sitefunction->delete(TBL_OWNERS, array('id'=>$this->input->get_post('id')));
        
    }
    
    public function multiple_delete() {
        $ids= $this->input->get_post('id');

        foreach($ids as $id){
            $this->Sitefunction->delete(TBL_OWNERS, array('id'=>$id));
        }

    }

    public function add(){
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('first_name', 'first name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('last_name', 'last name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('phone_number', 'phone', 'required|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('password', 'password', 'required|min_length[5]');
            $this->form_validation->set_rules('city_id', 'city', 'required');
            $this->form_validation->set_rules('state_id', 'state', 'required');
            $this->form_validation->set_rules('country_id', 'country', 'required');
            $this->form_validation->set_rules('pincode', 'pincode', 'required|min_length[5]|max_length[7]');
            $this->form_validation->set_rules('address', 'address', 'required|min_length[10]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['first_name']=urlencode($this->input->post('first_name'));
                $data_array['last_name']=urlencode($this->input->post('last_name'));
                $data_array['phone']=$this->input->post('phone_number');
                $data_array['email']=urlencode($this->input->post('email_id'));
                $data_array['city_id']=$this->input->post('city_id');
                $data_array['state_id']=$this->input->post('state_id');
                $data_array['country_id']=$this->input->post('country_id');
                $data_array['pincode']=$this->input->post('pincode');
                $data_array['password']=md5($this->input->post('password'));
                $data_array['address']=urlencode($this->input->post('address'));
                $data_array['created']=$this->utc_time;
                $data_array['updated']=$this->utc_time;
               if($this->Sitefunction->insert(TBL_OWNERS, $data_array)){
                    $this->session->set_flashdata('success', $this->lang->line('owner_added_successfully'));
                    redirect(OWNER_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        $this->load->view('owners/add',$this->dataModule);       
    }

    public function edit($id){
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_OWNERS, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('first_name', 'first name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('last_name', 'last name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('phone_number', 'phone', 'required|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('email_id', 'email', 'required|valid_email|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('city_id', 'city', 'required');
            $this->form_validation->set_rules('state_id', 'state', 'required');
            $this->form_validation->set_rules('country_id', 'country', 'required');
            $this->form_validation->set_rules('pincode', 'pincode', 'required|min_length[5]|max_length[7]');
            $this->form_validation->set_rules('address', 'address', 'required|min_length[10]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['first_name']=urlencode($this->input->post('first_name'));
                $data_array['last_name']=urlencode($this->input->post('last_name'));
                $data_array['phone']=$this->input->post('phone_number');
                $data_array['email']=urlencode($this->input->post('email_id'));
                $data_array['city_id']=$this->input->post('city_id');
                $data_array['state_id']=$this->input->post('state_id');
                $data_array['country_id']=$this->input->post('country_id');
                $data_array['pincode']=$this->input->post('pincode');
                $data_array['address']=urlencode($this->input->post('address'));
                if(trim($this->input->post('password'))) {
                    $data_array['password']=md5($this->input->post('password'));
                }
                $data_array['updated']=$this->utc_time;
                if($this->Sitefunction->update(TBL_OWNERS, $data_array, array('id'=>$id))){
                    $this->session->set_flashdata('success', $this->lang->line('owner_updated_successfully'));
                    redirect(OWNER_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        $this->dataModule['state']= $this->Sitefunction->get_rows(TBL_STATE, 'id, name', array('status'=>1, 'country_id'=>$this->dataModule['results']->country_id));
        $this->dataModule['city']= $this->Sitefunction->get_rows(TBL_CITY, 'id, name', array('status'=>1, 'state_id'=>$this->dataModule['results']->state_id));
        $this->load->view('owners/edit',$this->dataModule);       
    }

    function getState() {
        $country_id= $this->input->get_post('country_id');
        $getstate= $this->Sitefunction->get_rows(TBL_STATE, 'id, name', array('status'=>1, 'country_id'=>$country_id));
        $result= '<option value="">'.$this->lang->line('select_state').'</option>';
        foreach($getstate as $value) {
            $result.='<option value="'.$value['id'].'">'.urldecode($value['name']).'</option>';
        }
        echo $result;
    }
    function getCity() {
        $state_id= $this->input->get_post('state_id');
        $getcity= $this->Sitefunction->get_rows(TBL_CITY, 'id, name', array('status'=>1, 'state_id'=>$state_id));
        $result= '<option value="">'.$this->lang->line('select_city').'</option>';
        foreach($getcity as $value) {
            $result.='<option value="'.$value['id'].'">'.urldecode($value['name']).'</option>';
        }
        echo $result;
    }
}
?>