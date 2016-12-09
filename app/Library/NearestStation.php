<?php
namespace App\Library;

class NearestStation{
	// Define the config params
	var $googleKey = 'AIzaSyBBbAzwZ7KZiiuKoaCAyp_FppbRwdtBQzQ';
	var $defaultDistance = 1;
	
	public function getNearestStations($address){
		if (!trim($address))
			return array();
			
		$address = urlencode($address);
		
		//Get GEO Coordinates
		$apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?language=ja-JP&address='.$address.'&key='.$this->googleKey;
		$response = file_get_contents($apiUrl);
		$oResponse = json_decode($response);
		
		if (!empty($oResponse) && $oResponse->status == 'OK' && count($oResponse->results) > 0)
		{
			$coordinates = $oResponse->results[0]->geometry->location;
			$lon = $coordinates->lng;
			$lat = $coordinates->lat;
			$apiUrl = 'http://express.heartrails.com/api/json?method=getStations&x='.$lon.'&y='.$lat;
			$response = file_get_contents($apiUrl);
			$oResponse = json_decode($response, true);
			$stations = array();
			$stationNames = array();
			foreach ($oResponse['response']['station'] as $station)
			{
				if (!in_array($station['name'], $stationNames))
				{
					$stationNames[] = $station['name'];
					$stations[] = $station;
				}
			}
			return $stations;
		
		}
		else {
			return array();
		}
		
	}
}

