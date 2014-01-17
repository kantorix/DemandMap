<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
//include('application/models/incident.php');
class smsparse {
 
 
    public function __construct()
    {
        // Hook into routing
        Event::add('system.pre_controller', array($this, 'add'));
    }
 
 
    public function add()
    {
    	Event::add('ushahidi_action.message_sms_add', array($this, 'parse'));
    }
	
	public function parse()
	{
		$sms = Event::$data; 
		$data = $this->parse_contents($sms->message);
		$incident = new Incident_Model();
			$incident->incident_title = $data["title"];
			
			//$incident->incident_description = $sms->$message;
			$incident->location_id = $data["location_id"];
			$incident->incident_date = $sms->message_date;
			$incident->incident_dateadd = date("Y-m-d H:i:s",time());
			$incident->incident_active = 1;
			$incident->incident_verified = 1;
			$incident->save();
			
			// Update Message with Incident ID
			$sms->incident_id = $incident->id;
			$sms->save();
			
			$incident_category = new Incident_Category_Model();
			$incident_category->incident_id = $incident->id;
			$incident_category->category_id = $data["category_id"];
			$incident_category->save();
	}
	
	private function parse_contents($sms)
	{
		$result = array();
		// categories and keys are identified by '#'
		$items = explode("#",$sms);
		foreach ($items as $item)
		{
			if (strlen($item) < 1)
				continue;
			
			// key and value are seperated via ':'
			$kvp = explode(":", $item);
			
			// Houston, we have a problem
			//@TODO: send feedback to user or admin
			if ( sizeof($kvp) != 2 )
				return;
			
			// check for known keys or assign category
			switch( $kvp[0] )
			{
				case 'loc':
					// geolocation
					$geoarray = map::geocode($kvp[1]);
					$geoarray["country_name"] = $geoarray["country"];
					$result["location_id"] = $this->save_location($geoarray);
					break;
					
				case 'title':
					$result["title"] = $kvp[1];
					break;
					
				case 'cat':
					$result["category_id"] = $this->save_category($kvp[1]);
					break;
					
				default:
					break;
			}
		}
		return $result;
	}
	
	private function save_location($post)
	{
		$location = LocationExtended_Model::get_location_by_name($post["location_name"]);

		// country noch nicht vorhanden, neu anlegen
		if ( !isset($location) )
		{
			// Assign country_id retrieved
			$location = new Location_Model();
			$location->location_name = $post["location_name"];
			$location->latitude = $post["latitude"];
			$location->longitude = $post["longitude"];
			$location->country_id = $post["country_id"];
			$location->location_date = date("Y-m-d H:i:s",time());
			$location->save();
		}
		return $location->id;
	}
	
	private function save_category($category)
	{
		$cat = ORM::factory("category")
				->where("category_title", $category)
				->find();

		if ( !$cat->loaded)
		{
			$allCategories = Category_Model::categories();
			$exclude = array();
			foreach ($allCategories as $cat)
			{
				$exclude[] = $cat->category_color;
			}
			
			$cat = new Category_Model();
			$cat->category_title = $category;
			//$cat->parent_id = 0;
			//$cat->locale="en_us";
			//$cat->category_position=5;
			$cat->category_color = $this->create_color($exclude);
			$cat->category_visible = 1;
			$cat->category_trusted = 1;
			$cat->save();
		}
		
		return $cat->id;
	}
	
	private function random_color_part()
	{
    	return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	private function random_color()
	{
    	return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}
	
	private function create_color($exclude)
	{
		$run = true;
		$color = "000000";
		while ( $run == true )
		{
			$color = $this->random_color();
			$run = in_array($color, $exclude);
		}
		return $color;
	}
}
 
//instatiation of hook
new smsparse;
?>