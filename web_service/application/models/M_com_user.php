<?php

class M_com_user extends CI_Model {

  public function get_user($params) {
    $sql = "SELECT * FROM com_user a 
      INNER JOIN com_role_user b ON a.user_id = b.user_id 
      WHERE a.user_name = ? AND b.role_id = ?";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }
    return array();
  }

}
