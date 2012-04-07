<?php
class SITE {
    static public function getUrl() {
        return "http://" . $_SERVER['HTTP_HOST'] . "" . dirname($_SERVER['PHP_SELF']) . "/";
    }
}
?>