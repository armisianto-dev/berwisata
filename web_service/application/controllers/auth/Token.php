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

    $user = $this->M_com_user->get_user_by_username(array($email));
    if (!$user) {
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

    $password_decode = $this->encrypt->decode($user['user_pass'], $user['user_key']);
    if (md5($password) != $password_decode) {
      $response = array(
        'title'   => 'Login',
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
      'username' => $email,
    );

    $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

    $params = array(
      "user_id" => $user['user_id'],
      "token" => $token,
      "provider" => "MANUAL",
      "login_date" => date("Y-m-d H:i:s")
    );

    $this->M_com_user->insert_user_login($params);

    $response = array(
      'title'   => 'Login',
      'status'  => true,
      'message' => 'Token berhasil digenerate',
      'token'   => $token,
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function auth_social_post() {

    $postdata = file_get_contents("php://input");
    $obj = json_decode($postdata,true);

    $social_id = $obj['social_id'];
    $provider = $obj['provider'];
    $name = $obj['name'];
    $email = $obj['email'];
    $photoUrl = $obj['photoUrl'];

    $this->form_validation->set_data(compact('social_id','provider'));

    // validasi input
    $this->form_validation->set_rules('social_id', 'ID', 'trim|required');
    $this->form_validation->set_rules('provider', 'Provider', 'trim|required');

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

    $user = $this->M_com_user->get_user_by_social_id(array($provider, $social_id));
    if (!$user) {
      // $response = array(
      //   'title'   => 'Login',
      //   'status'  => false,
      //   'message' => 'Token gagal digenerate',
      //   'error'   => array(
      //     'code'    => '002',
      //     'message' => 'Akun belum terhubung'
      //   ),
      // );
      // return $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
      $this->register_social($obj);
    }

    $now_seconds = time();
    $config   = $this->config->item('jwt');
    $payload  = array(
      'iat' => $now_seconds,
      'exp' => $now_seconds+($config['expiration_time']),  // expiration time
      'username' => $email,
    );

    $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

    $params = array(
      "name" => $name,
      "email" => $email,
      "photoUrl" => $photoUrl
    );

    $where = array(
      "id" => $social_id,
      "provider" => $provider
    );

    $this->M_com_user->update_user_social($params, $where);

    $params = array(
      "user_id" => $user['user_id'],
      "token" => $token,
      "provider" => $provider,
      "login_date" => date("Y-m-d H:i:s")
    );

    $this->M_com_user->insert_user_login($params);

    $response = array(
      'title'   => 'Login',
      'status'  => true,
      'message' => 'Token berhasil digenerate',
      'token'   => $token
    );
    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function register_social($obj) {

    $social_id = $obj['social_id'];
    $provider = $obj['provider'];
    $name = $obj['name'];
    $email = $obj['email'];
    $photoUrl = $obj['photoUrl'];

    $this->form_validation->set_data(compact('social_id','provider'));

    // validasi input
    $this->form_validation->set_rules('social_id', 'ID', 'trim|required');
    $this->form_validation->set_rules('provider', 'Provider', 'trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Register',
        'status'  => false,
        'message' => 'Register gagal',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $prefixdate = date('Ym');
    $params = $prefixdate.'%';
    $user_id = $this->M_com_user->get_user_last_id($prefixdate, $params);

    $params = array(
      "user_id" => $user_id,
      "user_alias" => $name,
      "user_mail" => $email,
      "user_img_path" => $photoUrl,
      "user_st" => "1",
      "user_completed" => "0",
      "mdd" => date('Y-m-d H:i:s')
    );

    if($this->M_com_user->insert_user($params)){
      $params = array(
        "user_id" => $user_id,
        "id" => $social_id,
        "provider" => $provider,
        "name" => $name,
        "email" => $email,
        "photoUrl" => $photoUrl
      );

      if($this->M_com_user->insert_user_social($params)){
        $now_seconds = time();
        $config   = $this->config->item('jwt');
        $payload  = array(
          'iat' => $now_seconds,
          'exp' => $now_seconds+($config['expiration_time']),  // expiration time
          'username' => $email,
        );

        $token = JWT::encode($payload, $config['private_key'], $config['algorithms']);

        $params = array(
          "user_id" => $user_id,
          "token" => $token,
          "provider" => $provider,
          "login_date" => date("Y-m-d H:i:s")
        );

        $this->M_com_user->insert_user_login($params);

        $response = array(
          'title'   => 'Login',
          'status'  => true,
          'message' => 'Token berhasil digenerate',
          'token'   => $token
        );
        $this->set_response($response, REST_Controller::HTTP_OK);

      }else{
        $response = array(
          'title'   => 'Register',
          'status'  => false,
          'message' => 'Register gagal',
          'error'   => array(
            'code'    => '002',
            'message' => "Data user gagal disimpan"
          )
        );
        return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
      }
    }else{
      $response = array(
        'title'   => 'Register',
        'status'  => false,
        'message' => 'Register gagal',
        'error'   => array(
          'code'    => '002',
          'message' => "Data user gagal disimpan"
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }
  }

  public function profile_get(){

    $token = $this->input->get('token', true);
    $user = $this->M_com_user->get_user_by_token($token);
    $response = array(
      'name' => $user['name'],
      'email' => $user['email'],
      'photoUrl' => $user['photoUrl'],
      'gender' => $user['gender'],
      'birthday' => $user['birthday'],
      'no_hp' => $user['no_hp']
    );

    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function social_accounts_get(){

    $token = $this->input->get('token', true);
    $user = $this->M_com_user->get_user_by_token($token);
    $rs_social_accounts = $this->M_com_user->get_user_social($user['user_id']);
    $response = array();
    if($rs_social_accounts){
      foreach($rs_social_accounts as $social_account){
        $response[$social_account['provider']] = $social_account;
      }
    }

    $this->set_response($response, REST_Controller::HTTP_OK);
  }

  public function connect_social_post(){

    $postdata = file_get_contents("php://input");
    $obj = json_decode($postdata,true);

    $token = $obj['token'];
    $social_id = $obj['social_id'];
    $provider = $obj['provider'];
    $name = $obj['name'];
    $email = $obj['email'];
    $photoUrl = $obj['photoUrl'];

    $this->form_validation->set_data(compact('social_id','provider'));

    // validasi input
    $this->form_validation->set_rules('social_id', 'ID', 'trim|required');
    $this->form_validation->set_rules('provider', 'Provider', 'trim|required');

    if ($this->form_validation->run() === false) {
      $response = array(
        'title'   => 'Register',
        'status'  => false,
        'message' => 'Register gagal',
        'error'   => array(
          'code'    => '001',
          'message' => array_values($this->form_validation->error_array())
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    if($this->M_com_user->is_exist_social_id($social_id)){
      $response = array(
        'title'   => 'Register',
        'status'  => false,
        'message' => 'Akun sosial media sudah terdaftar',
        'error'   => array(
          'code'    => '001',
          'message' => 'Akun sosial media sudah terdaftar'
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_UNPROCESSABLE_ENTITY);
    }

    $user = $this->M_com_user->get_user_by_token($token);

    $params = array(
      "user_id" => $user['user_id'],
      "id" => $social_id,
      "provider" => $provider,
      "name" => $name,
      "email" => $email,
      "photoUrl" => $photoUrl
    );

    if($this->M_com_user->insert_user_social($params)){
      $response = array(
        'title'   => 'Register',
        'status'  => true,
        'message' => 'Register berhasil',
        'error'   => array(
          'code'    => '002',
          'message' => "Data user berhasil disimpan"
        )
      );
      $this->set_response($response, REST_Controller::HTTP_OK);

    }else{
      $response = array(
        'title'   => 'Register',
        'status'  => false,
        'message' => 'Register gagal',
        'error'   => array(
          'code'    => '002',
          'message' => "Data user gagal disimpan"
        )
      );
      return $this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    }
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
