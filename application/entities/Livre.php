<?php

require_once '../libraries/autoloader.php';
class Livre extends Articles implements JsonSerializable{


private $_autheur;
private $_resumer;



function __construct(array $params) {
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
	 * @return mixed
	 */
	function getAutheur() {
		return $this->_autheur;
	}
	
	/**
	 * @param mixed $_autheur 
	 * @return Livre
	 */
	function setAutheur($_autheur): self {
		$this->_autheur = $_autheur;
		return $this;
	}




    public function jsonSerialize():array{
        return ["id"=>$this->getId(),"reference"=>$this->getReference(),"denomination"=>$this->getDenomination(),"categorie"=>$this->getCategorie(),"autheur"=>$this->getAutheur(),"resumer"=>$this->getResumer()];
    }

	/**
	 * @return mixed
	 */
	function getResumer() {
		return $this->_resumer;
	}
	
	/**
	 * @param mixed $_resumer 
	 * @return Livre
	 */
	function setResumer($_resumer): self {
		$this->_resumer = $_resumer;
		return $this;
	}
}