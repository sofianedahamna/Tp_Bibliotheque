<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilisateur
 *
 * @author didie
 */
abstract class Utilisateur {

    protected $_id;
    protected $_civiliter;
    protected $_nom;
    protected $_prenom;
    protected $_email;
    protected $_telephone;
    protected $_login;
    protected $_password;

    static function passwordGenerator() {
        return uniqid();
    }

    function getId() {
        return $this->_id;
    }

    function getNom() {
        return $this->_nom;
    }

    function getPrenom() {
        return $this->_prenom;
    }

    function getEmail() {
        return $this->_email;
    }

    function getTelephone() {
        return $this->_telephone;
    }

    function getLogin() {
        return $this->_login;
    }

    function getPassword() {
        return $this->_password;
    }

    function setId($id): void {
        $this->_id = $id;
    }

    function setNom($nom): void {
        $this->_nom = $nom;
    }

    function setPrenom($prenom): void {
        $this->_prenom = $prenom;
    }

    function setEmail($email): void {
        $this->_email = $email;
        $this->setLogin($email);
    }

    function setTelephone($telephone): void {
        $this->_telephone = $telephone;
    }

    function setLogin($login): void {
        $this->_login = $login;
    }

    function setPassword($password): void {
        $this->_password = $password;
    }
	/**
	 * @return mixed
	 */
	function getCiviliter() {
		return $this->_civiliter;
	}
	
	/**
	 * @param mixed $_civiliter 
	 * @return Utilisateur
	 */
	function setCiviliter($_civiliter): self {
		$this->_civiliter = $_civiliter;
		return $this;
	}
}
