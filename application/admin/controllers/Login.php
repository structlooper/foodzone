<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login extends MY_Controller {

    public function __construct() {
		parent::__construct();
		$language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
    }
	public function index() {
		$this->dataModule['error_message']= "";
		$post= $this->input->post();
		if(!empty($post)) {
			$this->form_validation->set_rules('useremail', 'email', 'required|valid_email|min_length[5]|max_length[125]');
			$this->form_validation->set_rules('password', 'password', 'required|min_length[5]|max_length[15]');
			$this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
			
				$username = $this->input->post("useremail");
				$password = $this->input->post("password");
				$admin_find= $this->Sitefunction->get_single_row(TBL_ADMIN, '*', array('email'=>urlencode($username), 'password'=>md5($password)));
				if(!empty($admin_find)) {
					$data= array('admin_id'=>$admin_find->id);
					$this->session->set_userdata($data);
					redirect(DASHBOARD_PATH);
				}
				else {
					$this->dataModule['error_message']= $this->lang->line('invalid_id_password');
					
				}
			}

		}
		$this->load->view('login/login', $this->dataModule);
	}
	public function logout() {
		$this->session->sess_destroy();
		redirect(LOGIN_PATH);
	}

	public function forgot_password() {
		$this->dataModule['success_message']='';
		$this->dataModule['error_message']='';
		$post= $this->input->post();
		if(!empty($post)) {
			$this->form_validation->set_rules('email', 'email', 'required|valid_email|min_length[5]|max_length[125]');
			$this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
				$username = $this->input->post("email");
				$admin_find= $this->Sitefunction->get_single_row(TBL_ADMIN, '*', array('email'=>urlencode($this->input->post('email'))));
				if(!empty($admin_find)) {
					$password= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz!@#$%^&*'), 0, 8);
					$data_array= array('password'=>md5($password), 'updated'=>$this->utc_time);
				
					$this->Sitefunction->update(TBL_ADMIN ,$data_array, array('id'=>$admin_find->id));
					if($this->sendMailToAdmin($admin_find->id, $password, $username)) {
						$this->dataModule['success_message']= $this->lang->line('password_sent_to_email');
					}else {
						$this->dataModule['error_message']= $this->lang->line('error_try_again');
					}
					
				}
				else {
					$this->dataModule['error_message']= $this->lang->line('invalid_email_id');
					
				}
			}
		}
		 $this->load->view('login/forgot_pass', $this->dataModule);
		
	}

}
?>