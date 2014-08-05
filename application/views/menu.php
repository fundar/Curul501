<div>
	<a href="<?php echo site_url('admin/representatives')?>">
		<?php if($this->uri->segment(2) == "representatives") { ?><strong>Representantes</strong><?php } else { ?>Representantes<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/initiatives')?>">
		<?php if($this->uri->segment(2) == "initiatives") { ?><strong>Iniciativas</strong><?php } else { ?>Iniciativas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/political_parties')?>">
		<?php if($this->uri->segment(2) == "political_parties") { ?><strong>Partidos políticos</strong><?php } else { ?>Partidos políticos<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/legislatures')?>">
		<?php if($this->uri->segment(2) == "legislatures") { ?><strong>Legislaturas</strong><?php } else { ?>Legislaturas<?php } ?>
	</a> |
	<a href="<?php echo site_url('admin/topics')?>">
		<?php if($this->uri->segment(2) == "topics") { ?><strong>Temas</strong><?php } else { ?>Temas<?php } ?>
	</a> |
	<?php if(isset($_SESSION['user_id'])) { ?>
		<a href="<?php echo site_url('admin/logout')?>">Cerrar sesión</a>
	<?php } ?>
	
	<span class="link" id="ver-catalogos"></span>
</div>
