<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_fichePjt.png"/> 
            <div class="header_02">Fiche de votre projet </div>
        </div>
        </br></br>

        <form id="pf1">

            <input type="hidden" name="action" value="editer"/>
            <input type="hidden" name="controller" value="projet"/>
            <input type="hidden" name="id" value="<?php echo $objProjet->getId(); ?>"/>

            <label for="libelle">Titre du projet : </label><br />
            <input id="libelle" accesskey="l" type='text' name='libelle' size='18' maxlength='100' value="<?php echo $objProjet->getLibelle(); ?>" />
            </br></br>

            <label for="description">Description du projet : </label></br>
            <textarea name="description" id="description"><?php echo $objProjet->getDescription(); ?></textarea>
            </br></br>

            <label for="blahComp">Compétence(s) demandée(s) : </label><br />
            <input type="text" id="demo-input-local2" name="blahComp" />
            <br /><br />

            <script type="text/javascript">
                $(document).ready(function() {
				
                    $("#demo-input-local2").tokenInput([
<?php
if (!is_null($lstCompetenceObjs = Competence::getNObjs())) {
    foreach ($lstCompetenceObjs as &$objCompetence) {
        ?>
                            {
                                id: <?php echo str_replace('"', '', json_encode($objCompetence->getId())); ?>, 
                                name: "<?php echo str_replace('"', '', json_encode($objCompetence->getLibelle())); ?>"
                            },   
        <?php
        unset($objCompetence);
    }
}
?>
        ],
        { prePopulate: [
<?php
if (!is_null($lstCompetenceObjs = $objProjet->getCompetenceObjs())) {
    foreach ($lstCompetenceObjs as &$objCompetence) {
        ?>
                                {
                                    id: <?php echo $objCompetence->getId(); ?>, 
                                    name: "<?php echo $objCompetence->getLibelle(); ?>"
                                },
        <?php
        unset($objCompetence);
    }
}
?>					
            ]});
            
    });
            </script>

            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <label for="document">Fichier : </label><br />
            <?php
            if (!is_null($lstDocumentIds = Document::getDocumentIds($objProjet->getId()))) {
                foreach ($lstDocumentIds as $idDocument) {
                    $objDocument = new Document($idDocument);
                    $libelle = $objDocument->getLibelle();
                    ?>
                    <input type="file" name="document" value="<?php echo $objDocument->getLien(); ?>">
                    <?php
                    unset($objDocument);
                }
            }
            ?>
            <br /><br />

            <label for="budget">Budget : </label><br />
            <input id="budget" accesskey="l" type='text' name='budget' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" />
            </br></br>

            <label for="echeance">Echéance fixée : </label><br />
            <input id="echeance" accesskey="l" type='text' name='echeance' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" />
            </br></br>

            <label for="date">Date de création : </label><br />
            <input id="date" accesskey="l" type='text' name='date' size='18' maxlength='100' value="<?php echo $objProjet->getDate(); ?>" />
            </br></br>

            <label for="etat">Etat : </label><br />
            <input id="etat" accesskey="l" type='text' name='etat' size='18' maxlength='100' value="<?php echo $objProjet->getEtatObj(); ?>" />
            </br></br>

            <div id="demo">
                <?php
                $verrou = false;
                if ($objProjet->getEtatId() == "3" && $objProjet->isPorteur(Site::getUtilisateur()))
                    $verrou = true;
                ?>
                <table id="listePrestataire">
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="tableauPrestataire">
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
                                // Aucun
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
                                // Aucun
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
            }
            ?>
            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>
        </form>

        <div id="main">
            <ol  id="update" class="timeline">
                <?php
                if (!is_null($lstCommentaireIds = Notification::getCommentaireProjetIds($idProjet))) {
                    foreach ($lstCommentaireIds as $idCommentaire) {
                        $objCommentaire = new Notification($idCommentaire);
                        ?>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objCommentaire->getEmetteur(); ?>'});"><?php echo $objCommentaire->getSujet(); ?></a></span>, le <span class="com_date"> <?php echo $objCommentaire->getDate(); ?></span> a écrit : <br />
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
                if (isset($message)) {
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
<script type="text/javascript">
    $(function() {
        $(".commenter").click(function() {

            var idEmetteur = $("#idEmetteur").val();
            var idProjet = $("#idProjet").val();
            var logEmetteur = $("#logEmetteur").val();
            var titre = $("#titre").val();
            var comment = $("#comment").val();
            var action = $("#action").val();

            var dataString = 'action=' + action + ' &titre=' + titre + ' &comment=' + comment + '&idEmetteur=' + idEmetteur + '&idProjet=' + idProjet + '&logEmetteur=' + logEmetteur;
            //alert(dataString);	
            if(comment=='')
            {
                alert('Veuillez saisir un commentaire');
            }
            else
            {
                $("#flash").show();
                $("#flash").fadeIn(400).html('<img src="ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');

                $.ajax({
                    type: "POST",
                    url: "notification.php",
                    data: dataString,
                    cache: false,
                    success: function(html){
 
                        $("ol#update").append(html);
                        $("ol#update li:last").fadeIn("slow");
                        document.getElementById('comment').value='';
                        $("#name").focus();
 
                        $("#flash").hide();
                    }
                });
            }
            return false;
        });
    });
</script>