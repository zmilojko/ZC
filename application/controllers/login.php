<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['username'])?$_POST['username']:"";
    $language = isset($_POST['username'])?$_POST['username']:"";

    echo "OK, you have now logged in.";    
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */