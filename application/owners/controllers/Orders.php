<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Orders extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        }
	public function index() {
        $where = array('o.status!='=>9, 'r.owner_id'=>$this->user_id);
        $columns = "o.*, u.fullname";
        $join = array(TBL_USERS.' as u' => "u.id=o.user_id", TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id");
        $group_by = 'o.id';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '', 'LEFT', array(), $group_by, array(), array());
        $this->dataModule['controller']=$this; 
		$this->load->view('orders/index', $this->dataModule);
	}
	

    public function view($id) {

        $this->dataModule['order_info']=  $this->Sitefunction->get_single_by_query("SELECT o.*, r.name, r.profile_image, r.address, a.address_line_1, a.address_line_2, a.phone, a.name as user_name, a.city, u.phone as customer_phone, u.email as customer_email, u.fullname as customer_name FROM ".TBL_ORDERS." as o LEFT JOIN ".TBL_RESTAURANTS." as r ON r.id=o.restaurent_id LEFT JOIN ".TBL_ADDRESS." as a ON a.id=o.address_id  LEFT JOIN ".TBL_USERS." as u ON u.id=o.user_id WHERE o.id=".$id." and o.status=1 and r.owner_id=".$this->user_id);
        $this->dataModule['controller']=$this; 

        $where = array('od.order_id='=>$id, 'od.status'=>1);
        $columns = "od.*, p.type, p.title, p.image";
        $join = array(TBL_SUBCATEGORIES.' as p'=>"od.product_id=p.id");
        $group_by = 'od.id';
        $this->dataModule['get_order_details']=  $this->Sitefunction->get_all_rows(TBL_ORDERDETAIL.' as od', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());

       // print_r($this->dataModule['order_info']);
      //  die;

      if(empty($this->dataModule['order_info'])) {
        $this->session->set_flashdata('error', $this->lang->line('order_not_found'));
        redirect(ORDER_PATH);
      }

        $this->load->view("orders/view", $this->dataModule);

    }


    public function change_order_status() {
		$order_status= $this->input->get_post('order_status');
        if($this->Sitefunction->update(TBL_ORDERS, array("order_status"=>$this->input->get_post('order_status')), array('id'=>$this->input->get_post('orderid')))){
            $addNotification= array();
            if($order_status==2) {
                $addNotification['title'] = urlencode("Order Accepted");
			    $addNotification['Description'] = urlencode("Your order has been accepted.");
            }else if($order_status==3) {
                $addNotification['title'] = urlencode("Order Declined");
			    $addNotification['Description'] = urlencode("Opps! Your order is desclined by restaurant.");

            }else if($order_status==4) {
                $addNotification['title'] = urlencode("Order Inprocess");
			    $addNotification['Description'] = urlencode("Your order is in process.");

            }
            // else if($order_status==5) {
            //     $addNotification['title'] = "Order Delivered";
			//     $addNotification['Description'] = "Your order has been delivered successfully.";

            // }
			
			$addNotification['type'] = "1";
			$addNotification['type_id'] = $this->input->get_post('orderid');
			$addNotification['user_id']= $this->input->get_post('user_id');
			$addNotification['created']= date('Y-m-d H:i:s');
			$addNotification['updated']= date('Y-m-d H:i:s');
            $this->Sitefunction->insert(TBL_NOTIFICATIONS, $addNotification);
            $notification_id= $this->db->insert_id();
            $this->sendPushNotification($this->input->get_post('user_id'), $notification_id);
            $this->session->set_flashdata('success', $this->lang->line('order_status_updated_successfully'));
            redirect(ORDER_PATH.'/view/'.$this->input->get_post('orderid'));
        }else {
            $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
        }
        
    }

   
}
?>