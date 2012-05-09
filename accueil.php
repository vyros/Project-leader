<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
SITE::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

// Action requise
if (!is_null($action) && $action == "getUtilisateur") {

    //RECUPERER DONNEE
    $log = (isset($_GET["log"])) ? $_GET["log"] : null;
    $mdp = (isset($_GET["mdp"])) ? $_GET["mdp"] : null;

    /**
     * Le controleur définit le message suite à l'action 
     */
    $idUtilisateur = UTILISATEUR::getAccessToId($log, $mdp);
    if ($idUtilisateur !== null) {
        SITE::setUtilisateur(new UTILISATEUR($idUtilisateur));
        
        $message[succes] = "Connexion réussie !";
    } else {
        $message[erreur] = "Erreur de login et/ou de mot de passe !";
    }
    
} elseif (!is_null($action) && $action == "addUtilisateur") {

    $mail = (isset($_GET["mail"])) ? $_GET["mail"] : null;
    $log = (isset($_GET["log"])) ? $_GET["log"] : null;
    $statut = (isset($_GET["statut"])) ? $_GET["statut"] : null;
    $mdp = (isset($_GET["mdp"])) ? $_GET["mdp"] : null;
    $mdp2 = (isset($_GET["mdp2"])) ? $_GET["mdp2"] : null;

    if ($mdp != $mdp2) {
        $message[erreur] = "Erreur !";
    } else {

        /* @var $objUtilisateur UTILISATEUR */
        $objUtilisateur = UTILISATEUR::addUtilisateur($log, $mail, $mdp, $statut);
        if ($objUtilisateur instanceof UTILISATEUR) {

            $message[succes] = "Enregistrement effectué avec succès !";
        } else {
            $message[erreur] = "Erreur !";
        }
    }
} elseif (!is_null($action) && $action == "viewFormulaire") {
    $viewFormulaire = true;
}

include 'views/message.php';

if (SITE::getUtilisateur() instanceof UTILISATEUR) {
    ?>
    <script type="text/javascript">
        var varTable;
    </script>

    <script>
        $(document).ready(function() {
            /* Add a click handler to the rows - this could be used as a callback */
            $("#example tbody").click(function(event) {
                $(varTable.fnSettings().aoData).each(function () {
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });
         
            /* Add a click handler for the delete row */
            $('#delete').click( function() {
                var anSelected = fnGetSelected( varTable );
                varTable.fnDeleteRow( anSelected[0] );
            } );
         
            /* Init the table */
            varTable = $('#example').dataTable( );
        } );

        function fnGetSelected( oTableLocal ) {
            var aReturn = new Array();
            var aTrs = oTableLocal.fnGetNodes();
         
            for ( var i=0 ; i<aTrs.length ; i++ )
            {
                if ( $(aTrs[i]).hasClass('row_selected') )
                {
                    aReturn.push( aTrs[i] );
                }
            }
            return aReturn;
        }
    </script>
    <?php

    /**
     * L'accueil d'un utilisateur montre ses N derniers projets 
     */
    $lstUtilisateurProjetObjs = SITE::getUtilisateur()->getLstNLastProjetObjs(5);
    
    if (SITE::getUtilisateur()->getStatut() instanceof CLIENT) {
        /**
         * L'accueill d'un client montre une liste de N prestataires 
         */
        $lstUtilisateurObjs = PRESTATAIRE::getLstNObjs(10);
        include 'views/accueilClient.php';
    } else {
        /**
         * L'accueill d'un prestataire montre une liste de N projets 
         */
        $lstProjetIds = PROJET::getLstNObjs(10);
        include 'views/accueilPrestataire.php';
    }

} elseif (isset ($objUtilisateur)) {
    include 'views/accueilUtilisateur.php';
    
} elseif (isset ($viewFormulaire)) {
    include 'views/accueilInscription.php';
    
} else {
    include 'views/accueilVisiteur.php';
}
?>
