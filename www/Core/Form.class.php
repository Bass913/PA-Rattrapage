<?php

namespace App\Core;

class Form
{

    public function loginForm()
    {

        return [
            "config" => [
                "method" => "POST",
                "class" => "form-register",
                "submit" => "Se connecter",
            ],
            "inputs" => [
                "email" => [
                    "type" => "email",
                    "label" => "Adresse e-mail",
                    "class" => "ipt-form-entry",
                    "required" => true,
                    "error" => "Veuillez rentrer une adresse email valide."
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "class" => "ipt-form-entry",
                    "required" => true,
                    "error" => "Le mot de passe que vous essayez de saisir ne respecte pas les conditions."
                ],
            ]
        ];
    }



    public function registerForm()
    {

        return [
            "config" => [
                "method" => "POST",
                "class" => "form-register",
                "reset" => "RAZ",
                "submit" => "Nous rejoindre"
            ],
            "inputs" => [
                "firstname" => [
                    "type" => "text",
                    "label" => "Prénom",
                    "placeholder" => "Votre prénom",
                    "class" => "input-text",
                    "min" => 2,
                    "max" => 25,
                    "required" => true,
                    "error" => "Votre prénom doit faire entre 2 et 25 caractères"
                ],

                "lastname" => [
                    "type" => "text",
                    "label" => "Nom de famille",
                    "placeholder" => "Votre nom",
                    "class" => "input-text",
                    "min" => 2,
                    "max" => 75,
                    "required" => true,
                    "error" => "Votre nom doit faire entre 2 et 75 caractères"
                ],

                "birthday" => [
                    "type" => "date",
                    "label" => "Date de naissance",
                    "class" => "input-date",
                    "required" => true,
                ],
                "email" => [
                    "type" => "email",
                    "label" => "Email",
                    "placeholder" => "Votre email",
                    "class" => "input-email",
                    "required" => true,
                    "error" => "Votre email est incorrect"
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "placeholder" => "Votre mot de passe",
                    "class" => "input-pwd",
                    "required" => true,
                    "error" => "Votre mot de passe doit faire plus de 8 caractères avec une minuscule une majuscule et un chiffre"
                ],
                "confirm" => [
                    "type" => "password",
                    "label" => "Confirmer le mot de passe",
                    "placeholder" => "Confirmation",
                    "class" => "input-pwd",
                    "required" => true,
                    "confirm" => "password",
                    "error" => "Votre mot de passe de confirmation ne correspond pas"
                ],
            ]
        ];
    }
}
