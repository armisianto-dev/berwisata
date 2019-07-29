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
    $this->load->model('v1/M_eplanning');
    // load libraries
    $this->load->library('form_validation');
    // authentication middleware
    $this->_check_auth();
  }

  // DARI E-Planning
  // Get Tahun Program
  public function tahun_program_get() {

    $result = $this->M_eplanning->get_all_tahun_program();
    if(! $result){
      $response = array(
        'title'   => 'Tahun Program',
        'status'  => false,
        'message' => 'Tahun program tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'Tahun Program',
      'status'  => true,
      'message' => 'Tahun program ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get Program Unit
  public function program_unit_get() {
    $tahun = $this->input->get('tahun', true);
    $kdunit = $this->input->get('kdunit', true);

    $this->form_validation->set_data(compact('tahun', 'kdunit'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kdunit','Kode Unit','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Program Unit',
        'status'  => false,
        'message' => 'List Program Unit gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_program_unit(array($tahun, $kdunit));
    if(! $result){
      $response = array(
        'title'   => 'List Program Unit',
        'status'  => false,
        'message' => 'List Program Unit tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Program Unit',
      'status'  => true,
      'message' => 'List Program Unit ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get Program Tahun
  public function program_tahun_get() {
    $tahun = $this->input->get('tahun', true);

    $this->form_validation->set_data(compact('tahun'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Program',
        'status'  => false,
        'message' => 'List Program gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_program_tahun(array($tahun));
    if(! $result){
      $response = array(
        'title'   => 'List Program',
        'status'  => false,
        'message' => 'List Program tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Program',
      'status'  => true,
      'message' => 'List Program ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get Kegiatan Tahun
  public function kegiatan_tahun_get() {
    $tahun = $this->input->get('tahun', true);

    $this->form_validation->set_data(compact('tahun'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Kegiatan',
        'status'  => false,
        'message' => 'List Kegiatan gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_kegiatan_tahun(array($tahun));
    if(! $result){
      $response = array(
        'title'   => 'List Kegiatan',
        'status'  => false,
        'message' => 'List Kegiatan tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Kegiatan',
      'status'  => true,
      'message' => 'List Kegiatan ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get Program Satker
  public function program_satker_get() {
    $tahun = $this->input->get('tahun', true);
    $kdsatker = $this->input->get('kdsatker', true);

    $this->form_validation->set_data(compact('tahun', 'kdsatker'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kdsatker','Kode Satker','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Program Satker',
        'status'  => false,
        'message' => 'List Program Satker gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_program_satker(array($tahun, $kdsatker));
    if(! $result){
      $response = array(
        'title'   => 'List Program Satker',
        'status'  => false,
        'message' => 'List Program Satker tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Program Satker',
      'status'  => true,
      'message' => 'List Program Satker ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);

  }

  // Get Kegiatan Satker
  public function kegiatan_satker_get(){
    $tahun = $this->input->get('tahun', true);
    $kdsatker = $this->input->get('kdsatker', true);

    $this->form_validation->set_data(compact('tahun', 'kdsatker'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kdsatker','Kode Satker','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List Kegiatan Satker',
        'status'  => false,
        'message' => 'List Kegiatan Satker gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_kegiatan_satker(array($tahun, $kdsatker));
    if(! $result){
      $response = array(
        'title'   => 'List Kegiatan Satker',
        'status'  => false,
        'message' => 'List Kegiatan Satker tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Kegiatan Satker',
      'status'  => true,
      'message' => 'List Kegiatan Satker ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  // Get Detail Kegiatan Satker
  public function kegiatan_satker_detail_get(){
    $tahun = $this->input->get('tahun', true);
    $kdsatker = $this->input->get('kdsatker', true);
    $kdkegiatan = $this->input->get('kdkegiatan', true);

    $this->form_validation->set_data(compact('tahun', 'kdsatker', 'kdkegiatan'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kdsatker','Kode Satker','trim|required');
    $this->form_validation->set_rules('kdkegiatan','Kode Kegiatan','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Detail Kegiatan Satker',
        'status'  => false,
        'message' => 'Detail Kegiatan Satker gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_detail_data_kegiatan_satker(array($tahun, $kdsatker, $kdkegiatan));
    if(! $result){
      $response = array(
        'title'   => 'Detail Kegiatan Satker',
        'status'  => false,
        'message' => 'Detail Kegiatan Satker tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'Detail Kegiatan Satker',
      'status'  => true,
      'message' => 'Detail Kegiatan Satker ditemukan',
      'data'    => $result,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  // DARI E-Performance
  // Get IKK Satker
  public function ikk_satker_get(){
    $tahun = $this->input->get('tahun', true);
    $kdsatker = $this->input->get('kdsatker', true);

    $this->form_validation->set_data(compact('tahun', 'kdsatker'));
    $this->form_validation->set_rules('tahun','Tahun','trim|required');
    $this->form_validation->set_rules('kdsatker','Kode Satker','trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'List IKK Satker',
        'status'  => false,
        'message' => 'List IKK Satker gagal diproses',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $result = $this->M_eplanning->get_all_data_satker_ikk_by_satker_tahun(array($tahun, $kdsatker));
    if(! $result){
      $response = array(
        'title'   => 'List IKK Satker',
        'status'  => false,
        'message' => 'List IKK Satker tidak ditemukan',
        'error'   => array(
          'code'    => '001',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List IKK Satker',
      'status'  => true,
      'message' => 'List IKK Satker ditemukan',
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
