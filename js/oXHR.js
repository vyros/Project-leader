/* ** cartouche ********************************************************************* */
/* Script complet de gestion d'une requête de type XMLHttpRequest                     */
/*                                                                                    */
/* ********************************************************************************** */

function getController(controller) {

    var xhr = getXMLHttpRequest();
    var ctr = controller.toString() + ".php";

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {             
                document.getElementById('content').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("GET", ctr, true);
    xhr.send(null);
}

function getControllerDo(controller, action, value) {

    var xhr = getXMLHttpRequest();
    var rqt = controller.toString() + '.php?' + action.toString() + '=' + value.toString();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {
                document.getElementById('content').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("GET", rqt, true);
    xhr.send(null);
}

function getControllerFile(form) {
    
    var result = "";
    var nodes = document.getElementById(form).elements;
    
    for(i = 0; i < nodes.length; i++) {
        if(nodes[i].name != "controller")
            continue;
        
        result = nodes[i].value + ".php";
    }
    
    return result;
}

function getData(form) {
    
    var result = "";
    var nodes = document.getElementById(form).elements;
    
    for(i = 0; i < nodes.length; i++) {
        if(nodes[i].name == "" || nodes[i].name == "controller")
            continue;
        
        if(i == 1) {
            result = result + "?";
        } else {
            result = result + "&";
        }
        
        result = result + nodes[i].name + "=" 
        + nodes[i].value;
    }
    
    return result;
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

function getFormulaire(form) {

    var xhr = getXMLHttpRequest();
    var ctr = getControllerFile(form.toString());
    var rqt = ctr.toString() + getData(form.toString());
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {
                if(ctr.toString() == 'accueil.php')
                    getEntete();
                
                document.getElementById('content').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("GET", rqt, true);
    xhr.send(null);
}

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