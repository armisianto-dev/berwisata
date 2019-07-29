<?php

class M_ap2kp extends CI_Model {

  private $db_kemenhub_sik;
  private $db_eperformance;

  function __construct() {
    // Call the Model constructor
    parent::__construct();
    $CI = &get_instance();
    $this->db_kemenhub_sik = $this->load->database('kemenhub_sik', TRUE);
    $this->db_eperformance = $this->load->database('e-performance', TRUE);
  }

  public function get_all_satuan_kerja_ikk_group_by_sasaran($params){
    $sql = "SELECT a.kode_sasaran_satker, a.sasaran_satker_kode AS 'kode_sasaran', a.judul_sasaran
    FROM satuan_kerja_sasaran a
    INNER JOIN satuan_kerja b ON a.kode_satker = b.kode_satker
    INNER JOIN satuan_kerja_ikk c ON a.tahun = c.tahun AND a.kode_satker = c.kode_satker AND a.kode_sasaran_satker = c.kode_sasaran_satker AND c.active_st = '1'
    WHERE a.active_st = '1' AND a.tahun = ? AND b.struktur_cd_sik = ?
    GROUP BY a.kode_sasaran_satker
    ORDER BY a.sasaran_satker_kode ";
    $query = $this->db_eperformance->query($sql, $params);
    if($query->num_rows() > 0){
      $rs_result = $query->result_array();
      $query->free_result();
      $arr_result = array();
      foreach($rs_result as $i=>$result){
        $arr_result[$i] = $result;
        $arr_result[$i]['rs_ikk'] = $this->get_all_satuan_kerja_ikk_by_sasaran(array_merge($params, array($result['kode_sasaran_satker'])));
      }
      return $arr_result;
    }else{
      return array();
    }
  }

  public function get_all_satuan_kerja_ikk_by_sasaran($params){
    $sql = "SELECT a.ikk_kode AS 'kode_ikk', a.uraian_ikk, a.satuan
    FROM satuan_kerja_ikk a
    INNER JOIN satuan_kerja b ON a.kode_satker = b.kode_satker
    WHERE a.active_st = '1' AND a.tahun = ? AND b.struktur_cd_sik = ? AND a.kode_sasaran_satker = ?
    ORDER BY a.ikk_kode";
    $query = $this->db_eperformance->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }

