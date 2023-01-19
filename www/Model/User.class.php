<?php

namespace App\Model;

use App\Core\DatabaseDriver;
use App\Core\Jwt;
use App\Core\Verificator;


class User extends DatabaseDriver
{
    private $id = null;
    protected $firstname;
    protected $lastname;
    protected $birthday;
    protected $email;
    protected $password;
    protected $token = null;
    protected $status = 0;



    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId(Int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname(String $firstname): void
    {
        $this->firstname = ucwords(mb_strtolower(trim($firstname)));
    }

    /**
     * @return mixed
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname(String $lastname): void
    {
        $this->lastname = mb_strtoupper(trim($lastname));
    }

    /**
     * @return mixed
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param mixed $lastname
     */
    public function setBirthday(String $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(String $email): void
    {
        $this->email = mb_strtolower(trim($email));
    }

    /**
     * @return mixed
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed $pwd
     */
    public function setPassword(string $password, string $currentPassword = null): void
    {
        if (empty($password)) {
            $this->password = $currentPassword;
        } else {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token = null): void
    {
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }



    public function checkRegister(string $email, int $id = null): bool
    {
        if(!isset($id)) {
            $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
            $sql->execute(['email' => $email]);
            $result = $sql->rowCount();
            return $result > 0 ? true : false;
        }
        $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email AND id != :id");
        $sql->execute(['email' => $email, 'id' => $id]);
        $result = $sql->rowCount();
        return $result > 0 ? true : false;
    }

    public function checkTokenEmail(string $token, string $email): void
    {
        $sql = $this->pdo->prepare("SELECT token FROM $this->table WHERE status = :status AND email = :email");
        $sql->execute(['status' => 0, 'email' => $email]);
        $result = $sql->fetch();
        if ($sql->rowCount() > 0 && $result['token'] === $token) {
            $sql = $this->pdo->prepare("UPDATE user SET status = 1 WHERE email = :email");
            $sql->execute(['email' => $email]);
        } else {
            echo "Le compte n'existe pas ou est déja validé";
        }
    }

    public function checkLogin(string $email, string $password = null): bool
    {
        $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
        $sql->execute(['email' => $email]);
        $result = $sql->rowCount();
        if ($result > 0) {
            $data = $sql->fetch();
            if (!password_verify($password, $data['password'])) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function isActivated(string $email, string $password = null): bool
    {
        $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE email = :email");
        $sql->execute(['email' => $email]);
        $result = $sql->rowCount();
        if ($result > 0) {
            $data = $sql->fetch();
            if (password_verify($password, $data['password']) && $data['status'] != 1) {
                return false;
            } elseif (password_verify($password, $data['password']) && $data['status'] === 1) {
                $expiration = time() + 60 * 60 * 24;
                setcookie("LOGGED_USER", $data['token'], $expiration);
                // $_SESSION['lastname'] = $data['lastname'];
                // $_SESSION['email'] = $data['email'];
                header("Location: /users");
                echo "Logged in!";
                return true;
            }
            return true;
        }
        return true;
    }

    public function selectLoggedUser(String $token): array
    {
        $sql = $this->pdo->prepare("SELECT firstname, lastname FROM $this->table WHERE token = :token");
        $sql->execute(['token' => $token]);
        $result = $sql->fetch();
        return $result;
    }

    public function selectedUser(int $userId): array
    {
        $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $sql->execute(['id' => $userId]);
        $result = $sql->fetch();
        return $result;
    }

    public function fillForm(int $userId): array
    {
        $sql = $this->pdo->prepare("SELECT id, firstname, lastname, birthday, email, token, status FROM $this->table WHERE id = :id");
        $sql->execute(['id' => $userId]);
        $result = $sql->fetch();
        return empty($result) ? [] : $result;
    }

    public function showUsers(?String $token): array
    {
        if ($token === null) {
            header("Location: /");
        } else {
            $sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE token != :token");
            $sql->execute(['token' => $token]);
            $result = $sql->fetchAll();
            return $result;
        }
    }

    public function editUserForm()
    {

        return [
            "config" => [
                "method" => "POST",
                "class" => "form-edit-user",
                "submit" => "Modifier",
            ],

            "fill" => $this->fillForm($_GET['edit']),

            "inputs" => [
                "firstname" => [
                    "type" => "text",
                    "label" => "Prénom",
                    "placeholder" => "Votre prénom",
                    "class" => "input-text",
                    "min" => 2,
                    "max" => 25,
                    "required" => true,
                    "value" => "",
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
                    "value" => "",
                    "error" => "Votre nom doit faire entre 2 et 75 caractères"
                ],

                "birthday" => [
                    "type" => "date",
                    "label" => "Date de naissance",
                    "class" => "input-date",
                    "required" => true,
                    "value" => "",
                ],
                "email" => [
                    "type" => "email",
                    "label" => "Email",
                    "placeholder" => "Votre email",
                    "class" => "input-email",
                    "required" => true,
                    "value" => "",
                    "error" => "Votre email est incorrect"
                ],
                "password" => [
                    "type" => "password",
                    "label" => "Mot de passe",
                    "placeholder" => "Votre mot de passe",
                    "class" => "input-pwd",
                    "required" => false,
                    "value" => "",
                    "error" => "Votre mot de passe doit faire plus de 8 caractères avec une minuscule une majuscule et un chiffre"
                ],
                "status" => [
                    "type" => "number",
                    "label" => "Statut",
                    "class" => "input-status",
                    "required" => false,
                    "value" => "",
                    "min" => 0,
                    "max" => 1,
                ]
            ]
        ];
    }
}
