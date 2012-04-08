<?php
include_once("classes/classUtilisateur.php");
session_start();
include_once("classes/classProjet.php");
include_once("classes/classCorrespondre.php");
include_once("classes/classCategorie.php");
include_once("classes/classParticiper.php");
include_once("classes/classDemander.php");

if ($_POST["action"] == "VerificationCompte") {

    //RECUPERER DONNEE
    $log = '';
    if (isset($_POST['log'])) {
        $log = $_POST['log'];
    }

    $mdp = '';
    if (isset($_POST['mdp'])) {
        $mdp = $_POST['mdp'];
    }

    $access = UTILISATEUR::verifAccess($log, $mdp);
    if ($access === false) {
        die(mysql_error());
    }

    if (mysql_num_rows($access) == 1) {

        $object = mysql_fetch_object($access);
        $_SESSION['monUtilisateur'] = new UTILISATEUR($object->uti_id);
        $_SESSION['ouvert'] = true;

        echo ("<script language = \"JavaScript\">alert('Connexion réussie');");
        echo ("location.href = '" . SITE::getUrl() . "#accueilPerso';");
        echo ("</script>");
    }
} elseif ($_POST["action"] == "inscripCompte") {

    $mail = $_POST["mail"];
    $log = $_POST["log"];
    $statut = $_POST["statut"];
    $mdp = $_POST["mdp"];
    $mdp2 = $_POST["mdp2"];

    if ($mdp != $mdp2) {

        echo ("<script language = \"JavaScript\">alert('erreur');");
        echo ("location.href = 'inscription.php';");
        echo ("</script>");
        
    } else {

        $monUtilisateur = new UTILISATEUR();
        if ($monUtilisateur->inserUti($log, $mail, $mdp, $statut)) {
            
            echo ("<script language = \"JavaScript\">alert('Enregistrement effectué avec succès !');");
            echo ("location.href = 'index.php#fin_inscrip';");
            echo ("</script>");
        }

        echo ("<script language = \"JavaScript\">alert('Erreur d'enregistrement !');");
        echo ("location.href = 'index.php';");
        echo ("</script>");
    }
    
} elseif ($_POST["action"] == "inserProjet") {

    $libelle = $_POST["libelle"];
    $categorie = $_POST["categorie"];
    $idCompetence = $_POST["blah"];
    $description = $_POST["description"];
    $budget = $_POST["budget"];
    $delai = $_POST["delai"];

    $tabIdCompetence = explode(',', $idCompetence);

    $monProjet = new PROJET();
    $monProjet->inserProjet($libelle, $description, $budget, $delai);

    $idProjet = PROJET::maxPjt();
    $idUti = $_SESSION['monUtilisateur']->getId();

    $participer = new PARTICIPER();
    $participer->inserParticip($idUti, $idProjet);

    $idCateg = CATEGORIE::getIdViaLib($categorie);

    $correspondre = new CORRESPONDRE();
    $correspondre->inserCorres($idProjet, $idCateg);

    $demander = new DEMANDER();
    $demander->inserDem($idProjet, $tabIdCompetence);

    echo ("<script language = \"JavaScript\">alert('Projet créer');");
    echo ("location.href = '" . SITE::getUrl() . "#accueilPerso';");
    echo ("</script>");
}
?>