<?php
class Layout {

	private $ci;

	// the title for the layout
	private $title_for_layout;

	// title separator
	// you can change this in the construct
	public $title_separator;

	// holds the css and js files
	private $includes;

	public function __construct() {

		$this->ci = &get_instance();

		$this->title_for_layout = NULL;
		$this->title_separator = ' | ';

		$this->includes = array();

	}

	public function set_title($title = NULL) {

		$this->title_for_layout = $title;

	}

	public function add_includes($type, $file, $options = NULL, $prepend_base_url = TRUE) {

		if($prepend_base_url) {

			$this->ci->load->helper('url');
			$file = base_url() . $file;

		}

		$this->includes[$type][] = array(

			'file' => $file,
			'options' => $options


		);

		// allows chaining
		return $this;

	}

	public function view($name, $data = array(), $layout = 'default') {
    $this->ci->load->helper('url');
    $this->ci->config->load('jwt', true);
    $this->ci->load->model('M_preferences');
    $this->ci->load->model('M_com_menu');

    $data['config']      = $this->ci->config->item('jwt');
    $data['hostname']    = $this->ci->M_preferences->get_value_by_name('API', 'HOST_NAME');
    $data['rs_menu'] = $this->ci->M_com_menu->get_all_menu_by_portal($portal_id = "02");
		// get the contents of the view and store it
		$view = $this->ci->load->view($name, $data, TRUE);

		// set the title
		$title = '';

		if($this->title_for_layout !== NULL) {

			$title = $this->title_for_layout . $this->title_separator;

		}

		$this->ci->load->view('layouts/' . $layout, array(

			'title_for_layout' => $title,
			'includes_for_layout' => $this->includes,
			'content_for_layout' => $view

		));

	}

}
/* End of file layout.php */
/* Location: ./application/libraries/layout.php */
