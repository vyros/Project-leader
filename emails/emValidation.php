<?php
     //-----------------------------------------------
     //DECLARE LES VARIABLES
     //-----------------------------------------------

     $destinataire="$objUtilisateur->getMail()";
     $email_expediteur='info@project-leader.fr';
     $email_reply='info@project-leader.fr';

     $message_texte='Bonjour,'."\n\n".'Bienvenue sur le site Project-Leader.'."\n\n".'Suivez le lien ci-dessous pour activer votre compte.'
        ."\n\n"."http://localhost/project-leader/index.php?activer&id=$objUtilisateur->getId()&token=$objUtilisateur->getToken()";

     $message_html='<html>
     <head>
     <title>Project-Leader</title>
     </head>
     <body>Bonjour,'."\n\n".'Bienvenue sur le site Project-Leader.'."\n\n".'Suivez le lien ci-dessous pour activer votre compte.'
        ."\n\n"."http://localhost/project-leader/index.php?activer&id=$objUtilisateur->getId()&token=$objUtilisateur->getToken()"."\n\n".'</body></html>';

     //-----------------------------------------------
     //GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML
     //-----------------------------------------------

     $frontiere = '-----=' . md5(uniqid(mt_rand()));

     //-----------------------------------------------
     //HEADERS DU MAIL
     //-----------------------------------------------

     $headers = 'From: <'.$email_expediteur.'>'."\n";
     $headers .= 'Return-Path: <'.$email_reply.'>'."\n";
     $headers .= 'MIME-Version: 1.0'."\n";
     $headers .= 'Content-Type: multipart/alternative; boundary="'.$frontiere.'"';

     //-----------------------------------------------
     //MESSAGE TEXTE
     //-----------------------------------------------
//     $message = 'This is a multi-part message in MIME format.'."\n\n";
//
//     $message .= '--'.$frontiere.'--'."\n";
//     $message .= 'Content-Type: text/plain; charset="utf8"'."\n";
//     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
//     $message .= $message_texte."\n\n";

     //-----------------------------------------------
     //MESSAGE HTML
     //-----------------------------------------------
//     $message .= '--'.$frontiere.'--'."\n";
//     $message .= 'Content-Type: text/html; charset="utf8"'."\n";
//     $message .= 'Content-Transfer-Encoding: 8bit'."\n\n";
     $message = $message_html."\n\n"; // Danger, la concatenation

     $message .= '--'.$frontiere.'--'."\n";
     
     //mail($destinataire,$sujet,$message,$headers);
?>