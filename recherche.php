<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();
?>
<form>
    <div>
        <div style="color:red">
            Développement Web / Software
        </div>
        <div style="height:250px">
            <?php
            $array = Categorie::getListCategoriesFilsByCode(1); 
            $i = 0; 
            /* Sur 4 colonnes */
            foreach ($array as &$value) {  
               if ($i == 4)
               {
                   ?></br><?php
                   $i = 0;
               }
               $i++; ?>                  
               <input style="" type="checkbox" name=<?php echo $value[cat_libelle] ?> value=<?php echo $value[cat_libelle] ?> /><?php echo $value[cat_libelle] ?>
               <?php }               
            ?>
        </div>
    </div>

    <div>
        <div style="color:red">
            Mobile
        </div>
       <div style="height:250px">
            <?php
            $array = Categorie::getListCategoriesFilsByCode(2);
             foreach ($array as &$value) { ?>
                <input type="checkbox" name=<?php echo $value[cat_libelle] ?> value=<?php echo $value[cat_libelle] ?> /><?php echo $value[cat_libelle] ?><br />
                </br> <?php
            }
            ?>
        </div>
    </div>

    <div>
        <div style="color:red">
            Base de données
        </div>
        <div style="height:250px">
            <?php
            $array = Categorie::getListCategoriesFilsByCode(3);
             foreach ($array as &$value) { ?>
                <input type="checkbox" name=<?php echo $value[cat_libelle] ?> value=<?php echo $value[cat_libelle] ?> /><?php echo $value[cat_libelle] ?><br />
                </br> <?php
            }
            ?>
        </div>
    </div>

    <div>
        <div style="color:red">
            Design
        </div>
        <div style="height:250px">
            <?php
            $array = Categorie::getListCategoriesFilsByCode(4);
             foreach ($array as &$value) { ?>
                <input type="checkbox" name=<?php echo $value[cat_libelle] ?> value=<?php echo $value[cat_libelle] ?> /><?php echo $value[cat_libelle] ?><br />
                </br> <?php
            }
            ?>
        </div>
    </div>
</form>