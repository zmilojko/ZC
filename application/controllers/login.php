<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
    $this->load->library('LoginHandler');
    LoginHandler::DoLogin();
  }
  
  public function test()
  {
    $this->load->helper('form');
    $this->load->view('login_test');
  }  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */