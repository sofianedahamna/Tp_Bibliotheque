<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acheteurManager
 *
 * @author GRICOLAT Didier
 */
class ClientManager implements iModel {

    private $_PDO;
    const INSRT_RQST_UTLSTR = "INSERT INTO utilisateur_tbl (civiliter_utlstr,nom_utlstr,prenom_utlstr,email_utlstr,telephone_utlstr,login_utlstr,password_utlstr) "
            . "VALUES (:civiliter,:nom,:prenom,:email,:telephone,:login,:password)";
    const INSRT_RQST_ACTR = "INSERT INTO client_tbl (id_client,dateInscription_client) "
            . "VALUES (:id,:dateInscription)";
    const INSRT_RQST_ADR = "INSERT INTO adresse_tbl (numDeVoie_adr,libelleVoie_adr,ville_adr,codePostal_adr,client_adr)"
            . "VALUES (:numDeVoie,:libelleVoie,:ville,:codePostal,:client)"; 
    const SLCT_RQST_UTLSTR_ACTR_BY_ID = "SELECT nom_utlstr,prenom_utlstr,email_utlstr,telephone_utlstr,login_utlstr,password_utlstr FROM utilisateur_tbl "
            . " JOIN acheteur_tbl WHERE id_utlstr = id_actr AND id_utlstr = :id ";
    const SLCT_RQST_UTLSTR_ACTR_BY_KEYWORD = "SELECT DISTINCT nom_utlstr,prenom_utlstr,email_utlstr,telephone_utlstr,login_utlstr,password_utlstr,dateAnniversaire_actr FROM utilisateur_tbl "
            . " JOIN acheteur_tbl ON id_utlstr = id_actr AND (nom_utlstr regexp :nom OR prenom_utlstr regexp :prenom OR email_utlstr regexp :email OR telephone_utlstr regexp :telephone)";

    public function __construct(\PDO $PDO) {
        $this->setPDO($PDO);
    }

    public function add(object $Client, object $Adresse): array {
        //var_dump($Client->getNom()."/".$Client->getPrenom()."/".$Client->getEmail()."/".$Client->getTelephone()."/".$Client->getLogin()."/".$Client->getPassword());
       // var_dump($Adresse);
        $flag = false;
        $msg = "";
       // $id_utlstr = null;
        try {

            //Insertion d'un utilisateur
            $this->getPDO()->beginTransaction(); //Début de la transaction et sortie du mode autocommit
            $statement_utlstr = $this->getPDO()->prepare(self::INSRT_RQST_UTLSTR);
            $statement_utlstr->bindValue(":civiliter", $Client->getCiviliter(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":nom", $Client->getNom(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":prenom", $Client->getPrenom(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":email", $Client->getEmail(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":telephone", $Client->getTelephone(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":login", $Client->getLogin(), \PDO::PARAM_STR);
            $statement_utlstr->bindValue(":password", $Client->getPassword(), \PDO::PARAM_STR);
            $statement_utlstr->execute();
            $id_utlstr = $this->getPDO()->lastInsertId();

            //Insertion d'un Client
            $statement_actr = $this->getPDO()->prepare(self::INSRT_RQST_ACTR);
            $statement_actr->bindValue(":id", $id_utlstr, \PDO::PARAM_INT);
            $statement_actr->bindValue(":dateInscription", $Client->getDateInscriptionClient(), \PDO::PARAM_STR);
            $statement_actr->execute();
     
            $statement_adr = $this->getPdo()->prepare(self::INSRT_RQST_ADR);
            $statement_adr->bindValue(":numDeVoie", $Adresse->getNumDeVoie(), PDO::PARAM_STR);
            $statement_adr->bindValue(":libelleVoie", $Adresse->getLibelleVoie(), PDO::PARAM_STR);
            $statement_adr->bindValue(":ville", $Adresse->getVille(), PDO::PARAM_STR);
            $statement_adr->bindValue(":codePostal", $Adresse->getCodePostal(), PDO::PARAM_STR);
            $statement_adr->bindValue(":client", $id_utlstr ,PDO::PARAM_INT);
            $statement_adr->execute();

            $this->getPDO()->commit(); // Validation des requêtes
        } catch (\Exception $exc) {
            $flag = true;
            $msg = $exc->getTraceAsString();
            var_dump($msg);
            $this->getPDO()->rollBack(); // Si erreur => annulation des modifications 
        }
        return ["err_flag" => $flag, "error_msg" => $msg];
    }

    public function count($param) {
        
    }

    public function delete($params) {
        
    }

    public function exists($param) {
        
    }

    public function get(string $keyword): array {
        $Acheteur = null;
        $listeAcheteurs = array();
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_UTLSTR_ACTR_BY_KEYWORD);
            $statement->bindValue(":nom", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":prenom", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":email", $keyword, \PDO::PARAM_STR);
            $statement->bindValue(":telephone", $keyword, \PDO::PARAM_STR);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();
            while ($tupe = $statement->fetch()) {
                $dataTbTuple = $this->extractDatas($tupe);
                $Acheteur = new Client($dataTbTuple);
                $listeAcheteurs[] = $Acheteur;
            }
        } catch (\Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $listeAcheteurs;
    }

    public function getById(int $id): Client {
        $Acheteur = null;
        try {
            $statement = $this->getPDO()->prepare(self::SLCT_RQST_UTLSTR_ACTR_BY_ID);
            $statement->bindValue(":id", $id, \PDO::PARAM_INT);
            //ou
            //$statement->execute(array(":id" => intval($id)));
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $statement->execute();

            $array2 = $statement->fetch();
            $array = $this->extractDatas($array2);
            $Acheteur = new Client($array);
        } catch (\Exception $exc) {

            echo $exc->getTraceAsString();
        }

        return $Acheteur;
    }

    public function getList(array $param) {
        
    }

    public function update($params) {
        
    }

    function getPDO() {
        return $this->_PDO;
    }

    function setPDO($PDO): void {
        $this->_PDO = $PDO;
    }

    function extractDatas($array): array {
        $datas = null;
        foreach ($array as $key => $value) {
            $datas[str_replace(array("_utlstr",), "", $key)] = $value;
        }
        return $datas;
    }

}
