<?php
/*
 * Vue d'un porteur de projets.
 * 
 * @author jimmy
 */
?>
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
                    $verrou = true;
                    if (!is_null($lstUtilisateurProjetObjs)):
                        foreach ($lstUtilisateurProjetObjs as &$objProjet):
                            $verrou = false;
                            ?>
                            <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
                                <?php echo $objProjet->getLibelle(); ?></a><br />
                            <?php
                            unset($objProjet);
                        endforeach;
                    endif;
                    ?>
                </p>
            </div>
        </div>
        <?php
        if (!$verrou):
            ?>
            <div class="section_w140 fr">
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer un projet</a></div>
                <div class="cleaner"></div>            
            </div>
            <?php
        else:
            echo "Aucun projet en cours";
            ?>
            <div class="section_w140 fr">
                <div class="rc_btn_02"><a onclick="getView({'controller' : 'projet', 'view' : 'ajouter'});">Créer votre projet</a></div>
                <div class="cleaner"></div>            
            </div>
        <?php
        endif;
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
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauAccueilPorteur">
                <thead>
                    <tr>
                        <th class="sorting_asc">Pseudo</th>
                        <th class="sorting_asc">Compétence</th>
                        <th class="sorting_asc">Nombre de projet à ce jour</th>
                        <th class="sorting_asc">Date d'inscription</th>
                        <th class="sorting_asc">Accès profil</th>
                        <th>Présentation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!is_null($lstUtilisateurObjs)):
                        foreach ($lstUtilisateurObjs as &$objUtilisateur):
                            ?>
                            <tr id="lignePrestataire<?php echo $objUtilisateur->getId(); ?>" class="gradeX">

                                <td id="pseudo">
                                    <input type="hidden" name="pseudo" value="<?php echo $objUtilisateur->getLogin(); ?>" /> 
                                    <?php echo $objUtilisateur->getLogin(); ?>
                                </td>

                                <td id="competence">
                                    <input type="hidden" name="competence" value="" />
                                    <?php
                                    if (!is_null($lstCompetenceObjs = $objUtilisateur->getCompetenceObjs())):
                                        foreach ($lstCompetenceObjs as $objCompetence):
                                            echo $objCompetence->getLibelle();
                                            echo ('</br>');
                                        endforeach;
                                    endif;
                                    ?>	
                                </td>

                                <td id="nbreProjet">
                                    <input type="hidden" name="nbrePjt" value="<?php echo $objUtilisateur->getNombreProjets(); ?>" />
                                    <?php echo $objUtilisateur->getNombreProjets(); ?>											
                                </td>

                                <td id="date">
                                    <input type="hidden" name="date" value="<?php echo $objUtilisateur->getDate(); ?>" />
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
                            unset($objUtilisateur);
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="6" class="center">Aucun prestataire trouvé</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </tbody>
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
                <div class="header_03"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil'});"><div id="progressbar"></div></a></div>

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
        if (!is_null($message)):
            include_once('views/message.php');
        else:
            ?>
            <span>Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?>, vous avez <?php echo Site::getUtilisateur()->getMessageCount(0); ?> message(s).</span>
        <?php
        endif;
        ?>
    </div>
</div>
