<?php

header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();

$action = (isset($_POST["action"])) ? $_POST["action"] : null;
$view = (isset($_POST["view"])) ? $_POST["view"] : null;

/**
 * Actions 
 */
if (!is_null($action) && $action == "addCom ") { //commentaire

    if ($idPjt = Site::isValidId($_POST['idPjt'])) {
        $objProjet = new Projet($idPjt);
        $tabClientProjet = $objProjet->getPorteurIds();
    }
        
    $idUti = $_POST['idUti'];
    $nom = $_POST['nomUti'];
    
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
    <span class="com_name"><a onclick="getView({'controller' : 'utilisateur', 'view' : 'profil', 'id' : '<?php echo $idUti; ?>'});"><?php echo $nom; ?></a></span>, le <span class="com_date"> <?php echo $date; ?></span> a écrit : <br />
    <?php echo $libelle; ?>
</li>
            
<?php
} else if (!is_null($action) && $action == "message ") {
    
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
    <script type="text/javascript" src="js/jquery.fancybox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
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
 
 <script type="text/javascript"> 
$(function() {
	 
 $(".fancybox").fancybox();

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});
 
		 

			/*
			 *  Open manually
			 */

			 

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'views/nouveauMessage.php',
					type : 'iframe',
					padding : 5
				});
			});

			 
		});
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