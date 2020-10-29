<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Customers extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common", $language);
    }
    public function index()
    {
        $this->dataModule['results'] =  $this->Sitefunction->get_all_rows(TBL_USERS, "*", array('status!=' => 9, 'user_type' => 1), array(), array(), '', '', array(), '', array(), array());
        $this->load->view('customers/index', $this->dataModule);
    }

    public function delete()
    {

        $this->Sitefunction->delete(TBL_USERS, array('id' => $this->input->get_post('id')));
    }

    public function multiple_delete()
    {
        $ids = $this->input->get_post('id');

        foreach ($ids as $id) {
            $this->Sitefunction->delete(TBL_USERS, array('id' => $id));
        }
    }
}
?>