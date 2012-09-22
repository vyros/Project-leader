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
        $lstCatId = $_POST[rech];
        $iter = 0;
        $req = "";

        //construction du where
        foreach ($lstCatId as $idCat) {
            if ($iter == 0) {
                $req = " cat_id = '" . $idCat . "' ";
                $iter++;
            } else {
                $req = $req . " OR cat_id = '" . $idCat . "' ";
                $iter++;
            }
        }

        //on a des checkbox cochés
        if (!is_null($req)) {

            if (Site::getUtilisateur()->getStatut() == "prestataire") {
                //recupere les id des projets associÃƒÂ©s       
                $requete = " SELECT prj_id FROM correspondre " .
                        " WHERE " . $req;

                $listProjets = Site::getConnexion()->getFetchArray($requete);
                $idUtilisateur = Site::getUtilisateur()->getId();

                if (!is_null($listProjets)) {
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
                //recupere les id des projets associÃƒÂ©s       
                $requete = " SELECT uti_id FROM posseder " .
                        " WHERE " . $req;

                $listUsers = Site::getConnexion()->getFetchArray($requete);
                $idUtilisateur = Site::getUtilisateur()->getId();

                if (!is_null($listUsers)) {
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

$lstCatIdPere = Categorie::getListCategoriesPere();
include 'views/recherchePrestataire.php';
?>
<script type="text/javascript">
    $(document).ready(function(){
        getHeader();
    });   
</script>
<script language="javascript" type="text/javascript" src="js/tabler.js"></script>