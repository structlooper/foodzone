<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodel');
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
		//echo $this->lang->line('first_name');
    }
	public function index() {
		$this->dataModule["customerslist"] =$this->Sitefunction->get_all_rows(TBL_USERS, "id", array('status!='=>9, 'user_type'=>1));
        $this->dataModule["orderdeliveredlist"] =$this->Sitefunction->get_all_rows(TBL_ORDERS, "id", array('order_status'=>5));;
        $this->dataModule["totalorderreceived"] =$this->Sitefunction->get_all_rows(TBL_ORDERS, "id", array('created'=>$this->utc_date, 'order_status'=>1));
        $this->dataModule["totalearnings"] = $this->Sitefunction->get_all_rows(TBL_EARNINGS, "SUM(admin_charge_amount) AS earnings", array('status'=>1));
        $this->dataModule["totalowners"] =$this->Sitefunction->get_all_rows(TBL_OWNERS, "id", array('status!='=>9));
        $this->dataModule["totalResaturants"] =$this->Sitefunction->get_all_rows(TBL_RESTAURANTS, "id", array('status!='=>9));
        $this->dataModule['available_drivers']= $this->Sitefunction->get_all_rows(TBL_USERS, "*", array('status'=>1, 'user_type'=>2, 'latitude!='=>"", 'longitude!='=>""));
        $where = array('o.status!='=>9);
        $columns = "o.*, u.fullname, r.name";
        $join = array(TBL_USERS.' as u' => "u.id=o.user_id", TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id");
        $group_by = '';
        $this->dataModule['latest_order_list'] = $this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '5,0', 'LEFT', array(), $group_by, array(), array());
        $this->dataModule['controller']=$this; 
		        
        $this->load->view('dashboard/index', $this->dataModule);
	}

}
?>