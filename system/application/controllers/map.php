<?php

class Map extends Controller {
	
	function Map()	{
		parent::Controller();
		$this->load->library('curl');
		$this->load->library('session');
		$this->load->library('carabiner'); 
		$this->load->helper('date');
		$this->load->helper('url');
		$this->load->library('encrypt');
		$this->load->model('map_model');
		$this->load->model('auth_model');
	}
					
	function index($view = null) {		
		$this->map_model->get_list();
		
		$this->carabiner->js('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
				
		$data['checkins'] = $this->map_model->map_items;
		$data['user'] = $this->session->userdata('name');
		$data['is_loggedin'] = $this->auth_model->is_loggedin(array('foursquare', 'gowalla', 'facebook'));
		
		if ($view == "manage") {
			$this->carabiner->css('login.css');
			$this->carabiner->js('login.js');
			$this->load->view('manage_view', $data);
		} elseif (empty($data['checkins'])) {
			$this->carabiner->css('login.css');
			$this->carabiner->js('login.js');
			$this->load->view('login_view', $data);
		} else {
			
			$this->carabiner->js('scrollbars.js');
			$this->carabiner->js('resize.js');
			$this->carabiner->js('main.js');
			
			$this->carabiner->css('main.css');
			$this->carabiner->css('profile.css');
			$this->carabiner->css('scrollbars.css');
						
			if ($view == "stream") {
				$this->load->view('stream_view', $data);
			} else {
				$this->load->view('map_view', $data);
			}
		}
		
	}
	
}

?>