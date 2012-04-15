<?php
include_once("classes/classSite.php");
SITE::init();

$lstProjetIds = PROJET::getLstNIds(10);

$idUtilisateur = null;
if (SITE::getUtilisateur() && !isset($_GET['all'])) {
    $idUtilisateur = SITE::getUtilisateur()->getId();
    $lstProjetIds = SITE::getUtilisateur()->getLstNLastProjetIds(10);
}

if (isset($_GET['idProjet'])) {
    unset($lstProjetIds);
    $lstProjetIds[] = array(0 => $_GET['idProjet']);
}
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
            <?php
            if ($idUtilisateur !== null) {
                echo '<th class="sorting_asc"></th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($lstProjetIds as $idProjet) {
            $objProjet = new PROJET($idProjet);
            ?>
            <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                <td id="libelle">
                    <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                    <?php echo $objProjet->getLibelle(); ?>
                </td>

                <td id="categorie">
                    <input type="hidden" name="categorie" value="<?php echo '???'; ?>">
                    <?php
                    $lstCategorieIds = $objProjet->getCategorieIds();
                    foreach ($lstCategorieIds as $idCategorie) {
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
                    $lstCompetenceIds = $objProjet->getCompetenceIds();
                    foreach ($lstCompetenceIds as $idCompetence) {
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
                <?php
                if ($idUtilisateur !== null) {
                    ?>
                    <td id="action">
                        <?php echo $objProjet->getDescription(); ?>							
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
