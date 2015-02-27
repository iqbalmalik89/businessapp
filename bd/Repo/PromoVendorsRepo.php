<?php
class PromoVendorsRepo
{
	public function addPromoVendors($request)
	{
		$requestData = $request;

		$action = 'post';
		$response = 400;

		if(isset($requestData['vendor_id']) && !empty($requestData['vendor_id']) && !empty($requestData['start_date']) && !empty($requestData['end_date']))
		{
			$values = array('vendor_id' => $requestData['vendor_id'],'start_date' => $requestData['start_date'],'end_date' => $requestData['end_date']);
			$promo_id = $GLOBALS['con']->insertInto('promo_vendors',$values)->execute();

			if(isset($requestData['images']) && !empty($requestData['images']))
				$this->addPromoImages($requestData['vendor_id'], $promo_id ,$requestData['images']);

			$response = 200;
		}


		return $response;		
	}

	// Add Vendor Images
	public function addPromoImages($vendorId, $promo_id , $images)
	{
		if(!empty($images))
		{
			foreach($images as $image)
			{
				$values = array('vendor_id' => $vendorId, 'path' => $image, 'promo_id' => $promo_id);
				$query = $GLOBALS['con']->insertInto('promo_vendor_images', $values)->execute();
			}
		}
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

			$query = $GLOBALS['con']->deleteFrom('promo_vendor_images')->where('promo_id', $requestData['id'])->execute();

			if(isset($requestData['images']) && !empty($requestData['images']))
				$this->addPromoImages($requestData['vendor_id'], $requestData['id'] ,$requestData['images']);
			
			$response = 200;
		}	
		return $response;		
	}

	public function deletePromoVendor($requestData)
	{
		$query = $GLOBALS['con']->deleteFrom('promo_vendors')->where('id', $requestData['id'])->execute();	
		$query = $GLOBALS['con']->deleteFrom('promo_vendor_images')->where('promo_id', $requestData['id'])->execute();	
		return 200;
	}

	public function getPromoVendorImages($promo_id)
	{
		$VendorImages = array();
		if(!empty($promo_id))
		{
			$images = $GLOBALS['con']->from('promo_vendor_images')->where('promo_id',$promo_id);

			foreach($images as $image)
			{
				$image['url'] = UtilityRepo::getRootPath(false).'data/promo_images/'.$image['path'];
				$VendorImages[] = $image;
			}
		}
		return $VendorImages;
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
				$items['images'] = $this->getPromoVendorImages($items['id']);

				$vendorsquery = $GLOBALS['con']->from('vendors')->where("id", $items['vendor_id']);				
				$vendorsquery = $vendorsquery->fetch();

				if(isset($vendorsquery['business_name']))
				$items['vendor_name'] = $vendorsquery['business_name'];

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
				$items['images'] = $this->getPromoVendorImages($items['id']);
				$vendorsquery = $GLOBALS['con']->from('vendors')->where("id", $items['vendor_id']);				
				$vendorsquery = $vendorsquery->fetch();

				if(isset($vendorsquery['business_name']))
				$items['vendor_name'] = $vendorsquery['business_name'];				
				$data[] = $items;

			}

			$response = 200;
				
		}
		
		return array('response' => $response,'data' => $data);
	}


}