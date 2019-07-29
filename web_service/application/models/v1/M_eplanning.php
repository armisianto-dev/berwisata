<?php

class M_eplanning extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
		$CI = &get_instance();
		$this->db_eplanning = $CI->load->database('e-planning', TRUE);
		$this->db_eperformance = $CI->load->database('e-performance', TRUE);
	}

	// Dari E-planning

	public function get_all_tahun_program(){
		$sql = "SELECT * FROM (
			SELECT YEAR(CURRENT_DATE()) AS 'tahun'
			UNION ALL
			SELECT kode_tahun AS 'tahun' FROM renstra_program
			ORDER BY tahun ASC
		)r
		GROUP BY tahun";
		$query = $this->db_eplanning->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$query->free_result();
			return $result;
		} else {
			return array();
		}
	}

	function get_all_data_program_tahun($params){
		$sql = "SELECT * FROM renstra_program WHERE kode_tahun = ? ORDER BY kode_program";
		$query = $this->db_eplanning->query($sql, $params);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	function get_all_data_kegiatan_tahun($params){
		$sql = "SELECT * FROM renstra_kegiatan WHERE kode_tahun = ? ORDER BY kode_kegiatan ";
		$query = $this->db_eplanning->query($sql, $params);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();
			return $result;
		}else{
			return array();
		}
	}

	function get_all_data_program_unit($params) {
		$sql = "SELECT kode_unit, nama_unit, kode_program, nama_program, kode_tahun, pagu, jumlah
		FROM (
			SELECT a.kode_program, p.nama_program, a.kode_tahun, SUM(h.jumlah) AS 'jumlah',
			t.group_nm AS 'pagu', p.kode_unit, u.nama_unit, s.flow_id
			FROM renstra_program p
			JOIN renstra_kegiatan a USING(kode_program, kode_tahun)
			JOIN renstra_kegiatan_output b USING(kode_kegiatan,kode_tahun)
			JOIN rincian_output c USING(kode_kegiatan, kode_tahun, kode_output)
			JOIN rincian_detail d USING(flow_id, kode_satker, kode_output, kode_kegiatan, kode_tahun)
			JOIN rincian_komponen e USING(flow_id, kode_satker, kode_output, kode_kegiatan, kode_tahun, kode_sub_output)
			JOIN rincian_sub_komponen f USING(flow_id, kode_satker, kode_output, kode_kegiatan, kode_tahun, kode_sub_output, kode_komponen)
			JOIN rincian_akun g USING(flow_id, kode_satker, kode_output, kode_kegiatan, kode_tahun, kode_sub_output, kode_komponen, kode_sub_komponen)
			JOIN rincian_item h USING(flow_id, kode_satker, kode_output, kode_kegiatan, kode_tahun, kode_sub_output, kode_komponen, kode_sub_komponen, kode_akun)
			JOIN study_flow s ON c.flow_id = s.flow_id
			JOIN study_flow_group t ON s.group_id = t.group_id
			JOIN unit_kerja u ON p.kode_unit = u.kode_unit
			WHERE a.kode_tahun = ? AND p.kode_unit = ?
			GROUP BY s.flow_id, a.kode_program
			ORDER BY s.flow_id DESC
		)r
		GROUP BY kode_program";
		$query = $this->db_eplanning->query($sql, $params);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			$query->free_result();
			return $result;
		} else {
			return array();
		}
	}

	function get_all_data_program_satker($params) {
		$sql = "SELECT * FROM (
			SELECT e.kode_program, e.nama_program, e.kode_tahun, e.kode_unit, f.nama_unit, b.flow_id,
			a.kode_satker, a.uraian_satker,
			get_jumlah_nilai_program(b.kode_tahun, b.kode_satker, e.kode_program, b.flow_id) AS 'jumlah'
			FROM satuan_kerja a
			INNER JOIN rincian_output b ON a.kode_satker = b.kode_satker
			INNER JOIN renstra_kegiatan_output c USING(kode_output, kode_kegiatan, kode_tahun)
			INNER JOIN renstra_kegiatan d USING(kode_kegiatan, kode_tahun)
			INNER JOIN renstra_program e USING(kode_program, kode_tahun)
			INNER JOIN unit_kerja f ON e.kode_unit = f.kode_unit
			WHERE b.kode_tahun = ? AND b.kode_satker = ?
			ORDER BY flow_id DESC
		)r
		GROUP BY r.kode_program";
		$query = $this->db_eplanning->query($sql, $params);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			$query->free_result();
			return $result;
		} else {
			return array();
		}
	}

	function get_all_data_kegiatan_satker($params) {
		$sql = "SELECT * FROM (
			SELECT d.kode_kegiatan, d.nama_kegiatan, d.kode_tahun, f.kode_unit, f.nama_unit, b.flow_id,
			a.kode_satker, a.uraian_satker,
			get_jumlah_nilai_kegiatan(b.kode_satker, b.kode_tahun, b.kode_kegiatan, b.flow_id) AS 'jumlah'
			FROM satuan_kerja a
			INNER JOIN rincian_output b ON a.kode_satker = b.kode_satker
			INNER JOIN renstra_kegiatan_output c USING(kode_output, kode_kegiatan, kode_tahun)
			INNER JOIN renstra_kegiatan d USING(kode_kegiatan, kode_tahun)
			INNER JOIN renstra_program e USING(kode_program, kode_tahun)
			INNER JOIN unit_kerja f ON e.kode_unit = f.kode_unit
			WHERE b.kode_tahun = ? AND b.kode_satker = ?
			ORDER BY flow_id DESC
		)r
		GROUP BY r.kode_kegiatan";
		$query = $this->db_eplanning->query($sql, $params);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$query->free_result();
			return $result;
		} else {
			return array();
		}
	}

	// DARI E-Performance
	function get_all_data_satker_ikk_by_satker_tahun($params){
		$sql = "SELECT kode_satker_opt AS 'kode_satker', nama_satker, ikk_kode AS 'kode_ikk', uraian_ikk, satuan
		FROM satuan_kerja_ikk a
		INNER JOIN satuan_kerja b ON a.kode_satker = b.kode_satker
		INNER JOIN
		(
			SELECT * FROM (
				SELECT * FROM satuan_kerja_detail
				ORDER BY tahun DESC, detail_id DESC
			)c1
			GROUP BY kode_satker
		) c ON b.kode_satker = c.kode_satker
		INNER JOIN satuan_kerja_sasaran d ON a.tahun = d.tahun AND a.kode_satker = d.kode_satker AND a.kode_sasaran_satker = d.kode_sasaran_satker AND d.active_st = '1'
		WHERE a.active_st = '1' AND a.tahun = ? AND c.kode_satker_opt = ?
		ORDER BY a.tahun,b.kode_unit,a.kode_satker,a.ikk_kode";
		$query = $this->db_eperformance->query($sql, $params);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$query->free_result();
			return $result;
		} else {
			return array();
		}
	}
}
