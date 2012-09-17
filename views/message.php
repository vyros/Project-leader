<?php
if (isset($message['succes']) && $message['succes'])
    $message = $message['succes'];

elseif ((isset($message['erreur']) && $message['erreur']))
    $message = $message['erreur'];
else
    unset($message);

if (!is_null($message)) {
    if ($view == "accueil") {
        ?>
        <span> <?php echo $message; ?> Bonjour <?php echo Site::getUtilisateur()->getLogin(); ?> !</span>
        <?php
    } else if ($view == "liste" || $view == "profil") {
        ?>
        <span> <?php echo $message; ?></span>
        <?php
    }
}
?>
