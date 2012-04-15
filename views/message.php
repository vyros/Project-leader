<?php
if(isset($message[succes])) {
    $message = $message[succes];
} elseif(isset($message[erreur])) {
    $message = $message[erreur];
}
?>
<div class="content_col_w420 fl">
    <div class="header_02"><?php echo $message; ?></div>
</div><!-- end of a section -->