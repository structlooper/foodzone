<?php
class Owners_service extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('index');
	}
	

	public function login()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$email = urlencode($requestData->email);
		$password = $requestData->password;
		$device_token = $requestData->device_token;
		$get_user =  $this->Common_model->get_single_row(TBL_OWNERS, 'status, id', array('email' => $email, 'password' => md5($password), 'status!=' => 9));
		if (!empty($get_user)) {
			$user_status = $get_user->status;
			if ($user_status == 1) {

				$get_user =  $this->Common_model->get_single_row(TBL_OWNERS, '*', array('id' => $get_user->id));
				
				$this->Common_model->update(TBL_OWNERS, array('device_token' => $device_token, 'updated' => $this->utc_time), array('id' => $get_user->id));

				

				$user['id'] = $get_user->id;
				$user['name'] = urldecode($get_user->first_name.' '.$get_user->last_name);
				$user['email'] = urldecode($get_user->email);
				$user['profile_image'] = $this->getImage($get_user->image, 'owners');
				$user['phone'] = $get_user->phone;
				$user['address'] = $get_user->address;
				$user['pincode'] = $get_user->pincode;
				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = $user;
			} else {
				$data['code'] = INACTIVE_ACCOUNT;
				$data['message'] = 'Your account is inactive.';
				$data['result'] = [];
			}
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'Invaid email or password.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function forgot_password()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$email = $requestData->email;

		$get_user =  $this->Common_model->get_single_row(TBL_OWNERS, 'status, id', array('email' => urlencode($email), 'status=' => 1));
		//echo $this->db->last_query();
		//die;
		if (!empty($get_user)) {
			$password = substr(str_shuffle("ABCDEFGH1234567890IGHIJKLMNOPQ@!$%^&*RSTUVWXYZ"), 0, 8);
			$addArr['password'] = md5($password);
			$addArr['updated'] = date('Y-m-d H:i:s');


			//
			$sendEmail = $this->sendMailToUser($get_user->id,  $email, 2, $password);
			if ($sendEmail) {
				$update = $this->Common_model->update(TBL_OWNERS, $addArr, array('id' => $get_user->id));
				$data['code'] = SUCCESS;
				$data['message'] = 'Password successfully sent to your email id.';
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
			}
		} else {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Email does not exist.';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function logout()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);

		$owner_id = $requestData->owner_id;
		$this->Common_model->update(TBL_OWNERS, array('updated' => $this->utc_time), array('id' => $owner_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Logout successfully.';

		header('Content-type: application/json');
		echo json_encode($data);
	}
	public function change_password()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$owner_id = $requestData->owner_id;
		$old_password = $requestData->old_password;
		$new_password = $requestData->new_password;

		$get_user =  $this->Common_model->get_single_row(TBL_OWNERS, 'status, id', array('password' => md5($old_password), 'status=' => 1, 'id'=>$owner_id));

		if (!empty($get_user)) {
			$addArr['password'] = md5($new_password);
			$addArr['updated'] = date('Y-m-d H:i:s');			
			$update = $this->Common_model->update(TBL_OWNERS, $addArr, array('id' => $get_user->id));
			$data['code'] = SUCCESS;
			$data['message'] = 'Password successfully updated';
			
		} else {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Invalid old password';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function profile()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$owner_id = $requestData->owner_id;
		$get_user =  $this->Common_model->get_single_row(TBL_OWNERS, '*', array('id' => $owner_id, 'status' => 1));
		if (!empty($get_user)) {
			$user['owner_id'] = $get_user->id;
			$user['name'] = urldecode($get_user->first_name.' '.$get_user->last_name);
			$user['email'] = urldecode($get_user->email);
			$user['profile_image'] = $this->getImage($get_user->image, 'owners');
			$user['phone'] = $get_user->phone;

			$where = array('r.owner_id' => $owner_id, 'o.status' => 1);
			$join = array(TBL_RESTAURANTS . ' as r' => "r.id=o.restaurent_id");
			$group_by = 'o.id';
			
			$total_orders =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', 'o.id', $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());

			//$where = array('r.owner_id=' => $owner_id, 'o.status' => 1, 'created');
			$todays_orders =  $this->Common_model->get_all_rows_by_query("SELECT o.id FROM " . TBL_ORDERS . " as o INNER JOIN " . TBL_RESTAURANTS . " as r ON r.id=o.restaurent_id WHERE o.status=1  and r.status=1 and r.owner_id =".$owner_id." and DATE_FORMAT(o.created,' %Y-%m-%d') = '".date('Y-m-d')."' ORDER BY id DESC");

			$where = array('r.owner_id' => $owner_id, 'o.status' => 1, 'r.status'=>1, 'o.status'=>1, 'o.order_status <= '=>2);
			$new_orders =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', 'o.id', $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());
			
			$total_earnings =  $this->Common_model->get_all_rows(TBL_EARNINGS. ' as e ', "SUM(e.owners_amount) AS earnings", array('e.status'=>1, "r.owner_id"=>$owner_id), array(TBL_RESTAURANTS.' as r'=>"e.restaurent_id=r.id"));

			$current_month_earnings =  $this->Common_model->get_all_rows(TBL_EARNINGS. ' as e ', "SUM(e.owners_amount) AS earnings", array('e.status'=>1, "r.owner_id"=>$owner_id, 'MONTH(e.created)'=> "MONTH(".date('Y-m-d').")"), array(TBL_RESTAURANTS.' as r'=>"e.restaurent_id=r.id"));


			$user['total_orders'] = strval( count($total_orders) );
			$user['todays_orders'] = strval( count($todays_orders) );
			$user['new_orders'] = strval( count($new_orders));
			$user['total_earnings'] = $total_earnings[0]['earnings'];
			$user['current_month_earnings'] = $current_month_earnings[0]['earnings'];
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $user;
		} else {

			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function restaurant_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$owner_id = $requestData->owner_id;
		$finalResponse = array();

		$get_restaurants = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.owner_id, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name,  r.latitude, r.longitude, ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id LEFT JOIN ".TBL_RESTAURANT_REVIEW." as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING   r_status=1  and s_status=1 and ct_status=1 and c_status=1 and r.owner_id=".$owner_id." ORDER BY name ASC");
		if (!empty($get_restaurants)) {
			foreach ($get_restaurants as $row) {
				$res['id'] = $row['id'];
				$res['review'] = $row['review'];
				$res['is_available'] = $row['is_available'];
				$res['name'] = urldecode($row['name']);
				$res['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				
				$finalResponse[] = $res;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}

	function orders_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$owner_id = $requestData->owner_id;
		$where = array('r.owner_id=' => $owner_id, 'o.status' => 1);
		$columns = "o.*, r.name, r.profile_image, a.address_line_1, a.address_line_2, rr.review";
		$join = array(TBL_RESTAURANTS . ' as r' => "r.id=o.restaurent_id", TBL_RESTAURANT_REVIEW . ' as rr' => "rr.order_id=o.id", TBL_ADDRESS.' as a' =>"o.address_id=a.id");
		$group_by = 'o.id';
		$get_data =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', $columns, $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());


		$ordResponse = array();
		if (!empty($get_data)) {
			foreach ($get_data as $ord) {
				$ordRes['name'] = urldecode($ord['name']);
				$ordRes['banner_image'] = $this->getImage(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address'] = urldecode($ord['address_line_1'].' '.$ord['address_line_2']);
				$ordRes['order_id'] = $ord['id'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['total_price'] = $ord['total_price'];
				$ordRes['created'] = $ord['created'];
				$ordRes['payment_type'] = $ord['payment_type'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['review'] = urldecode($ord['review']);
				$ordResponse[] = $ordRes;
			}


			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $ordResponse;
		} else {

			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	

	public function details($restaurant_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$get_restaurant =  $this->Common_model->get_single_row(TBL_RESTAURANTS, '*', array('id' => $restaurant_id, 'status' => 1));
		if (!empty($get_restaurant)) {


			$get_avg_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'ROUND( AVG(rr.review),1 ) as review',array('restaurant_id'=>$restaurant_id, 'status'=>1),array(), array(), '', 'LEFT', array(), 'rr.restaurant_id', array(), array());
			
			$restData['restaurant_id'] = $restaurant_id;
			$restData['avg_review'] = null;
			if(!empty($get_avg_review)) {
				$restData['avg_review'] = $get_avg_review[0]['review'];
			}
			$restData['name'] = urldecode($get_restaurant->name);
			$restData['email'] = urldecode($get_restaurant->email);
			$restData['banner_image'] = $this->getImage(explode(',', $get_restaurant->profile_image)[0], 'restaurants/profile');
			$restData['phone'] = $get_restaurant->phone;
			$restData['address'] = urldecode($get_restaurant->address);
			$restData['opening_time'] = $get_restaurant->opening_time;
			$restData['closing_time'] = $get_restaurant->closing_time;
			$restData['latitude'] = $get_restaurant->latitude;
			$restData['longitude'] = $get_restaurant->longitude;
			$restData['average_price'] = $get_restaurant->average_price;
			$restData['discount'] = $get_restaurant->discount;
			$restData['discount_type'] = $get_restaurant->discount_type;
			$restData['average_price'] = $get_restaurant->average_price;
			$restData['is_available'] = $get_restaurant->is_available;

			$where = array('r.id=' => $restaurant_id, 's.status!=' => 9, 'c.status' => 1);
			$columns = "c.*, s.id as subcategory_id, s.restaurant_id";
			$join = array(TBL_SUBCATEGORIES . ' as s' => "s.category_id=c.id", TBL_RESTAURANTS . ' as r' => "r.id=s.restaurant_id");
			$group_by = 'c.id';
			$get_categories =  $this->Common_model->get_all_rows(TBL_CATEGORIES . ' as c', $columns, $where, $join, array('c.title' => 'asc'), '2,0', 'LEFT', array(), $group_by, array(), array());
			$catResponse = array();
			if (!empty($get_categories)) {
				foreach ($get_categories as $cats) {
					$catRes['category_name'] = urldecode($cats['title']);
					$catRes['category_id'] = $cats['id'];
					$where = array('s.category_id=' => $cats['id'], 's.status!=' => 9, 's.restaurant_id' => $restaurant_id);
					$columns = "s.*";
					$join = array(TBL_CATEGORIES . ' as c' => "c.id=s.category_id",);
					$group_by = 's.id';
					$get_subcat =  $this->Common_model->get_all_rows(TBL_SUBCATEGORIES . ' as s', $columns, $where, $join, array('s.title' => 'asc'), '2,0', 'LEFT', array(), $group_by, array(), array());
					$subcatResponse = array();
					if (!empty($get_subcat)) {
						foreach ($get_subcat as $subcat) {
							$subcatRes['id'] = $subcat['id'];
							$subcatRes['status'] = $subcat['status'];
							$subcatRes['name'] = urldecode($subcat['title']);
							$subcatRes['image'] = $this->getImage($subcat['image'], 'subcategory');
							$subcatRes['price'] = $subcat['price'];
							$subcatRes['discount'] = $subcat['discount'];
							$subcatRes['discount_type'] = $subcat['discount_type'];
							$subcatRes['type'] = $subcat['type'];
							$subcatRes['description'] = urldecode($subcat['description']);

							$subcatResponse[] = $subcatRes;
						}
					}

					$catRes['subcategories'] = $subcatResponse;
					$catResponse[] = $catRes;
				}
			}

			$get_last_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.*, u.fullname, u.image, a.city as city_name',array('rr.restaurant_id'=>$restaurant_id, 'rr.status'=>1),array(TBL_USERS.' as u'=>'u.id=rr.customer_id', TBL_ORDERS.' as o'=>'o.id=rr.order_id', TBL_ADDRESS.' as a'=>'a.id=o.address_id'), array('rr.id'=>'desc'), '2,0', 'LEFT', array(), 'rr.id', array(), array());

			$reviewResponse = array();
			if (!empty($get_last_review)) {
				foreach ($get_last_review as $rev) {
					$revRes['review'] = $rev['review'];
					$revRes['message'] = urldecode($rev['message']);
					$revRes['user_name'] = urldecode($rev['fullname']);
					$revRes['user_image'] = $this->getImage($rev['image'], 'user');
					$revRes['city'] = urldecode($rev['city_name']);
					$revRes['date'] = date('d M, Y', strtotime($rev['created']));
					$reviewResponse[] = $revRes;
				}
			}
			$restData['reviews'] = $reviewResponse;
			$restData['categories'] = $catResponse;
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $restData;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	function order_details($order_id)
	{

		header('Content-type: application/x-www-form-urlencoded');
		//$requestData = json_decode($this->input->raw_input_stream);
		//$order_id = $requestData->order_id;
		$get_order =  $this->Common_model->get_single_by_query("SELECT o.*, r.name, r.profile_image, r.address, a.address_line_1, a.address_line_2, a.phone, r.id as restaurant_id, a.latitude, a.longitude FROM " . TBL_ORDERS . " as o INNER JOIN " . TBL_RESTAURANTS . " as r ON r.id=o.restaurent_id INNER JOIN " . TBL_ADDRESS . " as a ON a.id=o.address_id WHERE o.id=" . $order_id . " and o.status=1");
		if (!empty($get_order)) {
			$get_driver =  $this->Common_model->get_single_row(TBL_ORDER_DRIVERS, 'driver_id', array('order_id' => $order_id, 'status' => 1, 'driver_status'=>1));
			$restData['order_id'] = $get_order->id;
			$restData['restaurant_id'] = $get_order->restaurant_id;
			$restData['latitude'] = $get_order->latitude;
			$restData['longitude'] = $get_order->longitude;
			$restData['driver_id'] = !empty($get_driver) ? $get_driver->driver_id : "";
			$restData['isReviewed'] = $get_order->isReviewed;
			$restData['name'] = urldecode($get_order->name);
			$restData['banner_image'] = $this->getImage(explode(',', $get_order->profile_image)[0], 'restaurants/profile');
			$restData['address'] = urldecode($get_order->address);
			$restData['date'] = $get_order->created;
			$restData['total_price'] = $get_order->total_price;
			$restData['tip_price'] = $get_order->tip_price;
			$restData['discount_price'] = $get_order->discount_price;
			$restData['payment_type'] = $get_order->payment_type;
			$restData['order_status'] = $get_order->order_status;
			$restData['delivery_address'] = $get_order->address_line_1 . ' ' . $get_order->address_line_2;
			$restData['phone'] = $get_order->phone;
			$where = array('od.order_id=' => $order_id, 'od.status' => 1);
			$columns = "od.*, p.type, p.title, p.discount, p.price, p.image, p.description";
			$join = array(TBL_SUBCATEGORIES . ' as p' => "od.product_id=p.id");
			$group_by = 'od.id';
			$get_order_details =  $this->Common_model->get_all_rows(TBL_ORDERDETAIL . ' as od', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
			$odResponse = array();
			if (!empty($get_order_details)) {
				foreach ($get_order_details as $oDetails) {
					$odRes['product_name'] = urldecode($oDetails['title']);
					$odRes['product_price'] = $oDetails['product_price'];
					$odRes['extra_note'] = urldecode($oDetails['extra_note']);
					$odRes['product_quantity'] = $oDetails['product_quantity'];
					$odRes['product_id'] = $oDetails['product_id'];
					$odRes['type'] = $oDetails['type'];
					$odRes['discount'] = $oDetails['discount'];
					$odRes['price'] = $oDetails['price'];
					$odRes['description'] = $oDetails['description'];
					$odRes['image'] = $this->getImage($oDetails['image'], 'subcategory');

					$odResponse[] = $odRes;
				}
			}
			$restData['products'] = $odResponse;
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $restData;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function categories()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$get_categories =  $this->Common_model->get_all_rows(TBL_CATEGORIES . ' as c', 'c.*, COUNT(s.category_id) as total',array('c.status'=>1),array(TBL_SUBCATEGORIES.' as s'=>'s.category_id=c.id'), array(), '', 'LEFT', array(), 'c.id', array(), array());
		if (!empty($get_categories)) {

			foreach ($get_categories as $cats) {
				$catRes['category_name'] = urldecode($cats['title']);
				$catRes['image'] = $this->getImage($cats['image'], 'category');;
				$catRes['category_id'] = $cats['id'];
				$catRes['total_count'] = $cats['total'];
				$catResponse[] = $catRes;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $catResponse;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function getCountry() {
		header('Content-type: application/x-www-form-urlencoded');
		$get_country =  $this->Common_model->get_all_rows(TBL_COUNTRY . ' as c', 'c.*',array('c.status'=>1),array(), array(), '', 'LEFT', array(), 'c.id', array(), array());
		if (!empty($get_country)) {

			foreach ($get_country as $cats) {
				$catRes['country_name'] = urldecode($cats['name']);
				$catRes['country_id'] = $cats['id'];
				$catResponse[] = $catRes;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $catResponse;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function getState($country_id) {
		header('Content-type: application/x-www-form-urlencoded');
		$get_state =  $this->Common_model->get_all_rows(TBL_STATE . ' as s', 's.*',array('s.status'=>1,  's.country_id'=>$country_id),array(), array(), '', 'LEFT', array(), 's.id', array(), array());
		if (!empty($get_state)) {

			foreach ($get_state as $cats) {
				$catRes['state_name'] = urldecode($cats['name']);
				$catRes['state_id'] = $cats['id'];
				$catResponse[] = $catRes;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $catResponse;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function getCity($state_id) {
		header('Content-type: application/x-www-form-urlencoded');
		$get_state =  $this->Common_model->get_all_rows(TBL_CITY . ' as c', 'c.*',array('c.status'=>1, 'c.state_id'=>$state_id),array(), array(), '', 'LEFT', array(), 'c.id', array(), array());
		if (!empty($get_state)) {

			foreach ($get_state as $cats) {
				$catRes['city_name'] = urldecode($cats['name']);
				$catRes['city_id'] = $cats['id'];
				$catResponse[] = $catRes;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $catResponse;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function addUpdateRestaurant($restaurant_id=null) {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$data_array['name']=urlencode($requestData->name);
		$data_array['owner_id']=$requestData->owner_id;
		$data_array['email']=urlencode($requestData->email);
		$data_array['phone']=$requestData->phone;
		$data_array['city_id']=$requestData->city_id;
		$data_array['state_id']=$requestData->state_id;
		$data_array['country_id']=$requestData->country_id;
		$data_array['pincode']=$requestData->pincode;
		$data_array['address']=urlencode($requestData->address);
		$data_array['discount']=$requestData->discount;
		$data_array['discount_type']=$requestData->discount_type;
		$data_array['average_price']=$requestData->average_price;
		$data_array['opening_time']=date('H:i:s', strtotime($requestData->opening_time));
		$data_array['closing_time']=date('H:i:s', strtotime($requestData->closing_time));
		
		
		$address = urldecode($data_array['address']).' '.$data_array['pincode'];
		$prepAddr = str_replace(' ','+',$address);
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false'.'&key='.$this->settings->map_api_key);
		$output= json_decode($geocode);
		if($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
			$latitude = $output->results[0]->geometry->location->lat;
			$longitude = $output->results[0]->geometry->location->lng;
			$data_array['latitude']=$latitude;
			$data_array['longitude']=$longitude;
			if(isset($requestData->profile_image) && $requestData->profile_image !="") {
				$image_base64 = base64_decode($requestData->profile_image);
				$file_name= uniqid() .'.jpg';
				$file = UPLOAD_PATH.'restaurants/profile/' . $file_name;
				file_put_contents($file, $image_base64);
				$data_array['profile_image']= $file_name;
			}
			if($restaurant_id) {
				$data_array['updated']=$this->utc_time;
				$this->Common_model->update(TBL_RESTAURANTS, $data_array, array('id'=>$restaurant_id));
			}else {
				$data_array['created']=$this->utc_time;
				$this->Common_model->insert(TBL_RESTAURANTS, $data_array);
			}
			
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
		}else {
			$data['code'] = NO_DATA;
			$data['message'] = 'Invalid Address';
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function addUpdateProduct($product_id=null) {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$data_array['title']=urlencode($requestData->title);
		$data_array['category_id']=$requestData->category_id;
		$data_array['type']=$requestData->type;
		$data_array['restaurant_id']=$requestData->restaurant_id;
		$data_array['discount_type']=$requestData->discount_type;
		$data_array['price']=$requestData->price;
		$data_array['discount']=$requestData->discount;
		$data_array['description']=urlencode($requestData->description);		
		if(isset($requestData->image) && $requestData->image !="") {
			$image_base64 = base64_decode($requestData->image);
			$file_name= uniqid() .'.png';
			$file = UPLOAD_PATH.'subcategory/' . $file_name;
			file_put_contents($file, $image_base64);
			$data_array['image']= $file_name;
		}
		if($product_id) {
			$data_array['updated']=$this->utc_time;
			$this->Common_model->update(TBL_SUBCATEGORIES, $data_array, array('id'=>$product_id));
		}else {
			$data_array['created']=$this->utc_time;
			$this->Common_model->insert(TBL_SUBCATEGORIES, $data_array);
		}
		
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function get_all_review($restaurant_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$reviewResponse = array();
		$get_last_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.*, u.fullname, u.image, a.city as city_name',array('rr.restaurant_id'=>$restaurant_id, 'rr.status'=>1),array(TBL_USERS.' as u'=>'u.id=rr.customer_id', TBL_ORDERS.' as o'=>'o.id=rr.order_id', TBL_ADDRESS.' as a'=>'a.id=o.address_id'), array('rr.id'=>'desc'), '', 'LEFT', array(), 'rr.id', array(), array());
		if (!empty($get_last_review)) {
			foreach ($get_last_review as $rev) {
				$revRes['review'] = $rev['review'];
				$revRes['message'] = urldecode($rev['message']);
				$revRes['user_name'] = urldecode($rev['fullname']);
				$revRes['city'] = urldecode($rev['city_name']);
				$revRes['user_image'] = $this->getImage($rev['image'], 'user');
				$revRes['date'] = date('d M, Y', strtotime($rev['created']));
				
				$reviewResponse[] = $revRes;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $reviewResponse;
		}else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}

		

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function mealDeal($restaurant_id, $cat_id= null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		
		$finalResponse = array();
		$append_where ="";
		if ($cat_id) {
			$append_where.= " and f.category_id=".$cat_id;
		}
		$get_mealdela = $this->Common_model->get_all_rows_by_query("SELECT f.id, r.id as res_id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name,r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, f.status as f_status, f.category_id, cat.title as category_name, f.type, f.description FROM " . TBL_SUBCATEGORIES . " as f INNER JOIN " . TBL_RESTAURANTS . " as r  ON r.id=f.restaurant_id INNER JOIN " . TBL_CATEGORIES . " as cat  ON cat.id=f.category_id INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id GROUP BY f.id HAVING r_status=1 and s_status=1 and ct_status=1 and c_status=1 and f.status!=9 ".$append_where." and r.id=".$restaurant_id." ORDER BY r.name ASC");
		if (!empty($get_mealdela)) {
			foreach ($get_mealdela as $row) {
				$mealRes['id'] = $row['id'];
				$mealRes['name'] = urldecode($row['title']);
				$mealRes['category_id'] = $row['category_id'];
				$mealRes['category_name'] = urldecode($row['category_name']);
				$mealRes['is_available'] = $row['is_available'];
				$mealRes['status'] = $row['f_status'];
				$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
				$mealRes['image'] = $this->getImage(explode(',', $row['image'])[0], 'subcategory');;
				$mealRes['price'] = $row['price'];
				$mealRes['discount'] = $row['discount'];
				$mealRes['latitude'] = $row['latitude'];
				$mealRes['longitude'] = $row['longitude'];
				$mealRes['discount_type'] = $row['discount_type'];
				$mealRes['type'] = $row['type'];
				$mealRes['description'] = urldecode($row['description']);

				$finalResponse[] = $mealRes;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function notifications()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$owner_id = $requestData->owner_id;

		$list =  $this->Common_model->get_all_rows_by_query("SELECT n.* FROM " . TBL_NOTIFICATIONS . " as n LEFT JOIN " . TBL_USERS . " as u ON u.id=n.user_id  WHERE (n.user_id=" . $owner_id . ") and n.status=1 ORDER BY id DESC");
		$Notifications = array();
		if (count($list) > 0 && !empty($list)) {

			foreach ($list as $lists) {

				$notification['title'] = urldecode($lists['title']);
				$notification['description'] = urldecode($lists['description']);
				$notification['type'] = $lists['type'];
				$notification['type_id'] = $lists['type_id'];
				$notification['date'] = date('d-m-Y h:i a', strtotime($lists['created']));
				$Notifications[] = $notification;
			}


			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $Notifications;
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Record Found.';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function accept_decline_order() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$data_array['order_status']=$requestData->order_status;
		$data_array['updated']=$this->utc_time;
		$this->Common_model->update(TBL_ORDERS, $data_array, array('id'=>$requestData->order_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
	
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function change_restaurant_availability() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$data_array['is_available']=urlencode($requestData->is_available);
		$data_array['updated']=$this->utc_time;
		
		$this->Common_model->update(TBL_RESTAURANTS, $data_array, array('id'=>$requestData->restaurant_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function change_product_availability() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$data_array['status']=urlencode($requestData->status);
		$data_array['updated']=$this->utc_time;
		
		$this->Common_model->update(TBL_SUBCATEGORIES, $data_array, array('id'=>$requestData->product_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function delete_product($product_id) {
		header('Content-type: application/x-www-form-urlencoded');
		$data_array['status']=9;
		$data_array['updated']=$this->utc_time;
		
		$this->Common_model->update(TBL_SUBCATEGORIES, $data_array, array('id'=>$product_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		
		header('Content-type: application/json');
		echo json_encode($data);
	}
	public function delete_restaurant($restaurant_id) {
		header('Content-type: application/x-www-form-urlencoded');
		$data_array['status']=9;
		$data_array['updated']=$this->utc_time;
		
		$this->Common_model->update(TBL_RESTAURANTS, $data_array, array('id'=>$restaurant_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		
		header('Content-type: application/json');
		echo json_encode($data);
	}

			
}
