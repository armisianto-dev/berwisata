<?php

class M_paket_wisata extends CI_Model {

  public function get_total_data_paket_wisata(){
    $sql = "SELECT COUNT(*) AS 'total' FROM data_wisata_paket";
    $query = $this->db->query($sql);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result['total'];
    }else{
      return 0;
    }
  }

  public function get_all_paket_wisata($params){
    $sql = "SELECT a.*, city_name, country_name, promo_st, harga_normal, harga_promo
    FROM data_wisata_paket a
    INNER JOIN data_city b ON a.city_id = b.city_id
    INNER JOIN data_country c ON b.country_id = c.country_id
    INNER JOIN (
      SELECT * FROM (
        SELECT * FROM data_wisata_paket_harga
        ORDER BY crd DESC
      )rsd GROUP BY paket_id
    ) d ON a.paket_id = d.paket_id
    ORDER BY a.paket_id LIMIT ?,? ";
    $query = $this->db->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  public function get_detail_paket_wisata($params){
    $sql = "SELECT a.*, city_name, country_name, promo_st, harga_normal, harga_promo
    FROM data_wisata_paket a
    INNER JOIN data_city b ON a.city_id = b.city_id
    INNER JOIN data_country c ON b.country_id = c.country_id
    INNER JOIN (
      SELECT * FROM (
        SELECT * FROM data_wisata_paket_harga
        ORDER BY crd DESC
      )rsd GROUP BY paket_id
    ) d ON a.paket_id = d.paket_id
    WHERE a.paket_id = ?
    ORDER BY a.paket_id ";
    $query = $this->db->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->row_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

}
