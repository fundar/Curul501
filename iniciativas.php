<?php
/*incluir clase para manejra la BD*/
include_once "db/db.php";

class Iniciativas {
	
	public function __construct() {
		/*configuración de base de datos*/
		include_once "config/database.php";
		
		/*conexion con base de datos*/
		$this->pgsql = new Db();
		$this->pgsql->connect($db);
	}
	
	/*Obtiene las iniciativas por comision*/
	public function getInitiativesByComission($slug = false) {
		$data = $this->defaultQuerySlug("commissions", "id_commission", "commissions2initiatives", $slug);
		
		if(is_array($data)) return $data;
		return false;
	}
	
	/*Obtiene las iniciativas por representante*/
	public function getInitiativesByRepresentative($slug = false) {
		$data = $this->defaultQuerySlug("representatives_scrapper", "id_representative", "initiative2representatives", $slug);
		
		if(is_array($data)) return $data;
		return false;
	}
	
	/*Obtiene las iniciativas por partido politico*/
	public function getInitiativesByPoliticalParty($slug = false) {
		$data = $this->defaultQuerySlug("political_parties", "id_political_party", "initiative2political_party", $slug);
		
		if(is_array($data)) return $data;
		return false;
	}
	
	/*Obtiene las iniciativas por dependencia*/
	public function getInitiativesByDependency($slug = false) {
		$data = $this->defaultQuerySlug("dependencies", "id_dependency", "initiative2dependencies", $slug);
		
		if(is_array($data)) return $data;
		return false;
	}
	
	/*Obtiene las iniciativas por tema*/
	public function getInitiativesByTopic($slug = false) {
		$data = $this->defaultQuerySlug("topics", "id_topic", "initiatives2topics", $slug);
		
		if(is_array($data)) return $data;
		return false;
	}
	
	/*Obtiene las iniciativas por estatus*/
	public function getInitiativesByStatus($slug = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por fecha de presentación*/
	public function getInitiativesByDate($date = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por fecha de votación*/
	public function getInitiativesByVoteDate($date = false) {
		return false;
	}
	
	/*Obtiene los estatus de una iniciativa*/
	public function getStatusByInitiative($id_initiative = false, $order = "desc") {
		return false;
	}
	
	/*Obtiene las votaciones de los partidos policitos por iniciativa*/
	public function getVotesPoliticalParties($id_initiative = false) {
		if($id_initiative) {
			$query  = "select * from votaciones_partidos_scrapper where id_initiative=". $id_initiative;
			$query .= "and id_contador_voto=(select id_contador_voto from votaciones_partidos_scrapper where id_initiative=" . $id_initiative;
			$query .= "order by id_contador_voto desc limit 1);"
			
			$data = $this->pgsql->query($query);
			
			if(is_array($data)) {
				return $data;
			} else {
				return false;
			}
		}
		
		return false;
	}
	
	/*Obtiene las votaciones de los representantes por iniciativa*/
	public function getVotesRepresentatives($id_initiative = false) {
		if($id_initiative) {
			$query  = "select * from votaciones_representantes_scrapper where id_initiative=". $id_initiative;
			$query .= "and id_contador_voto=(select id_contador_voto from votaciones_representantes_scrapper where id_initiative=" . $id_initiative;
			$query .= "order by id_contador_voto desc limit 1);"
			
			$data = $this->pgsql->query($query);
			
			if(is_array($data)) {
				return $data;
			} else {
				return false;
			}
		}
		
		return false;
	}
	
	/*Busca y regresa el representante*/
	public function getIDRepresentante($slug = false, $field = "slug") {
		if($slug) {
			$query = "select * from representatives_scrapper where " . $field ."='" . $slug . "'";
			$data  = $this->pgsql->query($query);
			
			if(is_array($data) and isset($data[0])) {
				return $data[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/*Busca y regresa el partido politco*/
	public function getIDPartido($slug = false) {
		if($slug) {
			$query = "select * from political_parties where slug='" . $slug . "'";
			$data  = $this->pgsql->query($query);
			
			if(is_array($data) and isset($data[0])) {
				return $data[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/*Busca y regresa la dependencia*/
	public function getIDDependency($slug = false) {
		if($slug) {
			$query = "select * from dependencies where slug='" . $slug . "'";
			$data  = $this->pgsql->query($query);
			
			if(is_array($data) and isset($data[0])) {
				return $data[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/*Busca y regresa la comision*/
	public function getIDCommission($slug = false) {
		if($slug) {
			$query = "select * from commissions where slug='" . $slug . "'";
			$data  = $this->pgsql->query($query);
			
			if(is_array($data) and isset($data[0])) {
				return $data[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/*metodo por default para las consultas para las busquedas de iniciativas*/
	private function defaultQuerySlug($table = false, $id_realtion = false, $relation_table = false, $slug = false) {
		if($slug) {
			$query  = "select * from iniciativas_scrapper where id_initiative in (select distinct(id_initiative) from ";
			$uqery .= $relation_table . " where " . $id_realtion . "=(select " . $id_realtion ." from " . $table . " where slug='" . $slug . "'));"
			$data  = $this->pgsql->query($query);
			
			if(is_array($data)) {
				return $data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
