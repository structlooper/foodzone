<?php
class MY_Model extends CI_Model {
    protected $table_name;

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	function escape_data($data) {
        return $this->db->escape_str($data);
    }
	function insert($table_name, $data) {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
	function get_all_rows($table_name, $fields, $where = array(), $join = array(), $order_by = array(), $limit = '', $join_type = '', $like_array = array(), $group_by = '', $or_where = array(), $or_like_array = array()) {
		$this->db->select($fields);
        if (is_array($join) && count($join) > 0) {
            foreach ($join as $key => $value) {
                if (!empty($join_type) && $join_type) {
                    $this->db->join($key, $value, $join_type);
                } else {
                    $this->db->join($key, $value);
                }
            }
        }
        if (is_array($where) && count($where) > 0) {
            $this->db->where($where);
        }
        if (count($or_where) > 0) {
            $this->db->or_where($or_where);
        }
        if (is_array($order_by) && count($order_by) > 0) {
            foreach ($order_by as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        if (is_array($like_array) && count($like_array) > 0) {
            $this->db->like($like_array);
        }
        //or like
        if (is_array($or_like_array) && count($or_like_array) > 0) {
            //or_like
            foreach ($or_like_array as $key => $value) {
                $like_statements[] = " " . $key . " LIKE '%" . $value . "%'";
            }
            $like_string = "(" . implode(' OR ', $like_statements) . ")";
            $this->db->where($like_string);
        }
        if ($group_by != '') {
            $this->db->group_by($group_by);
        }

        if ($limit != '') {
            $limit = explode(',', $limit);
            $this->db->limit($limit[0], $limit[1]);
        }
        $database_object = $this->db->get($table_name);
        $table_data = array();
        foreach ($database_object->result_array() as $row) {
            $table_data[] = $row;
        }
        return $table_data;
	}
	function update($table_name, $data= array(), $where=array()) {
		$this->db->where($where);
		$this->db->update($table_name, $data);
        return true;
	}
	function get_single_row($table_name, $column, $where= array()) {
		$this->db->select($column);
		$this->db->where($where);
		$query= $this->db->get($table_name);
		if($query->num_rows()>0) {
			return $query->row();
		}else {
			return array();
		}
	}
	public function delete($table_name, $where=array()) {
		$this->db->where($where);
		$this->db->delete($table_name);
	}
	function get_rows($table_name, $column, $where= array()) {
		$this->db->select($column);
		$this->db->where($where);
		$query= $this->db->get($table_name);
		if($query->num_rows()>0) {
			return $query->result_array();
		}else {
			return array();
		}
	}
	function get_single_column($table_name, $column, $where= array()) {
		$this->db->select($column);
		$this->db->where($where);
		$query= $this->db->get($table_name);
		if($query->num_rows()>0) {
			return $query->row()->$column;
		}else {
			return '';
		}
	}
	function get_all_rows_by_query($query) {
        $database_object = $this->db->query($query);
        $table_data = array();
        foreach ($database_object->result_array() as $row) {
            $table_data[] = $row;
        }
        return $table_data;
    }
	function get_rows_orderby($table_name, $column, $where= array(), $order_field, $order_by) {
		$this->db->select($column);
		$this->db->where($where);
		$this->db->order_by($order_field, $order_by);
		$query= $this->db->get($table_name);
		return $query->result_array();
	}
    public function numberToCurrency($nummer)
    {
       $number_split= explode('.', $nummer);
       $num= $number_split[0];
        $explrestunits = "" ;
        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        if($number_split[1]) {
            return $thecash.'.'.$number_split[1]; 
        }else {
            return $thecash.'.'.$number_split[1]; 
        }
    }

    function get_rows_joins($table_name, $fields, $where = array(), $join = array(), $order_by = array(), $limit = '', $join_type = '', $like_array = array(), $group_by = '', $or_where = array(), $or_like_array = array()) {
        $this->db->select($fields);
        if (is_array($join) && count($join) > 0) {
            foreach ($join as $key => $value) {
                if (!empty($join_type) && $join_type) {
                    $this->db->join($key, $value, $join_type);
                } else {
                    $this->db->join($key, $value);
                }
            }
        }
        if (is_array($where) && count($where) > 0) {
            $this->db->where($where);
        }
        if (count($or_where) > 0) {
            $this->db->or_where($or_where);
        }


        if (is_array($like_array) && count($like_array) > 0) {
            $this->db->like($like_array);
        }
        //or like
        if (is_array($or_like_array) && count($or_like_array) > 0) {
            //or_like
            foreach ($or_like_array as $key => $value) {
                $like_statements[] = " " . $key . " LIKE '%" . $value . "%'";
            }
            $like_string = "(" . implode(' OR ', $like_statements) . ")";
            $this->db->where($like_string);
        }
        if ($group_by != '') {
            $this->db->group_by($group_by);
        }
        if (is_array($order_by) && count($order_by) > 0) {
            foreach ($order_by as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }

        if ($limit != '') {
            $limit = explode(',', $limit);
            $this->db->limit($limit[0], $limit[1]);
        }
        $database_object = $this->db->get($table_name);
        $table_data = array();
        return $database_object->result_array();
    }


    public function getTimthumbImage($path, $height, $width){
        return DOMAIN_URL.'timthumb/timthumb.php?src='.$path.'&h='.$height.'&w='.$width.'&zc=1';

    }
   
      function msort($array, $key, $sort_flags = SORT_REGULAR) {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                asort($mapping, $sort_flags);
                $sorted = array();
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }

    function get_single_by_query($query) {
        $database_object = $this->db->query($query);
        $table_data = array();
        return $database_object->row();
        
    }
}