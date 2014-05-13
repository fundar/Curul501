<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		
		//Helpers
		$this->load->helper('url');
		$this->load->helper('slug');
		$this->load->helper('date');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null) {
		$this->load->view('example.php', $output);
	}
	
	/* TO-DO
	Falta agregar slugs en base de datos, partidos politicos,
	legislaturas, agregar un función para agregar slugs y  fechas de creación con
	callback_before_insert
	*/
	
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
	public function representatives() {
		$crud = new grocery_CRUD();
		
		/*Tabla y título*/
		$crud->set_theme('datatables');
		$crud->set_table('representatives');
		$crud->set_subject('Representantes');
		
		/*Set requiered fields, columns and fields*/
		$crud->required_fields('id_political_party', 'id_legislature', 'name');
		$crud->columns('id_representative', 'id_political_party', 'id_legislature', 'name', 'slug', 'avatar', 'birthday', 'twitter', 'facebook', 'district', 'phone', 'email');
		$crud->fields('id_political_party', 'id_legislature', 'name', 'slug', 'avatar', 'biography', 'birthday', 'twitter', 'facebook', 'district', 'phone', 'email', 'substitute', 'eleccion_type', 'circumscription', 'latitude', 'longitude');
		
		/*Nombres de campos*/	
		$crud->display_as('id_representative', 'ID');
		$crud->display_as('name', 'Nombre');
		$crud->display_as('biography', 'Biografia');
		$crud->display_as('district', 'Distrito');
		$crud->display_as('substitute', 'Sustituto');
		$crud->display_as('eleccion_type', 'Tipo de elección');
		$crud->display_as('circumscription', 'Cirscuncipcion');
		
		$crud->display_as('id_political_party', 'Partido Político');
		$crud->set_relation('id_political_party', 'political_parties', 'name');
		
		$crud->display_as('id_legislature', 'Legislatura');
		$crud->set_relation('id_legislature', 'legislatures', 'name');
		
		$crud->display_as('birthday', 'Cumpleaños');
		$crud->field_type('birthday', 'date');
		
		/*Set upload file Avatar & Slug*/
		$crud->set_field_upload('avatar', 'assets/uploads/files');
		$crud->field_type('slug', 'invisible');
		
		/*Callback Slug*/
		$crud->callback_before_insert(array($this, 'getSlug'));
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
	
	/*Genera slug y fecha*/
	function getSlug($post_array) {
		$post_array['slug'] = slug($post_array['name']);
		
		return $post_array;
	}
	
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
	
	public function users() {
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');	
		$crud->set_table('users');
		
		$output = $crud->render();
		
		if($crud->getState() == 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}
	
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

			if($crud->getState() == 'list') {
				$this->_example_output($output);
			} else {
				return $output;
			}
		} catch(Exception $e) {
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
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

	public function index() {
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{

		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}
