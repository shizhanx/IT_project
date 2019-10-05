<?php


class Artifact_model extends CI_Model
{
	public function  __construct()
	{
		$this->load->database();
	}

	public function get_artifacts($type,$value){
		if ($type=='exact'){
			$query=$this->db->get_where('artifacts',array('artifact_id'=>$value));
			return $query->result_array();
		}elseif ($type=='include') {
			$this->db->like('name',$value,'both');
			$this->db->or_like('description',$value,'both');
			$query = $this->db->get('artifacts');
			return $query->result_array();
		}
	}

	public function set_news(){
		$this->load->helper('url');

		$slug=url_title($this->input->post('title'),'dash',TRUE);

		$data=array(
			'title'=>$this->input->post('title'),
			'slug'=>$slug,
			'text'=>$this->input->post('text')
		);
		return $this->db->insert('news',$data);
	}
}
