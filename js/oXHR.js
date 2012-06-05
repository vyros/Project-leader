/* ** cartouche ********************************************************************* */
/* Script complet de gestion d'une requête de type XMLHttpRequest                     */
/*                                                                                    */
/* ********************************************************************************** */

// Write less, do more
function getController(controller){
    $.get(controller.toString() + ".php",function(data){
        $('#content').html(data);
    })
}

function getControllerAction(controller, action){
    $.get(controller.toString() + ".php", {
        'action' : action
    }, function(data){
        $('#content').html(data);
    })
}

function getControllerView(controller, view){
    $.get(controller.toString() + ".php", {
        'view' : view
    }, function(data){
        $('#content').html(data);
    })
}

function getControllerView(controller, view, item){
    $.get(controller.toString() + ".php", {
        'view' : view, 
        'id' : item
    }, function(data){
        $('#content').html(data);
    })
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
    return $('#'+form+' input[name=controller]').val() + '.php';
}

function getData(form) {
    var objJSon = {};

    $('#'+form+' input, #'+form+' select, #'+form+' textarea').each(function(){
        if($(this).attr('name') && $(this).attr('name') != 'controller') {
            eval('objJSon.'+$(this).attr('name')+' = recuperesChamps("'+$(this).attr('name')+'")');
   
        }
    });

    return objJSon;
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
    var ctr = getControllerFile(form.toString());
     
    $.post(ctr, getData(form), function(data){
        if(ctr.toString() == 'accueil.php')                   
            getEntete();
   
        $('#content').html(data);
    });
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

function recuperesChamps(name){
    var resultat;
    
    if($("*[name="+name+"]").length){
        switch($("*[name="+name+"]").get(0).tagName){
            case "SELECT" :
                resultat = recuperesSelect(name);
                break;
                
            case "INPUT" :
                if($("*[name="+name+"]").attr("type") == 'radio' ) {
                    resultat = recuperesRadio(name) ;
                }

                if($("*[name="+name+"]").attr("type") == 'checkbox' && $("*[name="+name+"]").length > 1) {
                    resultat = recuperesCheckBox(name);	
                }
				
                if($("*[name="+name+"]").attr("type") == 'checkbox' && $("*[name="+name+"]").length == 1) {
                    resultat = recuperesRadio(name) ;
                    if(typeof(resultat) == 'undefined')
                        resultat = 0;
                }
				
                if($("*[name="+name+"]").attr("type") == 'text'  
                    || $("*[name="+name+"]").attr("type") == 'password'
                    || $("*[name="+name+"]").attr("type") == 'hidden') {
                    resultat = recuperesTextBox(name);	
                }
				
                break;
                
            case "TEXTAREA" :
                resultat = recuperesTextArea(name);
                break;
                
            default :
                alert ('ERREUR -> balise non reconnu :' + $("*[name="+name+"]").get(0).tagName);
                break;
        }
        if(typeof(resultat) != 'undefined')
            return resultat;
        else
            return '';
    } else {
        alert('ERREUR -> champs : '+ name +' non trouvé');
    }
}

function recuperesSelect(name){
    return($("select[name="+name+"] option:selected").val());
}

function recuperesTextBox(name){
    return($("input[name="+name+"]").val());
}

function recuperesTextArea(name){
    return($("textarea[name="+name+"]").val());
}

function recuperesRadio(name){
    return($("input[name="+name+"]:checked").val());
}

function recuperesCheckBox(name){
    var i = 0;
    var tmp = '{';
    
    $("input:checked[name="+name+"]").each(function(){
        tmp += " "+i+": '"+$(this).val()+"',"
        i++;
    });
    
    if(tmp.length > 1)
        tmp = tmp.slice(0, -1);
    tmp += "}";
    
    var objetJson = eval('(' + tmp + ')');
    
    if(i == 0) {
        return '';
    }
    return objetJson;
}