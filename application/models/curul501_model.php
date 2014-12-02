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
	
	/*update representantes en votos y comisiones*/
	public function updateRepresentatives($id_representative = 0, $name = "") {
		$update = array('id_representative' => $id_representative);

		//votaciones
		$this->db->where('nombre', $name);
		$this->db->update('votaciones_representantes_scrapper', $update);
	}
	
	/*obtiene toda la información de un representante*/
	public function getRepresentative($id_representative = 0, $andWhere = "") {
		if($andWhere != "") {
			$query = $this->db->query("select * from representatives_scrapper where id_representative=" . $id_representative . " and " . $andWhere);
		} else {
			$query = $this->db->query("select * from representatives_scrapper where id_representative=" . $id_representative);
		}
		
		$data = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data[0];
		return false;
	}
	
	/*obtiene toda la información de una iniciativa*/
	public function getInitiative($id_initiative = 0, $andWhere = "") {
		if($andWhere != "") {
			$query = $this->db->query("select * from iniciativas_scrapper where id_initiative=" . $id_initiative . " and " . $andWhere);
		} else {
			$query = $this->db->query("select * from iniciativas_scrapper where id_initiative=" . $id_initiative);
		}
		
		$data = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data[0];
		return false;
	}
	
	/*obtiene todas las comisiones*/
	public function getCommissions() {
		$query = $this->db->query("select id_commission, name, slug from commissions");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	
	/*obtiene información del partido politico*/
	public function getPoliticalParty($id_political_party) {
		$query = $this->db->query("select * from political_parties where id_political_party=" . $id_political_party);
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data[0];
		return false;
	}
	
	/*Obtiene los representantes que la presentaron*/
	public function byRepresentatives($id_initiative = 0) {
		$query = $this->db->query("select * from representatives_scrapper where id_representative in (select id_representative from initiative2representatives where id_initiative=" . $id_initiative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*Obtiene las dependencias que la presentaron*/
	public function byDependencies($id_initiative = 0) {
		$query = $this->db->query("select * from dependencies where id_dependency in (select id_dependency from initiative2dependencies where id_initiative=" . $id_initiative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*Obtiene los partidos politicos que la presentaron*/
	public function byPoliticalParties($id_initiative = 0) {
		$query = $this->db->query("select * from political_parties where id_political_party in (select id_political_party from initiative2political_party where id_initiative=" . $id_initiative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*obtiene los temas de una iniciativa*/
	public function getTopicsByInitiative($id_initiative = 0) {
		$query = $this->db->query("select * from topics where id_topic in (select id_topic from initiatives2topics where id_initiative=" . $id_initiative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*obtiene las comisiones de una iniciativa*/
	public function getCommissionsByInitiative($id_initiative = 0) {
		$query = $this->db->query("select * from commissions where id_commission in (select id_commission from commissions2initiatives where id_initiative=" . $id_initiative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*obtiene las comisiones de una iniciativa*/
	public function getCommissionsByRepresentative($id_representative = 0) {
		$query = $this->db->query("select * from commissions where id_commission in (select id_commission from commissions2representatives where id_representative=" . $id_representative . ")");
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*obtiene los estatus de una iniciativa*/
	public function getStatusInitiative($id_initiative = 0, $order = "asc") {
		$query = $this->db->query("select * from estatus_iniciativas_scrapper where id_initiative=" . $id_initiative ." order by id_estatus " . $order);
		$data  = $query->result_array();
		
		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*poner en true publicada en la iniciativa*/
	public function setPublish($id_initiative = 0) {
		$update = array('publicada' => "t");

		//update initiative
		$this->db->where('id_initiative', $id_initiative);
		$this->db->update('iniciativas_scrapper', $update);
	}
	
	/*poner en true publicada un representante*/
	public function setPublishRepresentative($id_representative = 0) {
		$update = array('publicada' => "t");

		//update representative
		$this->db->where('id_representative', $id_representative);
		$this->db->update('representatives_scrapper', $update);
	}
	
	/*fix dates*/
	public function fixDates() {
		$query = $this->db->query("select * from iniciativas_scrapper");
		$data  = $query->result_array();
		
		//select fecha_listado, fecha_listado_tm, fecha_listado_header, fecha_listado_header_tm, fecha_votacion, fecha_votacion_tm from iniciativas_scrapper;
		
		foreach($data as $value) {
			$update = array();
			
			/*Fecha listado - presentada*/
			if($value["fecha_listado"] != "") {
				$fecha_listado    = $value["fecha_listado"];
				$fecha_listado    = str_replace(" de ", " ", $fecha_listado);
				$fecha_listado    = str_replace(".", "", $fecha_listado);
				$fecha_listado    = str_replace("+", "", $fecha_listado);
				$fecha_listado    = str_replace("</li>", "", $fecha_listado);
				$fecha_listado    = trim($fecha_listado);
				$fecha_listado    = explode(" ", $fecha_listado);
				$fecha_listado_tm = strtotime($fecha_listado[1] . '-' . $this->getMes(ucfirst($fecha_listado[2])) . '-' . $fecha_listado[3]);
				$update["fecha_listado_tm"] = date("Y-m-d H:i:s", $fecha_listado_tm);
			}
			
			/*Fecha listado header*/
			if($value["fecha_listado_header"] != "") {
				$fecha_listado_header    = $value["fecha_listado_header"];
				$fecha_listado_header    = str_replace(" de ", " ", $fecha_listado_header);
				$fecha_listado_header    = trim($fecha_listado_header);
				$fecha_listado_header    = explode(" ", $fecha_listado_header);
				$fecha_listado_header_tm = strtotime($fecha_listado_header[1] . '-' . $this->getMes(ucfirst($fecha_listado_header[2])) . '-' . $fecha_listado_header[3]);
				$update["fecha_listado_header_tm"] = date("Y-m-d H:i:s", $fecha_listado_header_tm);
			}
			
			/*Fecha votacion*/
			if($value["fecha_votacion"] != "") {
				$fecha_votacion            = $value["fecha_votacion"];
				$fecha_votacion            = str_replace(" de ", " ", $fecha_votacion);
				$fecha_votacion            = explode(" ", $fecha_votacion);
				$fecha_votacion_tm         = strtotime($fecha_votacion[0] . '-' . $this->getMes(ucfirst($fecha_votacion[1])) . '-' . $fecha_votacion[2]);
				$update["fecha_votacion_tm"] = date("Y-m-d H:i:s", $fecha_votacion_tm);
			}
			/*
			var_dump($update);
			var_dump($value["id_initiative"]);
			
			$this->db->where('id_initiative', $value["id_initiative"]);
			$this->db->update('iniciativas_scrapper', $update);
			*/
		}
	}
	
	/*fix slug status*/
	public function fixSlugStatus() {
		$query = $this->db->query("select * from estatus_iniciativas_scrapper");
		$data  = $query->result_array();
		
		foreach($data as $value) {
			$update["slug"] = slug($value["tipo"]);
			
			$this->db->where('id_estatus', $value["id_estatus"]);
			$this->db->update('estatus_iniciativas_scrapper', $update);
		}
	}
	
	/*get votes of political parties by initiative*/
	public function getVotesPoliticalParties($id_initiative) {
		$query  = "select * from votaciones_partidos_scrapper where id_initiative=". $id_initiative;
		$query .= "and id_contador_voto=(select id_contador_voto from votaciones_partidos_scrapper where id_initiative=" . $id_initiative;
		$query .= "order by id_contador_voto desc limit 1);";
		
		$query = $this->db->query($query);
		$data  = $query->result_array();

		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*get votes of representatives by initiative*/
	public function getVotesRepresentatives($id_initiative = false) {
		$query  = "select votaciones_representantes_scrapper.*, representatives_scrapper.full_name, representatives_scrapper.slug, representatives_scrapper.zone_state from votaciones_representantes_scrapper";
		$query .= " left join representatives_scrapper on votaciones_representantes_scrapper.id_representative=representatives_scrapper.id_representative";
		$query .= " where id_initiative=". $id_initiative;
		$query .= "and id_contador_voto=(select id_contador_voto from votaciones_representantes_scrapper where id_initiative=" . $id_initiative;
		$query .= "order by id_contador_voto desc limit 1);";
			
		$query = $this->db->query($query);
		$data  = $query->result_array();

		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
	
	/*Get resume from representative*/
	public function getResumeByRepresentative($id_representative = false) {
		$query = "select array_to_string(unnest_multidim(trayectoria), '_____') as trayectoria from representatives_scrapper where id_representative=". $id_representative;
		$query = $this->db->query($query);
		$data  = $query->result_array();

		if(is_array($data) and isset($data[0])) return $data;
		return false;
	}
			
	/*obtiene el mes - numerico*/
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
