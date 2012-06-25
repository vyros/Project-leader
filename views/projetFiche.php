<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


        $idProjet = $lstProjetIds[0][0];
        $objProjet = new Projet($idProjet);
        //print_r($lstProjetIds);
        $idUti = Site::getUtilisateur()->getId();
        
    ?>
    
    <div class="header_02">Titre du projet : <?php echo $objProjet->getLibelle();?></div>
    <div class="margin_bottom_20"></div>
    <div class="margin_bottom_20"></div>
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
    DÃ©lai fixÃ© :
    <?php
	echo $objProjet->getEcheance();
    ?>
    </div>
<br/>
<br/>
    <div id="dateCreation" class="infoProjet">
    Date de crÃ©ation :
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
<br/>
<br/>
    <div id="participant" class="infoProjet">
    Participant :
    <?php
        $lstParticipants = PARTICIPER::voirParticipation($idProjet);
        if (!is_null($lstParticipants)) {
            foreach ($lstParticipants as $idUti) {
                $objUtilisateur  = new Utilisateur($idUti);
                echo ('- ');
                ?>
                <a onclick="getView('utilisateur', 'profil', '<?php echo $objUtilisateur->getId(); ?>');">
                     <?php echo $objUtilisateur->getLogin(); ?></a><br />
                <?php
            }
        }
    ?>
    </div>
