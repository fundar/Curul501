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
	
	/*Obtiene las votaciones de los partidos policitis por iniciativa*/
	public function getVotesPoliticalParties($id_initiative = false) {
		return false;
	}
	
	/*Obtiene las votaciones de los representantes por iniciativa*/
	public function getVotesRepresentatives($id_initiative = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por comision*/
	public function getInitiativesByComission($slug = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por representante*/
	public function getInitiativesByRepresentative($slug = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por partido politico*/
	public function getInitiativesByPoliticalParty($slug = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por dependencia*/
	public function getInitiativesByDependency($slug = false) {
		return false;
	}
	
	/*Obtiene las iniciativas por tema*/
	public function getInitiativesByTopic($slug = false) {
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
	
	/*metodo por default para las consultas*/
	public function defaultQuery($query = false) {
		return false;
	}
}
