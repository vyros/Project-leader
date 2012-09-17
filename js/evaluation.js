/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    var srcIn='images/star_in.gif'; //image au survol
    var srcOut='images/star_out.gif'; // image non survolée

    // Obtenir id numérique des étoiles au format star_numero
    function idNum(id)
    {
        var id=id.split('_');
        var id=id[1];
        return id;
    }

    // Survol des étoiles
    $('.star').hover(function(){
        var id=idNum($(this).attr('id')); // id numérique de l'étoile survolée
        var nbStars=$('.star').length; // Nombre d'étoiles de la classe .star
        var i; // Variable d'incrémentation
        
        for (i=1;i<=nbStars;i++)
        {
            if(i<=id) $('#star_'+i).attr({
                src:srcIn
            });	
            else if(i>id) $('#star_'+i).attr({
                src:srcOut
            });
            if(i==id)$('#noteE').attr({
                value:i
            }); // affectation de la note au formulaire
        }
    },function(){});

    // Survol de la croix
    $('#clear_stars').hover(function(){
        $('.star').attr({
            src:srcOut
        });
        $('#noteE').attr({
            value:'0'
        });
    },function(){});
 
    try
    {
        $('#evaluation #note').load('views/etoiles.php');
 
        $('#evaluation #Noter').click(function(){
            $('#note').load('views/etoiles.php');
        })
    }
    catch(e)
    {
        window.alert(e);
    }
 
});

