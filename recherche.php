<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "Recherche") {
    
} else {

    
    $lstCategorieFils = Categorie::getListCategoriesFilsByCode(1);

    include 'views/recherchePrestataire.php';
}
?>
