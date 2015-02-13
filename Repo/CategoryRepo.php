<?php
class CategoryRepo
{
	/*
	* This function both handle add and update request
	*/

	public function addCategory($request)
	{
		// Get Json Input and decode it
		$requestData = json_decode($request->getBody(), TRUE);

		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(isset($requestData['cat_name']) && !empty($requestData['cat_name']))
			{
				$exists = $this->checkCat($requestData['cat_name']);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('cat_name' => $requestData['cat_name'], 'date_created' => date("Y-m-d H:i:s"));
					$query = $GLOBALS['con']->insertInto('category', $values)->execute();		
					$response = 200;
				}
			}
		}
		return $response;
	}

	public function updateCategory($request)
	{
		// Get Json Input and decode it
		$requestData = json_decode($request->getBody(), TRUE);

		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(isset($requestData['cat_name']) && !empty($requestData['cat_name']) && isset($requestData['id']))
			{
				$exists = $this->checkCat($requestData['cat_name'], $requestData['id']);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('cat_name' => $requestData['cat_name']);
					$query = $GLOBALS['con']->update('category', $values, $requestData['id'])->execute();
					$response = 200;
				}
			}
		}
		return $response;
	}

	

	public function checkCat($name, $id = 0)
	{
		$query = $GLOBALS['con']->from('category')->where('cat_name', $name);
		if(!empty($id))
			$query = $query->where('id != ?', $id);
		return count($query);
	}


}