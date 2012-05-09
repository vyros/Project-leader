<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <form id="au1">

        <input type="hidden" name="controller" value="accueil"/>
        <input type="hidden" name="action" value="getUtilisateur"/>
        
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
                <td><input type="button" onclick="getFormulaire('au1');" value="Valider" /></td>
            </tr>
        </table>
    </form>
</div><!-- end of a section -->