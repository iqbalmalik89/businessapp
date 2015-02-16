<?php
class LoginRepo{

	public function login($request)
	{
		$requestData = $request;

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



}