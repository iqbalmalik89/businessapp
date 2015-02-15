<?php
class SubCatRepo{

	/*
	* This function handle add request
	*/

	public function addSubCategory($request){

		$requestData = $request;

		$action = 'post';
		$response = 400;
		if(!empty($requestData))
		{
			if(!empty($requestData['sub_cat_name']) && !empty($requestData['cat_id']))
			{
				$exists = $this->checkSubCat($requestData['sub_cat_name'],$requestData['cat_id'],$action);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('cat_id' => $requestData['cat_id'],'cat_name' => $requestData['sub_cat_name'], 'date_created' => date("Y-m-d H:i:s"));
					$query = $GLOBALS['con']->insertInto('sub_category', $values)->execute();		
					$response = 200;
				}
			}
		}

		return $response;
	}

	public function updateSubCategory($request)
	{
				$requestData = $request;

		$action = 'put';
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(!empty($requestData['sub_cat_name']) && !empty($requestData['sub_cat_id']))
			{
				$exists = $this->checkSubCat($requestData['sub_cat_name'],$requestData['sub_cat_id'],$action);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('cat_name' => $requestData['sub_cat_name'], 'date_created' => date("Y-m-d H:i:s"));
					$query = $GLOBALS['con']->update('sub_category', $values, $requestData['id'])->execute();
					$response = 200;
				}
			}
		}
		return $response;
	}

	public function deleteSubCategory($request)
	{
		$requestData = $request;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(!empty($requestData['sub_cat_id']))
			{	
				$exists = $GLOBALS['con']->from('sub_category')->where('id',$requestData['sub_cat_id']);
				$exists = count($exists);
				if($exists)
				{
					$query = $GLOBALS['con']->deleteFrom('sub_category')->where('id', $requestData['sub_cat_id'])->execute();
					$response = 200;
				}
				else
				{
					$response = 409;
				}
			}
		}
		return $response;
	}

	// Get All Sub-Categories. If category id given, returns sub-categories of that Category
	public function getSubCategory($request)
	{	
		
		$requestData = $request;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{				
			$exists = $GLOBALS['con']->from('sub_category')->where('cat_id',$requestData['cat_id']);
			$allCat = array();

			foreach($exists as $items)
	    	{
				$allCat[] = $items;

			}

			$response = 200;
		}
		
		else
		{
			$exists = $GLOBALS['con']->from('sub_category');
			$allCat = array();

			foreach($exists as $items)
	    	{
				$allCat[] = $items;

			}

			$response = 200;
				
		}
		
		return array('response' => $response,'data' => $allCat);
	}

		
	public function checkSubCat($name, $id, $action)
	{

		if($action == 'post'){
			$query = $GLOBALS['con']->from('sub_category')->where('cat_name', $name)->where('cat_id',$id);
		}
		else if($action == 'put')
		{
			$query = $GLOBALS['con']->from('sub_category')->where('cat_name', $name)->where('id',$id);
		}
		return count($query);
	}

}

