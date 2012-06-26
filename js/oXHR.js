/* ** cartouche ********************************************************************* */
/* Script complet de gestion d'une requête de type XMLHttpRequest                     */
/*                                                                                    */
/* ********************************************************************************** */

// Write less, do more
function getController(params){
    
    var properties = $.extend(  
    {  
        'controller' : '',  
        'action' : '' 
    }, params || {} );  
  
    if (properties.controller == ''){  
        console.log('Erreur, un contrôleur est necessaire !');
    } else {
        if(properties.action != ''){
            $.post(properties.controller.toString() + ".php", {
                'action' : properties.action
            }, function(data) {
                $('#content').html(data);
            })
        } else {
            $.post(properties.controller.toString() + ".php", function(data) {
                $('#content').html(data);
            })
        }
    }
}

function getView(params){
    
    var properties = $.extend(  
    {  
        'controller' : '',  
        'view' : '',
        'id' : ''
    }, params || {} );  
  
    if (properties.controller == ''){  
        console.log('Erreur, un contrôleur est necessaire !');
        
    } else {
        if(properties.view == ''){
            console.log('Erreur, une vue est necessaire !');
            
        } else if(properties.id == '') {
            $.post(properties.controller.toString() + ".php", {
                'view' : properties.view
            }, function(data) {
                $('#content').html(data);
            })

        } else {
            $.post(properties.controller.toString() + ".php", {
                'view' : properties.view,
                'id' : properties.id
            }, function(data) {
                $('#content').html(data);
            })
        }
    }
}

// Private
function getControllerFile(form) {
    return $('#'+form+' input[name=controller]').val() + '.php';
}

// Private
function getData(form) {
    var objJSon = {};

    $('#'+form+' input, #'+form+' select, #'+form+' textarea').each(function(){
        if($(this).attr('name') && $(this).attr('name') != 'controller') {
            eval('objJSon.'+$(this).attr('name')+' = getField("'+$(this).attr('name')+'")');
   
        }
    });

    return objJSon;
}

function getHeader() {
    
    //     $(document).ready(function($){
    //         $.post('entete.php', function(data){
    //             document.getElementById('entete').html(data);
    //         })
    //    });
    
    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            jQuery(document).ready(function($) {
                document.getElementById('entete').innerHTML = xhr.responseText;
            });
        }
    };

    xhr.open("POST", 'entete.php', true);
    xhr.send(null);
}

function getFormulary(form) {
    var ctr = getControllerFile(form.toString());
     
    $.post(ctr, getData(form), function(data){
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

// Private
function getField(name) {
    var result;
    
    if($("*[name="+name+"]").length) {
        switch($("*[name="+name+"]").get(0).tagName) {
            case "SELECT" :
                result = getSelect(name);
                break;
                
            case "INPUT" :
                if($("*[name="+name+"]").attr("type") == 'radio' ) {
                    result = getRadio(name) ;
                }

                if($("*[name="+name+"]").attr("type") == 'checkbox' && $("*[name="+name+"]").length > 1) {
                    result = getCheckBox(name);	
                }
				
                if($("*[name="+name+"]").attr("type") == 'checkbox' && $("*[name="+name+"]").length == 1) {
                    result = getRadio(name) ;
                    if(typeof(result) == 'undefined')
                        result = 0;
                }
				
                if($("*[name="+name+"]").attr("type") == 'text'  
                    || $("*[name="+name+"]").attr("type") == 'password'
                    || $("*[name="+name+"]").attr("type") == 'hidden') {
                    result = getTextBox(name);	
                }
				
                break;
                
            case "TEXTAREA" :
                result = getTextArea(name);
                break;
                
            default :
                alert ('ERREUR -> balise non reconnu :' + $("*[name="+name+"]").get(0).tagName);
                break;
        }
        
        if(typeof(result) != 'undefined')
            return result;
        else
            return '';
    } else {
        alert('ERREUR -> champs : '+ name +' non trouvé');
    }
}

function getSelect(name) {
    return($("select[name="+name+"] option:selected").val());
}

function getTextBox(name) {
    return($("input[name="+name+"]").val());
}

function getTextArea(name) {
    return($("textarea[name="+name+"]").val());
}

function getRadio(name) {
    return($("input[name="+name+"]:checked").val());
}

function getCheckBox(name) {
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