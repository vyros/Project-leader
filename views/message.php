<?php
$message = (isset($message[succes])) ? $message[succes] : null;
if (!isset($message[succes]) && isset($message[erreur]))
    $message = $message[erreur];

if (!is_null($message)) {
    ?>
    <div class="content_col_w420 fr">

        <div class="sub_content_col">

            <div class="header_wrapper">
                <img src="images/icone_msg.png"/> 
                <div class="header_02">Message</div>
            </div>

            <div class="testimonial_box_wrapper">
                <div class="testimonial_box">
                    <p>
                        <?php
                        echo $message;
                        ?>
                    </p>
                </div>
            </div>

            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>

        </div>

    </div><!-- end of a section -->
    <?php
}
?>
