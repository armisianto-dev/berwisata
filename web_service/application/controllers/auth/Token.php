<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/REST_Controller.php';

use \Firebase\JWT\JWT;

class Token extends REST_Controller {

  public function __construct() {
    // Construct the parent class
    parent::__construct();
    // load config
    $this->config->load('jwt', true);
    // load model
    $this->load->model('M_com_user');
    // load libraries
    $this->load->library('encrypt');
    $this->load->library('form_validation');
  }

  public function index_post() {
    // validasi input
    $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[255]');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Generate Token',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $username = $this->input->post('username', true);
    $password = $this->input->post('password', true);
    $role = $this->input->post('role', true);

    $user = $this->M_com_user->get_user(array($username, $role));
    if (! $user) {
      $response = array(
        'title'   => 'Generate Token',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '002',
          'message' => 'Periksa kembali username dan password anda'
        ),
      );
      return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    $password_decode = $this->encrypt->decode($user['user_pass'], $user['user_key']);
    if (md5($password) != $password_decode) {
      $response = array(
        'title'   => 'Generate Token',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '003',
          'message' => 'Periksa kembali username dan password anda'
        ),
      );
      return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    $now_seconds = time();
    $config   = $this->config->item('jwt');
    $payload  = array(
      'iat' => $now_seconds,
      'exp' => $now_seconds+($config['expiration_time']),  // expiration time
      'username' => $username,
    );

    $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

    $response = array(
      'title'   => 'Generate Token',
      'status'  => true,
      'message' => 'Token berhasil digenerate',
      'token'   => $token,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

}
