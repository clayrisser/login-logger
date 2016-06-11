<?php

if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Logs_List extends WP_List_Table {

  public function prepare_items() {
    $columns = $this->get_columns();
    $hidden = $this->get_hidden_columns();
    $sortable = $this->get_sortable_columns();
    $data = $this->table_data();
    $this->_column_headers = array($columns, $hidden, $sortable);
    $this->items = $data;
  }
  
  public function get_columns() {
    $columns = array(
      'id'          => 'ID',
      'date'        => 'Date',
      'ip'          => 'IP Address',
      'country'     => 'Country',
      'username'    => 'Username',
      'password'      => 'Password'
    );
    return $columns;
  }
  
  public function get_hidden_columns() {
    return array();
  }
  
  public function get_sortable_columns() {
    return array('id' => array('id', false));
  }
  
  private function table_data() {
    $logJson = get_option( 'loggerlogin52' );
    $log = json_decode($logJson);
    $data = array();
    for ($i = 0; $i < count($log); $i++) {
      array_push($data, (array) $log[$i]);
    }
    return $data;
  }
  
  public function column_id($item) {
    return $item['id'];
  }
  
  public function column_default( $item, $column_name ) {
    switch( $column_name ) {
      case 'id':
      case 'date':
        return date_i18n(get_option('date_format'), $item[$column_name]).' '.date_i18n(get_option('time_format'), $item[$column_name]);
      case 'ip':
      case 'country':
      case 'username':
      case 'password':
        return $item[ $column_name ];
      default:
        return print_r( $item, true ) ;
    }
  }
  
}
