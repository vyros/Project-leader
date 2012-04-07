<div id="templatemo_content_wrapper">

    <div id="templatemo_content">

        <div class="content_col_w420 fl">
            <div class="header_02">Félication, votre compte est crée !<br/></div>
            Vous pouvez dès à présent vous connecter avec vos identifiants 

        </div>

        <div class="content_col_w420 fr">
            
            <form method="POST" action="verif.php">

                <input type="hidden" name="action" value="VerificationCompte"/>
                <div class="header_02">Acc&egrave;s &agrave; votre compte<br/></div>

                <table align="center">
                    <tr>
                        <td><h6>Login :&nbsp </h6></td>
                        <td><input type='text' name='log' size='25' maxlength='100' value=""/><br><br></td>
                    </tr>

                    <tr>
                        <td><h6>Pass :&nbsp </h6></td>
                        <td><input type='password' name='mdp' size='25' maxlength='100' value=""/><br><br></td>
                    </tr>

                    <br><br>

                    <tr>
                        <td><input type="submit" value="Valider"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>