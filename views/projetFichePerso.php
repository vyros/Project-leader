<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$idProjet = $lstProjetIds[0][0];
$objProjet = new Projet($idProjet);
//print_r($lstProjetIds);
$idUti = Site::getUtilisateur()->getId();
?>

<script type="text/javascript">
$(function() {
    
    
$(".commenter").click(function() {

var idUti = $("#idUti").val();
var idPjt = $("#idPjt").val();
var nomUti = $("#nomUti").val();
var titre = $("#titre").val();
var comment = $("#comment").val();
var action = $("#action").val();

var dataString = 'action=' + action + ' &titre=' + titre + ' &comment=' + comment + '&idUti=' + idUti + '&idPjt=' + idPjt + '&nomUti=' + nomUti;
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
            <input type="hidden" name="idProjet" value="<?php echo $idProjet;?>"/>
            
            <label for="infoPrj">Titre du projet : </label>
            <input id="titre" accesskey="l" type='text' name='titre' size='18' maxlength='100' value="<?php echo $objProjet->getLibelle(); ?>" />
            </br></br>
            
            <label for="infoPrj">Description du projet : </label></br>
            <textarea name="description" id="description"><?php echo $objProjet->getDescription(); ?></textarea>
            </br></br>

            <label for="demo-input-local">Catégorie du projet : </label>
            <input type="text" id="demo-input-local" name="blahCat" />
            
            
            <script type="text/javascript">
                $(document).ready(function() {
				
                $("#demo-input-local").tokenInput([
                <?php
                $lstCategorieIds = Categorie::getLstNIds();
                
                if (!is_null($lstCategorieIds)) {
                    foreach ($lstCategorieIds as $value) {
					
                        $objCategorie = new Categorie($value);
                        ?>
                        {
                            id: <?php echo str_replace('"', '', json_encode($objCategorie->getId())); ?>, 
                            name: "<?php echo str_replace('"', '', json_encode($objCategorie->getLibelle())); ?>"
                        },   
                        <?php
                    }
                }
                ?>
                ],
                { prePopulate: [
                <?php
                $lstCategorieIds = $objProjet->getCategorieIds();
				if (!is_null($lstCategorieIds)) {
                foreach ($lstCategorieIds as $idCategorie) {
                    $objCategorie = new Categorie($idCategorie);
                        ?>
                        {
                            id: <?php echo $idCategorie; ?>, 
                            name: "<?php echo $objCategorie->getLibelle(); ?>"
                        },
                        <?php
                    }
                }
                ?>					
                ]});
            
                });
            </script>
            </br></br>
                    
                    
            <label for="demo-input-local">Compétence(s) demandée(s) : </label>
            <input type="text" id="demo-input-local2" name="blahComp" />
            
            
            <script type="text/javascript">
                $(document).ready(function() {
				
                $("#demo-input-local2").tokenInput([
                <?php
                $lstCompetenceIds = Competence::getLstNIds();
                if (!is_null($lstCompetenceIds)) {
                    foreach ($lstCompetenceIds as $value) {
                        $objCompetence = new Competence($value);
                        ?>
                        {
                            id: <?php echo str_replace('"', '', json_encode($objCompetence->getId())); ?>, 
                            name: "<?php echo str_replace('"', '', json_encode($objCompetence->getLibelle())); ?>"
                        },   
                        <?php
                    }
                }
                ?>
                ],
                { prePopulate: [
                <?php
                $lstCompetenceIds = $objProjet->getCompetenceIds();
                if (!is_null($lstCompetenceIds)) {
                    foreach ($lstCompetenceIds as $idCompetence) {
                        $objCompetence = new Competence($idCompetence);
                        ?>
                        {
                            id: <?php echo $idCompetence; ?>, 
                            name: "<?php echo $objCompetence->getLibelle(); ?>"
                        },
                        <?php
                    }
                }
                ?>					
                ]});
            
                });
            </script>
            </br></br>
            
            <label for="infoPrj">Budget : </label>
            <input id="budget" accesskey="l" type='text' name='budget' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" />
            </br></br>
            <label for="infoPrj">Délai fixé : </label>
            <input id="delai" accesskey="l" type='text' name='delai' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" />
            </br></br>
            <label for="infoPrj">Date de création : </label>
            <input id="ddc" accesskey="l" type='text' name='ddc' size='18' maxlength='100' value="<?php echo $objProjet->getDateCreation(); ?>" />
            </br></br>
            <?php
            $idEtat = $objProjet->getEtatId();
            $monEtat = new Etat($idEtat);
            ?>
            <label for="infoPrj">Statut : </label>
            <input id="statut" accesskey="l" type='text' name='statut' size='18' maxlength='100' value="<?php echo $monEtat->getLibelle(); ?>" />
            </br></br>
            <div id="participant" class="infoProjet">
                Participant :
                <?php
                $lstParticipants = PARTICIPER::voirParticipationPresta($idProjet);
                if (!is_null($lstParticipants)) {
                    foreach ($lstParticipants as $value) {
                        $objUtilisateur = new Utilisateur($value);
                        echo ('- ');
                        ?>
                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                            <?php echo $objUtilisateur->getLogin(); ?></a><br />
                        <?php
                    }
                }
                ?>
            </div>
            </br></br>
            <div id="client" class="infoProjet">
                Client :
                <?php
                $lstClient = PARTICIPER::voirParticipationCli($idProjet);
                if (!is_null($lstClient)) {
                    
                    if(mysql_num_rows($lstClient)== 1)			
                    {
                        $object=mysql_fetch_object($lstClient);	
                        $idClientProjet = $object->uti_id;
                        $objUtilisateur = new Utilisateur($idClientProjet);
                        echo ('- ');
                        ?>
                        <a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objUtilisateur->getId(); ?>'});">
                            <?php echo $objUtilisateur->getLogin(); ?></a><br />
                        <?php
                    }
                }
                ?>
            </div>
            </br></br>
           
            <div class="margin_bottom_30"></div>

            <input type="button" onclick="getFormulary('pf1');" value="Valider" />

            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>
             
         

        </form>
        
           <div id="main">
               
                <ol  id="update" class="timeline">

                    <?php

                    $listComProjet = Notification::getComProjet($idProjet);
                    //var_dump($listComProjet);
                    if (!is_null($listComProjet)) {
                            foreach ($listComProjet as $value) {

                                $objCom = new Notification($value);
                                $titre = $objCom->getTitre();
                                $nom = $objCom->getNom();
                                $libelle = $objCom->getLibelle();
                                $date = $objCom->getDate();
                                 
                    ?>
                        <li class="box" style="display:list-item;">
                            <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                            <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objCom->getUti(); ?>'});"><?php echo $nom ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a écrit : <br />
                            <?php echo $libelle; ?>
                        </li>

                </ol>
            
            

            <?php
                }
            }
            ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">
                
                <form action="" method="post">
                    
                <input type="hidden" id="action" name="action" value="addCom"/><!--
                    <input type="hidden" name="controller" value="projet"/>-->
            
                    <input type="hidden" name="idUti" id="idUti"  value="<?php echo $idUti; ?>"/>
                    <input type="hidden" name="idPjt" id="idPjt"  value="<?php echo $idProjet; ?>"/>
                    <input type="hidden" name="nomUti" id="nomUti"  value="<?php echo Site::getUtilisateur()->getLogin(); ?>"/>
                    <input type="hidden" name="titre" id="titre"  value="<?php echo $titre; ?>"/>
                    
                    <textarea name="comment" id="comment"></textarea><br />

                    <input type="submit" class="commenter" value=" Submit Comment " />
<!--                    <input type="button" onclick="getFormulary('pf2');" value="Submit Comment" />-->
                    
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
                if (isset($message)){
                    include_once('views/message.php');
                }else {
                ?>
                <span>Sur cette page, vous pouvez modifier les informations de votre projet : "<?php echo $objProjet->getLibelle(); ?>". N'oubliez pas de valider ces modifications !</span>
                <?php
                }
                ?>
            </div>
        </div>
    
    </div>
    
</div>