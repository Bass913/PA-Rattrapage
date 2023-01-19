<?php

namespace App\Core;


abstract class DatabaseDriver
{

	abstract public function setId(Int $id);
	abstract public function getId();

	protected $pdo;
	protected $table;
	private static $instance;


	/**
	 * @return object
	 */
	// Singleton
	public static function getInstance(): object
	{
		if (is_null(self::$instance)) {
			self::$instance = new \PDO("mysql:host=database;dbname=exam;port=3306", "usersql", "passwordsql", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES latin1"));

			self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		}
		return self::$instance;
	}

	public function __construct()
	{
        //Connexion avec la bdd
		try{
			$this->pdo = $this::getInstance();

		}catch(\Exception $e){
			die("Erreur SQL ".$e->getMessage());
		}
		$CalledClassExploded = explode("\\", get_called_class());
		$this->table = strtolower(end($CalledClassExploded));
	}


	// public function __construct()
	// {
	// 	//Connexion avec la bdd
	// 	try {
	// 		$this->pdo = new \PDO("mysql:host=database;dbname=exam;port=3306", "usersql", "passwordsql");

	// 		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	// 		$this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	// 	} catch (Exception $e) {
	// 		die("Erreur SQL " . $e->getMessage());
	// 	}

	// 	$CalledClassExploded = explode("\\", get_called_class());
	// 	$this->table = strtolower(end($CalledClassExploded));
	// }


	//Insert et Update
	public function save(): void
	{

		$objectVars = get_object_vars($this);
		$classVars = get_class_vars(get_class());
		$columns = array_diff_key($objectVars, $classVars);


		if (is_null($this->getId())) {
			// INSERT INTO esgi_user (firstname,lastname,email,pwd,status) VALUES (:firstname,:lastname,:email,:pwd,:status) ;
			$sql = "INSERT INTO " . $this->table . " (" . implode(",", array_keys($columns)) . ") VALUES (:" . implode(",:", array_keys($columns)) . ") ;";
		} else {

			foreach ($columns as $column => $value) {
				$sqlUpdate[] = $column . "=:" . $column;
			}

			$sql = "UPDATE " . $this->table . " SET  " . implode(",", $sqlUpdate) . "  WHERE id=" . $this->getId();
		}

		$queryPrepared = $this->pdo->prepare($sql);
		$queryPrepared->execute($columns);
	}

	public function selectAll()
	{
		$sql = "SELECT * FROM $this->table";
		return $result = $this->pdo->query($sql)->fetchAll();
	}

	public function selectAllById(int $id)
	{
		$sql = $this->pdo->prepare("SELECT * FROM $this->table WHERE id=:id");
		$sql->execute(['id' => $id]);
		$result = $sql->fetch();
		return $result;
	}


	public function delete(int $id): void
	{
		$sql = "DELETE FROM $this->table where id=$id";
		$queryPrepared = $this->pdo->prepare($sql);
		$queryPrepared->execute();
	}
}
