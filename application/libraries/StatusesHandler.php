<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class StatusesHandler {
    function __construct($db_item = null) {
       if(!$db_item) {
        return;
       }    
       $this->status_id = $db_item->orders_status_id;
       $this->status_name = $db_item->orders_status_name;
    }
    
    public static function GetAllStatuses() {
      $ci =& get_instance();
      if(!$ci->session->userdata('user'))
      {
        die("Must login first");
        return;
      }
    
      $language_id = $ci->session->userdata('language');
    
      if(!$language_id)
      {
        $language_id = DEFAULT_LANGUAGE_INDEX;
      }
    
      $query = $ci->db->select('*')
                                ->from('orders_status')
                                ->where('language_id',$language_id)
                                ->get()->result();
      $statuses = array();     
       
      foreach($query as $row)
      {
        $statuses[] = new StatusesHandler($row);
      }
      echo json_encode($statuses);    
    }
}

/* End of file Statuses.php */