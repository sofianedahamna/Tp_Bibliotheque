<?php




class ArticlesManager implements iModel
{
    private $_pdo;

    const SLCT_RQST_ARTICLE_BY_KEYWORD = "SELECT * FROM article_tbl WHERE (reference_article regexp :reference OR denomination_article regexp :denomination OR categorie_article regexp :categorie )";
    const SLCT_RQST_ARTICLE_BY_REF = "SELECT * FROM article_tbl WHERE reference_article =:reference";
    const SLCT_REFERENCE = "SELECT COUNT(*) as count FROM article_tbl WHERE reference_article=:reference";
    const SLCT_RQST_ARTICLE_LIVRE = "SELECT reference_article,denomination_article,categorie_article,autheur_livre,resumer_livre FROM article_tbl "
        . " JOIN livre_tbl ON id_article = id_livre AND reference_article = :reference ";
    const SLCT_RQST_ARTICLE_CD = "SELECT reference_article,denomination_article,categorie_article,compositeur_cd,Tracklist_cd FROM article_tbl "
        . " JOIN cd_tbl ON id_article = id_cd AND reference_article = :reference ";
    const SLCT_RQST_ARTICLE_DVD = "SELECT reference_article,denomination_article,categorie_article,realisateur_dvd,synopsis_dvd FROM article_tbl "
        . " JOIN dvd_tbl ON id_article = id_dvd AND reference_article = :reference  ";

    public function __construct(\PDO $PDO)
    {
        $this->setPdo($PDO);
    }

    public function get(string $keyword): array
    {
        $article = null;
        $listeArticle = array();
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_BY_KEYWORD);
            $statement->bindValue(":reference", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":denomination", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":categorie", $keyword, \PDO::PARAM_STR);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();
            while ($tupe = $statement->fetch()) {
                $dataTbTuple = $this->extractDatas($tupe);
                //var_dump($dataTbTuple);
                $article = new Articles($dataTbTuple);
                $listeArticle[] = $article;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $msg = $exc;
            var_dump($msg);
        }
        // var_dump($listeArticle);
        return $listeArticle;
    }


    public function getByRef(string $keyword): array
    {
       // var_dump($keyword);
        $article =[];
        $Livre = [];
        $cd = [];
        $dvd = [];
        $listeArticle = array();
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_BY_REF);
            $statement->bindValue(":reference",strval($keyword), PDO::PARAM_STR);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            //var_dump($statement);
            $statement->execute();
            //var_dump( $statement->fetch());
            while ($tupe = $statement->fetch()) {
                $dataTbTuple = $this->extractDatas($tupe);
               // var_dump($tupe);
               // var_dump($dataTbTuple);
                $article = new Articles($dataTbTuple);
                $listeArticle[] = $article;
               // var_dump($article);
               // var_dump($listeArticle);
            }
             switch ($article->getCategorie()) {
                case "Livre":
            $Livre[]=$this->getListeLivre($keyword);
                    break;
                case "CD":
                   $cd[]=$this->getListeCd($keyword);
                    break;
                case "DVD":
                 $dvd[]=$this->getListeDvd($keyword);
                    break;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $msg = $exc;
            var_dump($msg);
        }
        //var_dump(array_merge($Livre, $cd, $dvd));
        //var_dump($Livre);
        //var_dump($cd);
        //var_dump($dvd);
       // var_dump($listeArticle);
        return array_merge($listeArticle,$Livre, $cd, $dvd);
    }
    public function getListeLivre(string $keyword)
    {
        $Livre = null;
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_LIVRE);
            $statement->bindValue(":reference", $keyword, PDO::PARAM_INT);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            if ($array2 = $statement->fetch()) :

                $array = $this->extractDatas($array2);
                $Livre = new Livre($array);
            //var_dump($Livre);
            endif;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
         //var_dump($Livre);
        return $Livre;
    }
    public function getListeCd(string $keyword)
    {
        $cd = null;
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_CD);
            $statement->bindValue(":reference", $keyword, PDO::PARAM_INT);

            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            if ($array2 = $statement->fetch()) :


                $array = $this->extractDatas($array2);
                $cd = new Cd($array);
            endif;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
        //var_dump($cd);
        return $cd;
    }
    public function getListeDvd(string $keyword)
    {
        $dvd = null;
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_DVD);
            $statement->bindValue(":reference", $keyword, PDO::PARAM_INT);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            if ($array2 = $statement->fetch()) :


                $array = $this->extractDatas($array2);
                $dvd = new DVD($array);
            endif;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
        // var_dump($dvd);
        return $dvd;
    }


    public function add(object $datas, object $datas2): array
    {
    }
    public function count($param)
    {
    }

    public function delete($params)
    {
    }

    public function exists($param)
    {
    }

    public function getList(array $param)
    {
    }

    public function update($params)
    {
    }

    static function referenceExists(String $reference): bool
    {
        $flag = false;
        $statement = self::getPdo()->prepare(self::SLCT_REFERENCE);
        $statement->bindValue(":reference", $reference, PDO::PARAM_STR);
        $statement->execute();
        if (intval($statement->fetch()['count']) >= 1) :
            $flag = true;
        endif;
        return $flag;
    }

    /**
     * 
     * @return mixed
     */
    function getPdo()
    {
        return $this->_pdo;
    }


    function setPdo($_pdo): self
    {
        $this->_pdo = $_pdo;
        return $this;
    }
    function extractDatas($array): ?array
    {
        $datas = null;
        foreach ($array as $key => $value) {
            $datas[str_replace(array("_article", "_livre", "_dvd", "_cd"), "", $key)] = $value;
        }
        return $datas;
    }
};
