<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!is_null($lstObjets)) {
    echo '<ul>';
    foreach ($lstObjets as $obj) {
        echo '<li>' . $obj . '</li>';
    }
    echo '</ul>';
}
?>