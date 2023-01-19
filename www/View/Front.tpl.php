<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Rattrapage PA</title>
	<meta name="description" content="Ceci est ma page">
	<link rel="stylesheet" href="../Public/css/main.css">
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></script>
</head>
<script>
	$(document).ready(function () {
    $('#datatable').DataTable({
		pageLength : 5
	});
});
</script>

<body class="pa-body-front">
	<nav class="pa-navbar">
		<div class="container">
			<div class="row">
				<div>
					<a href="/">Rattrapage PA</a>
				</div>
				<div>
					<ul>
						<?php
						if (isset($_COOKIE['LOGGED_USER'])) {
							echo "<li><a href='/users'>Gestion des utilisateurs</a></li>";
							echo "<li><a href='/logout'>Déconnexion</a></li>";
							echo "<li class='pseudo'>" . $userData['firstname'] . " " . $userData['lastname'] . "</li>";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<?php require $this->view; ?>

</body>

</html>