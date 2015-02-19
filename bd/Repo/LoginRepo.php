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



}