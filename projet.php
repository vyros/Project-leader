<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
SITE::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

// Action requise
if (!is_null($action) && $action == "addProjet") {

    $etatId = (isset($_GET["etat"])) ? $_GET["etat"] : null;
    $libelle = (isset($_GET["libelle"])) ? $_GET["libelle"] : null;
    $categorie = (isset($_GET["categorie"])) ? $_GET["categorie"] : null;
    $tabIdCompetence = explode(',', $_POST["blah"]);
    $description = (isset($_GET["description"])) ? $_GET["description"] : null;
    $budget = (isset($_GET["budget"])) ? $_GET["budget"] : null;
    $echeance = (isset($_GET["echeance"])) ? $_GET["echeance"] : null;

    /* @var $objProjet PROJET */
    $objProjet = PROJET::addProjet($etatId, $libelle, $description, $budget, $echeance);

    if ($objProjet instanceof PROJET) {
        $idUtilisateur = SITE::getUtilisateur()->getId();
        $objParticiper = new PARTICIPER();

        $objParticiper->addParticipation(SITE::getUtilisateur()->getId(), $objProjet->getId());
        $objCorrespondre = new CORRESPONDRE();
        $objCorrespondre->addCorrespondance($objProjet->getId(), CATEGORIE::getIdFromLibelle($categorie));
        $objDemander = new DEMANDER();
        $objDemander->addDemande($objProjet->getId(), $tabIdCompetence);

        $message[succes] = "Enregistrement effectué avec succès !";
    } else {
        $message[erreur] = "Erreur !";
    }
}

include 'views/message.php';

if(!is_null($view) && $view == "addProjet") {
    
    $lstCategorieIds = CATEGORIE::getLstNIds();
    $lstCompetenceIds = COMPETENCE::getLstNIds();
    
    include 'views/projetAdd.php';
}