<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">
    <div class="header_02">Vos derniers projets</div>
    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <p>
                <?php
                $i = 0;
                foreach ($lstUtilisateurProjetObjs as $objProjet) {
                    echo "<a href=\"#projetLst?idProjet=" . $objProjet->getId() . "\">" .
                    $objProjet->getLibelle() . "</a><br />";
                    $i++;
                }
                ?>
            </p>
        </div>
    </div>
    <?php
    if ($i != 0) {
        ?>
        <div class="section_w140 fr">
            <div class="rc_btn_02"><a href="#projetAdd">Créer un projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    } else {
        echo "Aucun projet en cours";
        ?>
        <div class="section_w140 fr">
            <div class="rc_btn_02"><a href="#projetAdd">Créer votre projet</a></div>
            <div class="cleaner"></div>            
        </div>
        <?php
    }
    ?>

    <div class="margin_bottom_10 border_bottom"></div>
    <div class="margin_bottom_30"></div>

    <div class="header_02">Liste de prestataires</div>
    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <p>
                <?php
                foreach ($lstUtilisateurObjs as $objUtilisateur) {
                    echo "<a href=\"#utilisateurLst?idUtilisateur=" . $objUtilisateur->getId() . "\">" .
                    $objUtilisateur . "</a><br />";
                }
                ?>
            </p>
        </div>
    </div>
    <div class="margin_bottom_20"></div>
</div><!-- end of a section -->


<div class="content_col_w420 fr">
    <div class="header_02">Votre compte</div>
    <div class="testimonial_box_wrapper">
        <div class="testimonial_box">
            <div class="header_03"><a href="#"><div id="progressbar"></div></a></div>

        </div>
    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>
</div>