<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Orders extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $language = $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common", $language);
    }
    public function index()
    {
        $where = array('o.status!=' => 9);
        $columns = "o.*, u.fullname as user_name, a.latitude, a.longitude";
        $join = array(TBL_USERS . ' as u' => "u.id=o.user_id", TBL_ADDRESS . ' as a' => "a.id=o.address_id");
        $group_by = 'o.id';
        $this->dataModule['results'] =  $this->Sitefunction->get_all_rows(TBL_ORDERS . ' as o', $columns, $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());

        $this->dataModule['drivers_list'] = $this->Sitefunction->get_all_rows(TBL_USERS, "fullname, id", array('user_type' => 2, 'is_available' => 1, 'status' => 1), array(), array('fullname' => 'asc'), '', '', array(), "", array(), array());
        // echo $this->db->last_query();
        // die;
        $this->dataModule['controller'] = $this;
        $this->load->view('orders/index', $this->dataModule);
    }

    public function delete()
    {

        $this->Sitefunction->delete(TBL_ORDERS, array('id' => $this->input->get_post('id')));
    }

    public function assign_driver()
    {
        $data_array['order_id'] = $this->input->get_post('order_id');
        $data_array['driver_id'] = $this->input->get_post('driver_id');
        $data_array['created'] = $this->utc_time;
        $data_array['updated'] = $this->utc_time;
        $this->Sitefunction->insert(TBL_ORDER_DRIVERS, $data_array);

        $data_array1['title'] = urlencode("Order Assigned");
        $data_array1['description'] = urlencode("Order #" . $data_array['order_id'] . " has been assigned to you.");
        $data_array1['type'] = 2;
        $data_array1['user_id'] = $this->input->get_post('driver_id');
        $data_array1['type_id'] = $data_array['order_id'];
        $data_array1['created'] = $this->utc_time;
        $data_array1['updated'] = $this->utc_time;

        if ($this->Sitefunction->insert(TBL_NOTIFICATION, $data_array1)) {
            $notification_id = $this->db->insert_id();
            $this->sendPushNotification($data_array['driver_id'], $notification_id, 'driver');
        }
        return true;
    }

    public function view($id)
    {

        $this->dataModule['order_info'] =  $this->Sitefunction->get_single_by_query("SELECT o.*, r.name, r.profile_image, r.address, r.phone as r_phone, r.email as r_email, r.id as restaurant_id, r.opening_time, r.closing_time, r.average_price, a.address_line_1, a.address_line_2, a.phone, a.name as user_name, a.city, u.phone as customer_phone, u.email as customer_email, u.fullname as customer_name FROM " . TBL_ORDERS . " as o LEFT JOIN " . TBL_RESTAURANTS . " as r ON r.id=o.restaurent_id LEFT JOIN " . TBL_ADDRESS . " as a ON a.id=o.address_id  LEFT JOIN " . TBL_USERS . " as u ON u.id=o.user_id WHERE o.id=" . $id . " and o.status=1");
        $this->dataModule['controller'] = $this;

        $where = array('od.order_id=' => $id, 'od.status' => 1);
        $columns = "od.*, p.type, p.title, p.image";
        $join = array(TBL_SUBCATEGORIES . ' as p' => "od.product_id=p.id");
        $group_by = 'od.id';
        $this->dataModule['get_order_details'] =  $this->Sitefunction->get_all_rows(TBL_ORDERDETAIL . ' as od', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());

        // print_r($this->dataModule['order_info']);
        //  die;

        $this->load->view("orders/view", $this->dataModule);
    }


    public function change_order_status()
    {

        if ($this->Sitefunction->update(TBL_ORDERS, array("order_status" => $this->input->get_post('order_status')), array('id' => $this->input->get_post('orderid')))) {
            $this->session->set_flashdata('success', $this->lang->line('order_status_updated_successfully'));
            redirect(ORDER_PATH . '/view/' . $this->input->get_post('orderid'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
        }
    }
}
?>