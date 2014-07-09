<?php
class Icons extends CI_Model {

    function __construct()
    {
        parent::__construct();
		$this->icons = array();
		$this->icons[1] = "glyphicon glyphicon-globe";
		$this->icons[2] = "fa fa-bolt";
		$this->icons[3] = "fa fa-certificate";
		$this->icons[4] = "fa fa-cloud";
		$this->icons[5] = "fa fa-cog";
		$this->icons[6] = "fa fa-comments";
		$this->icons[7] = "fa fa-desktop";
		$this->icons[8] = "fa fa-database";
		$this->icons[9] = "fa fa-dropbox";
		$this->icons[10] = "fa fa-facebook-square";
		$this->icons[11] = "fa fa-film";
		$this->icons[12] = "fa fa-gamepad";
		$this->icons[13] = "fa fa-glass";
		$this->icons[14] = "fa fa-group";
		$this->icons[15] = "fa fa-joomla";
		$this->icons[16] = "fa fa-leaf";
		$this->icons[17] = "fa fa-linux";
		$this->icons[18] = "fa fa-linkedin-square";
		$this->icons[19] = "fa fa-money";
		$this->icons[20] = "fa fa-reddit";
		$this->icons[21] = "fa fa-skype";
    }
	function getClassName($id)
	{
		if(array_key_exists($id, $this->icons))
			return $this->icons[$id];
		return "";
	}
	function getAllIcons()
	{
		return $this->icons;
	}
}
?>