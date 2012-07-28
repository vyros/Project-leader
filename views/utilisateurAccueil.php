<?php
/*
 * Vue utilisateurAccueil
 * 
 * Est appelée par le contrôleur utilsateur.
 * Lorsqu'un utilisateur s'est inscrit avec succès.
 * Est un formulaire lui demander log/mdp pour le connecter au site.
 */
?>
<div class="content_col_w420 fl">

    <form id="au1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="valider"/>

        <div class="header_02">Acc&egrave;s &agrave; votre compte<br/></div>

        <label for="log1">Login : </label><br />
        <input id="log1" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />

        <label for="mdp1">Mot de passe : </label><br />
        <input id="mdp1" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />

        <input type="button" onclick="getFormulary('au1');" value="Valider" />
    </form>
    
</div><!-- end of a section -->