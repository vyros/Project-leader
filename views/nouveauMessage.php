<?php
/*
 * Vue d'un nouveau message.
 * 
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <div class="header_02">Nouveau Message</div>
        </div>

        <form method="post">

            <input type="hidden" name="action" value="message"/><!--
                <input type="hidden" name="controller" value="projet"/>-->
            <input value="<?php echo $idUti = $_GET["idUti"]; ?>" type="hidden" name="idUti" />

            <?php
            if (is_null($idUti)) {
                ?>
                <input type="text" id="demo-input-local" name="blah" /><br /><br />
                <?php
            } else {
                ?>
                <input type="text" id="demo-input-pre-populated" name="blah" /><br /><br />
                <?php
            }
            ?>

            Titre de votre message :<input id="titre" accesskey="l" type='text' name='log' size='18' maxlength='100' value="" /> 
            Contenu du message :<textarea name="message" id="message"></textarea><br />

            <input type="submit" class="envoyerMsg" value=" Envoyer " />
<!--                    <input type="button" onclick="getFormulary('pf2');" value="Submit Comment" />-->

        </form>

    </div>
</div>