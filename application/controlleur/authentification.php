<?php

include_once '../libraries/autoloader.php';
use application\models;
//Autoloader::register();

function login() {
    $identifiant = htmlspecialchars($_POST['identifiant']);
    $password = htmlspecialchars($_POST['password']);
    var_dump($identifiant);
    var_dump($password);
    $PDOFactory = new PDOFactory("mysql:host=localhost;dbname=bibliotheque", "root", "", true);
    $ManagerCompte = new ManagerAuthentificationClient($PDOFactory->getPDO());
    var_dump($ManagerCompte);
    if ($ManagerCompte->access($identifiant, $password)):
        $datasSession = $ManagerCompte->getDatasSession($identifiant, $password);
        getCurrentSession($datasSession);
        header("Location:http://localhost/dossier_type_mvc/application/view/recherche.php");
   else :
        //Route::defaultRedirection();
         header("Location:http://localhost/dossier_type_mvc/application/view/authentification.php");
    endif;
}

function getCurrentSession(Utilisateur $utilisateur): void {
    session_start();
    $_SESSION['nom_utlstr']=$utilisateur->getnom();
    $_SESSION['prenom_utlstr']= $utilisateur->getprenom();
    $_SESSION['access_ctrl'] = session_id();
}

function logout() {
    //Code à ecrire
    unset($_SESSION);
    Route::defaultRedirection();
}

if (isset($_POST['action'])) :
    switch ($_POST['action']) {
        case "login":
            var_dump($_POST);
            login();
            break;
        case "logout":
            logout();
            break;
        default:
            // Route::defaultRedirection();
            break;
    } else:
    Route::defaultRedirection();
    endif;



