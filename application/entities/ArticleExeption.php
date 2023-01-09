<?php 



class ArticleException extends \Exception{



    public function __construct($msg="",$code=0)
    {
        if(empty($msg)){
            $msg="L'instanciation d'un objet Article sans données!";
        }
        parent::__construct($msg,$code);
    }



    public function showCurrentDataError(){
        $str="";
            $str=print_r(debug_backtrace(),true);
            $str.=print_r(get_defined_vars(),true);
            return $str;
        }
}