<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">
    <div class="header_02">Vos derniers projets</div>
    <div id="demo">
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
                if (!is_null($lstProjetIds)) {
                    foreach ($lstProjetIds as $idProjet) {
                        $objProjet = new Projet($idProjet);
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

                                if (!is_null($lstCategorieIds)) {
                                    foreach ($lstCategorieIds as $idCategorie) {
                                        $objCategorie = new Categorie($idCategorie);
                                        echo ('- ');
                                        echo $objCategorie->getLibelle();
                                        echo ('</br>');
                                    }
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

                                if (!is_null($lstCompetenceIds)) {
                                    foreach ($lstCompetenceIds as $idCompetence) {
                                        $objCompetence = new Competence($idCompetence);
                                        echo ('- ');
                                        echo $objCompetence->getLibelle();
                                        echo ('</br>');
                                    }
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
                                    <?php echo "boutons d'actions"; ?>							
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div><!-- end of a section -->