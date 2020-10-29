<?php 
class MY_Model extends CI_Model {
	
    function __construct() {
        parent::__construct();
		
	}
	function get_single_row($table_name, $column, $where= array()) {
		$this->db->select($column);
		$this->db->where($where);
		$query= $this->db->get($table_name);
        //if($query->num_rows()>0) {
    		return $query->row();
       // }else {
           // return 0;
       // }
	}
	function get_single_row_orderby($table_name, $column, $where= array(), $order_field , $order_by) {
		$this->db->select($column);
		$this->db->where($where);
		$this->db->order_by($order_field, $order_by);
		$query= $this->db->get($table_name);
		return $query->row();
	}
	function get_all_row($table_name, $column, $where= array(), $limit='') {
		$this->db->select($column);
		$this->db->where($where);
		if(isset($limit) && $limit!='') {
			$this->db->limit($limit, 0);
		}
		$query= $this->db->get($table_name);
		return $query->result_array();
	}
	function insert($table_name, $data= array()) {
		$this->db->insert($table_name, $data);
		return true;
	}
	function update($table_name, $data= array(), $where= array()) {
		$this->db->where($where);
		$this->db->update($table_name, $data);
		return true;
	}
	function get_rows_orderby($table_name, $column, $where= array(), $order_field, $order_by) {
		$this->db->select($column);
		$this->db->where($where);
		$this->db->order_by($order_field, $order_by);
		$query= $this->db->get($table_name);
		return $query->result_array();
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
	function get_all_rows_by_query($query) {
        $database_object = $this->db->query($query);
        $table_data = array();
        foreach ($database_object->result_array() as $row) {
            $table_data[] = $row;
        }
        return $table_data;
    }
    function get_single_by_query($query) {
        $database_object = $this->db->query($query);
        $table_data = array();
        return $database_object->row();
        
    }
	public function delete($table_name, $where=array()) {
		$this->db->where($where);
		$this->db->delete($table_name);
	}
	public  function safe_b64encode($string) {
	
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
 
	public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
	
	function encode($string)
    {
        $ret = $this->encryption->encrypt($string);

       
		$ret = strtr(
				$ret,
				array(
					'+' => '.',
					'=' => '-',
					'/' => '~'
				)
			);
      

        return $ret;
    }


    function decode($string, $key="")
    {
        $string = strtr(
                $string,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            );

        return $this->encryption->decrypt($string);
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
	
	
	
	

    public function getTimthumbImage($path, $height, $width){
        return SITE_URL.'timthumb/timthumb.php?src='.$path.'&h='.$height.'&w='.$width.'&zc=1';

    }
	
}
?>