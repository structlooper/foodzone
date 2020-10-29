<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodel');
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
    }
	public function index() {
		$this->dataModule["orderdeliveredlist"] =$this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', "o.id", array('o.status!='=>9, 'order_status'=>5, 'r.owner_id'=>$this->user_id), array(TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id"), array('o.id'=>'desc'), '', 'INNER');
        $this->dataModule["totalorderreceived"] =$this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', "o.id", array('o.status!='=>9, 'order_status'=>1, 'r.owner_id'=>$this->user_id), array(TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id"), array('o.id'=>'desc'), '', 'INNER');
        $this->dataModule["totaltodayorderview"]  =$this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', "o.id", array('o.status!='=>9, 'o.created'=>$this->utc_date, 'r.owner_id'=>$this->user_id), array(TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id"), array('o.id'=>'desc'), '', 'INNER');;
        $this->dataModule["totalEarnings"] = $this->Sitefunction->get_all_rows(TBL_EARNINGS. ' as e ', "SUM(e.owners_amount) AS earnings", array('e.status'=>1, "r.owner_id"=>$this->user_id), array(TBL_RESTAURANTS.' as r'=>"e.restaurent_id=r.id"));
        
        $where = array('o.status!='=>9, "owner_id"=>$this->user_id);
        $columns = "o.*, u.fullname, r.name";
        $join = array(TBL_USERS.' as u' => "u.id=o.user_id", TBL_RESTAURANTS.' as r'=>"o.restaurent_id=r.id");
        $group_by = '';
        $this->dataModule['latest_order_list'] = $this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '5,0', 'LEFT', array(), $group_by, array(), array());
       // echo $this->db->last_query();
      //  die;
        $this->dataModule['controller']=$this;
		        
        $this->load->view('dashboard/index', $this->dataModule);
	}

}
?>