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
            <div class="header_02">Fiche du projet : "<?= $objProjet->getLibelle() ?>" </div>
        </div>
        </br></br>

        <form id="pf1">

            <input type="hidden" name="action" value="editer"/>
            <input type="hidden" name="controller" value="projet"/>
            <input type="hidden" name="id" value="<?= $objProjet->getId() ?>"/>

            <?php
            if (Site::getUtilisateur()->getStatut() == "prestataire"):
                $disabled = "disabled";
            else:
                $disabled = "";
            endif;
            ?>

            <label for="libelle">Titre du projet : </label><br />
            <input id="libelle" accesskey="l" type='text' name='libelle' size='18' maxlength='100' value="<?= $objProjet->getLibelle() ?>" <?= $disabled ?>/>
                   </br></br>

            <label for="description">Description du projet : </label></br>
            <?php
            if (!is_null($disabled) && $disabled == "disabled"):
                ?>
                <textarea name="description" id="description" readonly="readonly"><?= $objProjet->getDescription() ?></textarea>
                <?php
            else:
                ?>
                <textarea name="description" id="description"><?= $objProjet->getDescription() ?></textarea>
            <?php
            endif;
            ?>
            </br></br>

            <label for="blahComp">Compétence(s) demandée(s) : </label><br />
            <input type="text" id="demo-input-local" name="blahComp" <?= $disabled ?>/>
                   <br /><br />

            <label for="budget">Budget : </label><br />
            <input id="budget" accesskey="l" type='text' name='budget' size='18' maxlength='100' value="<?= $objProjet->getBudget() ?>" <?= $disabled ?>/>
                   </br></br>

            <label for="echeance">Échéance fixée : </label><br />
            <input id="echeance" accesskey="l" type='text' name='echeance' size='18' maxlength='100' value="<?= $objProjet->getEcheance() ?>" <?= $disabled ?>/>
                   </br></br>

            <label for="date">Date de création : </label><br />
            <input id="date" accesskey="l" type='text' name='date' size='18' maxlength='100' value="<?= $objProjet->getDate() ?>" <?= $disabled ?>/>
                   </br></br>

            <label for="etat">État : </label><br />
            <input id="etat" accesskey="l" type='text' name='etat' size='18' maxlength='100' value="<?= $objProjet->getEtatObj() ?>" <?= $disabled ?>/>
                   </br></br>

            <div id="demo">
                <?php
                $verrou = false;
                if ($objProjet->getEtatId() == "3" && $objProjet->isPorteur(Site::getUtilisateur()))
                    $verrou = true;
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauFichePrestataire">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Prestataire</th>
                            <th class="sorting_asc">Accès fiche</th>
                            <?php
                            if ($verrou):
                                ?>
                                <th class="sorting_asc">Évaluer</th>
                                <?php
                            endif;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!is_null($lstParticipantIds = $objProjet->getPrestataireIds())):
                            foreach ($lstParticipantIds as $idParticipant):
                                $objUtilisateur = new Utilisateur($idParticipant);
                                ?>
                                <tr id="lignePrestataire<?= $objUtilisateur->getId() ?>" class="gradeX">
                                    <td id="id">
                                        <input type="hidden" name="id" value="<?= $objUtilisateur->getId() ?>">
                                        <?= $objUtilisateur ?>											
                                    </td>

                                    <td id="access">
                                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?= $objUtilisateur->getId() ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                    </td>
                                    <?php
                                    if ($verrou):
                                        ?>
                                        <td id="note">
                                            <a onclick="getEvaluation({'idUtilisateur' : '<?= $objUtilisateur->getId() ?>', 'idProjet' : '<?= $objProjet->getId() ?>'});">
                                                <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  											
                                        </td>
                                        <?php
                                    endif;
                                    ?>
                                </tr>
                                <?php
                                unset($objUtilisateur);
                            endforeach;
                        else:
                            ?>
                            <tr>
                                <?php
                                if ($verrou):
                                    ?>
                                    <td colspan="3" class="center">Aucun prestataire au projet</td>
                                    <td></td>
                                    <?php
                                else:
                                    ?>
                                    <td colspan="2" class="center">Aucun prestataire au projet</td>
                                <?php
                                endif;
                                ?>
                                <td></td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="demo">
                <?php
                $verrou = false;
                if ($objProjet->getEtatId() == "3" && $objProjet->isPrestataire(Site::getUtilisateur()))
                    $verrou = true;
                ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauPorteur">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Porteur</th>
                            <th class="sorting_asc">Accès fiche</th>
                            <?php
                            if ($verrou):
                                ?>
                                <th class="sorting_asc">Évaluer</th>
                                <?php
                            endif;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!is_null($lstParticipantIds = $objProjet->getPorteurIds())):
                            foreach ($lstParticipantIds as $idParticipant):
                                $objUtilisateur = new Utilisateur($idParticipant);
                                ?>
                                <tr id="lignePrestataire<?= $objUtilisateur->getId() ?>" class="gradeX">
                                    <td id="id">
                                        <input type="hidden" name="id" value="<?= $objUtilisateur->getId() ?>">
                                        <?= $objUtilisateur ?>											
                                    </td>

                                    <td id="access">
                                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?= $objUtilisateur->getId() ?>'});">
                                            <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  										
                                    </td>
                                    <?php
                                    if ($verrou):
                                        ?>
                                        <td id="note">
                                            <a onclick="getEvaluation({'idUtilisateurlisateur' : '<?= $objUtilisateur->getId() ?>', 'idProjet' : '<?= $objProjet->getId() ?>'});">
                                                <img class="imgLienFiche" src="images/lien_fiche.png"/> </a>  											
                                        </td>
                                        <?php
                                    endif;
                                    ?>
                                </tr>
                                <?php
                                unset($objUtilisateur);
                            endforeach;

                        else:
                            ?>
                            <tr>
                                <?php
                                if ($verrou):
                                    ?>
                                    <td colspan="3" class="center">Aucun porteur au projet</td>
                                    <td></td>
                                    <?php
                                else:
                                    ?>
                                    <td colspan="2" class="center">Aucun porteur au projet</td>
                                <?php
                                endif;
                                ?>
                                <td></td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                </table>

            </div>

            <div class="margin_bottom_30"></div>
            <?php
            if ($objProjet->isPorteur(Site::getUtilisateur())):
                ?>
                <input type="button" onclick="getFormulary('pf1');" value="Valider" />
                <?php
                if (is_null($lstParticipants = $objProjet->getPrestataireIds())):
                    ?>
                    <a onclick="getView({'controller' : 'notification', 'view' : 'nouveauMsg'});">Assigner prestataire</a>
                    <?php
                endif;
            else:

                if (Site::getUtilisateur()->IsFavoris($idProjet)):
                    ?><label id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label><?php
                else:
                    ?> <input id='btnfavoris' type='button' value='Favoris' />
                    <label style='display:none' id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label>
                <?php
                endif;

                if (is_null($lstParticipants = $objProjet->getPrestataireIds())):
                    ?>
                    <a onclick="getView({'controller' : 'notification', 'view' : 'nouveauMsg'});">Postuler</a>
                    <?php
                endif;
            endif;
            ?>
        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

        <form id="pf2" enctype="multipart/form-data" action="projet.php" method="post">

            <h3>Ajouter des documents au projet <?= $objProjet->getLibelle() ?></h3>
            <br />

            <input type="hidden" name="action" value="document"/>
            <input type="hidden" name="id" value="<?= $objProjet->getId() ?>"/>
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />

            <?php
            $i = 1;
            if (!is_null($lstDocumentObjs = $objProjet->getDocumentObjs())):
                foreach ($lstDocumentObjs as $objDocument):
                    ?>
                    <label for="document<?= $i ?>">Document <?= $i ?> : </label><br />
                    <a name="document<?= $i ?>" href="<?= $objDocument->getLien() ?>" ><?= $objDocument->getLibelle() ?></a>
                    <br /><br />
                    <?php
                    unset($objDocument);
                    $i++;
                endforeach;
            else:
                ?>
                <label for="document<?= $i ?>">Document <?= $i ?> : </label><br />
                <input type="file" name="document<?= $i ?>" value="" />
                <br />
            <?php
            endif;
            ?>
            <div id="nouveau_input"></div><a onClick="addLine({'form' : 'pf2'});">Ajouter un document</a><br />
            <br /><br />

            <input type="hidden" id="next" name="next" value="<?= $i ?>"/>
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
                            <!--<a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php // echo $objProjet->getId();                               ?>'});">-->
            <?php // echo "- " . $objProjet->getLibelle() ?></a><br />
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
                if (!is_null($lstCommentaireIds = Notification::getCommentaireProjetIds($idProjet))):
                    foreach ($lstCommentaireIds as $idCommentaire):
                        $objCommentaire = new Notification($idCommentaire);
                        ?>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?= $image ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?= $objCommentaire->getEmetteurId() ?>'});"><?= $objCommentaire->getSujet() ?></a></span>, le <span class="com_date"> <?= $objCommentaire->getDate() ?></span> a écrit : <br />
                            <?= $objCommentaire->getLibelle() ?>
                        </li>
                    </ol>
                    <?php
                    unset($objCommentaire);
                endforeach;
            endif;
            ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">
                <form action="" method="post">

                    <input type="hidden" id="action" name="action" value="commentaire"/>
                    <input type="hidden" name="controller" value="notification"/>

                    <input type="hidden" name="idEmetteur" id="idEmetteur"  value="<?= $idUtilisateur ?>"/>
                    <input type="hidden" name="idProjet" id="idProjet"  value="<?= $idProjet ?>"/>
                    <input type="hidden" name="logEmetteur" id="logEmetteur"  value="<?= Site::getUtilisateur()->getLogin() ?>"/>
                    <input type="hidden" name="titre" id="titre"  value="<?= $titre ?>"/>

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
                if (!is_null($message)):
                    include_once('views/message.php');
                else:
                    ?>
                    <span>Sur cette page, vous pouvez modifier les informations de votre projet : "<?= $objProjet->getLibelle() ?>". N'oubliez pas de valider ces modifications !</span>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>

    <div class="margin_bottom_20 border_bottom"></div>
    <div class="margin_bottom_30"></div>

    <div id="evaluation"></div>
</div>