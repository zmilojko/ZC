<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status {
    function __construct($db_item) {
       $this->status_id = $db_item->orders_status_id;
       $this->status_name = $db_item->orders_status_name;
    }
}

class Statuses extends CI_Controller {
	public function get()
	{
    if(!$this->session->userdata('user'))
    {
      die("Must login first");
      return;
    }
  
    $language_id = $this->session->userdata('language');
  
    if(!$language_id)
    {
      $language_id = DEFAULT_LANGUAGE_INDEX;
    }
  
		$query = $this->db->select('*')
                              ->from('orders_status')
                              ->where('language_id',$language_id)
                              ->get()->result();
    $statuses = array();     
     
    foreach($query as $row)
    {
      $statuses[] = new Status($row);
    }
    echo json_encode($statuses);
  }
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */