<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class SubCategories extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $language= $this->session->userdata('lang') ? $this->session->userdata('lang') : 'english';
        $this->lang->load("common",$language);
        $this->dataModule['foodcategory']= $this->Sitefunction->get_rows(TBL_CATEGORIES, 'id, title', array('status'=>1));
        $this->dataModule['restaurants']= $this->Sitefunction->get_rows(TBL_RESTAURANTS, 'id, name', array('status'=>1));
	}
	public function index() {
        $where = array('s.status!='=>9, 'owner_id'=>$this->user_id);
        $columns = "s.*, c.title as cat_title, r.name as restaurant_name";
        $join = array(TBL_CATEGORIES.' as c' => "c.id=s.category_id", TBL_RESTAURANTS.' as r' => "r.id=s.restaurant_id");
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_SUBCATEGORIES.' as s', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
		$this->load->view('subcategories/index', $this->dataModule);
    }
    public function change_visibility() {
        $data_array= array('status'=>trim($this->input->get_post('visibility')), 'updated'=>$this->utc_time);
            
        $this->Sitefunction->update(TBL_SUBCATEGORIES,$data_array,  array('id'=>$this->input->get_post('id')) );
    }
  
	
	

    
}
?>