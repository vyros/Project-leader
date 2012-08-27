/* ** cartouche ********************************************************************* */
/* Script complet de gestion d'une requête de type XMLHttpRequest                     */
/*                                                                                    */
/* ********************************************************************************** */

// Write less, do more
function getActivation(params){

    var properties = $.extend(  
    {  
        'id' : '',  
        'token' : ''
    }, params || {} );  
  
    if (properties.id == ''){  
        console.log('Erreur, un identifiant est necessaire !');
    } else if (properties.token == ''){
        console.log('Erreur, un jeton est necessaire !');
    } else {
        
        $.post("utilisateur.php", {
            'action' : 'activer',
            'id' : properties.id,
            'token' : properties.token
        }, function(data) {
            $('#content').html(data);
        })
    }
}

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

function getContenuOnglet(params) {
    
    alert('okk');
    
    var properties = $.extend(  
    {
        'id' : ''
    }, params || {} );
    
    $.post("utilisateur.php", {
        'action' : 'onglet',
        'contenu' : "cours",
        'id' : properties.id
    }, function(data) {
        $('#contenuOnglet').html(data);
    })

/*
    var properties = $.extend(  
    {  
        'controller' : 'utilisateur',  
        'action' : 'onglet',
        'contenu' : '',
        'id' : ''
    }, params || {} );
    
    properties.contenu = $('#ongletsProfil .active').val().toString();
    
    //    $('#ongletsProfil').children().each(function(){
    //        if($(this).attr('class') == 'active') {
    //            properties.contenu = $(this).attr('name');
    //        }
    //    });
    
    $.post(properties.controller.toString() + ".php", {
        'action' : properties.action,
        'contenu' : properties.contenu,
        'id' : properties.id
    }, function(data) {
        $('#contenuOnglet').html(data);
    })
    */
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
            eval('objJSon.'+$(this).attr('name')+' = getField({\'form\' : \''+form+'\', \'name\' : \''+$(this).attr('name')+'\'})');
        }
    });

    return objJSon;
}

function getHeader() {
    $.post('entete.php', function(data){
        $('#entete').html(data);
    })
}

function getFormulary(form) {
    var controller = getControllerFile(form);
     
    $.post(controller, getData(form), function(data){
        $('#content').html(data);
    });
}

// Private
function getField(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = '';
    var name;
    var result;
    
    if (properties.form != ''){  
        form = '#'+properties.form+" ";
    }
    
    if (properties.name == ''){  
        console.log('Erreur, un nom de champs est necessaire !');
    } else {
        name = properties.name;
    }
    
    if($(form+"*[name="+name+"]").length) {
        switch($(form+"*[name="+name+"]").get(0).tagName) {
            case "SELECT" :
                result = getSelect({
                    'form' : form, 
                    'name' : name
                });
                break;
                
            case "INPUT" :
                if($(form+"*[name="+name+"]").attr("type") == 'radio' ) {
                    result = getRadio({
                        'form' : form, 
                        'name' : name
                    }) ;
                }

                if($(form+"*[name="+name+"]").attr("type") == 'checkbox' && 
                    $(form+"*[name="+name+"]").length > 1) {
                    result = getCheckBox({
                        'form' : form, 
                        'name' : name
                    });	
                }
				
                if($(form+"*[name="+name+"]").attr("type") == 'checkbox' && 
                    $(form+"*[name="+name+"]").length == 1) {
                    result = getRadio({
                        'form' : form, 
                        'name' : name
                    }) ;
                    if(typeof(result) == 'undefined')
                        result = 0;
                }
				
                if($(form+"*[name="+name+"]").attr("type") == 'text'  
                    || $(form+"*[name="+name+"]").attr("type") == 'password'
                    || $(form+"*[name="+name+"]").attr("type") == 'hidden') {
                    result = getTextBox({
                        'form' : form, 
                        'name' : name
                    });	
                }
				
                break;
                
            case "TEXTAREA" :
                result = getTextArea({
                    'form' : form, 
                    'name' : name
                });
                break;
                
            default :
                alert ('ERREUR -> balise non reconnu :' + $(form+"*[name="+name+"]").get(0).tagName);
                break;
        }
        
        if(typeof(result) != 'undefined')
            return result;
        else
            return '';
    } else {
        var msg = 'ERREUR -> champs : '+ name +' non trouvé ';
        if(form.length)
            msg += 'dans le form : '+ form +' ';
        
        alert(msg+'!');
    }
}

function getSelect(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = properties.form;
    var name = properties.name;
    
    return($(form+"select[name="+name+"] option:selected").val());
}

function getTextBox(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = properties.form;
    var name = properties.name;
    
    return($(form+"input[name="+name+"]").val());
}

function getTextArea(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = properties.form;
    var name = properties.name;
    
    return($(form+"textarea[name="+name+"]").val());
}

function getRadio(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = properties.form;
    var name = properties.name;
    
    return($(form+"input[name="+name+"]:checked").val());
}

function getCheckBox(params) {
    
    var properties = $.extend(  
    {  
        'form' : '',  
        'name' : ''
    }, params || {} );
    
    var form = properties.form;
    var name = properties.name;
    
    var i = 0;
    var tmp = '{';
    
    $(form+"input:checked[name="+name+"]").each(function(){
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
