<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Error_404 extends REST_Controller {

  public function __construct() {
    // Construct the parent class
    parent::__construct();
  }

  public function index() {
    $response = array(
        'title'   => 'Not Found',
        'status'  => false,
        'message' => '404 Page Not Found',
        'error'   => array(
          'code'    => '404',
          'message' => 'The page you requested was not found'
        )
      );
      $this->response($response, REST_Controller::HTTP_NOT_FOUND);
  }

}
