<?php

// namespace Models;

/**
 *  Classe permettant de gérer les opérations en base de données concernant les objets User
 */
class UserManager
{

	private $_db;

  public function __construct() {
    $this->setDb(Database::DB());
  }

  public function setDb(PDO $database) {
    $this->_db = $database;
  }

	public function add(User $user){
		$query = $this->_db->prepare('INSERT INTO user(name, mail, password) VALUES (:name, :mail, :password)');
		$query->execute([
			"name" => $user->getName(),
			"mail" => $user->getMail(),
			"password" => $user->getPassword()
		]);
	}

	public function checkIfExist(User $user){
		$query = $this->_db->prepare('SELECT * FROM user WHERE mail = :mail');
		$query->execute([
			"mail" => $user->getMail()
		]);

		return $query->rowCount();
	}

	public function checkPassword(User $user){
		$query = $this->_db->prepare('SELECT * FROM user WHERE mail = :mail');
		$query->execute([
			"mail" => $user->getMail()
		]);

		$data = $query->fetch(PDO::FETCH_ASSOC);

		if(password_verify($user->getPassword(), $data['password'])){
			return true;
		} else {
			return false;
		}
	}

	public function getUser(User $user){
		$query = $this->_db->prepare('SELECT * FROM user WHERE mail = :mail');
		$query->execute([
			"mail" => $user->getMail()
		]);

		$data = $query->fetch(PDO::FETCH_ASSOC);
		return new User($data);
	}


}
