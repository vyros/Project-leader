/* ** cartouche ********************************************************************* */
/* Script complet de gestion d'une requête de type XMLHttpRequest                     */
/* Par Sébastien de la Marck (aka Thunderseb)                                         */
/* ********************************************************************************** */

function getXMLHttpRequest() {
    var xhr = null;
	
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest(); 
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
	
    return xhr;
}

function getEntete() {
    
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {
                document.getElementById('entete').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("GET", 'entete.php', true);
    xhr.send(null);
}

function getRequest(controller) {

    var xhr = getXMLHttpRequest();
    var rqt = controller.toString() + ".php";
    
    rqt = rqt + getFormulaire(controller.toString());

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {
                if(controller == 'accueil')
                    getEntete();
                
                document.getElementById('content').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("GET", rqt, true);
    xhr.send(null);
}

function getFormulaire(form) {
    
    var result = "";
    var nodes = document.getElementById(form).elements;
    
    for(i = 0; i < nodes.length; i++) {
        if(nodes[i].name == "")
            continue;
        
        if(i == 0) {
            result = result + "?";
        } else {
            result = result + "&";
        }
        
        result = result + nodes[i].name + "=" 
        + nodes[i].value;
    }
    
    return result;
}