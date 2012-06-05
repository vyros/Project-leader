<?php
/*
 * Par contre, 2 possibles affichages, si c'est le profil de l'utilisateur connecté, il pourra modifier
 * directement ses informations profil et valider. Chaque getXXX devra etre des setXXX (à verif)
 * Si ce n'est pas le profil de l'utilisateur connecté, le profil s'affiche en "read-only"
 */
?>
<div class="content_col_w420 fl">
    <div class="header_02">Éditer vos informations<br/></div>

    <form id="up1">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="profil"/>

        <img src="images/ex_avatar.png"/>
        <br/>
        <br/>
        <label for="nom">Nom : </label>  <br />
        <input id="nom" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getNom(); ?>"/><br />

        <label for="prenom">Prénom : </label><br />
        <input id="prenom" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getPrenom(); ?>"/><br />

        <label for="ddn">Date de naissance : </label><br />
        <input id="ddn" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getDdn(); ?>"/><br />

        <label for="ville">Localisé(e) à : </label><br />
        <input id="ville" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getVille(); ?>"/><br />

        <label for="cv">Lien Téléchargement du CV : </label><br />
        <input id="cv" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getLogin(); ?>"/><br />

        <label for="ddi">Date d'inscription : </label><br />
        <input id="ddi" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getDate(); ?>"/><br />

        <input type="button" onclick="getFormulaire('up1');" value="Valider" />
    </form>

</div>

<!--        <div style="position: relative; height: 230px; left: 10px; width:740px;">-->
<div class="content_col_w420 fr">
    <div class="header_02"><?php echo $objUtilisateur->getLogin(); ?></div>

    <form id="up2">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="profil"/>


        <label for="statut">Statut : </label><br />
        <input id="statut" class="infoProfil" type="text" value="<?php echo $objUtilisateur->getStatut(); ?>"/><br />

        <label for="presentation">Présentation : </label><br />
        <input id="presentation" class="infoProfil" type="text" value="<?php echo 'tmp'; ?>"/><br />

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <label for="competence">Compétences : </label><br />
        <input id="competence" class="infoProfil" type="text" value="<?php echo 'tmp'; ?>"/><br />

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <div id="menuProfil">
            <ul id="ongletsProfil">
                <li class="active"><a href=""> Projets réalisés </a></li>
                <li><a href=""> Projets en cours </a></li>
                <li><a href=""> Commentaire </a></li>
            </ul>
            <div id="contenuOnglet">

            </div>
        </div>

        <input type="button" onclick="getFormulaire('up1');" value="Valider" />
    </form>
</div>
