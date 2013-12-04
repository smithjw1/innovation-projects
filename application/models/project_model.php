<?php

class Project_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function add_project($sponsor, $marker_x, $marker_y, $project, $quadrant,$status) {
		    $this->db->query($this->db->insert_string('projects', array('sponsor'=>$sponsor, 'marker_x'=>$marker_x, 'marker_y'=>$marker_y, 'project'=>$project, 'quadrant'=>$quadrant, 'added'=>date('Y-m-d'), 'status'=>$status)));
		    
		    return $this->db->query($this->db->insert_string('project_path',array('marker_id'=>$this->db->insert_id(),'marker_x'=>$marker_x,'marker_y'=>$marker_y, 'note'=>'First placement')));
		    
	    }
    
    function get_projects($where = '1=1') 
    	{
		$query = $this->db->query('SELECT * FROM projects WHERE '.$where);
	    $projects = $query->result_array();
	    return $projects;
		}
		
	function move_project($id, $x, $y) 
		{
	    return $this->db->query('UPDATE projects SET marker_x = '.$this->db->escape($x).', marker_y = '.$this->db->escape($y).' WHERE id='.$this->db->escape($id)); 
		}

	function add_move_note($id, $x,$y, $note)
		{
		if($this->db->query($this->db->insert_string('project_path',array('marker_id'=>$id,'marker_x'=>$x,'marker_y'=>$y, 'note'=>$note)))) 
	 		{
		 		return $this->db->insert_id();		
	 		}
	 	else
	 		{
		 	return 'no_path';
	 		}   
		}
	
	function change_status($id, $status)
		{
		return $this->db->query('UPDATE projects SET status = '.$this->db->escape($status).' WHERE id='.$this->db->escape($id));	
		}
		
		function get_path($id) 
			{
			$query = $this->db->query('SELECT marker_x as x ,marker_y as y, time, note, marker_id as id FROM project_path WHERE marker_id='.$this->db->escape($id).' ORDER BY time DESC');
			return $query->result_array();
			}

}