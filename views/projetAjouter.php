<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <form id="pa1">

            <input type="hidden" name="action" value="ajouter"/>
            <input type="hidden" name="controller" value="projet"/>
            <input type="hidden" name="etat" value="1"/>

            <div class="header_wrapper">
                <img src="images/icone_crea.png"/> 
                <div class="header_02">Créer votre projet</div>
            </div>

            <label for="libelle">Intitulé : </label><br />
            <input id="libelle" type='text' name='libelle' size='25' maxlength='100' value=""/><br /><br />

            <label for="categorie">Catégorie : </label><br />
            <select name="categorie" id="categorie">
                <option selected>-- Selectionnez une catégorie --</option>
                <?php
                if (!is_null($lstCategorieIds)) {
                    foreach ($lstCategorieIds as $value) {
                        $objCategorie = new Categorie($value);
                        echo "<option value=\"" . $objCategorie->getId() . "\">" . $objCategorie->getLibelle() . "</option>";
                    }
                }
                ?>
            </select><br /><br />

            <label for="demo-input-local">Compétence(s) demandée(s) : </label><br />
            <input type="text" id="demo-input-local" name="blah" /><br /><br />
            
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

            <label for="description">Description : </label><br />
            <textarea id="description" style="font-weight:700; color:blue;" name="description"></textarea><br /><br />

            <label for="budget">Budget : </label><br />
            <input id="budget" type='text' name='budget' size='25' maxlength='10' value="" /><br /><br />

            <label for="echeance">Echeance (en jours) : </label><br />
            <input id="echeance" type='text' name='echeance' size='25' maxlength='10' value="" /><br /><br />

            <label for="doc">Document attaché : </label><br />
            <input id="doc" type='file' name='echeance' size='25' maxlength='10' value="" /><br /><br />

            <input type="button" onclick="getFormulary('pa1');" value="Valider" />

        </form>

        <div class="margin_bottom_20 border_bottom"></div>
        <div class="margin_bottom_30"></div>

    </div>

</div><!-- end of a section -->
<div class="content_col_w420 fr">

    <div class="sub_content_col">
        <img style="width:350px; position: relative; left:60px; top:70px;" class="" src="images/logo_seul.png"/>
    
        <div class="conteneur_bulleAcc">
            <div class="messageBulle">
                <span>Sur cette page, vous avez la possibilité de créer votre projet. Les caratéristiques du projet pourront être modifiés si besoin directement sur la fiche.</span>
            </div>
        </div>
    
    </div>
    
</div>