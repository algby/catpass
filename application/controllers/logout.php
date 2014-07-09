<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->session->unset_userdata("email");
		$this->session->unset_userdata("password");
		$this->session->set_flashdata("success", "Vous vous êtes bien déconnecté.");
		redirect("home", "refresh");
	}
}