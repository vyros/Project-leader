<?php
include_once("models/classSite.php");
SITE::init();

// Action requise
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

    /**
     * Le controleur définit le message suite à l'action 
     */
    $idUtilisateur = UTILISATEUR::getAccessToId($log, $mdp);
    if ($idUtilisateur !== null) {
        SITE::setUtilisateur(new UTILISATEUR($idUtilisateur));
        
        $message[succes] = "Succès !";
    } else {
        $message[erreur] = "Erreur !";
    }
    
    // Intrusif
    echo ("<script language = \"JavaScript\">");
//    echo ("location.href = 'index.php#accueil';");
    echo ("</script>");
    
} elseif ($_POST["action"] == "addUtilisateur") {

    $mail = $_POST["mail"];
    $log = $_POST["log"];
    $statut = $_POST["statut"];
    $mdp = $_POST["mdp"];
    $mdp2 = $_POST["mdp2"];

    if ($mdp != $mdp2) {

        echo ("<script language = \"JavaScript\">alert('erreur');");
        echo ("</script>");
    } else {

        /* @var $objUtilisateur UTILISATEUR */
        $objUtilisateur = UTILISATEUR::addUtilisateur($log, $mail, $mdp, $statut);
        if ($objUtilisateur instanceof UTILISATEUR) {

            $message = "Enregistrement effectué avec succès !";
            
            echo ("<script language = \"JavaScript\">alert('Enregistrement effectué avec succès !');");
//            echo ("location.href = 'index.php#accueil';");
            echo ("</script>");
        }

        echo ("<script language = \"JavaScript\">alert('Erreur d'enregistrement !');");
//        echo ("location.href = 'index.php';");
        echo ("</script>");
    }
}

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
//    $lstUtilisateurProjetObjs = SITE::getUtilisateur()->getLstNLastProjetObjs(5);
    SITE::setInformation("lstUtilisateurProjetObjs", 
            SITE::getUtilisateur()->getLstNLastProjetObjs(5));
    
    if (SITE::getUtilisateur()->getStatut() instanceof CLIENT) {
        /**
         * L'accueill d'un client montre une liste de N prestataires 
         */
//        $lstUtilisateurObjs = PRESTATAIRE::getLstNObjs(10);
        SITE::setInformation("lstUtilisateurObjs", 
            PRESTATAIRE::getLstNObjs(10));
        
        SITE::setView("accueilClient");
//        include 'views/accueilClient.php';
    } else {
        /**
         * L'accueill d'un prestataire montre une liste de N projets 
         */
//        $lstProjetIds = PROJET::getLstNObjs(10);
        SITE::setInformation("lstProjetIds", 
            PROJET::getLstNObjs(10));
        
        SITE::setView("accueilPrestataire");
//        include 'views/accueilPrestataire.php';
    }

} elseif (isset ($objUtilisateur)) {
    SITE::setView("accueilUtilisateur");
//    include 'views/accueilUtilisateur.php';
} else {
    SITE::setView("accueilVisiteur");
//    include 'views/accueilVisiteur.php';
}

if(!SITE::getController(true)) {
    SITE::getView();
}
?>
