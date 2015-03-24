<?php
class QueriesRepo
{

	// Add Vendor Images
	public function sendAdminQuery($data)
	{
		$date_created = date("Y-m-d H:i:s");
		$values = array('name' => $data['name'], 'phone' => $data['phone'], 'email' => $data['email'], 'subject' => $data['subject'], 'message' => $data['message'], 'date_created' => $date_created);
		$query = $GLOBALS['con']->insertInto('queries', $values)->execute();

		$loginRepo = new LoginRepo();
		$admindata = $loginRepo->getAdminData(1);

		//"coursemadt@gmail.com"
		$to = $admindata['username'];
		$subject = "Contact query";

		$message = "
		<html>
		<head>
		<title>New query</title>
		</head>
		<body>
		Hello,  New business is added. Please review the details. 
		<table cellspacing='20'>
		<tr>
		<th>Subject: ".$data['subject']."</th>
		<th>Name: ".$data['name']."</th>
		<th>Email: ".$data['email']."</th>
		<th>Phone: ".$data['phone']."</th>
		</tr>
		<tr>
		<td colspan='4'>".$data['message']."</td>
		</tr>
		</table>
		</body>
		</html>
		";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <'.$admindata['username'].'>' . "\r\n";

		mail($admindata['username'],$subject,$message,$headers);
		return 200;
	}

	public function addSubscriber($data)
	{
		$count = $GLOBALS['con']->from('subscribers')->where('email',$data['email'])->count();
		if($count > 0)
		{
			return 400;
		}
		else
		{
			$date_created = date("Y-m-d H:i:s");
			$values = array('email' => $data['email'],'date_created' => $date_created);
			$query = $GLOBALS['con']->insertInto('subscribers', $values)->execute();
			return 200;
		}
	}

	public function deleteQuery($request)
	{
		$query = $GLOBALS['con']->deleteFrom('queries')->where('id', $request['id'])->execute();
		return 200;
	}

	public function deleteSubscriber($request)
	{
		$query = $GLOBALS['con']->deleteFrom('subscribers')->where('id', $request['id'])->execute();
		return 200;
	}

	public function getQueries($request)
	{
		$limit = 15;
		$total_pages = 0;
		if(!isset($request['page']))
			$page = 0;
		else
			$page = $request['page'];

		$offset = $page * $limit;

		$resp = array('code' => 200, 'data' => array());

		$count = $GLOBALS['con']->from('queries')->count();
		$total_pages = ceil($count / $limit) ;			
		$queries = $GLOBALS['con']->from('queries')->limit($limit)->offset($offset);

		$allVendors = array();
		if(!empty($queries))
		{
			foreach ($queries as $key => $query) {
				$resp['data'][] = $query;
			}
		}

		$resp['total_pages'] = $total_pages;
		return $resp;
	}

	public function getSubscribers($request)
	{
		$limit = 15;
		$total_pages = 0;
		if(!isset($request['page']))
			$page = 0;
		else
			$page = $request['page'];

		$offset = $page * $limit;

		$resp = array('code' => 200, 'data' => array());

		$count = $GLOBALS['con']->from('subscribers')->count();
		$total_pages = ceil($count / $limit) ;			
		$queries = $GLOBALS['con']->from('subscribers')->limit($limit)->offset($offset);

		$allVendors = array();
		if(!empty($queries))
		{
			foreach ($queries as $key => $query) {
				$resp['data'][] = $query;
			}
		}

		$resp['total_pages'] = $total_pages;
		return $resp;
	}	

	public function editSubscriber($request)
	{
		$response = 400;

		if(!empty($request['email']))
		{
			$count = $GLOBALS['con']->from('subscribers')->where('email',$request['email'])->count();
			if($count > 0)
			{
				$response = 400;
			}
			else
			{
				$date_created = date("Y-m-d H:i:s");
				$values = array('email' => $request['email'],'date_created' => $date_created );
				$query = $GLOBALS['con']->update('subscribers', $values, $request['id'])->execute();
				$response = 200;
			}
		}
		return $response;
	}

	public function getSingleSubscriber($request)
	{
		$query = $GLOBALS['con']->from('subscribers')->where('id',$reuqeust['id']);
		$subscriber = array();

			foreach($query as $items)
	    	{
				$subscriber[] = $items;

			}

			return array('code' => '200','data' => $subscriber);
	}

	public function deactiveSubscriber($request)
	{
		$response = 400;
		$values = array('status' => 'deactive');
		$query = $GLOBALS['con']->update('subscribers', $values, $request['id'])->execute();
		
		if($query)
		{
			$response = 200;
		}

			return $response;
	}
}