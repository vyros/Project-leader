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

        <input type="button" onclick="getFormulary('pa1');" value="Valider" />
        
    </form>
</div><!-- end of a section -->