<?php
class PromoVendorsRepo
{
	public function addPromoVendors($request)
	{
		$requestData = $request;
		print_r($requestData);
		$action = 'post';
		$response = 400;

		if(isset($requestData['vendor_id']) && !empty($requestData['vendor_id']) && !empty($requestData['start_date']) && !empty($requestData['end_date']))
		{
			$values = array('vendor_id' => $requestData['vendor_id'],'start_date' => $requestData['start_date'],'end_date' => $requestData['end_date']);
			$query = $GLOBALS['con']->insertInto('promo_vendors',$values)->execute();

			$values2 = array('vendor_id' => $requestData['vendor_id'], 'images' =>$requestData['images']);
			$query2 = $GLOBALS['con']->insertInto('promo_vendor_images',$values2)->execute();
			$response = 200;
		}	
		return $response;		
	}

	public function editPromoVendors($request)
	{
		$requestData = $request;
		$action = 'post';
		$response = 400;

		if(isset($requestData['vendor_id']) && !empty($requestData['vendor_id']) && !empty($requestData['start_date']) && !empty($requestData['end_date']))
		{
			$values = array('vendor_id' => $requestData['vendor_id'],'start_date' => $requestData['start_date'],'end_date' => $requestData['end_date']);
			$query = $GLOBALS['con']->update('promo_vendors',$values,$requestData['id'])->execute();

			
			$response = 200;
		}	
		return $response;		
	}

	// Get Promo Vendors. 
	public function getPromoVendors($request)
	{	
		
		$requestData = $request;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{				
			$exists = $GLOBALS['con']->from('promo_vendors')->where('id',$requestData['id']);

			foreach($exists as $items)
	    	{
				$data = $items;

			}

			$response = 200;
		}
		
		else
		{
			$exists = $GLOBALS['con']->from('promo_vendors');
			$data = array();
			foreach($exists as $items)
	    	{
				$data[] = $items;

			}

			$response = 200;
				
		}
		
		return array('response' => $response,'data' => $data);
	}


}