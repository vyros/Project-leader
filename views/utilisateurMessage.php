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
            if (is_null($objMessage)):
                ?>
                <div class="header_02">Nouveau message</div>
                <?php
            else:
                ?>
                <div class="header_02">Message : <?php echo $objMessage->getSujet(); ?></div>
            <?php
            endif;
            ?>
        </div>
        <br />

        <div id="main">
            <?php
            if (!is_null($lstMessageObjs)):
                ?>
                <ol id="update" class="timeline">
                    <?php
                    foreach ($lstMessageObjs as $objMessageTmp):

                        $objMessageTmp->editMsgLu();
                        ?>
                        <h2>Titre du message : <?php echo $objMessageTmp->getTitre(); ?></h2>
                        <br/>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objMessageTmp->getEmetteurId(); ?>'});"><?php echo $objMessageTmp->getSujet(); ?></a></span>, le <span class="com_date"><?php echo $objMessageTmp->getDate(); ?></span> a écrit : <br />
                            <?php echo $objMessageTmp->getLibelle(); ?>
                        </li>
                    </ol>
                    <?php
                    unset($objMessageTmp);
                endforeach;
            endif;
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

                    <label for="corps">Corps de votre message :</label><br />
                    <textarea name="corps" id="corps"></textarea>
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