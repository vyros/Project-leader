<?php
include_once("classes/classSite.php");
SITE::init();

$all = false;
if(isset($_GET['all']) && $_GET['all'] === true) {
    $all = true;
}

if(SITE::chkUtilisateur() && !$all) {
    if (isset($_GET['idProjet'])) {
        $objProjet = new PROJET($_GET['idProjet']);
        echo ('- ');
        echo $objProjet;
        echo ('</br>');
        
    } else {
        $lstProjetId = SITE::getUtilisateur()->getNLastProjetId();
        foreach ($lstProjetId as $idProjet) {
            $objProjet = new PROJET($idProjet);
            echo ('- ');
            echo $objProjet;
            echo ('</br>');
        }
    }
?>

<?php    
} else {
?>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th class="sorting_asc">Intitulé</th>
                <th class="sorting_asc">Catégorie</th>
                <th class="sorting_asc">Budget</th>
                <th class="sorting_asc">Compétence requise</th>
                <th class="sorting_asc">Date de création</th>
                <th class="sorting_asc">Description</th>
            </tr>
        </thead>
        <tbody>
<?php
            $lstProjetId = PROJET::getNLastProjetId(10);
            foreach ($lstProjetId as $id) {
                $objProjet = new PROJET($id);
                ?>
            <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                    <td id="libelle">
                        <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                        <?php echo $objProjet->getLibelle(); ?>
                    </td>

                    <td id="categorie">
                        <input type="hidden" name="categorie" value="<?php echo '???'; ?>">
<?php
                        $lstCategorieId = $objProjet->getAllCategorie();
                        foreach ($lstCategorieId as $idCategorie) {
                            $objCategorie = new CATEGORIE($idCategorie);
                            echo ('- ');
                            echo $objCategorie->getLibelle();
                            echo ('</br>');
                        }
?>											
                    </td>

                    <td id="budget">
                        <input type="hidden" name="budget" value="<?php echo $objProjet->getBudget(); ?>">
                        <?php echo $objProjet->getBudget(); ?>											
                    </td>

                    <td id="competence">
                        <input type="hidden" name="competence" value="<?php echo '???'; ?>">
<?php
                        $lstCompetenceId = $objProjet->getAllCompetence();
                        foreach ($lstCompetenceId as $idCompetence) {
                            $objCompetence = new COMPETENCE($idCompetence);
                            echo ('- ');
                            echo $objCompetence->getLibelle();
                            echo ('</br>');
                        }
?>									
                    </td>

                    <td id="dateCreation">
                        <input type="hidden" name="dateCreation" value="<?php echo $objProjet->getDateCreation(); ?>">
                        <?php echo $objProjet->getDateCreation(); ?>											
                    </td>
                    
                    <td id="description">
                        <input type="hidden" name="description" value="<?php echo $objProjet->getDescription(); ?>">
                        <?php echo $objProjet->getDescription(); ?>											
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<?php
}
?>
