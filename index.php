<?php
include_once("Classes/classUtilisateur.php");
session_start();
// print_r($_SESSION['monUtilisateur']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>web design template, free css html layout</title>
<meta name="keywords" content="web design template, free css html layout" />
<meta name="description" content="web design template, free css html layout provided by templatemo.com for any website purpose" />
<link href="templatemo_style.css" rel="stylesheet" type="text/css" />

	<!-- Start css3menu.com HEAD section -->
	<link rel="stylesheet" href="testmenu.css3prj_files/css3menu1/style.css" type="text/css" /><style>._css3m{display:none}</style>
	<!-- End css3menu.com HEAD section -->
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.history.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>



  <link rel="stylesheet" href="css/demo_page.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/demo_table.css" type="text/css" media="all">
  <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
  
  
    <script type="text/javascript" src="src/jquery.tokeninput.js"></script>

    <link rel="stylesheet" href="styles/token-input.css" type="text/css" />
	
  <script type="text/javascript">
	var monTable;
  </script>
	


<script>
(function($){
    var origContent = "";

    function loadContent(hash) {
        if(hash != "") {
            if(origContent == "") {
                origContent = $('#content').html();
            }
            $('#content').load(hash +"",
                               function(){ prettyPrint(); });
        } else if(origContent != "") {
            $('#content').html(origContent);
        }
    }

    $(document).ready(function() {
            $.history.init(loadContent);
            $('#navigation a').not('.external-link').click(function(e) {
                    var url = $(this).attr('href');
                    url = url.replace(/^.*#/, '');
                    $.history.load(url);
                    return false;
                });
        });
})(jQuery);



</script>

</head>
<body>
<div id="ajax-links">

<div id="templatemo_header_wrapper">
<!-- Free Web Templates from TemplateMo.com -->
<?php 
if (isset($_SESSION['ouvert'])) 
{
//barre perso : nom user + icone profil + icone se deconnecter 
?>
<div style="position: relative; left: 862px; top: 10px;"> 
Bonjour <? echo $_SESSION['monUtilisateur']->getLogin(); ?> ! 
<a href="#monProfil.php" class="button style2"><span>Mon profil</span></a> /
<a href="#deconnexion.php" class="button style2"><span>Se déconnecter</span></a>
			

</div>
<?php
}else
{
?>
	<form method="POST" action="verif.php">
	<input type="hidden" name="action" value="VerificationCompte"/>
		<div style="position: relative; left: 862px; top: 10px;"> 
			Login :<input type='text' name='log' size='18' maxlength='100' value="" />
			Password :<input type='password' name='mdp' size='18' maxlength='100' value="" />
			<input type="submit" value="Valider" />
		</div>
	</form>
<?php
}
?>	
    <div id="templatemo_header">
    	<div id="logo"></div>
		
      
		<?php
			if (isset($_SESSION['ouvert'])) 
			{
				$statut = $_SESSION['monUtilisateur']->getStatut();

				if($statut == "client")
				{	
		?>
					<!-- Start css3menu.com BODY section -->
					<ul id="css3menu1" class="topmenu">
						<li class="topmenu"><a href="#accueilPerso.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
						<li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
						<ul>
							<li class="subfirst"><a href="#creaProjet.php">Créer votre projet</a></li>
							<li><a href="#mesProjets">Mes projets</a></li>
							<li class="sublast"><a href="#projetsFinis.php">Projets finis</a></li>
						</ul></li>
						<li class="topmenu"><a href="#recherche.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
					</ul>
		<?
				}
				else if ($statut == "prestataire")
				{
		?>			
					<!-- Start css3menu.com BODY section -->
					<ul id="css3menu1" class="topmenu">
						<li class="topmenu"><a href="#accueilPerso.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
						<li class="topmenu"><a href="#" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Espace Projet"/>Espace Projet</span></a>
						<ul>
							<li class="subfirst"><a href="#mesProjets.php">Mes projets</a></li>
							<li class="sublast"><a href="#projetsFinis.php">Projets finis</a></li>
						</ul></li>
						<li class="topmenu"><a href="#recherche.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Espace recherche"/>Espace recherche</a></li>
					</ul>
		<?		
				}
			}else
			{
		?>
			<ul id="css3menu1" class="topmenu">
				<li class="topmenu"><a href="#accueil.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/256base-home-over.png" alt="Accueil"/>Accueil</a></li>
				<li class="topmenu"><a href="#pres.php" style="height:24px;line-height:24px;"><span><img src="testmenu.css3prj_files/css3menu1/256base-open-over.png" alt="Présentation"/>Présentation</span></a></li>
				<li class="topmenu"><a href="#mesProjets.php" style="height:24px;line-height:24px;"><img src="testmenu.css3prj_files/css3menu1/smile.png" alt="Projet"/>Projet</a></li>
			</ul>
		<?
			}
		?>		
        
		
        
        <div class="cleaner"></div>
    </div> <!-- end of header -->
<div >

			</div>
</div> <!-- end of header wrapper -->


<div id="templatemo_content_wrapper">

    <div id="templatemo_content">
		<div id="content">
		
		</div>
    </div>  
    
</div>  <!-- end of content -->

</div> 
      
	  
	  
	  
	  
	  
	  
	  
	  
	  
<div id="templatemo_footer_wrapper">
	
    <div id="templatemo_footer">
    
        <div class="content_col_w420 fl">
            <div class="header_01">Aliquam tristique lacus</div>
          <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc quis sem nec tellus blandit tincidunt. Duis vitae velit sed dui malesuada dignissim. Donec mollis aliquet ligula. Maecenas adipiscing elementum ipsum.est. Suspendisse a nibh tristique justo rhoncus volutpat. Suspendisse vitae neque eget ante tristique vestibulum. Pellentesque dolor nulla, congue vitae, fringilla in, varius.</p>
            
            <div class="margin_bottom_20"></div>
            Copyright © 2024 <a href="#">Your Company Name</a> | Designed by <a href="http://www.templatemo.com" target="_parent">Free CSS Templates</a>
            
            <div class="cleaner"></div>
        </div>
        
        <div class="content_col_w420 fr">
            <div class="section_w220 fl">
                <div class="header_01">Praesent varius</div>
                <ul class="normal_list">
                    <li><a href="#">Nascetur ridiculus mus</a></li>
                    <li><a href="#">Curabitur quis velit quis tortor</a></li> 
                    <li><a href="#">Vivamus a velit</a></li>
                    <li><a href="#">Cum sociis natoque penatibus</a></li>
                    <li><a href="#">Magnis dis parturient montes</a></li>
                </ul>
            </div>
        
            <div class="section_w220 fr text_rl">
                <div class="header_01">Contact</div>
                <ul class="contact">
                    <li>Tel: 010-100-1001</li>
                    <li>Fax: 020-200-2002</li>
                    <li>Email: <a href="#">info [_at_] templatemo.com</a></li>
                </ul>
                <div class="margin_bottom_10"></div>
                <a href="http://validator.w3.org/check?uri=referer"><img style="border:0;width:88px;height:31px" src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" width="88" height="31" vspace="8" border="0" /></a>
                <a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px"  src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" vspace="8" border="0" /></a>
            </div>
            
        </div>
        <div class="cleaner"></div>
    </div><!-- end of footer wrapper -->
</div> 
<!-- Free CSS Templates @ www.TemplateMo.com -->
</body>
</html>