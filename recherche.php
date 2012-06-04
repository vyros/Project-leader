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
        foreach ($array as &$value) { ?>
            <input type="checkbox" name=<?php $value[cat_libelle] ?> value= <?php $value[cat_libelle] ?> >
            </br> <?php
        }
        ?>
    </div>
</div>

<div>
    <div style="color:red">
        Mobile
    </div>
    <div>
         <?php
        $array = Categorie::getListCategoriesFilsByCode(2);
        foreach ($array as &$value) {
            echo $value[cat_libelle]; ?> </br> <?php
        }
        ?>
    </div>
</div>

<div>
    <div style="color:red">
        Base de données
    </div>
    <div>
         <?php
        $array = Categorie::getListCategoriesFilsByCode(3);
        foreach ($array as &$value) {
            echo $value[cat_libelle]; ?> </br> <?php
        }
        ?>
    </div>
</div>

<div>
    <div style="color:red">
        Design
    </div>
    <div>
         <?php
        $array = Categorie::getListCategoriesFilsByCode(4);
        foreach ($array as &$value) {
            echo $value[cat_libelle]; ?> </br> <?php
        }
        ?>
    </div>
</div>