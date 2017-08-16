<div class="row">
	<div class="col-sm-8"></div>
	<div class="col-sm-4">
		<?php if(count($requisicoes) > 0){ ?>
		<div class="widget">
			<h4>Requisições de amizade</h4>
			<?php foreach($requisicoes as $pessoa){ ?>
				<div class="requisicaoitem">
					<strong><?php echo $pessoa['nome']; ?></strong><br>
					<button class="btn btn-default pull-right" onclick="aceitarFriend('<?php echo $pessoa['id']; ?>', this)">+</button>
				</div>
			<?php } ?>
		</div>
		<?php } ?>

		<div class="widget">
			<h4>Total de Amigos</h4>
			<?php echo ($totalamigos == 1)? $totalamigos.' amigo.' : $totalamigos.' amigos.'; ?>
		</div>

		<?php if(count($sugestoes) > 0){ ?>
		<div class="widget">
			<h4>Sugestões de amigos</h4>
			<?php foreach($sugestoes as $pessoa){ ?>
				<div class="sugestaoitem">
					<strong><?php echo $pessoa['nome']; ?></strong><br>
					<button class="btn btn-default pull-right" onclick="addFriend('<?php echo $pessoa['id']; ?>', this)">+</button>
				</div>
			<?php } ?>
		</div>
		<?php } ?>

	</div>
</div>