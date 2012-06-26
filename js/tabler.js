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
    varTable = $('#example').dataTable({"oLanguage": {
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
                                                }}});
} );

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