<?php
class DealRepo
{
	public function addDeal($request)
	{
		$requestData = $request;
		
		$response = 400;
		if(!empty($requestData))
		{
			if(!empty($requestData['deal_name']) && !empty($requestData['start_date']) && !empty($requestData['end_date']))
			{
				$exists = $this->checkdeal($requestData['deal_name']);
				if($exists)
				{
					$response = 409;
				}
				else
				{
					$values = array('deal_name' => $requestData['deal_name'],'start_date' => $requestData['start_date'], 'end_date' => $requestData['end_date'], 'desc' => $requestData['desc'], 'status' => $requestData['status']);
					$query = $GLOBALS['con']->insertInto('deals', $values)->execute();	
					
					$response = 200;
				}
			}
		}

		return $response;
	}

	public function checkDeal($name)
	{
		$query = $GLOBALS['con']->from('deals')->where('deal_name', $name);
		return count($query);
	}
	
}