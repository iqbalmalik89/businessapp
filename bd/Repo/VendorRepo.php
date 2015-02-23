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

	public function getVendors($request)
	{
		$resp = array('code' => 200, 'data' => array());
		$vendors = $GLOBALS['con']->from('vendors');
		$allVendors = array();
		if(!empty($vendors))
		{
			foreach ($vendors as $key => $vendor) {
				$vendor['images'] = $this->getVendorImages($vendor['id']);
				$vendor['days'] = $this->getVendorDays($vendor['id']);

				$resp['data'][] = $vendor;
			}
		}


		return $resp;
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
							'status' 			=> 'pending',
							'date_created' 		=> date("Y-m-d H:i:s"));
			//print_r($values);
			$vendorId = $GLOBALS['con']->insertInto('vendors', $values)->execute();		

			if($vendorId > 0)
			{
				if(isset($requestData['images']) && !empty($requestData['images']))
					$this->addVendorImages($vendorId, $requestData['images']);

				if(isset($requestData['days']) && !empty($requestData['days']))
					$this->addVendorDays($vendorId, $requestData['days']);							
			}
			$response = 200;
		}
		else
		{
			$response = 400;
		}

		return $response;
	}

	// Add Vendor Images
	public function addVendorImages($vendorId, $images)
	{
		if(!empty($images))
		{
			foreach($images as $image)
			{
				$values = array('vendor_id' => $vendorId, 'path' => $image);
				$query = $GLOBALS['con']->insertInto('vendor_images', $values)->execute();
			}
		}
	}

	public function getVendorDays($vendorId)
	{
		$VendorDays = array();
		if(!empty($vendorId))
		{
			$days = $GLOBALS['con']->from('vendor_working_days')->where('vendor_id',$vendorId);

			foreach($days as $day)
			{
				$VendorDays[] = $day;
			}
		}

		return $VendorDays;
	}
	public function getVendorImages($vendorId)
	{
		$VendorImages = array();
		if(!empty($vendorId))
		{
			$images = $GLOBALS['con']->from('vendor_images')->where('vendor_id',$vendorId);

			foreach($images as $image)
			{
				$image['url'] = UtilityRepo::getRootPath(false).'data/vendor_images/'.$image['path'];
				$VendorImages[] = $image;
			}
		}
		return $VendorImages;
	}

	public function addVendorDays($vendorId, $days)
	{
		if(!empty($days))
		{
			foreach ($days as $key => $day) {
				$values = array('vendor_id' => $vendorId, 'day_code' => $day['day_code'],'start_time' => $day['start_time'],'end_time' => $day['end_time']);
				$query = $GLOBALS['con']->insertInto('vendor_working_days', $values)->execute();
			}
		}

	}

	public function vendorStatus($request)
	{
		$response = 400;
		$requestData = $request;
		if(!empty($requestData['id']))
		{
			$value = array('status' => $requestData['status']); 
			$query = $GLOBALS['con']->update('vendors',$value,$requestData['id'])->execute();
			
			$reponse = 200;
			
		}
		return $response;
	}
	

}