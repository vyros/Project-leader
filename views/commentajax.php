<?php

if($_POST)
{
    $idUti = $_POST['idUti'];
    $nomUti = $_POST['nomUti'];
    $idPjt = $_POST['idPjt'];
    // $email=$_POST['email'];
    $libelle = $_POST['comment'];
    // $post_id=$_POST['post_id'];
    
    //pour gravatar
    //$lowercase = strtolower($email);
    //  $image = md5( $lowercase );

    $today = date("Y/m/d"); 

    $requete = "INSERT INTO notification (not_nom, not_libelle, not_nature, not_date, uti_id, projet_id) " .
                "VALUES ('" . $nomUti . "','" . $libelle . "','commentaire','" . $today . "','" . $idUti . "','" . $idPjt . "')";
    
    echo $requete;
//    mysql_query($requete);
}

else { }

?>
<li class="box">
    <img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo $image; ?>" class="com_img">
    <span class="com_titre"><?php echo $titre; ?></span>écrit par<span class="com_name"> <?php echo $nom; ?></span>le <span class="com_date"> <?php echo $date; ?></span> <br />
    <?php echo $libelle; ?>
</li>