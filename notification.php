<?php

header("Content-Type: text/plain");
//faudra mexpliquer pourquoi quand on inclue d class dan la fct init de la class site il percute rien... A VERIFIER JIM
//include_once("models/classEffectuer.php");
include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "addCom ") {

    $idUti = $_POST['idUti'];
    $nom = $_POST['nomUti'];
    $idPjt = $_POST['idPjt'];
    
    $tabClientProjet = PARTICIPER::voirParticipationCli($idPjt);
    $i = 0;
    while ($row = mysql_fetch_array($tabClientProjet)) {
        $idClientProjet[$i] = "$row[uti_id]";
    }
    $idUti2 = $idClientProjet[0];
    
    $titre=$_POST['titre'];
    $libelle = $_POST['comment'];
    
//    $idMaxNot = Notification::getMaxNot();
//    $idMaxNot = $idMaxNot + 1;
//    
//    $objEffect = Effectuer::addEvent($idUti, $idMaxNot);
    
    $date = date("Y/m/d"); 
    $objCom = Notification::addCom($titre, $nom, $libelle, $idUti, $idUti2, $idPjt);

?>
<li class="box">
    <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
    <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $idUti; ?>'});"><?php echo $nom; ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a Ã©crit : <br />
    <?php echo $libelle; ?>
</li>
            
<?php
} else if (!is_null($action) && $action == "newMsg ") {
    
    echo "test";
//    $idUti2 = explode(',', $_POST["blah"]);
    $idUti = Site::getUtilisateur()->getLogin();
    $idUti2 = (isset($_POST["blah"])) ? $_POST["blah"] : null;
}


/**
 * Vues 
 */
if (!is_null($view)) {
    ?>
    <script language="javascript" type="text/javascript" src="js/tabler.js"></script>
    <script language="javascript" type="text/javascript" src="js/shadowbox/shadowbox.js"></script>
    <link rel="stylesheet" type="text/css" href="js/shadowbox/shadowbox.css">
    <script language="javascript" type="text/javascript" src="js/jquery.tokeninput.js"></script>
    <?php
}

if (!is_null($view) && $view == "messagerie") {
   
    if (Site::getUtilisateur() instanceof Utilisateur) {
        
        $idUtilisateur = Site::getUtilisateur()->getId();

        $lstMsgNonLu = Notification::msgNonLu($idUtilisateur);
        $lstMsgLu = Notification::msgLu($idUtilisateur);
        
        $nbreNonLu = Notification::getNbreNonLu($idUtilisateur);
        $nbreLu = Notification::getNbreLu($idUtilisateur);
        
        $listToutLesUtis = Utilisateur::getAllNomUti();
        
        include 'views/utilisateurMessagerie.php';
    }
    
}else if (!is_null($view) && $view == "message") {
   
    $idMsg = (isset($_POST["id"])) ? $_POST["id"] : null;
    
    $objNotification = new Notification($idMsg);
    
//    $titre = $objNotification->getTitre();
//    $nom = $objNotification->getNom();
//    $libelle = $objNotification->getLibelle();
//    $date = $objNotification->getDate();
    
    $idUtilisateurCourant = Site::getUtilisateur()->getId();
    $idUtilisateur1 = $objNotification->getUti();
    $idUtilisateur2 = $objNotification->getUti2();

    $listMsgConvers = Notification::getConvers($idUtilisateurCourant, $idUtilisateur1, $idUtilisateur2);
    
//    var_dump($listMsgConvers);
    
    include 'views/utilisateurMessage.php';
    
}
?>
<script type="text/javascript">// <![CDATA[
Shadowbox.init({enableKeys:false,displayNav:false});
  Shadowbox.init({
language: "fr",
players: ["html"]
}); ;
// ]]></script>

 <script type="text/javascript">// <![CDATA[
function initializeXhrObject()
{
	var xhr_object = null; //je declare une variable et je la mÃ© a null
	
	if(window.XMLHttpRequest) //un test pour connaitre lorigine de son navigateur mais on senfou c pour tester si son navigateur date de matusalem 
		xhr_object = new XMLHttpRequest(); //pour firefox / chrome etc... je declare mon objet grace Ã  XMLHttpRequest
	else if(window.ActiveXObject) 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); //pour ie la meme chose
	else { 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		return; } 
	 
	return xhr_object;// enfin je le retourne
}

function openShadowbox(url)
{

//je te met des petit numero pour comprendre lordre dexecution exemple *1*//
	var content;
	var xhrObj=initializeXhrObject();//jinitialise mon objet
	xhrObj.open("POST", url, true);//*1*// jouvre une requete ajax de type post (un pe comme <form method="post"></form>
	xhrObj.onreadystatechange = function(){
											if(xhrObj.readyState != 4) // la requete ajax se fait en 4 etape la 4eme Ã©tant "jai fini"
												return;
											content=xhrObj.responseText;//*4*//quand jai fini je stock le contenu de la page qui porte ladresse du parametre "url"
											Shadowbox.open({ //ensuite jouvre la shadowbox de maniere classique
        content:    content,//dans le content je met le contenu de ma variable
        player:     "html",//je lui dis quil va recevoir du html
		enableKeys : false, //je desactive les touches qui fon des actions bizar avec la shadowbox (genre q pour quitter)
        height:     320,//la hauteur 
        width:      900//la largeur
    });

											}
	xhrObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");//*2*//le header
	xhrObj.send();	//*3*//jenvoi ma requete post
	
}

function fenetreNouveauMsg(idUtilisateur) 
{ 

        openShadowbox('views/nouveauMessage.php?idUti='+idUtilisateur);

}
</script>
<script type="text/javascript">
$(function() {
    
    
$(".envoyerMsg").click(function() {

var idUti = $("#idUti").val();
var idUti2 = jQuery('input[name=blah]').val();
var nomUti = $("#nomUti").val();
var titre = $("#titre").val();
var comment = $("#comment").val();
var action = $("#action").val();

var dataString = 'action=' + action + ' &titre=' + titre + ' &comment=' + comment + '&idUti=' + idUti + '&idUti2=' + idUti2 + '&nomUti=' + nomUti;
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


});


</script>