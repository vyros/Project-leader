
<div class="sub_content_col">
    <input type="hidden" value=""  id="noteE"/>
    <input type="hidden" value="1" id="idFormulaire"/>

    <img src="images/star_out.gif" id="star_1" class="star"/>
    <img src="images/star_out.gif" id="star_2" class="star"/>
    <img src="images/star_out.gif" id="star_3" class="star"/>
    <img src="images/star_out.gif" id="star_4" class="star"/>
    <img src="images/star_out.gif" id="star_5" class="star"/>

    <input onclick="setEvaluation({'idProjet' : '<?php echo $idProjet; ?>', 'idUtilisateur' : '<?php echo $idUtilisateur; ?>'});" type="submit" value="Évaluer" class="bouton"/>
    <div id="note"></div>
</div>
