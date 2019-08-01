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

    $postdata = file_get_contents("php://input");
    $obj = json_decode($postdata,true);

    $email = $obj['email'];
    $password = $obj['password'];

    $this->form_validation->set_data(compact('email','password'));

    // validasi input
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Login',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    // $user = $this->M_com_user->get_user(array($username, $role));
    if ($email != "armisianto@gmail.com" || $password != "kosongsatu") {
      $response = array(
        'title'   => 'Login',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '002',
          'message' => 'Periksa kembali username dan password anda'
        ),
      );
      return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    // $password_decode = $this->encrypt->decode($user['user_pass'], $user['user_key']);
    // if (md5($password) != $password_decode) {
    //   $response = array(
    //     'title'   => 'Login',
    //     'status'  => false,
    //     'message' => 'Token gagal digenerate',
    //     'error'   => array(
    //       'code'    => '003',
    //       'message' => 'Periksa kembali username dan password anda'
    //     ),
    //   );
    //   return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    // }

    $now_seconds = time();
    $config   = $this->config->item('jwt');
    $payload  = array(
      'iat' => $now_seconds,
      'exp' => $now_seconds+($config['expiration_time']),  // expiration time
      'username' => $email,
    );

    $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

    $response = array(
      'title'   => 'Login',
      'status'  => true,
      'message' => 'Token berhasil digenerate',
      'token'   => $token,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function auth_email_get() {


    $email = $this->input->get('email', true);
    $source = $this->input->get('source', true);

    $this->form_validation->set_data(compact('email','source'));

    // validasi input
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('source', 'Source', 'trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Login',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    // $user = $this->M_com_user->get_user(array($username, $role));
    if ($email != "armisianto@gmail.com" && $source == "google") {
      $response = array(
        'title'   => 'Login',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '002',
          'message' => 'Email anda belum terdaftar'
        ),
      );
      return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    if ($email != "armisianto.othermail@gmail.com" && $source == "fb") {
      $response = array(
        'title'   => 'Login',
        'status'  => false,
        'message' => 'Token gagal digenerate',
        'error'   => array(
          'code'    => '002',
          'message' => 'Akun anda belum terdaftar'
        ),
      );
      return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    // $password_decode = $this->encrypt->decode($user['user_pass'], $user['user_key']);
    // if (md5($password) != $password_decode) {
    //   $response = array(
    //     'title'   => 'Login',
    //     'status'  => false,
    //     'message' => 'Token gagal digenerate',
    //     'error'   => array(
    //       'code'    => '003',
    //       'message' => 'Periksa kembali username dan password anda'
    //     ),
    //   );
    //   return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    // }

    $now_seconds = time();
    $config   = $this->config->item('jwt');
    $payload  = array(
      'iat' => $now_seconds,
      'exp' => $now_seconds+($config['expiration_time']),  // expiration time
      'username' => $email,
    );

    $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

    $response = array(
      'title'   => 'Login',
      'status'  => true,
      'message' => 'Token berhasil digenerate',
      'token'   => $token,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function check_auth_get() {
    // check header or url parameters or post parameters for token
    $token = $this->input->get('token', true);
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

    $response = array(
      'title'   => 'Authorized',
      'status'  => true,
      'message' => 'Token masih aktif',
      'token'   => $token,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

}
