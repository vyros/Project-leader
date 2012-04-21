<?php
if(isset($_POST[succes])) {
    $message = $_POST[succes];
} elseif(isset($_POST[erreur])) {
    $message = $_POST[erreur];
}
?>
<div class="content_col_w420 fl">
    <div class="header_02"><?php echo $message; ?></div>
</div><!-- end of a section -->