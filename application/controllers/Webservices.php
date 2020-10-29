<?php
class Webservices extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function home()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$lat = $requestData->latitude;
		$long = $requestData->longitude;
		$bannerResponse = $topResponse = $mealDealResponse = $popularResponse = $catResponse = $codeResponse = array();
		$get_banner_restaurants = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance,  ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id LEFT JOIN " . TBL_RESTAURANT_REVIEW . " as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING r_status=1  and s_status=1 and ct_status=1 and c_status=1 ORDER BY distance ASC LIMIT 5,5");

		if (!empty($get_banner_restaurants)) {
			foreach ($get_banner_restaurants as $row) {
				$bannerRes['id'] = $row['id'];
				$bannerRes['review'] = $row['review'];
				$bannerRes['is_available'] = $row['is_available'];
				$bannerRes['name'] = urldecode($row['name']);
				$bannerRes['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$bannerRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$bannerRes['discount'] = $row['discount'];
				$bannerRes['latitude'] = $row['latitude'];
				$bannerRes['longitude'] = $row['longitude'];
				$bannerRes['discount_type'] = $row['discount_type'];

				$bannerResponse[] = $bannerRes;
			}
		}

		$get_popular_restaurants =  $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id INNER JOIN " . TBL_ORDERS . " as o ON o.restaurent_id=r.id LEFT JOIN " . TBL_RESTAURANT_REVIEW . " as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING   r_status=1 and s_status=1 and ct_status=1 and c_status=1 ORDER BY distance ASC LIMIT 0,10");
		if (!empty($get_popular_restaurants)) {
			foreach ($get_popular_restaurants as $row) {
				$popRes['id'] = $row['id'];
				$popRes['review'] = $row['review'];
				$popRes['is_available'] = $row['is_available'];
				$popRes['name'] = urldecode($row['name']);
				$popRes['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');;
				$popRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$popRes['discount'] = $row['discount'];
				$popRes['latitude'] = $row['latitude'];
				$popRes['longitude'] = $row['longitude'];
				$popRes['discount_type'] = $row['discount_type'];

				$popularResponse[] = $popRes;
			}
		}


		$get_top_restaurants = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id LEFT JOIN " . TBL_RESTAURANT_REVIEW . " as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING  r_status=1 and s_status=1 and ct_status=1 and c_status=1 ORDER BY distance ASC LIMIT 0,10");
		if (!empty($get_top_restaurants)) {
			foreach ($get_top_restaurants as $row) {
				$topRes['id'] = $row['id'];
				$topRes['review'] = $row['review'];
				$topRes['name'] = urldecode($row['name']);
				$topRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$topRes['is_available'] = $row['is_available'];
				$topRes['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');;
				$topRes['latitude'] = $row['latitude'];
				$topRes['longitude'] = $row['longitude'];

				$topResponse[] = $topRes;
			}
		}
		$get_mealdela = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name,r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, f.status as f_status, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance FROM " . TBL_SUBCATEGORIES . " as f INNER JOIN " . TBL_RESTAURANTS . " as r  ON r.id=f.restaurant_id INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id GROUP BY f.id HAVING r_status=1  and s_status=1 and ct_status=1 and c_status=1 and f_status!=9 ORDER BY distance ASC LIMIT 0,10");

		//echo $this->db->last_query();
		//die;

		if (!empty($get_mealdela)) {
			foreach ($get_mealdela as $row) {
				$mealRes['id'] = $row['id'];
				$mealRes['name'] = urldecode($row['title']);
				$mealrRes['is_available'] = $row['is_available'];
				$mealRes['status'] = $row['f_status'];
				$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
				$mealRes['image'] = $this->getImage(explode(',', $row['image'])[0], 'subcategory');;
				$mealRes['price'] = $row['price'];
				$mealRes['discount'] = $row['discount'];
				$mealRes['latitude'] = $row['latitude'];
				$mealRes['longitude'] = $row['longitude'];
				$mealRes['discount_type'] = $row['discount_type'];

				$mealDealResponse[] = $mealRes;
			}
		}

		$get_categories =  $this->Common_model->get_all_rows(TBL_CATEGORIES . ' as c', 'c.*, COUNT(s.category_id) as total', array('c.status' => 1), array(TBL_SUBCATEGORIES . ' as s' => 's.category_id=c.id'), array(), '10,0', 'LEFT', array(), 'c.id', array(), array());
		if (!empty($get_categories)) {

			foreach ($get_categories as $cats) {
				$catRes['category_name'] = urldecode($cats['title']);
				$catRes['image'] = $this->getImage($cats['image'], 'category');;
				$catRes['category_id'] = $cats['id'];
				$catRes['total_count'] = $cats['total'];
				$catResponse1[] = $catRes;
			}

			$catResponse = $catResponse1;
		}
		$current_date = date('Y-m-d');
		$get_codes =  $this->Common_model->get_all_rows(TBL_COUPONS . ' as c', 'c.*, ROUND(c.discount, 0) as discount', array('c.status' => 1, 'c.end_date >= ' => $current_date), array(), array('c.end_date' => 'asc'), '10,0', 'LEFT', array(), 'c.id', array(), array());
		if (!empty($get_codes)) {

			foreach ($get_codes as $codes) {
				$codeRes['coupon_code'] = $codes['coupon_code'];
				$codeRes['image'] = $this->getImage($codes['image'], 'coupons');;
				$codeRes['id'] = $codes['id'];
				$codeRes['description'] = urldecode($codes['description']);
				$codeRes['start_date'] = date('dS M, Y', strtotime($codes['start_date']));
				$codeRes['end_date'] = date('dS M, Y', strtotime($codes['end_date']));
				$codeRes['discount'] = $codes['discount'];
				$codeRes['discount_type'] = $codes['discount_type'];
				$codeResponse1[] = $codeRes;
			}

			$codeResponse = $codeResponse1;
		}

		$finalResponse['coupon_codes'] = $codeResponse;
		$finalResponse['categories'] = $catResponse;
		$finalResponse['bannerRestaurents'] = $bannerResponse;
		$finalResponse['topRestaurents'] = $topResponse;
		$finalResponse['popularRestaurents'] = $popularResponse;
		$finalResponse['mealDeal'] = $mealDealResponse;
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function login()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$email = urlencode($requestData->email);
		$password = $requestData->password;
		$device_token = $requestData->device_token;
		$latitude = $requestData->latitude;
		$longitude = $requestData->longitude;
		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'status, id', array('email' => $email, 'password' => md5($password), 'status!=' => 2));
		if (!empty($get_user)) {
			$user_status = $get_user->status;
			if ($user_status == 1) {

				$get_user =  $this->Common_model->get_single_row(TBL_USERS, '*', array('id' => $get_user->id));
				$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 0, 'updated' => $this->utc_time), array('user_id' => $get_user->id));
				$find_device_tokens = $this->Common_model->get_single_row(TBL_DEVICE_TOKENS, 'id', array('device_token' => $device_token));
				if (!empty($find_device_tokens)) {
					$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 1, 'user_id' => $get_user->id), array('id' => $find_device_tokens->id, 'updated' => $this->utc_time));
				} else {
					$insertTokenArr = array('user_id' => $get_user->id, 'device_token' => $device_token, 'created' => $this->utc_time, 'updated' => $this->utc_time);
					$this->Common_model->insert(TBL_DEVICE_TOKENS, $insertTokenArr);
				}
				$this->Common_model->update(TBL_USERS, array('latitude' => $latitude, 'longitude' => $longitude), array('id' => $get_user->id));

				$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&key=' . $this->settings->map_api_key);

				$addressData = json_decode($getUserAddress);
				$dataStatus = $addressData->status;


				$user['user_id'] = $get_user->id;
				$user['name'] = urldecode($get_user->fullname);
				$user['email'] = urldecode($get_user->email);
				$user['profile_image'] = $this->getImage($get_user->image, 'user');
				$user['phone'] = $get_user->phone;
				$user['address'] = "";
				if ($dataStatus == "OK") {
					$user['address'] = $addressData->results[0]->formatted_address;
				}
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

	public function registration()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$addArr['email'] = urlencode($requestData->email);
		$addArr['password'] = md5($requestData->password);
		$addArr['fullname'] = urlencode($requestData->name);
		$addArr['phone'] = $requestData->phone;
		$addArr['latitude'] = $requestData->latitude;
		$addArr['longitude'] = $requestData->longitude;
		$addArr['image'] = "";
		$addArr['created'] = date('Y-m-d H:i:s');
		$addArr['updated'] = date('Y-m-d H:i:s');
		$addArr['token'] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
		$get_user =  $this->Common_model->get_all_row(TBL_USERS, 'id', array('email' => $addArr['email'], 'status!=' => 2, 'is_social_login' => 0));
		if (!empty($get_user)) {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Email id already exist.';
			$data['result'] = [];
		} else {
			$insert = $this->Common_model->insert(TBL_USERS, $addArr);
			if ($insert) {
				$device_token = $requestData->device_token;
				$insert_id = $this->db->insert_id();
				$find_device_tokens = $this->Common_model->get_single_row(TBL_DEVICE_TOKENS, 'id', array('device_token' => $device_token));
				if (!empty($find_device_tokens)) {
					$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 1, 'user_id' => $insert_id), array('id' => $find_device_tokens->id, 'updated' => $this->utc_time));
				} else {
					$insertTokenArr = array('user_id' => $insert_id, 'device_token' => $device_token, 'created' => $this->utc_time, 'updated' => $this->utc_time);
					$this->Common_model->insert(TBL_DEVICE_TOKENS, $insertTokenArr);
				}
				$get_user =  $this->Common_model->get_single_row(TBL_USERS, '*', array('id' => $insert_id));
				$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($get_user->latitude) . ',' . trim($get_user->longitude) . '&key=' . $this->settings->map_api_key);

				$addressData = json_decode($getUserAddress);
				$dataStatus = $addressData->status;

				$user['user_id'] = $get_user->id;
				$user['name'] = urldecode($get_user->fullname);
				$user['email'] = urldecode($get_user->email);
				$user['profile_image'] = $this->getImage($get_user->image, 'user');
				$user['phone'] = $get_user->phone;
				$user['address'] = "";
				if ($dataStatus == "OK") {
					$user['address'] = urlencode($addressData->results[0]->formatted_address);
				}
				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = $user;
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function social_signin()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);

		$device_token = $requestData->device_token;
		$addArr['latitude'] = $requestData->latitude;
		$addArr['longitude'] = $requestData->longitude;
		$addArr['updated'] = date('Y-m-d H:i:s');
		$addArr['token'] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
		$addArr['social_id'] = $requestData->social_id;

		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'id', array('social_id' => $addArr['social_id'], 'status!=' => 2));
		if (!empty($get_user)) {
			$update = $this->Common_model->update(TBL_USERS, $addArr, array('id' => $get_user->id));
		} else {
			$addArr['email'] = urlencode($requestData->email);
			$addArr['fullname'] = urlencode($requestData->name);
			$addArr['image'] = $requestData->profile_image;
			$addArr['password'] = "";
			$addArr['phone'] = $requestData->phone;
			$addArr['is_social_login'] = $requestData->is_social_login; //1=>facebook, 2==>googge
			$addArr['created'] = date('Y-m-d H:i:s');
			$update = $this->Common_model->insert(TBL_USERS, $addArr);
		}
		if ($update) {
			$insert_id = empty($get_user) ? $this->db->insert_id() : $get_user->id;
			$get_user =  $this->Common_model->get_single_row(TBL_USERS, '*', array('id' => $insert_id));
			$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 0, 'updated' => $this->utc_time), array('user_id' => $get_user->id));
			$find_device_tokens = $this->Common_model->get_single_row(TBL_DEVICE_TOKENS, 'id', array('device_token' => $device_token));
			if (!empty($find_device_tokens)) {
				$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 1, 'user_id' => $get_user->id), array('id' => $find_device_tokens->id, 'updated' => $this->utc_time));
			} else {
				$insertTokenArr = array('user_id' => $get_user->id, 'device_token' => $device_token, 'created' => $this->utc_time, 'updated' => $this->utc_time);
				$this->Common_model->insert(TBL_DEVICE_TOKENS, $insertTokenArr);
			}
			$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($get_user->latitude) . ',' . trim($get_user->longitude) . '&key=' . $this->settings->map_api_key);

			$addressData = json_decode($getUserAddress);
			$dataStatus = $addressData->status;

			$user['user_id'] = $get_user->id;
			$user['name'] = urldecode($get_user->fullname);
			$user['email'] = urldecode($get_user->email);
			$user['profile_image'] = $this->getImage($get_user->image, 'user');
			$user['phone'] = $get_user->phone;
			$user['address'] = "";
			if ($dataStatus == "OK") {
				$user['address'] = $addressData->results[0]->formatted_address;
			}
			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = $user;
		} else {
			$data['code'] = FAILURE;
			$data['message'] = 'Failure.';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}
	public function forgot_password()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		//print_r($requestData);
		//die;
		$email = $requestData->email;

		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'status, id', array('email' => urlencode($email), 'status=' => 1, 'is_social_login' => 0));
		//echo $this->db->last_query();
		//die;
		if (!empty($get_user)) {
			$password = substr(str_shuffle("ABCDEFGH1234567890IGHIJKLMNOPQ@!$%^&*RSTUVWXYZ"), 0, 8);
			$addArr['password'] = md5($password);
			$addArr['updated'] = date('Y-m-d H:i:s');


			//
			$sendEmail = $this->sendMailToUser($get_user->id,  $email, 1, $password);
			if ($sendEmail) {
				$update = $this->Common_model->update(TBL_USERS, $addArr, array('id' => $get_user->id));
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

		$user_id = $requestData->user_id;
		$device_token = $requestData->device_token;

		$this->Common_model->update(TBL_DEVICE_TOKENS, array('is_last_login' => 0), array('user_id' => $user_id, 'device_token' => $device_token));
		$data['code'] = SUCCESS;
		$data['message'] = 'Logout successfully.';

		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function notifications()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;

		$list =  $this->Common_model->get_all_rows_by_query("SELECT n.* FROM " . TBL_NOTIFICATIONS . " as n LEFT JOIN " . TBL_USERS . " as u ON u.id=n.user_id  WHERE (n.user_id =0 OR n.user_id=" . $user_id . ") and n.status=1 ORDER BY id DESC");
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

	public function details()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$restaurant_id = $requestData->restaurant_id;
		$get_restaurant =  $this->Common_model->get_single_row(TBL_RESTAURANTS, '*', array('id' => $restaurant_id, 'status' => 1));
		if (!empty($get_restaurant)) {


			$get_avg_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'ROUND( AVG(rr.review),1 ) as review', array('restaurant_id' => $restaurant_id, 'status' => 1), array(), array(), '', 'LEFT', array(), 'rr.restaurant_id', array(), array());

			$restData['restaurant_id'] = $restaurant_id;
			$restData['avg_review'] = null;
			if (!empty($get_avg_review)) {
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
			$get_categories =  $this->Common_model->get_all_rows(TBL_CATEGORIES . ' as c', $columns, $where, $join, array('c.title' => 'asc'), '', 'LEFT', array(), $group_by, array(), array());
			$catResponse = array();
			if (!empty($get_categories)) {
				foreach ($get_categories as $cats) {
					$catRes['category_name'] = urldecode($cats['title']);
					$catRes['category_id'] = $cats['id'];
					$where = array('s.category_id=' => $cats['id'], 's.status!=' => 9, 's.restaurant_id' => $restaurant_id);
					$columns = "s.*";
					$join = array(TBL_CATEGORIES . ' as c' => "c.id=s.category_id",);
					$group_by = 's.id';
					$get_subcat =  $this->Common_model->get_all_rows(TBL_SUBCATEGORIES . ' as s', $columns, $where, $join, array('s.title' => 'asc'), '', 'LEFT', array(), $group_by, array(), array());
					$subcatResponse = array();
					if (!empty($get_subcat)) {
						foreach ($get_subcat as $subcat) {
							$subcatRes['id'] = $subcat['id'];
							$subcatRes['is_available'] = $subcat['status'];
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

			$get_last_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.*, u.fullname, u.image, a.city as city_name', array('rr.restaurant_id' => $restaurant_id, 'rr.status' => 1), array(TBL_USERS . ' as u' => 'u.id=rr.customer_id', TBL_ORDERS . ' as o' => 'o.id=rr.order_id', TBL_ADDRESS . ' as a' => 'a.id=o.address_id'), array('rr.id' => 'desc'), '2,0', 'LEFT', array(), 'rr.id', array(), array());

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


	public function all_top_restaurants()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$lat = $requestData->latitude;
		$long = $requestData->longitude;
		$finalResponse = array();

		$get_top_restaurants = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id LEFT JOIN " . TBL_RESTAURANT_REVIEW . " as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING   r_status=1  and s_status=1 and ct_status=1 and c_status=1 ORDER BY distance ASC");
		if (!empty($get_top_restaurants)) {
			foreach ($get_top_restaurants as $row) {
				$res['id'] = $row['id'];
				$res['review'] = $row['review'];
				$res['is_available'] = $row['is_available'];
				$res['name'] = urldecode($row['name']);
				$res['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$res['discount'] = $row['discount'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['discount_type'] = $row['discount_type'];

				$finalResponse[] = $res;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function add_user_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$addArr['user_id'] = $requestData->user_id;
		$addArr['name'] = urlencode($requestData->name);
		$addArr['phone'] = $requestData->phone;
		$addArr['address_line_1'] = urlencode($requestData->address_line_1);
		$addArr['address_line_2'] = urlencode($requestData->address_line_2);
		$addArr['pincode'] = $requestData->pincode;
		$addArr['latitude'] = $requestData->latitude;
		$addArr['longitude'] = $requestData->longitude;
		$addArr['city'] = urlencode($requestData->city);
		$addArr['state'] = urlencode($requestData->state);
		$addArr['country'] = urlencode($requestData->country);
		$addArr['isDefault'] = $requestData->isDefault;
		$addArr['address_type'] = $requestData->address_type;
		$addArr['created'] = date('Y-m-d H:i:s');
		$addArr['updated'] = date('Y-m-d H:i:s');
		$get_address =  $this->Common_model->get_all_row(TBL_ADDRESS, 'id', array('latitude' => $addArr['latitude'], 'status!=' => 2, 'longitude' => $addArr['longitude'], 'user_id' => $addArr['user_id']));
		if (!empty($get_address)) {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Address already exist.';
			$data['result'] = [];
		} else {
			$insert = $this->Common_model->insert(TBL_ADDRESS, $addArr);
			if ($insert) {


				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = [];
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function get_user_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$finalResponse = array();
		$where = array('status=' => 1, 'user_id' => $user_id);
		$columns = "*";
		$join = array();
		$group_by = '';

		$get_address =  $this->Common_model->get_all_rows(TBL_ADDRESS, $columns, $where, $join, array('id' => 'desc'), '', '', array(), $group_by, array(), array());
		if (!empty($get_address)) {
			foreach ($get_address as $row) {
				$res['id'] = $row['id'];
				$res['name'] = urldecode($row['name']);
				$res['phone'] = $row['phone'];
				$res['address_line_1'] = urldecode($row['address_line_1']);
				$res['address_line_2'] = urldecode($row['address_line_2']);
				$res['pincode'] = $row['pincode'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['city'] = urldecode($row['city']);
				$res['state'] = urldecode($row['state']);
				$res['country'] = urldecode($row['country']);
				$res['isDefault'] = $row['isDefault'];
				$res['address_type'] = $row['address_type'];

				$finalResponse[] = $res;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}

	function delete_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$address_id = $requestData->address_id;

		$get_address =  $this->Common_model->get_all_row(TBL_ADDRESS, 'id', array('status!=' => 2,  'id' => $address_id));
		if (empty($get_address)) {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Address not found.';
			$data['result'] = [];
		} else {
			$update = $this->Common_model->update(TBL_ADDRESS, array('status' => 2), array('id' => $address_id));
			if ($update) {


				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = [];
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	function add_order()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);


		$getUserData = $this->Common_model->get_single_row(TBL_USERS, '*', array('id' => $requestData->user_id));

		//print_r($getUserData->fullname);
		//die;
		$getAddressData = $this->Common_model->get_single_row(TBL_ADDRESS, '*', array('id' => $requestData->address_id));

		if ($requestData->token_id != "" && $requestData->payment_type == 2 && $requestData->total_price > 0) {
			require_once APPPATH . "third_party/stripe/init.php";

			$stripe = array(
				"secret_key"      => $this->settings->stripe_private_key,
				"publishable_key" => $this->settings->stripe_publish_key
			);


			//\Stripe\Stripe::setApiKey($stripe['secret_key']);
			$stripe = new \Stripe\StripeClient($stripe['secret_key']);
			$customer = $stripe->customers->create(
				array(
					'name' => urldecode($getUserData->fullname),
					'address' => array(
						'line1' => urldecode($getAddressData->address_line_1) . ' ' . urldecode($getAddressData->address_line_2),
						'postal_code' => $getAddressData->pincode,
						'city' => urldecode($getAddressData->city),
						'state' => urldecode($getAddressData->state),
						'country' => "US",

					),
					'payment_method' => 'pm_card_visa',
				)
			);
			$stripe->paymentMethods->attach(
				$requestData->token_id,
				['customer' => $customer->id]
			);
			$return = $stripe->paymentMethods->retrieve(
				$requestData->token_id,
				[]
			);

			$card = $stripe->customers->createSource($return->customer, ['source' => 'tok_visa']);
			$charge = $stripe->charges->create(
				[
					"amount" => $requestData->total_price * 100,
					"currency" => "usd",
					"receipt_email" => urldecode($getUserData->email),
					"description" => "Order from " . urldecode($this->settings->website_name),
					'customer' => $return->customer,

				]
			);
		}
		if ($requestData->token_id != "" && $requestData->payment_type == 3 && $requestData->total_price > 0) {
			require_once(APPPATH . 'libraries/breaintree/lib/Braintree.php');



			//This is for Sandbox Environment
			Braintree\Configuration::environment($this->settings->braintree_environment);
			Braintree\Configuration::merchantId($this->settings->braintree_merchant_id);
			Braintree\Configuration::publicKey($this->settings->braintree_public_key);
			Braintree\Configuration::privateKey($this->settings->braintree_private_key);

			$paypalResult = Braintree\Transaction::sale([
				'amount' => $requestData->total_price,
				'paymentMethodNonce' => $requestData->token_id,
				'orderId' => time(),
				'options' => ['submitForSettlement' => true]
			]);
		}
		if ((isset($charge) && !empty($charge)) || (isset($paypalResult) && !empty($paypalResult->success))  || $requestData->payment_type == 1 || $requestData->total_price == '0.00' || $requestData->payment_type == 4 || $requestData->payment_type == 5) {

			$grand_total = $requestData->total_price + $requestData->discount_price + $requestData->wallet_price;

			$addArr['user_id'] = $requestData->user_id;
			$addArr['address_id'] = $requestData->address_id;
			$addArr['restaurent_id'] = $requestData->restaurent_id;
			$addArr['total_price'] = $requestData->total_price;
			$addArr['tip_price'] = $requestData->tip_price;
			$addArr['discount_price'] = $requestData->discount_price;
			$addArr['wallet_price'] = $requestData->wallet_price;
			$addArr['promo_code'] = $requestData->promo_code;
			$addArr['grand_total'] = $grand_total;
			$addArr['payment_type'] = $requestData->payment_type;
			$addArr['payment_status'] = 1;
			$addArr['created'] = date('Y-m-d H:i:s');
			$addArr['updated'] = date('Y-m-d H:i:s');

			$insert = $this->Common_model->insert(TBL_ORDERS, $addArr);
			//echo $this->db->last_query(); die;
			if ($insert) {
				$insert_id = $this->db->insert_id();
				if ($requestData->wallet_price > 0) {
					$user_data =  $this->Common_model->get_single_row(TBL_USERS, 'id, wallet_amount', array('id' => $requestData->user_id, 'status' => 1));
					$updated_amount = $user_data->wallet_amount - $requestData->wallet_price;
					$this->Common_model->update(TBL_USERS, array('wallet_amount' => $updated_amount, 'updated' => $this->utc_time), array('id' => $user_data->id));
				}

				$addNotification = array();
				$addNotification['title'] = urlencode("Order Placed");
				$addNotification['Description'] = urlencode("Your order has been placed successfully.");
				$addNotification['type'] = "1";
				$addNotification['type_id'] = $insert_id;
				$addNotification['user_id'] = $requestData->user_id;
				$addNotification['created'] = date('Y-m-d H:i:s');
				$addNotification['updated'] = date('Y-m-d H:i:s');
				$this->Common_model->insert(TBL_NOTIFICATIONS, $addNotification);
				$notification_id = $this->db->insert_id();
				$this->sendPushNotification($requestData->user_id, $notification_id);

				$getOwner =  $this->Common_model->get_single_row(TBL_RESTAURANTS, 'owner_id', array('id' => $requestData->restaurent_id, 'status' => 1));
				$ownerNotification = array();
				$ownerNotification['title'] = urlencode("Order Received");
				$ownerNotification['Description'] = urlencode("Congratulations!!, You received new order.");
				$ownerNotification['type'] = "3";
				$ownerNotification['type_id'] = $insert_id;
				$ownerNotification['user_id'] = $getOwner->owner_id;
				$ownerNotification['created'] = date('Y-m-d H:i:s');
				$ownerNotification['updated'] = date('Y-m-d H:i:s');
				$this->Common_model->insert(TBL_NOTIFICATIONS, $ownerNotification);
				$notification_id = $this->db->insert_id();
				$this->sendPushNotification($getOwner->owner_id, $notification_id, 'owners');

				$order_details = $requestData->ProductDetails;
				foreach ($order_details as $oData) {
					$addArrO = array();
					$addArrO['product_id'] = $oData->product_id;
					$addArrO['product_price'] = $oData->product_price;
					$addArrO['extra_note'] = $oData->extra_note;
					$addArrO['product_quantity'] = $oData->product_quantity;
					$addArrO['order_id'] = $insert_id;
					$addArrO['created'] = date('Y-m-d H:i:s');
					$addArrO['updated'] = date('Y-m-d H:i:s');

					$this->Common_model->insert(TBL_ORDERDETAIL, $addArrO);
				}


				$addEarn = array();
				//echo $this->settings->charge_from_owner; die;
				$total_payable = $grand_total - 20 - $requestData->tip_price;
				$addEarn['total_amount'] = $grand_total;
				$addEarn['owners_amount'] = $total_payable - (($this->settings->charge_from_owner / 100) * $total_payable);
				$addEarn['admin_charge_amount'] = ($this->settings->charge_from_owner / 100) * $total_payable;
				$addEarn['order_id'] = $insert_id;
				$addEarn['restaurent_id'] = $requestData->restaurent_id;
				$addEarn['created'] = date('Y-m-d H:i:s');
				$this->Common_model->insert(TBL_EARNINGS, $addEarn);


				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = [];
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		} else {
			$data['code'] = FAILURE;
			$data['message'] = 'Failure.';
			$data['result'] = [];
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}


	function orders_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$where = array('o.user_id=' => $user_id, 'o.status' => 1);
		$columns = "o.*, r.name, r.profile_image, r.address, rr.review";
		$join = array(TBL_RESTAURANTS . ' as r' => "r.id=o.restaurent_id", TBL_RESTAURANT_REVIEW . ' as rr' => "rr.order_id=o.id");
		$group_by = 'o.id';
		$get_data =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', $columns, $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());


		$ordResponse = array();
		if (!empty($get_data)) {
			foreach ($get_data as $ord) {
				$ordRes['name'] = urldecode($ord['name']);
				$ordRes['banner_image'] = $this->getImage(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address'] = urldecode($ord['address']);
				$ordRes['order_id'] = $ord['id'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['total_price'] = $ord['total_price'];
				$ordRes['created'] = $ord['created'];
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


	function order_details()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$order_id = $requestData->order_id;
		$get_order =  $this->Common_model->get_single_by_query("SELECT o.*, r.name, r.profile_image, r.address, a.address_line_1, a.address_line_2, a.phone, r.id as restaurant_id, a.latitude, a.longitude FROM " . TBL_ORDERS . " as o INNER JOIN " . TBL_RESTAURANTS . " as r ON r.id=o.restaurent_id INNER JOIN " . TBL_ADDRESS . " as a ON a.id=o.address_id WHERE o.id=" . $order_id . " and o.status=1");
		if (!empty($get_order)) {
			$get_driver =  $this->Common_model->get_single_row(TBL_ORDER_DRIVERS, 'driver_id', array('order_id' => $order_id, 'status' => 1, 'driver_status' => 1));
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

	public function profile()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$get_user =  $this->Common_model->get_single_row(TBL_USERS, '*', array('id' => $user_id, 'status' => 1));
		if (!empty($get_user)) {
			$user['user_id'] = $get_user->id;
			$user['name'] = urldecode($get_user->fullname);
			$user['wallet_amount'] = $get_user->wallet_amount;
			$user['email'] = urldecode($get_user->email);
			$user['profile_image'] = $this->getImage($get_user->image, 'user');
			$user['phone'] = $get_user->phone;

			$where = array('o.user_id=' => $user_id, 'o.status' => 1);
			$columns = "o.*, r.name, r.profile_image, r.address, rr.review";
			$join = array(TBL_RESTAURANTS . ' as r' => "r.id=o.restaurent_id", TBL_RESTAURANT_REVIEW . ' as rr' => "rr.order_id=o.id");
			$group_by = 'o.id';
			$get_data =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', $columns, $where, $join, array('o.id' => 'desc'), '5,0', 'LEFT', array(), $group_by, array(), array());
			$total_orders =  $this->Common_model->get_all_rows(TBL_ORDERS . ' as o', 'o.id', $where, $join, array('o.id' => 'desc'), '', 'LEFT', array(), $group_by, array(), array());

			$ordResponse = array();

			foreach ($get_data as $ord) {
				//$get_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'ROUND( AVG(rr.review),1 ) as review', array('restaurant_id'=>$ord['restaurent_id']), array(), array('rr.id' => 'desc'), '', 'LEFT', array(), 'rr.restaurant_id', array(), array());
				$ordRes['review'] = $ord['review'];
				$ordRes['name'] = urldecode($ord['name']);
				$ordRes['banner_image'] = $this->getImage(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address'] = urldecode($ord['address']);
				$ordRes['order_id'] = $ord['id'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['total_price'] = $ord['total_price'];
				$ordRes['created'] = $ord['created'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordResponse[] = $ordRes;
			}
			$user['orders'] = $ordResponse;
			$user['total_orders'] = strval(count($total_orders));
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


	public function most_polupar_restaurants()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$lat = $requestData->latitude;
		$long = $requestData->longitude;

		$finalResponse = array();
		$get_top_restaurants = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review FROM " . TBL_RESTAURANTS . " as r INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id INNER JOIN " . TBL_ORDERS . " as o ON o.restaurent_id=r.id LEFT JOIN " . TBL_RESTAURANT_REVIEW . " as rr ON rr.restaurant_id=r.id GROUP BY r.id HAVING   r_status=1  and s_status=1 and ct_status=1 and c_status=1 ORDER BY distance ASC");
		if (!empty($get_top_restaurants)) {
			foreach ($get_top_restaurants as $row) {
				$res['id'] = $row['id'];
				$res['review'] = $row['review'];
				$res['is_available'] = $row['is_available'];
				$res['name'] = urldecode($row['name']);
				$res['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$res['discount'] = $row['discount'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['discount_type'] = $row['discount_type'];

				$finalResponse[] = $res;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function mealDeal($cat_id = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$lat = $requestData->latitude;
		$long = $requestData->longitude;

		$finalResponse = array();
		$append_where = "";
		if ($cat_id) {
			$append_where .= " and f.category_id=" . $cat_id;
		}
		$get_mealdela = $this->Common_model->get_all_rows_by_query("SELECT r.id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name,r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, f.status as f_status, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) ) 
		* cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance, f.category_id FROM " . TBL_SUBCATEGORIES . " as f INNER JOIN " . TBL_RESTAURANTS . " as r  ON r.id=f.restaurant_id INNER JOIN " . TBL_STATE . " as s ON s.id=r.state_id INNER JOIN " . TBL_CITY . " as ct ON ct.id=r.city_id INNER JOIN " . TBL_COUNTRY . " as c ON c.id=r.country_id GROUP BY f.id HAVING r_status=1 and s_status=1 and ct_status=1 and c_status=1 " . $append_where . " ORDER BY distance ASC");
		if (!empty($get_mealdela)) {
			foreach ($get_mealdela as $row) {
				$mealRes['id'] = $row['id'];
				$mealRes['name'] = urldecode($row['title']);
				//$mealRes['category_id'] = urldecode($row['category_id']);
				$mealRes['is_available'] = $row['is_available'];
				$mealRes['status'] = $row['f_status'];
				$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
				$mealRes['image'] = $this->getImage(explode(',', $row['image'])[0], 'subcategory');;
				$mealRes['price'] = $row['price'];
				$mealRes['discount'] = $row['discount'];
				$mealRes['latitude'] = $row['latitude'];
				$mealRes['longitude'] = $row['longitude'];
				$mealRes['discount_type'] = $row['discount_type'];

				$finalResponse[] = $mealRes;
			}
		}

		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}


	public function search()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$search_keyword = trim(strtolower($requestData->search_keyword));
		$bannerResponse = $mealDealResponse = array();

		$where = array('r.status=' => 1, 's.status' => 1, 'ct.status' => 1, 'c.status' => 1);
		$columns = "r.id, r.name, r.profile_image, r.address, r.pincode, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ROUND( AVG(rr.review),1 ) as review";
		$join = array(TBL_STATE . ' as s' => "s.id=r.state_id", TBL_CITY . ' as ct' => "ct.id=r.city_id", TBL_COUNTRY . " as c" => "c.id=r.country_id", TBL_RESTAURANT_REVIEW . " as rr" => "rr.restaurant_id=r.id");
		$group_by = 'r.id';
		//LEFT JOIN ".TBL_RESTAURANT_REVIEW." as rr ON rr.restaurant_id=r.id
		$like_array = array("LOWER(r.name)" => urlencode($search_keyword));
		$get_banner_restaurants =  $this->Common_model->get_all_rows(TBL_RESTAURANTS . ' as r', $columns, $where, $join, array('r.id' => 'desc'), '10, 0', 'LEFT', $like_array, $group_by, array(), array());
		if (!empty($get_banner_restaurants)) {
			foreach ($get_banner_restaurants as $row) {
				$bannerRes['id'] = $row['id'];
				$bannerRes['review'] = $row['review'];
				$bannerRes['is_available'] = $row['is_available'];
				$bannerRes['name'] = urldecode($row['name']);
				$bannerRes['image'] = $this->getImage(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$bannerRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$bannerRes['discount'] = $row['discount'];
				$bannerRes['latitude'] = $row['latitude'];
				$bannerRes['longitude'] = $row['longitude'];
				$bannerRes['discount_type'] = $row['discount_type'];

				$bannerResponse[] = $bannerRes;
			}
		}


		$where = array('r.status=' => 1,  's.status' => 1, 'ct.status' => 1, 'c.status' => 1);
		$columns = "r.id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name, f.status as f_status, r.is_available";
		$join = array(TBL_RESTAURANTS . ' as r' => "r.id=f.restaurant_id", TBL_STATE . ' as s' => "s.id=r.state_id", TBL_CITY . ' as ct' => "ct.id=r.city_id", TBL_COUNTRY . " as c" => "c.id=r.country_id");
		$group_by = 'f.id';
		$like_array = array("LOWER(f.title)" => $search_keyword);
		$get_mealdela =  $this->Common_model->get_all_rows(TBL_SUBCATEGORIES . ' as f', $columns, $where, $join, array('r.id' => 'desc'), '10, 0', 'LEFT', $like_array, $group_by, array(), array());
		if (!empty($get_mealdela)) {
			foreach ($get_mealdela as $row) {
				$mealRes['id'] = $row['id'];
				$mealRes['name'] = urldecode($row['title']);
				$mealRes['is_available'] = $row['is_available'];
				$mealRes['status'] = $row['f_status'];
				$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
				$mealRes['image'] = $this->getImage(explode(',', $row['image'])[0], 'subcategory');;
				$mealRes['price'] = $row['price'];
				$mealRes['discount'] = $row['discount'];
				$mealRes['latitude'] = $row['latitude'];
				$mealRes['longitude'] = $row['longitude'];
				$mealRes['discount_type'] = $row['discount_type'];

				$mealDealResponse[] = $mealRes;
			}
		}



		$finalResponse['restaurents'] = $bannerResponse;
		$finalResponse['mealDeal'] = $mealDealResponse;
		$data['code'] = SUCCESS;
		$data['message'] = 'Success.';
		$data['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($data);
	}


	function get_braintree_token()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		require_once(APPPATH . 'libraries/breaintree/lib/Braintree.php');
		Braintree\Configuration::environment($this->settings->braintree_environment);
		Braintree\Configuration::merchantId($this->settings->braintree_merchant_id);
		Braintree\Configuration::publicKey($this->settings->braintree_public_key);
		Braintree\Configuration::privateKey($this->settings->braintree_private_key);

		try {
			$result = Braintree_Customer::create(['firstName' => $user_id,]);

			if ($result->success) {
				$aCustomerId = $result->customer->id;

				if ($aCustomerId != "") {
					$clientToken = Braintree_ClientToken::generate(array(
						"customerId" => $aCustomerId
					));
				} else {
					$clientToken = Braintree_ClientToken::generate();
				}
				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = $clientToken;
			} else {
				$data['code'] = FAILURE;
				throw new Exception();
			}
		} catch (Exception $e) {
			$data['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function add_driver_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$addArr['customer_id'] = $requestData->customer_id;
		$addArr['order_id'] = $requestData->order_id;
		$addArr['review'] = $requestData->review;
		$addArr['message'] = urlencode($requestData->message);
		$addArr['driver_id'] = $requestData->driver_id;
		$addArr['created'] = date('Y-m-d H:i:s');

		$get_data =  $this->Common_model->get_all_row(TBL_DRIVER_REVIEW, 'id', array('order_id' => $addArr['order_id'], 'status!=' => 2, 'customer_id' => $addArr['customer_id'], 'driver_id' => $addArr['driver_id']));
		if (!empty($get_data)) {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Review already exist.';
			$data['result'] = [];
		} else {
			$insert = $this->Common_model->insert(TBL_DRIVER_REVIEW, $addArr);
			if ($insert) {


				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = [];
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function add_restaurant_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$addArr['customer_id'] = $requestData->customer_id;
		$addArr['order_id'] = $requestData->order_id;
		$addArr['review'] = $requestData->review;
		$addArr['message'] = urlencode($requestData->message);
		$addArr['restaurant_id'] = $requestData->restaurant_id;
		$addArr['created'] = date('Y-m-d H:i:s');

		$get_data =  $this->Common_model->get_all_row(TBL_RESTAURANT_REVIEW, 'id', array('order_id' => $addArr['order_id'], 'status!=' => 2, 'customer_id' => $addArr['customer_id'], 'restaurant_id' => $addArr['restaurant_id']));
		if (!empty($get_data)) {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Review already exist.';
			$data['result'] = [];
		} else {
			$insert = $this->Common_model->insert(TBL_RESTAURANT_REVIEW, $addArr);
			if ($insert) {

				$this->Common_model->update(TBL_ORDERS, array('isReviewed' => 1, 'updated' => $this->utc_time), array('id' => $requestData->order_id));
				$data['code'] = SUCCESS;
				$data['message'] = 'Success.';
				$data['result'] = [];
			} else {
				$data['code'] = FAILURE;
				$data['message'] = 'Failure.';
				$data['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function get_driver_location()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$driver_id = $requestData->driver_id;
		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'id, latitude, longitude', array('id' => $driver_id, 'status' => 1));
		if (!empty($get_user)) {
			$user['driver_id'] = $get_user->id;
			$user['latitude'] = $get_user->latitude;
			$user['longitude'] = $get_user->longitude;

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

	public function get_order_status()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$order_id = $requestData->order_id;
		$get_data =  $this->Common_model->get_single_row(TBL_ORDERS, 'order_status', array('id' => $order_id, 'status' => 1));
		if (!empty($get_data)) {
			$get_driver = $this->Common_model->get_single_by_query("SELECT d.fullname, d.image, ROUND( AVG(dr.review),1 ) as review, d.phone
			FROM " . TBL_ORDER_DRIVERS . " as od  LEFT JOIN " . TBL_USERS . " as d ON d.id = od.driver_id LEFT JOIN " . TBL_DRIVER_REVIEW . " as dr ON dr.driver_id = d.id WHERE od.order_id= " . $order_id . " and od.driver_status = 1");
			$driver_detail = array();
			//echo $this->db->last_query(); die;
			if (!empty($get_driver)) {
				$driver_detail['name'] = urldecode($get_driver->fullname);
				$driver_detail['image'] = $this->getImage($get_driver->image, 'user');;
				$driver_detail['review'] = $get_driver->review;
				$driver_detail['phone'] = $get_driver->phone;
			}
			$user['order_status'] = $get_data->order_status;
			$user['driver_details']  = $driver_detail;
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

	public function cancel_order()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$order_id = $requestData->order_id;
		$get_data =  $this->Common_model->get_single_row(TBL_ORDERS, 'user_id, id, total_price, payment_type', array('id' => $order_id, 'status' => 1));
		if (!empty($get_data)) {
			if ($get_data->payment_type != 1) {
				$cancel_charge = ($get_data->total_price * $this->settings->cancellation_charge) / 100;
				$wallet_amount = $get_data->total_price - $cancel_charge;
				$user_data =  $this->Common_model->get_single_row(TBL_USERS, 'id, wallet_amount', array('id' => $get_data->user_id, 'status' => 1));
				$updated_amount = $wallet_amount + $user_data->wallet_amount;
				$this->Common_model->update(TBL_USERS, array('wallet_amount' => $updated_amount, 'updated' => $this->utc_time), array('id' => $user_data->id));
			}

			$this->Common_model->update(TBL_ORDERS, array('order_status' => 9, 'refund_amount' => $wallet_amount, 'updated' => $this->utc_time), array('id' => $get_data->id));
			$this->Common_model->update(TBL_EARNINGS, array('status' => 9, 'updated' => $this->utc_time), array('order_id' => $order_id));

			$data['code'] = SUCCESS;
			$data['message'] = 'Success.';
			$data['result'] = [];
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'Invalid order ID';
			$data['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function get_all_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$restaurant_id = $requestData->restaurant_id;

		$reviewResponse = array();
		$get_last_review =  $this->Common_model->get_all_rows(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.*, u.fullname, u.image, a.city as city_name', array('rr.restaurant_id' => $restaurant_id, 'rr.status' => 1), array(TBL_USERS . ' as u' => 'u.id=rr.customer_id', TBL_ORDERS . ' as o' => 'o.id=rr.order_id', TBL_ADDRESS . ' as a' => 'a.id=o.address_id'), array('rr.id' => 'desc'), '', 'LEFT', array(), 'rr.id', array(), array());
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
		} else {
			$data['code'] = NO_DATA;
			$data['message'] = 'No Data Found.';
			$data['result'] = [];
		}



		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function get_wallet_amount($user_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'id, wallet_amount', array('id' => $user_id, 'status' => 1));
		if (!empty($get_user)) {
			$user['user_id'] = $get_user->id;
			$user['wallet_amount'] = $get_user->wallet_amount;
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


	public function categories()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$get_categories =  $this->Common_model->get_all_rows(TBL_CATEGORIES . ' as c', 'c.*, COUNT(s.category_id) as total', array('c.status' => 1), array(TBL_SUBCATEGORIES . ' as s' => 's.category_id=c.id'), array(), '', 'LEFT', array(), 'c.id', array(), array());
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

	public function change_password()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$old_password = $requestData->old_password;
		$new_password = $requestData->new_password;

		$get_user =  $this->Common_model->get_single_row(TBL_USERS, 'status, id', array('password' => md5($old_password), 'status=' => 1, 'is_social_login' => 0, 'id' => $user_id));

		if (!empty($get_user)) {
			$addArr['password'] = md5($new_password);
			$addArr['updated'] = date('Y-m-d H:i:s');
			$update = $this->Common_model->update(TBL_USERS, $addArr, array('id' => $get_user->id));
			$data['code'] = SUCCESS;
			$data['message'] = 'Password successfully updated';
		} else {
			$data['code'] = EMAIL_EXIST;
			$data['message'] = 'Invalid old password';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}

	public function check_promocode()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$promocode = $requestData->promocode;
		$current_date = date('Y-m-d');
		//$get_code =  $this->Common_model->get_single_row(TBL_COUPONS, 'id, discount, discount_type', array('coupon_code' => $promocode, 'status=' => 1, 'start_date >= ' => $current_date));
		$get_code = $this->Common_model->get_single_by_query("SELECT id, discount, discount_type
		FROM " . TBL_COUPONS . "
		WHERE '" . $current_date . "' between start_date and end_date and status=1 and coupon_code='" . $promocode . "'");
		//echo $this->db->last_query();
		//die;
		//ini_set('display_errors', 1);
		//error_reporting(E_ALL);
		if (!empty($get_code)) {
			$check_code =  $this->Common_model->get_single_row(TBL_ORDERS, 'id', array('promo_code' => $promocode, 'status=' => 1, 'user_id' => $user_id));
			if (!empty($check_code)) {
				$data['code'] = EMAIL_EXIST;
				$data['message'] = 'This promocode is applicable only once.';
			} else {
				$data['code'] = SUCCESS;
				$data['message'] = 'Promocode successfully applied.';
				$data['data'] = ['discount_type' => $get_code->discount_type, 'discount' => $get_code->discount];
			}
		} else {
			$data['code'] = FAILURE;
			$data['message'] = 'Invalid promocode.';
		}

		header('Content-type: application/json');
		echo json_encode($data);
	}

	function checkOtp()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$printarray = array();
		$requestData = json_decode($this->input->raw_input_stream);
		$user_id = $requestData->user_id;
		$otp = $requestData->otp;


		//$checkOTP = $this->Sitefunction->get_single_row(TBL_USERS, 'id', array('otp' => $data['otp'], 'id' => $data['customer_id']), array(), array(), '', '', array(), "", array(), array());

		if ($otp != '1234') {
			$data['code'] = FAILURE;
			$data['message'] = 'Invalid promocode.';
		} else {
			
		
			$data['code'] = SUCCESS;
			$data['message'] = "success";
		}


		header('Content-type: application/json');
		echo json_encode($data);
	}
}
