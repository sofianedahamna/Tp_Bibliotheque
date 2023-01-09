<?php




class CdManager implements iModel
{
    private $_pdo;
    const SLCT_RQST_ARTICLE_CD = "SELECT reference_article,denomination_article,categorie_article,compositeur_cd,tracklist_cd FROM article_tbl "
        . " JOIN cd_tbl ON id_article = id_cd AND denomination_article = :denomination  ";
    const SLCT_RQST_ARTICLE_CD_BY_KEYWORD = "SELECT DISTINCT  reference_article,denomination_article,categorie_article,compositeur_cd,tracklist_cd FROM article_tbl INNER JOIN cd_tbl ON id_article = id_cd AND (reference_article regexp :reference OR denomination_article regexp :denomination OR categorie_article regexp :categorie OR compositeur_cd regexp :compositeur OR tracklist_cd regexp :tracklist)";

    const SLCT_REFERENCE = "SELECT COUNT(*) as count FROM article_tbl WHERE reference_article=:reference";
    public function __construct(\PDO $PDO)
    {
        $this->setPdo($PDO);
    }

    public function get(string $keyword): array
    {
        $Cd = null;
        $listeCD = array();
        try {
            $statement = $this->getPDO()->prepare(self:: SLCT_RQST_ARTICLE_CD_BY_KEYWORD);
            $statement->bindValue(":reference", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":denomination", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":categorie", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":compositeur", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":tracklist", $keyword, \PDO::PARAM_STR);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();
            while ($tupe = $statement->fetch()) {
                $dataTbTuple = $this->extractDatas($tupe);
                //var_dump($dataTbTuple);
                $Cd = new CD($dataTbTuple);
                $listeCD[] = $Cd;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $msg = $exc;
            var_dump($msg);
        }
       // var_dump($listeCD);
        return $listeCD;
    }

    public function getListeCd(string $keyword)
    {
        $cd = null;
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_ARTICLE_CD);
            $statement->bindValue(":denomination", $keyword, PDO::PARAM_INT);
            
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();

            if ($array2 = $statement->fetch()) :

               
                $array = $this->extractDatas($array2);
                $cd = new Cd($array);
            endif;
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
        }
        var_dump($cd);
        return $cd;
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
            $datas[str_replace(array("_article","_cd"), "", $key)] = $value;
        }
        return $datas;
    }
}
