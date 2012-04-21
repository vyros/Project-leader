<?php
include_once("models/classSite.php");
SITE::init();

if ($_POST["action"] == "getUtilisateur") {

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
        $message[succes] = "Succès !";
    } else {
        $message[erreur] = "Erreur !";
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

        /* @var $objUtilisateur UTILISATEUR */
        $objUtilisateur = UTILISATEUR::addUtilisateur($log, $mail, $mdp, $statut);
        if ($objUtilisateur instanceof UTILISATEUR) {

            echo ("<script language = \"JavaScript\">alert('Enregistrement effectué avec succès !');");
            echo ("location.href = 'index.php#inscription';");
            echo ("</script>");
        }

        echo ("<script language = \"JavaScript\">alert('Erreur d'enregistrement !');");
        echo ("location.href = 'index.php';");
        echo ("</script>");
    }
} elseif ($_POST["action"] == "AddProjet") {

    $etatId = $_POST["etat"];
    $libelle = $_POST["libelle"];
    $categorie = $_POST["categorie"];
    $tabIdCompetence = explode(',', $_POST["blah"]);
    $description = $_POST["description"];
    $budget = $_POST["budget"];
    $echeance = $_POST["echeance"];

    /* @var $objProjet PROJET */
    $objProjet = PROJET::addProjet($etatId, $libelle, $description, $budget, $echeance);
    if ($objProjet instanceof PROJET) {

        $idUtilisateur = SITE::getUtilisateur()->getId();

        $objParticiper = new PARTICIPER();
        $objParticiper->addParticipation(SITE::getUtilisateur()->getId(), 
                $objProjet->getId());

        $objCorrespondre = new CORRESPONDRE();
        $objCorrespondre->addCorrespondance($objProjet->getId(), 
                CATEGORIE::getIdFromLibelle($categorie));

        $objDemander = new DEMANDER();
        $objDemander->addDemande($objProjet->getId(), $tabIdCompetence);

        echo ("<script language = \"JavaScript\">alert('Projet créer avec succès');");
        echo ("location.href = 'index.php#accueil';");
        echo ("</script>");
    }
}
?>