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
            $("#flash").fadeIn(400).html('<span class="loading">Loading Comment...</span>');

$.ajax({
  type: "POST",
  url: "notification.php",
//  url: "views/commentajax.php",
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

$("#btnfavoris").click(function() {
        
        var idUti = $("#idUti").val();
        var idPjt = $("#idPjt").val();

        var dataString = '&idUti=' + idUti + '&idPjt=' + idPjt;

        $.ajax({
        type: "POST",
        url: "favoris.php",
        data: dataString,
        cache: false,
        success: function(res){
            $("#btnfavoris").hide();
            $("#lblFav").show();
            }
        });   
    });
});


</script>

<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_fichePjt.png"/> 
            <div class="header_02"> Fiche de projet</div>
        </div>
        </br></br>
       
        <!-- favoris -->
        
        <?php
            if (Site::getUtilisateur()->getStatut() == "prestataire"){
                if (Site::getUtilisateur()->IsFavoris($idProjet)){
                    echo "<label id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label>";                   
                }else{
                    echo "<input id='btnfavoris' type='button' value='Favoris' />";
                    echo "<label style='display:none' id='lblFav' for='infoPrj'>Ce projet est dans vos favoris</label>";    
                }
            } ?>
        
        </br>
        <label for="infoPrj">Titre du projet : </label>
        <input id="titre" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getLibelle(); ?>" disabled/>
        </br></br>
            
        <label for="infoPrj">Description du projet : </label>
        <input id="description" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDescription(); ?>" disabled/>
        </br></br>

        <label for="demo-input-local">Compétence(s) demandée(s) : </label>
            <?php
            $lstCompetenceIds = $objProjet->getCompetenceIds();

            if (!is_null($lstCompetenceIds)) {
                foreach ($lstCompetenceIds as $idCompetence) {
                    $objCompetence = new Competence($idCompetence);
                    ?>
                    <input id="competence" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objCompetence->getLibelle(); ?>" disabled/> 
                    <?php
                }
            }
            ?>       
        <br/>
        <br/>
        
        <label for="infoPrj">Budget : </label>
        <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getBudget(); ?>" disabled/>
        <br/>
        <br/>
        
        <label for="infoPrj">Délai fixé : </label>
        <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getEcheance(); ?>" disabled/>
        <br/>
        <br/>
        
        <label for="infoPrj">Date de création : </label>
        <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $objProjet->getDateCreation(); ?>" disabled/>
        <br/>
        <br/>
        
        <label for="infoPrj">Statut : </label>
            <?php
                $idEtat = $objProjet->getEtatId();
                $monEtat = new Etat($idEtat);
            ?>
        <input id="budget" accesskey="l" type='text' name='log' size='18' maxlength='100' value="<?php echo $monEtat->getLibelle(); ?>" disabled/>
        <br/>
        <br/>
        
        <div id="participant" class="infoProjet">
            Participant :
            <?php
            $lstParticipants = $objProjet->getPrestataireIds();
            if (!is_null($lstParticipants)) {
                foreach ($lstParticipants as $value) {
                    $objUtilisateur = new Utilisateur($value);
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
                $lstClient = $objProjet->getPorteurIds();
                if (!is_null($lstClient)) {
                    
                    if(mysql_num_rows($lstClient)== 1)			
                    {
                        $object=mysql_fetch_object($lstClient);	
                        $idClientProjet = $object->uti_id;
                        $objUtilisateur = new Utilisateur($idClientProjet);
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
            <?php
            //script messagerie interne dispo, à adapter et a intégrer sur le 
            //sa sera la page pour envoyer un nouveau message
            ?>
            <input type="button" onclick="" value="envoyer MP" />

            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>
            
            <label for="infoPrj">Voir plus : </label>
            
            <?php
                // a faire: sortir les projet de meme competence et les associer les projet de meme categorie et de meme competence 
                $tabIdCompetence = $objProjet->getCompetenceIds();
                
                $objCorrespondre = new Correspondre($idProjet);
                $idCategorie = $objCorrespondre->getIdCategorie();
                $listPjtSimilaire = Projet::getProjetSimilaire($idCategorie);
                
                 if (!is_null($listPjtSimilaire)) {
                            foreach ($listPjtSimilaire as $value) {
                                
                               $objProjet = new Projet($value);
                               $nom = $objProjet->getLibelle();
                               ?>
<!--                               <a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $objProjet->getId(); ?>'});">
                                    <?php // echo $nom ?></a><br />-->
                               <?php
                            }
                 }
       
            ?>
            
            
            <div class="margin_bottom_20 border_bottom"></div>
            <div class="margin_bottom_30"></div>
            
            <div id="main">
               
                <ol  id="update" class="timeline">
            
                    <?php
                        $listComProjet = Notification::getComProjet($idProjet);
                        //var_dump($listComProjet);
                        if (!is_null($listComProjet)) {
                            foreach ($listComProjet as $value) {

                                $objCom = new Notification($value);
                                $nom = $objCom->getNom();
                                $titre = $objCom->getTitre();
                                $libelle = $objCom->getLibelle();
                                $date = $objCom->getDate();
                                

                    ?>
                    <li class="box" style="display:list-item;">
                        <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
                        <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $objCom->getUti(); ?>'});"><?php echo $nom; ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a écrit : <br />
                        <?php echo $libelle; ?>
                    </li>
            
                </ol>
            
            

                <?php
                        }
                     }
                ?>

            <div id="flash" align="left"></div>

            <div style="margin-left:100px">
                
                <form action="notification.php" method="post">
                    
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
                <span>Sur cette page, vous pouvez consulter les informations concernant le projet : "<?php echo $objProjet->getLibelle(); ?>".</span>
            </div>
        </div>
    
    </div>
    
</div>