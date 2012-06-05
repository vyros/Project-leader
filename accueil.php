<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "valider") {

    //RECUPERER DONNEE
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
}

/**
 * Message 
 */
include 'views/message.php';

/**
 * Vues 
 */
if (Site::getUtilisateur() instanceof Utilisateur) {
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
?>
