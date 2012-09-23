<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

?>
<script type="text/javascript">
    $('#content_col_w840').hide();
    $('#nores').hide();
    $('#content_col_w840Clients').hide();
</script>
<?php
/**
 * Actions 
 */
if (!is_null($action) && $action == "liste") {

    if (isset($_POST[rech]) && $_POST[rech] != null) {

        //recupere les id des categories
        $lstCptId = $_POST[rech];
        $iter = 0;
        $req = "";

        //construction du where
        foreach ($lstCptId as $idCpt) {
            if ($iter == 0) {
                $req = " cpt_id = " . $idCpt;
                $iter++;
            } else {
                $req = $req . " OR cpt_id = " . $idCpt;
                $iter++;
            }
        }

        //on a des checkbox cochés
        if (!is_null($req)) {

            if (Site::getUtilisateur()->getStatut() == "prestataire") {
                //recupere les id des projets associés       
                $requete = " SELECT prj_id FROM demander " .
                        " WHERE " . $req;

                $lstProjetIds = Site::getConnexion()->getFetchIntArray($requete);
                $idUtilisateur = Site::getUtilisateur()->getId();

                if (!is_null($lstProjetIds)) {
                    ?>
                    <script type="text/javascript">
                        $('#content_col_w840').show();
                    </script><?php } else {
                    ?>
                    <script type="text/javascript">;
                        $('#nores').html("Aucun projet ne correspond aux critères");
                        $('#nores').show();
                    </script>'<?php
                }
            } elseif (Site::getUtilisateur()->getStatut() == "client") {
                //recupere les id des projets associés
                $requete = " SELECT uti_id FROM posseder " .
                        " WHERE " . $req;

                $lstUtilisateurIds = Site::getConnexion()->getFetchIntArray($requete);
                $idUtilisateur = Site::getUtilisateur()->getId();

                if (!is_null($lstUtilisateurIds)) {
                    ?>
                    <script type="text/javascript">
                        $('#content_col_w840Clients').show();
                    </script><?php } else {
                    ?>
                    <script type="text/javascript">
                        $('#nores').html("Aucun prestataires ne correspond aux critères");
                        $('#nores').show();
                    </script>'<?php
                }
            }
        }
    }
}

$lstCompetenceMereIds = Competence::getCompetenceMereIds();
include 'views/recherchePrestataire.php';
?>
<script type="text/javascript">
    $(document).ready(function(){
        getHeader();
    });   
</script>
<script language="javascript" type="text/javascript" src="js/tabler.js"></script>