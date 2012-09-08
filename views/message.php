<?php
if (isset($message['succes']) && $message['succes'])
    $message = $message['succes'];
elseif ((isset($message['erreur']) && $message['erreur']))
    $message = $message['erreur'];
else
    unset($message);

if (!is_null($message)) {
    if($view == "accueil") {
    ?>
        <span> <?php echo $message;?> Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> !</span>
    <?php
    }else if ($view == "liste"){
    ?>
        <span> <?php echo $message;?></span>
    <?php
    }
    ?>
 
<!--    <div class="content_col_w420 fr">

        <div class="sub_content_col">

            <div class="header_wrapper">
                <img src="images/icone_msg.png"/> 
                <div class="header_02">Message</div>
            </div>

            <div class="testimonial_box_wrapper">
                <div class="testimonial_box">
                    <p>
                        <?php
                        
                        ?>
                    </p>
                </div>
            </div>

            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>

        </div>

    </div> end of a section -->
    <?php
}
?>
