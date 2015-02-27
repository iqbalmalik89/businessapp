<?php
class EventRepo
{
	public function addEvent($request)
	{
		$requestData = $request;

		$response = 400;
		if(!empty($requestData))
		{
			$exists = $this->checkEvent($requestData);
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
				
				if(empty($requestData['event_id']))
				{
					$loginRepo = new LoginRepo();
					$admindata = $loginRepo->getAdminData(1);

					//"coursemadt@gmail.com"
					$to = $admindata['username'];
					$subject = "New Event Added";

					$message = "
					<html>
					<head>
					<title>New Event</title>
					</head>
					<body>
					Hello,  New Event is added. Please review the details. 
					<table cellspacing='20'>
					<tr>
					<th>".$requestData['first_name'].' '.$requestData['last_name']."</th>
					<th>".$requestData['event_name']."</th>
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
					$headers .= 'From: <'. $admindata['username'].'>' . "\r\n";

					mail($to,$subject,$message,$headers);			

					$eventId = $GLOBALS['con']->insertInto('events',$values)->execute();
				}
				else
				{
					unset($values['status']);
					$query = $GLOBALS['con']->deleteFrom('event_images')->where('event_id', $requestData['event_id'])->execute();
					$query = $GLOBALS['con']->update('events',$values, $requestData['event_id'])->execute();					
					$eventId = $requestData['event_id'];
				}

				if($eventId > 0)
				{
					if(isset($requestData['images']) && !empty($requestData['images']))
						$this->addEventImages($eventId, $requestData['images']);
				}

				if($eventId)
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

	public function checkEvent($data)
	{
		$query = $GLOBALS['con']->from('events')->where('event_name', $data['event_name'])->count();		
		if(!empty($data['event_id']))
			$query = $GLOBALS['con']->from('events')->where('event_name', $data['event_name'])->where('id != ?', $data['event_id'])->count();		

		return $query;
	}

	public function getEventImages($eventId)
	{
		$eventImages = array();
		if(!empty($eventId))
		{
			$images = $GLOBALS['con']->from('event_images')->where('event_id',$eventId);

			foreach($images as $image)
			{
				$image['url'] = UtilityRepo::getRootPath(false).'data/event_images/'.$image['path'];
				$eventImages[] = $image;
			}
		}
		return $eventImages;
	}


	public function addEventImages($eventId, $images)
	{
		if(!empty($images))
		{
			foreach($images as $image)
			{
				$values = array('event_id' => $eventId, 'path' => $image);
				$query = $GLOBALS['con']->insertInto('event_images', $values)->execute();
			}
		}
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

	// Get All Events. If id given, returns a single event else return all events.
	public function getEvents($request)
	{	
		
		$requestData = $request;
		// Initial response is bad request
		$response = 400;

		// If there is some data in json form
		if(!empty($requestData))
		{				
			$exists = $GLOBALS['con']->from('events')->where('id',$requestData['id']);

			foreach($exists as $items)
	    	{
	    		$items['images'] = $this->getEventImages($items['id']);
				$data = $items;

			}

			$response = 200;
		}
		
		else
		{
			$exists = $GLOBALS['con']->from('events');
			$data = array();
			foreach($exists as $items)
	    	{
	    		$items['images'] = $this->getEventImages($items['id']);
				$data[] = $items;

			}

			$response = 200;
				
		}
		
		return array('response' => $response,'data' => $data);
	}
	
	public function deleteEvent($request)
	{
		$requestData = $request;
		$response = 400;

		$exists = $this->count($requestData['id']);
		if($exists)
		{
			$query = $GLOBALS['con']->deleteFrom('events')->where('id', $requestData['id'])->execute();
			$query1 =  $GLOBALS['con']->deleteFrom('event_images')->where('event_id', $requestData['id'])->execute();
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

		$query = $GLOBALS['con']->from('events')->where('id', $request);
		$count = $query->count();
		 return $count;
	}

}