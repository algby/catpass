<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secure extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->data = array();
	}
	public function index()
	{
		$this->load->template('secure', $this->data);
	}
}