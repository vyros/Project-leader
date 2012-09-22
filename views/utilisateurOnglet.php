<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!is_null($lstObjets)) {
    echo '<ul>';
    foreach ($lstObjets as $obj) {
        echo "<li><a onclick=\"getView({'controller' : 'projet', 'view' : 'liste', 'id' : '" . $obj->getId() . "'});\">" . $obj . "</a></li><br />";
    }
    echo '</ul>';
}
?>