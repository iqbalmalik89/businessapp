<?php
class LocationRepo
{
	public function getCountries($requestData)
	{
        // $data['country'] = City::where('CountryName', '!=', '')->groupBy('CountryName')->get()->toArray();
        //$data['state'] = City::where('CountryName', '=', $CountryName)->where('District', '!=', '')->groupBy('District')->get()->toArray();
        //$data['city'] = City::where('District', '=', $stateName)->where('Name', '!=', '')->get()->toArray();

		$resp = array('code' => 200, 'data' => array());
		$countries = $GLOBALS['con']->from('city')->groupBy('CountryName')->where('CountryName', 'Canada')->where('CountryName != ?', '');
		if(!empty($countries))
		{
			foreach ($countries as $key => $country) {
				$resp['data'][] = array('id' => $country['ID'], 'name' => $country['CountryName']);
			}
		}

		return $resp;
	}


	public function getStates($requestData)
	{
		$resp = array('code' => 200, 'data' => array());
		$states = $GLOBALS['con']->from('city')->where('CountryName', $requestData['country'])->groupBy('District');
		if(!empty($states))
		{
			foreach ($states as $key => $state) {
				$resp['data'][] = array('id' => $state['ID'], 'name' => utf8_encode($state['District']));
			}
		}

		return $resp;
	}	

	public function getCities($requestData)
	{
		$resp = array('code' => 200, 'data' => array());

		$cities = $GLOBALS['con']->from('city')->where('District', $requestData['state']);
		if(!empty($cities))
		{
			foreach ($cities as $key => $city) {
				$resp['data'][] = array('id' => $city['ID'], 'name' => utf8_encode($city['Name']));
			}
		}

		return $resp;
	}		

}