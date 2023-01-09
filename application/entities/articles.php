<?php



class Articles implements JsonSerializable
{
    protected $_id;
    protected $_reference;
    protected $_denomination;
    protected $_categorie;
    private $_defaultParams = array("id" => 0, "reference" => "aaaaaa", "denomination" => "null", "categorie"=> "null");
	/**
	 * @param $_Reference mixed 
	 * @param $_denomination mixed 
	 * @param $_description mixed 
	 * @param $_prixUnitaire mixed 
	 */
    const EOL = " <br>";

    public function __construct(array $params) {
        try {
            if (!(count($params) > 0))
                throw new ArticleException();
        } catch (Exception $ex) {
            $params = $this->_defaultParams;
            $msg = PHP_EOL. $ex->getMessage() . " : code : " . $ex->getCode() . " feedBack PHP =>" . $ex->getTraceAsString(). $this->showCurrentDataError();
            file_put_contents("C:/wamp64/www/dossier type mvc/application/log.txt","FILE_APPEND", $msg);
        }
        $this->hydrate($params);
    }

 public function showCurrentDataError(){
    $str="";
        $str=print_r(debug_backtrace(),true);
        $str.=print_r(get_defined_vars(),true);
        return $str;
    }

    function hydrate($params) {
        foreach ($params as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
     
    public function getId()
    {
        return $this->_id;
    }
    

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    function setId($id): void {
        if (is_int($id))
            throw new Exception("L'attribut 'id' de l'article doit être un entier");
        $this->_id = $id;
    }

    /**
     * 
     * @return mixed
     */
    function getReference()
    {
        return $this->_reference;
    }

    /**
     * 
     * @param mixed $_Reference 
     * @return Articles
     */
    function setReference($reference): void {
        if (!is_string($reference) || !strlen($reference) == 6)
            throw new Exception("L'attribut 'reference' de l'article doit être un string");
        $this->_reference = $reference;
    }

    /**
     * 
     * @return mixed
     */
    function getDenomination()
    {
        return $this->_denomination;
    }

    /**
     * 
     * @param mixed $_denomination 
     * @return Articles
     */
    function setDenomination($denomination): void {
        if (!is_string($denomination))
            throw new Exception("L'attribut 'type' de l'article doit être un string");
        $this->_denomination = $denomination;
        
    }


    public function jsonSerialize():array{
        return ["id"=>$this->getId(),"reference"=>$this->getReference(),"denomination"=>$this->getDenomination(),"categorie"=>$this->getCategorie()];
    }

    public function __toString() {
        return "id : " . $this->getId() . ", reference : " . $this->getReference() . ", denomination : " . $this->getDenomination()  . self::EOL;
    }
	/**
	 * @return mixed
	 */
	function getCategorie() {
		return $this->_categorie;
	}
	
	/**
	 * @param mixed $_categorie 
	 * @return Articles
	 */
	function setCategorie($_categorie): self {
		$this->_categorie = $_categorie;
		return $this;
	}
}

