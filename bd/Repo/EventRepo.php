<?php
class EventRepo
{
	public function addEvent($request)
	{
		$requestData = $request;

		$response = 400;
		if(!empty($requestData))
		{
			$exists = $this->checkEvent($requestData['event_name']);
			if($exists)
			{
				$response = 409;
			}
			else
			{
				$values = array('first_name' 	=> $requestData['first_name'],
								'last_name' 	=> $requestData['last_name'],
								'event_name'	=> $requestData['event_name'],
								'venue' 		=> $requestData['venue'],
								'address' 		=> $requestData['address'],
								'city'          => $requestData['city'],
								'state'			=> $requestData['state'],
								'country'		=> $requestData['country'],
								'postcode'		=> $requestData['postcode'],
								'office_number' => $requestData['office_number'],
								'cell_number'	=> $requestData['cell_number'],
								'start_date'	=> $requestData['start_date'],
								'end_date' 		=> $requestData['end_date'],
								'email'			=> $requestData['email'],
								'price'			=> $requestData['price'],
								'facebook'		=> $requestData['facebook'],
								'youtube'		=> $requestData['youtube'],
								'twitter'		=> $requestData['twitter'],
								'instagram'		=> $requestData['instagram'],
								'status'		=> 'pending',
								'date_created'	=> date("Y-m-d H:i:s"));

				$query = $GLOBALS['con']->insertInto('events',$values)->execute();
				if($query)
				{
					$response = 200;
				}
				else
				{
					$response = 400;
				}
			}
		}
			return $response;
	}

	public function checkEvent($name, $id = 0)
	{
		$query = $GLOBALS['con']->from('events')->where('event_name', $name);		
		if(!empty($id))
		$query = $query->where('id != ?', $id);
		return count($query);
	}

	public function eventStatus($request)
	{
		$response = 400;
		$requestData = $request;
		if(!empty($requestData['id']))
		{
			$value = array('status' => $requestData['status']); 
			$query = $GLOBALS['con']->update('events',$value,$requestData['id'])->execute();
			$response = 200;
		}
		return $response;

	}

	


}