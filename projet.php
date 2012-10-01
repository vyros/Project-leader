<?php
/*
 * Contrôleur de projet.
 * 
 * @author nicolas.gard / jimmy
 */

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
    $tabCompetenceIds = explode(',', $_POST["blahComp"]);
    $description = (isset($_POST["description"])) ? $_POST["description"] : null;
    $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
    $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;
    $tabDocuments = (isset($_POST["document"])) ? $_POST["document"] : null;

    if (!is_null($libelle) && $libelle != "") {

        /* @var $objProjet Projet */
        $objProjet = Projet::add($idEtat, $libelle, $description, $budget, $echeance);
        if ($objProjet instanceof Projet) {

            // TEST DE GETUTILISATEUR
            $objProjet->addParticipation(Site::getUtilisateur()->getId());
            $objProjet->addCompetences($tabCompetenceIds);

            if (!is_null($tabDocuments))
                Document::add($tabDocuments, date("c"), Site::getUtilisateur()->getId(), $objProjet->getId());

            $message[succes] = "Enregistrement effectué avec succès !";
            $view = "liste";
        } else {
            $message[erreur] = "Erreur lors de l'enregistrement !";
            $view = "ajouter";
        }
    } else {
        $message[erreur] = "Erreur, veuillez au moins donner un intitulé au projet !";
        $view = "ajouter";
    }
} elseif (!is_null($action) && $action == "document") {

    // Permet d'inclure l'index comme html
    header("Content-Type: text/html");

    if (!is_null($idProjet = Site::isValidId($_POST["id"]))) {

        $maxsize = (isset($_POST["MAX_FILE_SIZE"])) ? $_POST["MAX_FILE_SIZE"] : "1048576";
        $next = (isset($_POST["next"])) ? $_POST["next"] : "1";

        if (is_numeric($next))
            $next = (Integer) $next;
        else
            $next = 0;

        if (Site::getUtilisateur() instanceof Utilisateur) {
            $idUtilisateur = Site::getUtilisateur()->getId();
        }

        /* @var $objProjet Projet */
        $objProjet = new Projet($idProjet);

        $i = $next;
        while (isset($_FILES["document$i"])) {
            if (isset($_FILES["document$i"]['name']) && $_FILES["document$i"]['name'] != "") {
                $libelle = basename($_FILES["document$i"]['name']);
                $filesize = filesize($_FILES["document$i"]['tmp_name']);
                $extension = strrchr($_FILES["document$i"]['name'], '.');
                $extensions = array('.doc', '.docx', '.rtf', '.pdf', '.txt');

                // Contrôle de taille
                if ($filesize > $maxsize) {
                    $message[erreur] = "$filename est trop gros !";
                    $i++;
                    continue;
                }

                // Contrôle de type
                if (!in_array($extension, $extensions)) {
                    $message[erreur] = "$filename n'est pas un document de type doc, docx, rtf, txt ou pdf.";
                    $i++;
                    continue;
                }

                // Contrôle du libelle
                $libelle = strtr($libelle, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $libelle = preg_replace('/([^.a-z0-9]+)/i', '-', $libelle);

                // Id unique pour éviter les doublons
                $filename = uniqid("projet-" . $objProjet->getId() . "-");

                if (is_null($idDocument = Document::add("projet", $filename, $libelle, $idUtilisateur, $objProjet->getId(), $_FILES["document$i"]))) {
                    $message[erreur] = "Erreur lors de l'ajout de $libelle !";
                } else {
                    $message[succes] = "$libelle ajouté avec succès !";
                }
            }
            $i++;
        }
        include_once 'index.php';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});
            });
        </script>
        <?php
    } else {
        $message[erreur] = "Erreur lors de la modification !";
        include_once 'index.php';
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                getView({'controller' : 'utilisateur', 'view' : 'accueil'});
            });
        </script>
        <?php
    }
} elseif (!is_null($action) && $action == "editer") {

    if (!is_null($idProjet = Site::isValidId($_POST["id"]))) {

//        $idEtat = (isset($_POST["idEtat"])) ? $_POST["idEtat"] : null;
        $libelle = (isset($_POST["libelle"])) ? $_POST["libelle"] : null;
        $tabCompetenceIds = explode(',', $_POST["blahComp"]);
        $description = (isset($_POST["description"])) ? $_POST["description"] : null;
        $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
        $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;

        if (Site::getUtilisateur() instanceof Utilisateur) {
            $idUtilisateur = Site::getUtilisateur()->getId();
        }

        /* @var $objProjet Projet */
        $objProjet = new Projet($idProjet);

        $objProjet->setBudget($budget);
        $objProjet->setDescription($description);
        $objProjet->setEcheance($echeance);
//        $objProjet->setEtat($idEtat);
        $objProjet->setCompetenceIds($tabCompetenceIds);

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

    $lstCompetenceObjs = Competence::getNObjs();

    include 'views/projetAjouter.php';
} elseif (!is_null($view) && ($view == "liste" || $view == "fini" || $view == "favori")) {

    $message[erreur] = (isset($_POST["message"])) ? $_POST["message"] : null;
    $message[succes] = (isset($_POST["message"])) ? $_POST["message"] : null;

    if ($objProjet instanceof Projet) {
        // Projet récupéré (suite à un ajout ou une edition)
        ;
    } elseif (!is_null($idProjet = Site::isValidId($_POST["id"]))) {
        // Projet demandé (via getView)
        $objProjet = new Projet($idProjet);

        //$lstPrjSimilaire = $objProjet->getProjetSimilaireIds();
    } else {
        // Pour liste de projets
        $idUtilisateur = null;
        if ($view == "liste") {
            if (Site::getUtilisateur()) {
                $idUtilisateur = Site::getUtilisateur()->getId();
                $lstProjetObjs = Projet::getNObjs(10);
            }
            // Ou liste de projets finis
        } else if ($view == "fini") {
            if (Site::getUtilisateur()) {
                $idUtilisateur = Site::getUtilisateur()->getId();
                $lstProjetObjs = Site::getUtilisateur()->getNClosedProjetObjs(10);
            }
        } else if ($view == "favori") {

            if (Site::getUtilisateur()) {
                $idUtilisateur = Site::getUtilisateur()->getId();
                // comprend pa ou est la fonction qui va chercher les projets favoris
                $lstProjetObjs = Site::getUtilisateur();
            }
        }
    }

    if (!is_null($objProjet)) {
        //requete qui a pour result l'id CLIENT du projet selectionner
        $lstPorteurIds = $objProjet->getPorteurIds();
        include 'views/projetFiche.php';
    } else {
        include 'views/projetListe.php';
    }
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
            unset($objCompetence);
        }
    }
    ?>
            ]
    <?php
    if (!is_null($objProjet)) {
        ?>
                    ,
                    { prePopulate: [
        <?php
        if (!is_null($lstCompetenceObjs = $objProjet->getCompetenceObjs())) {
            foreach ($lstCompetenceObjs as &$objCompetence) {
                ?>
                                            {
                                                id: <?php echo $objCompetence->getId(); ?>, 
                                                name: "<?php echo $objCompetence->getLibelle(); ?>"
                                            },
                <?php
                unset($objCompetence);
            }
        }
        ?>					
                        ]}
        <?php
    } else {
        ;
    }
    ?>
        );
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(".commenter").click(function() {

                var idEmetteur = $("#idEmetteur").val();
                var idProjet = $("#idProjet").val();
                var logEmetteur = $("#logEmetteur").val();
                var titre = $("#titre").val();
                var comment = $("#comment").val();
                var action = $("#action").val();

                var dataString = 'action=' + action + ' &titre=' + titre + ' &comment=' + comment + '&idEmetteur=' + idEmetteur + '&idProjet=' + idProjet + '&logEmetteur=' + logEmetteur;
                //alert(dataString);	
                if(comment=='')
                {
                    alert('Veuillez saisir un commentaire');
                }
                else
                {
                    $("#flash").show();
                    $("#flash").fadeIn(400).html('<img src="ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');

                    $.ajax({
                        type: "POST",
                        url: "notification.php",
                        data: dataString,
                        cache: false,
                        success: function(html){
                            $("ol#update").append(html);
                            $("ol#update li:last").fadeIn("slow");
                            document.getElementById('comment').value='';
                            $("#name").focus();
                            $("#flash").hide();
                        }
                    });
                }
                return false;
            });
                                                                            
            $("#btnfavoris").click(function() {
                                                                        
                var idUti = $("#idUti").val();
                var idPjt = $("#idPjt").val();

                var dataString = '&idUti=' + idUti + '&idPjt=' + idPjt;

                $.ajax({
                    type: "POST",
                    url: "favoris.php",
                    data: dataString,
                    cache: false,
                    success: function(res){
                        $("#btnfavoris").hide();
                        $("#lblFav").show();
                    }
                });   
            });
        });
    </script>
    <?php
}