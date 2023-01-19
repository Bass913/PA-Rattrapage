<form method="<?= $config["config"]["method"]??"GET" ?>" action="<?= $config["config"]["action"]??"" ?>">
	<div>

	<?php 
		$textElem=array_slice($config["inputs"], 0, 6);
		$radioElem=array_slice($config["inputs"], 5,1);
	?>
	
	<?php 	
		foreach ($textElem as $name => $configInput):?>
		<div class="row">
			<div class="col col-3">
			<p><?= $configInput["label"] ?></p>
			</div>
			<div class="col">
			<input name="<?= $name ?>" 
					class="<?= $configInput["class"]??"" ?>"
					type="<?= $configInput["type"]??"text" ?>"

					<?php if(!empty($configInput["required"])): ?>
						required="required"
					<?php endif;?>

			>
					</div>
		</div>
	<?php endforeach;?>
	</div>
	<div class="row">
		<div class="col">
			<input type="submit" name="submit-register" value="<?= $config["config"]["submit"]??"Envoyer" ?>">
		</div>
	</div>
</form>