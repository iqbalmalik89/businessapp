<?php
class DealRepo
{
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
					$query = $GLOBALS['con']->insertInto('deals', $values)->execute();	
					$response = 200;
				}
			}
		}
		return $response;
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
					$values = array('deal_name' => $requestData['deal_name'],'start_date' => $requestData['start_date'], 'end_date' => $requestData['end_date'], '`desc`' => $requestData['desc'], '`status`' => 'pending');
					$query = $GLOBALS['con']->update('deals', $values, $requestData['id'])->execute();
					$response = 200;
				}
			}
		}
		return $response;
	}

	public function deleteDeal($requestData)
	{
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

	// Get All Deals. If id given, returns a single deal else return all deals.
	public function getDeals($request)
	{	
		
		$requestData = $request;
		// Initial response is bad request
		$response = 400;
		$data = array();

		// If there is some data in json form
		if(!empty($requestData))
		{				
			$exists = $GLOBALS['con']->from('deals')->where('id',$requestData['id']);
			$allCat = array();

			foreach($exists as $items)
	    	{
				$data[] = $items;

			}

			$response = 200;
		}
		
		else
		{
			$exists = $GLOBALS['con']->from('deals');
			$allCat = array();

			foreach($exists as $items)
	    	{
				$data[] = $items;

			}

			$response = 200;
				
		}
		
		return array('response' => $response,'data' => $data);
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

	public function addDealVendors($request)
	{
		$response = 200;
		$requestData = $request;
		$exists = $GLOBALS['con']->deleteFrom('vendor_deals')->where('deal_id',$requestData['deal_id'])->execute();
		$vendor = $requestData['vendor_ids'];
	    
		 foreach($vendor as $items)
		 {
		 	$value = array('deal_id' => $requestData['deal_id'], 'vendor_id' => $items);
		 	$query = $GLOBALS['con']->insertInto('vendor_deals',$value)->execute();
		     
		 }
		
		return $response;
	}


}