<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Paket_wisata extends REST_Controller {

  public function __construct() {
    // Construct the parent class
    parent::__construct();
    // load model
    $this->load->model('wisata/M_paket_wisata');
    // load libraries
    $this->load->library('form_validation');
  }

  public function pagination_paket_wisata_get() {

    $qcity = $this->input->get('qCity', true);
    $this->form_validation->set_data(compact('qCity'));

    $qcity = empty($qcity) || $qcity == "" ? '%' : '%'.$qcity."%";

    $total = $this->M_paket_wisata->get_total_data_paket_wisata(array($qcity));
    $result = array(
      "total" => $total
    );
    $this->set_response($result, REST_Controller::HTTP_OK);

  }

  public function all_paket_wisata_get() {
    $page = $this->input->get('page', true);
    $per_page = $this->input->get('per_page', true);
    $qcity = $this->input->get('qCity', true);

    $this->form_validation->set_data(compact('page','per_page','qCity'));

    $page = empty($page) ? 1 : $page;
    $start = (($page-1) * intval($per_page));

    $qcity = empty($qcity) || $qcity == "" ? '%' : '%'.$qcity."%";

    $result = $this->M_paket_wisata->get_all_paket_wisata(array($qcity, $start, intval($per_page)));
    if(! $result){
      $response = array(
        'title'   => 'List Paket Wisata',
        'status'  => false,
        'message' => 'List Paket Wisata tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Paket Wisata',
      'status'  => true,
      'message' => 'List Paket Wisata ditemukan',
      'data'    => $result,
    );
    $this->set_response($result, REST_Controller::HTTP_OK);

  }

  public function paket_wisata_promo_get() {

    $result = $this->M_paket_wisata->get_all_paket_wisata_promo();
    if(! $result){
      $response = array(
        'title'   => 'List Paket Wisata',
        'status'  => false,
        'message' => 'List Paket Wisata tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'List Paket Wisata',
      'status'  => true,
      'message' => 'List Paket Wisata ditemukan',
      'data'    => $result,
    );
    $this->set_response($result, REST_Controller::HTTP_OK);

  }

  public function detail_paket_wisata_get() {
    $paket_id = $this->input->get('paket_id', true);

    $this->form_validation->set_data(compact('paket_id'));
    $this->form_validation->set_rules('paket_id','Paket ID','trim|required');

    $result = $this->M_paket_wisata->get_detail_paket_wisata($paket_id);
    if(! $result){
      $response = array(
        'title'   => 'Detail Paket Wisata',
        'status'  => false,
        'message' => 'Detail Paket Wisata tidak ditemukan',
        'error'   => array(
          'code'    => '002',
          'message' => 'Data tidak ditemukan'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }

    $response = array(
      'title'   => 'Detail Paket Wisata',
      'status'  => true,
      'message' => 'Detail Paket Wisata ditemukan',
      'data'    => $result,
    );
    $this->set_response($result, REST_Controller::HTTP_OK);

  }
}
