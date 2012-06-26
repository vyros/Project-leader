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
    
    <div class="header_wrapper">
        <img src="images/icone_projet.png"/> 
        <div class="header_02">Acc&egrave;s &agrave; votre compte<br/></div>
    </div>

    <form id="au1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="valider"/>

        <label for="log1">Login : </label><br />
        <input id="log1" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />

        <label for="mdp1">Mot de passe : </label><br />
        <input id="mdp1" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />

        <input type="button" onclick="getFormulary('au1');" value="Valider" />
    </form>
    
    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>
    
</div><!-- end of a section -->