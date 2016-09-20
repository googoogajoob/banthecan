/**
 * Created by and on 2/22/15.
 */

function columnTicketOrder(event, ui, rthis) {

    var columnId = rthis.id.split("_");
    var ticketOrder =  $(rthis).sortable("toArray");

    for (i = 0; i < ticketOrder.length; i++) {
        ticketOrder[i] = ticketOrder[i].split("_")[1];
    }

    $.ajax({
        url: "/ticket/reorder",
        type: "post",
        data: {
                'columnId':columnId[1],
                'ticketOrder': ticketOrder
            },
        success: function(returnData){
            if (!$.isNumeric(returnData.ticketId)) {
                $(returnData.ticketId + ' .ticket-single-decorations').html(returnData.decorationHtml);
                //alert("Ticket/Column Update SUCCESS (Ticket Column Change: " + returnData + ")");
            } else {
                //alert("Ticket/Column Update SUCCESS (NO Ticket Column Change)");
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert("Ticket/Column Update Failure:" + textStatus + ':' + errorThrown);
        }
    });
}

function showColumnReceiver(event, ui, rthis) {
    $(rthis).addClass("board-column-receive");
}

function hideColumnReceiver(event, ui, rthis) {
    $(rthis).removeClass("board-column-receive");
}
