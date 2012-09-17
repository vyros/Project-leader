<?php

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "ajouter") {

    $idEtat = (isset($_POST["etat"])) ? $_POST["etat"] : null;
    $libelle = (isset($_POST["libelle"])) ? $_POST["libelle"] : null;
    $tabIdCompetence = explode(',', $_POST["blahComp"]);
    $tabIdCategorie = explode(',', $_POST["blahCat"]);
    $description = (isset($_POST["description"])) ? $_POST["description"] : null;
    $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
    $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;
    $tabFichiers = (isset($_POST["fichier"])) ? $_POST["fichier"] : null;
    
    /* @var $objProjet Projet */
    $objProjet = Projet::add($idEtat, $libelle, $description, $budget, $echeance);
    if ($objProjet instanceof Projet) {

        // AUCUN TEST DE GETUTILISATEUR
        $objProjet->addParticipation(Site::getUtilisateur()->getId());
        
        // Retirer les classes d'associations
        Correspondre::addCategories($objProjet->getId(), $tabIdCategorie);
        Demander::addCompetences($objProjet->getId(), $tabIdCompetence);

        if (!is_null($tabFichiers))
            Document::addDocument($fichier, date("c"), Site::getUtilisateur()->getId(), $objProjet->getId());

        $message[succes] = "Enregistrement effectué avec succès !";
        $view = "liste";
        
    } else {
        $message[erreur] = "Erreur lors de l'enregistrement !";
        $view = "ajouter";
    }
    
} elseif (!is_null($action) && $action == "editer") {

    if ($idProjet = Site::isValidId($_POST["id"])) {

//        $idEtat = (isset($_POST["idEtat"])) ? $_POST["idEtat"] : null;
        $libelle = (isset($_POST["libelle"])) ? $_POST["libelle"] : null;
        $tabIdCompetence = explode(',', $_POST["blahComp"]);
        $tabIdCategorie = explode(',', $_POST["blahCat"]);
        $description = (isset($_POST["description"])) ? $_POST["description"] : null;
        $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
        $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;

        /* @var $objProjet Projet */
        $objProjet = new Projet($idProjet);

        $objProjet->setBudget($budget);
        $objProjet->setDescription($description);
        $objProjet->setEcheance($echeance);
//        $objProjet->setEtat($idEtat);
        $objProjet->setCategories($tabIdCategorie);
        $objProjet->setCompetences($tabIdCompetence);

//    $objDemander = new Demander();
//    $objDemander->modifDemande($idProjet, $tabIdCompetence);
//    
//    $objCorrespondance = new Correspondre();
//    $objCorrespondance->modifCorrespondance($idProjet, $tabIdCategorie);

        if (is_null($objProjet->edit())) {
            $message[erreur] = "Erreur lors de la modification !";
        } else {
            $message[succes] = "Modification réussie !";
        }

        $view = "liste";
    } else {
        $message[erreur] = "Erreur lors de la modification !";
    }
} elseif (!is_null($action)) {
    $message[erreur] = "Action inconnue !";
}

/**
 * Vues 
 */
if (!is_null($view) && $view == "ajouter") {

    $lstCategorieIds = Categorie::getLstNIds();
    $lstCompetenceIds = Competence::getLstNIds();

    include 'views/projetAjouter.php';
    
} elseif (!is_null($view) && $view == "fini") {

    $idUtilisateur = null;
    if (Site::getUtilisateur()) {
        $idUtilisateur = Site::getUtilisateur()->getId();
        $lstProjetIds = Site::getUtilisateur()->getLstNLastClosedProjetIds();
    }

    include 'views/projetFini.php';
} elseif (!is_null($view) && $view == "liste") {
    
    $message[erreur] = (isset($_POST["message"])) ? $_POST["message"] : null;
    $message[succes] = (isset($_POST["message"])) ? $_POST["message"] : null;

    if ($objProjet instanceof Projet) {
        // Projet récupéré (suite à un ajout ou une edition)
        ;
    } elseif ($idProjet = Site::isValidId($_POST["id"])) {
        // Projet demandé (via getView)
        $objProjet = new Projet($idProjet);
    } else {
        // Pour liste de projets
        ;
    }
    
    $lstCategorieIds = Site::getOneLevelIntArray(Categorie::getLstNIds());
    
    
    if (!is_null($objProjet)) {
        
        //requete qui a pour result l'id CLIENT du projet selectionner
        $lstClient = Site::getOneLevelIntArray($objProjet->getPorteurIds());
        include 'views/projetFichePerso.php';
        
    } else {
        include 'views/projetListe.php';
    }
} elseif (!is_null($view) && $view == "favori") {
    
}

/**
 * Chargement du header lorsqu'une vue est définie
 */
if (!is_null($view)) {
    include_once('views/message.php');
    ?>
    <script language="javascript" type="text/javascript" src="js/oXHR.js"></script>
    <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            getHeader();
        });
    </script>
    <?php
}