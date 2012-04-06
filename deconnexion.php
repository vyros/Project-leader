<?php 
session_start();

		session_destroy();
							
		echo ("<script language = \"JavaScript\">alert('Vous êtes déconnecté');"); 
		echo ("location.href = 'http://localhost/project_leader/';"); 
		echo ("</script>");

?>