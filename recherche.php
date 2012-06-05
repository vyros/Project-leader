<?php

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "liste") {
    echo '<pre>';
    print_r($_GET);
    echo '</pre>';
} else {
    $lstCategorieFilsDev = Categorie::getListCategoriesFilsByCode(1);
    $lstCategorieFilsMobile = Categorie::getListCategoriesFilsByCode(2);
    $lstCategorieFilsBDD = Categorie::getListCategoriesFilsByCode(3);
    $lstCategorieFilsDesign = Categorie::getListCategoriesFilsByCode(4);
    include 'views/recherchePrestataire.php';
}
?>
