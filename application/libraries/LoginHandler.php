<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LoginHandler {
  public static function DoLogin() {
    $username = isset($_POST['username'])?$_POST['username']:"";
    $password = isset($_POST['password'])?$_POST['password']:"";
    
    $ci =& get_instance();
    
    
    
    if(USERNAME) {    
      //Check against defined constants USERNAME and PASSWORD
     
      $authenticated = false;
     
      //Calculate MD5 of the password provided, if needed
      if(PASSWORD_TYPE == 'MD5') {
        $authenticated = (PASSWORD == md5($password));
      } else if(PASSWORD_TYPE == 'ZENCART') {
        $this->load->helper('zen_passwords');
        $authenticated = zen_validate_password($password, PASSWORD);
      } else if(PASSWORD_TYPE == 'CLEAR_TEXT') { 
        $authenticated = (PASSWORD == $password);
      }
      
      if($username == USERNAME && $authenticated)
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
        
        if(ENABLE_TEST_PAGES && PASSWORD_TYPE == 'MD5') {
          echo "You provided password with MD5: " . md5($password);
        }
      } 
    } else {
      die('checking passwords from the database is not implemented yet');
      $this->load->helper('zen_passwords');
      //Check against admin tables
    }
  }  
}

/* End of file Login.php */