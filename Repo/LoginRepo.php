<?php
class LoginRepo{

	public function login($request)
	{
		$requestData = $request;

		$response = 400;
		if(!empty($requestData))
		{
			$exists = $GLOBALS['con']->from('admin')->where('username',$requestData['username'])->where('password',$requestData['password']);
			$exists = count($exists);
			if($exists)
			$response = 200;
			else
			$response =400;
		}

		return $response;
	}



}