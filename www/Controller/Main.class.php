<?php
namespace App\Controller;

use App\Core\View;
use App\Model\Category as CategoryModel;
use App\Model\Post as PostModel;

class Main{

	public function index(): void
	{

		$v = new View("Page/Home", "Front");
	}

	public function login(): void
	{
		echo "Afficher login";
	}
}