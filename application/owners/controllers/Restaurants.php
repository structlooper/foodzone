<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Restaurants extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        
      
	}
	public function index() {
        $where = array('r.status!='=>9, 'owner_id'=>$this->user_id);
        $columns = "r.*, o.first_name, o.last_name, s.name as state_name, ct.name as city_name, c.name as country_name";
        $join = array(TBL_STATE.' as s' => "s.id=r.state_id", TBL_CITY.' as ct'=> "ct.id=r.city_id", TBL_COUNTRY." as c" => "c.id=r.country_id", TBL_OWNERS." as o" => "o.id=r.owner_id");
        $group_by = 'r.id';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_RESTAURANTS.' as r', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
        
		$this->load->view('restaurants/index', $this->dataModule);
    }
    

    public function view($id) {

        $this->dataModule['restaurant_info']=  $this->Sitefunction->get_single_by_query("SELECT r.*, ct.name as city_name, s.name as state_name, c.name as country_name FROM ".TBL_RESTAURANTS." as r INNER JOIN ".TBL_CITY." as ct ON ct.id=r.city_id INNER JOIN ".TBL_STATE." as s ON s.id=r.state_id  INNER JOIN ".TBL_COUNTRY." as c ON c.id=r.country_id WHERE r.id=".$id." and r.status=1 and r.owner_id=".$this->user_id);
        $this->dataModule['controller']=$this; 

        $where = array('s.restaurant_id='=>$id, 's.status'=>1);
        $columns = "c.*";
        $join = array(TBL_SUBCATEGORIES.' as s'=>"s.category_id=c.id");
        $group_by = 'c.id';
        $this->dataModule['categories']=  $this->Sitefunction->get_all_rows(TBL_CATEGORIES.' as c', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());

        

      
      if(empty($this->dataModule['restaurant_info'])) {
        $this->session->set_flashdata('error', $this->lang->line('restaurant_not_found'));
        redirect(RESTAURANTS_PATH);
      }

        $this->load->view("restaurants/view", $this->dataModule);

    }

    public function change_visibility() {
      $data_array= array('status'=>trim($this->input->get_post('visibility')), 'updated'=>$this->utc_time);
			
			$this->Sitefunction->update(TBL_SUBCATEGORIES,$data_array,  array('id'=>$this->input->get_post('id')) );
    }

    public function change_availablity() {
      $data_array= array('is_available'=>trim($this->input->get_post('visibility')), 'updated'=>$this->utc_time);
			
			$this->Sitefunction->update(TBL_RESTAURANTS,$data_array,  array('id'=>$this->input->get_post('id')) );
    }
  
    function invoice($id) {

      $where = array('o.restaurent_id='=>$id, 'o.status'=>1, 'r.owner_id'=>$this->user_id, 'e.status'=>1);
      $columns = "o.*, e.admin_charge_amount, e.owners_amount, e.total_amount, e.payment_status, e.payment_date";
      $join = array(TBL_EARNINGS.' as e'=>"e.order_id=o.id", TBL_RESTAURANTS.' as r'=>"r.id=o.restaurent_id");
      $group_by = 'o.id';
      $this->dataModule['invoice_info']=  $this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '', 'INNER', array(), $group_by, array(), array());

      $this->dataModule['controller']=$this; 
      $this->dataModule['restaurant_id']= $id;
      $this->load->view("restaurants/invoice", $this->dataModule);


  }
    
    
}
?>