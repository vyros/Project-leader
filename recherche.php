<?php
header("Content-Type: text/plain");

include_once("models/classSite.php");
Site::init();
?>
<div>
    <div style="color:red">
        Développement Web / Software
    </div>
    <div>
        <?php
        $array = Categorie::getListCategoriesFilsByCode(1);
        foreach ($array as &$value) {
            echo $value[cat_libelle]; ?> </br> <?php
        }
        ?>
    </div>
</div>

<div>
    <div style="color:red">
        Mobile
    </div>
    <div>
        
    </div>
</div>

<div>
    <div style="color:red">
        Base de données
    </div>
    <div>
        
    </div>
</div>

<div>
    <div style="color:red">
        Design
    </div>
    <div>
        
    </div>
</div>