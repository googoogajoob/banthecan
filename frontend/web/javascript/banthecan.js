/**
 * Created by and on 2/22/15.
 */

function receiveTicketOrder(event, ui, rthis) {

    var columnId = rthis.id.split("_");
    var ticketOrder =  $(rthis).sortable("toArray");

    for (i = 0; i < ticketOrder.length; i++) {
        ticketOrder[i] = ticketOrder[i].split("_")[1];
    }

    $.ajax({
        url: "ticket/reorder",
        type: "post",
        data: {
                'columnId':columnId[1],
                'ticketOrder': ticketOrder
            },
        /*success: function(){
            //alert("success");
        },*/
        error:function(){
            alert("Ticket/Column Update Failure");
        }
    });
}

function reorderElementsResponse( data ) {
    if (data.FAIL === undefined) // Everything's cool!
    {
        alert( data.resultString + data.itemIndexString );
    }
    else
    {
        alert( "Bad Clams!" );
    }
}