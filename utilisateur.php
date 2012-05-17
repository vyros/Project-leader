<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "ajouter") {

    $mail = (isset($_GET["mail"])) ? $_GET["mail"] : null;
    $log = (isset($_GET["log"])) ? $_GET["log"] : null;
    $statut = (isset($_GET["statut"])) ? $_GET["statut"] : null;
    $mdp = (isset($_GET["mdp"])) ? $_GET["mdp"] : null;
    $mdp2 = (isset($_GET["mdp2"])) ? $_GET["mdp2"] : null;

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
    $log = (isset($_GET["log"])) ? $_GET["log"] : null;
    $mdp = (isset($_GET["mdp"])) ? $_GET["mdp"] : null;

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
    $idUtilisateur = (isset($_GET["id"])) ? $_GET["id"] : null;
    if ($idUtilisateur !== null) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
    } else {
        $message[erreur] = "Utilisateur inexistant !";
    }
    include 'views/utilisateurProfil.php';
}
?>
