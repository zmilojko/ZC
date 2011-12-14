<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LoginHandler {
  public static function DoLogin() {
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";
    
    $ci =& get_instance();
    
    if($username == 'm' && $password == 'gp')
    {
        
      $ci->session->set_userdata('user', 'OK');
      if(isset($_POST['language']))
      {
        $ci->session->set_userdata('language', $_POST['language']);
      }
      else
      {
        $ci->session->set_userdata('language', DEFAULT_LANGUAGE_INDEX);
      }
      echo "OK";      
    }
    else
    {
      $ci->session->unset_userdata('user', 'OK');
      echo "Error!";
    }    
  }  
}

/* End of file Login.php */