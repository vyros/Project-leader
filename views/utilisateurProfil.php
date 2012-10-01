<?php
/*
 * Vue du profil.
 * 
 * @author jimmy
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/ex_avatar.png"/>
            <?php
            if ($objUtilisateur->getStatut() == "prestataire") {
                ?>
                <div class="header_02"><?php echo $objUtilisateur->getLogin(); ?> : prestataire de compétences</div>
                <?php
            } else {
                ?>
                <div class="header_02"><?php echo $objUtilisateur->getLogin(); ?> : porteur de projets</div>
                <?php
            }
            ?>
        </div>

        <form id="up1">

            <input type="hidden" name="action" value="profil"/>
            <input type="hidden" name="controller" value="utilisateur"/>
            <input type="hidden" name="id" value="<?php echo $objUtilisateur->getId(); ?>"/>

            <label for="nom">Nom : </label>  <br />
            <input id="nom" name="nom" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getNom(); ?>"/><br /><br />

            <label for="prenom">Prénom : </label><br />
            <input id="prenom" name="prenom" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getPrenom(); ?>"/><br /><br />

            <label for="datepicker">Date de naissance : </label><br />
            <input id="datepicker" name="datepicker" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getDdn(); ?>"/><br /><br />

            <label for="presentation">Présentation : </label><br />
            <!--input id="presentation" name="presentation" class="infoProfil" type="text" value=""/-->
            <textarea id="presentation" name="presentation" class="infoProfil"><?php echo $objUtilisateur->getPresentation(); ?></textarea><br /><br />

            <label for="ville">Localisé(e) à : </label><br />
            <input id="ville" name="ville" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getVille(); ?>"/><br /><br />

            <label for="tel">Téléphone : </label><br />
            <input id="tel" name="tel" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getTel(); ?>"/><br /><br />

            <label for="cv">Lien Téléchargement du CV : </label><br />
            <input id="cv" name="cv" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getLogin(); ?>"/><br /><br />

            <?php
            if ($objUtilisateur->getStatut() == "prestataire") {
                ?>
                <label for="demo-input-local">Compétence(s) : </label><br />
                <input type="text" id="demo-input-local" name="blah" /><br /><br />
                <?php
            }

            if ($objUtilisateur->getId() == Site::getUtilisateur()->getId()) {
                ?>
                <input type="button" onclick="getFormulary('up1');" value="Valider" />
                <?php
            }
            ?>
        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>

<div class="content_col_w420 fr">

    <div class="sub_content_col">

        <div id="menuProfil">
            <ul id="ongletsProfil">
                <li id="closed" class="active"><a onclick="setOngletActif({'id' : '<?php echo $objUtilisateur->getId(); ?>', 'contenu' : 'closed'});"> Projets réalisés </a></li>
                <li id="opened"><a onclick="setOngletActif({'id' : '<?php echo $objUtilisateur->getId(); ?>', 'contenu' : 'opened'});"> Projets en cours </a></li>
                <li id="comments"><a onclick="setOngletActif({'id' : '<?php echo $objUtilisateur->getId(); ?>', 'contenu' : 'comments'});"> Commentaires </a></li>
            </ul>
            <div id="contenuOnglet">
                <p>Chargement...</p>
            </div>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>
<img class="imgAcc" src="images/demilogo2.png"/>

<div class="conteneur_bulle">
    <div class="messageBulle">
        <?php
        if (!is_null($message)) {
            include_once('views/message.php');
        } else {
            if (Site::getUtilisateur()->getLogin() == $objUtilisateur->getLogin()) {
                ?>
                <span>Voici votre profil, vous avez la possibilité de modifier vos informations (...)</span>
                <?php
            } else {
                ?>
                <span>Voici le profil de <?php echo $objUtilisateur->getSujet(); ?>, vous avez 0 notification(s).</span>
                <?php
            }
        }
        ?>
    </div>
</div>