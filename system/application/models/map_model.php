<?php

class Map_Model extends Model {
	
	function Map_Model() {
		parent::Model();
		$this->map_items = array();
		$this->load->model('auth_model');
	}
	
	function get_fbplaces() {
		$url = "https://graph.facebook.com/search?type=checkin&access_token=".$this->auth_model->access('facebook');
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_SSL_VERIFYPEER, false);
		
		$checkins = $this->curl->execute();
		$this->checkins = json_decode($checkins);
	}
	
	function list_fbplaces() {
		if ($this->auth_model->access('facebook')) {
			$this->get_fbplaces();
			
			foreach($this->checkins->data as $checkin) {
				$id = $checkin->id;
				$source = "facebook";

				$person = $checkin->from->name;
				$user_id = $checkin->from->id;

				$place_name = $checkin->place->name;
				$place_id = "fb_".$checkin->place->id;

				$message = (isset($checkin->message)) ? $checkin->message : null;

				$cords = array($checkin->place->location->latitude, $checkin->place->location->longitude);

				$profile_pic = "http://graph.facebook.com/".$user_id."/picture";

				$time = strtotime($checkin->created_time);

				$this->list_items($id, $person, $source, $place_id, $place_name, $message, $profile_pic, $cords, $time);
			}
		}		
	}
	
	function get_foursquare($user, $pass) {
		$url = "http://api.foursquare.com/v1/checkins.json";
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_USERPWD,"$user:$pass");
		
		$checkins = $this->curl->execute($url);
		$this->checkins = json_decode($checkins);
	}
	
	function list_foursquare() {
		if ($access = $this->auth_model->access('foursquare')) {
			$this->get_foursquare($access[0], $access[1]);
			
			foreach($this->checkins->checkins as $checkin) {
				$id = $checkin->id;
				$source = "foursquare";

				$person = $checkin->user->firstname." ".$checkin->user->lastname;
				$user_id = $checkin->user->id;

				$place_name = $checkin->venue->name;
				$place_id = "fsq_".$checkin->venue->id;

				$message = (isset($checkin->shout)) ? $checkin->shout : null;

				$cords = array($checkin->venue->geolat, $checkin->venue->geolong);

				$profile_pic = $checkin->user->photo;

				$time = strtotime($checkin->created);

				if ($cords[0] != "") {
					$this->list_items($id, $person, $source, $place_id, $place_name, $message, $profile_pic, $cords, $time);
				}
			}
		}
	}
	
	function get_gowalla($user, $pass) {
		$url = "http://api.gowalla.com/users/{$user}/activity/friends";
		$api_key = "33a3476fe9a14a0082fbb5322c213e0e";
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_HTTPHEADER, array("X-Gowalla-API-Key: {$api_key}"));
		$this->curl->option(CURLOPT_USERPWD,"$user:$pass");
		
		$checkins = $this->curl->execute($url);
		$this->checkins = json_decode($checkins);
	}
	
	function list_gowalla() {
		if ($access = $this->auth_model->access('gowalla')) {
			$this->get_gowalla($access[0], $access[1]);
			
			foreach($this->checkins->activity as $checkin) {
				$id = str_replace('/checkins/', '', $checkin->url);
				$source = "gowalla";

				$person = $checkin->user->first_name." ".$checkin->user->last_name;
				$user_id = str_replace('/users/', '', $checkin->user->url);

				$place_name = $checkin->spot->name;
				$place_id = "gw_".str_replace('/spots/', '', $checkin->spot->url);

				$message = (isset($checkin->message)) ? $checkin->message : null;

				$cords = array($checkin->spot->lat, $checkin->spot->lng);

				$profile_pic = $checkin->user->image_url;

				$time = strtotime($checkin->created_at);

				$this->list_items($id, $person, $source, $place_id, $place_name, $message, $profile_pic, $cords, $time);
			}
		}		
	}
	
	function get_list() {
		$this->list_fbplaces();
		$this->list_foursquare();
		$this->list_gowalla();
		
		//$this->list_items(5242432, "Spencer Schoeben", "gowalla", null, "The Moon", null, null, array('32', '-122'), now());
		
		$this->sort_items();
	}
	
	function sort_items() {
		$this->map_items = array_sort($this->map_items, 'time_raw', SORT_DESC);
	}
	
	function list_items($id, $person, $source, $place_id, $place_name, $message = null, $img, $cords, $time) {		
		$map_item['id'] = $id;
		$map_item['person'] = $person;
		$map_item['source'] = $source;
		$map_item['place_id'] = $place_id;
		$map_item['place_name'] = $place_name;
		$map_item['message'] = $message;
		$map_item['img'] = $img;
		$map_item['cords'] = $cords;
		$map_item['time'] = timespan($time)." ago";;
		$map_item['time_raw'] = $time;
		
		$this->map_items[] = $map_item;
	}
	
}

?>