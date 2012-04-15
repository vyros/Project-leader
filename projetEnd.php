<?php
include_once("classes/classSite.php");
SITE::init();

$idUtilisateur = null;
if (SITE::getUtilisateur()) {
    $idUtilisateur = SITE::getUtilisateur()->getId();
    $lstProjetIds = SITE::getUtilisateur()->getLstNLastClosedProjetIds();
}
?>
<div id="templatemo_banner_wrapper">
    <div id="templatemo_banner">
        <div id="banner_content">
            <div id="banner_title">Liste de vos projets menés à terme</div>
            <div id="banner_text">
                
                <p><table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Intitulé</th>
                            <th class="sorting_asc">Catégorie</th>
                            <th class="sorting_asc">Date de création</th>
                            <th class="sorting_asc">Description</th>
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
                </table></p>
                
                <!--p>This is a free CSS website template from <a href="http://www.templatemo.com" target="_parent">TemplateMo.com</a>. You may download, modify and apply this template design for your websites. Credit goes to <a href="http://www.smashingmagazine.com" target="_blank">Smashing Magazine</a> for the icon. Thank you for visiting.</p>
                <p>&nbsp;</p>
                <p>Nulla et augue. Donec a massa ut pede pulvinar vulputate. Sed eu nunc quis pede tristique suscipit. Nam sit amet justo vel libero tincidunt dignissim.</p-->
            </div>
            <div class="cleaner"></div>
        </div><!-- end of banner content -->
        <div class="cleaner"></div>
    </div><!-- end of banner -->
</div><!-- end of banner wrapper -->