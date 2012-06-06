<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_GET["action"])) ? $_GET["action"] : null;
$view = (isset($_GET["view"])) ? $_GET["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "ajouter") {

    $etatId = (isset($_GET["etat"])) ? $_GET["etat"] : null;
    $libelle = (isset($_GET["libelle"])) ? $_GET["libelle"] : null;
    $categorie = (isset($_GET["categorie"])) ? $_GET["categorie"] : null;
    $tabIdCompetence = explode(',', $_GET["blah"]);
    $description = (isset($_GET["description"])) ? $_GET["description"] : null;
    $budget = (isset($_GET["budget"])) ? $_GET["budget"] : null;
    $echeance = (isset($_GET["echeance"])) ? $_GET["echeance"] : null;

    /* @var $objProjet Projet */
    $objProjet = Projet::addProjet($etatId, $libelle, $description, $budget, $echeance);

    if ($objProjet instanceof Projet) {
        $idUtilisateur = Site::getUtilisateur()->getId();
        
        $objParticiper = new Participer();
        $objParticiper->addParticipation(Site::getUtilisateur()->getId(), $objProjet->getId());
        
        $objCorrespondre = new Correspondre();
        $objCorrespondre->addCorrespondance($objProjet->getId(), $categorie);
        
        $objDemander = new Demander();
        $objDemander->addDemande($objProjet->getId(), $tabIdCompetence);

        $message[succes] = "Enregistrement effectuÃ© avec succÃ¨s !";
    } else {
        $message[erreur] = "Erreur !";
    }
}

include 'views/message.php';

/**
 * Vues 
 */
if (!is_null($view)){
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
}
if (!is_null($view) && $view == "ajouter") {

    $lstCategorieIds = Categorie::getLstNIds();
    $lstCompetenceIds = Competence::getLstNIds();

    include 'views/projetAjouter.php';
    
} elseif (!is_null($view) && $view == "fini") {
    
    $idUtilisateur = null;
    if (Site::getUtilisateur()) {
        $idUtilisateur = Site::getUtilisateur()->getId();
        $lstProjetIds = Site::getUtilisateur()->getLstNLastClosedProjetIds();
    }
    
    include 'views/projetFini.php';

} elseif (!is_null($view) && $view == "liste") {
    
    $idProjet = (isset($_GET["id"])) ? $_GET["id"] : null;
    $lstProjetIds = Projet::getLstNIds(10);

    $idUtilisateur = null;
    if (Site::getUtilisateur() && !isset($_GET['all'])) {
        $idUtilisateur = Site::getUtilisateur()->getId();
        $lstProjetIds = Site::getUtilisateur()->getLstNLastProjetIds(10);
    }

    if (!is_null($idProjet)) {
        unset($lstProjetIds);
        $lstProjetIds[] = array(0 => $idProjet);
    }

    include 'views/projetListe.php';
}