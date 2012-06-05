<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form id="rp1">

    <input type="hidden" name="controller" value="recherche"/>
    <input type="hidden" name="action" value="liste"/>
    
    <div>
        <div style="color:red">
            Développement Web / Software
        </div>
        <div>
            <?php
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFils)) {
                foreach ($lstCategorieFils as &$value) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech[]" value=<?php echo $value[cat_id] ?> /><?php echo $value[cat_libelle] ?></div>
                <?php
                }
            }
            ?>
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Mobile
        </div>
        <div>
            <?php
            $array = Categorie::getListCategoriesFilsByCode(2);
            $i = 0;
            /* Sur 4 colonnes */
            foreach ($array as &$value) {
                if ($i == 4) {
                    ?></br><?php
            $i = 0;
        }
        $i++;
        ?>                  
                <div style="width:200px;float:left"><input type="checkbox" name="rech[]" value=<?php echo $value[cat_id] ?> /><?php echo $value[cat_libelle] ?></div>
<?php } ?>             
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Base de données
        </div>
        <div>
            <?php
            $array = Categorie::getListCategoriesFilsByCode(3);
            $i = 0;
            /* Sur 4 colonnes */
            foreach ($array as &$value) {
                if ($i == 4) {
                    ?></br><?php
            $i = 0;
        }
        $i++;
        ?>                  
                <div style="width:200px;float:left"><input type="checkbox" name="rech[]" value=<?php echo $value[cat_id] ?> /><?php echo $value[cat_libelle] ?></div>
<?php } ?>            
            </br>
        </div>
    </div>
    </br>
    <div>
        </br>
        <div style="color:red">
            Design
        </div>
        <div>
            <?php
            $array = Categorie::getListCategoriesFilsByCode(4);
            $i = 0;
            /* Sur 4 colonnes */
            foreach ($array as &$value) {
                if ($i == 4) {
                    ?></br><?php
            $i = 0;
        }
        $i++;
        ?>                  
                <div style="width:200px;float:left"><input type="checkbox" name="rech[]" value=<?php echo $value[cat_id] ?> /><?php echo $value[cat_libelle] ?></div>
<?php } ?>         
            </br>
        </div>
    </div>
    </br>
    </br>
    <div>
        <input type="button" onclick="getFormulaire('rp1');" value="Valider" />
<!--        <input type="submit" value="Recherche" />-->
    </div>
</form>
</br>
<table>

</table>