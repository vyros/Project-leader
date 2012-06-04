<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">
    <?php

    // faire autre condition pour le cas ou c'est un projet de l'utilisateur connecté
    // Dans ce cas, les informations (qui seront dans des inputs) seront modifiables directement (via des set)
   
    if($lstProjetIds[1] == "")
    {
        $idProjet = $lstProjetIds[0][0];
        $objProjet = new Projet($idProjet);
        //print_r($lstProjetIds);
        $idUti = Site::getUtilisateur()->getId();
        
    ?>
    
    <div class="header_02">Titre du projet : <?php echo $objProjet->getLibelle();?></div>
    
    <div id="contenuProjet" class="infoProjet">
    Description du projet :
    <?php
        echo $objProjet->getDescription();
    ?>
    </div>
    <br/>
    <br/>
    <div id="budget" class="infoProjet">
    Budget :
    <?php
	echo $objProjet->getBudget();
    ?>
    </div>
    <br/>
    <br/>
    <div id="delai" class="infoProjet">
    Délai fixé :
    <?php
	echo $objProjet->getEcheance();
    ?>
    </div>
<br/>
<br/>
    <div id="dateCreation" class="infoProjet">
    Date de création :
    <?php
	echo $objProjet->getDateCreation();
    ?>
    </div>
<br/>
<br/>
    <div id="statut" class="infoProjet">
    Statut:
    <?php
        $idEtat = $objProjet->getEtatId();
        $monEtat = new Etat($idEtat);
        echo $monEtat->getLibelle();
    ?>
    </div>
    <div id="participant" class="infoProjet">
    Participant :
    <?php
        $lstParticipants = PARTICIPER::voirParticipation($idProjet);
        if (!is_null($lstParticipants)) {
            foreach ($lstParticipants as $idUti) {
                $objUti = new Utilisateur($idUti);
                echo ('- ');
                echo $objUti->getLogin();
                echo ('</br>');
            }
        }
    ?>
    </div>

    <?php
    }else
    {
    ?>
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
                                    <a onclick="getControllerView('projet', 'liste', '<?php echo $objProjet->getId(); ?>');">
                            lien fiche </a>
                                    							
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                }
    }
                ?>
            </tbody>
        </table>
    </div>
</div><!-- end of a section -->