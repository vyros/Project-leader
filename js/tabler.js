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
    varTable = $('#example').dataTable();
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