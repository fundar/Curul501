<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		
		//Helpers
		$this->load->helper('url');
		$this->load->helper('slug'); /* application/helpers/slug_helper.php */
		$this->load->helper('date');

		$this->load->library('grocery_CRUD');
	}

	/*Salida de las vistas*/
	public function _example_output($output = null) {
		$this->load->view('admin.php', $output);
	}
	
	/*TO-DO*/
	
	/*Partidos politicos*/
	public function political_parties() {
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('political_parties');
		$crud->set_subject('Partidos políticos');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name', 'short_name', 'short_title', 'url_logo');
		$crud->columns('id_political_party', 'name', 'short_name', 'url_logo');
		$crud->fields('id_political_party', 'name', 'short_name', 'url_logo', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_political_party', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('short_name', 'Nombre corto');
		
		/*Set upload file Logo, Slug*/
		$crud->display_as('url_logo', 'Logo');
		$crud->set_field_upload('url_logo', 'assets/uploads/files');
		$crud->field_type('slug', 'invisible');
		$crud->field_type('id_political_party', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Legislaturas*/
	public function legislatures() {
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('legislatures');
		$crud->set_subject('Legislaturas');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_legislature', 'name');
		$crud->fields('id_legislature', 'name', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_legislature', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->field_type('slug', 'invisible');
		$crud->field_type('id_legislature', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}

	
	/*Representantes*/
	public function representatives() {
		try {
			$crud  = new grocery_CRUD();
			$state = $crud->getState();
			
			/*Tabla y título*/
			$crud->set_theme('datatables');
			$crud->set_table('representatives');
			$crud->set_subject('Representantes');
			
			/*Set requiered fields, columns and fields*/
			$crud->required_fields('id_political_party', 'id_legislature', 'name');
			$crud->columns('id_representative', 'name', 'id_political_party', 'id_legislature', 'avatar', 'birthday', 'twitter', 'facebook', 'district', 'phone', 'email', 'map');
			
			if($state != "read") {
				$crud->fields('id_representative', 'name','id_political_party', 'id_legislature', 'slug', 'avatar', 'biography', 'birthday', 'twitter', 'facebook', 'district', 'phone', 'email', 'substitute', 'election_type', 'circumscription', 'latitude', 'longitude', 'map');
			} else {
				$crud->fields('id_representative', 'name', 'id_political_party', 'id_legislature', 'slug', 'avatar', 'biography', 'birthday', 'twitter', 'facebook', 'district', 'phone', 'email', 'substitute', 'election_type', 'circumscription', 'latitude', 'longitude');
			}
			
			/*Nombres de campos*/	
			$crud->display_as('id_representative', 'ID');
			$crud->display_as('name', 'Nombre');
			$crud->display_as('biography', 'Biografia');
			$crud->display_as('district', 'Distrito');
			$crud->display_as('substitute', 'Sustituto');
			$crud->display_as('election_type', 'Tipo de elección');
			$crud->display_as('circumscription', 'Cirscuncipcion');
			
			$crud->display_as('id_political_party', 'Partido Político');
			$crud->set_relation('id_political_party', 'political_parties', 'name');
			
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
			
			$crud->display_as('birthday', 'Cumpleaños');
			$crud->field_type('birthday', 'date');
			
			/*Set upload file Avatar, slug, latitude & longitude*/
			$crud->set_field_upload('avatar', 'assets/uploads/files');
			$crud->field_type('slug', 'invisible');
			$crud->field_type('id_representative', 'invisible');
			$crud->field_type('longitude', 'hidden');
			
			/*Callback Para el Mapa*/
			if($state != "read") {
				$crud->field_type('latitude', 'hidden');
				$crud->display_as('map', 'Ubicación');
				$crud->callback_add_field('map', array($this,'getMap'));
				$crud->callback_edit_field('map', array($this,'getMap'));
			} else {
				$crud->display_as('latitude', 'Ubicación');
				$crud->callback_field('latitude', array($this, 'getMap2'));
			}
			
			/*Callbacks para obtener urls y slug*/
			$crud->callback_column($this->unique_field_name('id_political_party'), array($this, 'urlPoliticalParty'));
			$crud->callback_column($this->unique_field_name('id_legislature'),     array($this, 'urlLegislature'));
			$crud->callback_before_insert(array($this, 'getSlug'));
			
			$output = $crud->render();
			
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	/*Crud de iniciativas*/
	public function initiatives() {
		try {
			$crud = new grocery_CRUD();
			
			/*Tabla y título*/
			$crud->set_theme('datatables');
			$crud->set_table('initiatives');
			$crud->set_subject('Iniciativas');
			
			/*Set requiered fields, columns and fields*/
			$crud->required_fields('id_legislature', 'title', 'description', 'short_title');
			$crud->columns('id_initiative', 'id_legislature', 'title', 'description', 'short_title', 'presented_by', 'additional_resources', 'additional_resources_url', 'official_vote_up', 'official_vote_down', 'official_vote_abstentions', 'voted_at');
			$crud->fields('id_initiative', 'id_legislature', 'title', 'description', 'short_title', 'presented_by', 'additional_resources', 'additional_resources_url', 'official_vote_up', 'official_vote_down', 'official_vote_abstentions', 'voted_at');
			
			/*Votos posibles 0-501*/
			for($i=0; $i <= 501; $i++) $cvotes[] = $i;
			
			/*Invisible fields*/
			$crud->field_type('id_initiative', 'invisible');
			$crud->field_type('official_vote_up', 'dropdown', $cvotes);
			$crud->field_type('official_vote_down', 'dropdown', $cvotes);
			$crud->field_type('official_vote_abstentions', 'dropdown', $cvotes);
			
			/*Set displays*/
			$this->display_as_initiatives($crud);
			
			/*Set relations*/
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
		
			$crud->order_by('id_initiative','desc');
			$output = $crud->render();

			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud de usuarios*/
	public function users() {
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');	
		$crud->set_table('users');
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*obtener url de partido politco*/
	function urlPoliticalParty($value, $row) {
		return "<a href='".site_url('admin/political_parties/read/'.$row->id_political_party)."'>$value</a>";
	}	
	
	/*obtener url de legislatura*/
	function urlLegislature($value, $row) {
		return "<a href='".site_url('admin/legislatures/read/'.$row->id_legislature)."'>$value</a>";
	}
	
	/*obtener nombre unico de un campo*/
	function unique_field_name($field_name) {
		return 's'.substr(md5($field_name),0,8); //This s is because is better for a string to begin with a letter and not with a number
    }
    
	/*Genera slug*/
	function getSlug($post_array) {
		$post_array['slug'] = slug($post_array['name']);
		
		return $post_array;
	}
	
	/*Genera div del mapa*/
	function getMap($post_array) {
		return "<div id='map'></div>";
	}
	
	/*Genera div del mapa*/
	function getMap2($value) {
		return "<div id='map'></div><input id='field-latitude' type='hidden' name='longitude' value='$value'><input id='field-state' type='hidden' name='field-state' value='read'>";
	}
	
	/*Nombres en español de los campos*/
	public function display_as_initiatives($crud) {
		$crud->display_as('id_initiative', 'ID Iniciativa');
		$crud->display_as('title', 'Título');
		$crud->display_as('short_title', 'Título Corto');
		$crud->display_as('description', 'Descripción');
		$crud->display_as('presented_by', 'Presentada por');
		$crud->display_as('additional_resources', 'Recursos adicionales');
		$crud->display_as('additional_resources_url', 'Url de recursos adicionales');
		$crud->display_as('official_vote_up', 'Votos a favor');
		$crud->display_as('official_vote_down', 'Votos en contrar');
		$crud->display_as('official_vote_abstentions', 'Abstenciones');
		$crud->display_as('voted_at', 'Fecha votada');
		
		return true;
	}
	
	/*TODO - check users sessions, redirecto to main page*/
	public function index() {
		header('Location: /admin/political_parties');
		
		return false;
	}
	
	/*Prueba de multigrids*/
	public function multigrids2() {
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);
		
		$output1 = $this->users();
		$output2 = $this->initiatives();

		$js_files  = $output1->js_files + $output2->js_files;
		$css_files = $output1->css_files + $output2->css_files;
		$output    = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output;
		
		$this->_example_output((object)array (
			'js_files' => $js_files,
			'css_files' => $css_files,
			'output'	=> $output
		));
	}
}
