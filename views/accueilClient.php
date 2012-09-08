<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--<script type="text/javascript">
    $('.jsLinkGetControllerView').click(function(){
        var arg = $(this).attr('class');
        var targ = arg.split('arg-');
        if(targ.length == 4){
            getControllerView(targ[1],targ[2],targ[3]);
        }
    });
</script>-->
<style>
    .ui-progressbar .ui-progressbar-value { background-image: url(images/pbar-ani.gif); }
</style>
<script>
    $(function() {
        $( "#progressbar" ).progressbar({
            value: <?php echo Site::getUtilisateur()->getRatio(); ?>
        });
    });
</script>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_projet.png"/> 
            <div class="header_02">Vos derniers projets</div>
        </div>

    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <p>
                <?php
                $i = 0;
                if (!is_null($lstUtilisateurProjetObjs)) {
                    foreach ($lstUtilisateurProjetObjs as $objProjet) {
                        ?>
                            <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
                            <?php echo "- ".$objProjet->getLibelle(); ?></a><br />
                        <?php
                        $i++;
                    }
                }
                ?>
            </p>
        </div>
    </div>
    <?php
    if ($i != 0) {
        ?>
        <div class="section_w140 fr">
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer un projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    } else {
        echo "Aucun projet en cours";
        ?>
        <div class="section_w140 fr">
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer votre projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    }
    ?>

        <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

    </div>

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_presta.png"/> 
    <div class="header_02">Liste de prestataires</div>
        </div>

        <div id="demo">
            <table id="listePresta">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauDetail">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Pseudo</th>
                            <th class="sorting_asc">Compétence</th>
                            <th class="sorting_asc">Nombre de projet à ce jour</th>
                            <th class="sorting_asc">Date d'inscription</th>
                            <th class="sorting_asc">Accès profil</th>
                            <th>test</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                if (!is_null($lstUtilisateurObjs)) {
                    foreach ($lstUtilisateurObjs as $objUtilisateur) {
                        ?>
                                <tr id="lignePresta<?php echo $objUtilisateur->getId(); ?>" class="gradeX">

                                    <td id="pseudo">
                                        <input type="hidden" name="pseudo" value="<?php echo $objUtilisateur->getLogin(); ?>"> 
                                        <?php echo $objUtilisateur->getLogin(); ?>
                                    </td>

                                    <td id="competence">
                                        <input type="hidden" name="competence" value="<?php echo '???'; ?>">
                        <?php
                                        echo 'test';
                                        ?>											
                                    </td>

                                    <td id="nbreProjet">
                                        <input type="hidden" name="nbrePjt" value="<?php echo $objUtilisateur->getNombreProjets(); ?>">
                                        <?php echo $objUtilisateur->getNombreProjets(); ?>											
                                    </td>

                                    <td id="dateInscri">
                                        <input type="hidden" name="dateInscri" value="<?php echo '???'; ?>">
                                        <?php
                                        echo $objUtilisateur->getDate();
                                        ?>									
                                    </td>

                                    <td id="access">
                                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                    </td>
                                    
                                    <td id="detail" class="details" colspan="6">
                                        <?php
                                        echo $objUtilisateur->getPresentation();
                                                
                                        ?>
                                    </td>
                                    
                                 </tr>   
                                 
                               
                                <?php
                    }
                }
                ?>
                    </tbody>
                </table>
            </table>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

</div><!-- end of a section -->

</div>

<div class="content_col_w420 fr">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_compte.png"/> 
    <div class="header_02">Votre compte</div>
        </div>

    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <div class="header_03"><a href="#"><div id="progressbar"></div></a></div>

        </div>
    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

</div>

</div>
<img class="imgAcc" src="images/demilogo2.png"/>

       <div class="conteneur_bulle">
            <div class="messageBulle">
                <?php
                if (isset($message)){
                    include_once('views/message.php');
                }else {
                ?>
                <span>Bonjour <?php echo Site::getUtilisateur()->getLogin();?>, vous avez 0 notification(s).</span>
                <?php
                }
                ?>
            </div>
        </div>
