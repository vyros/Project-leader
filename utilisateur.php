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
            $objTmp->edit();

            $message[succes] = "Activation effectuée avec succès, vous pouvez à présent vous connecter !";
        } else {
            $message[erreur] = "Erreur !";
        }
        $view = "accueil";
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
        $objUtilisateur = Utilisateur::add($log, $mail, $mdp, $statut);
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
} elseif (!is_null($action) && $action == "note") {

    if (is_null($idFormulaire = Site::isValidId($_POST[idFormulaire])))
        return null;

    if (is_null($idProjet = Site::isValidId($_POST[idProjet])))
        return null;

    if (is_null($idUtilisateur = Site::isValidId($_POST[idUtilisateur])))
        return null;

    if (is_null($score = Site::isValidId($_POST[score])))
        return null;

    if (Evaluation::check($idUtilisateur, Site::getUtilisateur()->getId(), $idFormulaire, $idProjet)) {
        $objEvaluation = Evaluation::add($idProjet, Site::getUtilisateur()->getId(), $idUtilisateur, $idFormulaire, $score);
        $message[succes] = "Évaluation enregistrée !";
    } else {
        $message[erreur] = "Évaluation déjà enregistrée !";
    }
} elseif (!is_null($action) && $action == "onglet") {

    if (is_null($idUtilisateur = Site::isValidId($_POST["id"])))
        ;

    $contenu = (isset($_POST["contenu"])) ? $_POST["contenu"] : null;
    $objUtilisateur = null;

    if (!is_null($idUtilisateur) && $idUtilisateur != Site::getUtilisateur()->getId()) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
        
    } elseif (!is_null($idUtilisateur) && $idUtilisateur == Site::getUtilisateur()->getId()) {
        $objUtilisateur = &Site::getUtilisateur();
    }

    if (is_null($objUtilisateur)) {
        $message[erreur] = "Utilisateur incorrect !";
    } else {
        if (!is_null($contenu)) {

            $lstObjets = null;
            switch ($contenu) {
                case 'closed':
                    $t_array = $objUtilisateur->getNClosedProjetIds(5);
                    if (!is_null($t_array)) {
                        foreach ($t_array as $value) {
                            $lstObjets[] = new Projet($value);
                        }
                    }
                    break;

                case 'opened':
                    $t_array = $objUtilisateur->getNOpenedProjetIds(5);
                    if (!is_null($t_array)) {
                        foreach ($t_array as $value) {
                            $lstObjets[] = new Projet($value);
                        }
                    }
                    break;

                case 'comments':
                    $t_array = $objUtilisateur->getNCommentaireIds(5);
                    if (!is_null($t_array)) {
                        foreach ($t_array as $value) {
                            $lstObjets[] = new Projet($value);
                        }
                    }
                    break;

                default:
                    break;
            }

            include 'views/utilisateurOnglet.php';
        }
    }
} elseif (!is_null($action) && $action == "profil") {

    $id = (isset($_POST["id"])) ? $_POST["id"] : null;
    $_POST["id"] = (!is_null($id)) ? null : null;
    $nom = (isset($_POST["nom"])) ? $_POST["nom"] : null;
    $prenom = (isset($_POST["prenom"])) ? $_POST["prenom"] : null;
    $ddn = (isset($_POST["datepicker"])) ? $_POST["datepicker"] : null;
    $presentation = (isset($_POST["presentation"])) ? $_POST["presentation"] : null;
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
    $objUtilisateur->setPresentation($presentation);
    $objUtilisateur->setVille($ville);
    $objUtilisateur->setCvIds($cv);
    $objUtilisateur->setTel($tel);
    $objUtilisateur->setCompetenseIds($lstCompetenceIds);

    if (is_null($objUtilisateur->edit())) {
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

                // Faire la méthode sur l'utilisateur
                Utilisateur::StatutConnecte(Site::getUtilisateur()->getId());
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
 * Vues
 * 
 */
if (!is_null($view) && $view == "accueil") {

    if (Site::getUtilisateur() instanceof Utilisateur) {
        /**
         * L'accueil d'un utilisateur montre ses N derniers projets 
         */
        $lstUtilisateurProjetObjs = Site::getUtilisateur()->getNProjetObjs(5);

        if (Site::getUtilisateur()->getStatut() == "client") {
            /**
             * L'accueill d'un client montre une liste de N prestataires 
             */
            $lstUtilisateurObjs = Prestataire::getNObjs(10);
            include 'views/accueilClient.php';
        } else {
            /**
             * L'accueill d'un prestataire montre une liste de N projets 
             */
            $lstProjetObjs = Projet::getNObjs(10);
            include 'views/accueilPrestataire.php';
        }
        ?>
        <style>
            .ui-progressbar .ui-progressbar-value { background-image: url(images/pbar-ani.gif); }
        </style>
        <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
        <script>
            $(document).ready(function(){
                $( "#progressbar" ).progressbar({
                    value: <?php echo Site::getUtilisateur()->getRatio(); ?>
                });
            });
        </script>
        <?php
    } else {
        include 'views/accueilVisiteur.php';
    }
} elseif (!is_null($view) && $view == "inscription") {
    include 'views/utilisateurInscription.php';
    
} elseif (!is_null($view) && $view == "profil") {
    // Data
    $idUtilisateur = (isset($_POST["id"])) ? $_POST["id"] : null;
    $objUtilisateur = null;

    if (!is_null(Site::getUtilisateur()) && is_null($idUtilisateur)) {
        $objUtilisateur = &Site::getUtilisateur();
    } elseif (!is_null($idUtilisateur)) {
        $objUtilisateur = new Utilisateur($idUtilisateur);
    }

    if (is_null($objUtilisateur)) {
        $message[erreur] = "Utilisateur inexistant !";
        include 'views/accueilVisiteur.php';
    } else {
        include 'views/utilisateurProfil.php';
        ?>
        <script language="javascript" type="text/javascript" src="js/oXHR.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){             
                getOngletActif({'id' : '<?php echo $objUtilisateur->getId(); ?>'});

                // Calendrier
                $.datepicker.setDefaults( $.datepicker.regional[ "" ] );
                $( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
                                                                        
                // Liste
                $("#demo-input-local").tokenInput([
        <?php
        if (!is_null($lstCompetenceObjs = Competence::getNObjs())) {
            foreach ($lstCompetenceObjs as &$objCompetence) {
                ?>
                                    {
                                        id: <?php echo str_replace('"', '', json_encode($objCompetence->getId())); ?>, 
                                        name: "<?php echo str_replace('"', '', json_encode($objCompetence->getLibelle())); ?>"
                                    },
                <?php
                unset($lstCompetenceObjs);
            }
        }
        ?>
                ],
                { prePopulate: [
        <?php
        if (!is_null($lstCompetenceUtilisateurObjs = $objUtilisateur->getCompetenceObjs())) {
            foreach ($lstCompetenceUtilisateurObjs as &$objCompetence) {
                ?>
                                        {
                                            id: <?php echo str_replace('"', '', json_encode($objCompetence->getId())); ?>, 
                                            name: "<?php echo str_replace('"', '', json_encode($objCompetence->getLibelle())); ?>"
                                        },
                <?php
                unset($objCompetence);
            }
        }
        ?>
                    ]});
            });
        </script>
        <?php
    }
} elseif (!is_null($view) && $view == "note") {
    
    if (is_null($idProjet = Site::isValidId($_POST[idProjet])))
        ;

    if (is_null($idUtilisateur = Site::isValidId($_POST[idUtilisateur])))
        ;
    ?>
    <script language="javascript" type="text/javascript" src="js/evaluation.js"></script>
    <?php
    include 'views/evaluation.php';
}

/**
 * Chargement du header lorsqu'une vue est définie
 */
if (!is_null($view)) {
    include_once('views/message.php');
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            getHeader();
        });
    </script>
    <?php
}