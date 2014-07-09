<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keepass extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->load->model('user');
		if(!$this->user->is_logged_in())
			redirect("home", "refresh");
	}
	public function index()
	{
		$this->load->helper('form');
		if($this->session->flashdata("success"))
			$this->data["success"] = $this->session->flashdata("success");
		if($this->session->flashdata("error"))
			$this->data["error"] = $this->session->flashdata("error");
		$this->load->template('keepass', $this->data);
	}
}