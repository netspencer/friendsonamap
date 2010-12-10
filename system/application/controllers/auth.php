<?php

class Auth extends Controller {
	
	function Auth() {
		parent::Controller();
		$this->load->library('session');
		$this->load->library('curl');
		$this->load->library('encrypt');
		$this->load->helper('url');
		$this->load->model('auth_model');
	}
		
	function login($service, $redirect="redirect") {
		$this->session->set_flashdata('state_change', TRUE);
		switch($service) {
			case "facebook":
				$this->auth_model->auth_facebook($redirect);
				break;
			case "foursquare":
				$user = $this->input->get_post('user');
				$pass = $this->input->get_post('password');
				$this->auth_model->auth_service("foursquare", $user, $pass);
				if ($redirect == "manage") redirect('/manage');
				elseif ($redirect != "no-redirect") redirect('/');
				break;
			case "gowalla":
				$user = $this->input->get_post('user');
				$pass = $this->input->get_post('password');
				$this->auth_model->auth_service("gowalla", $user, $pass);
				if ($redirect == "manage") redirect('/manage');
				elseif ($redirect != "no-redirect") redirect('/');
				break;
		}
	}
		
	function logout($service, $redirect="redirect") {
		$this->session->set_flashdata('state_change', TRUE);
				
		switch($service) {
			case "facebook":
				$this->auth_model->logout_service('facebook');
				break;
			case "foursquare":
				$this->auth_model->logout_service('foursquare');
				break;
			case "gowalla":
				$this->auth_model->logout_service('gowalla');
				break;
			default:
				$this->session->set_flashdata('state_change', FALSE);
				$this->auth_model->unset_name();
				$this->auth_model->logout_service(array('foursquare', 'gowalla', 'facebook'));
				break;
		}
		
		if ($redirect == "manage") redirect('/manage');
		elseif ($redirect != "no-redirect") redirect('/');
	}
	
	function like($id) {
		$this->auth_model->like($id);
	}
	
	function comment($id) {
		$this->auth_model->comment($id);
	}
	
}

?>