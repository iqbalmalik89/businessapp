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

}
