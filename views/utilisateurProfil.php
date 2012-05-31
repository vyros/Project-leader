<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($objUtilisateur);
?>
<div class="content_col_w420 fl">

    <form id="up1">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="profil"/>

        <div class="header_02">Profil<br/></div>

        <table align="center">
            <tr>
                <td><h6>Intitulé :&nbsp </h6></td>
                <td><input type='text' name='libelle' size='25' maxlength='100' value=""/><br><br></td>
            </tr>

            <br><br>

            <tr>
                <td><input type="button" onclick="getFormulaire('up1');" value="Valider" /></td>
            </tr>
        </table>
    </form>
</div><!-- end of a section -->