<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
		$this->data = array();
	}
	public function index()
	{
		$this->login();
	}
	public function login()
	{
		$sessionEmail = $this->session->userdata('email');
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		
		$login_return = $this->user->login($email, $password);
		switch($login_return)
		{
			case 0: // 0: No email or password entered
				// don't do anything
			break;
			case 1: // 1: Email or password invalid
				$this->session->set_flashdata("error", "Votre email ou mot de passe est invalide.");
			break;
			case 2: // 2: Login OK
				$this->session->set_userdata("email", $email);
				$this->session->set_userdata("password", $password);
				redirect("passwords", "refresh");
			break;
			case 3: // 3: Already logged in
				// don't do anything
			break;
			default: // wtf happened
				$this->session->set_flashdata("error", "Une erreur est survenue. Merci de nous contacter.");
			break;
		}
		redirect("home", "refresh");
	}
	public function register()
	{
		$sessionEmail = $this->session->userdata("email");
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		$password2 = $this->input->post("password2");
		
		$register_return = $this->user->register($email, $password, $password2);
		
		switch($register_return)
		{
			case 0: // 0: user is already logged in, can't register
				$this->session->set_flashdata("error", "Vous êtes déjà connecté, vous ne pouvez pas vous inscrire.");
			break;
			case 1: // 1: passwords doesn't match
				$this->session->set_flashdata("error", "Les mots de passe ne correspondent pas.");
			break;
			case 2: // 2: email already used
				$this->session->set_flashdata("error", "Email déjà utilisée");
			break;
			case 3: // 3: registration ok
				$this->session->set_userdata("email", $email);
				$this->session->set_userdata("password", $password);
				redirect("passwords", "refresh");
			break;
			case 4: // 4: checkbox not checked
				$this->session->set_flashdata("error", "Vous devez accepter les termes et conditions pour vous enregistrer");
				//redirect("passwords", "refresh");
			break;
			default: // wtf happened
				$this->session->set_flashdata("error", "Une erreur est survenue. Merci de nous contacter.");
			break;
		}
		redirect("register", "refresh");
	}
}