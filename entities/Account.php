<?php

// namespace Entities;

class Account
{

	use Hydrator;

	protected $id,
						$name,
						$balance = 80,
						$userId;

	CONST ACCOUNT = ['Compte Courant','Livret A', 'PEL', 'Compte Joint'];

	public function __construct(array $array){
		$this->hydrate($array);
	}

	// SETTER

	public function setId($id){
		$id = (int) $id;
		if($id > 0){
			$this->id = $id;
		}
	}

	public function setName($name){
		if (in_array($name, self::ACCOUNT)){
			$this->name = $name;
		}
	}

	public function setBalance($balance){
		$balance = (int) $balance;
		$this->balance = $balance;
	}

	public function setUserId($userId){
	 	$userId = (int) $userId;
		if($userId > 0){
			$this->userId = $userId;
		}
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getBalance(){
		return $this->balance;
	}

	public function getUserId(){
		return $this->userId;
	}

	public function payment($balance){
		$balance = (int) $balance;
		$this->balance += $balance;
	}

	public function debit($balance){
		$balance = (int) $balance;
		$this->balance -= $balance;
	}

	public function transfer(Account $account, $balance){
		$balance = (int) $balance;
		$this->debit($balance);
		$account->payment($balance);
	}

	public function checkState(){
		if($this->balance < 0){
			return 'alert';
		}
	}

}
