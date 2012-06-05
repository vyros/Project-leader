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

        <table align="center">
            <tr>
                <td><h6>Login :&nbsp </h6></td>
                <td><input type='text' name='log' size='25' maxlength='100' value=""/><br><br></td>
            </tr>

            <tr>
                <td><h6>Pass :&nbsp </h6></td>
                <td><input type='password' name='mdp' size='25' maxlength='100' value=""/><br><br></td>
            </tr>

            <br><br>

            <tr>
                <td><input id="b1" type="button" onclick="getFormulary('ai1');" value="Valider" /></td>
            </tr>

        </table>
    </form>
</div>

<div class="content_col_w420 fr">

    <form id="ai2" style="position: relative; left: 75px;">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="ajouter"/>
        
        <div class="header_02">Inscription<br/></div>

        <table align="center">
            <tr>
                <td><h6>Pr&eacute;ciser votre statut (Client / Prestataire) :&nbsp</h6></td>
                <td>
                    <select type="text" name="statut">
                        <option selected>-- Selectionnez un statut --</option>
                        <option value="client">Client</option>
                        <option value="prestataire">Prestataire</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><h6>E-mail :&nbsp </h6></td>
                <td><input type='text' name='mail' size='25' maxlength='100' value=""/></td>
            </tr>

            <tr>
                <td><h6>Login :&nbsp </h6></td>
                <td><input type='text' name='log' size='25' maxlength='100' value=""/></td>
            </tr>

            <tr>
                <td><h6>Pass :&nbsp </h6></td>
                <td><input type='password' name='mdp' size='25' maxlength='100' value=""/></td>
            </tr>

            <tr>
                <td><h6>Confirmation Pass :&nbsp </h6></td>
                <td><input type='password' name='mdp2' size='25' maxlength='100' value=""/></td>
            </tr>
            <br><br>
            <tr>
                <td><input type="button" onclick="getFormulary('ai2');" value="Valider" /></td>
            </tr>
        </table>
    </form>
</div>