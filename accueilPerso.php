<?php
include_once("classes/classUtilisateur.php");

session_start();
$statut = $_SESSION['monUtilisateur']->getStatut();

include_once("classes/classProjet.php");
include_once("classes/classCorrespondre.php");
include_once("classes/classCategorie.php");
include_once("classes/classParticiper.php");
include_once("classes/classDemander.php");
include_once("classes/classCompetence.php");
?>

<script type="text/javascript">
    var monTable;
</script>

<script>
    $(document).ready(function() {
        /* Add a click handler to the rows - this could be used as a callback */
        $("#example tbody").click(function(event) {
            $(monTable.fnSettings().aoData).each(function () {
                $(this.nTr).removeClass('row_selected');
            });
            $(event.target.parentNode).addClass('row_selected');
        });
     
        /* Add a click handler for the delete row */
        $('#delete').click( function() {
            var anSelected = fnGetSelected( monTable );
            monTable.fnDeleteRow( anSelected[0] );
        } );
     
        /* Init the table */
        monTable = $('#example').dataTable( );
    } );

    function fnGetSelected( oTableLocal ) {
        var aReturn = new Array();
        var aTrs = oTableLocal.fnGetNodes();
     
        for ( var i=0 ; i<aTrs.length ; i++ )
        {
            if ( $(aTrs[i]).hasClass('row_selected') )
            {
                aReturn.push( aTrs[i] );
            }
        }
        return aReturn;
    }

    // function pageMesProjet(idProjet)
    // {


    // document.location.href='#mesProjets.php?idProjet='+idProjet+'';

    // }
</script>

<div id="templatemo_content">
    <div class="content_col_w420 fl">
        <div class="header_02">Vos projets</div>
<?php
    //tester si dans table participer il existe l'idUti
    // Si oui, prendre l'idProjet et afficher l'intitulé et l'avancement du projet
    // Si plusieurs projets, afficher les plus récents
    // + lien vers page mesProjets

    //Si non, afficher Pas de projet en cours
    // + lien vers page creaProjet (dans les 2 cas)

    $idUtilisateur = $_SESSION['monUtilisateur']->getId();
    $objParticiper = new PARTICIPER($idUtilisateur);
    $idProjet = $objParticiper->getIdProjet($idUtilisateur);

    if($idProjet != "") {
        // récuperer l'intitulé du projet et afficher l'avancement
        // + lien vers mesProjets

        $objProjet = new PROJET($idProjet);
        $lblProjet = $objProjet->getLibelle();
?>
        <a href="#mesProjets.php?idProjet=<? echo $idProjet;?>"><?php echo $lblProjet; ?></a>

        <div class="section_w140 fr">
            <div class="rc_btn_02"><a href="#creaProjet">Créer autre projet</a></div>
            <div class="cleaner"></div>            
        </div>
<?php
    } else {
        echo "Aucun projet en cours";

        if($statut == "client") {
?>

        <div class="section_w140 fr">
            <div class="rc_btn_02"><a href="#creaProjet">Créer votre projet</a></div>
            <div class="cleaner"></div>            
        </div>
<?php   } else { ?>
        <div class="section_w140 fr">
            <div class="rc_btn_02"><a href="#recherche">Rechercher un projet</a></div>
            <div class="cleaner"></div>            
        </div>
<?php
        }
    }
?>

        <div class="margin_bottom_10 border_bottom"></div>
        <div class="margin_bottom_30"></div>

