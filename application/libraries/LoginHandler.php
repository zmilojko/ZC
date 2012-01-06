<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * ZOM Connector
 *
 * An open source application for webshops based on PHP.
 * Based on the CodeIgniter framework. Visit http://codeigniter.com for more info.
 *
 * @package		ZOM Connector
 * @author		Z-Ware Ltd.
 * @copyright	Copyright (c) 2011, Z-Ware Ltd.
 * @license		http://zom.z-ware.fi/license
 * @link		http://zom.z-ware.fi
 * @since		Version 0.0.1
 * @filesource
 *  
 * Copyright (C) 2011 Z-Ware Ltd.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * This Software is based on the CodeIgniter framework (codeigniter.com).
 * Any use/change/distribution of the Software must comply with the Code Igniter 
 * license (http://codeigniter.com/user_guide/license.html).
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
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
        $authenticated = validate_password_zen_way($password, PASSWORD);
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
      //Check against admin tables
    }
  }  
}

/* End of file Login.php */