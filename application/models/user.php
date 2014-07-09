<?php
class User extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	/**
		Login function
		Return codes:
			0: No email or password entered
			1: Email or password invalid
			2: Login OK
			3: Already logged in
	*/
	function login($email, $password)
	{
		$sessionEmail = $this->session->userdata('email');
		if($sessionEmail)
		{
			return 3;
		}
		if((!$email || !$password) && !$sessionEmail)
		{
			return 0;
		}
		$query = $this->db->query("SELECT password FROM catpass_users WHERE email = ?", array($email));
		if($query->num_rows() == 1 && password_verify($password, $query->row()->password))
		{
			return 2;
		}
		else
		{
			return 1;
		}
	}
	/**
		Registers the user.
		Return codes:
			0: user is already logged in, can't register
			1: passwords doesn't match
			2: email already used
			3: registration ok
			4: tos not checked
	*/
	function register($email, $password, $password2)
	{
		$sessionEmail = $this->session->userdata("email");
		$checked = $this->input->post("t_and_c");
		//$captcha = $this->input->post("captcha");
		
		if(!$sessionEmail)
		{
			// not already logged in
			if($checked)
			{
				if($password === $password2)
				{
					// same password
					if($this->db->query("SELECT * FROM catpass_users WHERE email = ?", array($email))->num_rows() == 0)
					{
						// no existing email, register this user
						$hashed_password = password_hash($password, PASSWORD_BCRYPT);
						//die($hashed_password);
						$this->db->query("INSERT INTO catpass_users (email, password) VALUES (?, ?)", array($email, $hashed_password));
						return 3;
					}
					else
					{
						return 2;
					}
				}
				else
				{
					return 1;
				}
			}
			else
			{
				return 4;
			}
		}
		else
		{
			return 0;
		}
	}
	/*
		Returns userId or 0 if user isn't logged in
	*/
	function getUserId()
	{
		$email = $this->session->userdata("email");
		if(!$email) return 0;
		return $this->db->query("SELECT id FROM catpass_users WHERE email = ?", array($email))->row()->id;
	}
	/*
		New entry for user
		Return codes:
			0: user not logged in?!
			1: ok
			2: groupid doesn't exist
	*/
	function new_entry($username, $password, $url, $notes, $groupid, $icon = 0)
	{
		$email = $this->session->userdata("email");
		$masterpassword = $this->session->userdata("password");
		if(!$email || !$password)
		{
			return 0;
		}
		if($this->db->query("SELECT * FROM catpass_groups WHERE groupId = ? AND userId = (SELECT id FROM catpass_users WHERE email = ?)")->num_rows() != 0)
		{
			$encryptedUsername = $this->encrypt->encode($username, $masterpassword);
			$encryptedPassword = $this->encrypt->encode($password, $masterpassword);
			$encryptedUrl = $this->encrypt->encode($url, $masterpassword);
			$encryptedNotes = $this->encrypt->encode($notes, $masterpassword);
			$this->db->query("INSERT INTO catpass_entries (userId, groupId, icon, username, password, url, notes) VALUES (?, ?, ?, ?, ?, ?, ?)", array($this->getUserId(), $groupid, $icon, $encryptedUsername, $encryptedPassword, $encryptedUrl, $encryptedNotes));
			return 1;
		}
		else
		{
			// groupid doesn't exist
			return 2;
		}
	}
	/*
		New group for user
		Return codes:
			0: not logged in ?!
			1: ok
	*/
	function new_group($name, $icon)
	{
		$email = $this->session->userdata("email");
		if(!$email) return 0;
		$this->db->query("INSERT INTO catpass_groups (userId, name, icon) VALUES (?, ?, ?)", array(getUserId(), $name, $icon));
		return 1;
	}
	/*
		Returns true if user is logged in
	*/
	function is_logged_in()
	{
		return ($this->session->userdata("email") && $this->session->userdata("password")) !== false;
	}
}
?>