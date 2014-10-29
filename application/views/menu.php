<div>
	<a href="<?php echo site_url('admin/representatives_scrapper')?>">
		<?php if($this->uri->segment(2) == "representatives_scrapper") { ?><strong>Representantes</strong><?php } else { ?>Representantes<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/initiatives_scrapper_true')?>">
		<?php if($this->uri->segment(2) == "initiatives_scrapper_true") { ?><strong>Iniciatvas Revisadas</strong><?php } else { ?>Iniciatvas Revisadas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/initiatives_scrapper_false')?>">
		<?php if($this->uri->segment(2) == "initiatives_scrapper_false") { ?><strong>Iniciatvas NO Revisadas</strong><?php } else { ?>Iniciatvas NO Revisadas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/votaciones_scrapper')?>">
		<?php if($this->uri->segment(2) == "votaciones_scrapper") { ?><strong>Votaciones</strong><?php } else { ?>Votaciones<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/votos_representantes')?>">
		<?php if($this->uri->segment(2) == "votos_representantes") { ?><strong>Votos Representantes</strong><?php } else { ?>Votos Representantes<?php } ?>
	</a> |
		<a href="<?php echo site_url('admin/representative_repeat')?>">
		<?php if($this->uri->segment(2) == "representative_repeat") { ?><strong>Representantes similares</strong><?php } else { ?>Representantes similares<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/political_parties')?>">
		<?php if($this->uri->segment(2) == "political_parties") { ?><strong>Grupos parlamentarios</strong><?php } else { ?>Grupos parlamentarios<?php } ?>
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
	<a href="<?php echo site_url('admin/dependencies')?>">
		<?php if($this->uri->segment(2) == "dependencies") { ?><strong>Dependencias</strong><?php } else { ?>Dependencias<?php } ?>
	</a> |
	<?php if(isset($_SESSION['user_id'])) { ?>
		<a href="<?php echo site_url('admin/logout')?>">Cerrar sesión</a>
	<?php } ?>
</div>
