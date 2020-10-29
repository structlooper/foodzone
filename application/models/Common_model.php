<?php 
class Common_model extends MY_Model {

    function __construct() {
        parent::__construct();
	}
	 public function getRmainingQty($product_id, $totalQty){
        $query= "SELECT sum(od.total_qty) as total FROM ".TBL_ORDERDETAIL." as od INNER JOIN ".TBL_ORDERS." as o ON o.id=od.order_id INNER JOIN ".TBL_TRANSACTION." as t on t.order_id=o.id WHERE od.product_id=".$product_id." and t.payment_status=1 GROUP BY od.product_id";
        $getArray= $this->get_all_rows_by_query($query);
        $sold= 0;
        foreach ($getArray as $result) {
        	$sold= $sold+ $result['total'];
        }
        $final= $totalQty-$sold;
        return $final;

    }
}
?>