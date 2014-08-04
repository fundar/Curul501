<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class curul501_Model extends CI_Model  {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
		
	/*Get user by id*/
	public function getUser($id_user) {
		$query = $this->db->get_where("usuarios", array("id_usuario" => $id_user));
		$row   = $query->row(0);
		
		if(isset($row->id_usuario)) {
			return $row;
		} else {
			return false;
		}
	}
	
	/*Check if user exists*/
	public function isUser($email = "", $password = "") {
		$query = $this->db->get_where("usuarios", array("email" => $email, "pwd" => $password));
		$row   = $query->row(0);
		
		if(isset($row->id_usuario)) {
			return $row;
		} else {
			return false;
		}
	}
}
