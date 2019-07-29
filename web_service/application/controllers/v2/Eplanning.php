<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class Eplanning extends REST_Controller {

  public function __construct() {
    // Construct the parent class
    parent::__construct();
    // load config
    $this->config->load('jwt', true);
    // load model
    $this->load->model('v2/M_eplanning');
    // load libraries
    $this->load->library('form_validation');
    // authentication middleware
    $this->_check_auth();
  }

  // Get Program IKU
  public function program_iku_get(){
    $tahun = $this->input->get('tahun', true);
    $kode_program = $this->input->get('kode_program', true);

    $this->form_validation->set_data(compact('tahun', 'kode_program'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kode_program','Kode Program','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Program IKU',
        'status'  => false,
        'message' => 'List Program IKU gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_program_iku(array($tahun, $kode_program));
    if(! $result){
      $response = array(
        'title'   => 'List Program IKU',
        'status'  => false,
        'message' => 'List Program IKU tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Program IKU',
      'status'  => true,
      'message' => 'List Program IKU ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  // Get Kegiatan IKK
  public function kegiatan_ikk_get(){
    $tahun = $this->input->get('tahun', true);
    $kode_kegiatan = $this->input->get('kode_kegiatan', true);
    $kode_satker = $this->input->get('kode_satker', true);

    $this->form_validation->set_data(compact('tahun', 'kode_kegiatan', 'kode_satker'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kode_kegiatan','Kode Kegiatan','trim|required');
    $this->form_validation->set_rules('kode_satker','Kode Satker','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Kegiatan IKK',
        'status'  => false,
        'message' => 'List Kegiatan IKK gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_kegiatan_ikk(array($tahun, $kode_kegiatan, $kode_satker));
    if(! $result){
      $response = array(
        'title'   => 'List Kegiatan IKK',
        'status'  => false,
        'message' => 'List Kegiatan IKK tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Kegiatan IKK',
      'status'  => true,
      'message' => 'List Kegiatan IKK ditemukan',
      'data'    => $result,
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
