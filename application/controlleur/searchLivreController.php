<?php


namespace application\controller;
require_once '../libraries/autoloader.php';
use ArticlesManager;
use PDOFactory;




function rechercher() {
    if (isset($_POST["ref"])) {
        $Ref = htmlspecialchars($_POST["ref"]);
        $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", $user = "root", $pwd = "", true);
        $ArticlesManager = new ArticlesManager($PDOFactory->getPDO());
        $listeLivre = $ArticlesManager->getListeLivre($Ref);
        var_dump($listeLivre);
        if (empty($listeLivre)):
            echo json_encode($listeLivre);
        else:
            echo json_encode(false);
        endif;
    }
}



if (isset($_POST['action'])) {;
    switch ($_POST['action']) {
        case "rechercher":
            rechercher();
            break;
        case "rechercherArticle":
           // rechercherArticles();
            break;
        default:
            break;
    }
}