<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($objUtilisateur);
?>
<div class="content_col_w420 fl">

    <?php
    // Le page profil possede pas beaucoup de difference entre les 2 statut client et presta, juste 2 - 3 modifs
    // 
    // Par contre, 2 possibles affichages, si c'est le profil de l'utilisateur connecté, il pourra modifier
    // directement ses informations profil et valider. Chaque getXXX devra etre des setXXX (à verif)
    // Si ce n'est pas le profil de l'utilisateur connecté, le profil s'affiche en "read-only"
    
    ?>
    <form id="up1">

        <input type="hidden" name="controller" value="utilisateur"/>
        <input type="hidden" name="action" value="profil"/>

        
        
        <table align="center">
            <td>
                <div>
                    <img src="images/ex_avatar.png"/>
                    <br/>
                    <br/>
                    <div class="infoProfil">Nom : <?php echo "log";?><br/></div>
                    <div class="infoProfil">Prénom : <?php echo "";?><br/></div>
                    <div class="infoProfil">Age : <?php echo "";?><br/></div>
                    <div class="infoProfil">Localisé à : <?php echo "";?><br/></div>
                    <div class="infoProfil">Lien Téléchargement CV : <?php echo "";?><br/></div>
                    <div class="infoProfil">Date inscription : <?php echo "";?><br/></div>
               
                </div>
            </td>

            <td>
                <div style="position: relative; height: 230px; left: 10px; width:740px;">
                    <div class="header_02"><?php echo $objUtilisateur->getLogin();?></div>
                    <div class="">Statut :</div>
                    <div class="">Présentation :<textarea></textarea></div>
                    
                    <div class="margin_bottom_20 border_bottom"></div>
                    <div class="margin_bottom_30"></div>
                    
                    <div class="">Compétences :<textarea></textarea></div>
                    
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
                    
                </div>
            </td>
            <tr>
                <td><input type="button" onclick="getFormulaire('up1');" value="Valider" /></td>
            </tr>
        </table>
    </form>
</div><!-- end of a section -->