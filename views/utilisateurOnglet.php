<?php
if (!is_null($lstObjets)) {
    ?>
    <ul>
        <?php
        foreach ($lstObjets as $obj) {
            ?>
            <li><a onclick="getView({'controller' : 'projet', 'view' : 'liste', 'id' : '<?php echo $obj->getId(); ?>'});"><?php echo $obj; ?></a></li><br />
            <?php
        }
        ?>
    </ul>
    <?php
}
?>