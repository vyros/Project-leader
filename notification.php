<?php
/*
 * Contrôleur de notification.
 * 
 * @author nicolas.gard
 */

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "commentaire ") {

    if (!is_null($idProjet = Site::isValidId($_POST['idProjet']))) {
        $objProjet = new Projet($idProjet);
        $receveurIds = $objProjet->getPorteurIds();
    } else {
        $receveurIds = null; ///////////////////////////////////////////////////////
    }

    if (is_null($idEmetteur = Site::isValidId($_POST['idEmetteur'])))
        return null;

    if (Site::getUtilisateur() instanceof Utilisateur && Site::getUtilisateur()->getId() == $idEmetteur) {
        $objUtilisateur = &Site::getUtilisateur();
    } else {
        $objUtilisateur = new Utilisateur($idEmetteur);
    }

    $titre = $_POST['titre'];
    $libelle = $_POST['comment'];

//    $idMaxNot = Notification::getMaxNot();
//    $idMaxNot = $idMaxNot + 1;
//    
//    $objEffect = Effectuer::addEvent($idUti, $idMaxNot);

    $date = date("Y/m/d");
    $objCom = Notification::addCommentaire($titre, $libelle, $objUtilisateur->getId(), $receveurIds, $objProjet->getId());
    ?>
    <li class="box">
        <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
        <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});"><?php echo $objUtilisateur->getLogin(); ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a écrit : <br />
        <?php echo $libelle; ?>
    </li>

    <?php
} else if (!is_null($action) && $action == "message ") {

    $idEmetteur = Site::getUtilisateur()->getId();
    $receveurIds = (isset($_POST["blah"])) ? explode(',', $_POST["blah"]) : null;
}


/**
 * Vues 
 */
if (!is_null($view)) {
    ?>
    <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
    <script language="javascript" type="text/javascript" src="js/jquery.tokeninput.js"></script>
    <?php
}

if (!is_null($view) && $view == "messagerie") {

    if (Site::getUtilisateur() instanceof Utilisateur) {

        $idUtilisateur = Site::getUtilisateur()->getId();


        ///////// A FAIRE VIA L'UTILISATEUR
        $lstMsgNonLu = Notification::msgNonLu($idUtilisateur);
        $lstMsgLu = Notification::msgLu($idUtilisateur);

        $nbreNonLu = Notification::getNbreNonLu($idUtilisateur);
        $nbreLu = Notification::getNbreLu($idUtilisateur);

        $lstUtilisateurObjs = Utilisateur::getNObjs(); /////////////////////////

        include 'views/utilisateurMessagerie.php';
    }
} else if (!is_null($view) && $view == "message") {

    $idMsg = (isset($_POST["id"])) ? $_POST["id"] : null;

    $objNotification = new Notification($idMsg);

//    $titre = $objNotification->getTitre();
//    $nom = $objNotification->getNom();
//    $libelle = $objNotification->getLibelle();
//    $date = $objNotification->getDate();

    $idUtilisateurCourant = Site::getUtilisateur()->getId();
    $idUtilisateur1 = $objNotification->getEmetteur();
    $idUtilisateur2 = $objNotification->getReceveur();

    $listMsgConvers = Notification::getConvers($idUtilisateurCourant, $idUtilisateur1, $idUtilisateur2);

//    var_dump($listMsgConvers);

    include 'views/utilisateurMessage.php';
}


if (!is_null($view)) {
    ?>

    <script type="text/javascript"> 
        $(function() {

            // Envoyer un message
            $(function() {
                $(".envoyerMsg").click(function() {

                    var idEmetteur = $("#idEmetteur").val();
                    var receveurIds = jQuery('input[name=blah]').val();
                    
                    // Serialiser le blah
                    
                    var logEmetteur = $("#logEmetteur").val();
                    var titre = $("#titre").val();
                    var comment = $("#comment").val();
                    var action = $("#action").val();

                    var dataString = 'action=' + action + ' &titre=' + titre + ' &comment=' + comment + '&idEmetteur=' + idEmetteur + '&receveurIds=' + receveurIds + '&logEmetteur=' + logEmetteur;

                    if(comment=='')
                    {
                        alert('Veuillez saisir un commentaire');
                    }
                    else
                    {
                        $("#flash").show();
                        $("#flash").fadeIn(400).html('<span class="loading">Loading Comment...</span>');

                        $.ajax({
                            type: "POST",
                            url: "notification.php",
                            //  url: "views/commentajax.php",
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
            });

    </script>
    <?php
}
?>