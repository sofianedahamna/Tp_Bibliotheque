<?php
//namespace application\models;
/**
 * Description of ManagerAuthentification
 *
 * @author GRICOLAT Didier
 */
class ManagerAuthentificationClient {

    private $_pdo;

    const SLCT_RQST_UTLSTR_EXIST = "SELECT COUNT(*) as count FROM utilisateur_tbl WHERE login_utlstr=:login AND password_utlstr = :password";
    const SLCT_RQST_UTLSTR_DATAS = "SELECT nom_utlstr ,prenom_utlstr FROM utilisateur_tbl WHERE login_utlstr=:login AND password_utlstr = :password";

    public function __construct(\PDO $PDO) {
        $this->setPdo($PDO);
    }

    public function access($identifiant, $password) : bool{
        $rspAccess = false;
        $msg = "";
        $count =null;
        try {
            //connection utilisateur recureration login password
            $statement = $this->getPdo()->prepare(self::SLCT_RQST_UTLSTR_EXIST);
            $statement->bindValue(":login", $identifiant, PDO::PARAM_STR);
            $statement->bindValue(":password", $password, PDO::PARAM_STR);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();
            $count = intval($statement->fetch()['count']);
            if (isset($count) && $count >= 1):
                $rspAccess = true;
            endif;
        } catch (Exception $exc) {
            $msg = $exc->getTraceAsString();
        }
        var_dump($rspAccess);
        return $rspAccess;
    }

    public function getDatasSession($identifiant, $password):Client {
        $Client=null;
        try {
            //
            $statement = $this->getPdo()->prepare(self::SLCT_RQST_UTLSTR_DATAS);
            $statement->bindValue(":login", $identifiant, PDO::PARAM_STR);
            $statement->bindValue(":password", $password, PDO::PARAM_STR);
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $statement->execute();
            $Client = new Client ($this-> extratcSuffixFromDataBases($statement->fetch()));
        } catch (Exception $exc) {
            print $exc->getTraceAsString();
        }
        return $Client;
    }

    function getPdo() {
        return $this->_pdo;
    }

    function setPdo($pdo): void {
        $this->_pdo = $pdo;
    }

    function extratcSuffixFromDataBases($array): array {
        $datas = null;
        foreach ($array as $key => $value) {
            $datas[str_replace(array("_utlstr"), "", $key)] = $value;
        }
        return $datas;
    }


}
