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


class Order extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_full_orders() {
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

        $orders = array();     

        foreach($query as $row)
        {
          $orders[] = $this->CreateOrderObject($row);
        }
        echo json_encode($orders);
 
    }    
    
    private function CreateOrderObject($db_order = null) {
        if(!$db_order) {
          return;
        }   
        $obj = new stdClass();

        $obj->id = $db_order->orders_id;
        $obj->customer = new stdClass();
        $obj->customer->id = $db_order->customers_id;
        $obj->customer->name = $db_order->customers_name;
        $obj->customer->address = $db_order->customers_street_address . ', ' . $db_order->customers_postcode . ' ' . $db_order->customers_city;
        $obj->customer->telephone = $db_order->customers_telephone;
        $obj->customer->email = $db_order->customers_email_address;
        $obj->delivery = new stdClass();
        $obj->delivery->name = $db_order->delivery_name;
        $obj->delivery->address = $db_order->delivery_street_address . ', ' . $db_order->delivery_postcode . ' ' . $db_order->delivery_city;
        $obj->delivery->method = $db_order->shipping_method;       
        $obj->billing = new stdClass();
        $obj->billing->name = $db_order->billing_name;
        $obj->billing->address = $db_order->billing_street_address . ', ' . $db_order->billing_postcode . ' ' . $db_order->billing_city;
        $obj->billing->method = $db_order->payment_method;

        $obj->latest_update_time = $db_order->last_modified;
        if($obj->latest_update_time == null) {
        $obj->latest_update_time = $db_order->date_purchased;
        }
        $obj->order_creation_time = $db_order->date_purchased;
        $obj->status = $db_order->orders_status;

        $obj->currency = $db_order->currency;
        $obj->total = $db_order->order_total;
        $obj->tax = $db_order->order_tax;

        //items
        $items_res = $this->db->select('*')
                       ->from('orders_products')
                       ->where('orders_products.orders_id', $obj->id)
                       ->get()->result();

        $obj->items = array();
        foreach($items_res as $item_row)
        {
        $item = new stdClass();
        $item->name = $item_row->products_name;
        $item->unit_price = $item_row->final_price;
        $item->tax = $item_row->products_tax;
        $item->quantity = $item_row->products_quantity;
        $obj->items[] = $item;
        }

        //history
        $history_res = $this->db->select('*')
                       ->from('orders_status_history')
                       ->where('orders_status_history.orders_id', $obj->id)
                       ->get()->result();

        $obj->history = array();
        foreach($history_res as $history_row)
        {
        $history_item = new stdClass();
        $history_item->time = $history_row->date_added;
        $history_item->status_id = $history_row->orders_status_id;
        $history_item->comment = $history_row->comments;
        $obj->history[] = $history_item;
        }
        return $obj;
    }
    
    public function get_order_index_array($last_known_timestamp, $status_filter, $index_list)
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
}