<?php
class MY_Controller extends CI_Controller {

    public function __construct() {		
        parent::__construct();
		$user_id = $this->session->userdata('user_id');
		$this->user_id= $user_id;
		$this->utc_time = date('Y-m-d H:i:s');
		$this->utc_date = date('Y-m-d');
		$this->settings = $this->Common_model->get_single_row(TBL_SETTINGS, '*', array('status'=>1));
		
		 
    }

    public function dateFormate($date, $time='') {
    	if(isset($time) && $time!=''){
    		$date_f= date('d-m-Y H:i:s', strtotime("$date $time"));

    	}else {
    		$date_f= date('d-m-Y H:i:s', strtotime($date));
    	}
    	return $date_f;
    }
    public function getImage($image, $folder) {
		
    	if($image==''){
    		return UPLOAD_URL.$folder.'/dummy_profile.png';
    	}else {
    		if (filter_var($image, FILTER_VALIDATE_URL)) {
	    		return $image;
	    	}else{
				//echo UPLOAD_PATH.$folder."/".$image;
	    		if(file_exists(UPLOAD_PATH.$folder."/".$image)) {
	    			return UPLOAD_URL.$folder.'/'.$image;
	    		}else {
					
	    			return UPLOAD_URL.$folder.'/dummy_profile.png';
	    		}
	    		
	    	}
    	}
    	

	}
	
	public function sendMailToUser($user_id,  $email, $type, $password=false) {
		if($type==1) {
			$query= $this->Common_model->get_single_row(TBL_USERS, '*', array('id'=>$user_id));
			$fullname = ucwords(urldecode($query->fullname));
		}else {
			$query= $this->Common_model->get_single_row(TBL_OWNERS, '*', array('id'=>$user_id));
			$fullname = ucwords(urldecode($query->first_name.' '.$query->last_name));
		}
		
		require_once('Exception.php');
		require_once('PHPMailer.php');
		require_once("SMTP.php");
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->Port = $this->settings->smtp_port;												
		$mail->SMTPAuth   = true; 
		
		// $mail->SMTPOptions = array(
		// 	'ssl' => array(
		// 		'verify_peer' => false,
		// 		'verify_peer_name' => false,
		// 		'allow_self_signed' => true
		// 	)
		// );
		$mail->SMTPDebug = 0;
		$mail->IsHTML(true);
		//$mail->SMTPSecure = 'tls';
		$mail->Host       = $this->settings->smtp_host;
		$mail->Username   = $this->settings->smtp_username;
		$mail->Password   = $this->settings->smtp_password;
		
		$mail->Subject = "Reset Password";	

		$body= '<html>
						<body>
							<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
								<tr>
									<td>
										<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
											<tr>
												<td><h3><font color="#283092">Reset Password</font></h3></td>
											</tr>
										</table>
										<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
											<tr>
												<td>Dear '.$fullname.',</td>
											</tr>
											<tr>
												<td><h3>We have received your request to change your password.</h3></td>
											</tr>
											
										</table>
										<table border="0" cellpadding="5px" width="100%" style="padding-bottom:20px;">
											
											<tr>
												<td>Please Find your new password detail below..​</td>
											</tr>
											<tr>
												<td><b>Email:</b> '.urldecode($email).'</td>
												
											</tr>
											<tr>
												
												<td><b>Password:</b> '.$password.'</td>
											</tr>
										</table>
										
										
										<table border="0" cellpadding="0" width="100%" >
											
											<tr>
												<td>Thanks and Regards</td>
											</tr>
											<tr>
												<td><strong>'.urldecode($this->settings->website_name).'</strong></td>
											</tr>
											
										</table>
									</td>
								</tr>
							</table>
						</body>
				</html>';
		
		$mail->MsgHTML($body);
			
		$mail->From =  urldecode($this->settings->smpt_from_email);
			
			
		$mail->FromName =  urldecode($this->settings->smtp_from_name);
		
		$mail->AddAddress($email); 		
		
		if ($mail->Send()) 
		{
			return  true;
		}else {
			return false;
		}

	}
	
	public function sendPushNotification( $user_id,  $notification_id, $type=null) {
		if($type=="driver") {
			$getToken= $this->Common_model->get_all_rows(TBL_USERS, '*', array('status'=>1, 'id'=>$user_id));
		}else if($type=="owners") {
			$getToken= $this->Common_model->get_all_rows(TBL_OWNERS, '*', array('status'=>1, 'id'=>$user_id));
		}else {
			$getToken= $this->Common_model->get_all_rows(TBL_DEVICE_TOKENS, '*', array('status'=>1, 'user_id'=>$user_id));
		}
		
		//$getToken= $this->Common_model->get_all_row(TBL_DEVICE_TOKENS, '*', array('status'=>1, 'user_id'=>$user_id));
		$token= array();
		foreach($getToken as $getTokens) {
			$token[]= $getTokens['device_token'];
		}
		//print_r($token);
		$getNotification= $this->Common_model->get_single_row(TBL_NOTIFICATIONS, '*', array('status'=>1, 'id'=>$notification_id));
		
		$title= urldecode($getNotification->title);
		$message=urldecode($getNotification->description);

		
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

		
        $fields = array(
            'registration_ids' => $token,
            'priority' => 10,
            'notification' => array('title' => $title, 'body' =>  $message ,'sound'=>'default', 'badge'=>"1",'type_id'=>$getNotification->type_id),
        );
        $headers = array(
            'Authorization:key=' . $this->settings->fcm_key,
            'Content-Type:application/json'
        );  
         
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
		//echo $result;
		return $result;
	}
}
?>