<?php
class LocationExtended_Model extends Location_Model
{
	public static function get_location_by_name($country_name)
	{
		// Find the country with the specified name
		$location = self::factory('location')->where('location_name', $country_name)->find();
		
		// Return
		return ($location->loaded)? $location : NULL;

	}
}
?>