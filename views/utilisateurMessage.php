<?php
/*
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <?php
            if (is_null($objNotification)) {
                ?>
                <div class="header_02">Nouveau message</div>
                <?php
            } else {
                ?>
                <div class="header_02">Message : <?php echo $objNotification->getSujet(); ?></div>
                <?php
            }
            ?>
        </div>
        <br />

        <div id="main">
            <ol id="update" class="timeline">
                <?php
                if (!is_null($lstMessageObjs)) {
                    foreach ($lstMessageObjs as $objMessage) {

                        $objMessage->editMsgLu();
                        ?>
                        <h2>Titre du message : <?php echo $objMessage->getTitre(); ?></h2>
                        <br/>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objMessage->getEmetteurId(); ?>'});"><?php echo $objMessage->getSujet(); ?></a></span>, le <span class="com_date"><?php echo $objMessage->getDate(); ?></span> a écrit : <br />
                            <?php echo $objMessage->getLibelle(); ?>
                        </li>
                    </ol>
                    <?php
                }
            }
            ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">

                <form id="um1">

                    <input type="hidden" name="action" value="message"/>
                    <input type="hidden" name="controller" value="notification"/>
                    <input type="hidden" name="view" value="messagerie"/>

                    <label for="sujet">Titre de votre message :</label><br />
                    <input id="sujet" accesskey="t" type='text' name='titre' size='18' value="" />
                    <br /><br />

                    <label for="message">Corps de votre message :</label><br />
                    <textarea name="message" id="message"></textarea>
                    <br /><br />

                    <label for="receveur">Destinataire :</label><br />
                    <input id="receveur" accesskey="d" type='text' name='receveur' size='18' value="" />
                    <br /><br />

                    <input type="button" onclick="getFormulary('um1');" value="Envoyer" />

                </form>

            </div>

        </div>

    </div>
</div>