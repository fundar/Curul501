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
		
		set_time_limit(6000); 
		ini_set("memory_limit", -1);
		ini_set("session.cookie_lifetime", "14400");
		ini_set("session.gc_maxlifetime",  "14400");
		session_start();
	}
	
	/*para conectar el custom grocery con postgres*/
	public function new_crud() {
        $db_driver   = $this->db->platform();
        $model_name  = 'grocery_crud_model_' . $db_driver;
        $model_alias = 'm' . substr(md5(rand()), 0, rand(4,15));

        unset($this->{$model_name});
        $this->load->library('grocery_CRUD');
        $crud = new Grocery_CRUD();
        
        if(file_exists(APPPATH . '/models/' . $model_name . '.php')) {
            $this->load->model('grocery_crud_model');
            $this->load->model('grocery_crud_generic_model');
            $this->load->model($model_name,$model_alias);
            $crud->basic_model = $this->{$model_alias};
        }
        
        return $crud;
    }
    
	/*Salida de las vistas*/
	public function _example_output($output = null) {
		$this->load->view('admin.php', $output);
	}
	
	/*Comisiones*/
	public function commissions() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('commissions');
		$crud->set_subject('Comisiones');
		$crud->set_primary_key('id_commission');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_commission', 'name', 'created_at');
		$crud->fields('name', 'slug', 'commissions2representatives', 'created_at', 'status');
		
		/*Relacion Integrantes - comisiones*/
		$crud->set_relation_n_n('commissions2representatives', 'commissions2representatives', 'representatives', 'id_commission', 'id_representative', 'name');
		$crud->display_as('commissions2representatives', 'Integrantes');
			
		/*Nombres de campos*/	
		$crud->display_as('id_commission', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('created_at', 'Fecha de creación');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		$crud->callback_before_update(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Topic*/
	public function topics() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('topics');
		$crud->set_subject('Temas');
		$crud->set_primary_key('id_topic');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_topic', 'name');
		$crud->fields('name', 'description', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_topic', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('description', 'Descripción');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		$crud->callback_before_update(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Tags*/
	public function tags() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('tags');
		$crud->set_subject('Etiquetas');
		$crud->set_primary_key('id_tag');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_tag', 'name');
		$crud->fields('name', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_tag', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		$crud->callback_before_update(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Status*/
	public function status() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('status');
		$crud->set_subject('Estatus');
		$crud->set_primary_key('id_status');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_status', 'name');
		$crud->fields('name', 'slug', 'description');
		
		/*Nombres de campos*/	
		$crud->display_as('id_status', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('description', 'Descripción');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Partidos politicos*/
	public function political_parties() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('political_parties');
		$crud->set_subject('Partidos políticos');
		$crud->set_primary_key('id_political_party');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name', 'short_name', 'short_title', 'url_logo');
		$crud->columns('id_political_party', 'name', 'short_name', 'url_logo');
		$crud->fields('name', 'short_name', 'url_logo', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_political_party', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('short_name', 'Nombre corto');
		
		/*Set upload file Logo, Slug*/
		$crud->display_as('url_logo', 'Logo');
		$crud->set_field_upload('url_logo', 'assets/uploads/files');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		$crud->callback_before_update(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Legislaturas*/
	public function legislatures() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('legislatures');
		$crud->set_subject('Legislaturas');
		$crud->set_primary_key('id_legislature');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_legislature', 'name');
		$crud->fields('name', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('id_legislature', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Representantes*/
	public function representatives_scrapper() {
		try {
			$crud  = $this->new_crud();
			$state = $crud->getState();
			
			/*Tabla y título*/
			//$crud->set_theme('datatables');
			$crud->set_table('representatives_scrapper');
			$crud->set_subject('Diputados_Scrapper');
			$crud->set_primary_key('id_representative');
			
			/*Set requiered fields, columns and fields*/
			$crud->required_fields('name');
			$crud->columns('id_representative_type', 'full_name', 'id_political_party','email','id_legislature');
			
			$crud->unset_fields('full_name2');
			$crud->unset_fields('slug2');
			
			/*Relaciones*/
			$crud->set_primary_key('id_representative_type', 'representative_type');
			$crud->display_as('id_representative_type', 'Tipo de Representante');
			$crud->set_relation('id_representative_type', 'representative_type', 'name');
			
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Partido Político');
			$crud->set_relation('id_political_party', 'political_parties', 'name');
			
			$crud->set_primary_key('id_legislature', 'legislatures');
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
			
			/*Nombres de campos*/
			$crud->display_as('name', 'Nombres');
			$crud->display_as('last_name', 'Apellidos');
			$crud->display_as('full_name', 'Nombre completo');
			
			$crud->display_as('substitute', 'Suplente');
			$crud->display_as('election_type', 'Tipo de elección');
			
       		$crud->display_as('phone', 'Telefono');
			$crud->display_as('birth_state', 'Entidad de Nacimiento');
			$crud->display_as('birth_city', 'Ciudad de Nacimiento');
			$crud->display_as('zone_state', 'Entidad Representada');
			
			$crud->display_as('district', 'Distrito o Circunscripcion');
			$crud->display_as('circumscription', 'Circunscripcion');
			
			$crud->display_as('fecha_protesta', 'Fecha de Protesta');
			$crud->display_as('ubication', 'Ubicación');
			$crud->display_as('ultimo_grado_estudios', 'Ultimo Grado de Estudios');
			$crud->display_as('career', 'Preparacion Academica');
			$crud->display_as('commisions', 'Comisiones');
			$crud->display_as('exp_legislative', 'Experiencia Legislativa');
			$crud->display_as('suplentede', 'Suplente de:');
			
			/*Set upload file Avatar, slug*/
		    $crud->field_type('slug', 'invisible');
			$crud->set_field_upload('avatar_id', 'assets/uploads/files/');
			$crud->display_as('birthday', 'Cumpleaños');				
			
			/*Callbacks para obtener urls y slug*/
			$crud->callback_before_insert(array($this, 'getSlug2'));
			$crud->callback_before_update(array($this, 'getSlug2'));
			
			$output = $crud->render();
			
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud de iniciativas del Scrapping*/
	public function initiatives_scrapper() {
		try {
			$crud = $this->new_crud();
			$crud->set_theme('datatables');
			
			/*Tabla y título*/
			$crud->set_table('iniciativas_scrapper');
			$crud->set_subject('Iniciativa scrapper');
			$crud->set_primary_key('id_initiative');
			
			/*Columnas*/
			$crud->columns('id_initiative', 'id_legislature', 'titulo_listado', 'fecha_listado', 'periodo');
			$crud->unset_fields('id_parent');
			
			/*Relaciones*/
			$crud->display_as('ano', 'Año');
			
			/*Legislatura*/
			$crud->set_primary_key('id_legislature', 'legislatures');
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
			
			/*Relacion partidos politicos - iniciativas*/
			$crud->set_relation_n_n('initiative2political_party', 'initiative2political_party', 'political_parties', 'id_initiative', 'id_political_party', 'name');
			$crud->display_as('initiative2political_party', 'Partidos políticos');
			
			/*Relacion representantes - iniciativas*/
			$crud->set_relation_n_n('initiative2representatives', 'initiative2representatives', 'representatives_scrapper', 'id_initiative', 'id_representative', 'name');
			$crud->display_as('initiative2representatives', 'Representantes');
			
			/*Relacion Comisiones - iniciativas*/
			$crud->set_relation_n_n('commissions2initiatives', 'commissions2initiatives', 'commissions', 'id_initiative', 'id_commission', 'name');
			$crud->display_as('commissions2initiatives', 'Comisiones');
			
			/*Relacion topics - iniciativas*/
			$crud->set_relation_n_n('initiatives2topics', 'initiatives2topics', 'topics', 'id_initiative', 'id_topic', 'name');
			$crud->display_as('initiatives2topics', 'Temas');
			
			/*Relacion tags - iniciativas*/
			$crud->set_relation_n_n('initiatives2tags', 'initiatives2tags', 'tags', 'id_initiative', 'id_tag', 'name');
			$crud->display_as('initiatives2tags', 'Etiquetas');
			
			/*callback titulo*/
			$crud->callback_column('titulo_listado', array($this, 'getFullValue'));
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud para los estatus de las iniciativas del Scrapping*/
	public function estatus_iniciativas_scrapper() {
		try {
			$crud  = $this->new_crud();
			
			#no se pueden agregar
			$crud->unset_add();
			
			/*Tabla y título*/
			$crud->set_table('estatus_iniciativas_scrapper');
			$crud->set_subject('Estatus Iniciativa scrapper');
			$crud->set_primary_key('id_estatus');
			
			/*Columnas*/
			$crud->columns('id_estatus', 'id_iniciativa', 'titulo_limpio', 'tipo', 'votacion');
			
			/*Relaciones*/
			$crud->set_primary_key('id_iniciativa', 'iniciativas_scrapper');
			$crud->display_as('id_iniciativa', 'Iniciativa');
			$crud->set_relation('id_iniciativa', 'iniciativas_scrapper', 'titulo_listado');
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud de votaciones de las iniciativas del Scrapping*/
	public function votaciones_scrapper() {
		try {
			$crud  = $this->new_crud();
			
			#No se pueden agregar
			$crud->unset_add();
			
			/*Tabla y título*/
			$crud->set_table('votaciones_partidos_scrapper');
			$crud->set_subject('Votaciones scrapper');
			$crud->set_primary_key('id_voto');
			
			/*Columnas*/
			$crud->columns('id_voto', 'id_contador_voto', 'id_iniciativa', 'id_political_party', 'tipo', 'favor', 'contra', 'abstencion', "quorum", "ausente", "total");
			
			/*Relaciones*/
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Partido Político');
			$crud->set_relation('id_political_party', 'political_parties', 'name');
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud de los votos de representantes de las iniciativas del Scrapping*/
	public function votos_representantes() {
		try {
			$crud  = $this->new_crud();
			
			#No se pueden agregar
			$crud->unset_add();
			
			/*Tabla y título*/
			$crud->set_table('votaciones_representantes_scrapper');
			$crud->set_subject('Votos Representantes scrapper');
			$crud->set_primary_key('id_voto_representante');
			
			/*Columnas*/
			$crud->columns('id_voto_representante', 'id_contador_voto', 'id_iniciativa', 'id_political_party', 'id_representative', 'nombre', 'partido', 'tipo');
			
			/*Relaciones*/
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Partido Político');
			$crud->set_relation('id_political_party', 'political_parties', 'name');
			
			/*cambiar por representantes real / prueba con representrantes scrapping*/
			$crud->set_primary_key('id_representative', 'representatives_scrapper');
			$crud->display_as('id_representative', 'Representante');
			$crud->set_relation('id_representative', 'representatives_scrapper', 'full_name');
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*obtener url de partido politco*/
	function getFullValue($value, $row) {
		return $value;
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
	
	/*Genera slug 2*/
	function getSlug2($post_array) {
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
		$crud->display_as('id_initiative', 'ID');
		$crud->display_as('title', 'Título');
		$crud->display_as('short_title', 'Título Corto');
		$crud->display_as('description', 'Descripción');
		$crud->display_as('additional_resources', 'Contenido relacionado');
		$crud->display_as('official_vote_up', 'Votos a favor');
		$crud->display_as('official_vote_down', 'Votos en contrar');
		$crud->display_as('official_vote_abstentions', 'Abstenciones');
		$crud->display_as('voted_at', 'Fecha votada');
		
		return true;
	}
	
	/*isUser, si es usuario*/
	private function isUser($redirect = true, $admin = false) {
		if(isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			
			$this->load->model('curul501_model');
			$user = $this->curul501_model->getUser($_SESSION['user_id']);
			
			if($user) {
				if($admin) {
					if($user->type == "admin") {
						return $user;
					} else {
						if($redirect) {
							header('Location: ' . site_url('admin/initiatives'));
						}
						
						return false;
					}
				}
				
				return $user;
			} else {
				if($redirect) {
					header('Location: ' . site_url('admin/login'));
				}
				
				return false;
			}
		} else {
			if($redirect) {
				header('Location: ' . site_url('admin/login'));
			}
			
			return false;
		}
	}
	
	/*login de usuarios*/
	public function login() {
		if($this->isUser(false)) {
			header('Location: ' . site_url('admin/initiatives'));
		} else {
			$vars["error"] = false;
			
			if(isset($_POST["submit"])) {
				$this->load->model('curul501_model');
				$user = $this->curul501_model->isUser(trim(str_replace("'","",$_POST["email"])), md5($_POST["pwd"]));
				
				if($user) {
					if($user->type == "admin") {
						$_SESSION['admin'] = true;
					}
					
					$_SESSION['user_id'] = $user->id_user;
					$_SESSION['email']   = $user->email;
					
					header('Location: ' . site_url('admin/'));
				}
				
				$vars["error"] = "datos incorrectos";
			}
			
			$this->load->view('login.php', $vars);
		}
	}
	
	/*cerrar sesion*/
	public function logout() {
		session_unset(); 
		session_destroy();
		
		header('Location: ' . site_url('admin/login'));
	}
	
	/*Salida de las vista de bienvenida*/
	public function _welcome_output($output = null) {
		$this->load->view('welcome_message.php', $output);
	}
	
	/*index method*/
	public function index() {
		$user = $this->isUser();
		$this->_welcome_output();
	}
}
