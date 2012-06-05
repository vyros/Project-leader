<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">
    <div class="header_02">Vos derniers projets</div>
    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <p>
                <?php
                $i = 0;
                if (!is_null($lstUtilisateurProjetObjs)) {
                    foreach ($lstUtilisateurProjetObjs as $objProjet) {
                        ?>
                        <a onclick="getControllerView('projet','liste','<?php echo $objProjet->getId(); ?>');">
                            <?php echo $objProjet->getLibelle(); ?></a><br />
                        <?php
                        $i++;
                    }
                }
                ?>
            </p>
        </div>
    </div>
    <?php
    if ($i != 0) {
        ?>
        <div class="section_w140 fr">
            <div class="rc_btn_02"><a onclick="getControllerView('projet', 'ajouter');">Créer un projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    } else {
        echo "Aucun projet en cours";
        ?>
        <div class="section_w140 fr">
            <div class="rc_btn_02"><a onclick="getControllerView('projet', 'ajouter');">Rechercher un projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    }
    ?>

    <div class="margin_bottom_10 border_bottom"></div>
    <div class="margin_bottom_30"></div>
    <div class="header_02">Liste de projets</div>
    <?php
// tester si dans les tables  posseder (relier à competence et cv) il existe l'idUti
// Si oui, afficher une liste des projets en rapport avec les compétences et/ou spécialité de l'uti
// Sinon, listes des 10 derniers projets postés
    ?>
    <div id="demo">
        <table id="listeProjet">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th class="sorting_asc">Intitulé</th>
                        <th class="sorting_asc">Catégorie</th>
                        <th class="sorting_asc">Budget</th>
                        <th class="sorting_asc">Compétence requise</th>
                        <th class="sorting_asc">Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!is_null($lstProjetObjs)) {
                        foreach ($lstProjetObjs as $objProjet) {
                            ?>
                            <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                                <td id="libelle">
                                    <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                                    <?php echo $objProjet->getLibelle(); ?>
                                </td>

                                <td id="categorie">
                                    <input type="hidden" name="categorie" value="<?php echo '???'; ?>">
                                    <?php
                                    $lstCategorieObjs = $objProjet->getCategorieObjs();

                                    if (!is_null($lstCategorieObjs)) {
                                        foreach ($lstCategorieObjs as $objCategorie) {
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
                                    $lstCompetenceObjs = $objProjet->getCompetenceObjs();

                                    if (!is_null($lstCompetenceObjs)) {
                                        foreach ($lstCompetenceObjs as $objCompetence) {
                                            echo ('- ');
                                            echo $objCompetence->getLibelle();
                                            echo ('</br>');
                                        }
                                    }
                                    ?>									
                                </td>

                                <td id="dateCreation">
                                    <input type="hidden" name="dateCreation" value="<?php echo $objProjet->getDate(); ?>">
                                    <?php echo $objProjet->getDate(); ?>											
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </table>
    </div>
    <div class="margin_bottom_20"></div>
</div><!-- end of a section -->


<div class="content_col_w420 fr">
    <div class="header_02">Votre compte</div>
    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <div class="header_03"><a onclick=""><div id="progressbar"></div></a></div>
        </div>
    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>
</div>