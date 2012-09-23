<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <div class="header_02">Vos messages</div>
        </div>
        
        <br />
        <a href="javascript:;" id="fancybox-manual-b" class="link_new_pm">Nouveau message priv&eacute;</a><br />


        <h3>Messages non-lus(<?php echo $nbreNonLu; ?>):</h3>
        
         <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                <thead>
                    <tr>
                        <th class="sorting_asc">Titre du message</th>
                        <th class="sorting_asc">Utilisateur</th>
                        <th class="sorting_asc">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //var_dump($lstMsgNonLu);
                        //On affiche la liste des messages non-lus
                        if (!is_null($lstMsgNonLu)) {
                            foreach ($lstMsgNonLu as $value) {

                                $objMsg = new Notification($value);
                                $nom = $objMsg->getSujet();
                                $titre = $objMsg->getTitre();
                        //      $libelle = $objMsg->getLibelle();
                                $date = $objMsg->getDate();
                
                    ?>
                
                
                    <tr id="ligneMsg<?php echo $objMsg->getId(); ?>" class="gradeX">
                        <td id="titre">
                            <input type="hidden" name="titre" value="<?php echo $titre ?>"> 
            <!--                                    <a href="read_pm.php?id=<?php  ?>"><?php // echo htmlentities($titre, ENT_QUOTES, 'UTF-8'); ?></a>-->
                            <a onclick="getView({'controller' : 'notification', 'view' : 'message', 'id' : '<?php echo $objMsg->getId(); ?>'});"><?php echo $titre ?></a>
                        </td>
                        
                        <td id="user">
                            <input type="hidden" name="user" value="<?php echo $nom ?>"> 
                            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objMsg->getEmetteur(); ?>'});"><?php echo $nom ?></a>
                        </td>
                        
                        <td id="date">
                            <input type="hidden" name="date" value="<?php echo $date ?>"> 
                            <?php echo $date ?>
                        </td>
                    </tr>
            
                    <?php
                            }
                    }else{
                    //Sil na aucun message non-lu, on le dit   
                    ?>
                        <tr>
                            <td colspan="4" class="center">Vous n'avez aucun message non-lu.</td>
                            <td id="user"></td>
                            <td id="date"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
        </table>
      </div>
        
        <br />

        <h3>Messages lus(<?php echo $nbreLu; ?>):</h3>
        <div id="demo">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th class="sorting_asc">Titre du message</th>
                        <th class="sorting_asc">Utilisateur</th>
                        <th class="sorting_asc">Date d'envoi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //var_dump($lstMsgNonLu);
                        //On affiche la liste des messages non-lus
                        if (!is_null($lstMsgLu)) {
                            foreach ($lstMsgLu as $value) {

                                $objMsg = new Notification($value);
                                $nom = $objMsg->getSujet();
                                $titre = $objMsg->getTitre();
                        //      $libelle = $objMsg->getLibelle();
                                $date = $objMsg->getDate();
                
                    ?>
                
                
                    <tr id="ligneMsg<?php echo $objMsg->getId(); ?>" class="gradeX">
                        <td id="titre">
                            <input type="hidden" name="titre" value="<?php echo $titre ?>"> 
            <!--                                    <a href="read_pm.php?id=<?php  ?>"><?php // echo htmlentities($titre, ENT_QUOTES, 'UTF-8'); ?></a>-->
                            <a onclick="getView({'controller' : 'notification', 'view' : 'message', 'id' : '<?php echo $objMsg->getId(); ?>'});"><?php echo $titre ?></a>
                        </td>
                        
                        <td id="user">
                            <input type="hidden" name="user" value="<?php echo $nom ?>"> 
                            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objMsg->getEmetteur(); ?>'});"><?php echo $nom ?></a>
                        </td>
                        
                        <td id="date">
                            <input type="hidden" name="date" value="<?php echo $date ?>"> 
                            <?php echo $date ?>
                        </td>
                    </tr>
            
                    <?php
                            }
                    }else{
                    //Sil na aucun message non-lu, on le dit   
                    ?>
                        <tr>
                            <td colspan="4" class="center">Vous n'avez aucun message lu.</td>
                            <td id="user"></td>
                            <td id="date"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
        </table>
      </div>

    </div>
    
</div>