<?php
class VendorRepo{

	// check if Business Name exists, returns false else returns true
	public function checkVendor($request)
	{	// initial response is bad
		$response = false;

		$requestData = $request;
		//checks if business_name already exists
		$check = $GLOBALS['con']->from('vendors')->where('business_name',$requestData);
		$count = count($check);
		echo $count;
		if($count)
		{
			$response = false;
		}
		else
		{
			$response = true;
		}
		return $response;
	}

	public function businessAdd($request)
	{
		// initial response is bad
		$response = 400;
		$requestData = $request;
		//var_dump($requestData);
		$check = $this->checkVendor($requestData['business_name']);
		if($check)
		{
			$values = array('first_name' 		=> $requestData['first_name'],
							'last_name' 		=> $requestData['last_name'],
							'business_name' 	=> $requestData['business_name'],
							'address' 			=> $requestData['address'],
							'city'				=> $requestData['city'],
							'state' 			=> $requestData['state'],
							'country' 			=> $requestData['country'],
							'postcode' 			=> $requestData['postcode'],
							'cat_id' 			=> $requestData['cat_id'],
							'sub_cat_id'		=> $requestData['sub_cat_id'],
							'office_number' 	=> $requestData['office_number'],
							'cell_number' 		=> $requestData['cell_number'],
							'email' 			=> $requestData['email'], 
							'website' 			=> $requestData['website'],
							'facebook' 			=> $requestData['facebook'],
							'youtube' 			=> $requestData['youtube'],
							'twitter' 			=> $requestData['twitter'],
							'instagram' 		=> $requestData['instagram'],
							'status' 			=> $requestData['status'],
							'date_created' 		=> date("Y-m-d H:i:s"));
			//print_r($values);
			$query = $GLOBALS['con']->insertInto('vendors', $values)->execute();		
			$response = 200;
		}
		else
		{
			$response = 400;
		}

		return $response;
	}

	// Add Vendor Images
	public function addVendorImages($request)
	{
		$response =400;
		$requestData = $request;
		if(!empty($request))
		{

		}
		
		die();
		$query = $GLOBALS['con']->from('vendor_images')->where('vendor_id',$requestData['vendor_id']);
		if(!empty($query))
		{
			foreach($query as $items)
	    	{
				$data = $items;

			}
			$values = array('vendor_id' => $data['vendor_id'], 'path' => $requestData['path']);
			$query = $GLOBALS['con']->update('vendor_images', $values, $data['id'])->execute();
			$response = 200;
		}
		return $response;
	}

	public function addVendorDays($request)
	{
		$response =400;
		$requestData = $request;

		$query = $GLOBALS['con']->from('vendor_working_days')->where('vendor_id',$requestData['vendor_id']);
		if(!empty($query))
		{
			foreach($query as $items)
	    	{
				$data = $items;

			}
			$values = array('vendor_id' => $data['vendor_id'], 'day_code' => $requestData['day_code'],'start_time' => $requestData['start_time'],'end_time' => $requestData['end_time']);
			$query = $GLOBALS['con']->update('vendor_working_days', $values, $data['id'])->execute();
			$response = 200;
		}
		return $response;
	}

}