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

    $mail = (isset($_POST["mail"])) ? $_POST["mail"] : null;
    $log = (isset($_POST["log"])) ? $_POST["log"] : null;
    $statut = (isset($_POST["statut"])) ? $_POST["statut"] : null;
    $mdp = (isset($_POST["mdp"])) ? $_POST["mdp"] : null;
    $mdp2 = (isset($_POST["mdp2"])) ? $_POST["mdp2"] : null;

    if ($mdp != $mdp2) {
        $message[erreur] = "Erreur !";
    } else {

        /* @var $objUtilisateur Utilisateur */
        $objUtilisateur = Utilisateur::addUtilisateur($log, $mail, $mdp, $statut);
        if ($objUtilisateur instanceof Utilisateur) {

            $message[succes] = "Enregistrement effectué avec succès !";
            $view = "accueil";
        } else {
            $message[erreur] = "Erreur !";
            $view = "inscription";
        }
    }
} elseif (!is_null($action) && $action == "deconnexion") {
    Site::kill();
    $view = "deconnexion";
    
} elseif (!is_null($action) && $action == "profil") {
    $view = "profil";
    
} elseif (!is_null($action) && $action == "valider") {

    // Data
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
    $view = "inscription";
}

/**
 * Message 
 */
include 'views/message.php';

/**
 * Vues 
 */
if (!is_null($view) && $view == "accueil") {
    
    // Déprécié
    include 'views/utilisateurAccueil.php';
    
} elseif (!is_null($view) && $view == "deconnexion") {
    include 'views/utilisateurDeconnexion.php';
    
} elseif (!is_null($view) && $view == "inscription") {
    include 'views/utilisateurInscription.php';
    
} elseif (!is_null($view) && $view == "profil") {
    // Data
    $idUtilisateur = (isset($_POST["id"])) ? $_POST["id"] : null;
    $objUtilisateur = null;
    
    if(!is_null(Site::getUtilisateur())) {
        $objUtilisateur = &Site::getUtilisateur();
    }
    
    if(!is_null($idUtilisateur)) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
    }
    
    if(is_null($objUtilisateur)) {
        $message[erreur] = "Utilisateur inexistant !";
    } else {
        include 'views/utilisateurProfil.php';
    }
}
?>
