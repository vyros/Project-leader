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

<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_fichePjt.png"/> 
            <div class="header_02">Titre de mon projet : <?php echo $objProjet->getLibelle(); ?></div>
        </div>

        <form id="pf1">    

            <input type="hidden" name="controller" value="projet"/>
            <input type="hidden" name="action" value="editer"/>

            <label for="infoPrj">Description du projet : </label></br>
            <input id="description" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDescription(); ?>" />
            </br></br>

            <!--        <label for="infoPrj">Description du projet : </label>
                    <textarea style="vertical-align: top;">
            <?php // echo $objProjet->getDescription(); ?>
                    </textarea>-->

            <label for="infoPrj">Catégorie : </label></br>
            <?php
            $lstCategorieIds = $objProjet->getCategorieIds();

            if (!is_null($lstCategorieIds)) {
                foreach ($lstCategorieIds as $idCategorie) {
                    $objCategorie = new Categorie($idCategorie);
                    echo ('- ');
                    ?>
                    <input id="categorie" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objCategorie->getLibelle(); ?>" /> 
                    <?php
                    echo ('</br>');
                }
            }
            ?>
            <label for="infoPrj">Compétence : </label></br>
            <?php
            $lstCompetenceIds = $objProjet->getCompetenceIds();

            if (!is_null($lstCompetenceIds)) {
                foreach ($lstCompetenceIds as $idCompetence) {
                    $objCompetence = new Competence($idCompetence);
                    echo ('- ');
                    ?>
                    <input id="competence" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objCompetence->getLibelle(); ?>" />
                    <?php
                    echo ('</br>');
                }
            }
            ?>

            <label for="infoPrj">Budget : </label></br>
            <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" /></br>

            <label for="infoPrj">Délai fixé : </label></br>
            <input id="delai" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" /></br>

            <label for="infoPrj">Date de création : </label></br>
            <input id="ddc" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDateCreation(); ?>" /></br>

            <?php
            $idEtat = $objProjet->getEtatId();
            $monEtat = new Etat($idEtat);
            ?>
            <label for="infoPrj">Statut : </label></br>
            <input id="statut" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $monEtat->getLibelle(); ?>" /></br>

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

            <input type="button" onclick="getFormulary('up1');" value="Valider" />

        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>