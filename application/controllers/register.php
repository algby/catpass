<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data = array();
	}
	public function index()
	{
		if($this->session->flashdata("success"))
			$this->data["success"] = $this->session->flashdata("success");
		if($this->session->flashdata("error"))
			$this->data["error"] = $this->session->flashdata("error");
		$this->load->template('register', $this->data);
	}
}