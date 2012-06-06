<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <form id="ai1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="valider"/>
        
        <div class="header_02">Acc&egrave;s &agrave; votre compte<br/></div>

        <label for="log1">Login : </label><br />
        <input id="log1" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />
        
        <label for="mdp1">Mot de passe : </label><br />
        <input id="mdp1" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />
        
        <input type="button" onclick="getFormulary('ai1');" value="Valider" />
    </form>
</div>

<div class="content_col_w420 fr">

    <form id="ai2" style="position: relative; left: 75px;">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="ajouter"/>
        
        <div class="header_02">Inscription<br/></div>

        <label for="statut">Pr&eacute;ciser votre statut (Client / Prestataire) : </label><br />
        <select id="statut" type="text" name="statut">
            <option selected>-- Selectionnez un statut --</option>
            <option value="client">Client</option>
            <option value="prestataire">Prestataire</option>
        </select><br /><br />
        
        <label for="mail">E-mail : </label><br />
        <input id="mail" type='text' name='mail' size='25' maxlength='100' value=""/><br /><br />
        
        <label for="log2">Login : </label><br />
        <input id="log2" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />
        
        <label for="mdp3">Mot de passe : </label><br />
        <input id="mdp3" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />
        
        <label for="mdp4">Confirmation : </label><br />
        <input id="mdp4" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />
        
        <input type="button" onclick="getFormulary('ai2');" value="Valider" />
    </form>
</div>