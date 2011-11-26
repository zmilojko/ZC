<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang {
    function __construct($db_item) {
       $this->language_id = $db_item->languages_id;
       $this->language_name = $db_item->name;
    }
}

class Languages extends CI_Controller {
	public function get()
	{
    if(!$this->session->userdata('user'))
    {
      die("Must login first");
      return;
    }  
    $query = $this->db->select('*')
                      ->from('languages')
                      ->get()->result();
    $lang_array = array();     
     
    foreach($query as $row)
    {
      $lang_array[] = new Lang($row);
    }
                   
    echo json_encode($lang_array);
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */