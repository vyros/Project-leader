<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .ui-progressbar .ui-progressbar-value { background-image: url(images/pbar-ani.gif); }
</style>
<script>
    $(function() {
        $( "#progressbar" ).progressbar({
            value: <?php echo Site::getUtilisateur()->getRatio(); ?>
        });
    });
</script>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_projet.png"/> 
            <div class="header_02">Vos derniers projets</div>
        </div>

        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <p>
                    <?php
                    $i = 0;
                    if (!is_null($lstUtilisateurProjetObjs)) {
                        foreach ($lstUtilisateurProjetObjs as $objProjet) {
                            ?>
                            <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
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
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer un projet</a></div>
                <div class="cleaner"></div>            
            </div>
            <?php
        } else {
            echo "Aucun projet en cours";
            ?>
            <div class="section_w140 fr">
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'recherche'});">Rechercher un projet</a></div>
                <div class="cleaner"></div>            
            </div>
            <?php
        }
        ?>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div><!-- end of a section -->

<div class="content_col_w420 fr">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_compte.png"/> 
            <div class="header_02">Votre compte</div>
        </div>

        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <div class="header_03"><a onclick=""><div id="progressbar"></div></a></div>
            </div>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>

<div class="content_col_w840 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_projet.png"/> 
            <div class="header_02">Liste de projets</div>
        </div>

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
                                        <input type="hidden" name="dateCreation" value="<?php echo $objProjet->getDateCreation(); ?>">
                                        <?php echo $objProjet->getDateCreation(); ?>											
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

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>
<img class="imgAcc" src="images/demilogo2.png"/>

<div class="conteneur_bulle">
    <div class="messageBulle">
        <span>Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> !</span>
    </div>
</div>