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
                $('ticketwidget_' + returnData.ticketId).html(returnData.ticketHtml);
                if (showConsoleDebug) {
                    console.log("Ticket/Column Update SUCCESS (Ticket Column Change: " + returnData + ")");
                }
            } else {
                if (showConsoleDebug) {
                    console.log("Ticket/Column Update SUCCESS (NO Ticket Column Change)");
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            if (showConsoleDebug) {
                console.log("Ticket/Column Update Failure:" + textStatus + ':' + errorThrown);
            }
        }
    });
}

function showColumnReceiver(event, ui, rthis) {
    $(rthis).addClass("board-column-receive");
}

function hideColumnReceiver(event, ui, rthis) {
    $(rthis).removeClass("board-column-receive");
}

function columnTicketCount(event, ui, cthis) {
    //console.log('Ticket Counter');
    columnReferenceId = $(cthis).attr('column-reference-id');
    ticketCount = $(cthis).children().length;
    buttonId = '#button-' + columnReferenceId;
    title = $(buttonId).attr('apc-title');

    if (ticketCount > 0) {
        title = title + ' (' + ticketCount + ')';
    }

    $(buttonId).html(title);
}

function dynamicSortableDisable(event, ui, sthis) {
    environment = getBootstrapEnvironment();

    if (environment != 'lg') {
        $(sthis).sortable("disable");
        $('.ui-sortable-handle').removeClass('ui-sortable-handle');
    }
}