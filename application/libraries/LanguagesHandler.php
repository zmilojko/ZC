<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class LanguagesHandler {
    function __construct($db_item = null) {
       if(!$db_item) {
        return;
       }       
       $this->language_id = $db_item->languages_id;
       $this->language_name = $db_item->name;
    }
    public static function GetAllLanguages() {
      $ci =& get_instance();
      $query = $ci->db->select('*')
                        ->from('languages')
                        ->get()->result();
      $lang_array = array();     
       
      foreach($query as $row)
      {
        $lang_array[] = new LanguagesHandler($row);
      }
                     
      echo json_encode($lang_array);      
    }
}

/* End of file Languages.php */