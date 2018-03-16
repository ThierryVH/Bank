<?php

// namespace Entities;

class User
{

	use Hydrator;

	protected $id,
				 		$name,
				 		$mail,
				 		$password;


	public function __construct(array $array){
		$this->hydrate($array);
	}

	public function setId($id){
		$id = (int) $id;
		if($id > 0){
			$this->id = $id;
		}
	}

	public function setName($name){
		if(is_string($name)){
			$this->name = $name;
		}
	}

	public function setMail($mail){
		if(is_string($mail)){
			$this->mail = $mail;
		}
	}

	public function setPassword($password){
		if(is_string($password)){
			$this->password = $password;
		}
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getMail(){
		return $this->mail;
	}

	public function getPassword(){
		return $this->password;
	}


}
