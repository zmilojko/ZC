<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


  function zen_validate_password($plain, $encrypted) {
    if (zen_not_null($plain) && zen_not_null($encrypted)) {
// split apart the hash / salt
      $stack = explode(':', $encrypted);

      if (sizeof($stack) != 2) return false;

      if (md5($stack[1] . $plain) == $stack[0]) {
        return true;
      }
    }

    return false;
  }