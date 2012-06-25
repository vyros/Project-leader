<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form id="rp1">

    <input type="hidden" name="controller" value="recherche"/>
    <input type="hidden" name="action" value="liste"/>

    <div>
        <div style="color:red">
            Développement Web / Software
        </div>
        <div>
            <?php
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsDev)) {
                foreach ($lstCategorieFilsDev as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech" value=<?php echo $lstFils[cat_id] ?> id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                    <?php
                }
            }
            ?>
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Mobile
        </div>
        <div>
            <?php
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsMobile)) {
                foreach ($lstCategorieFilsMobile as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech" value=<?php echo $lstFils[cat_id] ?> id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>             
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Base de données
        </div>
        <div>
            <?php
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsBDD)) {
                foreach ($lstCategorieFilsBDD as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech" value=<?php echo $lstFils[cat_id] ?> id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>            
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Design
        </div>
        <div>
            <?php
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsDesign)) {
                foreach ($lstCategorieFilsDesign as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech" value=<?php echo $lstFils[cat_id] ?> id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>         
            </br>
        </div>
    </div>
    </br>
    </br>
    <div>
        <input type="button" onclick="getFormulary('rp1');" value="Valider" />
    </div>
</form>
</br>   
<div id="demo" id="tabRes" style="display: none">
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
                    ?>
                    <th class="sorting_asc">Accès</th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!is_null($listProjets)) {
                foreach ($listProjets as $idProjet) {
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
                                    //echo ('- ');
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
                                    //echo ('- ');
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
                                <a onclick="getView('projet', 'liste', '<?php echo $objProjet->getId(); ?>');">
                                    <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>
                                        
                            </td>
                            <?php
                        } else {
                            
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
<div class="margin_bottom_20"></div>
    