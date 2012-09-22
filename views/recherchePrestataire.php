
<div class="content_col_w840">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_recherche.png"/> 
            <div class="header_02">Choisissez les options du projet recherché</div>
        </div>

        <form id="rp1">

            <input type="hidden" name="action" value="liste"/>
            <input type="hidden" name="controller" value="recherche"/>

            <?php
            //construction des blocs 
            foreach ($lstCatIdPere as &$catpere) { //pour chaque id pere
                echo "<div>";
                    echo "<div class='divtitre' id='Titre" . $catpere[cat_id_pere] . "'>"; 
                        echo "<span class='libtitre'>" . $catpere[cat_libelle] . "</span>";
                    echo "</div>";
                    echo "<div class='divbloc' id='div" . $catpere[cat_id_pere] . "'>";                
                    $i = 0;
                    $lstCategorieFils = Categorie::getListCategoriesFilsByCode($catpere[cat_id_pere]);
                    /* Sur 4 colonnes */
                    if (!is_null($lstCategorieFils)) {
                        echo "</br>";
                        foreach ($lstCategorieFils as &$lstFils) { //pour chaque id fils
                            if ($i == 4) {
                                ?></br><?php
                                $i = 0;
                            }
                            $i++;                                             
                            echo "<div class='bloc'><input type='checkbox' name='rech' value=" . $lstFils[cat_id] . "id=" . $lstFils[cat_id] . "/>" . $lstFils[cat_libelle] . "</div>";  
                        }
                    }
                    echo "</br>";
                    echo "</div>"; //fermeture divid
                 echo "</div>";  
                 echo "</br></br>";
                 echo "<script type='text/javascript'>";
                    echo "$('#Titre" . $catpere[cat_id_pere] . "').click(function () { $('#div" . $catpere[cat_id_pere] ."').toggle('normal'); });";
                 echo "</script>";
            }
            ?>

         
            <div style="width:600px">
                <div class="rc_btn_02" style="float:left"><a id="btnvalider" onclick="getFormulary('rp1');">Valider</a></div>
                <div id="nores"></div>
            </div>
        </form>

    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

</div>

<!-- Tableau de résultats pour les projets -->
<div class="content_col_w840" id="content_col_w840">

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

                                <td id="date">
                                    <?php $date = new DateTime($objProjet->getDate()); ?>
                                    <input type="hidden" name="date" value="<?php echo $date->format('d-m-Y'); ?>">
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
                                        <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
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

<!-- Tableau de résultats pour les clients -->
<div class="content_col_w840" id="content_col_w840Clients">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_resultat.png"/> 
            <div class="header_02">Résultat(s)</div>
        </div>
        
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                            <th class="sorting_asc">Pseudo</th>
                            <th class="sorting_asc">Compétence</th>
                            <th class="sorting_asc">Nombre de projet à ce jour</th>
                            <th class="sorting_asc">Date d'inscription</th>
                        <?php
                        if ($idUtilisateur !== null) {
                            ?>
                            <th class="sorting_asc">Accès profil</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!is_null($listUsers)) {
                        foreach ($listUsers as $idUser) {
                            $objUtilisateur = new Utilisateur($idUser);
                            ?>
                             <tr id="lignePresta<?php echo $objUtilisateur->getId(); ?>" class="gradeX">

                                    <td id="pseudo">
                                        <input type="hidden" name="pseudo" value="<?php echo $objUtilisateur->getLogin(); ?>"> 
                                        <?php echo $objUtilisateur->getLogin(); ?>
                                    </td>

                                    <td id="competence">
                                        <input type="hidden" name="competence" value="<?php echo '???'; ?>">
                        <?php
                                        echo 'test';
                                        ?>											
                                    </td>

                                    <td id="nbreProjet">
                                        <input type="hidden" name="nbrePjt" value="<?php echo $objUtilisateur->getNombreProjets(); ?>">
                                        <?php echo $objUtilisateur->getNombreProjets(); ?>											
                                    </td>

                                    <td id="dateInscri">
                                        <input type="hidden" name="dateInscri" value="<?php echo '???'; ?>">
                                        <?php
                                        echo $objUtilisateur->getDate();
                                        ?>									
                                    </td>

                                    <td id="access">
                                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                    </td> 
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