  public function get_list_tahun() {
    $sql = "SELECT DISTINCT tahun
    FROM (
      SELECT DISTINCT tahun
      FROM satuan_kerja_ikk
      UNION ALL
      SELECT YEAR(CURRENT_DATE)'tahun'
    )result
    ORDER BY tahun DESC";
    $query = $this->db_eperformance->query($sql);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();
      return $result;
    } else {
      return array();
    }
  }
  //
  // public function get_total_data($params) {
  //   $sql = "SELECT COUNT(*)'total'
  //   FROM data_struktur_organisasi a
  //   LEFT JOIN eperformance_v4_db.satuan_kerja b ON a.struktur_cd = b.struktur_cd_sik
  //   LEFT JOIN eperformance_v4_db.satuan_kerja_ikk e ON b.kode_satker = e.kode_satker
  //   WHERE (a.struktur_induk LIKE ? OR a.struktur_cd LIKE ?) AND struktur_level IN ('1','2','3','4')
  //   AND a.struktur_nama NOT LIKE 'bagian%' AND a.struktur_nama NOT LIKE 'bidang%' AND a.struktur_nama <> ''
  //   AND a.struktur_nama <> '-' AND a.struktur_nama <> 'fungsional umum' AND a.struktur_nama NOT LIKE 'sub%'
  //   AND a.struktur_nama NOT LIKE 'seksi%' AND a.struktur_nama NOT LIKE 'Subbidang%' AND a.struktur_nama NOT LIKE 'urusan%'
  //   AND e.active_st = '1' AND e.tahun = ?
  //   GROUP BY a.struktur_cd";
  //   $query = $this->db_kemenhub_sik->query($sql, $params);
  //   if ($query->num_rows() > 0) {
  //     $result = $query->row_array();
  //     $query->free_result();
  //     return $result['total'];
  //   } else {
  //     return 0;
  //   }
  // }


    public function get_total_data($params) {
      $sql = "SELECT COUNT(*)'total'
      FROM data_struktur_organisasi a
      LEFT JOIN satuan_kerja b ON a.struktur_cd = b.struktur_cd_sik
      LEFT JOIN satuan_kerja_ikk e ON b.kode_satker = e.kode_satker
      WHERE (a.struktur_induk LIKE ? OR a.struktur_cd LIKE ?) AND struktur_level IN ('1','2','3','4')
      AND a.struktur_nama NOT LIKE 'bagian%' AND a.struktur_nama NOT LIKE 'bidang%' AND a.struktur_nama <> ''
      AND a.struktur_nama <> '-' AND a.struktur_nama <> 'fungsional umum' AND a.struktur_nama NOT LIKE 'sub%'
      AND a.struktur_nama NOT LIKE 'seksi%' AND a.struktur_nama NOT LIKE 'Subbidang%' AND a.struktur_nama NOT LIKE 'urusan%'
      AND e.active_st = '1' AND e.tahun = ?
      GROUP BY a.struktur_cd";
      $query = $this->db_eperformance->query($sql, $params);
      if ($query->num_rows() > 0) {
        $result = $query->row_array();
        $query->free_result();
        return $result['total'];
      } else {
        return 0;
      }
    }

  public function get_all_data_limit($params) {
    $sql = "SELECT a.struktur_cd, a.struktur_nama,a.struktur_level, total_ikk
    FROM data_struktur_organisasi a
    LEFT JOIN  satuan_kerja b ON a.struktur_cd = b.struktur_cd_sik
    LEFT JOIN (
      SELECT kode_satker, active_st, tahun, uraian_ikk, COUNT(*) AS total_ikk
      FROM satuan_kerja_ikk
      WHERE tahun = ? AND active_st = '1'
      GROUP BY kode_satker
    ) e ON b.kode_satker = e.kode_satker
    LEFT JOIN data_eselon c ON a.eselon_id = c.eselon_id
    WHERE (a.struktur_induk LIKE ? OR a.struktur_cd LIKE ?) AND struktur_level IN ('1','2','3','4')
    AND a.struktur_nama NOT LIKE 'bagian%' AND a.struktur_nama NOT LIKE 'bidang%' AND a.struktur_nama <> ''
    AND a.struktur_nama <> '-' AND a.struktur_nama <> 'fungsional umum' AND a.struktur_nama NOT LIKE 'sub%'
    AND a.struktur_nama NOT LIKE 'seksi%' AND a.struktur_nama NOT LIKE 'Subbidang%' AND a.struktur_nama NOT LIKE 'urusan%'
    GROUP BY a.struktur_cd
    LIMIT ?, ?";
    $query = $this->db_eperformance->query($sql, $params);
    if ($query->num_rows() > 0) {
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else {
      return array();
    }
  }

  public function get_all_unit_kerja_ikk_group_by_sasaran($params){
    $sql = "SELECT a.kode_sasaran_satker, a.sasaran_satker_kode AS 'kode_sasaran', a.judul_sasaran, c.*
    FROM satuan_kerja_sasaran a
    INNER JOIN satuan_kerja b ON a.kode_satker = b.kode_satker
    LEFT JOIN data_struktur_organisasi c ON b.struktur_cd_sik = c.struktur_cd
    WHERE a.active_st = '1' AND a.tahun = ? AND c.struktur_cd = ?
    ORDER BY a.sasaran_satker_kode ";
    $query = $this->db_eperformance->query($sql, $params);
    if($query->num_rows() > 0){
      $rs_result = $query->result_array();
      $query->free_result();
      $arr_result = array();
      $total_ikk = 0;
      foreach($rs_result as $i=>$result){
        $rs_ikk = $this->get_all_unit_kerja_ikk_by_sasaran(array_merge($params, array($result['kode_sasaran_satker'])));
        if(!empty($rs_ikk)){
          $arr_result[$i] = $result;
          $arr_result[$i]['rs_ikk'] = $rs_ikk;
          $arr_result[$i]['total_ikk'] = count($rs_ikk);
        }

      }
      return $arr_result;
    }else{
      return array();
    }
  }

  public function get_all_unit_kerja_ikk_by_sasaran($params){
    $sql = "SELECT a.ikk_kode AS 'kode_ikk', a.uraian_ikk, a.satuan,
    (SELECT IFNULL(COUNT(target_id),0) AS total
    FROM pegawai_skp_target
    WHERE kode_sasaran = a.kode_sasaran_satker AND kode_ikk = a.kode_ikk
    GROUP BY kode_ikk) AS total_target
    FROM satuan_kerja_ikk a
    INNER JOIN satuan_kerja b ON a.kode_satker = b.kode_satker
    WHERE a.active_st = '1' AND a.tahun = ? AND b.struktur_cd_sik = ? AND a.kode_sasaran_satker = ?
    ORDER BY a.ikk_kode";
    $query = $this->db_eperformance->query($sql, $params);
    if($query->num_rows() > 0){
      $result = $query->result_array();
      $query->free_result();
      return $result;
    }else{
      return array();
    }
  }
}
