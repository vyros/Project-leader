<?php
/*
 * Vue d'edition d'un projet existant.
 * 
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_fichePjt.png"/> 
            <div class="header_02">Fiche du projet : "<?php echo $objProjet->getLibelle(); ?>" </div>
        </div>
        </br></br>

        <form id="pf1">

            <input type="hidden" name="action" value="editer"/>
            <input type="hidden" name="controller" value="projet"/>
            <input type="hidden" name="id" value="<?php echo $objProjet->getId(); ?>"/>

            <?php
            if (Site::getUtilisateur()->getStatut() == "prestataire") {
                $disabled = "disabled";
            } else {
                $disabled = "";
            }
            ?>

            <label for="libelle">Titre du projet : </label><br />
            <input id="libelle" accesskey="l" type='text' name='libelle' size='18' maxlength='100' value="<?php echo $objProjet->getLibelle(); ?>" <?php echo $disabled; ?>/>
            </br></br>

            <label for="description">Description du projet : </label></br>
            <?php
            if (!is_null($disabled) && $disabled == "disabled") {
                ?>
                <textarea name="description" id="description" readonly="readonly"><?php echo $objProjet->getDescription(); ?></textarea>
                <?php
            } else {
                ?>
                <textarea name="description" id="description"><?php echo $objProjet->getDescription(); ?></textarea>
                <?php
            }
            ?>
            </br></br>

            <label for="blahComp">Compétence(s) demandée(s) : </label><br />
            <input type="text" id="demo-input-local" name="blahComp" <?php echo $disabled; ?>/>
            <br /><br />

            <label for="budget">Budget : </label><br />
            <input id="budget" accesskey="l" type='text' name='budget' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" <?php echo $disabled; ?>/>
            </br></br>

            <label for="echeance">Échéance fixée : </label><br />
            <input id="echeance" accesskey="l" type='text' name='echeance' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" <?php echo $disabled; ?>/>
            </br></br>

            <label for="date">Date de création : </label><br />
            <input id="date" accesskey="l" type='text' name='date' size='18' maxlength='100' value="<?php echo $objProjet->getDate(); ?>" <?php echo $disabled; ?>/>
            </br></br>

            <label for="etat">État : </label><br />
            <input id="etat" accesskey="l" type='text' name='etat' size='18' maxlength='100' value="<?php echo $objProjet->getEtatObj(); ?>" <?php echo $disabled; ?>/>
            </br></br>

            <div id="demo">
                <?php
                $verrou = false;
                if ($objProjet->getEtatId() == "3" && $objProjet->isPorteur(Site::getUtilisateur()))
                    $verrou = true;
                ?>
                <table id="listePrestataire">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauFichePrestataire">
                        <thead>
                            <tr>
                                <th class="sorting_asc">Prestataire</th>
                                <th class="sorting_asc">Accès fiche</th>
                                <?php
                                if ($verrou) {
                                    ?>
                                    <th class="sorting_asc">Évaluer</th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!is_null($lstParticipantIds = $objProjet->getPrestataireIds())) {
                                foreach ($lstParticipantIds as $idParticipant) {
                                    $objUtilisateur = new Utilisateur($idParticipant);
                                    ?>
                                    <tr id="lignePrestataire<?php echo $objUtilisateur->getId(); ?>" class="gradeX">
                                        <td id="id">
                                            <input type="hidden" name="id" value="<?php echo $objUtilisateur->getId(); ?>">
                                            <?php echo $objUtilisateur; ?>											
                                        </td>

                                        <td id="access">
                                            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                                                <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                        </td>
                                        <?php
                                        if ($verrou) {
                                            ?>
                                            <td id="note">
                                                <a onclick="getEvaluation({'idUtilisateur' : '<?php echo $objUtilisateur->getId(); ?>', 'idProjet' : '<?php echo $objProjet->getId(); ?>'});">
                                                    <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  											
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    unset($objUtilisateur);
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="center">Aucun participant</td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </table>
            </div>

            <div id="demo">
                <?php
                $verrou = false;
                if ($objProjet->getEtatId() == "3" && $objProjet->isPrestataire(Site::getUtilisateur()))
                    $verrou = true;
                ?>
                <table id="listePorteur">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauPorteur">
                        <thead>
                            <tr>
                                <th class="sorting_asc">Porteur</th>
                                <th class="sorting_asc">Accès fiche</th>
                                <?php
                                if ($verrou) {
                                    ?>
                                    <th class="sorting_asc">Évaluer</th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!is_null($lstParticipantIds = $objProjet->getPorteurIds())) {
                                foreach ($lstParticipantIds as $idParticipant) {
                                    $objUtilisateur = new Utilisateur($idParticipant);
                                    ?>
                                    <tr id="lignePrestataire<?php echo $objUtilisateur->getId(); ?>" class="gradeX">
                                        <td id="id">
                                            <input type="hidden" name="id" value="<?php echo $objUtilisateur->getId(); ?>">
                                            <?php echo $objUtilisateur; ?>											
                                        </td>

                                        <td id="access">
                                            <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                                                <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                        </td>
                                        <?php
                                        if ($verrou) {
                                            ?>
                                            <td id="note">
                                                <a onclick="getEvaluation({'idUtilisateurlisateur' : '<?php echo $objUtilisateur->getId(); ?>', 'idProjet' : '<?php echo $objProjet->getId(); ?>'});">
                                                    <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  											
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    unset($objUtilisateur);
                                }
                            } else {
                                // EN théorie il y a toujours un porteur de projet sur une fiche de projet donc Else inutile
                                ;
                            }
                            ?>
                        </tbody>
                    </table>
                </table>
            </div>

            <div class="margin_bottom_30"></div>
            <?php
            if ($objProjet->isPorteur(Site::getUtilisateur())) {
                ?>
                <input type="button" onclick="getFormulary('pf1');" value="Valider" />
                <?php
                if (is_null($lstParticipants = $objProjet->getPrestataireIds())) {
                    ?>
                    <a onclick="getView({'controller' : 'notification', 'view' : 'nouveauMsg'});">Assigner prestataire</a>
                    <?php
                }
            } else {

                if (Site::getUtilisateur()->IsFavoris($idProjet)) {
                    ?><label id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label><?php
        } else {
                    ?> <input id='btnfavoris' type='button' value='Favoris' />
                    <label style='display:none' id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label>
                    <?php
                }

                if (is_null($lstParticipants = $objProjet->getPrestataireIds())) {
                    ?>
                    <a onclick="getView({'controller' : 'notification', 'view' : 'nouveauMsg'});">Postuler</a>
                    <?php
                }
            }
            ?>
        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <form id="pf2" enctype="multipart/form-data" action="projet.php" method="post">

            <h3>Ajouter des documents au projet <?php echo $objProjet->getLibelle(); ?></h3>
            <br />

            <input type="hidden" name="action" value="document"/>
            <input type="hidden" name="id" value="<?php echo $objProjet->getId(); ?>"/>
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />

            <?php
            $i = 1;
            if (!is_null($lstDocumentObjs = $objProjet->getDocumentObjs())) {
                foreach ($lstDocumentObjs as $objDocument) {
                    ?>
                    <label for="document<?php echo $i; ?>">Document <?php echo $i; ?> : </label><br />
                    <a name="document<?php echo $i; ?>" href="<?php echo $objDocument->getLien(); ?>" ><?php echo $objDocument->getLibelle(); ?></a>
                    <br /><br />
                    <?php
                    unset($objDocument);
                    $i++;
                }
            } else {
                ?>
                <label for="document<?php echo $i; ?>">Document <?php echo $i; ?> : </label><br />
                <input type="file" name="document<?php echo $i; ?>" value="" />
                <br />
                <?php
            }
            ?>
            <div id="nouveau_input"></div><a onClick="addLine({'form' : 'pf2'});">Ajouter un document</a><br />
            <br /><br />

            <input type="hidden" id="next" name="next" value="<?php echo $i; ?>"/>
            <input type="submit" value="Valider" />
        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <label for="infoPrj">Voir plus : </label>
        <p>
            <?php
            // MARCHE PAS
//                    $i = 0;
//                    if (!is_null($lstPrjSimilaire)) {
//                        foreach ($lstPrjSimilaire as $objProjet) {
            ?>
                            <!--<a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php // echo $objProjet->getId();              ?>'});">-->
            <?php // echo "- " . $objProjet->getLibelle(); ?></a><br />
            <?php
//                            $i++;
//                        }
//                    }
            ?>
        </p>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <div id="main">
            <ol  id="update" class="timeline">
                <?php
                if (!is_null($lstCommentaireIds = Notification::getCommentaireProjetIds($idProjet))) {
                    foreach ($lstCommentaireIds as $idCommentaire) {
                        $objCommentaire = new Notification($idCommentaire);
                        ?>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objCommentaire->getEmetteurId(); ?>'});"><?php echo $objCommentaire->getSujet(); ?></a></span>, le <span class="com_date"> <?php echo $objCommentaire->getDate(); ?></span> a écrit : <br />
                            <?php echo $objCommentaire->getLibelle(); ?>
                        </li>
                    </ol>
                    <?php
                    unset($objCommentaire);
                }
            }
            ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">
                <form action="" method="post">

                    <input type="hidden" id="action" name="action" value="commentaire"/>
                    <input type="hidden" name="controller" value="notification"/>

                    <input type="hidden" name="idEmetteur" id="idEmetteur"  value="<?php echo $idUtilisateur; ?>"/>
                    <input type="hidden" name="idProjet" id="idProjet"  value="<?php echo $idProjet; ?>"/>
                    <input type="hidden" name="logEmetteur" id="logEmetteur"  value="<?php echo Site::getUtilisateur()->getLogin(); ?>"/>
                    <input type="hidden" name="titre" id="titre"  value="<?php echo $titre; ?>"/>

                    <textarea name="comment" id="comment"></textarea><br />

                    <input type="submit" class="commenter" value="Envoyer" />
                </form>
            </div>
        </div> 

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>
</div>

<div class="content_col_w420 fr">

    <div class="sub_content_col">
        <img style="width:350px; position: relative; left:60px; top:70px;" class="" src="images/logo_seul.png"/>

        <div class="conteneur_bulleAcc">
            <div class="messageBulle">
                <?php
                if (!is_null($message)) {
                    include_once('views/message.php');
                } else {
                    ?>
                    <span>Sur cette page, vous pouvez modifier les informations de votre projet : "<?php echo $objProjet->getLibelle(); ?>". N'oubliez pas de valider ces modifications !</span>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

    <div id="evaluation"></div>
</div>