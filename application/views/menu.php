<div>
	<a href="<?php echo site_url('admin/initiatives')?>">
		<?php if($this->uri->segment(2) == "initiatives") { ?><strong>Iniciativas</strong><?php } else { ?>Iniciativas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/representatives')?>">
		<?php if($this->uri->segment(2) == "representatives") { ?><strong>Representantes</strong><?php } else { ?>Representantes<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/representatives_scrapper')?>">
		<?php if($this->uri->segment(2) == "representatives_scrapper") { ?><strong>Representantes_scrapper</strong><?php } else { ?>Representantes_scrapper<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/initiatives_scrapper')?>">
		<?php if($this->uri->segment(2) == "initiatives_scrapper") { ?><strong>Iniciatvas scrapper</strong><?php } else { ?>Iniciatvas scrapper<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/votaciones_scrapper')?>">
		<?php if($this->uri->segment(2) == "votaciones_scrapper") { ?><strong>Votaciones scrapper</strong><?php } else { ?>Votaciones scrapper<?php } ?>
	</a> |
	
	
	<a href="<?php echo site_url('admin/political_parties')?>">
		<?php if($this->uri->segment(2) == "political_parties") { ?><strong>Partidos políticos</strong><?php } else { ?>Partidos políticos<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/legislatures')?>">
		<?php if($this->uri->segment(2) == "legislatures") { ?><strong>Legislaturas</strong><?php } else { ?>Legislaturas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/commissions')?>">
		<?php if($this->uri->segment(2) == "commissions") { ?><strong>Comisiones</strong><?php } else { ?>Comisiones<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/topics')?>">
		<?php if($this->uri->segment(2) == "topics") { ?><strong>Temas</strong><?php } else { ?>Temas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/tags')?>">
		<?php if($this->uri->segment(2) == "tags") { ?><strong>Etiquetas</strong><?php } else { ?>Etiquetas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/status')?>">
		<?php if($this->uri->segment(2) == "status") { ?><strong>Estatus</strong><?php } else { ?>Estatus<?php } ?>
	</a> |
	<?php if(isset($_SESSION['user_id'])) { ?>
		<a href="<?php echo site_url('admin/logout')?>">Cerrar sesión</a>
	<?php } ?>
	
	<span class="link" id="ver-catalogos"></span>
</div>
