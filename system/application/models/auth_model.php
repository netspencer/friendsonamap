<?php

class Auth_Model extends Model {
	
	function Auth_Model() {
		parent::Model();
		$this->config->load('oauth');
		$this->fb_client_id = $this->config->item('facebook_app_id');
		$this->fb_client_secret = $this->config->item('facebook_secret_key');
		
		$this->foursquare_key = $this->config->item('foursquare_key');
		$this->foursquare_secret = $this->config->item('foursquare_secret');
		
		$this->gowalla_key = $this->config->item('gowalla_key');
		$this->gowalla_secret = $this->config->item('gowalla_secret');
	}
	
	function access($service) {
		if ($service == "facebook") {
			return $this->session->userdata("{$service}_auth");
		} else {
			return $this->get_auth_service($service);
		}
	}
	
	function is_loggedin($service) {
		if (is_array($service)) {
			foreach($service as $item) {
				if ($this->session->userdata("{$item}_auth")) {
					$return[$item][0] = true;
					$return[$item][1] = $this->session->userdata("{$item}_auth_as");
				} else {
					$return[$item][0] = false;
				}
			}
			return $return;
		} else {
			if ($this->session->userdata("{$service}_auth")) {
			 	return array(true, $this->session->userdata("{$service}_auth_as"));
			} else {
				return array(false);
			}
		}		
	}
	
	function set_name($name) {
		$this->session->set_userdata('name', $name);
	}
	
	function unset_name() {
		$this->session->unset_userdata('name');
	}
	
	function auth_facebook($redirect = "redirect") {
		if ($redirect == "manage") $query['redirect_uri'] = base_url()."auth/login/facebook/manage";
		elseif ($redirect != "no-redirect") $query['redirect_uri'] = base_url()."auth/login/facebook";
				
		if (empty($_GET['code'])) {
			$query['client_id'] = $this->fb_client_id;
			//$query['redirect_uri'] = base_url()."auth/login/facebook";
			$query['scope'] = "user_checkins,friends_checkins,publish_stream";
			$url = "https://graph.facebook.com/oauth/authorize?".http_build_query($query);
			
			
			header('Location: '.$url);
		} else {
			$query['client_id'] = $this->fb_client_id;
			//$query['redirect_uri'] = base_url()."auth/login/facebook";
			$query['client_secret'] = $this->fb_client_secret;
			$query['code'] = $_GET['code'];
			$url = "https://graph.facebook.com/oauth/access_token?".http_build_query($query);
												
			$token = file_get_contents($url);
									
			$token = str_replace('access_token=', '', $token);
															
			$this->session->set_userdata('facebook_auth', $token);
			
			$url = "https://graph.facebook.com/me?access_token=".$token;
			
			$this->curl->create($url);

			$this->curl->option(CURLOPT_SSL_VERIFYPEER, false);

			$me = $this->curl->execute();
						
			$me = json_decode($me);
			
			$this->session->set_userdata('facebook_auth_as', $me->name);
						
			$this->set_name($me->name);	
			
			if ($redirect == "manage") redirect('/manage');
			elseif ($redirect != "no-redirect") redirect('/');
		}
	}
		
	function auth_service($service, $user, $pass) {
		$user = $this->encrypt->encode($user);
		$pass = $this->encrypt->encode($pass);
		
		$access = array($user, $pass);
		$this->session->set_userdata("{$service}_auth", $access);
		
	}
	
	function get_auth_service($service) {
		$encoded = $this->session->userdata("{$service}_auth");
		
		foreach($encoded as $item) {
			$access[] = $this->encrypt->decode($item);
		}
		
		return $access;
	}
	
	function logout_service($service) {
		if (is_array($service)) {
			foreach($service as $item) {
				$this->session->unset_userdata("{$item}_auth");
			}
		} else {
			$this->session->unset_userdata("{$service}_auth");
		}
	}
	
	function verify_gowalla($user, $pass) {
		$url = "http://api.gowalla.com/users/me.json";
		$api_key = "33a3476fe9a14a0082fbb5322c213e0e";
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_HTTPHEADER, array("X-Gowalla-API-Key: {$api_key}"));
		$this->curl->option(CURLOPT_USERPWD,"$user:$pass");
		
		$user = $this->curl->execute($url);
		$user = json_decode($user);
		
		$name = $user->first_name." ".$user->last_name;
		
		$this->session->set_userdata("gowalla_auth_as", $name);

		if ($this->curl->error_code == 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function like($id) {
		$url = "https://graph.facebook.com/".$id."/likes";
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_SSL_VERIFYPEER, false);
		
		$this->curl->post(array('access_token' => $this->access));
				
		$like = $this->curl->execute();
		
		print_r($like);
	}
	
	function comment($id) {
		$url = "https://graph.facebook.com/".$id."/comments";
		
		$this->curl->create($url);
		
		$this->curl->option(CURLOPT_SSL_VERIFYPEER, false);
		
		$this->curl->post(array('access_token' => $this->access, 'message' => $_POST['message']));
		
		if ($_POST['message']) {
			$comment = $this->curl->execute();
		}
		
		print_r($comment);
	}
}

?>