<?php
/*
 * Vue d'une liste de projets existant.
 * 
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">

            <?php
            if ($view == "fini") {
                ?>
                <img src="images/icone_lstPjtFini.png"/> 
                <div class="header_02">Vos projets menés à terme</div>
                <?php
            } else if ($view == "liste") {
                ?>
                <img src="images/icone_projet.png"/>
                <div class="header_02">Vos derniers projets</div>
                <?php
            } else if ($view == "favori") {
                ?>
                <img src="images/icone_lstPjtFavori.png"/> 
                <div class="header_02">Mes projets favoris</div>
                <?php
            }
            ?>

        </div>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th class="sorting_asc">Intitulé</th>
                        <th class="sorting_asc">Budget</th>
                        <th class="sorting_asc">Compétences requises</th>
                        <th class="sorting_asc">Date de création</th>
                        <th class="sorting_asc">Description</th>
                        <?php
                        if ($idUtilisateur !== null) {
                            ?>
                            <th class="sorting_asc">Accès</th>
                            <?php
                        } else {
                            ;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!is_null($lstProjetObjs = Projet::getNObjs())) {
                        foreach ($lstProjetObjs as &$objProjet) {
                            ?>
                            <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                                <td id="libelle">
                                    <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                                    <?php echo $objProjet->getLibelle(); ?>
                                </td>

                                <td id="competence">
                                    <input type="hidden" name="competence" value="">
                                    <?php
                                    if (!is_null($lstCompetenceObjs = $objProjet->getCompetenceObjs())) {
                                        foreach ($lstCompetenceObjs as &$objCompetence) {
                                            echo $objCompetence->getLibelle();
                                            echo ('</br>');
                                            unset($objCompetence);
                                        }
                                    }
                                    ?>									
                                </td>

                                <td id="budget">
                                    <input type="hidden" name="budget" value="<?php echo $objProjet->getBudget(); ?>">
                                    <?php echo $objProjet->getBudget(); ?>											
                                </td>

                                <td id="date">
                                    <input type="hidden" name="date" value="<?php echo $objProjet->getDate(); ?>">
                                    <?php echo $objProjet->getDate(); ?>											
                                </td>

                                <td id="description">
                                    <input type="hidden" name="description" value="<?php echo $objProjet->getDescription(); ?>">
                                    <?php echo $objProjet->getDescription(); ?>											
                                </td>
                                <?php
                                if ($idUtilisateur !== null) {
                                    ?>
                                    <td id="action">
                                        <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>

                                    </td>
                                    <?php
                                } else {
                                    
                                }
                                ?>
                            </tr>
                            <?php
                            unset($objProjet);
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div><!-- end of a section -->
<img class="imgAcc" src="images/demilogo2.png"/>

<div class="conteneur_bulle">
    <div class="messageBulle">
        <?php
        if ($idUtilisateur !== null) {
            if ($view == "liste") {
                ?>
                <span>Voici votre liste de projets sur le site. Pour voir la fiche complète d'un projet, cliquez sur  <img class="imgLienFiche" src="images/lien_fiche.png"/></span>
                <?php
            } else {
                ?>
                <span>Voici votre liste de projets finis sur le site. Pour voir la fiche complète d'un projet, cliquez sur  <img class="imgLienFiche" src="images/lien_fiche.png"/></span>
                    <?php
                }
            } else {
                ?>    
            <span>Voici une liste de projets posté sur le site. Pour voir la description complète des projets, vous devez être inscrit ou vous connecter ! <a onclick="getView({'controller' : 'utilisateur', 'view' : 'inscription'});">Cliquez ici</a></span>
            <?php
        }
        ?>
    </div>
</div>	