<?php
    if ($statut == "client") {
?>
        <div class="header_02">Liste de prestataire</div>
<?php
    // tester si dans table participer il existe l'idUti
    // Si oui, afficher une liste des prestataires en rapport avec les compétences recherchées pour les projets existants et passés de l'uti
    // Sinon, listes des tops prestataires 
?>
        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <div class="header_03"><a href="#">Aliquam pretium porta odio</a></div>
                <p>Donec iaculis felis id neque. Morbi nunc. Praesent varius egestas velit.</p>
            </div>
        </div>

        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <div class="header_03"><a href="#">Sed pellentesque placerat augue</a></div>
                <p>Sed ultrices. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur velit tellus, placerat et, dapibus varius, aliquet quis, purus.</p>
            </div>
        </div>
        
<?php
    } else {
?>
        <div class="header_02">Liste de projet</div>
<?php
    // tester si dans les tables  posseder (relier à competence et cv) il existe l'idUti
    // Si oui, afficher une liste des projets en rapport avec les compétences et/ou spécialité de l'uti
    // Sinon, listes des 10 derniers projets postés
?>
        <div id="demo">
            <table id="listeProjet">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>
                            <th class="sorting_asc">Intitulé</th>
                            <th class="sorting_asc">Catégorie</th>
                            <th class="sorting_asc">Budget</th>
                            <th class="sorting_asc">Compétence requise</th>
                            <th class="sorting_asc">Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
        $lastNProjets = PROJET::lastProjet(10);

        //init
        $i = 0;

        // boucle tant qu'une ligne existe dans le resultat de la requête
        while ($row = mysql_fetch_array($lastNProjets)) {

            $idProjet[$i] = "$row[prj_id]";
            $lblProjet[$i] = "$row[prj_libelle]";
            
            $objCorrespondre = new CORRESPONDRE($idProjet[$i]);
            $idCategorie = $objCorrespondre->getIdCategorie();
            
            $objCategorie = new CATEGORIE($idCategorie);
            $lblCategorie = $objCategorie->getLibelle();
            $budget[$i] = "$row[prj_budget]";

            $objDemander = new DEMANDER($idProjet[$i]);
            $resAllCompetences = $objDemander->getAll();

            $j = 0;
            while ($row = mysql_fetch_array($resAllCompetences)) {
                $idCompetence[$j] = "$row[cpt_id]";
                $objCompetence = new COMPETENCE($idCompetence[$j]);
                $lstCompetence[] = $objCompetence->getLibelle();
            }

            // print_r($chaineCompetence);
            $dateCreation[$i] = "$row[prj_date]";
?>
                        <tr id="ligneProjet<?php echo $idProjet[$i]; ?>" class="gradeX">
                            <td id="libelle">
                                <input type="hidden" name="libelle" value="<?php echo $lblProjet[$i]; ?>"> 
                                <?php echo $lblProjet[$i]; ?>
                            </td>

                            <td id="categorie">
                                <input type="hidden" name="categorie" value="<?php echo $lblCategorie; ?>">
                                <?php echo $lblCategorie; ?>											
                            </td>

                            <td id="budget">
                                <input type="hidden" name="budget" value="<?php echo $budget[$i]; ?>">
                                <?php echo $budget[$i]; ?>											
                            </td>

                            <td id="competence">
                                <input type="hidden" name="competence" value="<?php echo $lstCompetence; ?>">
<?php
            $j = 0;
            while ($lstCompetence[$j] != "") {
                echo ('-');
                echo $lstCompetence[$j];
                echo ('</br>');
                $j++; 
            }
?>									
                            </td>

                            <td id="dateCreation">
                                <input type="hidden" name="dateCreation" value="<?php echo $dateCreation[$i]; ?>">
                                <?php echo $dateCreation[$i]; ?>											
                            </td>
                        </tr>
<?php       
            $i++;
        }
?>
                    </tbody>
                </table>
            </table>
        </div>

<?php } ?>
        <div class="margin_bottom_20"></div>
    </div><!-- end of a section -->

    <div class="content_col_w420 fr">
        <div class="header_02">Votre compte</div>
<?php
// barre progression du compte (+ liens vers page monProfil)
?>
        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <div class="header_03"><a href="#">(Barre progression)</a></div>

            </div>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>
    </div>  
</div><!-- end of content -->