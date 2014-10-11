<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends MY_Controller {

	function __construct() {

        parent::__construct();
        $this->load->model('workshops_model', 'workshop');
        $this->load->model('users_model', 'user');
    }

    public function index(){
        $this->load->view('welcome_message');
    }

    public function register(){

    	if($this->input->post()){
    		$this->form_validation->set_rules('email', 'Email', 'validEmial|required|trim|xss_clean');
    		$this->form_validation->set_rules('contactNo', 'Contact ', 'required|trim|xss_clean');
	        $data['errors'] = array();

	        if ($this->form_validation->run()) {
	        	$user = $this->user->getUserByEmail($this->input->post('email'));
	            // validation ok
	            if (!empty($user)) {
	            	$data['errors'] = 'User Exists';	            	
	            } else {
	                if (!is_null($id = $this->user->saveRegistrer())) { // success
					}
				}
	        }	
    	}

        $this->view_data['main_view'] = "register";
        $this->view_data['rightbar']    = "";
        $this->view_data['profile']   = "";
        $this->display();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/user.php */