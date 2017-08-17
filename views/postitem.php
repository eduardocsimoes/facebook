<div class="postitem">
	<div class="postitem_info">
		<strong>Post de:</strong> <?php echo $nome; ?>
	</div>

	<?php if($tipo == 'foto'){ ?>
		<img src="<?php echo BASE_URL; ?>assets/images/posts/<?php echo $url; ?>" alt="" border="0" width="100%">
	<?php } ?>

	<div class="postitem_texto">
		<?php echo $texto; ?>
	</div>

	<div class="postitem_botoes">
		<button class="btn btn-default" onclick="curtir(this)" data-id="<?php echo $id; ?>" data-likes="<?php echo $likes; ?>" data-liked="<?php echo $liked; ?>">(<?php echo $likes; ?>) <?php echo ($liked == 0) ? 'Curtir' : 'Descurtir'; ?></button>
		<button class="btn btn-default" onclick="displayComentario(this)">Comentar</button>
		<div class="postitem_comentario">
			<br><br>
			<input type="text" class="postitem_txt form-control">
			<button class="btn btn-default" data-id="<?php echo $id; ?>" onclick="comentar(this)">Enviar</button>
		</div>
	</div>
	
	<br>

	<?php if(isset($comentarios) && !empty($comentarios)){ ?>
	<div class="postitem_comentarios">
		<h6><strong>Comentários</strong></h6><br>
		<?php foreach($comentarios as $value){ ?>
			<p><strong><?php echo $value['nome']; ?>: </strong><?php echo $value['texto']; ?></p><br>
		<?php
			}
		?>	
	</div>	
	<?php
		}  
	?>
</div>