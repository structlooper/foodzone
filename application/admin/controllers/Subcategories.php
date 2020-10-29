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
        $where = array('s.status!='=>9);
        $columns = "s.*, c.title as cat_title, r.name as restaurant_name";
        $join = array(TBL_CATEGORIES.' as c' => "c.id=s.category_id", TBL_RESTAURANTS.' as r' => "r.id=s.restaurant_id");
        $group_by = '';
        $this->dataModule['results']=  $this->Sitefunction->get_all_rows(TBL_SUBCATEGORIES.' as s', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
		$this->load->view('subcategories/index', $this->dataModule);
	}
	public function add($restarent_id=false){
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('title', 'title', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('category_id', 'category', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('restaurant_id', 'restaurant', 'required');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['title']= urlencode($this->input->post('title'));
                $data_array['category_id']= $this->input->post('category_id');
                $data_array['type']= $this->input->post('type');
                $data_array['restaurant_id']= $this->input->post('restaurant_id');
                $data_array['description']= urlencode($this->input->post('description'));
                $data_array['discount_type']= $this->input->post('discount_type');
                $data_array['price']= $this->input->post('price');
                $data_array['discount']= $this->input->post('discount');
                $data_array['created']= $this->utc_time;
                $data_array['updated']= $this->utc_time;
                $data_array['image']= "";
                if(isset($_FILES['image']) && !empty($_FILES['image']))
                {
                    $randdom= round(microtime(time()*1000)).rand(000, 999);
                    $file_extension1 =pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $file_name1= $randdom.'.'.$file_extension1;
                    if ($_FILES["image"]["error"] <=0) { 
                        move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH.'subcategory/'. $file_name1);
                        $data_array['image']= $file_name1;
                    } 
                
                
                }
                if($this->Sitefunction->insert(TBL_SUBCATEGORIES, $data_array)){
                    $this->session->set_flashdata('success', $this->lang->line('subcategory_added_successfully'));
                    redirect(SUBCATEGORY_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        $this->dataModule['restarent_id']= $restarent_id;
        $this->load->view('subcategories/add',$this->dataModule);       
    }
	public function delete() {
		
        $this->Sitefunction->delete(TBL_SUBCATEGORIES, array('id'=>$this->input->get_post('id')));
        
    }
    
    public function multiple_delete() {
        $ids= $this->input->get_post('id');

        foreach($ids as $id){
            $this->Sitefunction->delete(TBL_SUBCATEGORIES, array('id'=>$id));
        }

    }

    public function edit($id) {
        $this->dataModule['results']= $this->Sitefunction->get_single_row(TBL_SUBCATEGORIES, '*', array('id'=>$id));
        if(!$id || empty($this->dataModule['results'])) {
            redirect(ERROR_PATH);
        }
        $postData= $this->input->post();
        if($postData && !empty($postData)) {
            $this->form_validation->set_rules('title', 'title', 'required|min_length[3]|max_length[125]');
            $this->form_validation->set_rules('category_id', 'category', 'required');
            $this->form_validation->set_rules('type', 'type', 'required');
            $this->form_validation->set_rules('restaurant_id', 'restaurant', 'required');
            $this->form_validation->set_rules('description', 'description', 'required|min_length[10]');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_error_delimiters( '<p class="error">','</p>' );
			if ($this->form_validation->run() != FALSE)
			{
                $data_array['title']= urlencode($this->input->post('title'));
                $data_array['category_id']= $this->input->post('category_id');
                $data_array['type']= $this->input->post('type');
                $data_array['restaurant_id']= $this->input->post('restaurant_id');
                $data_array['description']= urlencode($this->input->post('description'));
                $data_array['discount_type']= $this->input->post('discount_type');
                $data_array['price']= $this->input->post('price');
                $data_array['discount']= $this->input->post('discount');
                $data_array['updated']= $this->utc_time;
                $data_array['image']= $this->dataModule['results']->image;
                if(isset($_FILES['image']) && !empty($_FILES['image']))
                {
                    $randdom= round(microtime(time()*1000)).rand(000, 999);
                    $file_extension1 =pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $file_name1= $randdom.'.'.$file_extension1;
                    if ($_FILES["image"]["error"] <=0) { 
                        move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH.'subcategory/'. $file_name1);
                        $data_array['image']= $file_name1;
                    } 
                
                
                }
                if($this->Sitefunction->update(TBL_SUBCATEGORIES, $data_array, array('id'=>$id))){
                    $this->session->set_flashdata('success', $this->lang->line('subcategory_updated_successfully'));
                    redirect(SUBCATEGORY_PATH);
                }else {
                    $this->session->set_flashdata('error', $this->lang->line('error_try_again'));
                }
            }
            
        }
        
        $this->load->view('subcategories/edit',$this->dataModule);  
    }
}
?>