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
            if (!is_null($lstCategorieFilsDev)) {
                foreach ($lstCategorieFilsDev as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech" id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
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
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsMobile)) {
                foreach ($lstCategorieFilsMobile as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech[]" id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>             
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
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsBDD)) {
                foreach ($lstCategorieFilsBDD as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech[]" id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>            
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
            $i = 0;
            /* Sur 4 colonnes */
            if (!is_null($lstCategorieFilsDesign)) {
                foreach ($lstCategorieFilsDesign as &$lstFils) {
                    if ($i == 4) {
                        ?></br><?php
                        $i = 0;
                    }
                    $i++;
                    ?>                  
                    <div style="width:200px;float:left"><input type="checkbox" name="rech[]" id=<?php echo $lstFils[cat_id] ?> /><?php echo $lstFils[cat_libelle] ?></div>
                <?php }
            } ?>         
            </br>
        </div>
    </div>
    </br>
    </br>
    <div>
        <input type="button" onclick="getFormulary('rp1');" value="Valider" />
    </div>
</form>
</br>
<table>

</table>
