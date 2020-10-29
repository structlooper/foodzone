<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Coupons extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common", $language);
    }
    public function index()
    {
        $where = array('status!=' => 9);
        $columns = "*";
        $join = array();
        $group_by = 'id';
        $this->dataModule['results'] =  $this->Sitefunction->get_all_rows(TBL_COUPONS, $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());

        $this->load->view('coupons/index', $this->dataModule);
    }

    public function delete()
    {

        $this->Sitefunction->delete(TBL_COUPONS, array('id' => $this->input->get_post('id')));
    }

    public function multiple_delete()
    {
        $ids = $this->input->get_post('id');

        foreach ($ids as $id) {
            $this->Sitefunction->delete(TBL_COUPONS, array('id' => $id));
        }
    }

    public function add()
    {
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('coupon_code', 'coupon code', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_rules('start_date', 'start date', 'required');
            $this->form_validation->set_rules('end_date', 'end sate', 'required');

            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array['coupon_code'] = $this->input->post('coupon_code');
                $data_array['description'] = urlencode($this->input->post('description'));
                $data_array['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
                $data_array['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
                $data_array['discount'] = $this->input->post('discount');
                $data_array['discount_type'] = $this->input->post('discount_type');
                $data_array['updated'] = $this->utc_time;
                $data_array['created'] = $this->utc_time;
                if (isset($_FILES['image']) && !empty($_FILES['image'])) {
                    $randdom = round(microtime(time() * 1000)) . rand(000, 999);
                    $file_extension1 = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $file_name1 = $randdom . '.' . $file_extension1;
                    if ($_FILES["image"]["error"] <= 0) {
                        move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . 'coupons/' . $file_name1);
                        $data_array['image'] = $file_name1;
                    }
                }

                if ($this->Sitefunction->insert(TBL_COUPONS, $data_array)) {
                    $this->session->set_flashdata('success', $this->lang->line('coupon_added_successfully'));
                    redirect(COUPONS_PATH);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
        }
        $this->load->view('coupons/add', $this->dataModule);
    }

    public function edit($id)
    {
        $this->dataModule['results'] = $this->Sitefunction->get_single_row(TBL_COUPONS, '*', array('id' => $id));
        if (!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData = $this->input->post();
        if ($postData && !empty($postData)) {
            $this->form_validation->set_rules('coupon_code', 'coupon code', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_rules('start_date', 'start date', 'required');
            $this->form_validation->set_rules('end_date', 'end sate', 'required');
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            if ($this->form_validation->run() != FALSE) {
                $data_array['coupon_code'] = $this->input->post('coupon_code');
                $data_array['description'] = urlencode($this->input->post('description'));
                $data_array['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
                $data_array['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
                $data_array['discount'] = $this->input->post('discount');
                $data_array['discount_type'] = $this->input->post('discount_type');
                $data_array['updated'] = $this->utc_time;
                if (isset($_FILES['image']) && !empty($_FILES['image'])) {
                    $randdom = round(microtime(time() * 1000)) . rand(000, 999);
                    $file_extension1 = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $file_name1 = $randdom . '.' . $file_extension1;
                    if ($_FILES["image"]["error"] <= 0) {
                        move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . 'coupons/' . $file_name1);
                        $data_array['image'] = $file_name1;
                    }
                }
                if ($this->Sitefunction->update(TBL_COUPONS, $data_array, array('id' => $id))) {
                    $this->session->set_flashdata('success', $this->lang->line('coupon_updated_successfully'));
                    redirect(COUPONS_PATH);
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
        }
        $this->load->view('coupons/edit', $this->dataModule);
    }
}
?>