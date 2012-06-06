<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "valider") {

    //RECUPERER DONNEE
    $log = (isset($_POST["log"])) ? $_POST["log"] : null;
    $mdp = (isset($_POST["mdp"])) ? $_POST["mdp"] : null;

    /**
     * Le controleur définit le message suite à l'action 
     */
    $idUtilisateur = Utilisateur::getAccessToId($log, $mdp);
    if ($idUtilisateur !== null) {
        Site::setUtilisateur(new Utilisateur($idUtilisateur));
        
        $message[succes] = "Connexion réussie !";
    } else {
        $message[erreur] = "Erreur de login et/ou de mot de passe !";
    }
}

/**
 * Message 
 */
include 'views/message.php';

/**
 * Vues 
 */
if (Site::getUtilisateur() instanceof Utilisateur) {
    ?>
    <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
    <?php

    /**
     * L'accueil d'un utilisateur montre ses N derniers projets 
     */
    $lstUtilisateurProjetObjs = Site::getUtilisateur()->getLstNLastProjetObjs(5);
    
    if (Site::getUtilisateur()->getStatut() instanceof Client) {
        /**
         * L'accueill d'un client montre une liste de N prestataires 
         */
        $lstUtilisateurObjs = Prestataire::getLstNObjs(10);
        include 'views/accueilClient.php';
    } else {
        /**
         * L'accueill d'un prestataire montre une liste de N projets 
         */
        $lstProjetObjs = Projet::getLstNObjs(10);
        include 'views/accueilPrestataire.php';
    }

} else {
    include 'views/accueilVisiteur.php';
}
?>
