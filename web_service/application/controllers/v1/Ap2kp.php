<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class Ap2kp extends REST_Controller {

  public function __construct() {
    // Construct the parent class
    parent::__construct();
    // load config
    $this->config->load('jwt', true);
    // load model
    $this->load->model('v1/M_ap2kp');
    // load libraries
    $this->load->library('form_validation');
    // authentication middleware
    $this->_check_auth();
  }

  // Get ikk group by sasaran
  public function ikk_group_by_sasaran_get() {
    $tahun = $this->input->get('tahun', true);
    $struktur_cd_sik = $this->input->get('struktur_cd_sik', true);

    $this->form_validation->set_data(compact('tahun', 'struktur_cd_sik'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('struktur_cd_sik','struktur_cd_sik','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List IKK Group By Sasaran',
        'status'  => false,
        'message' => 'List IKK Group By Sasaran gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_ap2kp->get_all_satuan_kerja_ikk_group_by_sasaran(array($tahun, $struktur_cd_sik));
    if(! $result){
      $response = array(
        'title'   => 'List IKK Group By Sasaran',
        'status'  => false,
        'message' => 'List IKK Group By Sasaran tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List IKK Group By Sasaran',
      'status'  => true,
      'message' => 'List IKK Group By Sasaran ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get unit kerja ikk
  public function unit_kerja_ikk_get() {
    $tahun = $this->input->get('tahun', true);
    $struktur_cd_sik = $this->input->get('struktur_cd_sik', true);
    $index = $this->input->get('index', true);
    $per_page = $this->input->get('per_page', true);

    $this->form_validation->set_data(compact('tahun', 'struktur_cd_sik'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('struktur_cd_sik','struktur_cd_sik','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Data Unit Kerja IKK',
        'status'  => false,
        'message' => 'Data Unit Kerja IKK gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_ap2kp->get_total_data(array($struktur_cd_sik, $struktur_cd_sik, $tahun));
    if(! $result){
      $response = array(
        'title'   => 'Data Unit Kerja IKK',
        'status'  => false,
        'message' => 'Data Unit Kerja IKK tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $index = empty($index) ? 0 : $index;
    $per_page = empty($per_page) ? $result : $per_page;
    $rs_result = $this->M_ap2kp->get_all_data_limit(array($tahun, $struktur_cd_sik, $struktur_cd_sik, intval($index), intval($per_page)));
    $response = array(
      'title'   => 'Data Unit Kerja IKK',
      'status'  => true,
      'message' => 'Total Data ditemukan',
      'data'    => array(
        "total_data" => $result,
        "list_data" => $rs_result
      ),
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  public function unit_kerja_ikk_group_by_sasaran_get() {
    $tahun = $this->input->get('tahun', true);
    $struktur_cd_sik = $this->input->get('struktur_cd_sik', true);

    $this->form_validation->set_data(compact('tahun', 'struktur_cd_sik'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('struktur_cd_sik','struktur_cd_sik','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Data Unit Kerja IKK ',
        'status'  => false,
        'message' => 'Data Unit Kerja IKK gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_ap2kp->get_all_unit_kerja_ikk_group_by_sasaran(array($tahun, $struktur_cd_sik));
    if(! $result){
      $response = array(
        'title'   => 'Data Unit Kerja IKK',
        'status'  => false,
        'message' => 'Data Unit Kerja IKK tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }
    $response = array(
      'title'   => 'Data Unit Kerja IKK',
      'status'  => true,
      'message' => 'Total Data ditemukan',
      'data'    => $result
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // List Tahun
  public function list_tahun_get() {

    $result = $this->M_ap2kp->get_list_tahun();
    if(! $result){
      $response = array(
        'title'   => 'List Tahun',
        'status'  => false,
        'message' => 'List Tahun tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List tahun',
      'status'  => true,
      'message' => 'List tahun ditemukan',
      'data'    => $result
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Check Auth Token
  private function _check_auth() {
    // check header or url parameters or post parameters for token
    $token = $this->input->get_request_header('Authorization', true) ?:
    $this->input->post('token', true) ?:
    $this->input->get('token', true);
    if (! $token) {
      $response = array(
        'title'   => 'Unauthorized',
        'status'  => false,
        'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini',
        'error'   => array(
          'code'    => '040',
          'message' => 'Authorization token not found'
        )
      );
      $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
      $this->output->_display();
      exit;
    }

    $config = $this->config->item('jwt');
    try {
      $decode = JWT::decode($token, $config['private_key'], array($config['algorithms']));
    } catch (Exception $e) {
      $response = array(
        'title'   => 'Unauthorized',
        'status'  => false,
        'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini',
        'error'   => array(
          'code'    => '041',
          'message' => $e->getMessage(),
        )
      );
      $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
      $this->output->_display();
      exit;
    }
  }
}
