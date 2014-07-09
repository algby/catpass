<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Passwords extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
		$this->load->model('icons');
		$this->data = array();
		$this->groupId = 1;
		if(!$this->user->is_logged_in())
			redirect("home", "refresh");
	}
	public function index()
	{
		$encryptKey = $this->session->userdata("password");
		$icons = $this->icons->getAllIcons();
		if($this->session->flashdata("success"))
			$this->data["success"] = $this->session->flashdata("success");
		if($this->session->flashdata("error"))
			$this->data["error"] = $this->session->flashdata("error");
		$entries = $this->db->query("SELECT * FROM catpass_entries WHERE userId = ?", array($this->user->getUserId()));
		$entries_decoded = array();
		foreach($entries->result() as $row)
		{
			$entries_decoded[$row->id]["icon"] = $this->icons->getClassName($row->icon);
			$entries_decoded[$row->id]["iconId"] = $row->icon;
			$entries_decoded[$row->id]["groupId"] = $row->groupId;
			$entries_decoded[$row->id]["title"] = $this->encrypt->decode($row->title, $encryptKey);
			$entries_decoded[$row->id]["username"] = $this->encrypt->decode($row->username, $encryptKey);
			$entries_decoded[$row->id]["password"] = $this->encrypt->decode($row->password, $encryptKey);
			$entries_decoded[$row->id]["url"] = $this->encrypt->decode($row->url, $encryptKey);
			$entries_decoded[$row->id]["notes"] = $this->encrypt->decode($row->notes, $encryptKey);
		}
		$groupsQuery = $this->db->query("SELECT * FROM catpass_groups WHERE userId = ?", array($this->user->getUserId()));
		$groups = array();
		foreach($groupsQuery->result() as $row)
		{
			$groups[$row->id]["name"] = $row->name;
			$groups[$row->id]["icon"] = $this->icons->getClassName($row->icon);
			$groups[$row->id]["iconId"] = $row->icon;
		}
		$this->data["groups"] = $groups;
		$this->data["entries"] = $entries_decoded;
		$this->data["icons"] = $icons;
		$this->load->template('passwords', $this->data);
	}
	public function newEntry()
	{
		$encryptKey = $this->session->userdata("password");
		$title = $this->input->post("title", TRUE);
		$username = $this->input->post("username", TRUE);
		$password = $this->input->post("password", TRUE);
		$password2 = $this->input->post("password2", TRUE);
		$url = $this->input->post("url", TRUE);
		$notes = $this->input->post("notes", TRUE);
		$icon = $this->input->post("iconNew", TRUE);
		$groupId = $this->input->post("groupId", TRUE);
		if(!$title || !$password || !$password2 || !$groupId || $groupId == 0)
		{
			$this->session->set_flashdata("error", "Un ou plusieurs champs n'ont pas été remplis.");
			redirect("passwords", "refresh");
		}
		if($password !== $password2)
		{
			$this->session->set_flashdata("error", "Les deux mots de passes ne correspondent pas.");
			redirect("passwords", "refresh");
		}
		$encoded_title = $this->encrypt->encode($title, $encryptKey);
		$encoded_username = $this->encrypt->encode($username, $encryptKey);
		$encoded_password = $this->encrypt->encode($password, $encryptKey);
		$encoded_url = $this->encrypt->encode($url, $encryptKey);
		$encoded_notes = $this->encrypt->encode($notes, $encryptKey);
		
		$this->db->query("INSERT INTO catpass_entries (userId, groupId, icon, title, username, password, url, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($this->user->getUserId(), $groupId, $icon, $encoded_title, $encoded_username, $encoded_password, $encoded_url, $encoded_notes));
		$this->session->set_flashdata("success", "Entrée ajoutée !");
		redirect("passwords", "refresh");
	}
	public function deleteEntry($id)
	{
		if(!$id)
		{
			$this->session->set_flashdata("error", "Pas de ligne à supprimer");
			redirect("passwords", "refresh");
		}
		$userId = $this->user->getUserId();
		$this->db->query("DELETE FROM catpass_entries WHERE id = ? AND userId = ?", array($id, $userId));
		$this->session->set_flashdata("success", "Entrée supprimée");
		redirect("passwords", "refresh");
	}
	public function editEntry()
	{
		$id = $this->input->post("entryId", TRUE);
		$title = $this->input->post("title", TRUE);
		$username = $this->input->post("username", TRUE);
		$password = $this->input->post("password", TRUE);
		$password2 = $this->input->post("password2", TRUE);
		$url = $this->input->post("url", TRUE);
		$notes = $this->input->post("notes", TRUE);
		$icon = $this->input->post("iconEdit", TRUE);
		if(!$id)
		{
			$this->session->set_flashdata("error", "Erreur: rien à modifier.");
			redirect("passwords", "refresh");
		}
		if(!$title || !$password || !$password2)
		{
			$this->session->set_flashdata("error", "Un ou plusieurs champs n'ont pas été remplis.");
			redirect("passwords", "refresh");
		}
		if($password !== $password2)
		{
			$this->session->set_flashdata("error", "Les deux mots de passes ne correspondent pas.");
			redirect("passwords", "refresh");
		}
		
		$encryptKey = $this->session->userdata("password");
		$encoded_title = $this->encrypt->encode($title, $encryptKey);
		$encoded_username = $this->encrypt->encode($username, $encryptKey);
		$encoded_password = $this->encrypt->encode($password, $encryptKey);
		$encoded_url = $this->encrypt->encode($url, $encryptKey);
		$encoded_notes = $this->encrypt->encode($notes, $encryptKey);
		$this->db->query("UPDATE catpass_entries SET title = ?, username = ?, password = ?, url = ?, notes = ?, icon = ? WHERE userId = ? AND id = ?", array($encoded_title, $encoded_username, $encoded_password, $encoded_url, $encoded_notes, $icon, $this->user->getUserId(), $id));
		$this->session->set_flashdata("success", "Entrée modifiée");
		redirect("passwords", "refresh");
	}
	public function editGroup()
	{
		$id = $this->input->post("groupId", TRUE);
		$name = $this->input->post("name", TRUE);
		$icon = $this->input->post("iconEditGroup", TRUE);
		if(!$id || $id == 0)
		{
			$this->session->set_flashdata("error", "Erreur: rien à modifier.");
			redirect("passwords", "refresh");
		}
		if(!$name)
		{
			$this->session->set_flashdata("error", "Erreur: Rentrez un nom pour ce groupe.");
			redirect("passwords", "refresh");
		}
		$this->db->query("UPDATE catpass_groups SET name = ?, icon = ? WHERE id = ? AND userId = ?", array($name, $icon, $id, $this->user->getUserId()));
		$this->session->set_flashdata("success", "Groupe modifié");
		redirect("passwords", "refresh");
	}
	public function newGroup()
	{
		$name = $this->input->post("name", TRUE);
		$icon = $this->input->post("iconGroup", TRUE);
		if(!$name)
		{
			$this->session->set_flashdata("error", "Erreur: Rentrez un nom pour ce groupe.");
			redirect("passwords", "refresh");
		}
		$this->db->query("INSERT INTO catpass_groups (userId, name, icon) VALUES (?, ?, ?)", array($this->user->getUserId(), $name, $icon));
		$this->session->set_flashdata("success", "Groupe créé");
		redirect("passwords", "refresh");
	}
	public function deleteGroup($id)
	{
		if(!$id || $id == 0)
		{
			$this->session->set_flashdata("error", "Erreur: rien à supprimer.");
			redirect("passwords", "refresh");
		}
		$this->db->query("DELETE FROM catpass_groups WHERE id = ? AND userId = ?", array($id, $this->user->getUserId()));
		$this->session->set_flashdata("success", "Groupe supprimé");
		redirect("passwords", "refresh");
	}
	public function upload_keepass()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
		$config['max_size']	= '1024';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
			$this->session->set_flashdata("error", $this->upload->display_errors());
			redirect("passwords", "refresh");
		}
		else
		{
			$file_data = $this->upload->data();
			$full_path = $file_data["full_path"];
			$xml = file_get_contents($full_path);
			try{
				$keepassXML = @new SimpleXMLElement($xml);
				$groups = $keepassXML->Root[0]->Group[0];
				foreach($groups->Group as $group)
				{
					$name = "KP_".$group->Name[0];
					$this->db->query("INSERT INTO catpass_groups (userId, name, icon) VALUES (?, ?, ?)", array($this->user->getUserId(), $name, 0));
					$groupId = $this->db->insert_id();
					$entries = $group->Entry;
					foreach($entries as $entry)
					{
						$strings = $entry->{'String'};
						$title = "";
						$username = "";
						$password = "";
						$url = "";
						$notes = "";
						foreach($strings as $string)
						{
							if($string->Key[0] == "Title")
								$title = $string->Value[0];
							if($string->Key[0] == "Notes")
								$notes = $string->Value[0];
							if($string->Key[0] == "UserName")
								$username = $string->Value[0];
							if($string->Key[0] == "URL")
								$url = $string->Value[0];
							if($string->Key[0] == "Password")
								$password = $string->Value[0];
						}
						//echo "Title: $title, Username: $username, Password: $password, URL: $url, Notes: $notes<br>";
						$encryptKey = $this->session->userdata("password");
						$encoded_title = $this->encrypt->encode($title, $encryptKey);
						$encoded_username = $this->encrypt->encode($username, $encryptKey);
						$encoded_password = $this->encrypt->encode($password, $encryptKey);
						$encoded_url = $this->encrypt->encode($url, $encryptKey);
						$encoded_notes = $this->encrypt->encode($notes, $encryptKey);
						$this->db->query("INSERT INTO catpass_entries (userId, groupId, icon, title, username, password, url, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($this->user->getUserId(), $groupId, 0, $encoded_title, $encoded_username, $encoded_password, $encoded_url, $encoded_notes));
					}
				}
				$this->session->set_flashdata("success", "Fichier KeePass importé !");
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata("error", "Ce n'est pas un fichier KeePass !");
			}
			unlink($full_path);
			redirect("passwords", "refresh");
		}
	}
	
}