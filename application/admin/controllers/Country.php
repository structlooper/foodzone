<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Country extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common", $language);
    }
    public function index()
    {
        $this->dataModule['results'] =  $this->Sitefunction->get_all_rows(TBL_COUNTRY, "*", array('status!=' => 9), array(), array(), '', '', array(), '', array(), array());
        $this->load->view('country/index', $this->dataModule);
    }
    public function add()
    {
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'country name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array = array('name' => urlencode($this->input->post('name')), 'created' => $this->utc_time, 'updated' => $this->utc_time);
                if ($this->Sitefunction->insert(TBL_COUNTRY, $data_array)) {
                    $this->session->set_flashdata('success', $this->lang->line('country_added_successfully'));
                    redirect(COUNTRY_PATH);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
        }
        $this->load->view('country/add', $this->dataModule);
    }
    public function delete()
    {

        $this->Sitefunction->delete(TBL_COUNTRY, array('id' => $this->input->get_post('id')));
    }

    public function multiple_delete()
    {
        $ids = $this->input->get_post('id');

        foreach ($ids as $id) {
            $this->Sitefunction->delete(TBL_COUNTRY, array('id' => $id));
        }
    }
    public function edit($id)
    {
        $this->dataModule['results'] = $this->Sitefunction->get_single_row(TBL_COUNTRY, '*', array('id' => $id));
        if (!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('name', 'country name', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array = array('name' => urlencode($this->input->post('name')), 'updated' => $this->utc_time);
                if ($this->Sitefunction->update(TBL_COUNTRY, $data_array, array('id' => $id))) {
                    $this->session->set_flashdata('success', $this->lang->line('country_updated_successfully'));
                    redirect(COUNTRY_PATH);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
        }

        $this->load->view('country/edit', $this->dataModule);
    }
}
?>