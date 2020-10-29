<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	
    public $controller_name;
    public $method_name;
    public $dataModule = array();
	public function __construct() {
		
		date_default_timezone_set('Asia/Kolkata');
		parent::__construct();
		$user_id = $this->session->userdata('admin_id');
		$this->utc_time = date('Y-m-d H:i:s');
		$this->utc_date = date('Y-m-d');
		$this->settings = $this->Sitefunction->get_single_row(TBL_SETTINGS, '*', array('status'=>1));
		 $controller_name= $this->router->fetch_class();
		
		 $this->user_id= $user_id;
		 if(!in_array($controller_name, array('login'))) {
			if(empty($user_id) || !isset($user_id)) {
				 redirect(LOGIN_PATH);
			}else {
				$this->dataModule['session_detail']=  $this->Sitefunction->get_single_row(TBL_ADMIN, '*', array('id'=>$user_id));
			}
		 }
		 
	}
	

	 function getPaymentType($id) {
		if($id==1)
			return "COD";
		elseif($id==2)
			return "Stripe";
		elseif($id==3)
			return "Paypal";
		elseif($id==4)
			return "Razor Pay";
		elseif($id==5)
			return "Wallet";
	}

	 function getPaymentStatus($id) {
		if($id==0)
			return "<label class='label label-warning'>Pending</label>";
		elseif($id==1)
			return "<label class='label label-success'>Success</label>";
		elseif($id==0)
			return "<label class='label label-danger'>Failed</label>";
		
		
	}
	 function getOrderStatus($id) {
		if($id==1)
			return "<label class='label label-warning'>Received</label>";
		elseif($id==2)
			return "<label class='label label-success'>Accepted</label>";
		elseif($id==3)
			return "<label class='label label-danger'>Declined</label>";
		elseif($id==4)
			return "<label class='label label-warning'>Inprocess</label>";
		elseif($id==5)
			return "<label class='label label-success'>Delivered</label>";
		elseif($id==6)
			return "<label class='label label-warning'>Picked Up</label>";
		elseif($id==9)
			return "<label class='label label-danger'>Cancelled</label>";
	}

	public function getDriverOrderStatus($id) {
		if($id==0)
			return "<label class='label label-warning'>Waiting for Approval</label>";
		elseif($id==1)
			return "<label class='label label-success'>Accepted</label>";
		elseif($id==2)
			return "<label class='label label-danger'>Declined</label>";
		
	}

	public function sendPushNotification( $user_id,  $notification_id, $type=null) {
		if($type!=null) {
			$getToken= $this->Sitefunction->get_all_rows(TBL_USERS, '*', array('status'=>1, 'id'=>$user_id));
		}else {
			$getToken= $this->Sitefunction->get_all_rows(TBL_DEVICE_TOKENS, '*', array('status'=>1, 'user_id'=>$user_id));
		}
		
		$token= array();
		foreach($getToken as $getTokens) {
			$token[]= $getTokens['device_token'];
		}

		$getNotification= $this->Sitefunction->get_single_row(TBL_NOTIFICATION, '*', array('status'=>1, 'id'=>$notification_id));
		
		$title=urldecode($getNotification->title);
		$message=urldecode($getNotification->description);

		
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';

		
        $fields = array(
            'registration_ids' => $token,
            'priority' => 10,
            'notification' => array('title' => $title, 'body' =>  $message ,'sound'=>'default', 'badge'=>"1", 'type_id'=>$getNotification->type_id),
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
        return $result;
	}

	public function sendMailToAdmin($id, $password, $email) {
		$query= $this->Sitefunction->get_single_row(TBL_ADMIN, '*', array('id'=>$id));
		require_once('Exception.php');
		require_once('PHPMailer.php');
		require_once("SMTP.php");
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->Port = $this->settings->smtp_port;										// comment for amazon
		$mail->SMTPAuth   = true; 
		$mail->SMTPDebug = 0;
		
		$mail->Host       = $this->settings->smtp_host;
		$mail->Username   = urldecode($this->settings->smtp_username);
		$mail->Password   = $this->settings->smtp_password;
		
		$mail->Subject = "New Password";	

		$body= '<html>
						<body>
							<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
								<tr>
									<td>
										<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
											<tr>
												<td><h3><font color="#283092">New Password</font></h3></td>
											</tr>
										</table>
										<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
											<tr>
												<td>Dear '.ucwords(urldecode($query->first_name).' '.urldecode($query->last_name)).',</td>
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
												<td><strong>'. urldecode($this->settings->website_name).'</strong></td>
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
			return true;
		}else {
			return false;
		}

	}

	public function sendInvoiceEmailToOwner($id, $amount) {
		// echo "<pre>";
		// print_r($this->settings);
		// die;
		$where = array('o.restaurent_id='=>$id, 'o.status'=>1, 'e.payment_status'=>0, 'e.status'=>1);
        $columns = "o.id, o.created, ,e.owners_amount, e.payment_status, e.total_amount";
        $join = array(TBL_EARNINGS.' as e'=>"e.order_id=o.id");
        $group_by = 'o.id';
		$invoice_info=  $this->Sitefunction->get_all_rows(TBL_ORDERS.' as o', $columns, $where, $join, array('o.id'=>'desc'), '', 'LEFT', array(), $group_by, array(), array());

		$invoiceData= "";
		foreach($invoice_info as $result) {
			$invoiceData.='<tr><td>'.$result['id'].'</td><td>'.date('d-m-Y', strtotime($result['created'])).'</td><td>$'.$result['total_amount'].'</td><td>$'.$result['owners_amount'].'</td></tr>';
		}
		$restaurent_info =  $this->Sitefunction->get_single_row(TBL_RESTAURANTS, '*', array('id'=>$id));
		require_once('Exception.php');
		require_once('PHPMailer.php');
		require_once("SMTP.php");
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->Port = $this->settings->smtp_port;
		//$mail->SMTPSecure = 'ssl';									// comment for amazon
		$mail->SMTPAuth   = true; 
		$mail->SMTPDebug = 0;
		
		$mail->Host       = $this->settings->smtp_host;
		$mail->Username   = urldecode($this->settings->smtp_username);
		$mail->Password   = $this->settings->smtp_password;
		
		$mail->Subject = "New Invoice";	

		$body= '<html>
				<body>
					<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
						<tr>
							<td>
								<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
									<tr>
										<td><h3><font color="#283092">New Invoice</font></h3></td>
									</tr>
								</table>
								<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
									<tr>
										<td>'.ucwords(urldecode($restaurent_info->name)).',</td>
									</tr>
									<tr>
										<td><h3>Congratulations! you got the payment of <b>$'.$amount.'</b></h3></td>
									</tr>
									
								</table>
								<table border="0" cellpadding="5px" width="100%" style="padding-bottom:20px;">
									
									<tr>
										<td>Please Find your invoice details below..​</td>
									</tr>
									
								</table>
								
								<table border="1" cellpadding="5px" width="100%" style="padding-bottom:20px;border-collapse: collapse;">
									
									<tr>
										<th>Order ID</th>
										<th>Order Date</th>
										<th>Order Amount</th>
										<th>Payable Amount</th>
									</tr>
									'.$invoiceData.'
									
								</table>
								
								<table border="0" cellpadding="0" width="100%" >
									
									<tr>
										<td>Thanks and Regards</td>
									</tr>
									<tr>
										<td><strong>'. $this->settings->website_name.'</strong></td>
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
		
		$mail->AddAddress(urldecode($restaurent_info->email)); 		
		
		if ($mail->Send()) 
		{
			return true;
		}else {
			return false;
		}

	}
	

    
}