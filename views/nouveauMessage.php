<?php
/*
 * Vue d'un nouveau message.
 * 
 * @author nicolas.gard
 */
?>
<div class="content_col_w420 fl">

    <div class="sub_content_col">

        <div class="header_wrapper">
            <img src="images/icone_msg.png"/> 
            <div class="header_02">Nouveau Message</div>
        </div>

        <form method="post">

            <input type="hidden" name="action" value="message"/><!--
                <input type="hidden" name="controller" value="projet"/>-->
            <input value="<?php echo $idUti = $_GET["idUti"]; ?>" type="hidden" name="idUti" />

            <?php
            if (is_null($idUti)) {
                ?>
                <input type="text" id="demo-input-local" name="blah" /><br /><br />
                <?php
            } else {
                ?>
                <input type="text" id="demo-input-pre-populated" name="blah" /><br /><br />
                <?php
            }
            ?>

            <script type="text/javascript">
                $(document).ready(function() {
<?php
if (is_null($idUti)) {
    ?>
                                $("#demo-input-local").tokenInput([
    <?php
    if (!is_null($listToutLesUtis)) {
        foreach ($listToutLesUtis as $value) {
            $objUtilisateur = new Utilisateur($value);
            ?>
                                                            {
                                                                id: <?php echo str_replace('"', '', json_encode($objUtilisateur->getId())); ?>, 
                                                                name: "<?php echo str_replace('"', '', json_encode($objUtilisateur->getLogin())); ?>"
                                                            },   
            <?php
        }
    }
    ?>
                                    ]);
    <?php
} else {
    ?>
                                $("#demo-input-pre-populated").tokenInput( {
                                    prePopulate: [
    <?php
    $objUtilisateur = new Utilisateur($idUti);
    ?>
                                                {
                                                    id: <?php echo str_replace('"', '', json_encode($objUtilisateur->getId())); ?>, 
                                                    name: "<?php echo str_replace('"', '', json_encode($objUtilisateur->getLogin())); ?>"
                                                },        
                                            ]
                                        });
                        
    <?php
}
?>
            
            
                        });
            </script>


            Titre de votre message :<input id="titre" accesskey="l" type='text' name='log' size='18' maxlength='100' value="" /> 
            Contenu du message :<textarea name="message" id="message"></textarea><br />

            <input type="submit" class="envoyerMsg" value=" Envoyer " />
<!--                    <input type="button" onclick="getFormulary('pf2');" value="Submit Comment" />-->

        </form>

    </div>
</div>