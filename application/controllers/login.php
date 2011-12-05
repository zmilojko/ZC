<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	{
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";
    
    if($username == 'm' && $password == 'gp')
    {
        
      $this->session->set_userdata('user', 'OK');
      if(isset($_POST['language']))
      {
        $this->session->set_userdata('language', $_POST['language']);
      }
      else
      {
        $this->session->set_userdata('language', DEFAULT_LANGUAGE_INDEX);
      }
      echo "OK";      
    }
    else
    {
      $this->session->unset_userdata('user', 'OK');
      echo "Error!";
    }    
  }
  
  public function test()
  {
    $this->load->helper('form');
    $this->load->view('login_test');
  }  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */