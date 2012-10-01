<?php
/*
 * @author folin
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

            <?php
            //construction des blocs
            foreach ($lstCompetenceMereIds as $idMere) {
                $objMere = new Competence($idMere);

                echo "<div>";
                echo "<div class='divtitre' id='Titre" . $objMere->getId() . "'>";
                echo "<span class='libtitre'>" . $objMere->getLibelle() . "</span>";
                echo "</div>";
                echo "<div class='divbloc' id='div" . $objMere->getId() . "'>";
                $i = 0;
                $lstCompetenceFilleIds = Competence::getCompetenceFilleIds($objMere->getId());
                /* Sur 4 colonnes */
                if (!is_null($lstCompetenceFilleIds)) {
                    echo "</br>";
                    foreach ($lstCompetenceFilleIds as $idFille) {
                        $objFille = new Competence($idFille);
                        if ($i == 4) {
                            ?></br><?php
                $i = 0;
            }
            $i++;
            echo "<div class='bloc'><input type='checkbox' name='rech' value=" . $objFille->getId() . "id=" . $objFille->getId() . "/>" . $objFille->getLibelle() . "</div>";
        }
    }
    echo "</br>";
    echo "</div>"; //fermeture divid
    echo "</div>";
    echo "</br></br>";
    echo "<script type='text/javascript'>";
    echo "$('#Titre" . $objMere->getId() . "').click(function () { $('#div" . $objMere->getId() . "').toggle('normal'); });";
    echo "</script>";

    unset($objMere);
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
                        <th class="sorting_asc">Budget</th>
                        <th class="sorting_asc">Comp&eacute;tences requises</th>
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
                    if (!is_null($lstProjetIds)) {
                        foreach ($lstProjetIds as $idProjet) {
                            $objProjet = new Projet($idProjet);
                            ?>
                            <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                                <td id="libelle">
                                    <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                                    <?php echo $objProjet->getLibelle(); ?>
                                </td>

                                <td id="budget">
                                    <input type="hidden" name="budget" value="<?php echo $objProjet->getBudget(); ?>">
                                    <?php echo $objProjet->getBudget(); ?>											
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
                            unset($objProjet);
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
                        <th class="sorting_asc">Compétences</th>
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
                    if (!is_null($lstUtilisateurIds)) {
                        foreach ($lstUtilisateurIds as $idUtilisateur) {
                            $objUtilisateur = new Utilisateur($idUtilisateur);
                            ?>
                            <tr id="lignePrestataire<?php echo $objUtilisateur->getId(); ?>" class="gradeX">

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

                                <td id="date">
                                    <input type="hidden" name="date" value="<?php echo '???'; ?>">
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
                            unset($objUtilisateur);
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