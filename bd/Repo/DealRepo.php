<?php
class DealRepo
{
	public $vendorRepo;
	public function addDeal($request)
	{
		$requestData = $request;
		$action = 'post';
		$response = 400;
		if(!empty($requestData))
		{
			if(!empty($requestData['deal_name']) && !empty($requestData['start_date']) && !empty($requestData['end_date']))
			{
				$exists = $this->checkDeal($requestData['deal_name'],$action);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('deal_name' => $requestData['deal_name'],'start_date' => $requestData['start_date'], 'end_date' => $requestData['end_date'], '`desc`' => $requestData['desc'], '`status`' => 'pending');
					$dealId = $GLOBALS['con']->insertInto('deals', $values)->execute();	
					$response = 200;

					$query = $GLOBALS['con']->deleteFrom('deal_images')->where('deal_id', $dealId)->execute();

					if(isset($requestData['images']))
						$this->addDealImages($dealId, $requestData['images']);

				}
			}
		}
		return $response;
	}

	public function isVendorDeal($dealId, $vendorId)
	{
		$count = $GLOBALS['con']->from('vendor_deals')->where('deal_id',$dealId)->where('vendor_id',$vendorId)->count();
		return $count;
	}

	public function getVendorDeals($request)
	{
		$deals = $this->getDeals('');

		if(isset($deals['data']))
		{
			foreach ($deals['data'] as $key => &$deal) {
				$deal['is_vendor'] = $this->isVendorDeal($deal['id'], $request['vendor_id']);
			}
		}
		return $deals;
	}

	public function addDealImages($dealId, $images)
	{
		if(!empty($images))
		{
			foreach($images as $image)
			{
				$values = array('deal_id' => $dealId, 'path' => $image);
				$query = $GLOBALS['con']->insertInto('deal_images', $values)->execute();
			}
		}
	}

	public function checkDeal($data,$action)
	{
		if($action == 'post')
		{
			$query = $GLOBALS['con']->from('deals')->where('deal_name', $data);	
			$query = $query->count();
		}	
		else if($action == 'put')
		{

			$query = $GLOBALS['con']->from('deals')->where('id', $data);
			$query = $query->count();
		}

		return $query;

	}

	public function updateDeal($request)
	{
		// Get Json Input and decode it
		$requestData = $request;
		$action = 'put';
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{
			// Check if cat_name is not empty
			if(isset($requestData['deal_name']) && !empty($requestData['deal_name']) && isset($requestData['id']) 
				&& isset($requestData['start_date']) && isset($requestData['end_date']))
			{
				$exists = $this->checkDeal($requestData['id'],$action);
				if(!$exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('deal_name' => $requestData['deal_name'],'start_date' => date('Y-m-d', strtotime($requestData['start_date'])), 'end_date' => date('Y-m-d', strtotime($requestData['end_date'])), '`desc`' => $requestData['desc'], '`status`' => 'pending');
					$query = $GLOBALS['con']->update('deals', $values, $requestData['id'])->execute();
					$response = 200;

					$query = $GLOBALS['con']->deleteFrom('deal_images')->where('deal_id', $requestData['id'])->execute();

					if(isset($requestData['images']))
						$this->addDealImages($requestData['id'], $requestData['images']);
				}
			}
		}
		return $response;
	}

	public function deleteDeal($requestData)
	{
		$query = $GLOBALS['con']->deleteFrom('deals_images')->where('deal_id', $requestData['id'])->execute();
		$query = $GLOBALS['con']->deleteFrom('vendor_deals')->where('deal_id', $requestData['id'])->execute();
		$query = $GLOBALS['con']->deleteFrom('deals')->where('id', $requestData['id'])->execute();
		if($query)
		{
			return 200;
		}
		else
		{
			return 400;
		}
	}	

	public function getDealImages($dealId)
	{
		$dealImages = array();
		if(!empty($dealId))
		{
			$images = $GLOBALS['con']->from('deal_images')->where('deal_id',$dealId);

			foreach($images as $image)
			{
				$image['url'] = UtilityRepo::getRootPath(false).'data/deals_images/'.$image['path'];
				$dealImages[] = $image;
			}
		}
		return $dealImages;
	}


	public function getDealVendors($dealId)
	{
		$vendors = array();
		$query = $GLOBALS['con']->from('vendor_deals')->where('deal_id',$dealId);
		if(!empty($query))
		{
			foreach ($query as $key => $deal) {
				$vendorData = $this->vendorRepo->getVendors(array('vendor_id' => $deal['vendor_id']));				
				if(isset($vendorData['data']))
				{
					$vendors[] = array('vendor_id' => $deal['vendor_id'], 'vendor_name' => $vendorData['data']['business_name']);
				}
			}
		}

		return $vendors;
	}

	// Get All Deals. If id given, returns a single deal else return all deals.
	public function getDeals($request)
	{	
		$sortBy = 'id';
		$orderBy = 'asc';

		if(isset($request['sort_by']) && !empty($request['sort_by']) && isset($request['sort_order']) && !empty($request['sort_order'] )) 
		{
			$sortBy = $request['sort_by'];
			$orderBy = $request['sort_order'];
		}
		
		$count = 0;

		if(isset($request['search']) && !empty($request['search']))
			$key = '%'.$request['search'].'%';

		$this->vendorRepo = new VendorRepo();
		$requestData = $request;

		$limit = 15;
		$total_pages = 0;
		if(!isset($requestData['page']))
			$page = 0;
		else
			$page = $requestData['page'];

		$offset = $page * $limit;


		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(isset($requestData['id']))
		{
			$exists = $GLOBALS['con']->from('deals')->where('id',$requestData['id']);

			foreach($exists as $items)
	    	{
				$data = $items;	
				$data['images'] = $this->getDealImages($requestData['id']); 
				$data['vendors'] = $this->getDealVendors($requestData['id']);
			}

			$response = 200;
		}
		
		else
		{
			$data = array();
			if(!isset($key))
			{
				$count = $GLOBALS['con']->from('deals')->count();
			}
			else
			{
				$rawSql = "SELECT COUNT(*) as cid FROM deals where ( 
					deal_name like '".$key."' || 
					`desc` like '".$key."' || 
					`status` like '".$key."'
					)";

				$stmt = $GLOBALS['pdo']->query($rawSql);
				$count = $stmt->fetchColumn();				
			}

			$total_pages = ceil($count / $limit) ;
			if(!isset($key))
			{
				$exists = $GLOBALS['con']->from('deals')->orderBy($sortBy." ".$orderBy)->limit($limit)->offset($offset);
			}
			else
			{
				$rawSql = "SELECT * FROM deals where ( 
					deal_name like '".$key."' || 
					`desc` like '".$key."' || 
					`status` like '".$key."'
					)";

				$stmt = $GLOBALS['pdo']->query($rawSql);
				$exists = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}

			foreach($exists as $items)
	    	{
				$items['vendors'] = $this->getDealVendors($items['id']);
				$data[] = $items;
			}

			$response = 200;
		}
		
		return array('response' => $response,'data' => $data, 'total_pages' => $total_pages, 'count' => $count);
	}
	
	public function dealStatus($request)
	{
		$response = 400;
		$requestData = $request;
		if(!empty($requestData['id']))
		{
			$value = array('status' => $requestData['status']); 
			$query = $GLOBALS['con']->update('deals',$value,$requestData['id'])->execute();
			
			$reponse = 200;
			
		}
		return $response;

	}

	// public function addDealVendors($request)
	// {
	// 	$response = 200;
	// 	$requestData = $request;
	// 	$exists = $GLOBALS['con']->deleteFrom('vendor_deals')->where('deal_id',$requestData['deal_id'])->execute();
	// 	$vendor = $requestData['vendor_ids'];
	    
	// 	 foreach($vendor as $items)
	// 	 {
	// 	 	$value = array('deal_id' => $requestData['deal_id'], 'vendor_id' => $items);
	// 	 	$query = $GLOBALS['con']->insertInto('vendor_deals',$value)->execute();
		     
	// 	 }
		
	// 	return $response;
	// }

	public function postVendorDeals($request)
	{
		$response = 200;
		$requestData = $request;
		$exists = $GLOBALS['con']->deleteFrom('vendor_deals')->where('vendor_id',$requestData['vendor_id'])->execute();

		if(isset($requestData['deal_ids']))
		{
			$deals = $requestData['deal_ids'];
		    
			 foreach($deals as $item)
			 {
			 	$value = array('deal_id' => $item, 'vendor_id' => $requestData['vendor_id']);
			 	$query = $GLOBALS['con']->insertInto('vendor_deals',$value)->execute();		     
			 }
			
		}

		return 200;
	}

}