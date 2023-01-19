<div class="container forms">

	<div class="">
		<!-- Blog Entries Column (REPEAT THAT) -->
		<h1>Inscrivez-vous !</h1><br>
		<?php
		$this->includeComponent("form-register", $registerForm);
		?>
		<?php foreach ($configFormErrorsRegister as $error) : ?>
			<div>
				<p><?= $error ?> </p>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="line"></div>
	<div class="login-form">
		<h1>Connectez vous à votre compte</h1><br>
		<?php
		$this->includeComponent("form-login", $loginForm);
		?>
		<?php foreach ($configFormErrorsLogin as $error) : ?>
			<div>
				<p><?= $error ?> </p>
			</div>
		<?php endforeach; ?>
	</div>

</div>
</div>