<?php

//namespace \application\entities;

/**
 * Description of Client
 *
 * @author GRICOLAT Didier
 */
class Client extends Utilisateur implements JsonSerializable  {

   // private $_commandes;
    private $_dateInscriptionClient;
   

    
    public function __construct(array $params) {
        //$this->_commandes = array();
        $this->hydrate($params);
        $this->setPassword(self::passwordGenerator());
    }

    function hydrate($params) {
        foreach ($params as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

  /**public function addCommande(Commande $cmd): array {
        $this->_commandes[] = $cmd;
    }

    function get_commandes() {
        return $this->_commandes;
    }*/

	

	
	
    public function jsonSerialize(){
        return ["civilite"=>$this-> getCiviliter(),"nom"=>$this-> getNom(),"prenom"=> $this-> getPrenom(),"email"=>$this->getEmail(),"telephone"=>$this->getTelephone(),"login"=>$this->getLogin(),"password"=>$this->getPassword(),"dateInscription"=>$this-> getDateInscriptionClient(),];
    }
	/**
	 * 
	 * @return mixed
	 */
	/**

     function getCommandes() {
		return $this->_commandes;
	}**/
	
	/**
	 * 
	 * @param mixed $_commandes 
	 * @return Client
	 
	function setCommandes($_commandes): self {
		$this->_commandes = $_commandes;
		return $this;
	}*/
	
	function getDateInscriptionClient() {
		return $this->_dateInscriptionClient;
	}
	
	/**
	 * @param mixed $_dateInscriptionClient 
	 * @return Client
	 */
	function setDateInscriptionClient($_dateInscriptionClient): self {
		$this->_dateInscriptionClient = $_dateInscriptionClient;
		return $this;
	}

}
