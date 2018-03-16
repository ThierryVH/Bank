<?php

// namespace Models;

/**
 *  Classe permettant de gérer les opérations en base de données concernant les objets Account
 */
class AccountManager
{

	private $_db;

	public function __construct() {
		$this->setDb(Database::DB());
	}

	public function setDb(PDO $database) {
		$this->_db = $database;
	}

	public function add(Account $account){
		$query = $this->_db->prepare('INSERT INTO account(name, balance, userId) VALUES (:name, :balance, :userId)');
		$query->execute([
			"name" => $account->getName(),
			"balance" => $account->getBalance(),
			"userId" => $account->getUserId()
		]);

	}

	public function getAll($id){

		$accounts = [];
		$query = $this->_db->prepare('SELECT * FROM account WHERE userId = :userId');
		$query->execute([
			"userId" => $id
		]);

		$data = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $result) {
      $accounts[] = new Account($result);
    }
		return $accounts;
	}

	public function getAccount($id){
		$id = (int) $id;
		$query = $this->_db->prepare('SELECT * FROM account WHERE id = :id');
		$query->execute([
			"id" => $id
		]);

		$data = $query->fetch(PDO::FETCH_ASSOC);
		return new Account($data);
	}

	public function update(Account $account){
		$query = $this->_db->prepare('UPDATE account SET balance = :balance WHERE id = :id');
		$query->execute([
			'balance' => $account->getBalance(),
			'id' => $account->getId()
		]);
	}

	public function delete(Account $account){
		$query = $this->_db->prepare('DELETE FROM account WHERE id = :id');
		$query->execute([
			"id" => $account->getId()
		]);
	}
}
