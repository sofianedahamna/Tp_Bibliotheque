<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilisateur
 *
 * @author soso
 */
 class Adresse{

	protected $_id;
    protected $_numDeVoie;
    protected $_libelleVoie;
    protected $_ville;
    protected $_codePostal;


	function __construct($params) {
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



	/**
	 * 
	 * @return mixed
	 */
	function getVille() {
		return $this->_ville;
	}
	
	/**
	 * 
	 * @param mixed $_ville 
	 * @return Adresse
	 */
	function setVille($_ville): self {
		$this->_ville = $_ville;
		return $this;
	}
	
	/**
	 * 
	 * @return mixed
	 */
	function getCodePostal() {
		return $this->_codePostal;
	}
	
	/**
	 * 
	 * @param mixed $_codePostal 
	 * @return Adresse
	 */
	function setCodePostal($_codePostal): self {
		$this->_codePostal = $_codePostal;
		return $this;
	}
	/**
	 * @param $_numeroDeLaVoie mixed 
	 * @param $_typeDeVoie mixed 
	 * @param $_nomDeLaVoie mixed 
	 * @param $_ville mixed 
	 * @param $_codePostal mixed 
	 */
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
	 * @return Adresse
	 */
	function setId($_id): self {
		$this->_id = $_id;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getNumDeVoie() {
		return $this->_numDeVoie;
	}
	
	/**
	 * 
	 * @param mixed $_numeroDeVoie 
	 * @return Adresse
	 */
	function setNumDeVoie($_numDeVoie): self {
		$this->_numDeVoie = $_numDeVoie;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getLibelleVoie() {
		return $this->_libelleVoie;
	}
	
	/**
	 * 
	 * @param mixed $_libelleVoie 
	 * @return Adresse
	 */
	function setLibelleVoie($_libelleVoie): self {
		$this->_libelleVoie = $_libelleVoie;
		return $this;
	}
}
