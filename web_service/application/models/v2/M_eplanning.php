<?php

class M_eplanning extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$CI = &get_instance();
		$this->db_eplanning = $CI->load->database('e-planning', TRUE);
		$this->db_eperformance = $CI->load->database('e-performance-v2', TRUE);
	}

	public function get_all_data_program_iku($params){
		$sql = "SELECT a.tahun, a.kode_program, c.indikator_kinerja_id, c.kode_indikator_kinerja, c.uraian, c.satuan,
		f.target_label AS 'target_label_rkt', f.target_value AS 'target_value_rkt',
		g.target_label AS 'target_label_pk', g.target_value AS 'target_value_pk',
		h.realisasi_value_total AS 'realisasi_value',
		IF(
			hitung = 'akumulatif',
			h.realisasi_value_total,
			h.realisasi_label
		) AS 'realisasi_label',
		IF(
      rumus = 'A',
      ROUND((( h.realisasi_value_total / g.target_value) * 100), 2),
      ROUND((((g.target_value - (h.realisasi_value_total - g.target_value)) / g.target_value) * 100), 2)
    ) AS 'kinerja_pk',
		IF(
      rumus = 'A',
      ROUND((( h.realisasi_value_total / f.target_value) * 100), 2),
      ROUND((((f.target_value - (h.realisasi_value_total - f.target_value)) / f.target_value) * 100), 2)
    ) AS 'kinerja_rkt'
		FROM renstra_program_iku a
		INNER JOIN renstra_indikator_kinerja_detail b ON a.tahun = b.tahun AND a.indikator_kinerja_id = b.indikator_kinerja_id AND b.active_st = 'yes'
		INNER JOIN renstra_indikator_kinerja c ON b.indikator_kinerja_id = c.indikator_kinerja_id
		INNER JOIN renstra_sasaran d ON c.sasaran_id = d.sasaran_id
		INNER JOIN renstra_sasaran_detail e ON d.sasaran_id = e.sasaran_id AND b.tahun = e.tahun AND e.active_st = 'yes'
		LEFT JOIN renstra_target_tahunan f ON b.tahun = f.tahun AND b.indikator_kinerja_id = f.indikator_kinerja_id
		LEFT JOIN perjanjian_kinerja_target g ON f.tahun = g.tahun AND f.indikator_kinerja_id = g.indikator_kinerja_id AND g.pengesahan_st = 'yes'
		LEFT JOIN (
			SELECT * FROM (
				SELECT indikator_kinerja_id, tahun, realisasi_value_total, realisasi_label
				FROM realisasi_kinerja
				WHERE bulan <= 12
				ORDER BY indikator_kinerja_id, tahun, bulan DESC
			)rsh GROUP BY indikator_kinerja_id, tahun
		) h ON b.indikator_kinerja_id = h.indikator_kinerja_id AND b.tahun = h.tahun
		WHERE a.tahun = ? AND a.kode_program = ?
		ORDER BY c.kode_indikator_kinerja ";
		$query = $this->db_eperformance->query($sql, $params);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	public function get_all_data_kegiatan_ikk($params){
		$this->db_eperformance->query('SET @tahun := ?', $params[0]);
		$sql = "SELECT a.tahun, a.kode_program, kode_satker, a.kode_kegiatan, c.indikator_kinerja_id, c.kode_indikator_kinerja,
		uraian, satuan ,
		g.target_label AS 'target_label_rkt', g.target_value AS 'target_value_rkt',
		h.target_label AS 'target_label_pk', h.target_value AS 'target_value_pk',
		i.realisasi_value_total AS 'realisasi_value',
		IF(
			hitung = 'akumulatif',
			i.realisasi_value_total,
			i.realisasi_label
		) AS 'realisasi_label',
		IF(
      rumus = 'A',
      ROUND((( i.realisasi_value_total / h.target_value) * 100), 2),
      ROUND((((h.target_value - (i.realisasi_value_total - h.target_value)) / h.target_value) * 100), 2)
    ) AS 'kinerja_pk',
		IF(
      rumus = 'A',
      ROUND((( i.realisasi_value_total / g.target_value) * 100), 2),
      ROUND((((g.target_value - (i.realisasi_value_total - g.target_value)) / g.target_value) * 100), 2)
    ) AS 'kinerja_rkt'
		FROM renstra_kegiatan_ikk a
		INNER JOIN renstra_indikator_kinerja_detail b ON a.tahun = b.tahun AND a.indikator_kinerja_id = b.indikator_kinerja_id AND b.active_st = 'yes'
		INNER JOIN renstra_indikator_kinerja c ON b.indikator_kinerja_id = c.indikator_kinerja_id
		INNER JOIN renstra_sasaran d ON c.sasaran_id = d.sasaran_id
		INNER JOIN renstra_sasaran_detail e ON d.sasaran_id = e.sasaran_id AND b.tahun = e.tahun AND e.active_st = 'yes'
		INNER JOIN renstra_periode_detail f ON d.detail_id = f.detail_id
		LEFT JOIN renstra_target_tahunan g ON b.tahun = g.tahun AND b.indikator_kinerja_id = g.indikator_kinerja_id
		LEFT JOIN perjanjian_kinerja_target h ON g.tahun = h.tahun AND g.indikator_kinerja_id = h.indikator_kinerja_id AND h.pengesahan_st = 'yes'
		LEFT JOIN (
			SELECT * FROM (
				SELECT indikator_kinerja_id, tahun, realisasi_value_total, realisasi_label
				FROM realisasi_kinerja
				WHERE bulan <= 12
				ORDER BY indikator_kinerja_id, tahun, bulan DESC
			)rsi GROUP BY indikator_kinerja_id, tahun
		) i ON b.indikator_kinerja_id = i.indikator_kinerja_id AND b.tahun = i.tahun
		INNER JOIN (
			SELECT * FROM (
				SELECT * FROM data_struktur_organisasi_perubahan
				WHERE perubahan_st NOT IN ('non_aktif') AND YEAR(perubahan_tanggal) <= @tahun
				ORDER BY perubahan_tanggal DESC, perubahan_id DESC
			) rsj GROUP BY struktur_id
		) j ON f.struktur_id = j.struktur_id
		WHERE a.tahun = ? AND a.kode_kegiatan = ? AND j.kode_satker = ?
		ORDER BY c.kode_indikator_kinerja ";
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
