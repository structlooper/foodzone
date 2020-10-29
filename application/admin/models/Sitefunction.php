<?php
class Sitefunction extends MY_Model {
	function __construct() {
        parent::__construct();
    }
	function get_product_name() {
		$this->db->select(array('p_id', 'p_title'));
		$query= $this->db->get(TBL_PRODUCTS);
		return $query->result_array();
	}
	function get_product_title($p_id) {
		$this->db->select(array('p_id', 'p_title'));
		$this->db->where('p_id', $p_id);
		$query= $this->db->get(TBL_PRODUCTS);
		return $query->row()->p_title;
		
	}
}
?>