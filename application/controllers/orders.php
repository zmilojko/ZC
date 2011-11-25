<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order {
    function __construct($db_order) {
       $this->id = $db_order->orders_id;
       $this->customer = new stdClass();
       $this->customer->id = $db_order->customers_id;
       $this->customer->name = $db_order->customers_name;
       $this->customer->address = $db_order->customers_street_address . ', ' . $db_order->customers_postcode . ' ' . $db_order->customers_city;
       $this->customer->telephone = $db_order->customers_telephone;
       $this->customer->email = $db_order->customers_email_address;
       $this->delivery = new stdClass();
       $this->delivery->name = $db_order->delivery_name;
       $this->delivery->address = $db_order->delivery_street_address . ', ' . $db_order->delivery_postcode . ' ' . $db_order->delivery_city;
       $this->delivery->method = $db_order->shipping_method;       
       $this->billing = new stdClass();
       $this->billing->name = $db_order->billing_name;
       $this->billing->address = $db_order->billing_street_address . ', ' . $db_order->billing_postcode . ' ' . $db_order->billing_city;
       $this->billing->method = $db_order->payment_method;
       
       $this->latest_update_time = $db_order->last_modified;
       $this->order_creation_time = $db_order->date_purchased;
       $this->status = $db_order->orders_status;

       $this->total = $db_order->order_total;
       $this->tax = $db_order->order_tax;
       
       //now should get:
       //items
       //history
    }
}

class Orders extends CI_Controller {

  private function get_order_index_array($last_known_timestamp, $status_filter, $index_list)
  {
      $query_build = $this->db->select('orders.orders_id')
                              ->from('orders')
                              ->join('orders_status_history', 'orders.orders_id = orders_status_history.orders_id');

      if($last_known_timestamp)
      {
        $query_build = $query_build->where('orders_status_history.date_added > ', $last_known_timestamp);
      }
      if($status_filter)
      {
        $query_build = $query_build->where('orders.orders_status', $status_filter);
      }
      if($index_list)
      {
        $query_build = $query_build->where('orders.orders_id in ('. $index_list.')');
      }

      $res = $query_build->get()->result();
      
      $orders = array();     
     
      foreach($res as $row)
      {
        $orders[] = $row->orders_id;
      }
      echo json_encode($orders);
  }

	public function get()
	{
    print_r($_POST);echo '<br/><br/><br/>';
  
    $language_id = $this->session->userdata('language');
    if(!$language_id)
    {
      $language_id = DEFAULT_LANGUAGE_INDEX;
    }

    $last_known_timestamp = isset($_POST['time_from'])?$_POST['time_from']:FALSE;
    $status_filter = isset($_POST['status'])?$_POST['status']:FALSE;
    $index_list = isset($_POST['index_list'])?$_POST['index_list']:FALSE;
    $indexes_only = isset($_POST['indexes_only'])?$_POST['indexes_only']:FALSE;

    if(is_array($index_list))
    {
      //change this to the comma separated string
      $index_list = implode(",", $index_list);
    }
    
    if($indexes_only)
    {
      $this->get_order_index_array($last_known_timestamp, $status_filter, $index_list);
      return;
    }
    
    $query_text = "select * from orders where true ";
    
    if($last_known_timestamp)
    {
      $query_text .= " and orders_id in (select distinct orders_id
                                                   from orders_status_history
                                                   where date_added > '".$last_known_timestamp."'
                                                   order by date_added desc) ";
    }     
    if($index_list)
    {
      $query_text .= " and orders_id in (".$index_list.") ";
    }                                                    
    if($status_filter)
    {
      $query_text .= " and orders_status = ".$status_filter." ";
    }                                                    
        
    $query_text .= "order by date_purchased desc limit 600;";
    
    
    $query = $this->db->query($query_text)->result();

    print_r($query[0]);echo '<br/><br/><br/>';
    echo $this->db->last_query() . '<br/><br/><br/>';                             
    $orders = array();     
     
    foreach($query as $row)
    {
      $orders[] = new Order($row);
      //$orders[$row->orders_id] = new Order($row);
    }
    echo json_encode($orders);
  }
  
  public function test()
  {
    $this->load->helper('form');
    $this->load->view('order_test');
  }
}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */