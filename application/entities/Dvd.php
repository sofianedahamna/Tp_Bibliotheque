<?php 


require_once '../libraries/autoloader.php';
class DVD extends Articles implements JsonSerializable{

private $_realisateur;
private $_synopsis;

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
	function getRealisateur() {
		return $this->_realisateur;
	}
	
	/**
	 * @param mixed $_realisateur 
	 * @return DVD
	 */
	function setRealisateur($_realisateur): self {
		$this->_realisateur = $_realisateur;
		return $this;
        
	}
    public function jsonSerialize():array{
        return ["id"=>$this->getId(),"reference"=>$this->getReference(),"denomination"=>$this->getDenomination(),"categorie"=>$this->getCategorie(),"realisateur"=>$this->getRealisateur(),"synopsis"=>$this->getSynopsis()];
    }

	/**
	 * @return mixed
	 */
	function getSynopsis() {
		return $this->_synopsis;
	}
	
	/**
	 * @param mixed $_synopsis 
	 * @return DVD
	 */
	function setSynopsis($_synopsis): self {
		$this->_synopsis = $_synopsis;
		return $this;
	}
}