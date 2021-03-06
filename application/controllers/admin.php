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
		
		$crud->unset_delete();
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('id_commission', 'name', 'created_at');
		$crud->fields('name', 'slug', 'commissions2representatives', 'created_at', 'status');
		
		/*Relacion Integrantes - comisiones*/
		$crud->set_relation_n_n('commissions2representatives', 'commissions2representatives', 'representatives_scrapper', 'id_commission', 'id_representative', 'full_name');
		$crud->display_as('commissions2representatives', 'Integrantes');
			
		/*Nombres de campos*/	
		$crud->display_as('id_commission', 'ID');
		$crud->display_as('full_name', 'Nombre');
		$crud->display_as('created_at', 'Fecha de creación');
		$crud->field_type('slug', 'invisible');
		
		/*Revisada*/
		$crud->field_type('status', 'dropdown', array(true => 'Activa', false => 'Inactiva'));
			
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
	
	/*Dependencies*/
	public function dependencies() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('dependencies');
		$crud->set_subject('Dependencias');
		$crud->set_primary_key('id_dependency');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('name');
		$crud->columns('name');
		$crud->fields('name', 'slug');
		
		/*Nombres de campos*/	
		$crud->display_as('name', 'Nombre');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		$crud->callback_before_update(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	/*Partidos politicos*/
	public function political_parties() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		//$crud->set_theme('datatables');
		$crud->set_table('political_parties');
		$crud->set_subject('Grupos parlamentarios');
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
			$crud->set_theme('datatables');
			$crud->set_table('representatives_scrapper');
			$crud->set_subject('Representantes');
			$crud->set_primary_key('id_representative');
			
			/*Set requiered fields, columns and fields*/
			$crud->required_fields('name');
			$crud->columns('id_representative','id_legislature', 'full_name', 'id_political_party', 'zone_state', 'district', 'circumscription', 'twitter', 'email', 'phone', 'ubication');
			$crud->unset_fields('id_representative', 'full_name2', 'slug2', 'status', 'district_clean', 'publicada', 'trayectoria', 'created_at', 'updated_at', 'commisions');
			
			$crud->display_as('id_representative', '#Representante');
			
			/*Relacion Comisiones - representantes*/
			$crud->set_relation_n_n('commissions2representatives', 'commissions2representatives', 'commissions', 'id_representative', 'id_commission', 'name');
			$crud->display_as('commissions2representatives', 'Comisiones');
			
			/*custom action - publish*/
			$crud->add_action('Publicar', '', '','ui-icon-plus',array($this, 'getUrlPublishRepresentative'));
			
			/*Relaciones*/
			$crud->set_primary_key('id_representative_type', 'representative_type');
			$crud->display_as('id_representative_type', 'Tipo de Representante');
			$crud->set_relation('id_representative_type', 'representative_type', 'name');
			
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Grupo parlamentario');
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
			
			$crud->display_as('district', 'Distrito');
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
	
	/*Crud de iniciativas del Scrapping - Revisadas*/
	public function initiatives_scrapper_true() {
		try {
			$crud = $this->new_crud();
			$crud->set_theme('datatables');
			
			$crud->where('revisada', "t");
			
			/*Tabla y título*/
			$crud->set_table('iniciativas_scrapper');
			$crud->set_subject('Iniciativa scrapper');
			$crud->set_primary_key('id_initiative');
			
			/*Columnas*/
			$crud->columns('id_initiative', 'titulo_listado', 'titulo', 'presentada', 'fecha_listado_tm', 'commissions2initiatives', 'publicada');
			$crud->fields('id_legislature', 'titulo_listado', 'fecha_listado_tm', 'enlace_gaceta', 'titulo', 'resumen', 'initiatives2topics', 'initiative2representatives', 'commissions2initiatives', 'initiative2political_party', 'initiative2dependencies', 'fecha_votacion_tm', 'numero_iniciativa', 'enlace_dictamen_listado', 'enlace_publicado_listado', 'html_listado', 'contenido_html_iniciativa', 'enviada', 'turnada', 'presentada', 'periodo', 'ano', 'revisada', 'publicada');
			
			$crud->field_type('html_listado', 'readonly');
			$crud->field_type('enviada', 'readonly');
			$crud->field_type('turnada', 'readonly');
			$crud->field_type('presentada', 'readonly');
			$crud->field_type('periodo', 'readonly');
			$crud->field_type('ano', 'readonly');
			
			/*custom action - publish*/
			$crud->add_action('Publicar', '', '','ui-icon-plus',array($this, 'getUrlPublish'));
			
			/*Enlace gaceta*/
			$crud->callback_edit_field('enlace_gaceta',array($this,'enlace_gaceta'));
			
			/*Relaciones y displays*/
			$crud->display_as('id_initiative', '#Iniciativa');
			$crud->display_as('numero_iniciativa', 'Numero iniciativa Gaceta');
			$crud->display_as('ano', 'Año');
			
			/*Legislatura*/
			$crud->set_primary_key('id_legislature', 'legislatures');
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
			
			/*Relacion partidos politicos - iniciativas*/
			$crud->set_relation_n_n('initiative2political_party', 'initiative2political_party', 'political_parties', 'id_initiative', 'id_political_party', 'name');
			$crud->display_as('initiative2political_party', 'Presentada por los partidos políticos');
			
			/*Relacion representantes - iniciativas*/
			$crud->set_relation_n_n('initiative2representatives', 'initiative2representatives', 'representatives_scrapper', 'id_initiative', 'id_representative', 'full_name');
			$crud->display_as('initiative2representatives', 'Presentada por los representantes');
			
			/*Relacion dependencias - iniciativas*/
			$crud->set_relation_n_n('initiative2dependencies', 'initiative2dependencies', 'dependencies', 'id_initiative', 'id_dependency', 'name');
			$crud->display_as('initiative2dependencies', 'Presentada por las dependencias');
			
			/*Relacion Comisiones - iniciativas*/
			$crud->set_relation_n_n('commissions2initiatives', 'commissions2initiatives', 'commissions', 'id_initiative', 'id_commission', 'name');
			$crud->display_as('commissions2initiatives', 'Comisiones');
			
			/*Relacion topics - iniciativas*/
			$crud->set_relation_n_n('initiatives2topics', 'initiatives2topics', 'topics', 'id_initiative', 'id_topic', 'name');
			$crud->display_as('initiatives2topics', 'Temas');
			
			/*Revisada*/
			$crud->field_type('revisada', 'dropdown', array("t" => 'Si', "f" => 'No'));
			$crud->field_type('publicada', 'dropdown', array("t" => 'Si', "f" => 'No'));
			
			/*callback titulo*/
			$crud->field_type('slug', 'invisible');
			$crud->callback_column('titulo_listado', array($this, 'getFullValue'));
			
			/*required fields*/
			$crud->required_fields('titulo', 'resumen', 'initiatives2topics');
			
			$crud->callback_column('commissions2initiatives', array($this, 'cleanText'));
			$crud->callback_column('initiatives2topics', array($this, 'cleanText'));
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			die(var_dump($e));
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	/*Crud de iniciativas del Scrapping - No revisadas*/
	public function initiatives_scrapper_false() {
		try {
			$crud = $this->new_crud();
			$crud->set_theme('datatables');
			
			$crud->where('revisada', "f");
			
			/*Tabla y título*/
			$crud->set_table('iniciativas_scrapper');
			$crud->set_subject('Iniciativa scrapper');
			$crud->set_primary_key('id_initiative');
			
			/*Columnas*/
			$crud->columns('id_initiative', 'titulo_listado', 'titulo', 'presentada', 'fecha_listado_tm', 'commissions2initiatives');
			$crud->fields('id_legislature', 'titulo_listado', 'fecha_listado_tm', 'enlace_gaceta', 'titulo', 'resumen', 'initiatives2topics', 'initiative2representatives', 'commissions2initiatives', 'initiative2political_party', 'initiative2dependencies', 'fecha_votacion_tm', 'numero_iniciativa', 'enlace_dictamen_listado', 'enlace_publicado_listado', 'html_listado', 'contenido_html_iniciativa', 'enviada', 'turnada', 'presentada', 'periodo', 'ano', 'revisada');
			
			$crud->field_type('html_listado', 'readonly');
			$crud->field_type('enviada', 'readonly');
			$crud->field_type('turnada', 'readonly');
			$crud->field_type('presentada', 'readonly');
			$crud->field_type('periodo', 'readonly');
			$crud->field_type('ano', 'readonly');
			
			/*Enlace gaceta*/
			$crud->callback_edit_field('enlace_gaceta',array($this,'enlace_gaceta'));
			
			/*Relaciones y displays*/
			$crud->display_as('id_initiative', '#Iniciativa');
			$crud->display_as('numero_iniciativa', 'Numero iniciativa Gaceta');
			$crud->display_as('ano', 'Año');
			
			/*Legislatura*/
			$crud->set_primary_key('id_legislature', 'legislatures');
			$crud->display_as('id_legislature', 'Legislatura');
			$crud->set_relation('id_legislature', 'legislatures', 'name');
			
			/*Relacion partidos politicos - iniciativas*/
			$crud->set_relation_n_n('initiative2political_party', 'initiative2political_party', 'political_parties', 'id_initiative', 'id_political_party', 'name');
			$crud->display_as('initiative2political_party', 'Presentada por los partidos políticos');
			
			/*Relacion representantes - iniciativas*/
			$crud->set_relation_n_n('initiative2representatives', 'initiative2representatives', 'representatives_scrapper', 'id_initiative', 'id_representative', 'full_name');
			$crud->display_as('initiative2representatives', 'Presentada por los representantes');
			
			/*Relacion dependencias - iniciativas*/
			$crud->set_relation_n_n('initiative2dependencies', 'initiative2dependencies', 'dependencies', 'id_initiative', 'id_dependency', 'name');
			$crud->display_as('initiative2dependencies', 'Presentada por las dependencias');
			
			/*Relacion Comisiones - iniciativas*/
			$crud->set_relation_n_n('commissions2initiatives', 'commissions2initiatives', 'commissions', 'id_initiative', 'id_commission', 'name');
			$crud->display_as('commissions2initiatives', 'Comisiones');
			
			/*Relacion topics - iniciativas*/
			$crud->set_relation_n_n('initiatives2topics', 'initiatives2topics', 'topics', 'id_initiative', 'id_topic', 'name');
			$crud->display_as('initiatives2topics', 'Temas');
			
			/*Slug*/
			$crud->field_type('slug', 'invisible');
			
			/*Callbacks para obtener urls y slug*/
			$crud->field_type('revisada', 'dropdown', array("t" => 'Si', "f" => 'No'));
		
			/*required fields*/
			$crud->required_fields('titulo', 'resumen', 'initiatives2topics');
			
			/*callback titulo*/
			$crud->callback_before_update(array($this, 'getSlugTitle'));
			$crud->callback_column('titulo_listado', array($this, 'getFullValue'));
			$crud->callback_column('commissions2initiatives', array($this, 'cleanText'));
			$crud->callback_column('initiatives2topics', array($this, 'cleanText'));
			
			$output = $crud->render();
			$this->_example_output($output);
		} catch(Exception $e) {
			die(var_dump($e));
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	function enlace_gaceta($value, $primary_key) {
		return '<a href="' . $value . '" title="Enlace gaceta" target="_blank">' . $value . '</a>';
	}

	/*Metodo para publicar una iniciativa en WP*/
	public function publish($id_initiative = false) {
		if($id_initiative and is_numeric($id_initiative)) {
			/*get initiative*/
			$this->load->model('curul501_model');
			$initiative = $this->curul501_model->getInitiative($id_initiative, "publicada=false");
			
			if($initiative) {
				/*presentada por [representantes, partidos politicos y dependencias]*/
				$presentada["representatives"]  = $this->curul501_model->byRepresentatives($id_initiative);
				$presentada["dependencies"]		= $this->curul501_model->byDependencies($id_initiative);
				$presentada["politicalparties"] = $this->curul501_model->byPoliticalParties($id_initiative);
				
				/*presentada*/
				$string_presentada		= "";
				$string_presentada_slug = "";
				
				if($presentada["representatives"] and is_array($presentada["representatives"])) {
					foreach($presentada["representatives"] as $value) {
						$string_presentada 		.= $value["full_name"] . "|";
						$string_presentada_slug .= $value["slug"] . "|";
					}
				}
				
				$string_presentada_dependencias	  	 = "";
				$string_presentada_dependencias_slug = "";
				
				if($presentada["dependencies"] and is_array($presentada["dependencies"])) {
					foreach($presentada["dependencies"] as $value) {
						$string_presentada_dependencias 	 .= $value["name"] . "|";
						$string_presentada_dependencias_slug .= $value["slug"] . "|";
					}
				}
				
				$string_presentada_partidos	  = "";
				$string_presentada_partidos_slug = "";
				
				if($presentada["politicalparties"] and is_array($presentada["politicalparties"])) {
					foreach($presentada["politicalparties"] as $value) {
						$string_presentada_partidos 		.= $value["name"] . "|";
						$string_presentada_partidos_slug .= $value["slug"] . "|";
					}
				}
				
				$string_presentada 		= rtrim($string_presentada, "|");
				$string_presentada_slug = rtrim($string_presentada_slug, "|");
				
				$string_presentada_dependencias 	 = rtrim($string_presentada_dependencias, "|");
				$string_presentada_dependencias_slug = rtrim($string_presentada_dependencias_slug, "|");
				
				$string_presentada_partidos 	 = rtrim($string_presentada_partidos, "|");
				$string_presentada_partidos_slug = rtrim($string_presentada_partidos_slug, "|");
				
				/*get topics, status & commissions*/
				$topics 	 = $this->curul501_model->getTopicsByInitiative($id_initiative);
				$commissions = $this->curul501_model->getCommissionsByInitiative($id_initiative);
				$status		 = $this->curul501_model->getStatusInitiative($id_initiative);
				$lastStatus	 = $this->curul501_model->getLastStatusInitiative($id_initiative);
				$votos		 = json_encode($this->curul501_model->getVotesPoliticalParties($id_initiative), JSON_NUMERIC_CHECK);
				
				if($votos == "false") {
					$votos				  = "";
					$votesRepresentatives = "";
				} else {
					$votesRepresentatives = json_encode($this->curul501_model->getVotesRepresentatives($id_initiative), JSON_NUMERIC_CHECK);	
				}
				
				/*topic*/
				$string_topics		= "";
				$string_topics_slug = "";
				if($topics and is_array($topics)) {
					foreach($topics as $topic) {
						$string_topics 		.= $topic["name"] . "|";
						$string_topics_slug .= $topic["slug"] . "|";
					}
				}
				$string_topics 		= rtrim($string_topics, "|");
				$string_topics_slug = rtrim($string_topics_slug, "|");
				
				/*status*/
				$string_status		= "";
				$string_status_slug = "";
				if($status and is_array($status)) {
					foreach($status as $value) {
						$string_status 		.= $value["tipo"] . "|";
						$string_status_slug .= $value["slug"] . "|";
					}
				}
				$string_status 		= rtrim($string_status, "|");
				$string_status_slug = rtrim($string_status_slug, "|");
				
				/*commissions*/
				$string_commissions 	 = "";
				$string_commissions_slug = "";
				if($commissions and is_array($commissions)) {
					foreach($commissions as $commission) {
						$string_commissions 	 .= $commission["name"] . "|";
						$string_commissions_slug .= $commission["slug"] . "|";
					}
				}
				$string_commissions 	 = rtrim($string_commissions, "|");
				$string_commissions_slug = rtrim($string_commissions_slug, "|");
				
				/*include configs  & create instance*/
				require("xmlrpc/config/config.php");
				require("xmlrpc/IXR_Library.php");
				$client = new IXR_Client($config["url"]);
				
				/*insert post into WP*/
				$content['title']         = $initiative["titulo"];
				$content['description']   = $initiative["resumen"];
				$content['categories']    = explode("|", $string_topics);
				$content['mt_keywords']   = explode("|", $string_topics);
				$content['custom_fields'] = array(
					array('key' => 'wp_id_initiative',	   'value' => $id_initiative),
					array('key' => 'wp_titulo', 		   'value' => $initiative["titulo"]),
					array('key' => 'wp_slug', 		       'value' => $initiative["slug"]),
					array('key' => 'wp_titulo_listado',    'value' => $initiative["titulo_listado"]),
					array('key' => 'wp_fecha_listado_tm',  'value' => $initiative["fecha_listado_tm"]),
					array('key' => 'wp_fecha_votacion_tm', 'value' => $initiative["fecha_votacion_tm"]),
					array('key' => 'wp_enlace_gaceta',	   'value' => $initiative["enlace_gaceta"]),
					array('key' => 'wp_enlace_dictamen_listado',  'value' => $initiative["enlace_dictamen_listado"]),
					array('key' => 'wp_enlace_publicado_listado', 'value' => $initiative["enlace_publicado_listado"]),
					array('key' => 'wp_topics', 		   'value' => $string_topics),
					array('key' => 'wp_topics_slug',	   'value' => $string_topics_slug),
					array('key' => 'wp_commissions',	   'value' => $string_commissions),
					array('key' => 'wp_commissions_slug',  'value' => $string_commissions_slug),
					array('key' => 'wp_presentada',	  	   'value' => $string_presentada),
					array('key' => 'wp_presentada_slug',   'value' => $string_presentada_slug),
					array('key' => 'wp_presentada_dependencias',	  'value' => $string_presentada_dependencias),
					array('key' => 'wp_presentada_dependencias_slug', 'value' => $string_presentada_dependencias_slug),
					array('key' => 'wp_presentada_partidos',	  	  'value' => $string_presentada_partidos),
					array('key' => 'wp_presentada_partidos_slug',     'value' => $string_presentada_partidos_slug),
					array('key' => 'wp_votos',						'value' => $votos),
					array('key' => 'wp_votos_representantes',		'value' => $votesRepresentatives),
					array('key' => 'wp_last_status',		  	   'value' => $lastStatus["tipo"]),
					array('key' => 'wp_last_status_slug',		   'value' => $lastStatus["slug"]),
					array('key' => 'wp_tipo_camara',		   'value' => 1),
					array('key' => 'wp_status',		  	   'value' => $string_status),
					array('key' => 'wp_status_slug', 	   'value' => $string_status_slug)
				);
				
				if(!$client->query('metaWeblog.newPost', '', $config["user"], $config["pass"], $content, true))  {
					$response["error"] = 'Error mientras se creaba el post ' . $client->getErrorCode() . " : " . $client->getErrorMessage();
				} else {
					/*get ID*/
					$ID = $client->getResponse();
					
					if($ID) {
						/*update publicada*/
						//$this->curul501_model->setPublish($id_initiative);
						
						/*set Initiative 2 Post*/
						//$this->curul501_model->setInitiative2Post($id_initiative, $ID);
						
						$response["success"] = true;
						$response["ID"]      = $ID;
						$response["titulo"]  = $initiative["titulo"];
						
						
					} else {
						$response["error"] = 'Error al insertar el registro';
					}
				}
			} else {
				$response["error"] = 'No se encuentra el registro o ya esta publicado';
			}
		} else {
			$response["error"] = 'Error al insertar el registro';
		}
		
		$this->load->view('publish_wp.php', $response);
	}
	
	/*obtiene la url para publicar iniciativas en wp*/
	function getUrlPublish($primary_key, $row) {
		return site_url('admin/publish') . '/' . $row->id_initiative;
	}
	
	/*Metodo para publicar representantes en WP*/
	public function publishRepresentative($id_representative = false) {
		if($id_representative and is_numeric($id_representative)) {
			/*get representative*/
			$this->load->model('curul501_model');
			$representative = $this->curul501_model->getRepresentative($id_representative, "publicada=false");
			
			if($representative) {
				$politicalParty = $this->curul501_model->getPoliticalParty($representative["id_political_party"]);
				
				/*include configs  & create instance*/
				require("xmlrpc/config/config.php");
				require("xmlrpc/IXR_Library.php");
				$client = new IXR_Client($config["url"]);
				
				/*File upload*/
				$fs   = filesize ('assets/uploads/files/' . $representative["avatar_id"]);
				$file = fopen ('assets/uploads/files/' . $representative["avatar_id"], 'rb');
				$data = fread ($file, $fs);
				fclose ($file);
				
				$content = array(
					'name' => $representative["avatar_id"],
					'type' => 'image/jpeg',
					'bits' => new IXR_Base64($data)
				);
				
				if(!$client->query('metaWeblog.newMediaObject', '', $config["user"], $config["pass"], $content, true))  {
					$dataFile['id']  = "";
					$dataFile['url'] = "";
				} else {
					$dataFile = $client->getResponse();
				}
				
				/*commissions*/
				$commissions = $this->curul501_model->getCommissionsByRepresentative($id_representative);
				
				$string_commissions 	 = "";
				$string_commissions_slug = "";
				if($commissions and is_array($commissions)) {
					foreach($commissions as $commission) {
						$string_commissions 	 .= $commission["name"] . "|";
						$string_commissions_slug .= $commission["slug"] . "|";
					}
				}
				$string_commissions 	 = rtrim($string_commissions, "|");
				$string_commissions_slug = rtrim($string_commissions_slug, "|");
				
				/*Resume*/
				$resume = json_encode($this->curul501_model->getResumeByRepresentative($id_representative), JSON_NUMERIC_CHECK);
				
				/*insert post into WP*/
				$content['title']          = $representative["full_name"];
				$content['description']    = "";
				$content['custom_fields'] = array(
					array('key' => 'wp_id_representative',  'value' => $id_representative),
					array('key' => 'wp_id_political_party', 'value' => $representative["id_political_party"]),
					array('key' => 'wp_political_party_name', 'value' => $politicalParty["name"]),
					array('key' => 'wp_political_party_slug', 'value' => $politicalParty["slug"]),
					array('key' => 'wp_political_party_short_name', 'value' => $politicalParty["short_name"]),
					array('key' => 'wp_id_representative_type', 'value' => $representative["id_representative_type"]),
					array('key' => 'wp_type',				'value' => $representative["type"]),
					array('key' => 'wp_slug', 		        'value' => $representative["slug"]),
					array('key' => 'wp_full_name',			'value' => $representative["full_name"]),
					array('key' => 'avatar_id'	,			'value' => $dataFile["id"]),
					array('key' => 'avatar_url',			'value' => $dataFile["url"]),
					array('key' => 'wp_email',    		    'value' => $representative["email"]),
					array('key' => 'wp_phone',  			'value' => $representative["phone"]),
					array('key' => 'wp_twitter',  			'value' => $representative["twitter"]),
					array('key' => 'wp_facebook',  			'value' => $representative["facebook"]),
					array('key' => 'wp_website',  			'value' => $representative["website"]),
					array('key' => 'wp_birthday', 			'value' => $representative["birthday"]),
					array('key' => 'wp_birth_state', 		'value' => $representative["birth_state"]),
					array('key' => 'wp_birth_city', 		'value' => $representative["birth_city"]),
					array('key' => 'wp_election_type', 		'value' => $representative["election_type"]),
					array('key' => 'wp_zone_state', 		'value' => $representative["zone_state"]),
					array('key' => 'wp_district', 			'value' => $representative["district"]),
					array('key' => 'wp_district_clean', 	'value' => $representative["district_clean"]),
					array('key' => 'wp_circumscription', 	'value' => trim($representative["circumscription"])),
					array('key' => 'wp_fecha_protesta', 	'value' => $representative["fecha_protesta"]),
					array('key' => 'wp_ubication', 			'value' => $representative["ubication"]),
					array('key' => 'wp_substitute', 		'value' => $representative["substitute"]),
					array('key' => 'wp_suplentede', 		'value' => $representative["suplentede"]),
					array('key' => 'wp_resume', 			'value' => $resume),
					array('key' => 'wp_clave_estado', 			'value' => $representative["clave_estado"]),
					array('key' => 'wp_ultimo_grado_estudios',	'value' => $representative["ultimo_grado_estudios"]),
					array('key' => 'wp_commissions',	   		'value' => $string_commissions),
					array('key' => 'wp_commissions_slug',  		'value' => $string_commissions_slug)
				);
				
				if(!$client->query('metaWeblog.newPost', '', $config["user"], $config["pass"], $content, true))  {
					$response["error"] = 'Error mientras se creaba el post ' . $client->getErrorCode() . " : " . $client->getErrorMessage();
				} else {
					/*get ID*/
					$ID = $client->getResponse();
					
					if($ID) {
						/*update publicada*/
						$this->curul501_model->setPublishRepresentative($id_representative);
						
						/*set Representative 2 Post*/
						$this->curul501_model->setRepresentative2Post($id_representative, $ID);
						
						$response["success"]   = true;
						$response["ID"]        = $ID;
						$response["full_name"] = $representative["full_name"];
					} else {
						$response["error"] = 'Error al insertar el registro';
					}
				}
			} else {
				$response["error"] = 'No se encuentra el registro o ya esta publicado';
			}
		} else {
			$response["error"] = 'Error al insertar el registro';
		}
		
		$this->load->view('publish_representative_wp.php', $response);
	}
	
	/*obtiene la url para publicar representantes en wp*/
	function getUrlPublishRepresentative($primary_key, $row) {
		return site_url('admin/publishRepresentative') . '/' . $row->id_representative;
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
			$crud->columns('id_estatus', 'id_initiative', 'titulo_limpio', 'tipo', 'votacion');
			
			/*Relaciones*/
			$crud->set_primary_key('id_initiative', 'iniciativas_scrapper');
			$crud->display_as('id_initiative', 'Iniciativa');
			$crud->set_relation('id_initiative', 'iniciativas_scrapper', 'titulo_listado');
			
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
			$crud->columns('id_voto', 'id_contador_voto', 'id_initiative', 'id_political_party', 'tipo', 'favor', 'contra', 'abstencion', "quorum", "ausente", "total");
			
			/*Relaciones*/
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Grupo parlamentario');
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
			$crud->columns('id_voto_representante', 'id_contador_voto', 'id_initiative', 'id_political_party', 'id_representative', 'nombre', 'tipo');
			
			/*Relaciones*/
			$crud->set_primary_key('id_political_party', 'political_parties');
			$crud->display_as('id_political_party', 'Grupo parlamentario');
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
	
	/*Representantes repetidos*/
	public function representative_repeat() {
		$crud  = $this->new_crud();
		
		/*Tabla y título*/
		$crud->set_table('representative_repeat');
		$crud->set_subject('Similutudes Representes');
		$crud->set_primary_key('id_repeat');
		
		/*Set requiered fields, columns and fields*/
		$crud->columns('id_representative', 'name');
		$crud->required_fields('id_representative', 'name');
		$crud->unset_fields('id_repeat');
		
		/*Nombres de campos*/	
		$crud->display_as('name', 'Nombre');
		$crud->set_primary_key('id_representative', 'representatives_scrapper');
		$crud->display_as('id_representative', 'Representante');
		$crud->set_relation('id_representative', 'representatives_scrapper', 'full_name');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'updateRepresentatives'));
		
		$output = $crud->render();
		$this->_example_output($output);
	}
	
	/*Actualiza representantes en votos y comisiones*/
	function updateRepresentatives($post_array) {
		
		$this->load->model('curul501_model');
		$result = $this->curul501_model->updateRepresentatives($post_array["id_representative"], $post_array["name"]);
		
		return $post_array;
	}
	
	/*obtener el texto limpio (solo en las relaciones n_n)*/
	function cleanText($value, $row) {
		$array_replace = array('{', '}', '"');
		$value = str_replace($array_replace, '', $value);
		
		return str_replace(',', ', ', $value);
	}
	
	/*obtener el valor completo*/
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
	
	/*Genera slug por titulo*/
	function getSlugTitle($post_array) {
		$post_array['slug'] = slug($post_array['titulo']);
		
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
							header('Location: ' . site_url('admin/'));
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
			header('Location: ' . site_url('admin/'));
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
	
	/*metodo para arreglar fechas*/
	public function fixDates() {
		$this->load->model('curul501_model');
		$result = $this->curul501_model->fixDates();
	}
	
	/*metodo para arreglar slug de estatus*/
	public function fixSlugStatus() {
		$this->load->model('curul501_model');
		$result = $this->curul501_model->fixSlugStatus();
	}
	
	/*metodo para arreglar slug de estatus*/
	public function fixSlugRepresentatives() {
		$this->load->model('curul501_model');
		$result = $this->curul501_model->fixSlugRepresentatives();
	}
	
	/*metodo para obtener las comissiones*/
	/*
	public function getCommissions() {
		$this->load->model('curul501_model');
		$results = $this->curul501_model->getCommissions();
		
		die(var_dump($results));
	}
	*/
}
