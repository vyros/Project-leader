<?php
/*
 * Par contre, 2 possibles affichages, si c'est le profil de l'utilisateur connecté, il pourra modifier
 * directement ses informations profil et valider. Chaque getXXX devra etre des setXXX (à verif)
 * Si ce n'est pas le profil de l'utilisateur connecté, le profil s'affiche en "read-only"
 */
?>
<script>
    $(function() {
        $.datepicker.setDefaults( $.datepicker.regional[ "" ] );
        $( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
    });
</script>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/ex_avatar.png"/>
            <div class="header_02"><?php echo $objUtilisateur->getLogin(); ?></div>
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

            <label for="ville">Localisé(e) à : </label><br />
            <input id="ville" name="ville" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getVille(); ?>"/><br /><br />

            <label for="tel">Téléphone : </label><br />
            <input id="tel" name="tel" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getTel(); ?>"/><br /><br />

            <label for="cv">Lien Téléchargement du CV : </label><br />
            <input id="cv" name="cv" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getLogin(); ?>"/><br /><br />

            <?php
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

        <div class="header_wrapper">
            <img src="images/ex_avatar.png"/>
            <div class="header_02"><?php echo $objUtilisateur->getLogin(); ?></div>
        </div>

        <form id="up2">

            <input type="hidden" name="action" value="profil"/>
            <input type="hidden" name="controller" value="utilisateur"/>

            <label for="statut">Statut : </label><br />
            <input id="statut" name="" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getStatut(); ?>"/><br /><br />

            <label for="presentation">Présentation : </label><br />
            <input id="presentation" name="" class="infoProfil" type="text" value="<?php echo 'tmp'; ?>"/><br /><br />

            <label for="competence">Compétences : </label><br />
            <input id="competence" name="" class="infoProfil" type="text" value="<?php echo 'tmp'; ?>"/><br /><br />

            <div id="menuProfil">
                <ul id="ongletsProfil">
                    <li class="active"><a href=""> Projets réalisés </a></li>
                    <li><a href=""> Projets en cours </a></li>
                    <li><a href=""> Commentaire </a></li>
                </ul>
                <div id="contenuOnglet">

                </div>
            </div>

            <input type="button" onclick="getFormulary('up2');" value="Valider" />

        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>
