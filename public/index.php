<?php
session_start();

require_once '../env.php';
require_once '../utils/functions.php';

require_once '../controller/Controller.php';
require_once '../controller/ControllerAuth.php';
require_once '../controller/ControllerHome.php';
require_once '../controller/ControllerAccount.php';

require_once '../model/Model.php';
require_once '../model/ModelAuth.php';

require_once '../view/View.php';
require_once '../view/ViewHeader.php';
require_once '../view/ViewFooter.php';
require_once '../view/ViewAuth.php';
require_once '../view/ViewHome.php';
require_once '../view/ViewAccount.php';


$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url)['path'];

switch($path){
    case "/":
        $viewHeader = new ViewHeader();
        $viewFooter = new ViewFooter();
        $viewHome = new ViewHome();

        $controller = new ControllerHome($viewHeader,$viewFooter, $viewHome);
        $controller->render();
        break;

    case "/connection":
        $modelUser = new ModelAuth(connect());
        //Création des View
        $viewHeader = new ViewHeader();
        $viewFooter = new ViewFooter();
        $viewAuth = new ViewAuth();

        //Créeation du controller
        $controller = new ControllerAuth($viewHeader, $viewFooter, $viewAuth, $modelUser);

        //Lancer le rendu de la page
        $controller->render();
        break;

    case "/account":
        $modelUser = new ModelAuth(connect());
        //Création des View
        $viewHeader = new ViewHeader();
        $viewFooter = new ViewFooter();
        $viewAccount = new ViewAccount();

        //Créeation du controller
        $controller = new ControllerAccount($viewHeader, $viewFooter, $viewAccount, $modelUser);

        //Lancer le rendu de la page
        $controller->render();
        break;

    case "/logout":
        session_destroy();
        header("Location: /");
        exit;

    default:
        http_response_code(404);
        echo "<h1>ERREUR 404 Page introuvable</h1>";
}