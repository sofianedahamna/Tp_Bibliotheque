<?php


namespace application\controller;

require_once '../libraries/autoloader.php';
use LivreManager;
use DvdManager;
use ArticlesManager;
use CdManager;
use JetBrains\PhpStorm\Internal\ReturnTypeContract;
use PDOFactory;

/** 

function rechercheArticlesParType()
{
        $liste=[];
        $type = htmlspecialchars($_POST["type"]);
        $keyword = htmlspecialchars($_POST["keyword"]);
        $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
        $ArticlesManager = new ArticlesManager($PDOFactory->getPDO());
    if (isset($keyword) && isset($type)) {
        switch ($type) {
            case 'Tous_Type':
                return $liste[]=$ArticlesManager->get($keyword);
            case "CD":
               return $liste[]=$ArticlesManager->get($keyword);
            case "DVD":
                return $liste[]=$ArticlesManager->getListeDvd($keyword);
            case "LIVRE":
                return $liste[]=$ArticlesManager->getListeLivre($keyword);
                

        } if (!empty($liste)) :
            echo json_encode($liste);
        else :
            echo json_encode(false);
        endif;
    }
       
}*/
function rechercheArticlesParType01()
{
    if (isset($_POST["keyword"])) {
        $keyword = htmlspecialchars($_POST["keyword"]);
        $type = htmlspecialchars($_POST["type"]);
        $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
        switch ($type) {
            case "Tous_Type":
                $ArticleManager = new ArticlesManager($PDOFactory->getPDO());
                $listeArticles = $ArticleManager->get($keyword);
                break;
            case "LIVRE":
                $LivreManager = new LivreManager($PDOFactory->getPDO());
                $listeArticles = $LivreManager->get($keyword);
                break;
            case "CD":
                $CdManager = new CdManager($PDOFactory->getPDO());
                $listeArticles = $CdManager->get($keyword);
                break;
            case "DVD":
                $DvdManager = new DvdManager($PDOFactory->getPDO());
                $listeArticles = $DvdManager->get($keyword);
                break;
            default:
                //home();
                break;
        }
        if (!empty($listeArticles)) :
            echo json_encode($listeArticles);
        else :
            echo json_encode(false);
        endif;
    }
}

function rechercher()
{
    if (isset($_POST["ref"])) {
        $Ref = htmlspecialchars($_POST["ref"]);
        $type = htmlspecialchars($_POST["type"]);
        $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
        $ArticlesManager = new ArticlesManager($PDOFactory->getPDO());
        $listeLivre = $ArticlesManager->getListeLivre($Ref);

        if (!empty($listeLivre)) :
            echo json_encode($listeLivre);
        else :
            echo json_encode(false);
        endif;
    }
}

function rechercheGlobal()
{  
    $Ref = htmlspecialchars($_POST["ref"]);
    $liste = [];
    $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
    $ArticlesManager = new ArticlesManager($PDOFactory->getPDO());
  //  if(!isset($Ref) && $Ref=="Livre" ){/** 
  //      $liste[]=$ArticlesManager->getListeLivre($Ref);
  //  }if($Ref=="DVD"){
  //      $liste[]=$ArticlesManager->getListeDvd($Ref);
  //  }if($Ref=="CD"){
  //      $liste[]=$ArticlesManager->getListeCd($Ref);
 //   }; 
  //  var_dump($liste);

 /** */ if(isset($Ref) && $Ref=="LIVRE" ){
    $liste[]=$ArticlesManager->getListeLivre($Ref);
}elseif($Ref=="DVD"){
    $liste[]=$ArticlesManager->getListeDvd($Ref);
}elseif($Ref=="CD"){
    $liste[]=$ArticlesManager->getListeCd($Ref);
}if (!empty($liste)){
        echo json_encode($liste);
    }else{
        echo json_encode(false);
    };

};

function rechercherArticles()
{
    if (isset($_POST["reference"])) {
        //var_dump($_POST);
        $listeArticle = null;
        $keyword = htmlspecialchars($_POST["reference"]);
        $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
        $articleManager = new ArticlesManager($PDOFactory->getPDO());
        $listeArticle =  $articleManager->getByRef($keyword);
        if (!empty($listeArticle)) :
            echo json_encode($listeArticle);
        else :
            echo json_encode(false);
        endif;
    }
};


if (isset($_POST['action'])) {;
    switch ($_POST['action']) {
        case "rechercher":
            rechercheGlobal();
            break;
        case "rechercherArticle":
            rechercheArticlesParType01();
            break;
        case "rechercherInfo":
           rechercherArticles();
            break;
        case "d":
            
            break;
    }
}
