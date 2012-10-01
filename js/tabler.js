/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var varTable;

$(document).ready(function() {
    /* Add a click handler to the rows - this could be used as a callback */
    $("#example tbody").click(function(event) {
        $(varTable.fnSettings().aoData).each(function () {
            $(this.nTr).removeClass('row_selected');
        });
        $(event.target.parentNode).addClass('row_selected');
    });
         
    /* Add a click handler for the delete row */
    $('#delete').click( function() {
        var anSelected = fnGetSelected( varTable );
        varTable.fnDeleteRow( anSelected[0] );
    } );
         
    /* Init the table */
    varTable = $('#example').dataTable({
        "oLanguage": {
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        }
    });

    //
    // Début tableauAccueilPorteur
    //
    varAccueilPorteur = $('#tableauAccueilPorteur').dataTable( {
        "oLanguage": {
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false, 
            "aTargets": [ 5 ]
        }
        ] 
    });
    $('#tableauAccueilPorteur tbody tr').live( 'mouseover', function () {                 
        var nTr = $(this)[0];              
        varAccueilPorteur.fnOpen( nTr, fnGetAccueilPorteur(nTr), 'details' );   
    });
    $('#tableauAccueilPorteur tbody tr').live( 'mouseout', function () {         
        var nTr = $(this)[0];
        varAccueilPorteur.fnClose( nTr );
    });
    function fnGetAccueilPorteur ( nTr )
    {
        var aData = varAccueilPorteur.fnGetData( nTr );
        var sOut = '<table cellpadding="6" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Présentation : </td><td>'+aData[5]+'</td></tr>';
        sOut += '</table>';
     
        return sOut;
    }
    // Fin tableauAccueilPorteur

    //
    // Début tableauAccueilPrestataire
    //
    varAccueilPrestataire = $('#tableauAccueilPrestataire').dataTable( {
        "oLanguage": {
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false, 
            "aTargets": [ 4 ]
        }
        ] 
    });
    $('#tableauAccueilPrestataire tbody tr').live( 'mouseover', function () {                 
        var nTr = $(this)[0];              
        varAccueilPrestataire.fnOpen( nTr, fnGetAccueilPrestataire(nTr), 'details' );   
    });
    $('#tableauAccueilPrestataire tbody tr').live( 'mouseout', function () {         
        var nTr = $(this)[0];
        varAccueilPrestataire.fnClose( nTr );
    });
    function fnGetAccueilPrestataire ( nTr )
    {
        var aData = varAccueilPrestataire.fnGetData( nTr );
        var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Description : </td><td>'+aData[4]+'</td></tr>';
        sOut += '</table>';
     
        return sOut;
    }
    // Fin tableauAccueilPrestataire

    //
    // Début tableauFichePorteur
    //
    varFichePorteur = $('#tableauFichePorteur').dataTable( {
        "oLanguage": {
            "bRetrieve":        true,
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false, 
            "aTargets": [ 1 ]
        }
        ] 
    });
    $('#tableauFichePorteur tbody tr').live( 'mouseover', function () {                 
        var nTr = $(this)[0];              
        varFichePorteur.fnOpen( nTr, fnGetFichePorteur(nTr), 'details' );   
    });
    $('#tableauFichePorteur tbody tr').live( 'mouseout', function () {         
        var nTr = $(this)[0];
        varFichePorteur.fnClose( nTr );
    });
    function fnGetFichePorteur ( nTr )
    {
        var aData = varFichePorteur.fnGetData( nTr );
        var sOut = '<table cellpadding="2" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Qualité : </td><td>'+aData[1]+'</td></tr>';
        sOut += '</table>';
     
        return sOut;
    }
    // Fin tableauFichePorteur

    //
    // Début tableauFichePrestataire
    //
    varFichePrestataire = $('#tableauFichePrestataire').dataTable( {
        "oLanguage": {
            "bRetrieve":        true,
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false
        }
        ] 
    });
    $('#tableauFichePrestataire tbody tr').live( 'mouseover', function () {                 
        var nTr = $(this)[0];              
        varFichePrestataire.fnOpen( nTr, fnGetFichePrestataire(nTr), 'details' );   
    });
    $('#tableauFichePrestataire tbody tr').live( 'mouseout', function () {         
        var nTr = $(this)[0];
        varFichePrestataire.fnClose( nTr );
    });
    function fnGetFichePrestataire ( nTr )
    {
        var aData = varFichePrestataire.fnGetData( nTr );
        var sOut = '<table cellpadding="2" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td>Qualité : </td><td>'+aData[0]+'</td></tr>';
        sOut += '</table>';
     
        return sOut;
    }
    // Fin tableauFichePrestataire
 
    //
    // Début tableauMessagerieLu
    //
    varMessagerieLu = $('#tableauMessagerieLu').dataTable( {
        "oLanguage": {
            "bRetrieve":        true,
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false
        }
        ] 
    });
    // Fin tableauMessagerieLu
 
    //
    // Début tableauMessagerieNonLu
    //
    varMessagerieNonLu = $('#tableauMessagerieNonLu').dataTable( {
        "oLanguage": {
            "bRetrieve":        true,
            "sProcessing":     "Traitement en cours...",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sSearch":         "Rechercher&nbsp;:",
            "sLoadingRecords": "Téléchargement...",
            "sUrl":            "",
            "oPaginate": {
                "sFirst":    "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext":     "Suivant",
                "sLast":     "Dernier"
            }
        },
        "aoColumnDefs": 
        [
        {
            "bSearchable": false, 
            "bVisible": false
        }
        ] 
    });
    // Fin tableauMessagerieNonLu         
});

function fnGetSelected( oTableLocal ) {
    var aReturn = new Array();
    var aTrs = oTableLocal.fnGetNodes();
         
    for ( var i=0 ; i<aTrs.length ; i++ )
    {
        if ( $(aTrs[i]).hasClass('row_selected') )
        {
            aReturn.push( aTrs[i] );
        }
    }
    return aReturn;
}