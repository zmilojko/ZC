<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


  function validate_password_zen_way($password, $zen_md5) {
      $split = explode(':', $zen_md5);
      return (sizeof($split) == 2 && (md5($split[1] . $password) == $split[0]));
  }