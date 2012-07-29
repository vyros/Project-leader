<?php

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();
?>
<script type="text/javascript">
    $(document).ready(function(){
        getHeader();
    });
    $('#TitreDev').click(function () { anime('divDev')});
    $('#TitreMobile').click(function () { anime('divMobile')});
    $('#TitreBDD').click(function () { anime('divBDD')});
    $('#TitreDesign').click(function () { anime('divDesign')});
    $('#demo').hide();
</script>
<script language="javascript" type="text/javascript" src="js/tabler.js"></script>
<?php

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "liste") {

    if (isset($_POST[rech]) && $_POST[rech] != null) {

        //recupere les id des competences
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

            //recupere les id des projets associÃƒÂ©s       
            $requete = " SELECT prj_id FROM correspondre " .
                    " WHERE " . $req;

            $listProjets = Site::getConnexion()->getFetchArray($requete);
            $idUtilisateur = Site::getUtilisateur()->getId();
            echo '<script type="text/javascript">';
            echo "      $('#demo').show();";
            echo '</script>';
        }
    }
}

$lstCategorieFilsDev = Categorie::getListCategoriesFilsByCode(1);
$lstCategorieFilsMobile = Categorie::getListCategoriesFilsByCode(2);
$lstCategorieFilsBDD = Categorie::getListCategoriesFilsByCode(3);
$lstCategorieFilsDesign = Categorie::getListCategoriesFilsByCode(4);

include 'views/recherchePrestataire.php';
?>
