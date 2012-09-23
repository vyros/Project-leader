<?php
////????

$objNotification = new Notification($idMsg);
$idUtilisateur = Site::getUtilisateur()->getId();
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <div class="header_02">Message de : <?php echo $objNotification->getSujet();?></div>
        </div>
        
        <br />
        
        <div id="main">
               
                <ol id="update" class="timeline">
            
                    <?php

                        if (!is_null($listMsgConvers)) {
                            foreach ($listMsgConvers as $value) {

                                $objMsg = new Notification($value);
                                $nom = $objMsg->getSujet();
                                $titre = $objMsg->getTitre();
                                $libelle = $objMsg->getLibelle();
                                $date = $objMsg->getDate();
                                
                                $objMsg->editMsgLu($objMsg->getId());
                    ?>
                    <h2>Titre du message : <?php echo $titre; ?></h2>
                    <br/>
                    <li class="box" style="display:list-item;">
                        <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                        <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objMsg->getEmetteur(); ?>'});"><?php echo $nom ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a écrit : <br />
                        <?php echo $libelle; ?>
                    </li>
            
                </ol>

                    <?php
                            }
                        }
                    ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">
                
                <form action="views/messageajax.php" method="post">
                    
<!--                <input type="hidden" name="action" value="commentaire"/>
                    <input type="hidden" name="controller" value="projet"/>-->
            
                    <input type="hidden" name="idUti" id="idUti"  value="<?php echo $idUtilisateur; ?>"/>
                    <input type="hidden" name="idUti2" id="idUti2"  value="<?php echo $idUtilisateur2; ?>"/>
                    <input type="hidden" name="nomUti" id="nomUti"  value="<?php echo Site::getUtilisateur()->getLogin(); ?>"/>
                    
                    Titre de votre message :<input id="titre" accesskey="l" type='text' name='log' size='18' maxlength='100' value="" /> 
                    <textarea name="message" id="message"></textarea><br />

                    <input type="submit" class="envoyerMsg" value=" Envoyer " />
<!--                    <input type="button" onclick="getFormulary('pf2');" value="Submit Comment" />-->
                    
                </form>
                
            </div>

        </div>

    </div>
</div>