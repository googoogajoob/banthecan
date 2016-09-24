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


function getBootstrapEnvironment() {
    var envs = ['xs', 'sm', 'md', 'lg'];

    var $el = $('<div>');
    $el.appendTo($('body'));

    for (var i = envs.length - 1; i >= 0; i--) {
        var env = envs[i];

        $el.addClass('hidden-'+env);
        if ($el.is(':hidden')) {
            $el.remove();
            return env;
        }
    }
}

function dynamicSortableDisable(event, ui, sthis) {
    environment = getBootstrapEnvironment();

    if (environment != 'lg') {
        $(sthis).sortable("disable");
        $('.ui-sortable-handle').removeClass('ui-sortable-handle');
    }
}