<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IP extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		$this->load->model('Project_model');
	}

	public function index($staff=false)
	{
		$this->load->view('global/header');
		$this->load->view('view', array('staff'=>$staff,'projects'=>$this->Project_model->get_projects()));
		$this->load->view('global/footer');
	}
	
	
	public function create_project() {
		switch($this->input->post('quadrant')) 
			{
				case 'now': $x = 46; $y = 50; break;
				case 'wow': $x = 50; $y = 50; break;
				case 'how': $x = 50; $y = 46; break;
				default: $x = 50; $y = 50;
			}
		$this->Project_model->add_project(
			$this->input->post('sponsor'),
			$x,
			$y,
			$this->input->post('project'),
			$this->input->post('quadrant'),
			$this->input->post('status')
		);
		redirect('/');
		
	}
	
	public function move_project($id,$x,$y) {
		print $this->Project_model->move_project($id, $x, $y);
	}	
	public function add_move_note() {
		$this->Project_model->add_move_note($this->input->post('id'),$this->input->post('x'),$this->input->post('y'),$this->input->post('note'));
	}	
	public function approve_project($id) {
		$this->Project_model->change_status($id,'i');
	}	


	public function get_path($id)
		{
		print json_encode($this->Project_model->get_path($id));
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */