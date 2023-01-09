<?php


class Administrateur implements JsonSerializable{
private $_id;
private $_nom;
private $_prenom;
private $_pseudo;
private $_login;
private $_password;


public function __construct(array $params) {
    $this->_commandes = array();
    $this->hydrate($params);
}


function hydrate($params) {
    foreach ($params as $key => $value) {
        $method = "set" . ucfirst($key);
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }
}

 


	
	function getPrenom() {
		return $this->_prenom;
	}
	
	/**
	 * 
	 * @param mixed $_prenom 
	 * @return Administrateur
	 */
	function setPrenom($_prenom): self {
		$this->_prenom = $_prenom;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getNom() {
		return $this->_nom;
	}
	
	/**
	 * 
	 * @param mixed $_nom 
	 * @return Administrateur
	 */
	function setNom($_nom): self {
		$this->_nom = $_nom;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getPassword() {
		return $this->_password;
	}
	
	/**
	 * 
	 * @param mixed $_password 
	 * @return Administrateur
	 */
	function setPassword($_password): self {
		$this->_password = $_password;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getLogin() {
		return $this->_login;
	}
	
	/**
	 * 
	 * @param mixed $_login 
	 * @return Administrateur
	 */
	function setLogin($_login): self {
		$this->_login = $_login;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getPseudo() {
		return $this->_pseudo;
	}
	
	/**
	 * 
	 * @param mixed $_pseudo 
	 * @return Administrateur
	 */
	function setPseudo($_pseudo): self {
		$this->_pseudo = $_pseudo;
		return $this;
	}
    
    public function jsonSerialize(){
        return ["nom"=>$this-> getNom(),"prenom"=> $this-> getPrenom(),];
    }
	/**
	 * 
	 * @return mixed
	 */
	function getId() {
		return $this->_id;
	}
	
	/**
	 * 
	 * @param mixed $_id 
	 * @return Administrateur
	 */
	function setId($_id): self {
		$this->_id = $_id;
		return $this;
	}
}