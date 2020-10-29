<?php
class Drivers extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index(){
    	$this->load->view('index');
	}
	
	
	public function login() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$email= urlencode($requestData->email);
		$password= $requestData->password;
		$device_token= $requestData->device_token;
		$latitude= $requestData->latitude;
		$longitude= $requestData->longitude;
		$get_user=  $this->Common_model->get_single_row(TBL_USERS, 'status, id', array('email'=>$email, 'password'=>md5($password), 'status!='=>9, 'user_type'=>2));
		if(!empty($get_user)){
			$user_status= $get_user->status;
			if($user_status==1){
				$this->Common_model->update(TBL_USERS, array('is_available'=>1, 'updated'=>$this->utc_time, 'latitude'=>$latitude,'longitude'=>$longitude, 'device_token'=>$device_token), array('id'=>$get_user->id));
				
				$get_user=  $this->Common_model->get_single_row(TBL_USERS, '*', array('id'=>$get_user->id));
				
				$getUserAddress=file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&key='.$this->settings->map_api_key);
				
				$addressData=json_decode($getUserAddress);
				$dataStatus = $addressData->status;
				
					
				$user['driver_id']= $get_user->id;
				$user['name']= urldecode($get_user->fullname);
				$user['email']= urldecode($get_user->email);
				$user['profile_image']= $this->getImage($get_user->image, 'user');
				$user['phone']=$get_user->phone;
				$user['address'] = "";
				if($dataStatus=="OK")
				{
					$user['address']=$addressData->results[0]->formatted_address;
				}
				$data['code']=SUCCESS;
				$data['message']= 'Success.';
				$data['result']= $user;
			}else {
				$data['code']=INACTIVE_ACCOUNT;
				$data['message']= 'Your account is inactive.';
				$data['result']= [];
			}
		}else {
			$data['code']=NO_DATA;
			$data['message']= 'Invaid email or password.';
			$data['result']= [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function forgot_password() {

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$email= $requestData->email;

		$get_user=  $this->Common_model->get_single_row(TBL_USERS, 'status, id', array('email'=>urlencode($email), 'status='=>1, 'is_social_login'=>0));
		
		if(!empty($get_user)) {
			$password= substr(str_shuffle("ABCDEFGH1234567890IGHIJKLMNOPQ@!$%^&*RSTUVWXYZ"), 0, 8);
			$addArr['password']= md5($password);
			$addArr['updated']= date('Y-m-d H:i:s');

			
			//
			$sendEmail= $this->sendMailToUser($get_user->id,  $email, 1, $password);
			if($sendEmail) {
				$update= $this->Common_model->update(TBL_USERS, $addArr, array('id'=>$get_user->id));
				$data['code']=SUCCESS;
				$data['message']= 'Password successfully sent to your email id.';
			}else {
				$data['code']=FAILURE;
				$data['message']= 'Failure.';

			}

		}else {
			$data['code']=EMAIL_EXIST;
			$data['message']= 'Email does not exist.';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function logout() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		
		$user_id= $requestData->user_id;
		
		$this->Common_model->update(TBL_USERS, array('is_available'=>0), array('id'=>$user_id));
		$data['code']=SUCCESS;
		$data['message']= 'Logout successfully.';

		header('Content-type: application/json');
		echo json_encode($data);
	}
	
	public function order_details() {

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$order_id= $requestData->order_id;
		$get_order=  $this->Common_model->get_single_by_query("SELECT o.*, r.name, r.profile_image, r.address, a.address_line_1, a.address_line_2, a.phone, a.latitude, a.longitude, r.latitude as r_latitude, r.longitude as r_longitude FROM ".TBL_ORDERS." as o INNER JOIN ".TBL_RESTAURANTS." as r ON r.id=o.restaurent_id INNER JOIN ".TBL_ADDRESS." as a ON a.id=o.address_id WHERE o.id=".$order_id." and o.status=1");
		
		if(!empty($get_order)){
						
			$restData['order_id']= $get_order->id;
			$restData['name']= urldecode($get_order->name);
			$restData['banner_image']= $this->getImage(explode(',',$get_order->profile_image)[0], 'restaurants/profile');
			$restData['address'] = urldecode($get_order->address);
			$restData['date'] = $get_order->created;
			$restData['total_price'] = $get_order->total_price;
			$restData['tip_price'] = $get_order->tip_price;
			$restData['discount_price'] = $get_order->discount_price;
			$restData['payment_type'] = $get_order->payment_type;
			$restData['order_status'] = $get_order->order_status;
			$restData['delivery_address'] = urldecode($get_order->address_line_1) .' '.urldecode($get_order->address_line_2);
			$restData['phone'] = $get_order->phone;
			$restData['latitude'] = $get_order->latitude;
			$restData['longitude'] = $get_order->longitude;
			$restData['r_latitude'] = $get_order->r_latitude;
			$restData['r_longitude'] = $get_order->r_longitude;


			$where = array('od.order_id='=>$order_id, 'od.status'=>1);
			$columns = "od.*, p.type, p.title, p.discount, p.price, p.image, p.description";
			$join = array(TBL_SUBCATEGORIES.' as p'=>"od.product_id=p.id");
			$group_by = 'od.id';
			$get_order_details=  $this->Common_model->get_all_rows(TBL_ORDERDETAIL.' as od', $columns, $where, $join, array(), '', 'LEFT', array(), $group_by, array(), array());
			$odResponse= array();
			if(!empty($get_order_details)){
				foreach($get_order_details as $oDetails){
					$odRes['product_name']= urldecode($oDetails['title']);
					$odRes['product_price']= $oDetails['product_price'];
					$odRes['extra_note']= urldecode($oDetails['extra_note']);
					$odRes['product_quantity']= $oDetails['product_quantity'];	
					$odRes['product_id']= $oDetails['product_id'];
					$odRes['type']= $oDetails['type'];
					$odRes['discount']= $oDetails['discount'];
					$odRes['price']= $oDetails['price'];
					$odRes['description']= urldecode($oDetails['description']);
					$odRes['image']= $this->getImage($oDetails['image'], 'subcategory');
					
					$odResponse[]= $odRes;


					
				}
			}			
			$restData['products'] = $odResponse;
			$data['code']=SUCCESS;
			$data['message']= 'Success.';
			$data['result']= $restData;


			
		}else {
			$data['code']=NO_DATA;
			$data['message']= 'No Data Found.';
			$data['result']= [];
		}
		header('Content-type: application/json');
		echo json_encode($data);

	}
	
	public function profile() {

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id= $requestData->user_id;
		$get_user=  $this->Common_model->get_single_by_query("SELECT u.*, c.name as city_name, s.name as state_name, co.name as country_name FROM ".TBL_USERS." as u INNER JOIN ".TBL_CITY." as c ON c.id=u.city_id INNER JOIN ".TBL_STATE." as s ON s.id=u.state_id INNER JOIN ".TBL_COUNTRY." as co ON co.id=u.country_id WHERE u.status=1 and u.id=".$user_id);
		
		//$this->Common_model->get_single_row(TBL_USERS, '*', array('id'=>$user_id, 'status'=>1));
		if(!empty($get_user)){
			$get_total_tips= $this->Common_model->get_all_rows(TBL_ORDERS.' as o', "SUM(o.tip_price) AS total_tip, COUNT(o.id) as total_delivered_orders", array('o.status'=>1, 'o.order_status'=>5, 'od.driver_id'=>$user_id, 'od.driver_status'=>1, 'od.status'=>1), array(TBL_ORDER_DRIVERS." as od"=>"od.order_id=o.id"), array('o.id'=>'desc'), '', 'INNER', array(),"", array(), array());
			$get_total_rejected_orders= $this->Common_model->get_all_rows(TBL_ORDER_DRIVERS, " COUNT(id) as total_rejected_orders", array('driver_id'=>$user_id, 'driver_status'=>2, 'status'=>1), array(), array(), '', '', array(),"", array(), array());
			
			$get_review =  $this->Common_model->get_all_rows(TBL_DRIVER_REVIEW . ' as dr', 'ROUND( AVG(dr.review),1 ) as review', array('driver_id'=>$user_id), array(), array('dr.id' => 'desc'), '', 'LEFT', array(), 'dr.driver_id', array(), array());

			$dateOfBirth= $get_user->date_of_birth;
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));

			$user['driver_id']= $get_user->id;
			$user['avg_review']= $get_review[0]['review'];
			$user['name']= urldecode($get_user->fullname);
			$user['email']= urldecode($get_user->email);
			$user['profile_image']= $this->getImage($get_user->image, 'user');
			$user['identity_number']= $get_user->identity_number;
			$user['identity_image']= $this->getImage($get_user->identity_image, 'user');
			$user['license_number']= $get_user->license_number;
			$user['license_image']= $this->getImage($get_user->license_image, 'user');
			$user['phone']=$get_user->phone;
			$user['gender']= $get_user->gender;
			$user['date_of_birth']= $get_user->date_of_birth;
			$user['age']= $diff->format('%Y');
			$user['is_available']= $get_user->is_available;
			$user['permenent_address']= urldecode($get_user->address).', '.urldecode($get_user->city_name).', '.urldecode($get_user->state_name).', '.urldecode($get_user->country_name).'-'.$get_user->pincode;
			$user['total_tip']= $get_total_tips[0]['total_tip'];
			$user['total_delivered_orders']= $get_total_tips[0]['total_delivered_orders'];
			$user['total_rejected_orders']= $get_total_rejected_orders[0]['total_rejected_orders'];
			$getUserAddress=file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng='.trim($get_user->latitude).','.trim($get_user->longitude).'&key='.$this->settings->map_api_key);
				
			$addressData=json_decode($getUserAddress);
			$dataStatus = $addressData->status;
			$user['current_address'] = "";
			if($dataStatus=="OK")
			{
				$user['current_address']=$addressData->results[0]->formatted_address;
			}

			$data['code']=SUCCESS;
			$data['message']= 'Success.';
			$data['result']= $user;


		}else {
	
			$data['code']=NO_DATA;
			$data['message']= 'No Data Found.';
			$data['result']= [];
		}
		header('Content-type: application/json');
		echo json_encode($data);

	}

	public function accept_reject_order() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		//$addArr['user_id']= $requestData->user_id;
		$addArr['updated']= $this->utc_time;
		$addArr['driver_status']= $requestData->status;
		$update= $this->Common_model->update(TBL_ORDER_DRIVERS, $addArr, array('driver_id'=>$requestData->user_id, 'order_id'=> $requestData->order_id));
		if($update) {
			
			$data['code']=SUCCESS;
			$data['message']= 'Status changed successfully.';
		}else {
			$data['code']=FAILURE;
			$data['message']= 'Failure.';

		}

		header('Content-type: application/json');
		echo json_encode($data);

	}

	function orders_list() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id= $requestData->user_id;
		$where = array('od.driver_id='=>$user_id, 'o.status'=>1, 'od.driver_status!='=>2, 'o.order_status!='=>5);
		$columns = "o.order_status, o.total_price, o.id, o.created, o.updated, od.driver_status,  r.name, r.profile_image, r.address, r.pincode, o.user_id";
		$join = array(TBL_RESTAURANTS.' as r'=>"r.id=o.restaurent_id", TBL_ORDER_DRIVERS." as od"=>"od.order_id=o.id");
		$group_by = 'o.id';
		$get_data=  $this->Common_model->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '', 'LEFT', array(), $group_by, array(), array());

	
		$ordResponse= array();
		if(!empty($get_data)){
			foreach($get_data as $ord){
				$ordRes['name']= urldecode($ord['name']);
				$ordRes['banner_image']= $this->getImage(explode(',',$ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address']= urldecode($ord['address']);
				$ordRes['pincode']= $ord['pincode'];
				$ordRes['order_id']= $ord['id'];
				$ordRes['user_id']= $ord['user_id'];
				$ordRes['order_status']= $ord['order_status'];
				$ordRes['total_price']= $ord['total_price'];
				$ordRes['created']= $ord['created'];
				$ordRes['updated']= $ord['updated'];
				$ordRes['driver_status']= $ord['driver_status']; 
				$ordResponse[] = $ordRes;				
			
			}
		
		
			$data['code']=SUCCESS;
			$data['message']= 'Success.';
			$data['result']= $ordResponse;


		}else {
	
			$data['code']=NO_DATA;
			$data['message']= 'No Data Found.';
			$data['result']= [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function change_order_status() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$driver_id= $requestData->driver_id;
		$lat= $requestData->latitude;
		$long= $requestData->longitude;
		$addArr['updated']= $this->utc_time;
		$addArr['order_status']= $requestData->status;
		if(isset($requestData->signature) && $requestData->signature !="") {
			$image_base64 = base64_decode($requestData->signature);
		    $file_name= uniqid() .'.png';
		    $file = UPLOAD_PATH.'signature/' . $file_name;
		    file_put_contents($file, $image_base64);
		    $addArr['signature']= $file_name;
		}
		$getOrder=  $this->Common_model->get_single_row(TBL_ORDERS, 'restaurent_id', array('id' => $requestData->restaurent_id, 'status' => 1));
		$update= $this->Common_model->update(TBL_ORDERS, $addArr, array('id'=>$requestData->order_id));
		//if($update) {
			$addNotification= array();
			
			$addNotification['type'] = "1";
			$addNotification['type_id'] = $requestData->order_id;
			$addNotification['user_id']= $requestData->user_id;
			$addNotification['created']= $this->utc_time;
			$addNotification['updated']= $this->utc_time;
			if($addArr['order_status']==6) {
				$addNotification['title'] = urlencode("Order picked up");
				$addNotification['Description'] = urlencode("Your order has been picked up from restaurant.");
			}else if($addArr['order_status']==5) {
				$addNotification['title'] = urlencode("Order Delivered");
				$addNotification['Description'] = urlencode("Your order delivered successfully");
				$getOwner=  $this->Common_model->get_single_row(TBL_RESTAURANTS, 'owner_id', array('id' => $getOrder->restaurent_id, 'status' => 1));
				$ownerNotification = array();
				$ownerNotification['title'] = urlencode("Order Delivered");
				$ownerNotification['Description'] = urlencode("Congratulations!!, Your order has been delivered.");
				$ownerNotification['type'] = "3";
				$ownerNotification['type_id'] = $requestData->order_id;
				$ownerNotification['user_id'] = $getOwner->owner_id;
				$ownerNotification['created'] = date('Y-m-d H:i:s');
				$ownerNotification['updated'] = date('Y-m-d H:i:s');
				$this->Common_model->insert(TBL_NOTIFICATIONS, $ownerNotification);
				$notification_id = $this->db->insert_id();
				$this->sendPushNotification($getOwner->owner_id, $notification_id, 'owners');
			}
			$this->Common_model->insert(TBL_NOTIFICATIONS, $addNotification);
			$notification_id= $this->db->insert_id();
			$this->sendPushNotification($requestData->user_id, $notification_id, "driver");
			$this->Common_model->update(TBL_USERS, array('latitude'=>$lat, 'longitude'=>$long, 'updated'=>$this->utc_time), array('id'=>$driver_id));
			
			$data['code']=SUCCESS;
			$data['message']= 'Status changed successfully.';
		// }else {
		// 	$data['code']=FAILURE;
		// 	$data['message']= 'Failure.';

		// }
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function notifications() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id= $requestData->user_id;
			
		$list=  $this->Common_model->get_all_rows_by_query("SELECT n.* FROM ".TBL_NOTIFICATIONS." as n LEFT JOIN ".TBL_USERS." as u ON u.id=n.user_id  WHERE n.user_id=".$user_id." and n.status=1 and type=2 ORDER BY id DESC");
		$Notifications= array();
		if(count($list)>0 && !empty($list)) {

			foreach($list as $lists){
				
				$notification['title']= urldecode($lists['title']);
				$notification['description']= urldecode($lists['description']);
				$notification['type']= $lists['type'];
				$notification['type_id']= $lists['type_id'];
				$notification['date']= date('d-m-Y h:i a', strtotime($lists['created']));
				$Notifications[]= $notification;
			}


			$data['code']=SUCCESS;
			$data['message']= 'Success.';
			$data['result']= $Notifications;
		}else {
			$data['code']=NO_DATA;
			$data['message']= 'No Record Found.';
		}

		header('Content-type: application/json');
		echo json_encode($data);

	}


	function orders_history() {
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id= $requestData->user_id;
		
		$get_data = $this->Common_model->get_all_rows_by_query("SELECT o.order_status, o.total_price, o.id, o.created, o.updated, od.driver_status,  r.name, r.profile_image, r.address, r.pincode, o.user_id FROM ".TBL_ORDERS." as o INNER JOIN ".TBL_RESTAURANTS." as r ON r.id=o.restaurent_id INNER JOIN ".TBL_ORDER_DRIVERS." as od ON od.order_id=o.id WHERE od.driver_id=".$user_id ." AND ((od.driver_status =1 AND o.order_status=5) OR od.driver_status =2) AND o.status=1");
	
		$ordResponse= array();
		if(!empty($get_data)){
			foreach($get_data as $ord){
				$ordRes['name']= urldecode($ord['name']);
				$ordRes['banner_image']= $this->getImage(explode(',',$ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address']= urldecode($ord['address']);
				$ordRes['pincode']= $ord['pincode'];
				$ordRes['order_id']= $ord['id'];
				$ordRes['user_id']= $ord['user_id'];
				$ordRes['order_status']= $ord['order_status'];
				$ordRes['total_price']= $ord['total_price'];
				$ordRes['created']= $ord['created'];
				$ordRes['updated']= $ord['updated'];
				$ordRes['driver_status']= $ord['driver_status']; 
				$ordResponse[] = $ordRes;				
			
			}
		
		
			$data['code']=SUCCESS;
			$data['message']= 'Success.';
			$data['result']= $ordResponse;


		}else {
	
			$data['code']=NO_DATA;
			$data['message']= 'No Data Found.';
			$data['result']= [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function change_availability_status() {

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$addArr['updated']= $this->utc_time;
		$addArr['is_available']= $requestData->status;
		$update= $this->Common_model->update(TBL_USERS, $addArr, array('id'=> $requestData->driver_id));
		//echo $this->db->last_query();
		//die;
		if($update) {
			
			$data['code']=SUCCESS;
			$data['message']= 'Status changed successfully.';
		}else {
			$data['code']=FAILURE;
			$data['message']= 'Failure.';

		}

		header('Content-type: application/json');
		echo json_encode($data);

	}

	public function update_driver_location()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$driver_id = $requestData->driver_id;
		$addArr['latitude'] = $requestData->latitude;
		$addArr['longitude'] = urlencode($requestData->longitude);
		$addArr['updated'] = date('Y-m-d H:i:s');
	
		
			

		$this->Common_model->update(TBL_USERS, $addArr, array('id' => $driver_id));
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = [];
			
		
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function get_all_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$driver_id = $requestData->driver_id;
		
		$reviewResponse = array();
		$get_last_review =  $this->Common_model->get_all_rows(TBL_DRIVER_REVIEW . ' as dr', 'dr.*, u.fullname, u.image, a.city as city_name',array('dr.driver_id'=>$driver_id, 'dr.status'=>1),array(TBL_USERS.' as u'=>'u.id=dr.customer_id', TBL_ORDERS.' as o'=>'o.id=dr.order_id', TBL_ADDRESS.' as a'=>'a.id=o.address_id'), array('dr.id'=>'desc'), '', 'LEFT', array(), 'dr.id', array(), array());
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

	
}


