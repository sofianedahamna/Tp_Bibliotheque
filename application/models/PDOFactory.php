<?php


/**
 * Description of PDOFactory
 *
 * @author GRICOLAT Didier
 */
class PDOFactory {

    private $_dsn;
    private $_user;
    private $_pwd;
    private $_opt_persistent = [];
    private $_err_manager;
    private $_pdo = null;

    public function __construct(String $dsn, $user,$pwd, bool $persistent) {
        $this->_dsn = $dsn;
        $this->_user = $user;
        $this->_pwd = $pwd;
        if ($persistent)
            $this->_opt_persistent = array(\PDO::ATTR_PERSISTENT => true);
    }

    public function getPDO() {
        if (is_null($this->_pdo)) {
            $this->_pdo = new \PDO($this->getDsn(), $this->getUser(), $this->getPwd(), $this->getOpt_persistent());
        }

        return $this->_pdo;
    }

    function getDsn() {
        return $this->_dsn;
    }

    function getUser() {
        return $this->_user;
    }

    function getPwd() {
        return $this->_pwd;
    }

    function getOpt_persistent() {
        return $this->_opt_persistent;
    }

    function getErr_manager() {
        return $this->_err_manager;
    }
    
    

}
