<?php
include_once("classes/classSite.php");
SITE::init();

if ($_POST["action"] == "chkUtilisateur") {

    //RECUPERER DONNEE
    $log = '';
    if (isset($_POST['log'])) {
        $log = $_POST['log'];
    }

    $mdp = '';
    if (isset($_POST['mdp'])) {
        $mdp = $_POST['mdp'];
    }

    $idUtilisateur = UTILISATEUR::getAccessToId($log, $mdp);
    if ($idUtilisateur !== null) {
        SITE::setUtilisateur(new UTILISATEUR($idUtilisateur));
        
        echo ("<script language = \"JavaScript\">");
        echo ("location.href = 'index.php#accueilCo';");
        echo ("</script>");
    }
} elseif ($_POST["action"] == "addUtilisateur") {

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

        $objUtilisateur = new UTILISATEUR();
        if ($objUtilisateur->addUtilisateur($log, $mail, $mdp, $statut)) {
            
            echo ("<script language = \"JavaScript\">alert('Enregistrement effectué avec succès !');");
            echo ("location.href = 'index.php#inscription';");
            echo ("</script>");
        }

        echo ("<script language = \"JavaScript\">alert('Erreur d'enregistrement !');");
        echo ("location.href = 'index.php';");
        echo ("</script>");
    }
    
} elseif ($_POST["action"] == "projetAdd") {

    $libelle = $_POST["libelle"];
    $categorie = $_POST["categorie"];
    $tabIdCompetence = explode(',', $_POST["blah"]);
    $description = $_POST["description"];
    $budget = $_POST["budget"];
    $echeance = $_POST["echeance"];

    $objProjet = new PROJET();
    if($objProjet->addProjet($libelle, $description, $budget, $echeance)) {
        
    }

    $idUtilisateur = SITE::getUtilisateur()->getId();

    $objParticiper = new PARTICIPER();
    $objParticiper->addParticipation(SITE::getUtilisateur()->getId(), 
            $objProjet->getId());

    $objCorrespondre = new CORRESPONDRE();
    $objCorrespondre->addCorrespondance($objProjet->getId(), 
            CATEGORIE::getIdFromLibelle($categorie));

    $objDemander = new DEMANDER();
    $objDemander->addDemande($objProjet->getId(), 
            $tabIdCompetence);

    echo ("<script language = \"JavaScript\">alert('Projet créer avec succès');");
    echo ("location.href = 'index.php#accueilCo';");
    echo ("</script>");
}
?>