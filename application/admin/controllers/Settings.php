<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Settings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
      
	}
	public function index() {
        $where = array('status'=>1);
        $columns = "";
        $join = array();
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_SETTINGS, $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
        
		$this->load->view('settings/index', $this->dataModule);
	}
	
	

    public function edit($id){
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_SETTINGS, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {

            $data_array['website_name']=urlencode($this->input->post('website_name'));
            $data_array['map_api_key']=$this->input->post('map_api_key');
            $data_array['email']=urlencode($this->input->post('email'));
            $data_array['phone']=$this->input->post('phone');
            $data_array['smtp_host']=$this->input->post('smtp_host');
            $data_array['smtp_port']=$this->input->post('smtp_port');
           $data_array['smtp_username']=urlencode($this->input->post('smtp_username'));
           $data_array['smtp_password']=$this->input->post('smtp_password');
           $data_array['smpt_from_email']=urlencode($this->input->post('smpt_from_email'));
           $data_array['smtp_from_name']=urlencode($this->input->post('smtp_from_name'));
            $data_array['fcm_key']=$this->input->post('fcm_key');
           $data_array['stripe_private_key']=$this->input->post('stripe_private_key');
           $data_array['stripe_publish_key']=$this->input->post('stripe_publish_key');
           $data_array['braintree_environment']=$this->input->post('braintree_environment');
           $data_array['braintree_merchant_id']=$this->input->post('braintree_merchant_id');
           $data_array['braintree_public_key']=$this->input->post('braintree_public_key');
           $data_array['braintree_private_key']=$this->input->post('braintree_private_key');
            $data_array['charge_from_owner']=$this->input->post('charge_from_owner');
            if(isset($_FILES['website_logo']) && $_FILES['website_logo'] != '')
			{
				
	
				
					$randdom= round(microtime(time()*1000)).rand(000, 999);
					$file_extension1 =pathinfo($_FILES["website_logo"]["name"], PATHINFO_EXTENSION);
					$p_profile_image1= $randdom.'.'.$file_extension1;
					if ($_FILES["website_logo"]["error"] > 0) { 
						$p_profile_image1=$this->dataModule['results']->website_logo;
					} else {
						move_uploaded_file($_FILES['website_logo']['tmp_name'], UPLOAD_PATH. $p_profile_image1);
										  
					 }
				
				
				
			}else {
				$p_profile_image1=$this->dataModule['results']->website_logo;
            }
            $data_array['website_logo']=$p_profile_image1;
            $data_array['updated']=$this->utc_time;
            if($this->Sitefunction->update(TBL_SETTINGS, $data_array, array('id'=>$id))){
                $this->session->set_flashdata('success', $this->lang->line('settings_updated_successfully'));
                redirect(SETTINGS_PATH);
            }else {
                $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
            }
            
        }
         
        $this->load->view('settings/edit',$this->dataModule);       
    }

   
}
?>