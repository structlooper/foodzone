<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
      
	}
	public function index() {
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_OWNERS, '*', array('id'=>$this->user_id));
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('first_name', 'first name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('last_name', 'last name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email|min_length[5]|max_length[125]');
            $this->form_validation->set_rules('phone', 'phone', 'required|min_length[10]|max_length[12]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{

                $data_array['first_name']=urlencode($this->input->post('first_name'));
                $data_array['last_name']=urlencode($this->input->post('last_name'));
                $data_array['email']=urlencode($this->input->post('email'));
                $data_array['phone']=$this->input->post('phone');
                if(isset($_FILES['image']) && $_FILES['image'] != '')
                {
                    
        
                    
                        $randdom= round(microtime(time()*1000)).rand(000, 999);
                        $file_extension1 =pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                        $p_profile_image1= $randdom.'.'.$file_extension1;
                        if ($_FILES["image"]["error"] > 0) { 
                            $p_profile_image1=$this->dataModule['results']->image;
                        } else {
                            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH.'owners/'. $p_profile_image1);
                                            
                        }
                    
                    
                    
                }else {
                    $p_profile_image1=$this->dataModule['results']->image;
                }
                $data_array['image']=$p_profile_image1;
                $data_array['updated']=$this->utc_time;
                if($this->Sitefunction->update(TBL_OWNERS, $data_array, array('id'=>$this->user_id))){
                    $this->session->set_flashdata('success', $this->lang->line('profile_updated_successfully'));
                    redirect(PROFILE_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
		$this->load->view('profile/change_profile', $this->dataModule);
	}
	
	

    public function change_password(){
        $this->dataModule['results']=  $this->Sitefunction->get_single_row(TBL_OWNERS, '*', array('id'=>$this->user_id));
        if(empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
           
            $this->form_validation->set_rules('old_password', 'old password', 'required|min_length[5]|max_length[125]');
            $this->form_validation->set_rules('new_password', 'new password', 'required|min_length[5]|max_length[125]');
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'required|min_length[5]|max_length[125]|matches[new_password]');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $old_password= $this->input->post('old_password');
                $new_password= $this->input->post('new_password');
                $confirm_password= $this->input->post('confirm_password');

                $check_password= $this->Sitefunction->get_single_row(TBL_OWNERS, '*', array('password'=>md5($old_password)));
                if(!empty($check_password)) {
                    if($new_password==$confirm_password) {
                        $data_array['password']=md5($this->input->post('new_password'));
                        $data_array['updated']=$this->utc_time;
                        if($this->Sitefunction->update(TBL_OWNERS, $data_array, array('id'=>$this->user_id))){
                            $this->session->set_flashdata('success', $this->lang->line('password_updated_successfully'));
                            redirect(PROFILE_PATH.'/change_password');
                        }else {
                            $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                        }
                    }else {
                        $this->session->set_flashdata('error', $this->lang->line('confirm_password_same_as_new_password'));
                    }
                    

                }else {
                    $this->session->set_flashdata('error', $this->lang->line('old_password_invalid'));
                }
            }
            
            
        }
         
        $this->load->view('profile/change_password',$this->dataModule);       
    }

    public function change_language ($lang, $lang_short) {

        $data= array('lang'=>$lang,'lang_short'=>$lang_short);
        $this->session->set_userdata($data);
        redirect(DASHBOARD_PATH);
        

    }
   
}
?>