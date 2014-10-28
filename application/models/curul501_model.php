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
			
			$fecha_listado = $value["fecha_listado"];
			$fecha_listado = str_replace(" de ", " ", $fecha_listado);
			$fecha_listado = explode(" ", $fecha_listado);
			
			var_dump($fecha_listado[1] . '-' . $this->getMes(ucfirst($fecha_listado[2])) . '-' . $fecha_listado[3]);
			
			$timestamp = strtotime($fecha_listado[1] . '-' . getMes(ucfirst($fecha_listado[2])) . '-' . $fecha_listado[3]);
			
			var_dump($timestamp);
			
			die("ok");
		}
	}
	
	public function getMes($mes) {
		switch($mes) {
		   case 'Enero': return 1; break;
		   case 'Febrero': return 2; break;
		   case 'Marzo': return 3; break;
		   case 'Abril': return 4; break;
		   case 'Mayo': return 5; break;
		   case 'Junio': return 6; break;
		   case 'Julio': return 7; break;
		   case 'Agosto': return 8; break;
		   case 'Septiembre': return 9; break;
		   case 'Octubre': return 10; break;
		   case 'Noviembre': return 11; break;
		   case 'Diciembre': return 12; break;
		}
	}
}
