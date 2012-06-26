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
    
<div class="header_02">Titre du projet : <?php echo $objProjet->getLibelle(); ?></div>
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
    <div id="categorie" class="categorie">
    Catégorie :
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
    </div>
    <br/>
    <br/>
    <div id="competence" class="competence">
    Compétence(s) requise(s) :
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
<br/>
<br/>
    <div id="participant" class="infoProjet">
    Participant :
    <?php
        $lstParticipants = PARTICIPER::voirParticipation($idProjet);
        if (!is_null($lstParticipants)) {
            foreach ($lstParticipants as $idUti) {
                $objUtilisateur = new Utilisateur($idUti);
                echo ('- ');
                ?>
            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                     <?php echo $objUtilisateur->getLogin(); ?></a><br />
                <?php
            }
        }
    ?>
    </div>
