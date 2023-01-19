<?php

namespace App\Controller;

use App\Core\Form;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class UserController
{
	public function activateAccount()
	{
		$user = new UserModel();
		$user->checkTokenEmail($_GET['verify_key'], $_GET['email']);
		echo 'Votre compte a bien été activé !';
	}

	public function showUsers()
	{
		if (isset($_COOKIE['LOGGED_USER'])) {
			$user = new UserModel();
			$userData = $user->selectLoggedUser($_COOKIE['LOGGED_USER']);
			$userList = $user->showUsers($_COOKIE['LOGGED_USER']);
			$v = new View("Page/UserList", "Front");
			$v->assign("userData", $userData);
			$v->assign("userList", $userList ?? []);
			if (isset($_GET['edit'])) {
				$editForm = $user->editUserForm();
				$v->assign("editForm", $editForm);
			}
			if (isset($_GET['edit']) && empty($userList)) {
				header("Location: /users");
			}
			if(isset($_POST['submit-edit'])) {
				$verificator = new Verificator($editForm, $_POST);
				$userExists = $user->checkRegister($_POST['email'], $_GET['edit']);
				if($userExists) {
					$message = ["error" => "L'adresse mail est déja utilisé sur un autre compte !"];
					$verificator->setMessage($message['error']);
				}
				$configFormErrors = $verificator->getMesssage();

				if(empty($configFormErrors)) {
					$userData = $user->selectAllById($editForm['fill']['id']);
					$user->fillForm($editForm['fill']['id']);
					$user->setId($editForm['fill']['id']);
					$user->setFirstname($_POST['firstname']);
                    $user->setLastname($_POST['lastname']);
                    $user->setBirthday($_POST['birthday']);
                    $user->setEmail($_POST['email']);
					$user->setToken($userData['token']);
					$user->setPassword($_POST['password'], $userData['password']);
					$user->setToken($userData['token']);
					$user->setStatus($_POST['status']);
					$user->save();
					header("Location: /users?edit=".$editForm['fill']['id']);
				}
			}
			if(isset($_GET['delete'])) {
					$user->setId($_GET['delete']);
					$user->delete($_GET['delete']);
					header("Location: /users");
			}	
		} else {
			header("Location: /");
		}
		$v->assign("configFormErrors", $configFormErrors ?? []);
	}

	public function logout()
	{
		setcookie("LOGGED_USER", null, -1);
		header("Location: /");
	}
}
