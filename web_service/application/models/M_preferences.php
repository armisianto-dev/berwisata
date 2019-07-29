<?php

class M_preferences extends CI_Model {

  public function get_value_by_name($pref_group, $pref_nm) {
    $sql = "SELECT pref_value FROM com_preferences WHERE pref_group = ? AND pref_nm = ?";
    $query = $this->db->query($sql, array($pref_group, $pref_nm));
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result['pref_value'];
    }
    return array();
  }

  public function get_pref_value_by_grup_name($params){
    $sql = "SELECT pref_value FROM com_preferences
      WHERE pref_group = ? AND pref_nm = ? ";
    $query = $this->db->query($sql,$params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result['pref_value'];
    }else{
      return array();
    }
  }

}
