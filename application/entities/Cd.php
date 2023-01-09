<?php 


require_once '../libraries/autoloader.php';

class CD extends Articles implements JsonSerializable{

    private $_tracklist;
    private $_compositeur;



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
	function getCompositeur() {
		return $this->_compositeur;
	}
	
	/**
	 * @param mixed $_compositeur 
	 * @return CD
	 */
	function setCompositeur($_compositeur): self {
		$this->_compositeur = $_compositeur;
		return $this;
	}
    public function jsonSerialize():array{
        return ["id"=>$this->getId(),"reference"=>$this->getReference(),"denomination"=>$this->getDenomination(),"categorie"=>$this->getCategorie(),"compositeur"=>$this->getCompositeur(),"Tracklist"=>$this->getTracklist()];
    }

	/**
	 * @return mixed
	 */
	function getTracklist() {
		return $this->_tracklist;
	}
	
	/**
	 * @param mixed $_tracklist 
	 * @return CD
	 */
	function setTracklist($_tracklist): self {
		$this->_tracklist = $_tracklist;
		return $this;
	}
}