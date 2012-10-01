<?php
/*
 * Vue de la messagerie.
 * 
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <div class="header_02">Vos messages</div>
        </div>

        <br />
        <a onclick="getView({'controller' : 'notification', 'view' : 'message'});">Nouveau message priv&eacute;</a>

        <h3>Message(s) non-lu(s) (<?php echo Site::getUtilisateur()->getMessageCount(0); ?>):</h3>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauMessagerieNonLu">
                <thead>
                    <tr>
                        <th class="sorting_asc">Titre du message</th>
                        <th class="sorting_asc">Utilisateur</th>
                        <th class="sorting_asc">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Messages non lus
                    if (!is_null($lstMessageObjs = Site::getUtilisateur()->getMessageObjs(0))):
                        foreach ($lstMessageObjs as $objMessage):
                            $objEmetteur = $objMessage->getEmetteurObj();
                            ?>
                            <tr id="ligneMsg<?php echo $objMessage->getId(); ?>" class="gradeX">
                                <td id="titre">
                                    <input type="hidden" name="titre" value="<?php echo $objMessage->getTitre(); ?>"> 
                                    <a onclick="getView({'controller' : 'notification', 'view' : 'message', 'id' : '<?php echo $objMessage->getId(); ?>'});"><?php echo $objMessage->getTitre(); ?></a>
                                </td>

                                <td id="user">
                                    <input type="hidden" name="user" value="<?php echo $objEmetteur->getLogin(); ?>"> 
                                    <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objEmetteur->getId(); ?>'});"><?php echo $objEmetteur->getLogin(); ?></a>
                                </td>

                                <td id="date">
                                    <input type="hidden" name="date" value="<?php echo $objMessage->getDateTable(); ?>"> 
                                    <?php echo $objMessage->getDateTable(); ?>
                                </td>
                            </tr>
                            <?php
                            unset($objEmetteur);
                            unset($objMessage);
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="3" class="center">Vous n'avez aucun message non-lu.</td>
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

        <h3>Message(s) lu(s) (<?php echo Site::getUtilisateur()->getMessageCount(1); ?>):</h3>

        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauMessagerieLu">
                <thead>
                    <tr>
                        <th class="sorting_asc">Titre du message</th>
                        <th class="sorting_asc">Utilisateur</th>
                        <th class="sorting_asc">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!is_null($lstMessageObjs = Site::getUtilisateur()->getMessageObjs(1))):
                        foreach ($lstMessageObjs as $objMessage):
                            $objEmetteur = $objMessage->getEmetteurObj();
                            ?>
                            <tr id="ligneMsg<?php echo $objMessage->getId(); ?>" class="gradeX">
                                <td id="titre">
                                    <input type="hidden" name="titre" value="<?php echo $objMessage->getTitre(); ?>"> 
                                    <a onclick="getView({'controller' : 'notification', 'view' : 'message', 'id' : '<?php echo $objMessage->getId(); ?>'});"><?php echo $objMessage->getTitre(); ?></a>
                                </td>

                                <td id="user">
                                    <input type="hidden" name="user" value="<?php echo $objEmetteur->getLogin(); ?>"> 
                                    <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objEmetteur->getId(); ?>'});"><?php echo $objEmetteur->getLogin(); ?></a>
                                </td>

                                <td id="date">
                                    <input type="hidden" name="date" value="<?php echo $objMessage->getDateTable(); ?>"> 
                                    <?php echo $objMessage->getDateTable(); ?>
                                </td>
                            </tr>

                            <?php
                            unset($objEmetteur);
                            unset($objMessage);
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="3" class="center">Vous n'avez aucun message lu.</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>