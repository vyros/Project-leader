<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <form id="pa1">

        <input type="hidden" name="controller" value="projet"/>
        <input type="hidden" name="action" value="ajouter"/>
        <input type="hidden" name="etat" value="1"/>

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
                        if (!is_null($lstCategorieIds)) {
                            foreach ($lstCategorieIds as $value) {
                                $objCategorie = new Categorie($value);
                                echo "<option value=\"" . $objCategorie->getId() . "\">" . $objCategorie->getLibelle() . "</option>";
                            }
                        }
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
                <td><input type="button" onclick="getFormulaire('pa1');" value="Valider" /></td>
            </tr>
        </table>
    </form>
</div><!-- end of a section -->