<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "activer") {

    $objTmp = new Utilisateur($_POST[id]);

    if ($objTmp instanceof Utilisateur) {
        $token = $_POST[token];

        // a rendre mieux !!!
        if ($token == $objTmp->getToken()) {
            $objTmp->setActif(true);
            $objTmp->editUtilisateur();

            $message[succes] = "Activation effectuée avec succès, vous pouvez à présent vous connecter !";
            $view = "accueil";
        } else {
            $message[erreur] = "Erreur !";
        }
    }
} elseif (!is_null($action) && $action == "ajouter") {

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

            include 'emails/emValidation.php';
            $message[succes] = "Enregistrement effectué avec succès, un email de confirmation vient de vous être envoyé !";
            //$view = "accueil";
        } else {
            $message[erreur] = "Erreur !";
            $view = "inscription";
        }
    }
} elseif (!is_null($action) && $action == "deconnexion") {

    Site::kill();
    $view = "accueil";
    //$view = "deconnexion";
} elseif (!is_null($action) && $action == "onglet") {

    $contenu = (isset($_POST["contenu"])) ? $_POST["contenu"] : null;
    $idUtilisateur = (isset($_POST["id"])) ? $_POST["id"] : null;
    $objUtilisateur = null;

    if (!is_null($idUtilisateur)) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
    }

    if (is_null($objUtilisateur)) {
        $message[erreur] = "Utilisateur inexistant !";
    } else {
        if (!is_null($contenu)) {
            switch ($contenu) {
                case 'closed':
                    $lstObjets = Utilisateur::getLstProjetObjsFromArrayIds($objUtilisateur->getLstNLastClosedProjetIds(5));
                    break;

                case 'opened':
                    $lstObjets = Utilisateur::getLstObjsFromFunction($objUtilisateur->getLstNLastOpenedProjetIds(5));
                    break;

                case 'comments':
                    $lstObjets = Utilisateur::getLstObjsFromFunction($objUtilisateur->getLstNLastCommentIds(5));
                    echo 'commentaires';
                    break;

                default:
                    break;
            }
            
            include 'views/utilisateurOnglet.php';
        }
    }
} elseif (!is_null($action) && $action == "profil") {

    $id = (isset($_POST["id"])) ? $_POST["id"] : null;
    $nom = (isset($_POST["nom"])) ? $_POST["nom"] : null;
    $prenom = (isset($_POST["prenom"])) ? $_POST["prenom"] : null;
    $ddn = (isset($_POST["ddn"])) ? $_POST["ddn"] : null;
    $ville = (isset($_POST["ville"])) ? $_POST["ville"] : null;
    $cv = (isset($_POST["cv"])) ? $_POST["cv"] : null;
    $tel = (isset($_POST["tel"])) ? $_POST["tel"] : null;
    $lstCompetenceIds = (isset($_POST["blah"])) ? explode(',', $_POST["blah"]) : null;

    if (Site::getUtilisateur()->getId() != $id) {
        $objUtilisateur = new Utilisateur($id);
    } else {
        $objUtilisateur = &Site::getUtilisateur();
    }

    $objUtilisateur->setNom($nom);
    $objUtilisateur->setPrenom($prenom);
    $objUtilisateur->setDdn($ddn);
    $objUtilisateur->setVille($ville);
    $objUtilisateur->setCvs($cv);
    $objUtilisateur->setTel($tel);
    $objUtilisateur->setCompetenses($lstCompetenceIds);
    
    if (is_null($objUtilisateur->editUtilisateur())) {
        $message[erreur] = "Erreur lors de la modification !";
    } else {
        $message[succes] = "Modification réussie !";
    }

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

        switch (Site::setUtilisateur(new Utilisateur($idUtilisateur))) {
            case 1:
                $message[succes] = "Connexion réussie !";
                break;
            case -1:
                $message[erreur] = "Erreur, ce compte est inactif !";
                break;
            case -2:
                $message[erreur] = "Erreur de login et/ou de mot de passe !";
                break;
            default:
                $message[erreur] = "Erreur inconnue !";
                break;
        }
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
 * 
 * Chargement du header lorsqu'une vue est définie
 */
if (!is_null($view)) {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            getHeader();
        });
    </script>
    <?php
}

if (!is_null($view) && $view == "accueil") {

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
} elseif (!is_null($view) && $view == "deconnexion") {
    include 'views/utilisateurDeconnexion.php';
    
} elseif (!is_null($view) && $view == "inscription") {
    include 'views/utilisateurInscription.php';
    
} elseif (!is_null($view) && $view == "profil") {
    // Data
    $idUtilisateur = (isset($_POST["id"])) ? $_POST["id"] : null;
    $objUtilisateur = null;

    if (!is_null(Site::getUtilisateur())) {
        $objUtilisateur = &Site::getUtilisateur();
    }

    if (!is_null($idUtilisateur)) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
    }

    if (is_null($objUtilisateur)) {
        $message[erreur] = "Utilisateur inexistant !";
    } else {
        $lstCompetenceIds = Competence::getLstNIds();
        $lstUserCompetenceIds = $objUtilisateur->getCompetenceIds();
        
        include 'views/utilisateurProfil.php';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                // Bug via la fonction                
                //getContenuOnglet({'id' : '<?php //echo $objUtilisateur->getId(); ?>'});
                                
                $.post("utilisateur.php", {
                    'action' : 'onglet',
                    'contenu' : 'closed',
                    'id' : '<?php echo $objUtilisateur->getId(); ?>'
                }, function(data) {
                    $('#contenuOnglet').html(data);
                })
            });
        </script>
        <?php
    }
}
?>