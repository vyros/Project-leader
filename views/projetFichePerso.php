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
    
    <div class="header_02">Titre DE MON projet : <?php echo $objProjet->getLibelle();?></div>
    <div class="margin_bottom_20"></div>
    <div class="margin_bottom_20"></div>
    
    
    <label for="infoPrj">Description du projet : </label>
    <input id="description" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDescription(); ?>" />
    <div class="margin_bottom_20"></div>
 
    <label for="infoPrj">Budget : </label>
    <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" />
    
    <div class="margin_bottom_20"></div>
    
    <label for="infoPrj">Délai fixé : </label>
    <input id="delai" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" />
   
    <div class="margin_bottom_20"></div>
    
    <label for="infoPrj">Date de création : </label>
    <input id="ddc" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDateCreation(); ?>" />
    
    <div class="margin_bottom_20"></div>
    
    <?php
        $idEtat = $objProjet->getEtatId();
        $monEtat = new Etat($idEtat);    
    ?>
    <label for="infoPrj">Statut : </label>
    <input id="statut" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $monEtat->getLibelle(); ?>" />
     
    <div class="margin_bottom_20"></div>
    
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
    
    <div class="margin_bottom_20"></div>
    
