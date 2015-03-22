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
		$query = $GLOBALS['con']->from('events')
			->where('first_name', $data['first_name'])
			->where('last_name', $data['last_name'])
			->where('venue', $data['venue'])
			->where('city', $data['city'])
			->where('state', $data['state'])
			->where('country', $data['country'])
			->where('postcode', $data['postcode'])
			->where('email', $data['email'])
			->where('price', $data['price'])
			->where('event_name', $data['event_name'])
			->where('start_date', $data['start_date'])
			->where('end_date', $data['end_date'])
			->where('address', $data['address'])
			->count();		
		if(!empty($data['event_id']))
		{
			$query = $GLOBALS['con']->from('events')
			->where('first_name', $data['first_name'])
			->where('last_name', $data['last_name'])
			->where('venue', $data['venue'])
			->where('city', $data['city'])
			->where('state', $data['state'])
			->where('country', $data['country'])
			->where('postcode', $data['postcode'])
			->where('email', $data['email'])
			->where('price', $data['price'])
			->where('event_name', $data['event_name'])
			->where('start_date', $data['start_date'])
			->where('end_date', $data['end_date'])
			->where('address', $data['address'])
			->where('id != ?', $data['event_id'])
			->count();	
		}


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

		$requestData = $request;
		
		if(!isset($requestData['status']))
			$status = 'ongoing';
		else
			$status = $requestData['status'];

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
			$exists = $GLOBALS['con']->from('events')->where('id',$requestData['id']);

			foreach($exists as $items)
	    	{
	    		$items['images'] = $this->getEventImages($items['id']);
	    		$items['start_date'] = date('Y/m/d H:i', strtotime($items['start_date']));
	    		$items['end_date'] = date('Y/m/d H:i', strtotime($items['end_date']));	    		
				$data = $items;

			}

			$response = 200;
		}		
		else
		{
			if(!isset($key))
			{
				$count = $GLOBALS['con']->from('events')->where("status", $status)->count();
			}
			else
			{
				$rawSql = "SELECT COUNT(*) as cid FROM events where status = '".$status."' AND ( 
					first_name like '".$key."' || 
					last_name like '".$key."' || 
					event_name like '".$key."' || 
					venue like '".$key."' || 
					address like '".$key."' || 
					city like '".$key."' || 
					state like '".$key."' || 
					country like '".$key."' || 
					postcode like '".$key."' || 
					office_number like '".$key."' || 
					cell_number like '".$key."' || 
					email like '".$key."' || 
					price like '".$key."'
					)";

				$stmt = $GLOBALS['pdo']->query($rawSql);
				$count = $stmt->fetchColumn();

			}

			$total_pages = ceil($count / $limit);

			if(isset($key))
			{
				$rawSql = "SELECT * FROM events where status = '".$status."' AND ( 
					first_name like '".$key."' || 
					last_name like '".$key."' || 
					event_name like '".$key."' || 
					venue like '".$key."' || 
					address like '".$key."' || 
					city like '".$key."' || 
					state like '".$key."' || 
					country like '".$key."' || 
					postcode like '".$key."' || 
					office_number like '".$key."' || 
					cell_number like '".$key."' || 
					email like '".$key."' || 
					price like '".$key."'
					)";

				$stmt = $GLOBALS['pdo']->query($rawSql);
				$exists = $stmt->fetchAll(PDO::FETCH_ASSOC);


			}
			else
			{
				$exists = $GLOBALS['con']->from('events')->where("status", $status)->orderBy($sortBy." ".$orderBy)->limit($limit)->offset($offset);
			}

			$data = array();
			foreach($exists as $items)
	    	{
	    		$items['images'] = $this->getEventImages($items['id']);
				$data[] = $items;

			}

			$response = 200;
				
		}

		return array('response' => $response,'data' => $data , 'total_pages' => $total_pages, "count" => $count);
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