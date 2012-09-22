<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_lstPjtFavori.png"/> 
            <div class="header_02">Mes projets favoris</div>
        </div>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th class="sorting_asc">Intitulé</th>
                        <th class="sorting_asc">Catégorie</th>
                        <th class="sorting_asc">Date de création</th>
                        <th class="sorting_asc">Description</th>
                        <th class="sorting_asc">Accès</th>
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
                                            echo $objCategorie->getLibelle();
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
                                        <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>
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

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div><!-- end of a section -->