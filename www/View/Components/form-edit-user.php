<form method="<?= $config["config"]["method"]??"POST" ?>" action="<?= $config["config"]["action"]??"" ?>">
	<div>

	<?php 
		$textElem=array_slice($config["inputs"], 0, 6);
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
					value="<?= $config["fill"][$name]??"" ?>"
					min="<?= $configInput["min"]??"" ?>"
					max="<?= $configInput["max"]??"" ?>"
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
			<input type="submit" name="submit-edit" value="<?= $config["config"]["submit"]??"Envoyer" ?>">
		</div>
	</div>
</form>