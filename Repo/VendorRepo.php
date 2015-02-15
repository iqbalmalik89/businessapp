<?php
class VendorRepo{

	public function checkVendor($request)
	{
		$response = false;
		$requestData = $request;
		$check = $GLOBALS['con']->from('vendors')->where('business_name',$requestData['business_name']);
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
}