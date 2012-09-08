<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="content_col_w420 fr">	
    <img class="logoAccueil" src="images/logo_300_modifSansFond.png"/>
    <div class="conteneur_bulleAcc">
        <div class="messageBulle">
            <span><b>Bonjour à vous ! Vous recherchez une personne pouvant travailler sur votre projet ou à l'inverse pouvoir travailler sur un projet posté, alors inscrivez-vous et profitez des fonctionnalités de Project-Leader gratuitement !</b></span>
        </div>
    </div>
</div>

<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_statut.png"/> 
            <div class="header_02">Votre statut</div>
        </div>

        <div class="service_box fl margin_right_10">
            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'inscription'});" onmouseover="visibilite('Client','div_libelle_cli')" onMouseOut="visibilite('','div_libelle_cli')"><img src="images/icone_acces_client.png" alt="service" /></a>
            <div id="div_libelle_cli">
            </div> 
        </div> 

        <div class="service_box fl">
            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'inscription'});" onmouseover="visibilite('Prestataire','div_libelle_prest')" onMouseOut="visibilite('','div_libelle_prest')"><img src="images/icone_acces_prestataire.png" alt="service" /></a>
            <div id="div_libelle_prest">
            </div> 
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>
        
        <div class="header_02">Avantages d'être inscrit :</div>
        <ul type="circle">
            <li>Client : Pouvoir poster des projets informatique de toute sortes</li>
            <li>Prestataire : Pouvoir visualiser ces projets et y répondre</li>
           
        </ul>
    </div>

</div><!-- end of a section -->