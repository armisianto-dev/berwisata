<?php

class M_com_user extends CI_Model {

  public function get_user_last_id($prefixdate, $params) {
    $sql = "SELECT RIGHT(user_id, 4)'last_number'
    FROM com_user
    WHERE user_id LIKE ?
    ORDER BY user_id DESC
    LIMIT 1";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      // create next number
      $number = intval($result['last_number']) + 1;
      if ($number > 9999) {
        return false;
      }
      $zero = '';
      for ($i = strlen($number); $i < 4; $i++) {
        $zero .= '0';
      }
      return $prefixdate . $zero . $number;
    } else {
      // create new number
      return $prefixdate . '0001';
    }
  }

  public function get_user_by_username($params) {
    $sql = "SELECT * FROM com_user a
    WHERE a.user_name = ?";
    $query = $this->db->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }
    return array();
  }

  public function get_user_by_social_id($params){
    $sql = "SELECT a.*,b.* FROM com_user a
    INNER JOIN com_user_social b ON a.user_id = b.user_id
    WHERE provider = ? AND id = ? ";
    $query = $this->db->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  public function get_user_by_token($params){
    $sql = "SELECT a.user_id,
    IF(c.user_id IS NOT NULL, c.name, a.user_alias) AS 'name',
    IF(c.user_id IS NOT NULL, c.email, a.user_mail) AS 'email',
    IF(c.user_id IS NOT NULL, c.photoUrl, CONCAT(a.user_img_path, a.user_img_name)) AS 'photoUrl',
    a.user_gender AS 'gender',
    a.user_birthday AS 'birthday',
    a.user_no_hp AS 'no_hp'
    FROM com_user a
    INNER JOIN com_user_login b ON a.user_id = b.user_id
    LEFT JOIN com_user_social c ON a.user_id = c.user_id AND b.provider = c.provider
    WHERE b.token = ? ";
    $query = $this->db->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  public function insert_user($params){
    return $this->db->insert('com_user', $params);
  }

  public function insert_user_login($params){
    return $this->db->insert('com_user_login', $params);
  }

  public function update_user_social($params, $where){
    return $this->db->update('com_user_social', $params, $where);
  }

  public function insert_user_social($params){
    return $this->db->insert('com_user_social', $params);
  }

}
