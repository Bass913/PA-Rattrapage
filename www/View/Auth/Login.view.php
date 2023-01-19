<div class="container relative">

	<div class="row">
		<!-- Blog Entries Column (REPEAT THAT) -->
		<h1>Connectez vous à votre compte</h1><br>
		<?php
		$this->includeComponent("form-login", $loginForm);
		?>
		<?php foreach ($configFormErrors as $error) : ?>
			<div>
				<p><?= $error ?> </p>
			</div>
		<?php endforeach; ?>
		<br>
		<p><a href="/mot-de-passe-oublie">Mot de passe oublié ?</a></p>
		<br>
	</div>
	

</div>
</div>