<?php

namespace App\Controller;


use App\Core\View;
use App\Core\Form;
use App\Core\Verificator;
use App\Core\Jwt;
use App\Core\SendMail;
use App\Model\User;

class FormController
{

    public function checkAction()
    {
        if (isset($_COOKIE['LOGGED_USER'])) {
            header("Location: /users");
        } else {
            // Instanciation de la classe User
            $user = new User();
            // Instanciation de la class Form (qui contient tous les formulaires)
            $form = new Form();
            // Récupération du formulaire d'inscription
            $registerForm = $form->registerForm();
            // Récupération du formulaire de connexion
            $loginForm = $form->loginForm();
            if (isset($_POST['submit-register'])) {
                // Vérification pour voir si la variable POST contient le même nombre de champs que le form initialement crée
                // Effectue également toutes les vérifications par rapport aux restrictions définies dans le formulaire (Array)
                $verificator = new Verificator($registerForm, $_POST);
                // On check si le compte existe déja en BDD_POST
                $accountExists = $user->checkRegister($_POST['email']);
                if ($accountExists) {
                    $message = ["error" => "L'adresse mail est déja utilisé sur un autre compte !"];
                    $verificator->setMessage($message['error']);
                }
                // On check si nous avons des erreurs suite aux vérifications
                $configFormErrorsRegister = $verificator->getMesssage();
                // Si nous n'avons pas d'erreur alors on insert le user en BDD
                if (empty($configFormErrorsRegister)) {
                    $user->setFirstname($_POST['firstname']);
                    $user->setLastname($_POST['lastname']);
                    $user->setBirthday($_POST['birthday']);
                    $user->setEmail($_POST['email']);
                    $user->setPassword($_POST['password']);
                    $token = new Jwt([$user->getFirstname(), $user->getLastname(), $user->getEmail()]);
                    $user->setToken($token->getToken());
                    $user->setStatus(0);
                    $token = $user->getToken();
                    $user->save();
                    $servername = $_SERVER['HTTP_HOST'];
                    $email = $_POST['email'];
                    // Envoi du mail d'activation sur l'adresse de l'inscrit (Mail, Objet, Contenu,)
                    new sendMail($_POST['email'], "Activation de votre compte RATTRAPAGE", "<a href='http://$servername/activation-compte?verify_key=$token&email=$email'>Cliquez ici pour activer votre compte</a>", "Inscription réussite, confirmer votre email", "Une erreur s'est produite, merci de réesayer plus tard");
                }
            } elseif (isset($_POST['submit-login'])) {
                $verificator = new Verificator($loginForm, $_POST);
                $configFormErrors = $verificator->getMesssage();
                $userExists = $user->checkLogin($_POST['email'], $_POST['password']);
                $isActivated = $user->isActivated($_POST['email'], $_POST['password']);
                if (!$userExists) {
                    $message = ['error' => "L'identifiant ou le mot de passe est incorrect."];
                    $verificator->setMessage($message['error']);
                    $configFormErrorsLogin = $verificator->getMesssage();
                }
                if (!$isActivated) {
                    $message = ['error' => "Veuillez activer votre compte."];
                    $verificator->setMessage($message['error']);
                    $configFormErrorsLogin = $verificator->getMesssage();
                }
            }
            $v = new View("Page/Home", "Front");
            $v->assign("registerForm", $registerForm);
            $v->assign("loginForm", $loginForm);
            $v->assign("configFormErrorsRegister", $configFormErrorsRegister ?? []);
            $v->assign("configFormErrorsLogin", $configFormErrorsLogin ?? []);
        }
    }
}
