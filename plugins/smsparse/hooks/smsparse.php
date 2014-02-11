<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
//include('application/models/incident.php');
class smsparse {
 
 
    public function __construct()
    {
        // Hook into routing
        Event::add('system.pre_controller', array($this, 'add'));
		 
//instatiation of hook
		//$sms->message = "#cat:reports#loc:juba#title:Wasser#desc:Test mit Category preg_match";
		//$sms->message_from = "4917684128175";
		//Event::run('ushahidi_action.message_sms_add', $sms);
		//$this->parse($sms);
    }
 
 
    public function add()
    {
    	Event::add('ushahidi_action.message_sms_add', array($this, 'parse'));
		Event::add('ushahidi_action.report_edit', array($this, 'send_message'));
    }
	
	public function send_message()
	{
		
	}
	
	private function get_reporter_type($reporter_id)
	{
		$reporterType = ORM::factory('reporters_types')
			->where("reporter_id", $reporter_id)
			->find();
		return $reporterType;
	}
	
	public function parse()
	{
		
		// "parse";
		// get sms data from Ushahidi and parse content
		$sms = Event::$data; 
		$data = $this->parse_contents($sms->message);
		$incident = NULL;

    // echo "parse contents";
		
		// reporter is created in Ushahidi SMS Core before the sms add event is invoked
		$reporter = ORM::factory('reporter')
		    ->where('service_account', $sms->message_from)
		    ->find();

    // echo "reporter";
			
		// Registration sms, don't create incident
		if ( in_array("reporter_type_id", array_keys($data)) )
		{
			//@TODO: Herausfinden warum das suchen nach reporter_id nicht funktioniert
			
			$reporterType = $this->get_reporter_type($reporter->id);
			
			//var_dump($reporterType->loaded);
			
			if ( !$reporterType->loaded )
			{
				$reporterType = new Reporters_Types_Model();
				$reporterType->reporter_id = $reporter->id;
				$reporterType->type_id = $data["reporter_type_id"];
				$reporterType->save();
			}
			
			// set reporter trusted
			//$reporter->level_id = 4;
			$reporter->location_id = $data["location_id"];
			$reporter->save();
		}	
		// message did not contain any hashtags, create unpublished incident 
		elseif (in_array("invalid_message_content", array_keys($data))) 
		{
			$data["active"] = 0;// not active
			$data["verified"] = 0;//not verified
			$data["title"] = "New Report";
			$data["description"] = $data["invalid_message_content"];
			$geoarray = map::geocode("Juba");
			$geoarray["country_name"] = $geoarray["country"];
			$data["location_id"] = $this->save_location($geoarray);
			$incident = $this->create_new_incident($data, $sms->message_date);
		}
		// create incident
		else
		{	
			$data["active"] = 1;//active
			$data["verified"] = 1;//$reporter->level_id >= 4 ? 1 : 0;// if reporter is not trusted, mark report as not verified
			$incident = $this->create_new_incident($data, $sms->message_date);

      //echo "incident";
			
			$incident_category = new Incident_Category_Model();
			$incident_category->incident_id = $incident->id;
			$incident_category->category_id = $data["category_id"];
			$incident_category->save();

      //echo "incident category";
		}
		
		
		// set incident relations
		if ( isset($incident) )
		{
			// Update Message with Incident ID
			$sms->incident_id = $incident->id;
			$sms->save();

      //echo "update incident";
			
			// set reporter incident relation
			$reporterIncident = new Reporters_Incidents_Model();
			$reporterIncident->reporter_id = $reporter->id;
			$reporterIncident->incident_id = $incident->id;
			$reporterIncident->save();

      //echo "reporters incidents";
			
			//@TODO:store incident type
			$incidentType = new Incidents_Types_Model();
			$reporterType = $this->get_reporter_type($reporter->id);
			$incidentType->incident_id = $incident->id;
			$incidentType->type_id = $reporterType->id;

      //echo "incidents types";
		}
		
		//TODO:How to handle multiple messages
	}
	
	private function create_new_incident($data, $messageDate)
	{
		$incident = new Incident_Model();
		$incident->incident_title = $data["title"];
		$incident->incident_description = $data["description"];
		$incident->location_id = $data["location_id"];
		$incident->incident_date = $messageDate;
		$incident->incident_dateadd = date("Y-m-d H:i:s",time());
		$incident->incident_active = $data["active"];
		$incident->incident_verified = $data["verified"];
		$incident->incident_mode = 2;//SMS Mode
		$incident->save();
		return $incident;
	}
	
	private function parse_contents($sms)
	{
		$result = array();
		
		// invalid message format
		if ( strpos($sms, '#') === false)
		{
			$result["invalid_message_content"] = $sms;
		}
		// valid message format
		else
		{
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
					case 'register':
						$reporter = ORM::factory("reporter_types")
						->where("type", $kvp[1])
						->find();
						$result["reporter_type_id"] = $reporter->id;
						break;
						
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
						
					case 'desc':
						$result["description"] = $kvp[1];
						break;
						
					default:
						break;
				}
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
			->where("category_title", 'Other')
			->find();
			
			$id = $cat->id;
			
		$allCategories = Category_Model::categories();
		
		foreach ($allCategories as $_cat)
		{
			//var_dump($_cat);
			//var_dump($_cat["category_title"] . "-" . strpos($_cat->category_title, $category));
			//var_dump(preg_match('/' . $category . '/', $_cat["category_title"] ));
			
			if ( preg_match('/' . $category . '/', $_cat["category_title"] ) === 1)
			{
				$id = $_cat["category_id"];
				//break;
			}
		}
/*
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
			$cat->category_description = $category;
			//$cat->parent_id = 0;
			//$cat->locale="en_us";
			//$cat->category_position=5;
			$cat->category_color = $this->create_color($exclude);
			$cat->category_visible = 1;
			$cat->category_trusted = 1;
			$cat->save();
		}*/
		//var_dump("ID:".$id);exit;
		return $id;
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
new smsparse;
?>