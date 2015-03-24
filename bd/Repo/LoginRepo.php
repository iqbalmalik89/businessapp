<?php
class LoginRepo{

	public function login($request)
	{
		$requestData = $request;
					// $values = array('username' => 'kam@yahoo.com', 'password' => md5('admin123!'), 'name' => 'Kam');
					// $query = $GLOBALS['con']->insertInto('admin', $values)->execute();		

		$response = 400;
		if(!empty($requestData))
		{
			$rec = $GLOBALS['con']->from('admin')->where('username',$requestData['username'])->where('password',md5($requestData['password']));
			$exists = count($rec);

			if($exists)
			{
				$_SESSION['user'] = $rec->fetch();
				$response = 200;
			}
			else
			{
				$response =400;
			}
		}

		return $response;
	}

	public function getAdminData($id = 1)
	{
		$rec = $GLOBALS['con']->from('admin')->where('id',$id);
		$rec = $rec->fetch();
		$_SESSION['user'] = $rec;
		return $rec;
	}

	public function editAdminData($request)
	{
		$requestData = $request;
		$id = 1;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(!empty($requestData['name']) && !empty($requestData['email']))
			{
				
				$values = array('name' => $requestData['name'], 'username' => $requestData['email']);
				$query = $GLOBALS['con']->update('admin', $values, $id)->execute();
				$this->getAdminData(1);
				$response = 200;
				
			}
		}
		return $response;
	}

	public function editadminpassword($request)
	{
		$requestData = $request;
		$id = 1;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(!empty($requestData['password']))
			{
				
				$values = array('password' => md5($requestData['password']));
				$query = $GLOBALS['con']->update('admin', $values, $id)->execute();
				$response = 200;
				
			}
		}
		return $response;
	}
	public function forgotPassword($request)
	{
		$requestData = $request;
		$response = 400;

		if(!empty($requestData['email']))
		{
			$rec = $GLOBALS['con']->from('admin')->where('username',$requestData['email']);
			$exists = count($rec);

			if($exists)
			{
				$code1 = mt_rand(100,999);
				$code2 = mt_rand(100,999);
				$code = $code1.$code2;
				
				$values = array('code' => $code);
				$query = $GLOBALS['con']->update('admin', $values)->where('username',$requestData['email'])->execute();

				$msg = "Hi! Enter this code ".$code."and reset your password";
				$to = $requestData['email'];
				$subject = "Reset Password";

				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				//$headers .= 'From: <'. .'>' . "\r\n";

				mail($to,$subject,$msg,$headers);	
				$response = 200;
			}
			else
			{
				$response =400;
			}
		}
		return $response;
	}

	public function resetPassword($request)
	{
		$requestData = $request;
		$response = 400;

		$rec = $GLOBALS['con']->from('admin')->where('username',$requestData['email'])->where('code',$requestData['code']);
		$exists = count($rec);

		if($exists)
		{
			$values = array('password' => $requestData['password']);
			$query = $GLOBALS['con']->update('admin', $values)->where('username',$requestData['email'])->execute();
			$response = 200;
		}
		else
		{
			$response = 400;
		}
		return $response;
	}

}
