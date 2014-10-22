<div>
	<a href="<?php echo site_url('admin/representatives_scrapper')?>">
		<?php if($this->uri->segment(2) == "representatives_scrapper") { ?><strong>Representantes</strong><?php } else { ?>Representantes<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/initiatives_scrapper')?>">
		<?php if($this->uri->segment(2) == "initiatives_scrapper") { ?><strong>Iniciatvas</strong><?php } else { ?>Iniciatvas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/votaciones_scrapper')?>">
		<?php if($this->uri->segment(2) == "votaciones_scrapper") { ?><strong>Votaciones</strong><?php } else { ?>Votaciones<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/votos_representantes')?>">
		<?php if($this->uri->segment(2) == "votos_representantes") { ?><strong>Votos Representantes</strong><?php } else { ?>Votos Representantes<?php } ?>
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
	<?php if(isset($_SESSION['user_id'])) { ?>
		<a href="<?php echo site_url('admin/logout')?>">Cerrar sesión</a>
	<?php } ?>
	
	<span class="link" id="ver-catalogos"></span>
</div>
