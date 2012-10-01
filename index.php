<?php
/*
 * Index...
 * 
 * @author jimmy
 */
include_once("models/classSite.php");
Site::init();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Project-leader</title>
        <meta name="keywords"    content="web design template, free css html layout" />
        <meta name="description" content="web design template, free css html layout provided by templatemo.com for any website purpose" />

        <link rel="stylesheet" type="text/css" href="css/styleSite.css" />
        <link rel="stylesheet" type="text/css" href="css/templatemo_style.css" />
        <link rel="stylesheet" type="text/css" href="css/demo_page.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/demo_table.css" media="all" />
        <link rel="stylesheet" type="text/css" href="css/token-input/token-input.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/css3menu1/style.css" /><style>._css3m{display:none}</style>

        <script language="javascript" type="text/javascript" src="js/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery-ui.datepicker-fr.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.history.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.dataTables.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.tokeninput.js"></script>
        <script language="javascript" type="text/javascript" src="js/oXHR.js"></script>

        <script language="javascript" type="text/javascript">
            var varAccueilPorteur;
            var varAccueilPrestataire;
            
            var varFichePorteur;
            var varFichePrestataire;
            
            var varMessagerieLu;
            var varMessagerieNonLu;

            var varTable;

            var i = 2;
            var contenu = "";
        </script>
    </head>
    <body>
        <div id="ajax-links">
            <div id="templatemo_header_wrapper">
                <!-- Free Web Templates from TemplateMo.com -->
                <div id="templatemo_header">
                    <div id="logo" onclick="getView({'controller' : 'utilisateur', 'view' : 'accueil'});" style="cursor:pointer"></div>
                    <div id="entete">
                        <?php
                        /**
                         * Ici ajax charge la partie dynamique de l'entête.
                         */
                        ?>
                    </div>
                    <div class="cleaner"></div>
                </div> <!-- end of header -->
            </div> <!-- end of header wrapper -->

            <div id="templatemo_content_wrapper">
                <div id="templatemo_content">
                    <div id="content">
                        <?php
                        /**
                         * Ici ajax charge la partie dynamique du corps du site.
                         */
                        ?>
                    </div>
                </div>  <!-- end of content -->
            </div>
        </div>

        <div id="templatemo_footer_wrapper">
            <div id="templatemo_footer">
                <div style="position:relative;width:360px;float:left">
                    <div class="header_01">Partagez nous</div>
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                        <a class="addthis_button_preferred_1"></a>
                        <a class="addthis_button_preferred_2"></a>
                        <a class="addthis_button_preferred_3"></a>
                        <a class="addthis_button_preferred_4"></a>
                        <a class="addthis_button_compact"></a>
                        <a class="addthis_counter addthis_bubble_style"></a>
                    </div>
                    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5059d51a326357a0"></script>
                    <!-- AddThis Button END -->
                    <div class="margin_bottom_20"></div>
                    <div id="nbConnecte" style="font-size:20px;font-weight:bold"></div>
                    <div style="font-size:17px;font-weight:bold">utilisateurs connectés</div></br>
                    <div id="nbUtilisateurs" style="font-size:20px;font-weight:bold"></div>
                    <div style="font-size:17px;font-weight:bold">utilisateurs inscrits</div></br>
                    <div id="nbProjets" style="font-size:20px;font-weight:bold"></div>
                    <div style="font-size:17px;font-weight:bold">projets</div>

                    <div class="cleaner"></div>
                </div>

                <div style="position:relative;width:560px;float:right">
                    <div class="section_w220 fl">
                        <div class="header_01">Praesent varius</div>
                        <ul class="normal_list">
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
                            <li>Email: <a href="#">info@templatemo.com</a></li>
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
    <div id="fb-root"></div>
    <script>
        //fonction pour facebook
        //        (function(d, s, id) {
        //            var js, fjs = d.getElementsByTagName(s)[0];
        //            if (d.getElementById(id)) return;
        //            js = d.createElement(s); js.id = id;
        //            js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
        //            fjs.parentNode.insertBefore(js, fjs);
        //        }(document, 'script', 'facebook-jssdk'));
            
        //Reactualisation du nb de connectés   
        function ReactConnectes(){

            $.ajax({
                type: "POST",
                url: "NbConnectes.php",
                cache: false,
                success: function(res){
                    var str = res.split("/");
                    $("#nbConnecte").html(str[0]);
                    $("#nbUtilisateurs").html(str[1]);
                    $("#nbProjets").html(str[2]);
                }
            });   
        }
        //setInterval(function(){ReactConnectes()},3000);
    </script>
</html>
<?php
if (isset($_GET['activer']) && isset($_GET['id']) && isset($_GET['token'])) {
    ?>
    <script language="javascript" type="text/javascript">
        getActivation({'id' : '<?php echo $_GET['id']; ?>', 'token' : '<?php echo $_GET['token']; ?>'});
    </script>
    <?php
}
?>
<script>
    $(document).ready(function(){
        ReactConnectes();
        getView({'controller' : 'utilisateur', 'view' : 'accueil'});
    });
</script>