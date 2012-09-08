<?php

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "ajouter") {

    $etatId = (isset($_POST["etat"])) ? $_POST["etat"] : null;
    $libelle = (isset($_POST["libelle"])) ? $_POST["libelle"] : null;
    $categorie = (isset($_POST["categorie"])) ? $_POST["categorie"] : null;
    $tabIdCompetence = explode(',', $_POST["blah"]);
    $description = (isset($_POST["description"])) ? $_POST["description"] : null;
    $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
    $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;

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

        $message[succes] = "Enregistrement effectué avec succès !";
    } else {
        $message[erreur] = "Erreur !";
    }
} elseif (!is_null($action) && $action == "editer") {

      
    $idProjet = (isset($_POST["idProjet"])) ? $_POST["idProjet"] : null;
    
    $etatId = (isset($_POST["etat"])) ? $_POST["etat"] : null;
    $libelle = (isset($_POST["libelle"])) ? $_POST["libelle"] : null;
    $categorie = (isset($_POST["categorie"])) ? $_POST["categorie"] : null;
    $tabIdCompetence = explode(',', $_POST["blahCat"]);
    $tabIdCategorie = explode(',', $_POST["blahComp"]);
    $description = (isset($_POST["description"])) ? $_POST["description"] : null;
    $budget = (isset($_POST["budget"])) ? $_POST["budget"] : null;
    $echeance = (isset($_POST["echeance"])) ? $_POST["echeance"] : null;

    
    $objProjet = new Projet($idProjet);
      
    $objProjet->setDescription($description);
    $objProjet->setBudget($budget);
    $objProjet->setEcheance($echeance);
    $objProjet->setStatut($etatId);
//    echo "la ok";
//    var_dump($tabIdCompetence);
//    var_dump($tabIdCategorie);
//         echo "la ok";
    $objDemander = new Demander();
    $objDemander->modifDemande($idProjet, $tabIdCompetence);
    
    $objCorrespondance = new Correspondre();
    $objCorrespondance->modifCorrespondance($idProjet, $tabIdCategorie);
  

    if (is_null($objProjet->editProjet())) {
        $message[erreur] = "Erreur lors de la modification !";
    } else {
        $message[succes] = "Modification réussie !";
    }
    
    $view = "liste";
    $idTmp = $idProjet;
}


//include 'views/message.php';

/**
 * Vues 
 */
if (!is_null($view)) {
    ?>
    <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
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

    if(isset($idTmp) && $idTmp != "")
    {
        $idProjet = $idTmp;
    }else{
        $idProjet = (isset($_POST["id"])) ? $_POST["id"] : null;
    }
    
    $lstProjetIds = Projet::getLstNIds(10);

    $idUtilisateur = null;
    if (Site::getUtilisateur() && !isset($_POST['all'])) {
        $idUtilisateur = Site::getUtilisateur()->getId();
        $lstProjetIds = Site::getUtilisateur()->getLstNLastProjetIds(10);
    }

    if (!is_null($idProjet)) {
        unset($lstProjetIds);
        $lstProjetIds[] = array(0 => $idProjet);
    }

    if ($lstProjetIds[1] == "") {
        
        $idProjet = $lstProjetIds[0][0];
        $objProjet = new Projet($idProjet);

        //requete qui a pour result l'id CLIENT du projet selectionner
        $lstClient = PARTICIPER::voirParticipationCli($idProjet);
        if(mysql_num_rows($lstClient)== 1)			
	{
            $object=mysql_fetch_object($lstClient);	
            $idClientProjet = $object->uti_id;
        }
        
          // CA C NAZE
//        $i = 0;
//        while ($row = mysql_fetch_array($tabClientProjet)) {
//            $idClientProjet[$i] = "$row[uti_id]";
//        }
          
        if ($idClientProjet[0] == $idUtilisateur) {
            
            include 'views/projetFichePerso.php';
        } else {
            include 'views/projetFiche.php';
        }
    } else {
        include 'views/projetListe.php';
    }
}elseif (!is_null($view) && $view == "favori") {
    
    
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        getHeader();
    });
</script>