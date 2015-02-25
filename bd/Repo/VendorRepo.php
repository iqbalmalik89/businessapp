<?php
class VendorRepo{

	// check if Business Name exists, returns false else returns true
	public function checkVendor($request)
	{	// initial response is bad
		$response = false;

		$requestData = $request;
		//checks if business_name already exists
		if(!empty($request['vendor_id']))
			$count = $GLOBALS['con']->from('vendors')->where('business_name',$requestData)->where('id != ?', $requestData['vendor_id'])->count();
		else
			$count = $GLOBALS['con']->from('vendors')->where('business_name',$requestData)->count();

		if($count > 0)
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

		if(isset($request['vendor_id']))
		{
			$vendors = $GLOBALS['con']->from('vendors')->where("id", $request['vendor_id']);
		}
		else
			$vendors = $GLOBALS['con']->from('vendors');			

		$allVendors = array();
		if(!empty($vendors))
		{
			foreach ($vendors as $key => $vendor) {
				$vendor['images'] = $this->getVendorImages($vendor['id']);
				$vendor['days'] = $this->getVendorDays($vendor['id']);
		
				if(!isset($request['vendor_id']))
					$resp['data'][] = $vendor;
				else
					$resp['data'] = $vendor;
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
		$check = $this->checkVendor($requestData);

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

			if(!empty($requestData['vendor_id']))
			{
				unset($values['status']);
				$query = $GLOBALS['con']->deleteFrom('vendor_images')->where('vendor_id', $requestData['vendor_id'])->execute();	
				$query = $GLOBALS['con']->deleteFrom('vendor_working_days')->where('vendor_id', $requestData['vendor_id'])->execute();	

				$rs = $GLOBALS['con']->update('vendors', $values, $requestData['vendor_id'])->execute();			
				$vendorId = $requestData['vendor_id'];
			}
			else
			{	
				// Add vendor
$to = "jasonbourne501@gmail.com";
$subject = "New Business Added";

$message = "
<html>
<head>
<title>New Vendor</title>
</head>
<body>
Hello,  New business is added. Please review the details. 
<table>
<tr>
<th>".$requestData['first_name'].' '.$requestData['last_name']."</th>
<th>".$requestData['business_name']."</th>
</tr>
<tr>
<td colspan='2'><a href='http://yakoinc.com/bd/admin/login.php'>Login into admin</a></td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <jasonbourne501@gmail.com>' . "\r\n";

mail($to,$subject,$message,$headers);				
				$vendorId = $GLOBALS['con']->insertInto('vendors', $values)->execute();
			}


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
				$day['start_time'] = date("g:i a", strtotime($day['start_time']));
				$day['end_time'] = date("g:i a", strtotime($day['end_time']));				
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
				$values = array('vendor_id' => $vendorId, 'day_code' => $day['day_code'],'start_time' => date("H:i:s", strtotime($day['start_time'])) ,'end_time' => date("H:i:s", strtotime($day['end_time'])));
				$query = $GLOBALS['con']->insertInto('vendor_working_days', $values)->execute();
			}
		}

	}

	public function vendorStatus($request)
	{
		$reponse = 400;
		$requestData = $request;
		if(!empty($requestData['id']))
		{
			$value = array('status' => $requestData['status']); 
			$query = $GLOBALS['con']->update('vendors',$value,$requestData['id'])->execute();
			
			$reponse = 200;
			
		}
		return $reponse;
	}
	
	public function deleteVendor($request)
	{
		$requestData = $request;
		$response = 400;

		$exists = $this->count($requestData['id']);
		if($exists)
		{
			$query = $GLOBALS['con']->deleteFrom('vendors')->where('id', $requestData['id'])->execute();
			$query1 =  $GLOBALS['con']->deleteFrom('vendor_images')->where('vendor_id', $requestData['id'])->execute();
			$query2 =  $GLOBALS['con']->deleteFrom('vendor_working_days')->where('vendor_id', $requestData['id'])->execute();
			$response = 200;

		}
		else
		{
			$response = 400;
		}
		return $response;


	}

	public function count($request)
	{

		$query = $GLOBALS['con']->from('vendors')->where('id', $request);
		$count = $query->count();
		 return $count;
	}
	

}