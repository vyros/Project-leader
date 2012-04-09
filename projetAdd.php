<?php
include_once("classes/classSite.php");
SITE::init();
?>
<div id="templatemo_content_wrapper">
    <div id="templatemo_content">
        <div class="content_col_w420 fl">

            <form method="POST" action="checkout.php">

                <input type="hidden" name="action" value="projetAdd"/>
                <div class="header_02">Créer votre projet<br/></div>

                <table align="center">
                    <tr>
                        <td><h6>Intitulé :&nbsp </h6></td>
                        <td><input type='text' name='libelle' size='25' maxlength='100' value=""/><br><br></td>
                    </tr>

                    <tr>
                        <td><h6>Catégorie :&nbsp </h6></td>
                        <td><select name="categorie" id="categorie" ><option></option>
<?php
                                $resAllCategorie = CATEGORIE::getAll();
                                $resAllCompetence = COMPETENCE::getAll();

                                while ($row = mysql_fetch_array($resAllCategorie)) {
                                    echo "<option>$row[cat_libelle]</option>";
                                }
                                mysql_free_result($resAllCategorie);
?>	
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><h6>Compétences demandées :&nbsp </h6></td>
                        <td>
                            <div>
                                <input type="text" id="demo-input-local" name="blah" />
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#demo-input-local").tokenInput([
<?php
        while ($row = mysql_fetch_array($resAllCompetence)) {
            $idCompetence[$i] = "$row[cpt_id]";
            $libCompetence[$i] = "$row[cpt_libelle]";
?>
            {
            id: <?php echo str_replace('"', '', json_encode($idCompetence[$i])); ?>, 
            name: "<?php echo str_replace('"', '', json_encode($libCompetence[$i])); ?>"
            },
<?php
        } 
        mysql_free_result($resAllCompetence);
?>
                                        ]);
                                    });
                                </script>
                            </div>
                            <br><br></td>
                    </tr>

                    <tr>
                        <td><h6>Description :&nbsp </h6></td>
                        <td><textarea style="font-weight:700; color:blue;" name="description"></textarea></td>
                    </tr>

                    <tr>
                        <td><h6>Budget :&nbsp </h6></td>
                        <td><input type='text' name='budget' size='25' maxlength='10' value=""/><br><br></td>
                    </tr>

                    <tr>
                        <td><h6>Echeance (en jours) :&nbsp </h6></td>
                        <td><input type='text' name='echeance' size='25' maxlength='10' value=""/><br><br></td>
                    </tr>
                    <br><br>

                    <tr>
                        <td><input type="submit" value="Valider"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>