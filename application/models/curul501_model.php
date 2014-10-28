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
			/*Fecha listado - presentada*/
			$fecha_listado    = $value["fecha_listado"];
			$fecha_listado    = str_replace(" de ", " ", $fecha_listado);
			$fecha_listado    = str_replace(".", "", $fecha_listado);
			$fecha_listado    = str_replace("+", "", $fecha_listado);
			$fecha_listado    = str_replace("</li>", "", $fecha_listado);
			$fecha_listado    = trim($fecha_listado);
			$fecha_listado    = explode(" ", $fecha_listado);
			$fecha_listado_tm = strtotime($fecha_listado[1] . '-' . $this->getMes(ucfirst($fecha_listado[2])) . '-' . $fecha_listado[3]);
			var_dump(date("Y-m-d H:i:s", $fecha_listado_tm));
			
			/*Fecha listado header*/
			$fecha_listado_header    = $value["fecha_listado_header"];
			$fecha_listado_header    = str_replace(" de ", " ", $fecha_listado_header);
			$fecha_listado_header    = trim($fecha_listado_header);
			$fecha_listado_header    = explode(" ", $fecha_listado_header);
			$fecha_listado_header_tm = strtotime($fecha_listado_header[1] . '-' . $this->getMes(ucfirst($fecha_listado_header[2])) . '-' . $fecha_listado_header[3]);
			var_dump(date("Y-m-d H:i:s", $fecha_listado_header_tm));
			
			/*Fecha votacion*/
			$fecha_votacion    = $value["fecha_votacion"];
			$fecha_votacion    = str_replace(" de ", " ", $fecha_votacion);
			$fecha_votacion    = explode(" ", $fecha_votacion);
			$fecha_votacion_tm = strtotime($fecha_votacion[0] . '-' . $this->getMes(ucfirst($fecha_votacion[1])) . '-' . $fecha_votacion[2]);
			var_dump(date("Y-m-d H:i:s", $fecha_votacion_tm));
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
