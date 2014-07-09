<?php
class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
	{
		$CI =& get_instance();
		$email = $CI->session->userdata("email");
		$vars["email"] = $email;
        $content  = $this->view('header', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('footer', $vars, $return);

        if ($return)
        {
            return $content;
        }
    }
}
?>