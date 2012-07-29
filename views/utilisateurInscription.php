<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_compte.png"/> 
            <div class="header_02">Acc&egrave;s &agrave; votre compte<br/></div>
        </div>

        <form id="ai1">

            <input type="hidden" name="action" value="valider"/>
            <input type="hidden" name="controller" value="utilisateur"/>
            <input type="hidden" name="view" value="inscription"/>

            <label for="log">Login : </label><br />
            <input id="log" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />

            <label for="mdp">Mot de passe : </label><br />
            <input id="mdp" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />

            <input type="button" onclick="getFormulary('ai1');" value="Valider" />
        </form>

    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

</div>

<div class="content_col_w420 fr">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_compte.png"/> 
            <div class="header_02">Inscription<br/></div>
        </div>

        <form id="ai2" style="position: relative; left: 75px;">

            <input type="hidden" name="action" value="ajouter"/>
            <input type="hidden" name="controller" value="utilisateur"/>

            <label for="statut">Pr&eacute;ciser votre statut (Client / Prestataire) : </label><br />
            <select id="statut" type="text" name="statut">
                <option selected>-- Selectionnez un statut --</option>
                <option value="client">Client</option>
                <option value="prestataire">Prestataire</option>
            </select><br /><br />

            <label for="mail">E-mail : </label><br />
            <input id="mail" type='text' name='mail' size='25' maxlength='100' value=""/><br /><br />

            <label for="log">Login : </label><br />
            <input id="log" type='text' name='log' size='25' maxlength='100' value=""/><br /><br />

            <label for="mdp">Mot de passe : </label><br />
            <input id="mdp" type='password' name='mdp' size='25' maxlength='100' value=""/><br /><br />

            <label for="mdp2">Confirmation : </label><br />
            <input id="mdp2" type='password' name='mdp2' size='25' maxlength='100' value=""/><br /><br />

            <input type="button" onclick="getFormulary('ai2');" value="Valider" />
        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div>