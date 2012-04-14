<?php
include_once("classes/classSite.php");
SITE::init();
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


    // document.location.href='#projetLst?idProjet='+idProjet+'';

    // }
</script>

<div id="templatemo_content">
    <div class="content_col_w420 fl">
        <div class="header_02">Dernier(s) projet(s)</div>
        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <p>
                    <?php
                    $i = 0;
                    $lstProjetIds = SITE::getUtilisateur()->getLstNLastProjetIds(5);
                    foreach ($lstProjetIds as $idProjet) {
                        $objProjet = new PROJET($idProjet);
                        echo "<a href=\"#projetLst?idProjet=" . $objProjet->getId() . "\">" .
                        $objProjet->getLibelle() . "</a><br />";
                        $i++;
                    }
                    ?>
                </p>
            </div>
        </div>
        <?php
        if ($i != 0) {
            ?>
            <div class="section_w140 fr">
                <div class="rc_btn_02"><a href="#projetAdd">Créer un projet</a></div>
                <div class="cleaner"></div>            
            </div>
            <?php
        } else {
            echo "Aucun projet en cours";

            if (SITE::getUtilisateur()->getStatut() == "client") {
                ?>

                <div class="section_w140 fr">
                    <div class="rc_btn_02"><a href="#projetAdd">Créer votre projet</a></div>
                    <div class="cleaner"></div>            
                </div>
            <?php } else { ?>
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
        if (SITE::getUtilisateur()->getStatut() == "client") {
            ?>
            <div class="header_02">Liste de prestataire</div>
            <div class="testimonial_box_wrapper">
                <div class="testimonial_box">
                    <p>
                        <?php
                        $lstUtilisateurIds = PRESTATAIRE::getLstNIds(10);
                        foreach ($lstUtilisateurIds as $idUtilisateur) {
                            $objUtilisateur = new UTILISATEUR($idUtilisateur);
                            echo "<a href=\"#utilisateurLst?idUtilisateur=" . $objUtilisateur->getId() . "\">" .
                            $objUtilisateur . "</a><br />";
                        }
                        ?>
                    </p>
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
                            $lstProjetIds = PROJET::getLstNIds(10);
                            foreach ($lstProjetIds as $idProjet) {
                                $objProjet = new PROJET($idProjet);
                                ?>
                                <tr id="ligneProjet<?php echo $objProjet->getId(); ?>" class="gradeX">
                                    <td id="libelle">
                                        <input type="hidden" name="libelle" value="<?php echo $objProjet->getLibelle(); ?>"> 
                                        <?php echo $objProjet->getLibelle(); ?>
                                    </td>

                                    <td id="categorie">
                                        <input type="hidden" name="categorie" value="<?php echo '???'; ?>">
                                        <?php
                                        $lstCategorieIds = $objProjet->getCategorieIds();
                                        foreach ($lstCategorieIds as $idCategorie) {
                                            $objCategorie = new CATEGORIE($idCategorie);
                                            echo ('- ');
                                            echo $objCategorie->getLibelle();
                                            echo ('</br>');
                                        }
                                        ?>											
                                    </td>

                                    <td id="budget">
                                        <input type="hidden" name="budget" value="<?php echo $objProjet->getBudget(); ?>">
                                        <?php echo $objProjet->getBudget(); ?>											
                                    </td>

                                    <td id="competence">
                                        <input type="hidden" name="competence" value="<?php echo '???'; ?>">
                                        <?php
                                        $lstCompetenceIds = $objProjet->getCompetenceIds();
                                        foreach ($lstCompetenceIds as $idCompetence) {
                                            $objCompetence = new COMPETENCE($idCompetence);
                                            echo ('- ');
                                            echo $objCompetence->getLibelle();
                                            echo ('</br>');
                                        }
                                        ?>									
                                    </td>

                                    <td id="dateCreation">
                                        <input type="hidden" name="dateCreation" value="<?php echo $objProjet->getDateCreation(); ?>">
                                        <?php echo $objProjet->getDateCreation(); ?>											
                                    </td>
                                </tr>
                                <?php
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
        <div class="testimonial_box_wrapper">
            <div class="testimonial_box">
                <div class="header_03"><a href="#"><div id="progressbar"></div></a></div>

            </div>
        </div>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>
    </div>  
</div><!-- end of content -->