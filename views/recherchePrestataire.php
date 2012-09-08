<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w840">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_recherche.png"/> 
            <div class="header_02">Choisissez les options du projet recherché</div>
        </div>

        <form id="rp1">

            <input type="hidden" name="action" value="liste"/>
            <input type="hidden" name="controller" value="recherche"/>

            <div>
                <div style="color:red">
                    <a id="TitreDev">D&eacute;veloppement Web / Software</a>
                </div>
                <div id="divDev">
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
                    <a id="TitreMobile">Mobile</a>
                </div>
                <div id="divMobile">
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
                    <a id="TitreBDD">Base de donn&eacute;es</a>
                </div>
                <div id="divBDD">
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
                    <a id="TitreDesign">Design</a>
                </div>
                <div id="divDesign">
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
                            <?php
                        }
                    }
                    ?>         
                    </br>
                </div>
            </div>
            </br>
            </br>
            <div>
                <input type="button" onclick="getFormulary('rp1');" value="Valider" />
            </div>
        </form>

    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

</div>

<div class="content_col_w840">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_result_recherche.png"/> 
            <div class="header_02">Résultat(s)</div>
        </div>
        
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th class="sorting_asc">Intitul&eacute;</th>
                        <th class="sorting_asc">Cat&eacute;gorie</th>
                        <th class="sorting_asc">Budget</th>
                        <th class="sorting_asc">Comp&eacute;tence requise</th>
                        <th class="sorting_asc">Date de cr&eacute;ation</th>
                        <th class="sorting_asc">Description</th>
                        <?php
                        if ($idUtilisateur !== null) {
                            ?>
                            <th class="sorting_asc">Acc&eacute;s</th>
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
                                    <?php $date = new DateTime($objProjet->getDateCreation()); ?>
                                    <input type="hidden" name="dateCreation" value="<?php echo $date->format('d-m-Y'); ?>">
                                    <?php echo $date->format('d-m-Y'); ?>											
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

    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

</div>
