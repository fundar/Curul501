<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class curul501_Model extends CI_Model  {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
		
	/*Get user by id*/
	public function getUser($id_user) {
		$query = $this->db->get_where("users", array("id_user" => $id_user));
		$row   = $query->row(0);
		
		if(isset($row->id_user)) {
			return $row;
		} else {
			return false;
		}
	}
	
	/*Check if user exists*/
	public function isUser($email = "", $password = "") {
		$query = $this->db->get_where("users", array("email" => $email, "password" => $password));
		$row   = $query->row(0);
		
		if(isset($row->id_user)) {
			return $row;
		} else {
			return false;
		}
	}
	
	/*fix dates*/
	public function fixDates() {
		$query = $this->db->query("select * from iniciativas_scrapper");
		$data  = $query->result_array();
		
		foreach($data as $value) {
			//fecha_listado fecha_listado_header fecha_votacion
			die(var_dump($value));
		}
	}
}
