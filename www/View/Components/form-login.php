<form method="<?= $config["config"]["method"]??"GET" ?>" action="<?= $config["config"]["action"]??"" ?>">



	<?php foreach ($config["inputs"] as $name => $configInput):?>
		<p><?= $configInput["label"] ?></p>
		<input name="<?= $name ?>" 
				class="<?= $configInput["class"]??"" ?>"
				type="<?= $configInput["type"]??"text" ?>"

				<?php if(!empty($configInput["required"])): ?>
					required="required"
				<?php endif;?>

			><br>

	<?php endforeach;?>
<br>
	<input type="submit" name="submit-login" value="<?= $config["config"]["submit"]??"Envoyer" ?>">

</form>